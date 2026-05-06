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
