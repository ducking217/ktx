# IA & User Flows — Admin KTX

## 1) Information Architecture (IA)

### 1.1 Cấp 1 (Sidebar)
- Dashboard
- Quản lý tòa nhà
- Phòng & Tài sản
- Sinh viên
- Hồ sơ đăng ký
- Hợp đồng
- Yêu cầu gia hạn
- Hóa đơn điện nước
- Báo cáo nợ
- Báo cáo tài chính
- Báo hỏng
- Lịch bảo trì
- Kỷ luật
- Thông báo
- Hộp thư góp ý
- Cài đặt hệ thống
- Nhật ký hoạt động (Admin only)
- Quản lý tài khoản (permission)

### 1.2 Cấp 2 (Trong từng trang)
- List → Detail (nếu có)
- List → Create/Edit (modal hoặc trang riêng)
- Filters / Segments
- Primary action (1 hành động chính)
- Secondary actions (icon buttons)

## 2) Core User Flows

### Flow A — Duyệt đăng ký cư trú (Registration Approval)
Goal: chuyển hồ sơ từ Pending sang Approved hoặc ApprovedPendingPayment hoặc Rejected.

1. Mở “Hồ sơ đăng ký”
2. Chọn segment “Chờ duyệt”
3. Xem nhanh: Ứng viên + Chỉ định + Trạng thái + Hồ sơ
4. Primary action:
   - Duyệt (sinh viên có tài khoản) → xác nhận → toast thành công
   - hoặc với hồ sơ guest: Duyệt → chuyển sang “Chờ đóng tiền”
5. Optional:
   - Mở preview CCCD
   - Từ chối → xác nhận → toast
Success: thao tác 1 hàng trong table không cần rời trang.

### Flow B — Xác nhận thanh toán hồ sơ guest
1. Vào “Hồ sơ đăng ký”
2. Segment “Chờ đóng tiền”
3. Bấm “XN Tiền” → xác nhận
4. Hệ thống cấp phòng + sinh viên + hợp đồng + hóa đơn cọc (backend giữ nguyên)
Success: trạng thái đổi ngay, row biến mất khỏi segment hoặc chuyển trạng thái tương ứng.

### Flow C — Kết xuất hóa đơn tháng
1. Vào “Hóa đơn điện nước”
2. Primary action “Ghi chỉ số mới” hoặc “Nhập hàng loạt”
3. Nhập chỉ số → submit
4. Xem danh sách hóa đơn mới tạo + trạng thái “Chờ thanh toán/Chờ xác nhận”
Success: tránh sai số bằng validation UI + định dạng tiền rõ.

### Flow D — Theo dõi công nợ và nhắc nợ
1. Vào “Báo cáo nợ”
2. Xem KPI + bảng theo phòng
3. Bấm “Gửi nhắc nợ” → xác nhận
Success: xác nhận nêu rõ phạm vi (toàn bộ sinh viên phòng).

### Flow E — Xử lý báo hỏng
1. Vào “Báo hỏng”
2. Segment theo trạng thái
3. Inline cập nhật trạng thái (select + submit)
4. Optional: mở tư liệu (tab mới)
Success: thao tác 1 bước, feedback rõ.

### Flow F — Lập lịch bảo trì
1. Vào “Lịch bảo trì”
2. Primary action “Lập lịch mới” (modal)
3. Nhập nội dung + ngày + kỹ thuật viên → submit
4. Optional: hoàn tất / chỉnh sửa

### Flow G — Phát hành thông báo
1. Vào “Thông báo”
2. Primary action “Tạo bài đăng mới”
3. Nhập tiêu đề + ngày + nội dung → submit
4. Edit / delete có confirmation

### Flow H — Báo cáo tài chính
1. Vào “Báo cáo tài chính”
2. Xem KPI + biểu đồ + top phòng + bảng theo kỳ
3. Export Excel theo năm

