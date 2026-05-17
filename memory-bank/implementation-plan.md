# Implementation Plan - Final Completion (e2e)

## Giai đoạn 1: Đồng bộ hóa Schema v2 & Fix Bugs (Hoàn thành)
- [x] Fix **BangDieuKhienService**: Chuyển đổi từ `chi_tiet` JSON sang các cột explicit.
- [x] Fix **HoadonService**: Sửa lỗi gán nhầm chỉ số điện cho nước trong luồng tạo hóa đơn.
- [x] Sync **Views**: Cập nhật toàn bộ các view Admin và Student để sử dụng đúng tên cột mới (`ten_phong`, `ghi_chu`, `created_at`, v.v.).
- [x] Fix **Dangky Model**: Thêm accessors để giải mã dữ liệu nhạy cảm (`so_dien_thoai`, `cccd`) cho Admin hiển thị.

## Giai đoạn 2: Hoàn thiện Module & Logic Nghiệp vụ (Hoàn thành)
- [x] **Hóa đơn**: Đảm bảo luồng Nhập hàng loạt (Bulk entry) và Ghi chỉ số đơn lẻ hoạt động 100%.
- [x] **Đăng ký**: Verify luồng Guest -> Approved -> Paid -> Student/Contract conversion.
- [x] **Tài khoản**: Đảm bảo Super Admin có thể quản lý nhân sự vận hành an toàn.
- [x] **Báo cáo**: Tối ưu hóa Dashboard và Báo cáo tài chính với Chart.js và Excel export.

## Giai đoạn 3: Đánh bóng UI/UX & Empty States (Hoàn thành)
- [x] Thêm Loader/Spinner cho tất cả các nút submit quan trọng.
- [x] Thiết kế Empty States chuyên nghiệp cho tất cả các bảng dữ liệu trống.
- [x] Đảm bảo Responsive 100% cho các thiết bị di động.

## Giai đoạn 4: Kiểm thử & QA (Hoàn thành)
- [x] Chạy bộ Feature Test cho luồng Sinh viên.
- [x] Manual QA luồng Admin duyệt đăng ký và xuất hóa đơn.
- [x] Verify database constraints (Check constraints, Foreign keys).

---
**Dự án đã đạt trạng thái Sẵn sàng vận hành (Production Ready).**

## 2026-05-16 - Refactor an toàn: HoadonService (không đổi nghiệp vụ)
- [x] Khoanh vùng refactor ở các hàm phụ trợ/bulk-entry (`xuLyHoaDonHangLoat`, `duLieuNhapHangLoat`) để giảm phức tạp nhưng giữ nguyên public API.
- [x] Tách helper methods nội bộ (normalize payload + lấy chỉ số gần nhất) trong cùng file, không tạo file mới.
- [x] Verify bằng PHPUnit: chạy `HoadonServiceFeatureTest` và `HoadonServiceTest` đều pass.

## 2026-05-16 - Refactor an toàn: DangkyService (không đổi nghiệp vụ)
- [x] Refactor `xacNhanThanhToan`: tách helper nội bộ (tìm giường trống, ghi nhận thanh toán cọc, gửi magic link) để giảm phức tạp, không đổi public API.
- [x] Refactor `diChuyenFileDangKySangSinhvien`: chuẩn hoá đường dẫn private disk bằng helper nội bộ để tránh lặp logic.
- [x] Update tests theo schema v2 + route names hiện tại, đảm bảo luồng Guest/Admin/Student trong module Đăng ký pass.
- [x] Verify bằng PHPUnit: `AdminApproveGuestDangkyStatusTest`, `DangkyServiceTest`, `DangKyPhongTest` đều pass.

## 2026-05-16 - Kế hoạch refactor theo GitNexus (Hướng 1 & 2)

### Nguyên tắc an toàn (không phá luồng)
- Mọi thay đổi đều bắt đầu bằng `gitnexus_impact` (upstream) cho symbol mục tiêu; nếu HIGH/CRITICAL thì dừng và khoanh phạm vi lại.
- Không đổi public API (method signatures public, contract interface, route names, payload keys).
- Không tạo file mới trừ khi bắt buộc; ưu tiên tách helper/private methods trong cùng file.
- Mỗi bước refactor phải có verify: `gitnexus_detect_changes()` + chạy test/feature test liên quan.

