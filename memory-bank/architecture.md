# Architecture - Laravel KTX V1

## 1) Kiến trúc tổng thể
- Framework: Laravel 11 (MVC + Service Layer + Observer).
- Tổ chức mã nguồn theo module: `Admin`, `Student`, `Guest`, `Shared`, `Core`.
- Luồng chuẩn: Route -> Controller -> Contract -> Service -> Model/Repository -> DB.
- Cross-cutting: Middleware phân quyền, Observer đồng bộ nghiệp vụ, Notification/Mail cho giao tiếp người dùng.
- Liên hệ từ Landing: `TrangChuService::guiLienHe()` tạo `lienhe` + thông báo admin; Admin quản lý tại `/admin/lien-he`, phản hồi qua email và lưu `ghi_chu_admin`.
- Landing không tích hợp chatbot; hỗ trợ người dùng qua form Liên hệ và các kênh hotline/Zalo được hiển thị trên Landing.
- Các trang Landing (danh sách phòng, chi tiết vật tư/tài sản) dùng `x-landing-layout` và token `ink/ui/brand` để giữ trải nghiệm nhất quán.
- Student “Danh sách phòng trống” chỉ tập trung vào luồng đăng ký phòng; phần chi tiết trong UI Student chỉ hiển thị “Tài sản trong phòng” (không dùng “Vật tư”) để giữ luồng gọn và đúng nghiệp vụ báo hỏng theo tài sản.
- Landing hero stats hiển thị realtime từ DB qua `TrangChuService::layDuLieuTrangChu()` (sinh viên/phòng/tòa).
- UI layer: Blade + Tailwind + token màu OKLCH (xem `DESIGN.md` và `resources/css/app.css`), gồm focus-visible ring, reduced-motion và status tokens (success/warning/error/info).
- Sidebar icons (Admin/Student) dùng inline SVG (Heroicons outline style), giữ `stroke="currentColor"` để đồng bộ màu theo token.
- Token `brand-emerald`/`brand-jade` được map từ CSS variables `--brand-emerald-lch`/`--brand-jade-lch` trong `resources/css/app.css` để đảm bảo hover/active state nhất quán.
- Export files (Admin): ưu tiên Excel khi khả dụng, fallback sang CSV để tránh phụ thuộc môi trường (ZipArchive/Excel writer).
- Trang Admin “Liên hệ” dùng `x-admin.page-header` + `x-admin.table-card` và copy tiếng Việt để đồng bộ trải nghiệm Admin (table-first, scannable).
- Quy ước ngôn ngữ UI: ưu tiên tiếng Việt cho toàn bộ nội dung hiển thị; không để chuỗi tiếng Anh ở menu/header/bảng/form/email. Fallback chuẩn dùng “Chưa có/Không xác định” thay cho `N/A`.
- Quy ước nhận diện hóa đơn ở UI: ưu tiên `hoadon.ma_hoa_don` (khớp nội dung chuyển khoản và đối soát), fallback mới dùng `id` format.
- Quy ước Enum ở UI: dùng `->value` cho logic (match/filter) và `->label()` cho nội dung hiển thị để tránh lỗi so sánh Enum vs string.
- Quy ước hiển thị trạng thái hóa đơn: dùng `InvoiceStatus::badgeClass($invoiceType)` và `InvoiceStatus::displayLabel($invoiceType)` để đồng bộ badge/label giữa Admin/Student, đặc biệt với loại hóa đơn `refund`.
- Quy ước UI list: ưu tiên dùng `x-admin.page-header` + `x-admin.table-card` cho các màn danh sách data-rich (kể cả Student) để đồng bộ spacing, typography và empty state.
- Quy ước hiển thị mã hợp đồng: dùng `$hopdong->ma_hd` (accessor trên Model `Hopdong`) để thống nhất format `HD-000001` ở Admin/Student/PDF.
- Quy ước IA module Hóa đơn: ưu tiên tab “Chờ xác nhận” (PendingConfirmation) cho workflow đối soát, sau đó mới xử lý “Công nợ” (Unpaid/Overdue) và “Lịch sử thu” (Paid).
- Workflow đối soát hóa đơn: khi Sinh viên gửi “Tôi đã chuyển khoản” → hóa đơn sang `pending_confirmation`; Admin có thể **Xác nhận** (→ `paid`) hoặc **Từ chối** (→ `unpaid/overdue` theo hạn), và có thể kèm lý do từ chối.
- Thông tin từ chối đối soát được lưu trên bản ghi `thanh_toan.ghi_chu` (pattern “Từ chối: …”) và hiển thị lại cho Sinh viên ở danh sách/chi tiết hóa đơn.
- IA Admin Hóa đơn: tách riêng tab “Hoàn cọc” (refund) để tránh lẫn với luồng thu, vì refund là nghiệp vụ chi trả khi thanh lý.
- IA Student Lưu trú: gộp “Hợp đồng” và “Gia hạn” thành 1 màn hình (canonical `/student/hopdong`), tách theo tab query `tab=hopdong|gia-han` để giảm phân mảnh điều hướng; không duy trì route legacy để tránh nhiều đường cho cùng chức năng.
- IA Student Thông báo: hỗ trợ lọc theo thời gian (`loai=tatca|moi_nhat`) và lọc theo phân loại (`nhom=general|finance|maintenance|discipline|system`) dựa trên `thongbao.loai_thong_bao`.
- IA Admin điều hướng: Dashboard là hub duy nhất cho shortcut cross-module; các trang Admin khác không đặt CTA/link nhảy sang module khác trong nội dung trang (điều hướng qua sidebar hoặc về Dashboard).
- Admin role model: chỉ có 1 cấp Admin toàn quyền (UI hiển thị đầy đủ menu; không thay đổi enforcement ở middleware/policy).
- Công nợ (module riêng): không bật route/view độc lập; công nợ được xử lý trong tab của module Hóa đơn theo hiện trạng.

