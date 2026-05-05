# Error Audit - Code vs PRD/Architecture

Ngày audit: 2026-05-04
Phạm vi: đối chiếu `memory-bank/product-requirements.md`, `memory-bank/architecture.md` với code và migrations hiện tại.

## 1) Lỗi nghiêm trọng (Cần xử lý ngay)
- ~~**DangkyController gọi method không tồn tại**~~ ✅ **ĐÃ GIẢI QUYẾT**
  - ~~`DangkyController::duyetDangKy()` gọi `$this->dangkyService->duyetDangKy(...)`.~~
  - ~~`DangkyServiceInterface` và `DangkyService` không có method này.~~
  - **Resolution:** Đã thêm method `duyetDangKy()` vào interface và service với full logic.
  - **Ngày giải quyết:** 2026-05-04 (Phase 1A Hotfix)

- ~~**Lệch luồng tạo hợp đồng giữa Controller - Service - DB**~~ ✅ **ĐÃ GIẢI QUYẾT**
  - ~~Controller validate `phong_id`.~~
  - ~~Service `taoHopDong()` lại đọc `giuong_id`.~~
  - ~~Migration `hopdong` yêu cầu cả `phong_id` và `giuong_id` (đều FK), nhưng service không set `phong_id`.~~
  - **Resolution:** Smart Auto-Assign logic - Controller truyền cả hai ID, Service validate và mapping.
  - **Ngày giải quyết:** 2026-05-04 (Phase 1D Hotfix)

- ~~**Module hóa đơn không khớp schema v2**~~ ✅ **ĐÃ GIẢI QUYẾT**
  - ~~Code dùng `chi_tiet`, `ma_hd`, relation `hoadon->sinhvien`, loại hóa đơn `penalty/utility`.~~
  - ~~Migration hiện tại không có `chi_tiet`, cột mã là `ma_hoa_don`, enum `loai_hoadon` là `monthly/deposit/refund/extra`.~~
  - ~~DB có check constraint `tong_tien = tien_phong + tien_dien + tien_nuoc + phi_dich_vu`, nhưng service thường chỉ set `tong_tien`.~~
  - **Resolution:** Module đã đồng bộ 100% với migration v2, constraint verified.
  - **Ngày giải quyết:** 2026-05-04 (Phase 1B Hotfix)

- ~~**Module thông báo vẫn dùng field legacy**~~ ✅ **ĐÃ GIẢI QUYẾT**
  - ~~Model/Service thao tác `tieude/noidung/doituong/ngaydang`.~~
  - ~~Migration `thongbao` dùng `tieu_de/noi_dung/loai_thong_bao/doi_tuong_nhan`.~~
  - ~~Model còn chứa `phong_id/sinhvien_id` nhưng bảng hiện tại không có.~~
  - **Resolution:** Đã cập nhật Model và Service theo schema v2.
  - **Ngày giải quyết:** 2026-05-04 (Phase 1C Hotfix)

## 2) Lỗi mức cao
- ~~**Role không nhất quán giữa Route - Enum - DB**~~ ✅ **ĐÃ GIẢI QUYẾT**
  - ~~Route middleware dùng `admin,admin_truong,admin_toanha`.~~
  - ~~Enum `UserRole` chỉ có `admin/sinhvien/cuu_sinhvien`.~~
  - ~~DB enum `users.vaitro` là `guest/sinhvien/admin`.~~
  - **Resolution:** "Tam giác quyền lực" - Ép phẳng 3 role: admin, sinhvien, guest.
  - **Ngày giải quyết:** 2026-05-04 (Phase 2A Hotfix)

- ~~**Gia hạn hợp đồng cập nhật cột không tồn tại**~~ ✅ **ĐÃ GIẢI QUYẾT**
  - ~~`GiaHanService::duyetYeuCau()` update `sinhvien.ngay_het_han`.~~
  - ~~Bảng `sinhvien` không có cột `ngay_het_han`.~~
  - **Resolution:** Xóa logic update cột không tồn tại, chỉ update `hopdong.ngay_ket_thuc`.
  - **Ngày giải quyết:** 2026-05-04 (Phase 2B Hotfix)

## 3) Lỗi mức trung bình
- ~~**Đọc chỉ số điện nước sai cấu trúc dữ liệu**~~ ✅ **ĐÃ GIẢI QUYẾT**
  - ~~Code đọc `chiso_dien_moi/chiso_nuoc_moi`.~~
  - ~~Bảng `chi_so_dien_nuoc` đang thiết kế theo `loai` + `chi_so_moi`.~~
  - **Resolution:** Code đã dùng đúng structure `loai` + `chi_so_moi`.
  - **Ngày giải quyết:** 2026-05-04 (Phase 2B Hotfix)

- **PII flow đang dở**
  - Có placeholder `diChuyenFileDangKySangSinhvien()`.
  - Có comment “encrypt sau” cho dữ liệu nhạy cảm.
  - Rủi ro: chưa hoàn thiện yêu cầu bảo mật/tuân thủ dữ liệu cá nhân.

## 4) Điểm chưa tối ưu để mở rộng DB
- **Thiếu cột kỳ hóa đơn chuẩn hóa**
  - Nên có cột `thang`, `nam` (hoặc `billing_period`) trực tiếp trên bảng hóa đơn.
  - Tránh nhồi kỳ tính tiền vào JSON.

- **Thiếu unique chống trùng hóa đơn theo kỳ**
  - Đề xuất unique theo tổ hợp: `hopdong_id + loai_hoadon + thang + nam`.
  - Tránh tạo trùng hóa đơn khi chạy tác vụ lặp/retry.

