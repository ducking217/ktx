# BÁO CÁO AUDIT TOÀN DIỆN — Hệ thống Quản lý KTX
**Ngày:** 2026-05-02  
**Phiên bản:** v1 (trước Cleanup)  
**Stack:** Laravel 10 + Blade + Tailwind + MySQL  
**Quy mô:** ~130 Classes, ~16 Models, ~25 Services, ~15 Admin Controllers, ~8 Student Controllers

---

## MỤC LỤC
1. [Nghiệp vụ (Business Logic)](#1-nghiệp-vụ-business-logic)
2. [Kỹ thuật & Kiến trúc](#2-kỹ-thuật--kiến-trúc)
3. [Trải nghiệm người dùng (UX/UI)](#3-trải-nghiệm-người-dùng-uxui)
4. [Danh sách việc cần làm (Prioritized Backlog)](#4-danh-sách-việc-cần-làm-prioritized-backlog)

---

## 1. Nghiệp vụ (Business Logic)

### 1.1. Luồng nghiệp vụ hiện có

| Luồng | Trạng thái | Ghi chú |
|-------|-----------|---------|
| Đăng ký phòng (Sinh viên) | ✅ Có | Kiểm tra phòng đầy, kỷ luật, pending duplicate |
| Đăng ký phòng (Khách - Guest) | ✅ Có | Có PII encryption, email thông báo, lookup token |
| Duyệt đăng ký (Admin) | ✅ Có | Tạo User + Sinhvien + Hopdong + Hóa đơn tự động |
| Trả phòng | ✅ Có | Kiểm tra nợ trước khi trả, terminate hợp đồng |
| Chuyển/Đổi phòng | ✅ Có | Terminate hợp đồng cũ, kiểm tra giới tính/sức chứa |
| Gia hạn hợp đồng | ⚠️ Một phần | Chỉ có từ phía Admin, SV không tự gia hạn được |
| Tạo hóa đơn hàng tháng | ✅ Có | Tính phí điện/nước/phòng theo cấu hình |
| Xác nhận thanh toán | ✅ Có | Admin xác nhận thủ công |
| Nhắc nợ | ✅ Có | Tạo thông báo cho SV |
| Kỷ luật | ✅ Có | Block SV đăng ký nếu có lỗi chưa giải quyết |
| Báo hỏng/Bảo trì | ✅ Có | SV báo → Admin xử lý, có phí bồi thường |

### 1.2. Luồng nghiệp vụ còn THIẾU hoặc CHƯA ĐỦ

#### 🔴 CRITICAL: Thiếu hoàn tiền / Hoàn cọc (Refund)
- **Vấn đề:** Khi sinh viên trả phòng sớm, KHÔNG có logic hoàn tiền cọc (`deposit`) hoặc tính tiền phòng theo ngày thực tế ở. Hệ thống thu cọc (`taoHoaDonTheChan`) nhưng không hoàn khi offboarding.
- **Tác động:** Sinh viên mất tiền cọc vô lý → khiếu nại, rủi ro pháp lý.
- **Đề xuất:** Tạo `HoanTienService` xử lý: (1) Kiểm tra deposit đã thu, (2) Tính ngày ở thực tế / phí tính theo ngày, (3) Tạo `Hoadon` loại `refund` với số tiền âm, (4) Gắn vào luồng `thanhLyHopDong`.

#### 🔴 CRITICAL: Thiếu tự động hết hạn hợp đồng (Auto-Expiry)
- **Vấn đề:** `ContractStatus` có trạng thái `Expired` nhưng KHÔNG có scheduled command nào chuyển hợp đồng `active` → `expired` khi `ngay_ket_thuc` < now(). `Kernel.php` chỉ có `notifications:prune`.
- **Tác động:** Hợp đồng hết hạn vẫn hiển thị `active`, SV vẫn ở phòng dù hết hạn, dữ liệu sai.
- **Đề xuất:** Thêm command `php artisan hopdong:kiem-tra-het-han` chạy daily: (1) Tìm HĐ `active` có `ngay_ket_thuc < today()`, (2) Chuyển → `expired`, (3) Gửi thông báo cho SV + Admin, (4) Tùy chọn tự động gia hạn nếu không có nợ.

#### 🔴 CRITICAL: Thiếu tự động phát hiện hóa đơn quá hạn
- **Vấn đề:** `InvoiceStatus::Overdue` tồn tại nhưng KHÔNG có cơ chế tự động chuyển `pending` → `overdue` sau X ngày.
- **Tác động:** Công nợ chỉ hiện khi admin tự kiểm tra, SV không bị nhắc nhở kịp thời.
- **Đề xuất:** Thêm command `hoadon:kiem-tra-qua-han` chạy daily, set `overdue` cho hóa đơn pending > 30 ngày.

#### 🟡 IMPORTANT: Logic tính phí chưa hoàn chỉnh
- **Vấn đề 1:** Trong `HoadonService::xuLyHoaDon()`, `tongtien = giaphong + tiendien + tiennuoc` nhưng KHÔNG cộng `phidichvu`. Cột `phidichvu` trong DB luôn = NULL.
- **Vấn đề 2:** Hóa đơn tạo bằng `updateOrCreate` theo `phong_id + thang + nam` → nếu admin nhập lại cùng tháng, sẽ GHI ĐÈ hóa đơn cũ mà không warning. Nếu hóa đơn cũ đã `paid`, vẫn bị ghi đè thành `pending`.
- **Vấn đề 3:** Hóa đơn hàng tháng (`taoHoaDonHangThang`) khi duyệt đăng ký KHÔNG tính điện/nước (chỉ tính tiền phòng) → SV nhận 2 hóa đơn tháng đầu (1 auto + 1 manual khi admin ghi chỉ số).
- **Đề xuất:** (1) Thêm `phidichvu` vào tính toán, (2) Kiểm tra hóa đơn đã tồn tại + trạng thái trước khi ghi đè, (3) Merge hóa đơn tháng đầu.

#### 🟡 IMPORTANT: Chuyển phòng (Admin) thiếu tạo hợp đồng mới
- **Vấn đề:** `SinhvienService::assignRoom()` chỉ terminate hợp đồng cũ + update `phong_id`, nhưng KHÔNG tạo hợp đồng mới cho phòng mới.
- **Tác động:** SV ở phòng mới nhưng không có hợp đồng → hóa đơn, báo cáo bị thiếu.
- **Đề xuất:** Sau khi assign room, tự động tạo `Hopdong` mới với `ngay_bat_dau = today()`.

#### 🟡 IMPORTANT: Phân quyền chưa đủ chi tiết
- **Vấn đề:**
  - `PhongController` (admin) KHÔNG có Gate/middleware riêng → tất cả admin roles đều CRUD phòng, kể cả Lễ tân.
  - `BaohongController` (admin) KHÔNG có Gate → lễ tân sửa được trạng thái bảo hỏng.
  - `SinhvienController` (admin) KHÔNG có Gate → lễ tân sửa thông tin SV, chuyển phòng.
  - `ThongbaoController`, `LichsubaotriController` KHÔNG có Gate.
  - Thiếu phân quyền theo tòa nhà (AdminToaNha chỉ nên thấy phòng của tòa mình).
- **Đề xuất:** Bổ sung Gates chi tiết + data-level scoping cho `AdminToaNha`.

#### 🟢 NICE-TO-HAVE: Gia hạn hợp đồng từ phía SV
- SV phải liên hệ admin để gia hạn. Nên cho SV tự gửi yêu cầu gia hạn (tương tự đăng ký/đổi/trả phòng).

#### 🟢 NICE-TO-HAVE: Lịch sử thanh toán chi tiết
- Không có bảng ghi lại ai thanh toán, khi nào, bằng phương thức gì. Chỉ biết trạng thái `paid`.

### 1.3. Edge Cases chưa xử lý

| Edge Case | Trạng thái | Rủi ro |
|-----------|-----------|--------|
| Phòng hết chỗ giữa lúc duyệt đăng ký | ✅ Có `lockForUpdate()` | OK |
| SV nợ tiền nhưng hết hạn hợp đồng | ❌ Chưa xử lý | SV vẫn ở, không bị cưỡng chế trả phòng |
| 2 admin duyệt cùng 1 đơn đăng ký | ✅ Check `trangthai !== Pending` | OK |
| Đăng ký Guest trùng email/phone | ❌ Chưa validate unique | Có thể spam đăng ký |
| SV bị kỷ luật nặng → buộc thôi ở | ❌ Chưa có luồng | Chỉ block đăng ký mới, không buộc rời phòng |
| Admin xóa phòng đang có SV | ⚠️ Có check nhưng logic phức tạp | Cần review `kiemTraDieuKienXoaPhong` |
| HĐ expired nhưng SV vẫn ở (overstay) | ❌ Không xử lý | Dữ liệu không nhất quán |
| Đổi phòng khi phòng mới đầy | ✅ Check sức chứa | OK |
| Ghi đè hóa đơn đã thanh toán | ❌ Cho phép ghi đè | Mất dữ liệu thanh toán |

---

## 2. Kỹ thuật & Kiến trúc

### 2.1. Kiến trúc tổng quan — Điểm tốt

| Tiêu chí | Đánh giá |
|----------|----------|
| Service Layer pattern | ✅ Tốt — logic tách khỏi Controller |
| Interface + DI | ✅ Tốt — 25+ interfaces, bind trong AppServiceProvider |
| Enum pattern (3 tầng) | ✅ Tốt — case/backed value/label() |
| State machine transitions | ✅ Tốt — `canTransitionTo()` + `ALLOWED_TRANSITIONS` trên Model |
| PII Encryption | ✅ Tốt — encrypt/decrypt + blind index cho SĐT, CCCD |
| Audit Trail (Observers) | ✅ Tốt — 13 Observers cho toàn bộ Models |
| SoftDeletes | ⚠️ Có cho 4 Models chính (Sinhvien, Hopdong, Hoadon, Phong) |
| DB Transactions + lockForUpdate | ✅ Tốt — 26 lần sử dụng |
| FormRequest validation | ✅ Tốt — ~18 FormRequest classes |
| CSRF Protection | ✅ Tốt — 54 `@csrf` trong views |

### 2.2. Code Smell & Anti-patterns

#### 🔴 CRITICAL: N+1 Query trên Dashboard
```php
// BangDieuKhienService.php:76
private function demPhongConTrong(): int {
    return Phong::all()->filter(fn($p) => 
        Sinhvien::where('phong_id', $p->id)->count() < (int)$p->succhuamax
    )->count();
}
```
- **Vấn đề:** Load TẤT CẢ phòng rồi query từng phòng → N+1. Với 100 phòng = 101 queries.
- **Fix:** Dùng `withCount('danhsachsinhvien')` rồi filter trong PHP, hoặc raw subquery.

#### 🔴 CRITICAL: N+1 Query trong xu hướng doanh thu
```php
// BangDieuKhienService.php:82-85
for ($i = 5; $i >= 0; $i--) {
    $tienphong[] = Hoadon::where(...)->sum('tienphong');
    $tiendichvu[] = Hoadon::where(...)->sum('tiendien') + Hoadon::where(...)->sum('tiennuoc');
}
```
- **Vấn đề:** 18 queries cho 6 tháng (3 queries/tháng). Dashboard load mỗi lần tốn rất nhiều.
- **Fix:** 1 query group by `thang, nam` rồi map trong PHP.

#### 🟡 IMPORTANT: Tham chiếu method không tồn tại
```php
// DongBoHopDong.php:66
'trang_thai' => Hopdong::trangThaiDaThanhLy()
```
- **Vấn đề:** Model `Hopdong` chỉ có `trangThaiDangHieuLuc()`, KHÔNG có `trangThaiDaThanhLy()`.
- **Tác động:** Command `dongbo:hopdong` sẽ crash khi chạy.

#### 🟡 IMPORTANT: TraPhongService constructor dependency sai namespace
```php
// TraPhongService.php:22-23
private ContractService $contractService,
private HoadonService $invoiceService
```
- **Vấn đề:** Import `App\Services\Student\ContractService` và `App\Services\Student\HoadonService` — nhưng các class này KHÔNG tồn tại trong namespace `Student`. Chỉ có `App\Services\Admin\HopdongService` và `App\Services\Admin\HoadonService`.
- **Tác động:** `TraPhongService` sẽ crash khi resolve vì DI container không tìm thấy class.

#### 🟡 IMPORTANT: Inconsistency sức chứa phòng
```php
// Phong model: $fillable có cả 'soluongtoida' VÀ 'succhuamax'
// Student view: dùng $phong->succhuamax
// Service logic: dùng $phong->soluongtoida
```
- **Vấn đề:** 2 cột cùng ý nghĩa nhưng dùng lẫn lộn. Nếu giá trị khác nhau → logic sai.
- **Fix:** Migrate sang 1 cột duy nhất, thêm accessor nếu cần backward compat.

#### 🟡 IMPORTANT: downloadInvoicePDF & downloadPDF chưa implement
```php
// HoadonController.php:43-48 → body rỗng
// HopdongController.php:78-87 → return toast "sẽ bổ sung ở phase tiếp"
```

#### 🟢 Code style — biến chưa thống nhất
- `TaiChinhService::nhacNo()` viết thông báo KHÔNG DẤU: `'Nhac nho thanh toan cong no'`, `'Yeu cau sinh vien thanh toan...'` → hiển thị sai trên UI cho SV.
- Một số Service method dùng English name: `listStudents`, `assignRoom`, `removeFromRoom`, `updateStudent` — vi phạm STANDARDS.md (biến/method phải tiếng Việt camelCase).

### 2.3. Bảo mật

#### 🔴 CRITICAL: SQL Injection risk với LIKE query
```php
// 13 nơi dùng: where('...', 'like', "%{$tuKhoa}%")
```
- **Vấn đề:** Biến `$tuKhoa` từ `$request->query('q')` KHÔNG được escape cho `%` và `_` (SQL wildcards). User nhập `%` sẽ match mọi thứ.
- **Tác động:** Không phải SQL injection truyền thống (Laravel dùng prepared statements), nhưng là **logic injection** — kẻ tấn công có thể enumerate data.
- **Fix:** Escape `$tuKhoa` bằng `str_replace(['%', '_'], ['\%', '\_'], $tuKhoa)` hoặc dùng helper.

#### 🔴 CRITICAL: Guest routes thiếu Rate Limiting
- **Vấn đề:** Routes `/dang-ky-ktx` (POST), `/lien-he` (POST), `/tra-cuu-don` (GET) KHÔNG có throttle middleware.
- **Tác động:** Bot có thể spam hàng ngàn đăng ký, tấn công email queue, brute-force lookup token.
- **Fix:** Thêm `->middleware('throttle:5,1')` cho POST routes, `->middleware('throttle:10,1')` cho GET.

#### 🟡 IMPORTANT: Lookup token brute-force
```php
$lookupToken = Str::random(32);
```
- Token 32 ký tự đủ mạnh, nhưng route `/tra-cuu-don/{token?}` KHÔNG throttle → có thể brute-force.
- **Fix:** Thêm throttle + log failed lookups + hết hạn token sau 30 ngày.

#### 🟡 IMPORTANT: Private file access chỉ check admin role
```php
Route::get('/private-files/{path}', [FileController::class, 'showPrivateFile'])
    ->middleware(['auth', 'kiemtravaitro:admin,...']);
```
- SV không thể xem ảnh thẻ/CCCD của chính mình. Nếu SV cần xem → phải thêm route riêng với scoping.

#### 🟡 IMPORTANT: Tạo User với random password
```php
'password' => bcrypt(Str::random(12))
```
- SV đăng ký qua Guest flow nhận account nhưng KHÔNG BIẾT password. Phải reset password hoặc dùng magic link. Magic link mail tồn tại (`MagicLinkMail.php`) nhưng KHÔNG thấy được gọi trong luồng `xacNhanThanhToan`.

#### 🟢 SoftDeletes thiếu cho Dangky, Kyluat, Baohong, Taisan, Vattu
- Các Models này thiếu SoftDeletes → dữ liệu bị xóa vĩnh viễn, vi phạm Core Coding Philosophy.

### 2.4. Performance Bottleneck

| Vấn đề | Vị trí | Nghiêm trọng |
|--------|--------|-------------|
| N+1 đếm phòng trống | `BangDieuKhienService::demPhongConTrong()` | 🔴 |
| N+1 doanh thu 6 tháng | `BangDieuKhienService::layXuHuongDoanhThu()` | 🔴 |
| `Phong::all()` trong dropdown | `HoadonService::lietKeHoaDonAdmin()`, `SinhvienService::listStudents()` | 🟡 |
| Không cache cấu hình đơn giá | `layGiaTuCauhinh()` query mỗi lần gọi | 🟡 |
| Thiếu DB index trên `trangthaithanhtoan`, `trang_thai`, `trangthai` | Migrations | 🟡 |
| Dashboard load ~30+ queries mỗi request | `layDuLieuBangDieuKhienAdmin()` | 🔴 |

---

## 3. Trải nghiệm người dùng (UX/UI)

### 3.1. Luồng thao tác phức tạp

#### 🔴 Ghi chỉ số điện nước — Từng phòng một
- Admin phải nhập chỉ số cho TỪNG phòng bằng modal, không có bulk import.
- **Với 100+ phòng, đây là nightmare.**
- **Đề xuất:** Thêm màn hình nhập hàng loạt (table editable) hoặc import Excel.

#### 🟡 Duyệt đăng ký — Không xem chi tiết trước khi duyệt
- Nút "Duyệt" và "Từ chối" nằm ngay trên danh sách, không có trang chi tiết hồ sơ (xem ảnh CCCD, ảnh thẻ).
- Admin Guest flow (`duyetHoSo`) duyệt mà chưa xem ảnh → rủi ro.
- **Đề xuất:** Thêm modal/trang chi tiết với preview ảnh trước khi duyệt.

#### 🟡 Hợp đồng — Thiếu preview trước khi tạo
- Admin POST form tạo hợp đồng mà không thấy preview tổng hợp (SV nào, phòng nào, giá bao nhiêu, thời hạn).
- **Đề xuất:** Thêm bước confirmation trước khi submit.

### 3.2. Thiếu thông báo / Feedback

| Thiếu gì | Ảnh hưởng ai | Mức độ |
|----------|-------------|--------|
| Email thông báo khi HĐ sắp hết hạn (7 ngày, 30 ngày) | SV | 🔴 |
| Thông báo real-time (WebSocket/Pusher đã config nhưng chưa dùng) | SV + Admin | 🟡 |
| Email khi bị ghi kỷ luật | SV | 🟡 |
| Email nhắc thanh toán hóa đơn gần quá hạn | SV | 🔴 |
| Confirmation dialog khi thanh lý hợp đồng | Admin | 🟡 |
| Confirmation dialog khi xóa phòng | Admin | 🟡 |
| Toast message cho thao tác thành công đã có | ✅ | OK |

### 3.3. Màn hình / Tính năng nên thêm

#### 🔴 Thiếu: Báo cáo tổng hợp tài chính
- Không có báo cáo doanh thu theo tháng/quý/năm dạng xuất Excel/PDF.
- Admin chỉ thấy biểu đồ đơn giản trên dashboard.

#### 🔴 Thiếu: Lịch sử hoạt động (Activity Log)
- `TblLog` tồn tại nhưng không có UI để xem → admin không thể audit ai đã làm gì.

#### 🟡 Thiếu: Dashboard SV — Countdown hợp đồng
- SV không thấy bao nhiêu ngày còn lại trong hợp đồng, chỉ thấy ngày bắt đầu/kết thúc.

#### 🟡 Thiếu: Trang quản lý Users (Admin)
- Không có UI để tạo/sửa/khóa tài khoản admin. Hiện phải làm qua DB.
- Tính năng `deactivate()` trên User model tồn tại nhưng không có route/view.

#### 🟡 Thiếu: Tìm kiếm nâng cao (theo tầng, tòa, giới tính, khoảng giá)
- Hiện chỉ tìm theo tên phòng hoặc mã SV.

#### 🟢 Thiếu: Mobile responsiveness
- Dashboard admin dùng grid 12-column → có thể chưa tối ưu trên mobile.
- Student views dùng table → cần card layout cho mobile.

#### 🟢 Thiếu: Dark mode
- Tailwind config đã có nhưng chưa implement dark mode toggle.

#### 🟢 Thiếu: Trang FAQ / Hướng dẫn cho SV mới
- SV mới vào không biết luồng đăng ký, thanh toán, báo hỏng.

### 3.4. Vấn đề UX cụ thể trên View

| View | Vấn đề |
|------|--------|
| `admin/trangchu.blade.php` | Dashboard hard-code "Tòa A-E" với giá trị giả lập từ `$tyLeLapDay ± offset`. Không reflect dữ liệu thực tế. |
| `student/phong/danhsach.blade.php` | Dùng `$phong->succhuamax` nhưng có thể không tồn tại (xem issue soluongtoida vs succhuamax). |
| `admin/hoadon/danhsach.blade.php` | Không có bộ lọc theo trạng thái/tháng/năm. Phải scroll qua tất cả. |
| `student/hoadon/danhsach.blade.php` | So sánh `$status` với `->value` (string) nhưng `$status` là Enum object → badge CSS có thể sai. |
| `admin/dangky/danhsach.blade.php` | Hiển thị `$dangky->loaidangky` trực tiếp → hiện backed value (`rental`, `return`, `change`) thay vì label tiếng Việt. |

---

## 4. Danh sách việc cần làm (Prioritized Backlog)

### 🔴 CRITICAL — Phải sửa ngay

| # | Vấn đề | Tác động | Hướng xử lý |
|---|--------|---------|-------------|
| C1 | Thiếu auto-expiry hợp đồng | HĐ hết hạn vẫn `active`, dữ liệu sai, SV overstay | Tạo command `hopdong:kiem-tra-het-han` chạy daily trong Scheduler. Chuyển expired, gửi email cảnh báo trước 7+30 ngày. |
| C2 | Thiếu auto-overdue hóa đơn | Công nợ không được phát hiện kịp, SV không bị nhắc | Tạo command `hoadon:kiem-tra-qua-han` chạy daily. Chuyển `pending` → `overdue` sau 30 ngày. Gửi email nhắc. |
| C3 | Thiếu hoàn cọc khi trả phòng | SV mất tiền cọc, khiếu nại, rủi ro pháp lý | Tạo `HoanTienService`. Gắn vào luồng thanh lý HĐ. Hóa đơn refund loại `deposit_refund`. |
| C4 | N+1 query trên Dashboard | Dashboard admin chậm, ~30+ queries mỗi load | Refactor `demPhongConTrong()` dùng `withCount()`. Gom doanh thu 6 tháng thành 1 query. Cache 5 phút. |
| C5 | Guest routes thiếu Rate Limiting | Bot spam đăng ký, DDoS email queue | Thêm `throttle:5,1` cho POST, `throttle:10,1` cho GET lookup. |
| C6 | `DongBoHopDong` gọi method không tồn tại | Command crash khi chạy | Thêm `trangThaiDaThanhLy()` vào Model Hopdong hoặc dùng `ContractStatus::Terminated->value`. |
| C7 | `TraPhongService` dependency sai namespace | Service crash khi DI resolve | Sửa constructor import đúng namespace hoặc inject qua Interface. |
| C8 | Ghi đè hóa đơn đã thanh toán | Mất dữ liệu thanh toán, SV phải trả lại | Thêm check: nếu hóa đơn existing đã `paid` → reject hoặc tạo hóa đơn bổ sung thay vì `updateOrCreate`. |

### 🟡 IMPORTANT — Lên kế hoạch sprint tới

| # | Vấn đề | Tác động | Hướng xử lý |
|---|--------|---------|-------------|
| I1 | `tongtien` thiếu `phidichvu` | Tiền thu thiếu so với thực tế | Cộng `phidichvu` từ cấu hình vào `xuLyHoaDon()`. Lưu vào cột `phidichvu`. |
| I2 | Chuyển phòng không tạo HĐ mới | SV có phòng mà không có HĐ | `assignRoom()` tự tạo Hopdong mới sau khi assign. |
| I3 | Phân quyền thiếu cho Phòng, Bảo hỏng, SV, Bảo trì | Lễ tân truy cập quá nhiều chức năng | Bổ sung Gates: `phong.manage`, `baohong.manage`, `sinhvien.manage`, `baotri.manage`. |
| I4 | Scoping dữ liệu theo tòa nhà cho AdminToaNha | AdminToaNha thấy toàn bộ KTX thay vì chỉ tòa mình | Thêm cột `toa_nha_id` vào User, filter theo tòa trong mọi query. |
| I5 | `succhuamax` vs `soluongtoida` inconsistency | Logic sai nếu 2 cột có giá trị khác | Migrate sang 1 cột, alias accessor. |
| I6 | Nhập chỉ số điện nước hàng loạt | Admin mất hàng giờ nhập từng phòng | Bulk input UI (table editable) hoặc Excel import. |
| I7 | Thiếu trang chi tiết hồ sơ đăng ký (Guest) | Admin duyệt mù, không xem ảnh CCCD/thẻ | Tạo modal/trang chi tiết với image preview. |
| I8 | SoftDeletes cho Dangky, Kyluat, Baohong, Taisan, Vattu | Dữ liệu xóa vĩnh viễn, không audit | Thêm SoftDeletes + migration `deleted_at`. |
| I9 | Trang xem Activity Log (TblLog) | Admin không thể audit | Tạo route + view cho danh sách logs, filter theo model/user/ngày. |
| I10 | `nhacNo()` viết thông báo không dấu | SV thấy nội dung lỗi dấu | Sửa nội dung thông báo sang tiếng Việt có dấu chuẩn. |
| I11 | SQL wildcard injection trong LIKE | Kẻ tấn công enumerate data | Escape `%` và `_` trong search input tất cả 13 vị trí. |
| I12 | Guest account tạo mà không gửi magic link login | SV không thể đăng nhập sau đăng ký | Gửi MagicLinkMail trong `xacNhanThanhToan()` luồng Guest. |
| I13 | `downloadInvoicePDF` / `downloadPDF` chưa implement | Admin không xuất được PDF | Implement bằng DomPDF/Snappy. Tạo template Blade cho hợp đồng + hóa đơn. |
| I14 | Thiếu confirmation dialog cho thao tác nguy hiểm | Xóa nhầm phòng, thanh lý nhầm HĐ | Dùng component `<x-confirmation-modal>` đã có trong project. |
| I15 | Dashboard hard-code Tòa A-E | Dữ liệu giả, không phản ánh thực tế | Query `Phong` group by tòa nhà, tính công suất thực. |
| I16 | Dangky view hiển thị backed value thay vì label | UI hiện `rental` thay vì `Thuê phòng` | Dùng `$dangky->loaidangky->label()` trong Blade. |
| I17 | Hóa đơn SV: badge CSS so sánh sai type | Badge có thể hiện sai màu | So sánh `$status->value` hoặc dùng `match` trên Enum instance. |
| I18 | Method names English trong Service (vi phạm STANDARDS.md) | Không nhất quán, khó maintain | Rename `listStudents` → `lietKeSinhVien`, `assignRoom` → `xepPhong`, etc. |

### 🟢 NICE-TO-HAVE — Cải thiện dần

| # | Vấn đề | Tác động | Hướng xử lý |
|---|--------|---------|-------------|
| N1 | SV tự gia hạn hợp đồng | Giảm tải admin, tự phục vụ | Thêm route + form gia hạn cho SV, admin duyệt. |
| N2 | Lịch sử thanh toán chi tiết | Minh bạch tài chính | Tạo bảng `lich_su_thanh_toan` (thời gian, phương thức, người xác nhận). |
| N3 | Báo cáo tài chính xuất Excel | Admin report cho ban giám đốc | Integrate `maatwebsite/excel` hoặc `spatie/simple-excel`. |
| N4 | Real-time notifications (WebSocket) | SV nhận thông báo ngay | Kích hoạt Pusher/Reverb đã config trong `.env.example`. |
| N5 | Trang quản lý Users/Accounts | Admin tạo/sửa/khóa tài khoản | CRUD UserController cho Admin level. |
| N6 | Mobile-optimized card layout cho SV | UX trên điện thoại | Responsive card thay table trên < 768px. |
| N7 | Tìm kiếm nâng cao phòng (tầng, tòa, giới tính, giá) | SV tìm phòng dễ hơn | Multi-filter form + query builder. |
| N8 | Dashboard SV — Countdown HĐ | SV biết còn bao lâu | `Carbon::parse($ngay_ket_thuc)->diffInDays(now())`. |
| N9 | Cache đơn giá điện/nước | Giảm DB queries | `Cache::remember('gia_dien', 3600, ...)` trong `layGiaTuCauhinh()`. |
| N10 | Trang FAQ/Hướng dẫn cho SV mới | Giảm support | Static page với FAQ thường gặp. |
| N11 | Validate unique email/phone cho Guest đăng ký | Chống spam | Thêm rule unique (dùng blind_index) vào `LuuDangkyRequest`. |
| N12 | Index DB cho cột trạng thái | Tăng tốc query | Migration thêm index cho `trangthaithanhtoan`, `trang_thai`, `trangthai`. |
| N13 | Trang SV xem ảnh thẻ/CCCD của mình | SV kiểm tra thông tin | Route riêng với authorization scoping. |

---

## Tổng kết nhanh

| Chiều | Điểm đánh giá | Ghi chú |
|-------|-------------|---------|
| **Nghiệp vụ** | 6/10 | Luồng cơ bản đủ, nhưng thiếu auto-expiry, refund, overdue detection |
| **Kỹ thuật** | 7/10 | Kiến trúc Service/Interface tốt, nhưng có bug runtime (wrong namespace, missing method) và N+1 |
| **Bảo mật** | 7/10 | PII encryption tốt, nhưng thiếu rate limit guest, LIKE injection |
| **UX/UI** | 5/10 | Giao diện đẹp nhưng thiếu nhiều tính năng vận hành: bulk input, reports, PDF, activity log |

**Ưu tiên hành động:**  
1. Fix runtime bugs (C6, C7) → hệ thống chạy không crash  
2. Thêm Scheduler commands (C1, C2) → nghiệp vụ tự động  
3. Rate limit + security (C5, I11) → chống abuse  
4. Performance (C4) → dashboard không lag  
5. UX improvements (I6, I7, I13) → admin làm việc hiệu quả hơn