### Hướng 1: Refactor “điểm nóng” (hotspots) theo graph

#### 1.1 SinhvienService (Shared)
- [x] Preflight: `gitnexus_impact({target: "SinhvienService", direction: "upstream"})`
- [x] Refactor nội bộ (giữ nguyên signatures):
  - [x] Nhóm “Profile update + upload private disk”: tách helper thay file private disk (xóa file cũ + store file mới).
  - [x] Nhóm “Assign/Remove room”: tách helper lấy sinh viên lockForUpdate; giữ nguyên transaction boundary.
  - [ ] Chuẩn hoá message/return payload theo pattern `PhanHoiService` (không đổi keys đang dùng ở controller/view).
- [x] Verify:
  - [x] PHPUnit: `SinhvienServiceTest`, `DangKyPhongTest`
  - [x] Diagnostics: không phát sinh lỗi mới.
  - [x] `gitnexus_detect_changes()` scope unstaged

#### 1.2 BangDieuKhienService (Admin)
- [x] Preflight: `gitnexus_impact({target: "BangDieuKhienService", direction: "upstream"})`
- [x] Refactor nội bộ (giữ nguyên output keys cho view):
  - [x] Tách các đoạn “stats phòng”, “stats tài chính”, “lists” thành private helpers.
  - [x] Giữ nguyên query semantics; chỉ gom nhóm và đặt tên rõ.
- [x] Verify: diagnostics + `gitnexus_detect_changes()` (chưa có test trực tiếp cho dashboard).

#### 1.3 TruyVanPhongService (Core)
- [x] Preflight: `gitnexus_impact({target: "TruyVanPhongService", direction: "upstream"})`
- [x] Refactor nội bộ:
  - [x] Tách helper query builder theo use-case (admin/public/student) để giảm độ phức tạp.
  - [x] Giữ nguyên select columns và eager-load hiện tại để tránh regression performance.
- [x] Verify: diagnostics + `gitnexus_detect_changes()` + chạy regression tests liên quan (`DangKyPhongTest|SinhvienServiceTest`).

### Hướng 2: Audit “cô lập” (no incoming CALLS) một cách đúng ngữ cảnh Laravel

#### 2.1 Lập danh sách ứng viên từ graph
- [ ] Dùng cypher để lấy danh sách function/method có 0 incoming CALLS (lọc theo `app/` và loại trừ `vendor/`), xuất ra top theo thư mục (Helpers/Traits/Enums).

#### 2.2 Phân loại false-positive / true-dead
- [ ] Enums: tìm usage trong Blade (`resources/views/**`) và casts/DB enum; nhiều case gọi `label()` từ UI nên graph không thấy.
- [ ] Traits: dò `use <Trait>` trong codebase; xác định có đang “mang theo” trong service/model không.
- [ ] Helpers: dò static call trong Services/Controllers/Requests; xác định có đang dùng cho security/search không.

#### 2.3 Xử lý theo mức độ rủi ro
- [ ] Nếu “true-dead”: đề xuất xóa hoặc deprecate; trước khi xóa chạy `gitnexus_impact` và `gitnexus_detect_changes` để tránh orphan.
- [ ] Nếu “false-positive nhưng dùng ở runtime”: bổ sung test/coverage (hoặc ghi chú trong plan) để tránh refactor nhầm.

## 2026-05-16 - Clean Code Roadmap (GitNexus-driven, không đổi nghiệp vụ)

