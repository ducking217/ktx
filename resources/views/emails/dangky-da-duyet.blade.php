<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Đăng ký phòng đã được duyệt</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #0f172a;">
    <h2>Thông báo duyệt đăng ký phòng</h2>

    <p>Chào {{ $userName ?? 'bạn' }},</p>
    <p>Đơn đăng ký phòng của bạn đã được duyệt.</p>

    <div style="background: #f0f7ff; padding: 20px; border-radius: 8px; margin: 20px 0; border: 1px solid #d0e7ff;">
        <h4 style="margin-top: 0; color: #00A86B;">Yêu cầu thanh toán</h4>
        <p>Hệ thống đã tạo hóa đơn <strong>Tiền cọc</strong> và <strong>Tiền phòng tháng này</strong>.</p>
        <p>Vui lòng đăng nhập vào hệ thống để xem chi tiết hóa đơn và thực hiện thanh toán để hoàn tất thủ tục nhận phòng.</p>
    </div>

    <p><strong>Thông tin chỗ ở</strong></p>
    <ul>
        <li>Phòng: {{ $tenPhong }}</li>
        <li>Giường: {{ $maGiuong }}</li>
        <li>Ngày bắt đầu: {{ $ngayBatDau }}</li>
        <li>Ngày kết thúc: {{ $ngayKetThuc }}</li>
    </ul>

    <p>Bạn vui lòng đăng nhập hệ thống để xem chi tiết hợp đồng và hóa đơn.</p>
</body>
</html>
