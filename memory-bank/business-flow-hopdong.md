# Phân tích Luồng Nghiệp vụ: Module Hợp đồng

## App\Services\Admin\HopdongService — Bảng DB liên quan: `sinhvien`, `phong`, `giuong`, `hopdong`, `hoadon`

### Điều kiện tiên quyết
- Sinh viên phải tồn tại trong bảng `sinhvien`.
- Giường (`giuong`) phải có trạng thái `available`.
- Admin phải có permission `hopdong.manage`.

### Các bước chi tiết

**Bước 1 — Tạo Hợp đồng (Actor: Admin)**
- **Input:** `sinhvien_id`, `phong_id` (optional), `giuong_id` (optional), `ngay_bat_dau`, `ngay_ket_thuc`.
- **Validation:** 
    - Phải cung cấp ít nhất `giuong_id` hoặc `phong_id`.
    - Sinh viên không được có hợp đồng `active` khác.
    - Giường phải đang trống.
- **Action (Smart Auto-Assign):**
    - Nếu có `giuong_id`: Kiểm tra giường thuộc phòng nào, validate nếu `phong_id` cũng được gửi lên.
    - Nếu chỉ có `phong_id`: SELECT giường trống đầu tiên trong phòng đó.
    - Lấy `gia_thuc_te` từ `loai_phong` của phòng đó.
    - INSERT INTO `hopdong` (sinhvien_id, phong_id, giuong_id, ngay_bat_dau, ngay_ket_thuc, gia_thuc_te, trang_thai='active').
    - UPDATE `giuong` SET `trang_thai` = 'occupied'.
- **Side effects:** 
    - `HopdongObserver` ghi nhật ký tạo mới.
- **Output:** Hợp đồng mới được tạo, giường chuyển sang trạng thái có người ở.

**Bước 2 — Gia hạn Hợp đồng (Actor: Admin/Sinh viên)**
- **Luồng Sinh viên gửi yêu cầu:**
    - Sinh viên gửi yêu cầu qua `GiaHanController@store`.
    - INSERT INTO `yeu_cau_gia_han` (hopdong_id, ngay_ket_thuc_moi, trang_thai='pending').
- **Luồng Admin duyệt yêu cầu:**
    - Admin duyệt qua `GiaHanController@duyet`.
    - UPDATE `hopdong` SET `ngay_ket_thuc` = `ngay_ket_thuc_moi`.
    - UPDATE `yeu_cau_gia_han` SET `trang_thai` = 'approved'.
- **Side effects:** 
    - Gửi email `KetQuaGiaHanHopDongMail` cho sinh viên.
- **Output:** Ngày kết thúc hợp đồng được cập nhật.

**Bước 3 — Thanh lý Hợp đồng (Actor: Admin)**
- **Input:** `id` (ID hợp đồng), `phi_hu_hai` (optional).
- **Validation:** Hợp đồng phải đang `active`.
- **Action:**
    - UPDATE `hopdong` SET `trang_thai` = 'terminated'.
    - UPDATE `giuong` SET `trang_thai` = 'available' (giải phóng giường).
    - Gọi `HoanTienService->xuLyHoanTien()` để tính toán trả lại tiền cọc trừ đi phí hư hại (nếu có).
- **Side effects:** 
    - `HopdongObserver` ghi nhật ký thay đổi trạng thái.
- **Output:** Hợp đồng kết thúc, giường trống trở lại.

### Ràng buộc DB quan trọng
- **GENERATED COLUMN:** `cot_hieu_luc` (stored as CASE WHEN `trang_thai` = 'active' THEN 1 ELSE NULL END).
- **UNIQUE INDEX:** 
    - `hopdong_mot_active_moi_sinhvien_unique`: (sinhvien_id, cot_hieu_luc) -> Đảm bảo mỗi sinh viên chỉ có 1 hợp đồng active.
    - `hopdong_mot_active_moi_giuong_unique`: (giuong_id, cot_hieu_luc) -> Đảm bảo mỗi giường chỉ có 1 hợp đồng active.
- **CHECK CONSTRAINT:** `hopdong_ngay_hop_le_chk`: `ngay_ket_thuc` >= `ngay_bat_dau`.

### Điểm CHƯA RÕ (Cần clarify)
- **Tự động chấm dứt:** Command `KiemTraHopDongHetHan` xử lý các hợp đồng đến ngày kết thúc nhưng chưa được thanh lý thủ công như thế nào? (Cần check `app/Console/Commands/KiemTraHopDongHetHan.php`).
- **Logic Hoàn tiền:** `HoanTienService` chưa được phân tích sâu, cần xem cách nó tạo hóa đơn hoàn tiền (`refund`).
- **Generated PDF:** Cột `ma_hd` legacy đã được fix thành `"HD-{$hopdong->id}"`, nhưng cần verify template PDF có hiển thị đúng thông tin giường/phòng mới không.
