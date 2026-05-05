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
        <strong><?php echo e($yeuCauGiaHan->trang_thai?->label() ?? '---'); ?></strong>
    </p>

    <p style="margin: 0 0 6px 0;"><strong>Thông tin yêu cầu</strong></p>
    <ul style="margin: 0; padding-left: 18px;">
        <li>Mã yêu cầu: <?php echo e($yeuCauGiaHan->id); ?></li>
        <li>Mã hợp đồng: <?php echo e($yeuCauGiaHan->hopdong?->ma_hd ?? '---'); ?></li>
        <li>Ngày kết thúc mới đề xuất: <?php echo e($yeuCauGiaHan->ngay_ket_thuc_moi ? \Illuminate\Support\Carbon::parse($yeuCauGiaHan->ngay_ket_thuc_moi)->format('d/m/Y') : '---'); ?></li>
        <li>Ghi chú admin: <?php echo e($yeuCauGiaHan->ghi_chu_admin ?? '---'); ?></li>
    </ul>

    <p>
        Đăng nhập để xem chi tiết:
        <a href="<?php echo e($loginUrl); ?>"><?php echo e($loginUrl); ?></a>
    </p>

    <p>Trân trọng,</p>
    <p>Ban quản lý KTX</p>
</body>
</html>

<?php /**PATH D:\laragon\www\hethongquanlyktxv1\resources\views/emails/ket-qua-gia-han-hop-dong.blade.php ENDPATH**/ ?>