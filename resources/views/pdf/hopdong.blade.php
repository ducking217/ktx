<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Hợp đồng #{{ $hopdong->id }}</title>
    <style>
        body { font-family: 'DejaVu Sans', sans-serif; font-size: 13px; line-height: 1.8; }
        .header { text-align: center; margin-bottom: 40px; }
        .title { font-size: 22px; font-weight: bold; text-transform: uppercase; }
        .section { margin-bottom: 25px; }
        .section-title { font-weight: bold; text-decoration: underline; margin-bottom: 10px; }
        .content { text-align: justify; }
        .signature { margin-top: 60px; width: 100%; }
        .sig-box { width: 50%; float: left; text-align: center; }
        .clear { clear: both; }
    </style>
</head>
<body>
    <div class="header">
        <div>CỘNG HÒA XÃ HỘI CHỦ NGHĨA VIỆT NAM</div>
        <div style="font-weight: bold;">Độc lập - Tự do - Hạnh phúc</div>
        <hr style="width: 30%;">
        <br>
        <div class="title">HỢP ĐỒNG THUÊ PHÒNG KÝ TÚC XÁ</div>
        <div>Mã hợp đồng: #{{ $hopdong->id }}</div>
    </div>

    <div class="section">
        <div class="section-title">BÊN CHO THUÊ (BÊN A): BAN QUẢN LÝ KÝ TÚC XÁ</div>
        <p>Đại diện bởi: Giám đốc trung tâm quản lý KTX</p>
    </div>

    <div class="section">
        <div class="section-title">BÊN THUÊ (BÊN B): SINH VIÊN</div>
        <p>
            Họ và tên: <strong>{{ $hopdong->sinhvien->taikhoan->name ?? 'N/A' }}</strong><br>
            Mã sinh viên: {{ $hopdong->sinhvien->masinhvien ?? 'N/A' }}<br>
            Số CCCD: {{ $hopdong->sinhvien->so_cccd ?? '....................' }}<br>
            Số điện thoại: {{ $hopdong->sinhvien->sodienthoai ?? '....................' }}
        </p>
    </div>

    <div class="section">
        <div class="section-title">NỘI DUNG HỢP ĐỒNG</div>
        <div class="content">
            1. Bên A đồng ý cho bên B thuê 01 chỗ ở tại <strong>Phòng {{ $hopdong->phong->tenphong ?? 'N/A' }}</strong>.<br>
            2. Thời hạn thuê: Từ ngày {{ \Carbon\Carbon::parse($hopdong->ngay_bat_dau)->format('d/m/Y') }} đến ngày {{ \Carbon\Carbon::parse($hopdong->ngay_ket_thuc)->format('d/m/Y') }}.<br>
            3. Giá thuê phòng: {{ number_format($hopdong->giaphong_luc_ky) }} VNĐ/tháng (Chưa bao gồm điện, nước và phí dịch vụ).<br>
            4. Bên B có trách nhiệm tuân thủ nội quy Ký túc xá và thanh toán hóa đơn đúng hạn hàng tháng.
        </div>
    </div>

    <div class="signature">
        <div class="sig-box">
            <strong>ĐẠI DIỆN BÊN B</strong><br>
            (Ký và ghi rõ họ tên)
            <br><br><br><br>
            {{ $hopdong->sinhvien->taikhoan->name ?? '' }}
        </div>
        <div class="sig-box">
            <strong>ĐẠI DIỆN BÊN A</strong><br>
            (Ký tên và đóng dấu)
            <br><br><br><br>
            BAN QUẢN LÝ KTX
        </div>
        <div class="clear"></div>
    </div>
</body>
</html>
