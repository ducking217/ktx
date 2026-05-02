<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Đăng nhập Ký túc xá</title>
    <style>
        body { font-family: sans-serif; line-height: 1.6; color: #333; max-width: 600px; margin: 0 auto; padding: 20px; }
        .button { display: inline-block; padding: 10px 20px; background-color: #10b981; color: #fff; text-decoration: none; border-radius: 5px; font-weight: bold; margin-top: 20px; }
        .footer { margin-top: 30px; font-size: 12px; color: #666; }
    </style>
</head>
<body>
    <h2>Chào {{ $user->name }},</h2>
    <p>Chúc mừng bạn đã hoàn tất đăng ký và thanh toán phí nội trú tại Ký túc xá.</p>
    <p>Tài khoản của bạn đã được khởi tạo thành công. Bạn có thể nhấn vào nút bên dưới để đăng nhập trực tiếp vào hệ thống mà không cần mật khẩu:</p>
    
    <a href="{{ $url }}" class="button">Đăng nhập ngay</a>
    
    <p>Link này sẽ hết hạn sau 72 giờ.</p>
    
    <div class="footer">
        <p>Đây là email tự động, vui lòng không phản hồi.</p>
        <p>&copy; {{ date('Y') }} Ban Quản lý Ký túc xá.</p>
    </div>
</body>
</html>