## 2) Cấu trúc CSDL (từ Migration hiện tại)
### 2.1 Số lượng và phạm vi
- Tổng migration quét: 24 file.
- Tổng bảng tạo qua `Schema::create`: 23 bảng.
- Một migration `create_admin_table_v2` là no-op để tương thích chuỗi migration cũ.

### 2.2 Nhóm bảng chính
- Danh mục cơ sở vật chất: `toa_nha`, `loai_phong`, `phong`, `giuong`, `taisan`, `vattu`, `lich_su_bao_tri`.
- Người dùng và hồ sơ: `users`, `sinhvien`, `cauhinh`, `lienhe`.
- PII/định danh cá nhân theo schema v2 nằm ở `users`: `phone`, `id_card`, `gender`, `dob`, `address` (không nằm ở `sinhvien`).
- PDF hợp đồng/hóa đơn khi cần hiển thị PII phải đọc từ `hopdong.sinhvien.user` để tránh field legacy trống/sai.
- Admin “Chi tiết sinh viên” cũng phải đọc PII từ `sinhvien.user` (không đọc field legacy `ngaysinh/diachi/...`).
- Admin “Chi tiết sinh viên” cho phép hiệu chỉnh hồ sơ (users + sinhvien) qua `SinhvienController::capNhatSinhVien()` và `SinhvienService::updateStudent()`, hỗ trợ upload ảnh thẻ/CCCD lên disk `private` theo đường dẫn `sinhvien/{id}/...`.
- Private file access (ảnh thẻ/CCCD) dùng signed URL qua endpoint `/private-files?path=...` (query param) để tránh lỗi wildcard route param chứa `/`.
- Vận hành lưu trú: `dangky`, `hopdong`, `yeu_cau_gia_han`.
- Tài chính: `chi_so_dien_nuoc`, `hoadon`, `thanh_toan`.
- Truyền thông và phản hồi: `thongbao`, `thongbao_user`, `danhgia`, `baohong`, `kyluat`.
- Kiểm toán: `nhat_ky`.

