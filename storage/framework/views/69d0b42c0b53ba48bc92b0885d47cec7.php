<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Dang ky phong da duoc duyet</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #0f172a;">
    <h2>Thong bao duyet dang ky phong</h2>

    <p>Chao <?php echo e($userName ?? 'ban'); ?>,</p>
    <p>Don dang ky phong cua ban da duoc duyet.</p>

    <div style="background: #f0f7ff; padding: 20px; border-radius: 8px; margin: 20px 0; border: 1px solid #d0e7ff;">
        <h4 style="margin-top: 0; color: #00A86B;">Yeu cau thanh toan</h4>
        <p>He thong da tao hoa don <strong>Tien coc</strong> va <strong>Tien phong thang nay</strong>.</p>
        <p>Vui long dang nhap vao he thong de xem chi tiet hoa don va thuc hien thanh toan de hoan tat thu tuc nhan phong.</p>
    </div>

    <p><strong>Thong tin cho o</strong></p>
    <ul>
        <li>Phong: <?php echo e($tenPhong); ?></li>
        <li>Giuong: <?php echo e($maGiuong); ?></li>
        <li>Ngay bat dau: <?php echo e($ngayBatDau); ?></li>
        <li>Ngay ket thuc: <?php echo e($ngayKetThuc); ?></li>
    </ul>

    <p>Ban vui long dang nhap he thong de xem chi tiet hop dong va hoa don.</p>
</body>
</html>
<?php /**PATH D:\laragon\www\hethongquanlyktxv1\resources\views/emails/dangky-da-duyet.blade.php ENDPATH**/ ?>