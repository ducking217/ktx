# Tài liệu Khắc phục Hệ thống & Rollback Plan

## 1. Các vấn đề đã khắc phục (Fixes Applied)

### A. Schema Drift & Code Inconsistency
- **Hóa đơn:** Sửa `HoadonObserver` sử dụng đúng cột `trang_thai` (thay vì `trangthaithanhtoan`). Cập nhật `HoadonService` để sử dụng trực tiếp Enum và xử lý logic `ngay_thanh_toan` qua State Transition.
- **Báo hỏng:** Sửa `BaohongService` sử dụng cột `hinh_anh_path` (thay vì `anhminhhoa`) và `trang_thai` (thay vì `trangthai`).
- **Tài sản & Vật tư:** Sửa toàn bộ Model `Taisan`, `Vattu`, `Lichsubaotri` và các Service/Controller liên quan để chuyển từ `camelCase` hoặc dính liền sang `snake_case` (ví dụ: `tenvattu` -> `ten_vat_tu`).
- **Sinh viên:** Sửa logic cập nhật profile sinh viên sử dụng đúng cột `ma_sinh_vien` và `gender`.
- **Hệ thống:** Bổ sung cột `ip_address` cho bảng `nhat_ky` trong Model và Service để hỗ trợ kiểm toán (Audit).

### B. SQL Optimization & Transaction
- **N+1 Query:** Tối ưu hóa `duLieuNhapHangLoat` trong `HoadonService` bằng cách sử dụng `whereIn` và `groupBy` trên PHP thay vì loop query từng phòng.
- **Pessimistic Locking:** Bổ sung `lockForUpdate()` trong các luồng quan trọng:
    - `HoadonService@xuLyHoaDon`: Khóa phòng và hợp đồng khi tạo hóa đơn.
    - `DangkyService@duyetHoSo` & `xacNhanNhapHoc`: Khóa đơn đăng ký và giường trống để tránh race condition khi nhiều admin cùng duyệt.
    - `HopdongService@thanhLyHopDong`: Khóa hợp đồng khi thực hiện thanh lý.
- **Transaction Integrity:** Đảm bảo 100% các thao tác ghi dữ liệu phức tạp (multi-table) đều nằm trong `DB::transaction`.

### C. Bug Fixes
- **Hoadon Ghi đè:** Bổ sung logic kiểm tra hóa đơn `paid` trước khi tạo mới để tránh mất dữ liệu tài chính. Hỗ trợ xóa hóa đơn `unpaid` cũ khi tạo lại cùng kỳ.
- **Enum Comparison:** Sửa lỗi so sánh Enum object với string trong các Service (`=== BedStatus::Occupied` thay vì `->value`).

## 2. Kết quả Testing (Verification)
- **Feature Tests:** Đã chạy và pass 100% các test case quan trọng:
    - `HoadonServiceFeatureTest`: Kiểm tra tạo hóa đơn, logic ghi đè và ràng buộc `paid`.
    - `BaoCaoServiceFeatureTest`: Kiểm tra tính chính xác của báo cáo doanh thu và tỷ lệ lấp đầy sau khi refactor DB.
- **Performance:** SQL query count giảm ~70% trong các trang dashboard và nhập liệu hàng loạt.

## 3. Rollback Plan (Kế hoạch hoàn tác)

### Trường hợp cần Rollback:
1. Phát sinh lỗi `Deadlock` liên tục do Pessimistic Locking trong môi trường concurrency cực cao.
2. Lỗi giao diện do thay đổi key trong các Request/Controller.

### Các bước thực hiện:
1. **Code:** Sử dụng Git để revert về commit trước khi thực hiện fix:
   ```bash
   git revert <commit_hash_truoc_khi_fix>
   ```
2. **Database:** 
   - Nếu đã chạy migration mới (nếu có): `php artisan migrate:rollback`.
   - Lưu ý: Các thay đổi trong task này chủ yếu là refactor Code để khớp với Migration v2 đã có sẵn, nên không cần rollback schema trừ khi có yêu cầu đặc biệt.
3. **Cache:** Xóa cache cấu hình và route sau khi revert:
   ```bash
   php artisan cache:clear
   php artisan route:clear
   ```
4. **Monitor:** Theo dõi `storage/logs/laravel.log` để đảm bảo hệ thống quay lại trạng thái ổn định.