### 2.3 Quan hệ dữ liệu nổi bật
- `toa_nha` 1-n `phong`; `loai_phong` 1-n `phong`; `phong` 1-n `giuong`.
- `phong` 1-n `taisan`; `phong` 1-n `vattu`.
- `users` 1-1 `sinhvien` (unique `user_id`).
- `sinhvien` + `phong` + `giuong` liên kết tại `hopdong`.
- `hopdong` 1-n `hoadon`; `hoadon` 1-n `thanh_toan`.
- `sinhvien` 1-n `kyluat`, `baohong`, `danhgia`, `yeu_cau_gia_han`.
- `thongbao` n-n `users` qua `thongbao_user`.
- `Hoadon` có accessor `loai_hoadon_label` (UI label 1-1 với `loai_hoadon`) và relation `giao_dich_gan_nhat` để lấy bản ghi `ThanhToan` gần nhất khi cần đối soát trạng thái `pending_confirmation`.

### 2.4 Ràng buộc nghiệp vụ quan trọng ở DB
- Unique active contract bằng cột generated `cot_hieu_luc` trong `hopdong`.
- Check constraints: hợp lệ ngày hợp đồng, rating 1-5, chỉ số điện nước hợp lệ, số tiền thanh toán > 0.
- Index hỗ trợ truy vấn trạng thái/thời gian ở `dangky`, `hoadon`, `baohong`, `thongbao_user`, `nhat_ky`.
- Soft deletes áp dụng rộng để hỗ trợ audit/khôi phục.

Ghi chú: `toa_nha` có thêm metadata `so_phong`, `so_tang` để BQL quản trị quy mô tòa nhà (không đồng nghĩa tự động tạo/xóa phòng).

Ghi chú: Landing đăng ký khách không cho chọn giường. Hệ thống vẫn quản lý sức chứa bằng `giuong` nội bộ và tự động gán giường trống khi Admin xác nhận thanh toán.

## 3) Cấu trúc Controller
### 3.1 Theo khu vực nghiệp vụ
- `Guest`: landing, đăng ký, tra cứu, xem phòng công khai.
- `Student`: dashboard, phòng của tôi, hóa đơn, hợp đồng, gia hạn, báo hỏng, thông báo, kỷ luật.
- `Admin`: vận hành toàn hệ thống (tòa nhà, phòng, sinh viên, đăng ký, hợp đồng, hóa đơn, bảo trì, kỷ luật, cấu hình, tài khoản, báo cáo).
- `Shared/Auth`: profile, file private, xác thực Laravel + magic link.

Ghi chú Student UI: trang “Phòng của tôi” chỉ tập trung thông tin phòng hiện tại; các thao tác/luồng khác được đặt ở đúng module tương ứng (Dashboard là hub ngoại lệ).

### 3.2 Điều phối qua route
- Route prefix tách theo miền: `/admin`, `/student`, public `/`. Prefix legacy `/sinhvien` redirect vĩnh viễn về `/student` để tránh trùng canonical URL.
- Canonical Admin: mỗi module chỉ có 1 entrypoint dưới `/admin/<module-slug>` (ví dụ: `/admin/hoa-don`, `/admin/hop-dong`, `/admin/sinh-vien`); route names dùng dạng `admin.<module>.*`, không duy trì route legacy để tránh trùng chức năng.
- Middleware chính: `auth`, `kiemtravaitro:*`, `can:*`, throttle cho tác vụ guest.

Ghi chú IA Admin: màn “Quản lý Đăng ký Cư trú” tách luồng theo tab `type=thue-phong|tra-phong` để giảm nhiễu khi vận hành.

## 4) Cấu trúc Service + Contract
### 4.1 Service layer hiện hữu
- `App\\Services\\Admin`: `DangkyService`, `HopdongService`, `HoadonService`, `BaoTriService`, `TaiChinhService`, `BaoCaoService`, `AccountService`, `ToaNhaService`, `HoanTienService`, `BangDieuKhienService`.
- `App\\Services\\Student`: `PhongSinhvienService`, `BaohongService`, `DanhgiaService`, `KyluatService`, `TraPhongService`.
- `App\\Services\\Shared`: `NghiepVuPhongService`, `KhoPhongService`, `TaiSanPhongService`, `VatTuPhongService`, `ThongbaoService`, `GiaHanService`, `SinhvienService`.
- `App\\Services\\Core`: `TrangChuService`, `TruyVanPhongService`, `TienIchService`, `KiemToanService`.

