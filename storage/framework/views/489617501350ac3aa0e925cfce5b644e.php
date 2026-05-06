<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Hóa đơn <?php echo e($hoadon->ma_hoa_don ?? $hoadon->id); ?></title>
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
        <p>Mã hóa đơn: <?php echo e($hoadon->ma_hoa_don ?? $hoadon->id); ?></p>
    </div>

    <?php
        $tenSinhVien = $hoadon->hopdong?->sinhvien?->user?->name ?? '........';
        $maSinhVien = $hoadon->hopdong?->sinhvien?->ma_sinh_vien ?? '........';
        $tenPhong = $hoadon->phong?->ten_phong ?? $hoadon->hopdong?->giuong?->phong?->ten_phong ?? '........';
        $giaoDichChoXacNhan = $hoadon->trang_thai === \App\Enums\InvoiceStatus::PendingConfirmation
            ? $hoadon->giao_dich_gan_nhat
            : null;
        $ky = null;
        if (is_string($hoadon->ghi_chu) && preg_match('/Ky\s+(\d{1,2}\/\d{4})/u', $hoadon->ghi_chu, $m)) {
            $ky = $m[1];
        }
        $kyHienThi = $ky
            ?? ($hoadon->ngay_thanh_toan?->format('m/Y') ?? $hoadon->created_at?->format('m/Y'))
            ?? '........';
    ?>

    <div class="info-section">
        <table class="info-table">
            <tr>
                <td class="label">Sinh viên:</td>
                <td>
                    <?php echo e($tenSinhVien); ?> (<?php echo e($maSinhVien); ?>)
                </td>
            </tr>
            <tr>
                <td class="label">Phòng:</td>
                <td>
                    <?php echo e($tenPhong); ?>

                </td>
            </tr>
            <tr>
                <td class="label">Tháng thanh toán:</td>
                <td><?php echo e($kyHienThi); ?></td>
            </tr>
            <tr>
                <td class="label">Ngày phát hành:</td>
                <td><?php echo e($hoadon->created_at->format('d/m/Y')); ?></td>
            </tr>
            <?php if($giaoDichChoXacNhan): ?>
            <tr>
                <td class="label">Mã giao dịch:</td>
                <td><?php echo e($giaoDichChoXacNhan->ma_giao_dich ?? '........'); ?></td>
            </tr>
            <tr>
                <td class="label">Ghi chú chuyển khoản:</td>
                <td><?php echo e($giaoDichChoXacNhan->ghi_chu ? preg_replace('/\bKy\s+/u', 'Tháng ', (string) $giaoDichChoXacNhan->ghi_chu) : '........'); ?></td>
            </tr>
            <tr>
                <td class="label">Ngày giao dịch:</td>
                <td><?php echo e($giaoDichChoXacNhan->ngay_giao_dich?->format('d/m/Y H:i') ?? '........'); ?></td>
            </tr>
            <?php endif; ?>
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
                <td><?php echo e(number_format((int) $hoadon->tien_phong)); ?></td>
            </tr>
            <tr>
                <td>Tiền điện</td>
                <td><?php echo e(number_format((int) $hoadon->tien_dien)); ?></td>
            </tr>
            <tr>
                <td>Tiền nước</td>
                <td><?php echo e(number_format((int) $hoadon->tien_nuoc)); ?></td>
            </tr>
            <?php if((int) $hoadon->phi_dich_vu > 0): ?>
            <tr>
                <td>Tiền dịch vụ</td>
                <td><?php echo e(number_format((int) $hoadon->phi_dich_vu)); ?></td>
            </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <div class="total-section">
        Tổng cộng: <?php echo e(number_format((int) $hoadon->tong_tien)); ?> VNĐ
    </div>

    <div class="footer">
        <p>Ngày .... tháng .... năm ....</p>
        <p style="font-weight: bold; padding-right: 50px;">Người lập phiếu</p>
        <br><br><br>
        <p style="padding-right: 40px;">(Ký và ghi rõ họ tên)</p>
    </div>
</body>
</html>
<?php /**PATH D:\laragon\www\hethongquanlyktxv1\resources\views/pdf/hoadon.blade.php ENDPATH**/ ?>