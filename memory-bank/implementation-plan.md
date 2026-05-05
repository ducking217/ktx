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