## 5) Admin UI - Chi tiết phòng
- Màn chi tiết phòng (Admin) ưu tiên luồng vận hành và audit: nhân khẩu, bảo trì, tài sản.
- Khối “Sơ đồ vị trí giường” có thể được tắt ở UI để giảm nhiễu khi không phục vụ thao tác thường ngày.
- Tài sản phòng có thao tác CRUD tại chỗ qua route `admin.taisan.*` để giảm điều hướng.

## 6) Admin UI - Gán tài sản theo phạm vi & quản lý hàng loạt
- Trang danh sách phòng (Admin) có modal “Thêm tài sản” để gán 1 loại tài sản theo phạm vi:
  - Theo tòa (`admin.taisan.gan_hang_loat`, input `toa_nha_id`)
  - Theo phòng (`admin.taisan.gan_hang_loat`, input `phong_id`)
- Trang danh sách phòng (Admin) có panel “Tài sản (hàng loạt)” theo từng phòng qua query `?taisan_phong_id=<id>` và endpoint `admin.taisan.*_hang_loat`.

## 7) Student UI - Báo hỏng theo tài sản
- Form báo hỏng (Sinh viên) hiển thị danh sách tài sản theo phòng hiện tại và lưu `baohong.taisan_id` (nullable).
- Ràng buộc: khi sinh viên chọn tài sản, hệ thống kiểm tra tài sản phải thuộc đúng `hopdong.phong_id` trước khi tạo báo hỏng.
- Sinh viên được chỉnh sửa báo hỏng của mình khi trạng thái còn `pending/processing` (không cho chỉnh sửa khi đã `done/rejected`).

Ghi chú: `TruyVanPhongService` hỗ trợ truy vấn phòng trống (theo giường), kèm dữ liệu vật tư/tài sản và danh sách phòng “sắp trống” dựa trên `hopdong.ngay_ket_thuc` (mặc định 30 ngày).

### 4.2 Luồng nghiệp vụ quan trọng
#### 4.2.1 Luồng Duyệt Đăng Ký (`DangkyService::duyetDangKy`)
- **Input:** `int $id`, `?string $ngayHetHan`
- **Flow:** 
  1. Validate đăng ký tồn tại và trạng thái = `RegistrationStatus::Pending`
  2. Kiểm tra sinh viên đã có hợp đồng active chưa
  3. Tìm giường trống phù hợp với nguyện vọng (`toa_nha_id` + `loai_phong_id`)
  4. **Branch 1 - Sinh viên có tài khoản:**
     - Chấm dứt hợp đồng cũ (nếu có)
     - Tạo hợp đồng mới với `phong_id`, `giuong_id`, ngày bắt đầu/kết thúc
     - Cập nhật trạng thái giường thành `BedStatus::Occupied`
     - Cập nhật trạng thái đăng ký thành `RegistrationStatus::Approved`
     - Gửi email `DangkyDaDuyetMail`
  5. **Branch 2 - Khách chưa có tài khoản:**
     - Chuyển trạng thái thành `RegistrationStatus::ApprovedPendingPayment`
     - Gửi email `PaymentRequestMail` yêu cầu thanh toán **phí thế chân (phi_the_chan)** trước khi Admin xác nhận và cấp phòng
- **Output:** Array với `toast_loai` và `toast_noidung`
- **Transaction:** Toàn bộ flow trong DB transaction với `lockForUpdate`

#### 4.2.2 Luồng Xác Nhận Thanh Toán & Cấp Phòng (Guest) (`DangkyService::xacNhanThanhToan`)
- **Điều kiện:** `dangky.trang_thai = approved_pending_payment`
- **Hành vi:** tạo `User`/`Sinhvien`/`Hopdong`, gán `Giuong`, tạo **hóa đơn deposit** theo `phi_the_chan` và chuyển sang `paid`, ghi nhận `ThanhToan`

