<!DOCTYPE html>
<html lang="vi">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Cảnh báo sắp hết hạn hợp đồng</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #111827;">
    <p>Chào bạn,</p>

    <p>
        Hợp đồng lưu trú của bạn sắp hết hạn trong khoảng {{ $mocCanhBaoNgay }} ngày tới.
        Vui lòng kiểm tra lại thông tin hợp đồng để chủ động gia hạn (nếu cần).
    </p>

    <p style="margin: 0 0 6px 0;"><strong>Thông tin hợp đồng</strong></p>
    <ul style="margin: 0; padding-left: 18px;">
        <li>Mã hợp đồng: {{ $hopdong->ma_hd }}</li>
        <li>Phòng: {{ $hopdong->phong->tenphong ?? '---' }}</li>
        <li>Ngày kết thúc: {{ $hopdong->ngay_ket_thuc ? \Illuminate\Support\Carbon::parse($hopdong->ngay_ket_thuc)->format('d/m/Y') : '---' }}</li>
    </ul>

    <p>
        Đăng nhập để xem chi tiết:
        <a href="{{ $loginUrl }}">{{ $loginUrl }}</a>
    </p>

    <p>Trân trọng,</p>
    <p>Ban quản lý KTX</p>
</body>
</html>