### Mục tiêu (định nghĩa “clean” cho dự án này)
- Tên gọi nhất quán theo [STANDARDS.md](file:///d:/laragon/www/hethongquanlyktxv1/STANDARDS.md) (Vietnamese domain classes, English enums).
- Service/Controller/Observer có ranh giới rõ; không “leak” nghiệp vụ vào Blade/Controller.
- Không có symbol “mồ côi” hoặc trùng vai trò (vd: `StudentObserver` vs `SinhvienObserver`) gây side effect khó đoán.
- Hotspots (fan-in/fan-out cao) được làm gọn bằng tách private helpers, giữ nguyên public API.
- Các luồng nghiệp vụ trọng yếu có regression tests tối thiểu để refactor an toàn.

### Nguyên tắc vận hành (cứng)
- Preflight mỗi đợt: `npx gitnexus status` → nếu stale/corrupt: `npx gitnexus analyze --force`.
- Trước mọi chỉnh sửa: `gitnexus_impact({target: "<symbol>", direction: "upstream"})`; HIGH/CRITICAL thì chỉ khoanh vùng, không chạm code.
- Sau mỗi commit refactor: `gitnexus_detect_changes()` để đảm bảo phạm vi đúng dự kiến (không “lây” sang module khác).
- Rename/refactor multi-file: chỉ dùng `gitnexus_rename`/`gitnexus_refactor` (không find-replace).

### “100% Clean Code” = Definition of Done (định nghĩa nội bộ, đo được)
- Không còn lệch chuẩn naming so với [STANDARDS.md](file:///d:/laragon/www/hethongquanlyktxv1/STANDARDS.md): domain classes tiếng Việt, Enum case name tiếng Anh, không còn “magic string” cho role/status trong core flows (chỉ dùng Enum hoặc constants).
- Không còn file rác/artefact được track: cache Blade compiled, script test rời, output tooling, v.v. (chỉ giữ những gì có chủ đích).
- Không còn true-dead code trong `app/**` (xác nhận bằng GitNexus + cross-check runtime Laravel: routes, Blade, events, observers, commands, policies).
- Hotspots chính (fan-in/fan-out cao, cyclomatic cao) được “làm phẳng”:
  - Public API giữ nguyên (route names, request keys, interface signatures).
  - Mỗi method trọng yếu có ranh giới rõ (validate → query → domain action → side effects), side effects không bị trộn trong transaction nếu không cần.
- Quality gates tự động (mục tiêu cuối):
  - `php artisan test` pass (regression tối thiểu cho các process trọng yếu).
  - Pint/format pass (nếu bật).
  - Static analysis pass (Larastan/PHPStan ở mức đã chọn).
  - IDE diagnostics không còn Error (Hint/Info được chấp nhận theo whitelist).

### Chiến lược đạt “100%” (thực tế: tiến dần theo gate)
1) **Ổn định nền tảng đo lường** (để “100%” có ý nghĩa):
   - Bật Pint (PSR-12) + cấu hình tối thiểu.
   - Bật Larastan/PHPStan mức Medium → High theo từng cụm module (không bật một lần cho toàn repo).
   - Chuẩn hóa `.gitignore` cho cache/runtime outputs và dọn artefacts đã lỡ track.
2) **Dọn naming + schema drift có kiểm soát**:
   - Loại magic strings (role/status/type) ở “điểm nóng” trước (Auth/Accounts/Đăng ký/Hóa đơn/Hợp đồng).
   - Đồng bộ Model `$casts` + migration schema để tránh “code đúng nhưng test fail” (SQLite vs MySQL).
3) **Giảm hotspots theo graph** (ưu tiên high fan-in):
   - Tách private helpers theo trách nhiệm; giảm nesting; giảm duplicate query snippets.
   - Chuẩn hóa chỗ đặt side effects (Mail/Notification/Audit logs).
4) **Audit dead code đúng ngữ cảnh Laravel**:
   - Xóa theo cụm nhỏ (1–3 files/commit) sau khi đã khóa bằng tests/diagnostics.
5) **Khóa regression theo process**:
   - Mỗi process trọng yếu có tối thiểu 1 happy path + 1 guardrail test.
   - “Không cần test” chỉ áp dụng cho cleanup thuần (imports/types/format/ignore); còn thay đổi flow/hotspot phải có test.

### Trục 1 — Chuẩn hóa Naming/Structure (theo STANDARDS “Known Issues”)
- [ ] Enum audit:
  - [ ] `gitnexus_query({query: "enum"})` + lọc các enum tên/values không theo chuẩn (English PascalCase + backed value English).
  - [ ] Chuẩn hóa dần theo module (Hợp đồng → Đăng ký → Hóa đơn) để giảm blast radius.
- [ ] Service/Request/Controller còn tiếng Anh:
  - [ ] Dò các class dạng `*Registration*|*Contract*|Approve*Request` để lên danh sách rename.
  - [ ] Với mỗi rename: `gitnexus_impact` → `gitnexus_rename` → chạy test filter theo module.
