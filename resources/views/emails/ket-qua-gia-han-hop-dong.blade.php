<!DOCTYPE html>
<html lang="vi">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Kết quả yêu cầu gia hạn hợp đồng</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #111827;">
    <p>Chào bạn,</p>

    <p>
        Yêu cầu gia hạn hợp đồng của bạn đã được cập nhật trạng thái:
        <strong>{{ $yeuCauGiaHan->trang_thai?->label() ?? '---' }}</strong>
    </p>

    <p style="margin: 0 0 6px 0;"><strong>Thông tin yêu cầu</strong></p>
    <ul style="margin: 0; padding-left: 18px;">
        <li>Mã yêu cầu: {{ $yeuCauGiaHan->id }}</li>
        <li>Mã hợp đồng: {{ $yeuCauGiaHan->hopdong?->ma_hd ?? '---' }}</li>
        <li>Ngày kết thúc mới đề xuất: {{ $yeuCauGiaHan->ngay_ket_thuc_moi ? \Illuminate\Support\Carbon::parse($yeuCauGiaHan->ngay_ket_thuc_moi)->format('d/m/Y') : '---' }}</li>
        <li>Ghi chú admin: {{ $yeuCauGiaHan->ghi_chu_admin ?? '---' }}</li>
    </ul>

    <p>
        Đăng nhập để xem chi tiết:
        <a href="{{ $loginUrl }}">{{ $loginUrl }}</a>
    </p>

    <p>Trân trọng,</p>
    <p>Ban quản lý KTX</p>
</body>
</html>

