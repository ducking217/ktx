<?php if (isset($component)) { $__componentOriginal91fdd17964e43374ae18c674f95cdaa3 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal91fdd17964e43374ae18c674f95cdaa3 = $attributes; } ?>
<?php $component = App\View\Components\AdminLayout::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('admin-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(App\View\Components\AdminLayout::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
     <?php $__env->slot('title', null, []); ?> Quản lý Hóa đơn & Tài chính <?php $__env->endSlot(); ?>

    <div class="space-y-6">
        <?php if (isset($component)) { $__componentOriginalcb19cb35a534439097b02b8af91726ee = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalcb19cb35a534439097b02b8af91726ee = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.page-header','data' => ['title' => 'Hóa đơn & Tài chính','subtitle' => 'Giám sát dòng tiền cư trú, chỉ số tiện ích và quản lý lịch sử giao dịch toàn diện.']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('admin.page-header'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Hóa đơn & Tài chính','subtitle' => 'Giám sát dòng tiền cư trú, chỉ số tiện ích và quản lý lịch sử giao dịch toàn diện.']); ?>
            <div class="flex items-center gap-3">
                <a href="<?php echo e(route('admin.hoadon.nhap_hang_loat')); ?>" class="saas-btn-secondary h-11 px-5 shadow-sm">
                    <svg class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    Nhập hàng loạt
                </a>
                <button type="button" data-modal-target="modal-xulyhoadon" data-modal-toggle="modal-xulyhoadon" class="saas-btn-primary h-11 px-6 shadow-lg shadow-emerald-500/20">
                    <svg class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4"/></svg>
                    Tạo hóa đơn tháng
                </button>
            </div>
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

        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
            <div class="saas-card p-6">
                <div class="flex items-center justify-between mb-4">
                    <div class="h-10 w-10 rounded-xl bg-slate-50 text-slate-700 flex items-center justify-center border border-slate-200/60">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                    </div>
                    <span class="text-[10px] font-semibold text-slate-400 uppercase tracking-wider">Tổng nợ</span>
                </div>
                <div class="text-2xl font-semibold text-slate-900 tabular-nums"><?php echo e(number_format((int) ($thongke['tong_no'] ?? 0))); ?><span class="text-xs font-semibold text-slate-400 ml-1.5 uppercase">VNĐ</span></div>
                <div class="mt-1 text-xs text-slate-500">Tổng công nợ đang theo dõi.</div>
            </div>

            <div class="saas-card p-6">
                <div class="flex items-center justify-between mb-4">
                    <div class="h-10 w-10 rounded-xl bg-rose-50 text-rose-700 flex items-center justify-center border border-rose-200/50">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <span class="text-[10px] font-semibold text-slate-400 uppercase tracking-wider">Quá hạn</span>
                </div>
                <div class="text-2xl font-semibold text-rose-700 tabular-nums"><?php echo e($thongke['so_qua_han'] ?? 0); ?><span class="text-xs font-semibold text-rose-400 ml-1.5 uppercase">HĐ</span></div>
                <div class="mt-1 text-xs text-slate-500">Cần nhắc thanh toán.</div>
            </div>

            <div class="saas-card p-6">
                <div class="flex items-center justify-between mb-4">
                    <div class="h-10 w-10 rounded-xl bg-amber-50 text-amber-700 flex items-center justify-center border border-amber-200/50">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
                    </div>
                    <span class="text-[10px] font-semibold text-slate-400 uppercase tracking-wider">Chờ thu</span>
                </div>
                <div class="text-2xl font-semibold text-amber-700 tabular-nums"><?php echo e($thongke['so_cho_thu'] ?? 0); ?><span class="text-xs font-semibold text-amber-400 ml-1.5 uppercase">HĐ</span></div>
                <div class="mt-1 text-xs text-slate-500">Chưa thu hoặc chờ xác nhận.</div>
            </div>

            <div class="saas-card p-6">
                <div class="flex items-center justify-between mb-4">
                    <div class="h-10 w-10 rounded-xl bg-emerald-50 text-emerald-700 flex items-center justify-center border border-emerald-200/50">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <span class="text-[10px] font-semibold text-slate-400 uppercase tracking-wider">Đã thu</span>
                </div>
                <div class="text-2xl font-semibold text-emerald-700 tabular-nums"><?php echo e(number_format((int) ($thongke['da_thu_thang'] ?? 0))); ?><span class="text-xs font-semibold text-emerald-400 ml-1.5 uppercase">VNĐ</span></div>
                <div class="mt-1 text-xs text-slate-500">Tổng thu trong tháng.</div>
            </div>
        </div>

        <?php
            $activeTab = (string) ($activeTab ?? request()->query('tab', 'cho-xac-nhan'));
            $tabs = $tabs ?? [
                'cho_xac_nhan' => 0,
                'cong_no' => 0,
                'lich_su' => 0,
                'hoan_coc' => 0,
            ];
            $tabItems = [
                'cho-xac-nhan' => ['label' => 'Chờ xác nhận', 'count' => (int) ($tabs['cho_xac_nhan'] ?? 0)],
                'cong-no' => ['label' => 'Công nợ', 'count' => (int) ($tabs['cong_no'] ?? 0)],
                'lich-su' => ['label' => 'Lịch sử thu', 'count' => (int) ($tabs['lich_su'] ?? 0)],
                'hoan-coc' => ['label' => 'Hoàn cọc', 'count' => (int) ($tabs['hoan_coc'] ?? 0)],
            ];
        ?>

        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <div class="text-sm font-semibold text-slate-900">Bộ lọc theo luồng xử lý</div>
                <div class="mt-0.5 text-xs text-slate-500">Ưu tiên đối soát giao dịch trước, sau đó xử lý công nợ.</div>
            </div>
            <nav class="flex items-center gap-1 p-1 rounded-xl bg-slate-100/80 w-fit" aria-label="Bộ lọc hóa đơn">
                <?php $__currentLoopData = $tabItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tabValue => $tab): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php
                        $isActive = $activeTab === $tabValue;
                        $href = request()->fullUrlWithQuery(['tab' => $tabValue, 'page' => 1]);
                    ?>
                    <a
                        href="<?php echo e($href); ?>"
                        class="px-4 py-1.5 rounded-lg text-xs font-bold transition-all <?php echo e($isActive ? 'bg-white text-brand-emerald shadow-sm' : 'text-slate-500 hover:text-slate-900'); ?>"
                        aria-current="<?php echo e($isActive ? 'page' : 'false'); ?>"
                    >
                        <?php echo e($tab['label']); ?>

                        <span class="ml-2 inline-flex min-w-[20px] items-center justify-center rounded-full px-1.5 py-0.5 text-[10px] font-bold tabular-nums <?php echo e($isActive ? 'bg-brand-emerald/10 text-brand-emerald' : 'bg-slate-200/70 text-slate-700'); ?>">
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
                    <th>Sinh viên</th>
                    <th class="text-right">Số tiền</th>
                    <th>Giao dịch</th>
                    <th>Hạn thanh toán</th>
                    <th class="text-center">Trạng thái</th>
                    <th class="text-right">Hành động</th>
                </tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $danhsachhoadon; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $hoadon): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr class="hover:bg-slate-50/50 transition-colors group">
                        <td class="py-5">
                            <?php
                                $maHoaDon = $hoadon->ma_hoa_don ?: ('HD-' . str_pad((string) $hoadon->id, 6, '0', STR_PAD_LEFT));
                                $ghiChuHoaDon = $hoadon->ghi_chu
                                    ? preg_replace('/\bKy\s+/u', 'Tháng ', (string) $hoadon->ghi_chu)
                                    : null;
                            ?>
                            <div class="text-sm font-bold text-slate-900 tabular-nums leading-tight"><?php echo e($maHoaDon); ?></div>
                            <div class="mt-1 text-xs text-slate-500">
                                <?php echo e($hoadon->loai_hoadon_label); ?><?php if($ghiChuHoaDon): ?> • <?php echo e($ghiChuHoaDon); ?><?php endif; ?>
                            </div>
                        </td>
                        <td class="py-5">
                            <div class="text-sm font-bold text-slate-800 leading-tight group-hover:text-slate-900 transition-colors"><?php echo e($hoadon->hopdong?->sinhvien?->user?->name ?? 'Chưa xác định'); ?></div>
                            <div class="mt-1 text-xs text-slate-500">
                                Phòng <?php echo e($hoadon->hopdong?->giuong?->phong?->ten_phong ?? '—'); ?>

                            </div>
                        </td>
                        <td class="py-5 text-right">
                            <div class="text-sm font-bold text-slate-900 tabular-nums leading-tight"><?php echo e(number_format((int) $hoadon->tong_tien)); ?><small class="ml-0.5 text-slate-400 font-bold uppercase">VNĐ</small></div>
                            <div class="mt-1 text-xs text-slate-500 tabular-nums"><?php echo e($hoadon->created_at?->format('d/m/Y') ?? '—'); ?></div>
                        </td>
                        <td class="py-5">
                            <?php
                                $giaoDichChoXacNhan = $hoadon->trang_thai === \App\Enums\InvoiceStatus::PendingConfirmation
                                    ? $hoadon->giao_dich_gan_nhat
                                    : null;
                            ?>

                            <?php if($giaoDichChoXacNhan): ?>
                                <?php
                                    $ghiChuGiaoDich = $giaoDichChoXacNhan->ghi_chu
                                        ? preg_replace('/\bKy\s+/u', 'Tháng ', (string) $giaoDichChoXacNhan->ghi_chu)
                                        : null;
                                ?>
                                <div class="text-[11px] font-bold text-slate-900 tabular-nums leading-tight"><?php echo e($giaoDichChoXacNhan->ma_giao_dich ?? '—'); ?></div>
                                <div class="mt-1 text-[10px] font-semibold text-slate-500 leading-snug">
                                    <?php echo e($ghiChuGiaoDich ?? '—'); ?>

                                </div>
                                <div class="mt-1 text-[9px] font-bold text-slate-400 uppercase tracking-widest">
                                    <?php echo e($giaoDichChoXacNhan->ngay_giao_dich?->format('d/m/Y H:i') ?? '—'); ?>

                                </div>
                            <?php else: ?>
                                <div class="text-sm font-bold text-slate-300">—</div>
                            <?php endif; ?>
                        </td>
                        <td class="py-5 text-slate-600">
                            <div class="tabular-nums"><?php echo e($hoadon->ngay_het_han?->format('d/m/Y') ?? '—'); ?></div>
                        </td>
                        <td class="py-5 text-center">
                            <?php
                                $invoiceType = (string) ($hoadon->loai_hoadon ?? '');
                                $statusInvoice = $hoadon->trang_thai;
                                $statusBadgeInvoice = $statusInvoice->badgeClass($invoiceType);
                                $statusLabel = $statusInvoice->displayLabel($invoiceType);
                            ?>
                            <span class="saas-badge <?php echo e($statusBadgeInvoice); ?>">
                                <?php echo e($statusLabel); ?>

                            </span>
                        </td>
                        <td class="py-5 text-right">
                            <div class="flex items-center justify-end gap-2">
                                <?php
                                    $loaiHoadon = (string) ($hoadon->loai_hoadon ?? '');
                                    $coTheNhacNo = in_array($hoadon->trang_thai, [\App\Enums\InvoiceStatus::Unpaid, \App\Enums\InvoiceStatus::Overdue], true)
                                        && $loaiHoadon !== 'refund';
                                ?>
                                <?php if($hoadon->trang_thai !== \App\Enums\InvoiceStatus::Paid): ?>
                                    <?php
                                        $isRefund = (string) ($hoadon->loai_hoadon ?? '') === 'refund';
                                        $isPendingConfirmation = $hoadon->trang_thai === \App\Enums\InvoiceStatus::PendingConfirmation;
                                        $confirmText = $isRefund
                                            ? ('Xác nhận đã hoàn tiền cọc ' . $maHoaDon . ' (Số tiền: ' . number_format((int) $hoadon->tong_tien, 0, ',', '.') . 'đ)?')
                                            : ($isPendingConfirmation
                                                ? ('Xác nhận giao dịch chuyển khoản cho hóa đơn ' . $maHoaDon . ' (Số tiền: ' . number_format((int) $hoadon->tong_tien, 0, ',', '.') . 'đ)?')
                                                : ('Ghi nhận đã thu hóa đơn ' . $maHoaDon . ' (Số tiền: ' . number_format((int) $hoadon->tong_tien, 0, ',', '.') . 'đ)?'));
                                    ?>
                                    <form action="<?php echo e(route('admin.hoadon.xacnhan', $hoadon->id)); ?>" method="POST" data-confirm="<?php echo e(e($confirmText)); ?>" onsubmit="return confirm(this.dataset.confirm)">
                                        <?php echo csrf_field(); ?>
                                        <button type="submit" class="saas-btn-primary h-9 px-3 text-xs font-semibold">
                                            <?php echo e($isRefund ? 'Xác nhận hoàn' : ($isPendingConfirmation ? 'Xác nhận CK' : 'Ghi nhận thu')); ?>

                                        </button>
                                    </form>
                                    <?php if($isPendingConfirmation): ?>
                                        <?php
                                            $rejectText = 'Từ chối xác nhận thanh toán cho hóa đơn ' . $maHoaDon . '?';
                                        ?>
                                        <form action="<?php echo e(route('admin.hoadon.tuchoi_xacnhan', $hoadon->id)); ?>" method="POST" data-confirm="<?php echo e(e($rejectText)); ?>" onsubmit="const reason = prompt('Nhập lý do từ chối (tùy chọn):'); if (reason === null) return false; this.querySelector('input[name=ly_do]').value = String(reason).trim(); return confirm(this.dataset.confirm)">
                                            <?php echo csrf_field(); ?>
                                            <input type="hidden" name="ly_do" value="" />
                                            <button type="submit" class="saas-btn-danger h-9 px-3 text-xs font-semibold">
                                                Từ chối
                                            </button>
                                        </form>
                                    <?php endif; ?>
                                <?php endif; ?>

                                <a href="<?php echo e(route('admin.hoadon.pdf', $hoadon->id)); ?>" class="saas-btn-secondary h-9 px-3 text-xs font-semibold">
                                    PDF
                                </a>

                                <?php if($coTheNhacNo): ?>
                                    <form action="<?php echo e(route('admin.hoadon.nhacno', $hoadon->id)); ?>" method="POST" data-confirm="<?php echo e(e('Gửi nhắc nợ cho hóa đơn ' . $maHoaDon . '?')); ?>" onsubmit="return confirm(this.dataset.confirm)">
                                        <?php echo csrf_field(); ?>
                                        <button type="submit" class="saas-btn-ghost h-9 px-3 text-xs font-semibold">
                                            Nhắc nợ
                                        </button>
                                    </form>
                                <?php endif; ?>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="7" class="py-24 text-center">
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

        <?php if(method_exists($danhsachhoadon, 'links')): ?>
            <div class="mt-8">
                <?php echo e($danhsachhoadon->links()); ?>

            </div>
        <?php endif; ?>
    </div>

    <?php $__env->startPush('modals'); ?>
        <?php if (isset($component)) { $__componentOriginal9f64f32e90b9102968f2bc548315018c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9f64f32e90b9102968f2bc548315018c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.modal','data' => ['id' => 'modal-xulyhoadon','title' => 'Ghi chỉ số điện nước','subtitle' => 'Nhập chỉ số điện nước định kỳ để hệ thống tự động tạo hóa đơn tháng.']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('modal'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['id' => 'modal-xulyhoadon','title' => 'Ghi chỉ số điện nước','subtitle' => 'Nhập chỉ số điện nước định kỳ để hệ thống tự động tạo hóa đơn tháng.']); ?>
            <form method="POST" action="<?php echo e(route('admin.hoadon.tao_thang')); ?>" class="space-y-6">
                <?php echo csrf_field(); ?>
                <div class="space-y-2">
                    <label for="phong_id" class="text-[10px] font-bold uppercase tracking-widest text-slate-400 ml-1">Phòng cần ghi chỉ số</label>
                    <select name="phong_id" id="phong_id" class="saas-input font-bold h-11" required>
                        <option value="">-- Chọn phòng --</option>
                        <?php $__currentLoopData = $danhsachphong; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $phong): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($phong->id); ?>"><?php echo e($phong->ten_phong); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>

                <div class="grid grid-cols-2 gap-6">
                    <div class="space-y-2">
                        <label for="thang" class="text-[10px] font-bold uppercase tracking-widest text-slate-400 ml-1">Tháng</label>
                        <input name="thang" id="thang" type="number" value="<?php echo e(now()->format('m')); ?>" class="saas-input font-bold tabular-nums h-11" required />
                    </div>
                    <div class="space-y-2">
                        <label for="nam" class="text-[10px] font-bold uppercase tracking-widest text-slate-400 ml-1">Năm</label>
                        <input name="nam" id="nam" type="number" value="<?php echo e(now()->format('Y')); ?>" class="saas-input font-bold tabular-nums h-11" required />
                    </div>
                </div>

                <div class="saas-card p-6 bg-slate-50 border-dashed border-slate-200">
                    <div class="grid grid-cols-2 gap-8">
                        <div class="space-y-4">
                            <h4 class="text-[10px] font-bold text-slate-900 uppercase tracking-widest flex items-center gap-2">
                                <div class="h-5 w-5 rounded-lg bg-amber-500 text-white flex items-center justify-center">
                                    <svg class="h-3 w-3" fill="currentColor" viewBox="0 0 24 24"><path d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                                </div>
                                Điện
                            </h4>
                            <div class="space-y-2">
                                <label class="text-[9px] font-bold uppercase text-slate-400 tracking-wider">Chỉ số cũ</label>
                                <input name="chisodiencu" type="number" value="0" class="saas-input h-10 tabular-nums text-sm font-bold" required />
                            </div>
                            <div class="space-y-2">
                                <label class="text-[9px] font-bold uppercase text-brand-emerald tracking-wider">Chỉ số mới</label>
                                <input name="chisodienmoi" type="number" value="0" class="saas-input h-11 font-bold text-slate-900 tabular-nums border-emerald-200 focus:border-brand-emerald" required />
                            </div>
                        </div>
                        <div class="space-y-4">
                            <h4 class="text-[10px] font-bold text-slate-900 uppercase tracking-widest flex items-center gap-2">
                                <div class="h-5 w-5 rounded-lg bg-brand-emerald text-white flex items-center justify-center">
                                    <svg class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                                </div>
                                Nước
                            </h4>
                            <div class="space-y-2">
                                <label class="text-[9px] font-bold uppercase text-slate-400 tracking-wider">Chỉ số cũ</label>
                                <input name="chisonuoccu" type="number" value="0" class="saas-input h-10 tabular-nums text-sm font-bold" required />
                            </div>
                            <div class="space-y-2">
                                <label class="text-[9px] font-bold uppercase text-brand-emerald tracking-wider">Chỉ số mới</label>
                                <input name="chisonuocmoi" type="number" value="0" class="saas-input h-11 font-bold text-slate-900 tabular-nums border-emerald-200 focus:border-brand-emerald" required />
                            </div>
                        </div>
                    </div>
                    <div class="mt-6 flex items-center gap-3 p-4 bg-white/70 rounded-xl border border-slate-200/40">
                        <svg class="h-4 w-4 text-slate-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <p class="text-[10px] text-slate-500 font-bold leading-relaxed">
                            Hệ thống sẽ tự động tính chênh lệch chỉ số và áp dụng đơn giá để tạo hóa đơn.
                        </p>
                    </div>
                </div>

                <div class="flex gap-4 pt-2">
                    <button type="submit" class="saas-btn-primary flex-1 h-11 shadow-lg shadow-emerald-500/20">Tạo hóa đơn</button>
                    <button type="button" data-modal-hide="modal-xulyhoadon" class="saas-btn-secondary flex-1 h-11">Hủy</button>
                </div>
            </form>
         <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal9f64f32e90b9102968f2bc548315018c)): ?>
<?php $attributes = $__attributesOriginal9f64f32e90b9102968f2bc548315018c; ?>
<?php unset($__attributesOriginal9f64f32e90b9102968f2bc548315018c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9f64f32e90b9102968f2bc548315018c)): ?>
<?php $component = $__componentOriginal9f64f32e90b9102968f2bc548315018c; ?>
<?php unset($__componentOriginal9f64f32e90b9102968f2bc548315018c); ?>
<?php endif; ?>
    <?php $__env->stopPush(); ?>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal91fdd17964e43374ae18c674f95cdaa3)): ?>
<?php $attributes = $__attributesOriginal91fdd17964e43374ae18c674f95cdaa3; ?>
<?php unset($__attributesOriginal91fdd17964e43374ae18c674f95cdaa3); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal91fdd17964e43374ae18c674f95cdaa3)): ?>
<?php $component = $__componentOriginal91fdd17964e43374ae18c674f95cdaa3; ?>
<?php unset($__componentOriginal91fdd17964e43374ae18c674f95cdaa3); ?>
<?php endif; ?>
<?php /**PATH D:\laragon\www\hethongquanlyktxv1\resources\views/admin/hoadon/danhsach.blade.php ENDPATH**/ ?>