- [ ] Observer trùng/khó đoán:
  - [ ] Dò `*Observer` theo concept “Student/Sinhvien/Hopdong/Hoadon” để xác định cái nào đang được register (AppServiceProvider/EventServiceProvider).
  - [ ] Nếu phát hiện duplicate active: ưu tiên “1 model → 1 observer” và gom logic về observer canonical.

### Trục 2 — Giảm Hotspots (fan-in/fan-out cao) theo graph
- [ ] Lấy Top hotspots:
  - [ ] `gitnexus://repo/ktx/clusters` để xem khu vực cohesion thấp / coupling cao.
  - [ ] `gitnexus_query({query: "transaction lockForUpdate"})`, `gitnexus_query({query: "pending_confirmation"})`, `gitnexus_query({query: "private-files"})` để tìm luồng nhạy cảm.
- [ ] Với mỗi hotspot:
  - [ ] Chỉ tách private helpers + đặt tên rõ (không đổi signature/keys).
  - [ ] Tách side effects (Notification/Mail/Observer) ra điểm cuối của transaction (nếu hiện có trộn lẫn).
  - [ ] Verify: test module + `gitnexus_detect_changes()`.

### Trục 3 — Audit Dead Code “đúng ngữ cảnh Laravel”
- [ ] Ứng viên dead code:
  - [ ] Cypher: liệt kê methods/functions có 0 incoming CALLS trong `app/**` (loại trừ `vendor/**`).
  - [ ] Cross-check với: Routes, Blade usage, Model casts, events/observers, policies, commands/schedule.
- [ ] Xử lý:
  - [ ] Nếu “true-dead”: ưu tiên xóa theo cụm nhỏ (1-3 files/commit), kèm test/diagnostics.
  - [ ] Nếu “false-positive”: ghi lại lý do runtime (Blade/event/DI) và bổ sung test để khóa hành vi.

### Trục 4 — Regression Tests theo “process” (để refactor không sợ)
- [ ] Chọn 8–12 execution flows quan trọng nhất từ `gitnexus://repo/ktx/processes` (ưu tiên: Đăng ký duyệt + xác nhận thanh toán, Hóa đơn pending_confirmation, Gia hạn hợp đồng, Private files).
- [ ] Mỗi flow: viết/ổn định 1–2 feature tests cover “happy path + 1 guardrail”.
- [ ] Quy ước verify: chạy test theo filter của flow sau mỗi refactor chạm vào cluster đó.

### Giả định (để thực thi không bị lệch)
- Cho phép rename trong phạm vi code (class/enum/method) miễn giữ nguyên public surface: routes, request payload keys, response keys đang dùng ở Blade/JS.
- Ưu tiên “clean để vận hành” hơn “clean để đẹp”: dọn các điểm gây bug/khó bảo trì trước (Accounts/Auth/Đăng ký/Hóa đơn/Hợp đồng).
- Cho phép bổ sung tooling quality gates (Pint + Larastan/PHPStan) theo lộ trình tăng dần.

## 2026-05-05 - Tắt tính năng Đánh giá (Sinh viên)
- [x] Gỡ UI đánh giá khỏi “Phòng của tôi” (nút/CTA/modal).
- [x] Tắt endpoints đánh giá phía Student (GET/POST `/student/danhgia` → redirect về Phòng của tôi).
- [x] Gỡ hiển thị đánh giá phía Admin (chi tiết phòng + chi tiết sinh viên).
- [x] Verify nhanh cú pháp routes và rà soát diagnostics.

## 2026-05-05 - Admin Liên hệ: nhận & phản hồi liên hệ từ Landing
- [x] Đồng bộ filter trang Liên hệ (query param `status`) giữa UI và backend.
- [x] Thêm entry “Liên hệ” ở sidebar + badge số liên hệ chờ xử lý.
- [x] Thêm panel xem chi tiết + form phản hồi (lưu ghi chú hoặc gửi email và đánh dấu đã xử lý).
- [x] Verify nhanh diagnostics (PHP/Blade) và đảm bảo không phát sinh lỗi cú pháp.

