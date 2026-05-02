<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Hợp đồng {{ $hopdong->ma_hd }}</title>
    <style>
        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 13px;
            line-height: 1.5;
            color: #333;
            margin: 0;
            padding: 30px;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .header h1 {
            margin: 0;
            font-size: 20px;
            text-transform: uppercase;
        }
        .header h2 {
            margin: 5px 0;
            font-size: 16px;
        }
        .section-title {
            font-weight: bold;
            text-decoration: underline;
            margin-top: 15px;
            margin-bottom: 10px;
            text-transform: uppercase;
        }
        .content-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }
        .content-table td {
            padding: 4px 0;
            vertical-align: top;
        }
        .content-table td.label {
            width: 180px;
            font-weight: bold;
        }
        .terms {
            text-align: justify;
            margin-top: 15px;
        }
        .signature-section {
            margin-top: 40px;
            width: 100%;
        }
        .signature-box {
            width: 45%;
            float: left;
            text-align: center;
        }
        .signature-box.right {
            float: right;
        }
        .clear {
            clear: both;
        }
    </style>
</head>
<body>
    <div class="header">
        <h2>CỘNG HÒA XÃ HỘI CHỦ NGHĨA VIỆT NAM</h2>
        <h3>Độc lập - Tự do - Hạnh phúc</h3>
        <hr style="width: 30%; margin: 10px auto;">
        <h1>HỢP ĐỒNG THUÊ CHỖ Ở NỘI TRÚ</h1>
        <p>Số: {{ $hopdong->ma_hd }}</p>
    </div>

    <div class="terms">
        <p>Hôm nay, ngày {{ date('d') }} tháng {{ date('m') }} năm {{ date('Y') }}, chúng tôi gồm:</p>
        
        <div class="section-title">BÊN CHO THUÊ (BÊN A): BAN QUẢN LÝ KÝ TÚC XÁ</div>
        <p>Đại diện: Trưởng Ban quản lý Ký túc xá</p>

        <div class="section-title">BÊN THUÊ (BÊN B): SINH VIÊN</div>
        <table class="content-table">
            <tr>
                <td class="label">Họ và tên:</td>
                <td>{{ $hopdong->sinhvien->hovaten }}</td>
            </tr>
            <tr>
                <td class="label">Mã sinh viên:</td>
                <td>{{ $hopdong->sinhvien->masv }}</td>
            </tr>
            <tr>
                <td class="label">Ngày sinh:</td>
                <td>{{ $hopdong->sinhvien->ngaysinh ? date('d/m/Y', strtotime($hopdong->sinhvien->ngaysinh)) : '........' }}</td>
            </tr>
            <tr>
                <td class="label">Số CMND/CCCD:</td>
                <td>{{ $hopdong->sinhvien->cccd ?? '................' }}</td>
            </tr>
            <tr>
                <td class="label">Số điện thoại:</td>
                <td>{{ $hopdong->sinhvien->sdt ?? '................' }}</td>
            </tr>
        </table>

        <div class="section-title">ĐIỀU 1: NỘI DUNG HỢP ĐỒNG</div>
        <p>Bên A đồng ý cho bên B thuê 01 chỗ ở nội trú tại:</p>
        <table class="content-table">
            <tr>
                <td class="label">Phòng:</td>
                <td>{{ $hopdong->phong->tenphong }}</td>
            </tr>
            <tr>
                <td class="label">Thời hạn thuê:</td>
                <td>Từ ngày {{ date('d/m/Y', strtotime($hopdong->ngaybatdau)) }} đến hết ngày {{ date('d/m/Y', strtotime($hopdong->ngayketthuc)) }}</td>
            </tr>
            <tr>
                <td class="label">Giá thuê:</td>
                <td>{{ number_format($hopdong->phong->giaphong) }} VNĐ/tháng</td>
            </tr>
            <tr>
                <td class="label">Tiền đặt cọc:</td>
                <td>{{ number_format($hopdong->tiencoc) }} VNĐ</td>
            </tr>
        </table>

        <div class="section-title">ĐIỀU 2: QUYỀN VÀ NGHĨA VỤ CỦA CÁC BÊN</div>
        <p>1. Bên B có trách nhiệm thanh toán đầy đủ tiền thuê phòng, tiền điện, nước và các dịch vụ khác theo quy định.</p>
        <p>2. Bên B phải chấp hành nghiêm chỉnh nội quy, quy định của Ký túc xá và pháp luật Nhà nước.</p>
        <p>3. Bên A có trách nhiệm đảm bảo các điều kiện về cơ sở vật chất và an ninh trật tự cho Bên B.</p>

        <div class="section-title">ĐIỀU 3: ĐIỀU KHOẢN CHUNG</div>
        <p>Hợp đồng này có giá trị kể từ ngày ký. Hai bên cam kết thực hiện đúng các điều khoản đã ghi trong hợp đồng. Hợp đồng được lập thành 02 bản có giá trị pháp lý như nhau, mỗi bên giữ 01 bản.</p>
    </div>

    <div class="signature-section">
        <div class="signature-box">
            <p style="font-weight: bold;">ĐẠI DIỆN BÊN A</p>
            <br><br><br><br>
            <p>(Ký và ghi rõ họ tên)</p>
        </div>
        <div class="signature-box right">
            <p style="font-weight: bold;">ĐẠI DIỆN BÊN B</p>
            <br><br><br><br>
            <p>{{ $hopdong->sinhvien->hovaten }}</p>
        </div>
        <div class="clear"></div>
    </div>
</body>
</html>
