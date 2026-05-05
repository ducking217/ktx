<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Hợp đồng {{ $hopdong->ma_hd ?? ('HD-' . str_pad((string) ($hopdong->id ?? 0), 6, '0', STR_PAD_LEFT)) }}</title>
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
    @php
        $maHopDong = $hopdong->ma_hd ?? ('HD-' . str_pad((string) ($hopdong->id ?? 0), 6, '0', STR_PAD_LEFT));
        $sinhvien = $hopdong->sinhvien;
        $user = $sinhvien?->user;

        $ngaySinh = $user?->dob;
        $ngaySinhHienThi = $ngaySinh?->format('d/m/Y') ?? '........';

        $soGiayTo = $user?->id_card ?? '................';
        $soDienThoai = $user?->phone ?? '................';
        $diaChi = $user?->address ?? null;
    @endphp

    <div class="header">
        <h2>CỘNG HÒA XÃ HỘI CHỦ NGHĨA VIỆT NAM</h2>
        <h3>Độc lập - Tự do - Hạnh phúc</h3>
        <hr style="width: 30%; margin: 10px auto;">
        <h1>HỢP ĐỒNG THUÊ CHỖ Ở NỘI TRÚ</h1>
        <p>Số: {{ $maHopDong }}</p>
    </div>

    <div class="terms">
        <p>Hôm nay, ngày {{ date('d') }} tháng {{ date('m') }} năm {{ date('Y') }}, chúng tôi gồm:</p>
        
        <div class="section-title">BÊN CHO THUÊ (BÊN A): BAN QUẢN LÝ KÝ TÚC XÁ</div>
        <p>Đại diện: Trưởng Ban quản lý Ký túc xá</p>

        <div class="section-title">BÊN THUÊ (BÊN B): SINH VIÊN</div>
        <table class="content-table">
            <tr>
                <td class="label">Họ và tên:</td>
                <td>
                    {{ $user?->name ?? '........' }}
                </td>
            </tr>
            <tr>
                <td class="label">Mã sinh viên:</td>
                <td>
                    {{ $sinhvien?->ma_sinh_vien ?? '........' }}
                </td>
            </tr>
            <tr>
                <td class="label">Ngày sinh:</td>
                <td>{{ $ngaySinhHienThi }}</td>
            </tr>
            <tr>
                <td class="label">Số CMND/CCCD:</td>
                <td>{{ $soGiayTo }}</td>
            </tr>
            <tr>
                <td class="label">Số điện thoại:</td>
                <td>{{ $soDienThoai }}</td>
            </tr>
            @if(is_string($diaChi) && trim($diaChi) !== '')
                <tr>
                    <td class="label">Địa chỉ:</td>
                    <td>{{ $diaChi }}</td>
                </tr>
            @endif
        </table>

        <div class="section-title">ĐIỀU 1: NỘI DUNG HỢP ĐỒNG</div>
        <p>Bên A đồng ý cho bên B thuê 01 chỗ ở nội trú tại:</p>
        <table class="content-table">
            <tr>
                <td class="label">Phòng:</td>
                <td>
                    {{ $hopdong->phong?->ten_phong ?? $hopdong->phong?->tenphong ?? '........' }}
                </td>
            </tr>
            <tr>
                <td class="label">Thời hạn thuê:</td>
                <td>
                    Từ ngày
                    @if($hopdong->ngay_bat_dau)
                        {{ date('d/m/Y', strtotime($hopdong->ngay_bat_dau)) }}
                    @else
                        ........
                    @endif
                    đến hết ngày
                    @if($hopdong->ngay_ket_thuc)
                        {{ date('d/m/Y', strtotime($hopdong->ngay_ket_thuc)) }}
                    @else
                        ........
                    @endif
                </td>
            </tr>
            <tr>
                <td class="label">Giá thuê:</td>
                <td>
                    @if(!is_null($hopdong->gia_thuc_te))
                        {{ number_format((int) $hopdong->gia_thuc_te) }} VNĐ/tháng
                    @elseif($hopdong->phong)
                        {{ number_format((int) $hopdong->phong->giaphong) }} VNĐ/tháng
                    @else
                        ........
                    @endif
                </td>
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
            <p>{{ $user?->name ?? '........' }}</p>
        </div>
        <div class="clear"></div>
    </div>
</body>
</html>
