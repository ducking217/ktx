# Phân tích Luồng Nghiệp vụ: Module Đăng ký & Xét duyệt

## App\Services\Admin\DangkyService — Bảng DB liên quan: `toa_nha`, `loai_phong`, `phong`, `giuong`, `dangky`, `users`, `sinhvien`, `hopdong`, `hoadon`

### Điều kiện tiên quyết
- Dữ liệu `toa_nha` và `loai_phong` (với `suc_chua` > 0) phải tồn tại.
- Giường (`giuong`) phải có trạng thái `available`.
- Admin phải có permission `dangky.review`.
- Đối với Sinh viên đăng ký lại: Tài khoản phải không bị khóa và không có vi phạm kỷ luật mức độ "Chặn đăng ký".

### Các bước chi tiết

**Bước 1 — Gửi Đăng ký (Actor: Guest/Sinh viên)**
- **Input (Guest):** `ho_ten`, `email`, `so_dien_thoai`, `ngay_sinh`, `gender`, `toa_nha_id`, `loai_phong_id`, `anh_the`, `anh_cccd`.
- **Input (Sinh viên):** `toa_nha_id`, `loai_phong_id`.
- **Validation:**
    - Guest: Required tất cả các trường thông tin cá nhân. Kiểm tra định dạng email, phone.
    - Sinh viên: Kiểm tra `kiemTraKyluat()` và xem đã có hợp đồng `active` hoặc đơn `pending` chưa.
- **Action:** 
    - INSERT INTO `dangky` (ho_ten, email, toa_nha_id, loai_phong_id, trang_thai, lookup_token, ...)
    - Lưu file ảnh vào storage `private/dangky/`.
- **Side effects:** 
    - Gửi email `DangkyKhachThanhCongMail` cho Guest kèm `lookup_token`.
- **Output:** Mã tra cứu (lookup token) cho Guest hoặc thông báo thành công cho Sinh viên.

**Bước 2 — Duyệt Hồ sơ (Actor: Admin)**
- **Input:** `id` (ID của đơn đăng ký).
- **Validation:** Đơn đăng ký phải tồn tại và có trạng thái `pending`.
- **Action:** UPDATE `dangky` SET `trang_thai` = 'approved_pending_payment'.
- **Side effects:** 
    - Gửi email `PaymentRequestMail` yêu cầu thanh toán (đối với Guest).
- **Output:** Thông báo "Duyệt hồ sơ thành công".

**Bước 3 — Xác nhận Thanh toán & Khởi tạo Cư trú (Actor: Admin)**
- **Input:** `id` (ID của đơn đăng ký).
- **Validation:** Trạng thái đơn phải là `approved_pending_payment`. Phải còn giường trống phù hợp với nguyện vọng.
- **Action:**
    - Tự động tìm giường trống: SELECT * FROM `giuong` WHERE `phong_id` IN (SELECT `id` FROM `phong` WHERE `toa_nha_id` = ... AND `loai_phong_id` = ...) AND `trang_thai` = 'available' LIMIT 1.
    - Nếu là Guest: INSERT INTO `users` (tạo tài khoản sinh viên), INSERT INTO `sinhvien`.
    - INSERT INTO `hopdong` (sinhvien_id, giuong_id, phong_id, ngay_bat_dau, ngay_ket_thuc, gia_thuc_te, trang_thai='active').
    - UPDATE `giuong` SET `trang_thai` = 'occupied'.
    - UPDATE `dangky` SET `trang_thai` = 'completed', `phong_id` = ...
    - Gọi `HoadonService` tạo hóa đơn thế chân (`deposit`) và hóa đơn tháng đầu tiên (`monthly`).
- **Side effects:** 
    - Gửi email `LoginMagicLinkMail` chứa link đăng nhập không cần mật khẩu (72h hiệu lực).
- **Output:** Sinh viên có tài khoản, hợp đồng và phòng ở chính thức.

### Ràng buộc DB quan trọng
- **FOREIGN KEY:** 
    - `dangky.user_id -> users.id` (nullOnDelete)
    - `dangky.toa_nha_id -> toa_nha.id`
    - `dangky.loai_phong_id -> loai_phong.id`
- **UNIQUE INDEX:** `dangky.lookup_token` đảm bảo mã tra cứu không trùng lặp.
- **INDEX:** `dangky_status_created_index` (trang_thai, created_at) tối ưu cho Admin lọc đơn.

### Điểm CHƯA RÕ (Cần clarify)
- **PII Encryption:** Code hiện tại ghi nhận "sẽ triển khai sau" cho việc encrypt `phone` và `id_card`.
- **File Movement:** Method `diChuyenFileDangKySangSinhvien` đang là placeholder, chưa thực sự di chuyển ảnh từ đơn đăng ký sang profile sinh viên.
- **Logic Trả phòng:** `yeuCauTraPhong` tạo đơn `dangky` với `ghi_chu = 'TRA_PHONG'`, nhưng luồng xử lý đơn này ở Admin chưa được tách biệt rõ ràng (đang dùng chung `duyetHoSo`).