#### 4.2.3 Luồng Yêu Cầu Trả Phòng (Sinh viên)
- Sinh viên gửi “Yêu cầu trả phòng” → hệ thống tạo bản ghi `dangky` với `trang_thai = pending` và `ghi_chu = TRA_PHONG|<ly_do>`.
- Điều kiện chặn: nếu còn hóa đơn chưa thanh toán (`unpaid/overdue`) không phải `refund` thì không cho gửi yêu cầu.
- Admin Dashboard hiển thị block “Yêu cầu trả phòng” và badge ở navbar để nhận biết nhanh.
- Admin không xử lý theo luồng “Duyệt đăng ký” thông thường cho loại `TRA_PHONG` (UI chặn thao tác duyệt).
- Khi Admin **từ chối** yêu cầu trả phòng: lưu `dangky.trang_thai = rejected` và giữ prefix `dangky.ghi_chu = TRA_PHONG|<ly_do>` để vừa phân loại vừa có lý do (nếu có).
- Khi Admin **xử lý** yêu cầu trả phòng: nếu sinh viên có bản ghi `baohong` thuộc diện `nguoi_chiu_phi = sinhvien` (pending/processing/done) thì phải xác nhận `phi_hu_hai` để cấn trừ vào cọc trước khi thanh lý.

#### 4.2.x Luồng Yêu Cầu Đổi Phòng (Sinh viên) — Chưa hỗ trợ
- Sau refactor, hệ thống tạm thời không cung cấp endpoint “đổi phòng” để tránh phát sinh sai lệch tính tiền phòng theo kỳ.
- Nếu cần mở lại, triển khai như một flow riêng (effective date + policy tính phí + đối soát hóa đơn).

#### 4.2.4 Luồng Form Đăng Ký Khách (`DangkyService::layDuLieuFormDangKyKhach`)
- **Input:** `int $phongId`, `?int $giuongNo = null` (Updated signature)
- **Flow:** 
  1. Validate phòng tồn tại với `with(['toanha', 'loaiphong'])`
  2. Nếu có `giuongNo`: kiểm tra giường tồn tại và `trang_thai = Available`
  3. Đếm số giường trống trong phòng
  4. Return phòng info + số giường trống
- **Defensive Programming:** Parameter validation, null-safe bed checking, proper error messages
- **Output:** Array với `success`, `phong`, `giuong_no`, `so_giuong_trong`

#### 4.2.3 Luồng Tạo Hợp Đồng Tự Động
- Khi duyệt đăng ký cho sinh viên có tài khoản
- Tạo `Hopdong` với trạng thái `ContractStatus::Active`
- Gán `phong_id` và `giuong_id` nhất quán
- Cập nhật trạng thái giường và phòng occupancy

### 4.3 DI container bindings
- `AppServiceProvider` bind đầy đủ Contract -> Service cho các module chính.
- Repository được khai báo interface (`PhongRepositoryInterface`, `SinhvienRepositoryInterface`) và implementation tại `App\\Repositories`.

## 5) Observer và tác vụ hệ thống
- Observer đang gắn cho phần lớn model nghiệp vụ: sinh viên, hợp đồng, hóa đơn, phòng, tài sản, vật tư, bảo hỏng, thông báo, yêu cầu gia hạn...
- Command nền hỗ trợ tự động hóa vận hành: kiểm tra hợp đồng hết hạn, hóa đơn quá hạn, dọn thông báo, đồng bộ hợp đồng.

## 5.1) Observability (Runtime)
- Khi lỗi 5xx, response trả về `X-Request-Id` và log có kèm `request_id` + ngữ cảnh (route/user) để truy vết nhanh; có fallback log tại `storage/logs/fallback-exceptions.log` nếu kênh log chính gặp lỗi.

