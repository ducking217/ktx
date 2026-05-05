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
        <li>Mã hóa đơn: <?php echo e($hoadon->ma_hd); ?></li>
        <li>Kỳ: Tháng <?php echo e($hoadon->thang); ?>/<?php echo e($hoadon->nam); ?></li>
        <li>Phòng: <?php echo e($hoadon->phong->tenphong ?? '---'); ?></li>
        <li>Số tiền: <?php echo e(number_format((int) $hoadon->tongtien)); ?> VNĐ</li>
        <li>Ngày phát hành: <?php echo e($hoadon->ngayxuat ? \Illuminate\Support\Carbon::parse($hoadon->ngayxuat)->format('d/m/Y') : '---'); ?></li>
    </ul>

    <p>
        Đăng nhập để xem chi tiết:
        <a href="<?php echo e($loginUrl); ?>"><?php echo e($loginUrl); ?></a>
    </p>

    <p>Trân trọng,</p>
    <p>Ban quản lý KTX</p>
</body>
</html>

<?php /**PATH D:\laragon\www\hethongquanlyktxv1\resources\views/emails/nhac-no-hoa-don.blade.php ENDPATH**/ ?>