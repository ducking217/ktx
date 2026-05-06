<?php $__env->startSection('noidung'); ?>
    <?php
        $activeTab = (string) ($activeTab ?? request()->query('tab', 'can-thanh-toan'));
        $tabs = $tabs ?? [
            'can_thanh_toan' => (int) ($thongKe['chua_thanh_toan'] ?? 0),
            'cho_xac_nhan' => (int) ($thongKe['cho_xac_nhan'] ?? 0),
            'lich_su' => (int) ($thongKe['da_thanh_toan'] ?? 0),
        ];
    ?>

    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between mb-6">
        <div class="flex items-center gap-3">
            <a href="<?php echo e(route('student.phongcuatoi')); ?>" class="saas-btn-ghost h-9 px-3 text-xs">
                <svg class="mr-1 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
                </svg>
                Phòng của tôi
            </a>
            <div>
                <div class="text-lg font-semibold text-slate-900">Hóa đơn</div>
                <div class="text-xs text-slate-500">Chọn một tab để xem đúng phần bạn cần xử lý.</div>
            </div>
        </div>

        <nav class="flex items-center gap-1 p-1 rounded-xl bg-slate-100/80 w-fit" aria-label="Bộ lọc hóa đơn">
            <?php
                $tabItems = [
                    'can-thanh-toan' => ['label' => 'Cần thanh toán', 'count' => (int) ($tabs['can_thanh_toan'] ?? 0)],
                    'cho-xac-nhan' => ['label' => 'Chờ xác nhận', 'count' => (int) ($tabs['cho_xac_nhan'] ?? 0)],
                    'lich-su' => ['label' => 'Lịch sử', 'count' => (int) ($tabs['lich_su'] ?? 0)],
                ];
            ?>
            <?php $__currentLoopData = $tabItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tabValue => $tab): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php
                    $isActive = $activeTab === $tabValue;
                    $href = request()->fullUrlWithQuery(['tab' => $tabValue, 'page' => 1]);
                ?>
                <a
                    href="<?php echo e($href); ?>"
                    class="px-4 py-1.5 rounded-lg text-xs font-bold transition-all <?php echo e($isActive ? 'bg-white text-slate-900 shadow-sm' : 'text-slate-500 hover:text-slate-900'); ?>"
                    aria-current="<?php echo e($isActive ? 'page' : 'false'); ?>"
                >
                    <?php echo e($tab['label']); ?>

                    <span class="ml-2 inline-flex min-w-[20px] items-center justify-center rounded-full bg-slate-200/70 px-1.5 py-0.5 text-[10px] font-bold text-slate-700 tabular-nums">
                        <?php echo e($tab['count']); ?>

                    </span>
                </a>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </nav>
    </div>

    <div class="grid grid-cols-1 gap-4 sm:grid-cols-3 mb-6">
        <div class="saas-card p-4">
            <div class="text-xs font-semibold text-slate-500">Cần thanh toán</div>
            <div class="mt-1 text-2xl font-semibold text-slate-900 tabular-nums"><?php echo e((int) ($tabs['can_thanh_toan'] ?? 0)); ?></div>
        </div>
        <div class="saas-card p-4">
            <div class="text-xs font-semibold text-slate-500">Chờ xác nhận</div>
            <div class="mt-1 text-2xl font-semibold text-slate-900 tabular-nums"><?php echo e((int) ($tabs['cho_xac_nhan'] ?? 0)); ?></div>
        </div>
        <div class="saas-card p-4">
            <div class="text-xs font-semibold text-slate-500">Đã thanh toán</div>
            <div class="mt-1 text-2xl font-semibold text-slate-900 tabular-nums"><?php echo e((int) ($tabs['lich_su'] ?? 0)); ?></div>
        </div>
    </div>

    <div class="saas-table-container">
        <div class="overflow-x-auto">
            <table class="saas-table">
                <thead>
                    <tr>
                        <th>Hóa đơn</th>
                        <th class="text-right">Số tiền</th>
                        <th class="text-center">Trạng thái</th>
                        <th>Hạn thanh toán</th>
                        <th>Ngày tạo</th>
                        <th class="text-right">Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $hoadon; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <?php
                            $loai = (string) ($item->loai_hoadon ?? '');
                            $isRefund = $loai === 'refund';
                            $isDeposit = $loai === 'deposit';
                            $isExtra = $loai === 'extra';
                            $ky = null;
                            if (is_string($item->ghi_chu) && preg_match('/Ky\s+(\d{1,2}\/\d{4})/u', $item->ghi_chu, $m)) {
                                $ky = $m[1];
                            }
                            $kyHienThi = $ky
                                ?? ($item->ngay_thanh_toan?->format('m/Y') ?? $item->created_at?->format('m/Y'))
                                ?? 'Chưa có';
                            $tenLoai = $isRefund ? 'Hoàn cọc' : ($isDeposit ? 'Tiền cọc' : ($isExtra ? 'Phát sinh' : 'Hóa đơn tháng'));

                            $statusInvoice = $item->trang_thai;
                            $statusBadge = match($statusInvoice) {
                                \App\Enums\InvoiceStatus::Paid => 'saas-badge-success',
                                \App\Enums\InvoiceStatus::PendingConfirmation => 'saas-badge-info',
                                \App\Enums\InvoiceStatus::Overdue => 'saas-badge-error',
                                default => $isRefund ? 'saas-badge-info' : 'saas-badge-warning',
                            };
                            $maHoaDon = $item->ma_hoa_don ?: ('HD-' . str_pad((string) $item->id, 6, '0', STR_PAD_LEFT));
                        ?>
                        <tr>
                            <td>
                                <div class="font-semibold text-slate-900 tabular-nums"><?php echo e($maHoaDon); ?></div>
                                <div class="mt-0.5 text-xs text-slate-500"><?php echo e($tenLoai); ?> • <?php echo e($kyHienThi); ?></div>
                            </td>
                            <td class="text-right">
                                <div class="font-semibold text-slate-900 tabular-nums"><?php echo e(number_format((int) $item->tong_tien)); ?> đ</div>
                            </td>
                            <td class="text-center">
                                <span class="saas-badge <?php echo e($statusBadge); ?>"><?php echo e($statusInvoice->label()); ?></span>
                            </td>
                            <td class="text-slate-600">
                                <div class="tabular-nums"><?php echo e($item->ngay_het_han?->format('d/m/Y') ?? '—'); ?></div>
                            </td>
                            <td class="text-slate-600">
                                <div class="tabular-nums"><?php echo e($item->created_at?->format('d/m/Y') ?? '—'); ?></div>
                            </td>
                            <td class="text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="<?php echo e(route('student.phongcuatoi.hoadon.chitiet', $item->id)); ?>" class="saas-btn-secondary h-9 px-3 text-xs font-semibold">
                                        Xem
                                    </a>
                                    <?php if(!$isRefund && in_array($item->trang_thai, [\App\Enums\InvoiceStatus::Unpaid, \App\Enums\InvoiceStatus::Overdue], true)): ?>
                                        <a href="<?php echo e(route('student.phongcuatoi.hoadon.chitiet', $item->id)); ?>#huong-dan-thanh-toan" class="saas-btn-primary h-9 px-3 text-xs font-semibold">
                                            Thanh toán
                                        </a>
                                    <?php endif; ?>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="6" class="py-16 text-center text-slate-500">
                                Không có hóa đơn trong tab này.
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <div class="px-4 py-4 border-t border-slate-200">
            <?php echo e($hoadon->links()); ?>

        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('student.layouts.chinh', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\laragon\www\hethongquanlyktxv1\resources\views/student/phongcuatoi/lichSuHoaDon.blade.php ENDPATH**/ ?>