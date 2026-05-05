# Project Brief - HeThongQuanLyKTXV1

## 1) Tổng quan dự án
Hệ thống quản lý KTX là ứng dụng Laravel 11 phục vụ số hóa vận hành ký túc xá cho 3 nhóm người dùng:
- Khách/Guest: đăng ký ở KTX và tra cứu trạng thái hồ sơ.
- Sinh viên: quản lý vòng đời ở KTX (phòng, hợp đồng, hóa đơn, gia hạn, báo hỏng, thông báo).
- Quản trị/Admin: vận hành tòa nhà, phòng, tài sản, đăng ký, hợp đồng, tài chính, bảo trì, kỷ luật.

## 2) Mục tiêu nghiệp vụ
- Tập trung dữ liệu vận hành KTX vào một hệ thống duy nhất, có lịch sử và kiểm soát truy vết.
- Rút ngắn quy trình xử lý đăng ký, duyệt hồ sơ, lập hóa đơn, theo dõi công nợ.
- Nâng cao trải nghiệm sinh viên với kênh tự phục vụ (xem phòng, hóa đơn, thông báo, gửi yêu cầu).
- Chuẩn hóa quản trị nội bộ qua service layer + observer + role-based access.

## 3) Phạm vi hiện tại
- Quản lý tòa nhà, loại phòng, phòng, giường, tài sản, vật tư.
- Quản lý người dùng/sinh viên và phân vai trò (`guest`, `sinhvien`, `admin`).
- Quản lý đăng ký vào KTX (guest và sinh viên), xét duyệt hồ sơ.
- Quản lý hợp đồng, gia hạn hợp đồng, thanh lý hợp đồng.
- Quản lý hóa đơn, thanh toán, công nợ, báo cáo tài chính.
- Quản lý bảo hỏng, lịch sử bảo trì, kỷ luật, đánh giá, thông báo.
- Nhật ký hoạt động và các observer để đồng bộ nghiệp vụ.

## 4) Giá trị cốt lõi
- Minh bạch dữ liệu và truy vết thao tác qua bảng nhật ký/observer.
- Hạn chế lỗi nghiệp vụ bằng ràng buộc DB (unique, check, FK, index).
- Dễ mở rộng nhờ kiến trúc tách lớp Controller -> Contract -> Service -> Repository/Model.

## 5) Giả định vận hành
- Hệ thống ưu tiên web app nội bộ, chưa có mobile app chính thức.
- Tài khoản người dùng là điểm định danh chung cho admin và sinh viên.
- Dữ liệu nhạy cảm (PII) có chiến lược lưu trữ mã hóa/chỉ mục mù ở các bảng liên quan.
