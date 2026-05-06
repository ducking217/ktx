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
     <?php $__env->slot('title', null, []); ?> Quản lý Hợp đồng Cư trú <?php $__env->endSlot(); ?>

    <div class="space-y-8">
        <?php if (isset($component)) { $__componentOriginalcb19cb35a534439097b02b8af91726ee = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalcb19cb35a534439097b02b8af91726ee = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.page-header','data' => ['title' => 'Hệ thống hợp đồng','subtitle' => 'Quản lý vòng đời hợp đồng, thực thi điều khoản pháp lý và quy trình thanh lý tài chính.']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('admin.page-header'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Hệ thống hợp đồng','subtitle' => 'Quản lý vòng đời hợp đồng, thực thi điều khoản pháp lý và quy trình thanh lý tài chính.']); ?>
            <div class="saas-card flex items-center px-4 h-10 bg-white/60 border-slate-200/60 shadow-sm">
                <form action="<?php echo e(route('admin.hopdong.index')); ?>" method="GET" class="flex items-center gap-2">
                    <svg class="h-4 w-4 text-slate-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    <input type="text" name="search" value="<?php echo e(request('search')); ?>" placeholder="Tìm sinh viên, mã HĐ..." class="bg-transparent border-none focus:ring-0 text-sm font-medium text-slate-900 w-44 placeholder:text-slate-300" />
                </form>
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

        
        <div class="saas-card p-6 bg-slate-50/50 border-dashed">
            <form method="GET" action="<?php echo e(route('admin.hopdong.index')); ?>" class="flex flex-wrap items-end gap-6">
                <div class="flex-1 min-w-[200px] space-y-2">
                    <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest ml-1">Trạng thái hợp đồng</label>
                    <select name="status" class="saas-input font-bold h-11" onchange="this.form.submit()">
                        <option value="">Tất cả trạng thái</option>
                        <?php $__currentLoopData = \App\Enums\ContractStatus::cases(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $status): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($status->value); ?>" <?php echo e(request('status') == $status->value ? 'selected' : ''); ?>><?php echo e($status->label()); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
            </form>
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
                    <th>Mã HĐ</th>
                    <th>Sinh viên</th>
                    <th>Phòng</th>
                    <th>Thời hạn</th>
                    <th class="text-center">Trạng thái</th>
                    <th class="text-right">Hành động</th>
                </tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $hopdong; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr class="hover:bg-slate-50/50 transition-colors group">
                        <td class="py-5">
                            <span class="text-[11px] font-bold text-slate-400 tabular-nums bg-slate-50 px-2 py-0.5 rounded border border-slate-200/60 uppercase tracking-widest"><?php echo e($item->ma_hd); ?></span>
                        </td>
                        <td class="py-5">
                            <div class="text-sm font-bold text-slate-900 leading-tight group-hover:text-brand-emerald transition-colors"><?php echo e($item->sinhvien?->user?->name ?? 'Chưa xác định'); ?></div>
                            <div class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-1.5"><?php echo e($item->sinhvien?->ma_sinh_vien ?? 'Chưa có'); ?></div>
                        </td>
                        <td class="py-5">
                            <div class="flex items-center gap-2">
                                <div class="h-8 w-8 rounded-xl bg-slate-50 border border-slate-200/60 flex items-center justify-center text-slate-400 group-hover:bg-slate-900 group-hover:text-white group-hover:border-slate-900 transition-all shadow-sm">
                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16"/></svg>
                                </div>
                                <span class="text-sm font-bold text-slate-700"><?php echo e($item->giuong?->phong?->ten_phong ?? 'Chưa có'); ?></span>
                            </div>
                        </td>
                        <td class="py-5 min-w-[160px]">
                            <div class="text-[11px] font-bold text-slate-900 tabular-nums">
                                <?php echo e(is_string($item->ngay_bat_dau) ? $item->ngay_bat_dau : $item->ngay_bat_dau->format('d.m.Y')); ?>

                                <span class="mx-1 text-slate-300">→</span>
                                <?php echo e(is_string($item->ngay_ket_thuc) ? $item->ngay_ket_thuc : $item->ngay_ket_thuc->format('d.m.Y')); ?>

                            </div>
                            <div class="w-full bg-slate-100 h-1.5 rounded-full overflow-hidden mt-2">
                                <?php
                                    $start = is_string($item->ngay_bat_dau) ? strtotime($item->ngay_bat_dau) : $item->ngay_bat_dau->timestamp;
                                    $end = is_string($item->ngay_ket_thuc) ? strtotime($item->ngay_ket_thuc) : $item->ngay_ket_thuc->timestamp;
                                    $now = time();
                                    $total = max(1, $end - $start);
                                    $progress = min(100, max(0, (($now - $start) / $total) * 100));
                                ?>
                                <div class="bg-brand-emerald h-full transition-all duration-1000 rounded-full" style="width: <?php echo e($progress); ?>%"></div>
                            </div>
                        </td>
                        <td class="py-5 text-center">
                            <?php
                                $statusBadge = match ($item->trang_thai) {
                                    \App\Enums\ContractStatus::Active => 'saas-badge-success',
                                    \App\Enums\ContractStatus::Expired => 'saas-badge-warning',
                                    \App\Enums\ContractStatus::Terminated => 'saas-badge-error',
                                    default => 'saas-badge-info',
                                };
                            ?>
                            <span class="saas-badge <?php echo e($statusBadge); ?>">
                                <?php echo e($item->trang_thai->label()); ?>

                            </span>
                        </td>
                        <td class="py-5 text-right">
                            <div class="flex items-center justify-end gap-1">
                                <button type="button" data-modal-target="modal-chi-tiet-<?php echo e($item->id); ?>" data-modal-toggle="modal-chi-tiet-<?php echo e($item->id); ?>" class="h-9 w-9 inline-flex items-center justify-center text-slate-400 hover:text-brand-emerald hover:bg-brand-emerald/10 border border-transparent hover:border-brand-emerald/20 rounded-xl transition-all shadow-sm hover:shadow-md" title="Chi tiết hợp đồng">
                                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                </button>

                                <?php if($item->trang_thai == \App\Enums\ContractStatus::Active): ?>
                                    <button type="button" data-modal-target="modal-gia-han-<?php echo e($item->id); ?>" data-modal-toggle="modal-gia-han-<?php echo e($item->id); ?>" class="h-9 w-9 inline-flex items-center justify-center text-slate-400 hover:text-emerald-600 hover:bg-emerald-50 border border-transparent hover:border-emerald-100 rounded-xl transition-all shadow-sm hover:shadow-md" title="Gia hạn hợp đồng">
                                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
                                    </button>

                                    <button type="button" data-modal-target="modal-thanh-ly-<?php echo e($item->id); ?>" data-modal-toggle="modal-thanh-ly-<?php echo e($item->id); ?>" class="h-9 w-9 inline-flex items-center justify-center text-slate-400 hover:text-rose-600 hover:bg-rose-50 border border-transparent hover:border-rose-100 rounded-xl transition-all shadow-sm hover:shadow-md" title="Thanh lý hợp đồng">
                                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                                    </button>
                                <?php endif; ?>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="6" class="py-24 text-center">
                            <div class="flex flex-col items-center gap-4 text-slate-200">
                                <svg class="h-14 w-14" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                <p class="text-sm font-bold text-slate-400 uppercase tracking-widest">Không có hợp đồng nào</p>
                            </div>
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

        <?php if(method_exists($hopdong, 'links')): ?>
            <div class="mt-8">
                <?php echo e($hopdong->appends(request()->query())->links()); ?>

            </div>
        <?php endif; ?>
    </div>

    <?php $__env->startPush('modals'); ?>
        <?php $__currentLoopData = $hopdong; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php
                $statusBadge = match ($item->trang_thai) {
                    \App\Enums\ContractStatus::Active => 'saas-badge-success',
                    \App\Enums\ContractStatus::Expired => 'saas-badge-warning',
                    \App\Enums\ContractStatus::Terminated => 'saas-badge-error',
                    default => 'saas-badge-info',
                };
            ?>

            
            <?php if (isset($component)) { $__componentOriginal9f64f32e90b9102968f2bc548315018c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9f64f32e90b9102968f2bc548315018c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.modal','data' => ['id' => 'modal-chi-tiet-'.e($item->id).'','title' => 'Chi tiết hợp đồng '.e($item->ma_hd).'','subtitle' => 'Thông tin đầy đủ về hợp đồng cư trú và điều khoản liên quan.']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('modal'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['id' => 'modal-chi-tiet-'.e($item->id).'','title' => 'Chi tiết hợp đồng '.e($item->ma_hd).'','subtitle' => 'Thông tin đầy đủ về hợp đồng cư trú và điều khoản liên quan.']); ?>
                <div class="space-y-6">
                    <div class="p-6 rounded-2xl bg-slate-50 border border-slate-200/60 flex items-center gap-4">
                        <div class="h-12 w-12 rounded-xl bg-white border border-slate-200 flex items-center justify-center text-xl shadow-sm">👤</div>
                        <div>
                            <div class="text-base font-bold text-slate-900 leading-none"><?php echo e($item->sinhvien?->user?->name ?? 'Chưa xác định'); ?></div>
                            <div class="text-[10px] font-bold uppercase tracking-widest text-slate-400 mt-1.5">Mã SV: <?php echo e($item->sinhvien->ma_sinh_vien ?? 'Chưa có'); ?></div>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div class="saas-card p-5 bg-white/60 border-slate-100">
                            <span class="block text-[9px] font-bold uppercase tracking-widest text-slate-400 mb-2">Ngày bắt đầu</span>
                            <span class="text-sm font-bold text-slate-900 tabular-nums"><?php echo e(is_string($item->ngay_bat_dau) ? $item->ngay_bat_dau : $item->ngay_bat_dau->format('d.m.Y')); ?></span>
                        </div>
                        <div class="saas-card p-5 bg-white/60 border-slate-100">
                            <span class="block text-[9px] font-bold uppercase tracking-widest text-slate-400 mb-2">Ngày kết thúc</span>
                            <span class="text-sm font-bold text-brand-emerald tabular-nums"><?php echo e(is_string($item->ngay_ket_thuc) ? $item->ngay_ket_thuc : $item->ngay_ket_thuc->format('d.m.Y')); ?></span>
                        </div>
                    </div>

                    <div class="divide-y divide-slate-100 saas-card px-6 border-slate-100 shadow-sm">
                        <div class="flex items-center justify-between py-4">
                            <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Phòng</span>
                            <span class="text-sm font-bold text-slate-900">Tòa <?php echo e($item->giuong?->phong?->toanha?->ten_toa_nha ?? '?'); ?> — <?php echo e($item->giuong?->phong?->ten_phong ?? '?'); ?></span>
                        </div>
                        <div class="flex items-center justify-between py-4">
                            <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Giá thuê / tháng</span>
                            <span class="text-sm font-bold text-slate-900 tabular-nums"><?php echo e(number_format((int) $item->gia_thuc_te)); ?><small class="ml-1 text-slate-400 uppercase font-bold text-[10px]">VNĐ</small></span>
                        </div>
                        <div class="flex items-center justify-between py-4">
                            <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Trạng thái</span>
                            <span class="saas-badge <?php echo e($statusBadge); ?>"><?php echo e($item->trang_thai->label()); ?></span>
                        </div>
                    </div>

                    <?php if($item->ghichu): ?>
                        <div class="space-y-2">
                            <span class="text-[10px] font-bold uppercase tracking-widest text-slate-400 ml-1">Ghi chú</span>
                            <div class="p-5 rounded-xl bg-amber-50/50 border border-amber-100/50 text-sm text-slate-700 font-medium leading-relaxed italic">
                                "<?php echo e($item->ghichu); ?>"
                            </div>
                        </div>
                    <?php endif; ?>

                    <div class="flex gap-4 pt-2">
                        <a href="<?php echo e(route('admin.hopdong.pdf', $item->id)); ?>" target="_blank" class="saas-btn-primary flex-1 h-11 justify-center shadow-lg shadow-emerald-500/20">
                            <svg class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                            Xuất PDF hợp đồng
                        </a>
                        <button type="button" data-modal-hide="modal-chi-tiet-<?php echo e($item->id); ?>" class="saas-btn-secondary flex-1 h-11 justify-center">Đóng</button>
                    </div>
                </div>
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

            
            <?php if (isset($component)) { $__componentOriginal9f64f32e90b9102968f2bc548315018c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9f64f32e90b9102968f2bc548315018c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.modal','data' => ['id' => 'modal-gia-han-'.e($item->id).'','title' => 'Gia hạn hợp đồng','subtitle' => 'Cập nhật ngày kết thúc mới cho hợp đồng cư trú '.e($item->ma_hd).'.']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('modal'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['id' => 'modal-gia-han-'.e($item->id).'','title' => 'Gia hạn hợp đồng','subtitle' => 'Cập nhật ngày kết thúc mới cho hợp đồng cư trú '.e($item->ma_hd).'.']); ?>
                <form action="<?php echo e(route('admin.hopdong.giahan', $item->id)); ?>" method="POST" class="space-y-6">
                    <?php echo csrf_field(); ?>
                    <div class="space-y-2">
                        <label class="text-[10px] font-bold uppercase tracking-widest text-slate-400 ml-1">Ngày kết thúc mới</label>
                        <?php
                            $ngayKetThuc = $item->ngay_ket_thuc;
                            if (is_string($ngayKetThuc)) {
                                $ngayKetThuc = \Illuminate\Support\Carbon::parse($ngayKetThuc);
                            }
                            $ngayMacDinh = optional($ngayKetThuc)?->copy()->addMonths(5) ?? now()->addMonths(5);
                        ?>
                        <input name="ngay_ket_thuc" type="date" value="<?php echo e(old('ngay_ket_thuc', $ngayMacDinh->format('Y-m-d'))); ?>" class="saas-input h-11 font-bold tabular-nums" required />
                        <?php if (isset($component)) { $__componentOriginalf94ed9c5393ef72725d159fe01139746 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf94ed9c5393ef72725d159fe01139746 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.input-error','data' => ['messages' => $errors->get('ngay_ket_thuc'),'class' => 'mt-2 ml-1']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('input-error'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['messages' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($errors->get('ngay_ket_thuc')),'class' => 'mt-2 ml-1']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalf94ed9c5393ef72725d159fe01139746)): ?>
<?php $attributes = $__attributesOriginalf94ed9c5393ef72725d159fe01139746; ?>
<?php unset($__attributesOriginalf94ed9c5393ef72725d159fe01139746); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalf94ed9c5393ef72725d159fe01139746)): ?>
<?php $component = $__componentOriginalf94ed9c5393ef72725d159fe01139746; ?>
<?php unset($__componentOriginalf94ed9c5393ef72725d159fe01139746); ?>
<?php endif; ?>
                    </div>

                    <div class="flex gap-4 pt-2">
                        <button type="button" data-modal-hide="modal-gia-han-<?php echo e($item->id); ?>" class="saas-btn-secondary flex-1 h-11">Hủy</button>
                        <button type="submit" class="saas-btn-primary flex-1 h-11 shadow-lg shadow-emerald-500/20">Xác nhận gia hạn</button>
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

            
            <?php if (isset($component)) { $__componentOriginal9f64f32e90b9102968f2bc548315018c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9f64f32e90b9102968f2bc548315018c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.modal','data' => ['id' => 'modal-thanh-ly-'.e($item->id).'','title' => 'Thanh lý hợp đồng','subtitle' => 'Xác nhận chấm dứt hợp đồng '.e($item->ma_hd).' và thực hiện đối soát tài chính.']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('modal'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['id' => 'modal-thanh-ly-'.e($item->id).'','title' => 'Thanh lý hợp đồng','subtitle' => 'Xác nhận chấm dứt hợp đồng '.e($item->ma_hd).' và thực hiện đối soát tài chính.']); ?>
                <form action="<?php echo e(route('admin.hopdong.thanhly', $item->id)); ?>" method="POST" class="space-y-6">
                    <?php echo csrf_field(); ?>
                    <?php
                        $hoadonCoc = \App\Models\Hoadon::where('hopdong_id', $item->id)
                            ->where('loai_hoadon', \App\Models\Hoadon::LOAI_DEPOSIT)
                            ->where('trang_thai', \App\Enums\InvoiceStatus::Paid->value)
                            ->first();
                        $tienCoc = $hoadonCoc?->tong_tien ?? 0;
                    ?>

                    <div class="space-y-2">
                        <label class="text-[10px] font-bold uppercase tracking-widest text-slate-400 ml-1">Tiền cọc đã thu (gốc)</label>
                        <div class="h-11 saas-input bg-slate-50/50 flex items-center font-bold text-slate-900 tabular-nums border-slate-200/60 shadow-inner px-4">
                            <?php echo e(number_format((int) $tienCoc)); ?><span class="ml-1 text-slate-400 font-bold uppercase text-[10px]">VNĐ</span>
                        </div>
                    </div>

                    <div class="space-y-2">
                        <label for="phi_hu_hai_<?php echo e($item->id); ?>" class="text-[10px] font-bold uppercase tracking-widest text-slate-400 ml-1">Phí hư hại / vi phạm</label>
                        <div class="relative group">
                            <input name="phi_hu_hai" id="phi_hu_hai_<?php echo e($item->id); ?>" type="number" min="0" value="0" class="saas-input h-11 pl-14 font-bold tabular-nums focus:border-rose-300 transition-all" />
                            <div class="absolute inset-y-0 left-4 flex items-center text-slate-300 font-bold text-[11px] group-hover:text-rose-500 transition-colors">VNĐ</div>
                        </div>
                    </div>

                    <div class="p-5 rounded-xl bg-rose-50/30 border border-rose-100/50">
                        <div class="flex gap-3">
                            <svg class="h-5 w-5 text-rose-400 shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                            <p class="text-[11px] text-rose-600 font-bold leading-relaxed">
                                Hệ thống sẽ tự động tính delta giữa tiền cọc và phí hư hại để tạo chứng từ hoàn trả hoặc truy thu tương ứng.
                            </p>
                        </div>
                    </div>

                    <div class="flex gap-4 pt-2">
                        <button type="button" data-modal-hide="modal-thanh-ly-<?php echo e($item->id); ?>" class="saas-btn-secondary flex-1 h-11">Hủy</button>
                        <button type="submit" class="saas-btn-primary !bg-rose-900 flex-1 h-11 shadow-lg shadow-rose-900/20">Xác nhận thanh lý</button>
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
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
<?php /**PATH D:\laragon\www\hethongquanlyktxv1\resources\views/admin/hopdong/danhsach.blade.php ENDPATH**/ ?>