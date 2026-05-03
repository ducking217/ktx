<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Hóa đơn {{ $hoadon->ma_hd }}</title>
    <style>
        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 14px;
            line-height: 1.6;
            color: #333;
            margin: 0;
            padding: 40px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
        }
        .header h1 {
            margin: 0;
            text-transform: uppercase;
            color: #1a1a1a;
        }
        .info-section {
            margin-bottom: 30px;
        }
        .info-table {
            width: 100%;
            border-collapse: collapse;
        }
        .info-table td {
            padding: 5px 0;
        }
        .info-table td.label {
            font-weight: bold;
            width: 150px;
        }
        .details-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        .details-table th, .details-table td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }
        .details-table th {
            background-color: #f8f9fa;
            font-weight: bold;
        }
        .total-section {
            margin-top: 20px;
            text-align: right;
            font-size: 18px;
            font-weight: bold;
        }
        .footer {
            margin-top: 50px;
            text-align: right;
        }
        .footer p {
            margin: 5px 0;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Hóa đơn thanh toán</h1>
        <p>Mã hóa đơn: {{ $hoadon->ma_hd }}</p>
    </div>

    <div class="info-section">
        <table class="info-table">
            <tr>
                <td class="label">Sinh viên:</td>
                <td>
                    @isset($hoadon->sinhvien->taikhoan)
                        {{ $hoadon->sinhvien->taikhoan->name }}
                    @else
                        ........
                    @endisset
                    @isset($hoadon->sinhvien)
                        ({{ $hoadon->sinhvien->masinhvien ?? '........' }})
                    @else
                        (........)
                    @endisset
                </td>
            </tr>
            <tr>
                <td class="label">Phòng:</td>
                <td>
                    @isset($hoadon->phong)
                        {{ $hoadon->phong->tenphong }}
                    @else
                        ........
                    @endisset
                </td>
            </tr>
            <tr>
                <td class="label">Kỳ thanh toán:</td>
                <td>Tháng {{ $hoadon->thang }}/{{ $hoadon->nam }}</td>
            </tr>
            <tr>
                <td class="label">Ngày phát hành:</td>
                <td>{{ $hoadon->created_at->format('d/m/Y') }}</td>
            </tr>
        </table>
    </div>

    <table class="details-table">
        <thead>
            <tr>
                <th>Hạng mục</th>
                <th>Số tiền (VNĐ)</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Tiền phòng</td>
                <td>{{ number_format($hoadon->tienphong) }}</td>
            </tr>
            <tr>
                <td>Tiền điện</td>
                <td>{{ number_format($hoadon->tiendien) }}</td>
            </tr>
            <tr>
                <td>Tiền nước</td>
                <td>{{ number_format($hoadon->tiennuoc) }}</td>
            </tr>
            @if($hoadon->phidichvu > 0)
            <tr>
                <td>Tiền dịch vụ</td>
                <td>{{ number_format($hoadon->phidichvu) }}</td>
            </tr>
            @endif
            @if($hoadon->tienphat > 0)
            <tr>
                <td>Tiền phạt/Bồi thường</td>
                <td>{{ number_format($hoadon->tienphat) }}</td>
            </tr>
            @endif
        </tbody>
    </table>

    <div class="total-section">
        Tổng cộng: {{ number_format($hoadon->tongtien) }} VNĐ
    </div>

    <div class="footer">
        <p>Ngày .... tháng .... năm ....</p>
        <p style="font-weight: bold; padding-right: 50px;">Người lập phiếu</p>
        <br><br><br>
        <p style="padding-right: 40px;">(Ký và ghi rõ họ tên)</p>
    </div>
</body>
</html>
