<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; border: 1px solid #eee; border-radius: 10px; }
        .header { text-align: center; margin-bottom: 30px; }
        .info-box { background: #f0f7ff; padding: 20px; border-radius: 8px; margin: 20px 0; border: 1px solid #d0e7ff; }
        .btn { display: inline-block; padding: 12px 24px; background-color: #00A86B; color: #fff; text-decoration: none; border-radius: 6px; font-weight: bold; }
        .footer { margin-top: 30px; font-size: 12px; color: #777; text-align: center; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2 style="color: #00A86B;">Chúc mừng bạn!</h2>
        </div>
        <p>Chào <?php echo e($dangky->ho_ten); ?>,</p>
        <p>Hồ sơ đăng ký phòng của bạn tại <strong><?php echo e($dangky->phong?->tenphong ?? 'Chưa xác định'); ?></strong> đã được Ban quản lý phê duyệt bước 1.</p>
        <p>Để hoàn tất việc giữ chỗ và được cấp phòng chính thức, vui lòng thực hiện thanh toán phí thế chân (tiền cọc):</p>
        
        <div class="info-box">
            <h4 style="margin-top: 0;">Thông tin thanh toán:</h4>
            <p><strong>Số tiền:</strong> <?php echo e(number_format($soTien ?? 0, 0, ',', '.')); ?> VNĐ</p>
            <p><strong>Ngân hàng:</strong> VietinBank</p>
            <p><strong>Số tài khoản:</strong> 123456789</p>
            <p><strong>Chủ tài khoản:</strong> BAN QUAN LY KTX ABC</p>
            <p><strong>Nội dung CK:</strong> KTX <?php echo e($dangky->id); ?> <?php echo e($dangky->so_dien_thoai); ?></p>
        </div>

        <p>Hạn chót thanh toán: <strong><?php echo e($dangky->token_expires_at?->format('d/m/Y H:i') ?? 'Chưa có'); ?></strong></p>
        <p>Sau khi thanh toán thành công, Ban quản lý sẽ xác nhận, cấp phòng và gửi liên kết đăng nhập cho bạn qua thư này.</p>
        
        <div style="text-align: center; margin: 30px 0;">
            <a href="<?php echo e(route('guest.lookup', ['token' => $dangky->lookup_token])); ?>" class="btn">Xem chi tiết đơn</a>
        </div>

        <div class="footer">
            &copy; <?php echo e(date('Y')); ?> KTX Đại học ABC. Mọi quyền được bảo lưu.
        </div>
    </div>
</body>
</html>
<?php /**PATH D:\laragon\www\hethongquanlyktxv1\resources\views/emails/payment-request.blade.php ENDPATH**/ ?>