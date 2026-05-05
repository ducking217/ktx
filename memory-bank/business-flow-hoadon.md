# Phân tích Luồng Nghiệp vụ: Module Hóa đơn & Tài chính

## App\Services\Admin\HoadonService — Bảng DB liên quan: `phong`, `hopdong`, `chi_so_dien_nuoc`, `hoadon`, `thanh_toan`, `cauhinh`

### Điều kiện tiên quyết
- Phòng phải có sinh viên đang cư trú (`giuong` status = 'occupied').
- Cấu hình giá điện, giá nước, phí dịch vụ phải tồn tại trong bảng `cauhinh`.
- Admin phải có permission `hoadon.manage`.

### Các bước chi tiết

**Bước 1 — Nhập Chỉ số & Tạo Hóa đơn (Actor: Admin)**
- **Input:** `phong_id`, `thang`, `nam`, `chisodiencu`, `chisodienmoi`, `chisonuoccu`, `chisonuocmoi`.
- **Validation:** 
    - Chỉ số mới phải >= chỉ số cũ. 
    - Phòng phải có ít nhất 1 hợp đồng `active`.
- **Action:**
    - INSERT/UPDATE vào `chi_so_dien_nuoc` (loai='dien') và `chi_so_dien_nuoc` (loai='nuoc').
    - Tính toán: 
        - `tien_dien_tong` = (mới - cũ) * giá cấu hình.
        - `tien_nuoc_tong` = (mới - cũ) * giá cấu hình.
        - `phi_dich_vu_tong` = giá cấu hình.
    - Chia đều: `tien_dien_moi_nguoi` = `tien_dien_tong` / số hợp đồng active. (Tương tự cho nước và phí dịch vụ).
    - Lặp qua từng hợp đồng active:
        - INSERT INTO `hoadon` (hopdong_id, phong_id, ma_hoa_don, loai_hoadon='monthly', tien_phong, tien_dien, tien_nuoc, phi_dich_vu, tong_tien, trang_thai='unpaid', ngay_het_han, ...).
- **Side effects:** 
    - Gửi `HoadonMoiNotification` cho tất cả sinh viên trong phòng qua hệ thống Notification của Laravel.
- **Output:** Danh sách các hóa đơn mới được tạo.

**Bước 2 — Xác nhận Thanh toán (Actor: Admin)**
- **Input:** `id` (ID hóa đơn).
- **Validation:** Hóa đơn phải tồn tại.
- **Action:** 
    - UPDATE `hoadon` SET `trang_thai` = 'paid', `ngay_thanh_toan` = NOW().
- **Side effects:** 
    - `HoadonObserver` ghi nhật ký thay đổi trạng thái thanh toán.
- **Output:** Trạng thái hóa đơn chuyển sang 'paid'.

**Bước 3 — Xuất PDF Hóa đơn (Actor: Admin/Sinh viên)**
- **Input:** `id` (ID hóa đơn).
- **Action:** Render view `pdf.hoadon` và stream về trình duyệt bằng thư viện DomPDF.
- **Output:** File PDF hóa đơn chính thức.

### Ràng buộc DB quan trọng
- **CHECK CONSTRAINTS:**
    - `hoadon_tong_tien_hop_le_chk`: `tong_tien` phải bằng tổng của các cột thành phần (`tien_phong` + `tien_dien` + `tien_nuoc` + `phi_dich_vu`).
    - `hoadon_ngay_thanh_toan_chk`: Nếu `trang_thai` = 'paid' thì `ngay_thanh_toan` không được NULL.
- **UNIQUE INDEX:** `hoadon.ma_hoa_don` đảm bảo mã hóa đơn là duy nhất.
- **FOREIGN KEY:** `hoadon.hopdong_id -> hopdong.id` (nullOnDelete).

### Điểm CHƯA RÕ (Cần clarify)
- **Hóa đơn Phat (Penalty):** Luồng tạo hóa đơn phạt hiện đang được trigger từ `BaohongService`, nhưng chưa thấy UI cho Admin tạo hóa đơn phạt thủ công không thông qua báo hỏng.
- **Xử lý Hóa đơn quá hạn:** Có Command `KiemTraHoaDonQuaHan` nhưng cần verify logic auto-update trạng thái sang 'overdue'.
- **Schema Drift:** `HoadonObserver` đang kiểm tra cột `trangthaithanhtoan` nhưng thực tế cột là `trang_thai`.
- **Refund Logic:** `LOAI_REFUND` tồn tại trong Enum/Constant nhưng chưa có implementation cụ thể trong Service.
