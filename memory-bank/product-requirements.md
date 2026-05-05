# Product Requirements - KTX Management

## 1) Mục tiêu sản phẩm
- Cung cấp nền tảng quản lý KTX end-to-end cho toàn bộ vòng đời: đăng ký -> ở -> thanh toán -> rời phòng.
- Tối ưu quy trình xử lý cho admin và tăng khả năng tự phục vụ cho sinh viên.

## 2) Tính năng đã có (As-Is)
### 2.1 Khách/Guest
- Xem thông tin phòng công khai.
- Đăng ký ở KTX trực tuyến.
- Tra cứu trạng thái đơn đăng ký qua token.
- Gửi liên hệ từ landing page.
- Đăng nhập bằng magic link (luồng xác thực liên kết ký).

### 2.2 Sinh viên
- Xem dashboard, phòng của tôi, hợp đồng của tôi.
- Xem danh sách hóa đơn, chi tiết hóa đơn, xác nhận vi phạm/đối soát.
- Đăng ký phòng, yêu cầu đổi phòng, yêu cầu trả phòng.
- Tạo yêu cầu gia hạn hợp đồng và theo dõi trạng thái.
- Gửi báo hỏng, gửi đánh giá phòng/KTX.
- Xem kỷ luật cá nhân và nhận/đọc thông báo.

### 2.3 Quản trị/Admin
- Quản lý tòa nhà, phòng, sơ đồ phòng, tài sản và vật tư.
- Quản lý sinh viên và nghiệp vụ chuyển/rời phòng.
- Duyệt đăng ký, duyệt hồ sơ, xác nhận thanh toán đăng ký.
- Quản lý hợp đồng (tạo, gia hạn, thanh lý, xuất PDF).
- Quản lý hóa đơn, nhập điện nước hàng loạt, xác nhận thanh toán, xuất PDF.
- Quản lý công nợ và gửi nhắc nợ.
- Quản lý bảo hỏng, bảo trì, kỷ luật, phản hồi đánh giá.
- Quản lý cấu hình hệ thống, thông báo, liên hệ và tài khoản admin.
- Xem báo cáo tài chính và xuất Excel.

### 2.4 Hệ thống/Nền tảng
- RBAC qua middleware + policy (`can:*`).
- Service layer + contracts + repository pattern cục bộ.
- Observer cho các model nghiệp vụ quan trọng.
- Nhật ký thay đổi dữ liệu (`nhat_ky`).
- Soft delete ở nhiều bảng để hỗ trợ audit/khôi phục.

## 3) Tính năng cần có (To-Be)
### 3.1 Ưu tiên cao
- Chuẩn hóa luồng thanh toán online thực tế (gateway callback, đối soát tự động).
- Dashboard KPI vận hành theo thời gian thực (tỷ lệ lấp đầy, nợ quá hạn, SLA bảo trì).
- Workflow phê duyệt nhiều cấp cho đăng ký/gia hạn theo vai trò admin.
- Bộ lọc/báo cáo nâng cao theo tòa nhà, loại phòng, kỳ thu, trạng thái hợp đồng.

### 3.2 Ưu tiên trung bình
- Cổng self-service nâng cao cho sinh viên: lịch sử yêu cầu, tracking tiến độ theo mốc.
- Thông báo đa kênh (email + in-app + tùy chọn SMS/Zalo).
- Mẫu biểu và biên bản chuẩn hóa (thanh lý, bàn giao tài sản, biên nhận thu tiền).
- API-first cho tích hợp mobile app/cổng trường.

### 3.3 Ưu tiên nền tảng
- Chỉ số đo chất lượng dữ liệu (missing profile, sai lệch hóa đơn, orphan record).
- Chính sách backup/restore và DR drill định kỳ.
- Bộ test regression theo module nghiệp vụ quan trọng (đăng ký, hợp đồng, hóa đơn, gia hạn).

## 4) Tiêu chí chấp nhận tổng quát
- Mọi nghiệp vụ chính có thể thao tác qua UI theo đúng role.
- Dữ liệu giao dịch quan trọng có ràng buộc DB và log truy vết.
- Báo cáo tài chính và công nợ đối soát được với hóa đơn/thanh toán.
- Không phát sinh ghi nhận trùng cho hợp đồng active trên cùng sinh viên/giường.