- **Enum DB cứng cho domain thay đổi nhanh**
  - Trạng thái/loại nghiệp vụ đang dùng enum DB ở nhiều bảng.
  - Khi mở rộng nhiều trạng thái mới sẽ tăng chi phí migration.

## 5) Runtime Errors (Defensive Programming) - ĐÃ GIẢI QUYẾT ✅
- **Parameter Mismatch in DangkyService**
  - **Issue:** Controller truyền `phongId, giuongNo` nhưng Service mong đợi `toaNhaId, loaiPhongId`
  - **Resolution:** Cập nhật signature thành `layDuLieuFormDangKyKhach(int $phongId, ?int $giuongNo = null)`
  - **Files:** DangkyService, DangkyServiceInterface, DangkyController
  - **Ngày giải quyết:** 2026-05-04 (Hotfix & Stability)

- **Null Pointer in Blade Template**
  - **Issue:** `$phong->gioitinh_han_che->label()` có thể gây null error
  - **Resolution:** Null-safe operator `?->label() ?? 'N/A'`
  - **Files:** `resources/views/landing/phong/danhsach.blade.php`
  - **Ngày giải quyết:** 2026-05-04 (Hotfix & Stability)

- **UI Bug: Landing Page Gender Display & Schema Drift**
  - **Issue 1:** Schema Drift: File migration `create_phong_table.php` định nghĩa cột `gioitinh_han_che`, nhưng DB thực tế đang dùng `gioi_tinh_han_che`. Việc sửa Model theo file migration đã làm hỏng tính năng ép kiểu Enum.
  - **Issue 2:** Giao diện trang khách hiển thị `N/A` và trống phần Sức chứa / Đang ở do file `landing/index.blade.php` vẫn sử dụng các biến cũ từ cấu trúc v1 (`$phong->gioitinh`, `$phong->succhuamax`, `$phong->dango`).
  - **Resolution:** 
    1. Trả lại Model `Phong.php` sử dụng đúng cột thực tế trong DB là `gioi_tinh_han_che` để Enum được cast thành công.
    2. Cập nhật lại toàn bộ `landing/index.blade.php` để map đúng thuộc tính mới (`gioi_tinh_han_che?->label()`, `loaiphong->gia_thang`, `loaiphong->suc_chua`, `dango_count`).
  - **Files:** `app/Models/Phong.php`, `resources/views/landing/index.blade.php`
  - **Ngày giải quyết:** 2026-05-04 (Hotfix & Stability)

## 6) Schema Drift - Migration vs DB (ĐÃ GIẢI QUYẾT ✅)
- ~~**Bảng `phong`: Sai tên cột giới tính**~~ ✅ **ĐÃ GIẢI QUYẾT**
  - ~~Migration dùng `gioitinh_han_che` nhưng DB có `gioi_tinh_han_che`~~
  - **Resolution:** Đổi migration và 9 code files sang `gioi_tinh_han_che`
  - **Ngày giải quyết:** 2026-05-04 (Phase 3 Migration Audit)

- ~~**Bảng `thongbao_user`: Sai tên cột ngày đọc**~~ ✅ **ĐÃ GIẢI QUYẾT**
  - ~~Migration dùng `ngay_doc` nhưng DB có `doc_luc`~~
  - **Resolution:** Đổi migration sang `doc_luc`
  - **Ngày giải quyết:** 2026-05-04 (Phase 3 Migration Audit)

- ~~**Bảng `cauhinh`: Thiếu cột**~~ ✅ **ĐÃ GIẢI QUYẾT**
  - ~~Migration thiếu `nhom` và `mo_ta`~~
  - **Resolution:** Thêm 2 cột vào migration
  - **Ngày giải quyết:** 2026-05-04 (Phase 3 Migration Audit)

- ~~**Bảng `toa_nha`: Thiếu cột giới tính và softDeletes**~~ ✅ **ĐÃ GIẢI QUYẾT**
  - ~~Migration thiếu cột `gioi_tinh` và `softDeletes`~~
  - **Resolution:** Thêm cột `gioi_tinh` enum và `softDeletes` vào migration
  - **Ngày giải quyết:** 2026-05-04 (Phase 3 Migration Audit - Lần 2)

- ~~**Bảng `nhat_ky`: Thiếu cột IP**~~ ✅ **ĐÃ GIẢI QUYẾT**
  - ~~Migration thiếu cột `ip_address`~~
  - **Resolution:** Thêm cột `ip_address` vào migration
  - **Ngày giải quyết:** 2026-05-04 (Phase 3 Migration Audit - Lần 2)

- ~~**Bảng `lich_su_bao_tri`: Thiếu softDeletes**~~ ✅ **ĐÃ GIẢI QUYẾT**
  - ~~Migration thiếu `softDeletes`~~
  - **Resolution:** Thêm `softDeletes` vào migration
  - **Ngày giải quyết:** 2026-05-04 (Phase 3 Migration Audit - Lần 2)

## 7) Khuyến nghị xử lý theo pha
- ~~**Pha 1 (Hotfix):**~~ ✅ **HOÀN TẤT** sửa mismatch method/interface, đồng bộ field `hopdong` và `hoadon`, sửa `thongbao` theo schema hiện tại.
- ~~**Pha 2 (Stabilize):**~~ ✅ **HOÀN TẤT** chuẩn hóa role toàn hệ thống (route, enum, DB), hoàn tất flow gia hạn và chỉ số điện nước.
- ~~**Pha 3 (Migration Audit):**~~ ✅ **HOÀN TẤT** fix schema drift giữa migration và DB, đồng bộ tên cột trong code.
- **Pha 4 (Scale-ready):** chuẩn hóa dữ liệu kỳ hóa đơn, thêm unique chống trùng, bổ sung test integration cho 4 luồng core: đăng ký, hợp đồng, hóa đơn, thông báo.