## 2026-05-05 - Student Thanh lý: hiển thị thông báo khi Admin từ chối
- [x] Thêm endpoint Admin từ chối “Yêu cầu trả phòng” riêng để không làm mất loại yêu cầu.
- [x] Chuẩn hóa lưu `dangky.ghi_chu` theo prefix `TRA_PHONG|<ly_do>` khi từ chối (giữ nguyên loại).
- [x] Student UI hiển thị trạng thái yêu cầu thanh lý (Chờ duyệt / Từ chối + lý do nếu có) tại màn “Hợp đồng & gia hạn”.
- [x] Admin UI route nút “Từ chối” tự chọn endpoint đúng cho yêu cầu trả phòng.

## 2026-05-05 - Admin Đăng ký: tách Thuê phòng / Trả phòng
- [x] Thêm filter `type` (thue-phong/tra-phong) trong `DangkyService::lietKeDangKyAdmin`.
- [x] UI Admin thêm tab phân luồng và giữ nguyên query khi đổi tab/trạng thái.
- [x] Với tab “Trả phòng”, hiển thị phòng hiện tại từ `sinhvien.current_hopdong`.

## 2026-05-06 - Hóa đơn: Chuẩn hóa status badge/label (Admin/Student)
- [x] Bổ sung `InvoiceStatus::badgeClass()` và `InvoiceStatus::displayLabel()` (hỗ trợ `refund`).
- [x] Thay các `match()` trong Blade (Admin/Student/Profile) sang gọi method trên Enum để tránh lệch copy/màu.
- [x] Verify nhanh diagnostics (PHP/Blade) sau khi refactor.

---

## 2026-05-06 - Admin UI: Kế hoạch làm lần lượt toàn bộ trang (không đổi nghiệp vụ)

### Nguyên tắc không phá luồng
- Chỉ chỉnh Blade/Tailwind/Alpine/components; không đổi Service/Observer/DB.
- Giữ nguyên route name + request payload (name, method, field) để không lệch nghiệp vụ hiện tại.
- Mỗi màn chỉ có 1 primary action; secondary actions đưa về icon/overflow để giảm nhiễu.
- Luôn có states: loading (submit), empty, error (validation), permission (403 UX).

### Inventory trang Admin (theo routes + view hiện có)
- Dashboard: `admin.trangchu` → `resources/views/admin/trangchu.blade.php`
- Tòa nhà:
  - `admin.toanha.index|tao|chitiet|capnhat|xoa` → `resources/views/admin/toanha/index.blade.php`, `resources/views/admin/toanha/form.blade.php`
- Phòng:
  - `admin.phong.index|map|chitiet` → `resources/views/admin/phong/danhsach.blade.php`, `resources/views/admin/phong/map.blade.php`, `resources/views/admin/phong/chitiet.blade.php`
  - Tài sản/Vật tư gắn với “Chi tiết phòng” (form inline) → nằm trong `phong/chitiet`
- Sinh viên:
  - `admin.sinhvien.index|chitiet|chuyenphong|choroiophong|capnhat` → `resources/views/admin/sinhvien/danhsach.blade.php`, `resources/views/admin/sinhvien/chitiet.blade.php`
- Đăng ký cư trú:
  - `admin.dangky.index|duyet|duyethoso|xacnhanthanhtoan|tuchoi|traphong.*` → `resources/views/admin/dangky/danhsach.blade.php`
- Hợp đồng:
  - `admin.hopdong.index|show|store|giahan|thanhly|pdf` → `resources/views/admin/hopdong/danhsach.blade.php`
- Yêu cầu gia hạn:
  - `admin.giahan.index|duyet|tuchoi` → `resources/views/admin/giahan/danhsach.blade.php`
- Hóa đơn:
  - `admin.hoadon.index|tao_thang|nhap_hang_loat|luu_hang_loat|nhacno|xacnhan|pdf` → `resources/views/admin/hoadon/danhsach.blade.php`, `resources/views/admin/hoadon/nhap-hang-loat.blade.php`
- Báo hỏng:
  - `admin.baohong.index|capnhat` → `resources/views/admin/baohong/danhsach.blade.php`
- Bảo trì:
  - `admin.baotri.index|store|capnhat|xoa|hoanthanh|vattu.baotri` → `resources/views/admin/baotri/danhsach.blade.php`
- Kỷ luật:
  - `admin.kyluat.index|store|capnhat|xoa` → `resources/views/admin/kyluat/danhsach.blade.php`
- Thông báo:
  - `admin.thongbao.index|store|capnhat|xoa` → `resources/views/admin/thongbao/danhsach.blade.php`
