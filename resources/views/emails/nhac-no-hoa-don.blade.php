<!DOCTYPE html>
<html lang="vi">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Nhắc nhở thanh toán hóa đơn</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #111827;">
    <p>Chào bạn,</p>

    <p>
        Hệ thống ghi nhận hóa đơn của bạn đã chuyển sang trạng thái quá hạn thanh toán.
        Vui lòng đăng nhập để kiểm tra và hoàn tất thanh toán.
    </p>

    <p style="margin: 0 0 6px 0;"><strong>Thông tin hóa đơn</strong></p>
    <ul style="margin: 0; padding-left: 18px;">
        <li>Mã hóa đơn: {{ $hoadon->ma_hd }}</li>
        <li>Kỳ: Tháng {{ $hoadon->thang }}/{{ $hoadon->nam }}</li>
        <li>Phòng: {{ $hoadon->phong->tenphong ?? '---' }}</li>
        <li>Số tiền: {{ number_format((int) $hoadon->tongtien) }} VNĐ</li>
        <li>Ngày phát hành: {{ $hoadon->ngayxuat ? \Illuminate\Support\Carbon::parse($hoadon->ngayxuat)->format('d/m/Y') : '---' }}</li>
    </ul>

    <p>
        Đăng nhập để xem chi tiết:
        <a href="{{ $loginUrl }}">{{ $loginUrl }}</a>
    </p>

    <p>Trân trọng,</p>
    <p>Ban quản lý KTX</p>
</body>
</html>

