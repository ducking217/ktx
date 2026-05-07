<?php $__env->startSection('student_page_title', 'Hóa đơn'); ?>

<?php $__env->startSection('noidung'); ?>
    <?php
        $activeTab = (string) ($activeTab ?? request()->query('tab', 'can-thanh-toan'));
        $tabs = $tabs ?? [
            'can_thanh_toan' => (int) ($thongKe['chua_thanh_toan'] ?? 0),
            'cho_xac_nhan' => (int) ($thongKe['cho_xac_nhan'] ?? 0),
            'lich_su' => (int) ($thongKe['da_thanh_toan'] ?? 0),
        ];
    ?>

    <div class="space-y-6">
        <?php if (isset($component)) { $__componentOriginalcb19cb35a534439097b02b8af91726ee = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalcb19cb35a534439097b02b8af91726ee = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.page-header','data' => ['title' => 'Hóa đơn','subtitle' => 'Theo dõi các khoản cần thanh toán, giao dịch đang chờ đối soát và lịch sử thu.']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('admin.page-header'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Hóa đơn','subtitle' => 'Theo dõi các khoản cần thanh toán, giao dịch đang chờ đối soát và lịch sử thu.']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalcb19cb35a534439097b02b8af91726ee)): ?>
<?php $attributes = $__attributesOriginalcb19cb35a534439097b02b8af91726ee; ?>
<?php unset($__attributesOriginalcb19cb35a534439097b02b8af91726ee); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalcb19cb35a534439097b02b8af91726ee)): ?>
<?php $component = $__componentOriginalcb19cb35a534439097b02b8af91726ee; ?>
<?php unset($__componentOriginalcb19cb35a534439097b02b8af91726ee); ?>
<?php endif; ?>

        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <div class="text-sm font-semibold text-slate-900">Bộ lọc theo luồng xử lý</div>
                <div class="mt-0.5 text-xs text-slate-500">Chọn tab để xem đúng phần bạn cần.</div>
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

        <?php if (isset($component)) { $__componentOriginaldf54224cf245156c316d9d3b07da8b50 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginaldf54224cf245156c316d9d3b07da8b50 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.table-card','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('admin.table-card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
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

                        $invoiceType = $loai;
                        $statusInvoice = $item->trang_thai;
                        $statusBadge = $statusInvoice->badgeClass($invoiceType);
                        $statusLabel = $statusInvoice->displayLabel($invoiceType);
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
                            <span class="saas-badge <?php echo e($statusBadge); ?>"><?php echo e($statusLabel); ?></span>
                            <?php if(!$isRefund && in_array($item->trang_thai, [\App\Enums\InvoiceStatus::Unpaid, \App\Enums\InvoiceStatus::Overdue], true) && $item->giao_dich_tu_choi_gan_nhat): ?>
                                <?php
                                    $lyDoTuChoi = trim((string) ($item->giao_dich_tu_choi_gan_nhat->ghi_chu ?? ''));
                                    if (preg_match('/Từ chối:\s*(.+)$/u', $lyDoTuChoi, $m)) {
                                        $lyDoTuChoi = trim((string) $m[1]);
                                    }
                                    $lyDoTuChoi = $lyDoTuChoi !== '' ? $lyDoTuChoi : 'Giao dịch chưa khớp. Vui lòng kiểm tra lại và gửi lại yêu cầu.';
                                ?>
                                <div class="mt-1 text-[10px] font-semibold text-rose-600 leading-snug">
                                    Bị từ chối: <?php echo e(\Illuminate\Support\Str::limit($lyDoTuChoi, 80)); ?>

                                </div>
                            <?php endif; ?>
                        </td>
                        <td class="text-slate-600">
                            <div class="tabular-nums"><?php echo e($item->ngay_het_han?->format('d/m/Y') ?? '—'); ?></div>
                        </td>
                        <td class="text-slate-600">
                            <div class="tabular-nums"><?php echo e($item->created_at?->format('d/m/Y') ?? '—'); ?></div>
                        </td>
                        <td class="text-right">
                            <div class="flex items-center justify-end gap-2">
                                <a href="<?php echo e(route('student.hoadon.chitiet', $item->id)); ?>" class="saas-btn-secondary h-9 px-3 text-xs font-semibold">
                                    Xem
                                </a>
                                <?php if(!$isRefund && in_array($item->trang_thai, [\App\Enums\InvoiceStatus::Unpaid, \App\Enums\InvoiceStatus::Overdue], true)): ?>
                                    <a href="<?php echo e(route('student.hoadon.chitiet', $item->id)); ?>#huong-dan-thanh-toan" class="saas-btn-primary h-9 px-3 text-xs font-semibold">
                                        Thanh toán
                                    </a>
                                <?php endif; ?>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="6" class="py-24 text-center">
                            <?php if (isset($component)) { $__componentOriginal074a021b9d42f490272b5eefda63257c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal074a021b9d42f490272b5eefda63257c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.empty-state','data' => ['title' => 'Chưa có hóa đơn','description' => 'Không có dữ liệu trong tab hiện tại.']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('empty-state'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Chưa có hóa đơn','description' => 'Không có dữ liệu trong tab hiện tại.']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal074a021b9d42f490272b5eefda63257c)): ?>
<?php $attributes = $__attributesOriginal074a021b9d42f490272b5eefda63257c; ?>
<?php unset($__attributesOriginal074a021b9d42f490272b5eefda63257c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal074a021b9d42f490272b5eefda63257c)): ?>
<?php $component = $__componentOriginal074a021b9d42f490272b5eefda63257c; ?>
<?php unset($__componentOriginal074a021b9d42f490272b5eefda63257c); ?>
<?php endif; ?>
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
         <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginaldf54224cf245156c316d9d3b07da8b50)): ?>
<?php $attributes = $__attributesOriginaldf54224cf245156c316d9d3b07da8b50; ?>
<?php unset($__attributesOriginaldf54224cf245156c316d9d3b07da8b50); ?>
<?php endif; ?>
<?php if (isset($__componentOriginaldf54224cf245156c316d9d3b07da8b50)): ?>
<?php $component = $__componentOriginaldf54224cf245156c316d9d3b07da8b50; ?>
<?php unset($__componentOriginaldf54224cf245156c316d9d3b07da8b50); ?>
<?php endif; ?>

        <?php if(method_exists($hoadon, 'links') && $hoadon->hasPages()): ?>
            <div class="mt-6">
                <?php echo e($hoadon->links()); ?>

            </div>
        <?php endif; ?>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('student.layouts.chinh', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\laragon\www\hethongquanlyktxv1\resources\views/student/phongcuatoi/lichSuHoaDon.blade.php ENDPATH**/ ?>