- Liên hệ:
  - `admin.lienhe.index|capnhattrangthai` → `resources/views/admin/lienhe/danhsach.blade.php`
- Cấu hình:
  - `admin.cauhinh.index|capnhat` → `resources/views/admin/cauhinh/index.blade.php`
- Báo cáo tài chính:
  - `admin.baocao.taichinh|xuat_excel` → `resources/views/admin/baocao/taichinh.blade.php` (export là action, không có view riêng)
- Nhật ký hoạt động:
  - `admin.activity-log` → `resources/views/admin/activity-log.blade.php`
- Quản lý tài khoản:
  - `admin.accounts.index|tao|luu|sua|capnhat|xoa|restore` → `resources/views/admin/accounts/index.blade.php`, `resources/views/admin/accounts/form.blade.php`

### Trang “có dấu hiệu tồn tại nhưng chưa bật/thiếu view”
- Báo cáo nợ/Công nợ: có `Admin\CongnoController@index` trả `view('admin.congno.danhsach')` nhưng hiện chưa có view trong `resources/views/admin/` và route không thấy trong `routes/web.php`. Khi đi đến giai đoạn này sẽ quyết định: bật route theo IA hay loại khỏi scope.

### Thứ tự triển khai (lần lượt, bám luồng nghiệp vụ)
1) Nền tảng UI dùng chung: Admin layout shell, sidebar/navbar, PageHeader/StatusTabs/TableCard, empty-state/toast/modal, chuẩn table/filter (không đổi logic).
2) “Cơ sở vật chất”: Tòa nhà → Phòng (list, map, detail) vì đây là tiền đề cho các flow sau.
3) “Nhân sự cư trú”: Sinh viên (list/detail) để phục vụ tra cứu khi duyệt hồ sơ/hợp đồng.
4) “Onboarding”: Đăng ký cư trú (review + thu tiền + trả phòng) vì đây là flow có tần suất cao, nhiều trạng thái.
5) “Vòng đời ở”: Hợp đồng + Yêu cầu gia hạn (list + inline actions + PDF).
6) “Tài chính”: Hóa đơn (list + tạo tháng + nhập hàng loạt + xác nhận + PDF) theo đúng flow tạo chỉ số.
7) “Sự cố & bảo trì”: Báo hỏng → Bảo trì (tối ưu segment theo trạng thái + update inline).
8) “Kỷ luật”: CRUD nhẹ, ưu tiên tốc độ thao tác + confirm rõ.
9) “Truyền thông & hộp thư”: Thông báo → Liên hệ (giảm nhiễu, giữ 1 hành động chính).
10) “Cấu hình & báo cáo”: Cấu hình → Báo cáo tài chính (kết xuất/biểu đồ) để khóa UI cho nhóm kế toán.
11) “Quản trị hệ thống”: Activity Log → Accounts (nhóm quyền cao, kiểm tra a11y + confirm destructive).
12) “Công nợ” (nếu bật): tạo view + gắn route/middleware phù hợp, giữ nghiệp vụ nhắc nợ theo hiện trạng.

---

## 2026-05-06 - Student UI: Kế hoạch làm lần lượt toàn bộ trang (không đổi nghiệp vụ)

### Nguyên tắc không phá luồng
- Chỉ chỉnh Blade/Tailwind/Alpine/components; không đổi Service/Observer/DB.
- Giữ nguyên route name + request payload (name, method, field) để không lệch nghiệp vụ hiện tại.
- Không tạo route mới. Nếu có view “thừa/legacy”, chỉ ghi chú, không xóa khi chưa được yêu cầu.
- Luôn có states: loading (submit), empty, error (validation), permission (403 UX).

### Inventory trang Student (theo routes + view hiện có)
- Dashboard: `student.trangchu` → `resources/views/student/trangchu.blade.php`
- Layout shell: `student.layouts.chinh` → `resources/views/student/layouts/chinh.blade.php`
- Phòng của tôi: `student.phongcuatoi` → `resources/views/student/phongcuatoi/index.blade.php`
- Hóa đơn:
  - `student.hoadon.index` → `resources/views/student/phongcuatoi/lichSuHoaDon.blade.php`
  - `student.hoadon.chitiet` → `resources/views/student/phongcuatoi/chiTietHoaDon.blade.php`
  - `student.hoadon.yeu_cau_xac_nhan` (POST) → action trong `chiTietHoaDon` hoặc list (không có view riêng)
  - `student.hoadon.confirm_penalty` (POST) → action (không có view riêng)
