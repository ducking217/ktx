# Phân tích Luồng Nghiệp vụ: Các Module Khác (Facility, Student, System)

## 1. Module Cơ sở vật chất (ToaNha, Phong, Giuong)
**Bảng DB liên quan:** `toa_nha`, `loai_phong`, `phong`, `giuong`.

### Luồng chính
- **Thêm Phòng mới:** Admin chọn Tòa nhà và Loại phòng. Hệ thống tự động INSERT `suc_chua` bản ghi vào bảng `giuong` với mã giường `ten_phong-Gi`.
- **Xóa Phòng:** Hệ thống kiểm tra ràng buộc: Không được xóa nếu có giường đang `occupied` hoặc có hợp đồng `active`.
- **Xóa Tòa nhà:** Force delete toàn bộ phòng và giường bên trong (sau khi đã kiểm tra an toàn) để tránh lỗi Foreign Key.

## 2. Module Sinh viên & Kỷ luật (Sinhvien, Kyluat)
**Bảng DB liên quan:** `users`, `sinhvien`, `kyluat`.

### Luồng chính
- **Xếp phòng thủ công:** Admin chọn sinh viên và phòng. Hệ thống tự tìm giường trống đầu tiên, tạo hợp đồng và cập nhật trạng thái giường. Có kiểm tra giới tính (`user.gender` vs `phong.gioi_tinh_han_che`).
- **Ghi nhận Kỷ luật:** Admin nhập tiêu đề, nội dung, mức độ và ngày vi phạm. Dữ liệu này được dùng để chặn sinh viên đăng ký phòng trong tương lai.

## 3. Module Tài sản & Bảo hỏng (Taisan, Baohong)
**Bảng DB liên quan:** `taisan`, `baohong`, `hoadon`.

### Luồng chính
- **Báo hỏng:** Sinh viên gửi mô tả + ảnh. Admin cập nhật trạng thái xử lý.
- **Bồi thường:** Nếu xác định do lỗi sinh viên, Admin nhập phí bồi thường. Khi trạng thái chuyển sang 'Completed', một hóa đơn loại `extra` (phạt) sẽ tự động được tạo cho sinh viên đó.

## 4. Module Hệ thống & Kiểm toán (Cauhinh, Nhatky)
**Bảng DB liên quan:** `cauhinh`, `nhat_ky`.

### Luồng chính
- **Cấu hình:** Lưu trữ các tham số vận hành (giá điện, giá nước, phí dịch vụ, phí thẻ chân). Được Cache để tối ưu hiệu năng.
- **Kiểm toán (Audit Log):** Sử dụng Observers (`HoadonObserver`, `HopdongObserver`, ...) để tự động ghi lại mọi thay đổi dữ liệu vào bảng `nhat_ky`, bao gồm cả IP address của người thực hiện.

---

### Tổng hợp Schema Drift (Vấn đề cần xử lý gấp)

| Module | File | Cột trong Code | Cột trong DB (Migration v2) |
|--------|------|----------------|-----------------------------|
| Hóa đơn | `HoadonObserver.php` | `trangthaithanhtoan` | `trang_thai` |
| Báo hỏng | `BaohongService.php` | `anhminhhoa` | `hinh_anh_path` |
| Báo hỏng | `BaohongService.php` | `trangthai` | `trang_thai` |
| Tài sản | `TaiSanPhongService.php` | `tentaisan`, `soluong`, `tinhtrang` | `ten_tai_san`, `so_luong`, `tinh_trang` |
| Sinh viên | `SinhvienService.php` | `masinhvien` | `ma_sinh_vien` |
| Kỷ luật | `KyluatService.php` | `masinhvien`, `taikhoan` | `ma_sinh_vien`, `user` |

### Điểm CHƯA RÕ (Tổng hợp)
1. **PII Encryption Infrastructure:** Hệ thống chưa có lớp xử lý mã hóa dữ liệu nhạy cảm (Phone, CCCD) như đã định nghĩa trong migration.
2. **Notification Sync:** Cần kiểm tra xem các Events như `GiuongStatusChanged` có thực sự được trigger và xử lý đồng bộ trạng thái phòng/tòa nhà hay không.
3. **Logic Hoàn tiền (HoanTienService):** Cần phân tích sâu hơn cách hệ thống tính toán tiền hoàn lại khi thanh lý hợp đồng trước hạn.
