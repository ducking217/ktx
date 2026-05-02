<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Hóa đơn #{{ $hoadon->id }}</title>
    <style>
        body { font-family: 'DejaVu Sans', sans-serif; font-size: 12px; line-height: 1.6; }
        .header { text-align: center; margin-bottom: 30px; }
        .title { font-size: 20px; font-weight: bold; text-transform: uppercase; }
        .section { margin-bottom: 20px; }
        .section-title { font-weight: bold; border-bottom: 1px solid #000; margin-bottom: 10px; }
        table { border-collapse: collapse; margin-bottom: 20px; width: 100%; }
        th, td { border: 1px solid #ccc; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        .total { font-size: 16px; font-weight: bold; text-align: right; margin-top: 20px; }
        .footer { text-align: right; margin-top: 50px; font-style: italic; }
    </style>
</head>
<body>
    <div class="header">
        <div class="title">Hóa đơn Tiền điện, Nước & Phòng</div>
        <div>Kỳ quyết toán: Tháng {{ $hoadon->thang }}/{{ $hoadon->nam }}</div>
        <div>Mã hóa đơn: #{{ $hoadon->id }}</div>
    </div>

    <div class="section">
        <div class="section-title">Thông tin khách hàng</div>
        <p>
            <strong>Sinh viên:</strong> {{ $hoadon->sinhvien->taikhoan->name ?? 'N/A' }}<br>
            <strong>Mã sinh viên:</strong> {{ $hoadon->sinhvien->masinhvien ?? 'N/A' }}<br>
            <strong>Phòng:</strong> {{ $hoadon->phong->tenphong ?? 'N/A' }}
        </p>
    </div>

    <div class="section">
        <div class="section-title">Chi tiết tiêu thụ</div>
        <table>
            <thead>
                <tr>
                    <th>Loại</th>
                    <th>Chỉ số cũ</th>
                    <th>Chỉ số mới</th>
                    <th>Tiêu thụ</th>
                    <th>Đơn giá</th>
                    <th>Thành tiền</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Điện (kWh)</td>
                    <td>{{ $hoadon->chisodiencu }}</td>
                    <td>{{ $hoadon->chisodienmoi }}</td>
                    <td>{{ $hoadon->chisodienmoi - $hoadon->chisodiencu }}</td>
                    <td>{{ number_format($dongiadien) }}đ</td>
                    <td>{{ number_format($hoadon->tiendien) }}đ</td>
                </tr>
                <tr>
                    <td>Nước (m³)</td>
                    <td>{{ $hoadon->chisonuoccu }}</td>
                    <td>{{ $hoadon->chisonuocmoi }}</td>
                    <td>{{ $hoadon->chisonuocmoi - $hoadon->chisonuoccu }}</td>
                    <td>{{ number_format($dongianuoc) }}đ</td>
                    <td>{{ number_format($hoadon->tiennuoc) }}đ</td>
                </tr>
                <tr>
                    <td colspan="5">Tiền phòng cơ bản</td>
                    <td>{{ number_format($hoadon->tienphong) }}đ</td>
                </tr>
                <tr>
                    <td colspan="5">Phí dịch vụ</td>
                    <td>{{ number_format($hoadon->phidichvu ?? 0) }}đ</td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="total">
        Tổng cộng: {{ number_format($hoadon->tongtien) }} VNĐ
    </div>

    <div class="section">
        <p><strong>Trạng thái:</strong> {{ $hoadon->trangthaithanhtoan }}</p>
        <p><strong>Ngày xuất:</strong> {{ \Carbon\Carbon::parse($hoadon->ngayxuat)->format('d/m/Y') }}</p>
    </div>

    <div class="footer">
        Ban Quản lý Ký túc xá<br>
        (Đã ký điện tử)
    </div>
</body>
</html>