- Danh sách phòng trống: `student.phong.index` → `resources/views/student/phong/danhsach.blade.php`
- Đăng ký phòng / Trả phòng:
  - `student.dangkyphong` (POST) → action từ `phong/danhsach` (không có view riêng)
  - `student.yeucautraphong` (POST) → action từ `hopdong/index` (không có view riêng)
- Hợp đồng & gia hạn:
  - `student.hopdong.index` → `resources/views/student/hopdong/index.blade.php` (tab hợp đồng + tab gia hạn + trạng thái yêu cầu trả phòng)
  - `student.giahan.store` (POST) → action từ `hopdong/index` (không có view riêng)
- Báo hỏng:
  - `student.danhsachbaohong` (GET) → `resources/views/student/baohong/danhsach.blade.php`
  - `student.thembaohong` (POST) → form trong `baohong/danhsach` (không có view riêng)
- Kỷ luật:
  - `student.kyluat.index` → `resources/views/student/kyluat/index.blade.php`
- Thông báo:
  - `student.thongbao` → `resources/views/student/thongbao/danhsach.blade.php`
  - `student.chitietthongbao` → `resources/views/student/thongbao/chitiet.blade.php`
  - `student.thongbao.markAllRead` (PATCH) → action (không có view riêng)
- Đánh giá: `student.danhgia` → route disabled (GET/POST redirect về `student.phongcuatoi`), không có view.

### View có dấu hiệu legacy/không còn là canonical
- `resources/views/student/hoadon/danhsach.blade.php` tồn tại nhưng route `student.hoadon.index` hiện render `student/phongcuatoi/lichSuHoaDon.blade.php`. Giữ nguyên file, không xóa; chỉ đảm bảo link/route canonical hoạt động.

### Thứ tự triển khai (lần lượt, bám luồng nghiệp vụ)
1) Nền tảng UI dùng chung: Student layout shell (nav, header, spacing), component table-card/empty-state, toast, responsive.
2) Dashboard (student.trangchu): “hub” duy nhất cho shortcut cross-module, giảm phân mảnh điều hướng.
3) Phòng của tôi: thông tin phòng + trạng thái lưu trú + CTA chính (xem hóa đơn / báo hỏng / hợp đồng).
4) Hóa đơn: list + chi tiết + flow “yêu cầu xác nhận” (chuyển khoản) + trạng thái/empty/error.
5) Phòng trống: tìm kiếm/lọc + đăng ký phòng (POST) giữ payload; mô tả rõ điều kiện giới tính và số giường trống.
6) Hợp đồng & gia hạn: tab hợp đồng + tab gia hạn + gửi yêu cầu gia hạn + yêu cầu trả phòng (POST) giữ payload.
7) Báo hỏng: list + tạo mới (upload ảnh) + trạng thái xử lý rõ.
8) Kỷ luật: lịch sử vi phạm (read-only), copy súc tích, tránh gây hoang mang.
9) Thông báo: list + detail + mark-all-read, nhấn mạnh “chưa đọc/đã đọc”.
10) Polish cuối: consistency CTA/spacing/typography, a11y (focus/aria), remove AI-slop, không nested cards.

### Business quyết định đã chốt
- Thanh toán: sinh viên chủ yếu chuyển khoản; ưu tiên CTA “Tôi đã chuyển khoản” + hướng dẫn đối soát.
- Đăng ký phòng: sinh viên tự chọn phòng, gửi đăng ký, chờ admin duyệt.
- Kỷ luật: cho phép đăng ký phòng khi mức Low; mức khác tuân theo rule chặn hiện tại của service.
- Trả phòng: yêu cầu nhập lý do khi gửi yêu cầu trả phòng.
- Gia hạn: chọn theo gói số tháng (UI tạo ngày kết thúc mới theo gói, vẫn gửi field `ngay_ket_thuc_moi` như backend).
- Báo hỏng: sinh viên được sửa yêu cầu của mình (chỉ khi chưa hoàn thành).
- Thông báo: có phân loại theo `loai_thong_bao` và lọc theo loại.