## 6) Defensive Programming Implementation
### 6.1 Service Layer Defensive Patterns
- **Parameter Validation:** Kiểm tra null/invalid trước khi xử lý trong `DangkyController::create()`
- **Null-Safe Operations:** Method signatures với nullable parameters `?int $giuongNo = null`
- **Exception Handling:** Try-catch blocks với error messages thân thiện
- **Interface Contracts:** Đồng bộ interface với implementation signatures
- **Gia hạn hợp đồng:** `GiaHanService::guiYeuCau()` chặn `hopdong.ngay_ket_thuc` null và yêu cầu `ngay_ket_thuc_moi` phải sau ngày kết thúc hiện tại.

### 6.2 Blade Template Defensive Patterns
- **Null-Safe Operators:** Sử dụng `?->label()` thay vì `->label()` cho enum properties
- **Fallback Values:** `?? 'N/A'` cho null enum labels trong `resources/views/landing/phong/danhsach.blade.php`
- **Data Consistency:** Verify database integrity trước khi render UI
- **Enum badge mapping:** Khi render badge theo Enum trong Blade, match theo `->value` (hoặc fallback string) để tránh lỗi so sánh Enum vs string.

### 6.3 Database Integrity
- **Status Column Validation:** Verified không có NULL values trong `phong`, `dangky`, `giuong` tables
- **Migration Strategy:** Không cần migration cho NULL status - dữ liệu đã nhất quán

## 7) Nhận định kiến trúc
- Nền tảng đã đi đúng hướng Domain-driven theo module và tách lớp rõ ràng.
- DB đã có nhiều guard-rail kỹ thuật (FK/index/check/soft delete) giúp giảm rủi ro dữ liệu.
- **Đã áp dụng Defensive Programming:** Service layer và Blade templates được bảo vệ chống null pointer errors.
- Cần tiếp tục chuẩn hóa chuẩn enum/status và mở rộng regression test theo luồng nghiệp vụ trọng yếu.

## 8) UI Layer (Admin) — Design System & Componentization
- Admin shell: Sidebar + Navbar sticky + Breadcrumbs + slot content.
- Admin sidebar hỗ trợ off-canvas trên mobile qua Alpine state `sidebarOpen` trong layout, giữ nguyên cấu trúc nội dung trang.
- Chuẩn hóa tiêu đề trang:
  - Layout tính `pageTitle` từ `$title` (Blade component slot) hoặc `@section('title')`, dùng cho cả HTML title và navbar.
- Component UI (Blade):
  - `x-admin.page-header`: header chuẩn hóa cho list/report pages.
  - `x-admin.status-tabs`: segmented tabs chuẩn hóa cho lọc trạng thái.
 - Quy ước thao tác theo hàng (table actions): ưu tiên icon-buttons compact (h-9 w-9) để bảng không “phình”, còn CTA chính ở header/form vẫn giữ h-11.
 - Quy ước CTA form (submit): dùng `saas-btn-primary` kích thước h-11, mobile ưu tiên full-width để thao tác chắc tay.
 - Quy ước modal: wrapper overlay phải tự set `text-left` để không bị inherit `text-right` từ table cells; các modal toggle bằng `hidden` nên đi kèm `flex` để centering không phụ thuộc JS.
  - `x-admin.table-card`: wrapper table + optional header slot + caption (sr-only).
- Adoption:
  - Các trang CRUD modal + table và các trang dual-view (desktop table + mobile cards) được chuẩn hóa về cùng contract header/table/empty state để giảm trùng lặp.
  - Table headers dùng `scope="col"`, icon-only actions có `aria-label` làm baseline a11y.
- Design tokens:
  - Tokens OKLCH + semantic colors đặt trong CSS variables và map qua Tailwind theme.
  - Typography/spacing tokens chuẩn hoá tại `resources/css/app.css` (font stacks Geist Sans/Quicksand, spacing rhythm 4pt, focus/selection theo brand emerald).
  - Admin views tránh hardcode nền trắng (`bg-white`, `hover:bg-white`, `ring-white`), ưu tiên `bg-ui-card` và `ring-ui-border` để nhất quán tinted-neutral.
