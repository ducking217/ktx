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
     <?php $__env->slot('title', null, []); ?> Quản lý Đăng ký Cư trú <?php $__env->endSlot(); ?>

    <div class="space-y-8">
        <?php if (isset($component)) { $__componentOriginalcb19cb35a534439097b02b8af91726ee = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalcb19cb35a534439097b02b8af91726ee = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.page-header','data' => ['title' => 'Hồ sơ đăng ký','subtitle' => ''.e(($type ?? 'thue-phong') === 'tra-phong' ? 'Luồng trả phòng: kiểm tra công nợ, xác nhận thanh lý và giải phóng giường.' : 'Luồng thuê phòng: thẩm định hồ sơ, điều phối hạ tầng và xác thực nghĩa vụ tài chính.').'']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('admin.page-header'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Hồ sơ đăng ký','subtitle' => ''.e(($type ?? 'thue-phong') === 'tra-phong' ? 'Luồng trả phòng: kiểm tra công nợ, xác nhận thanh lý và giải phóng giường.' : 'Luồng thuê phòng: thẩm định hồ sơ, điều phối hạ tầng và xác thực nghĩa vụ tài chính.').'']); ?>
            <div class="space-y-3">
                <?php if (isset($component)) { $__componentOriginalca9a59ffed06600c602f2637b0b34f87 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalca9a59ffed06600c602f2637b0b34f87 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.status-tabs','data' => ['items' => [
                        'thue-phong' => 'Thuê phòng (' . (int) ($countThuePhong ?? 0) . ')',
                        'tra-phong' => 'Trả phòng (' . (int) ($countTraPhong ?? 0) . ')',
                    ],'active' => $type ?? 'thue-phong','route' => 'admin.dangky.index','param' => 'type','defaultValue' => 'thue-phong']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('admin.status-tabs'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['items' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute([
                        'thue-phong' => 'Thuê phòng (' . (int) ($countThuePhong ?? 0) . ')',
                        'tra-phong' => 'Trả phòng (' . (int) ($countTraPhong ?? 0) . ')',
                    ]),'active' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($type ?? 'thue-phong'),'route' => 'admin.dangky.index','param' => 'type','defaultValue' => 'thue-phong']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalca9a59ffed06600c602f2637b0b34f87)): ?>
<?php $attributes = $__attributesOriginalca9a59ffed06600c602f2637b0b34f87; ?>
<?php unset($__attributesOriginalca9a59ffed06600c602f2637b0b34f87); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalca9a59ffed06600c602f2637b0b34f87)): ?>
<?php $component = $__componentOriginalca9a59ffed06600c602f2637b0b34f87; ?>
<?php unset($__componentOriginalca9a59ffed06600c602f2637b0b34f87); ?>
<?php endif; ?>

            <?php if (isset($component)) { $__componentOriginalca9a59ffed06600c602f2637b0b34f87 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalca9a59ffed06600c602f2637b0b34f87 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.status-tabs','data' => ['items' => [
                    'Tất cả' => 'Tất cả hồ sơ',
                    \App\Enums\RegistrationStatus::Pending->value => 'Chờ duyệt',
                    \App\Enums\RegistrationStatus::ApprovedPendingPayment->value => 'Chờ thu phí',
                    \App\Enums\RegistrationStatus::Approved->value => 'Đã duyệt',
                    \App\Enums\RegistrationStatus::Completed->value => 'Hoàn tất',
                    \App\Enums\RegistrationStatus::Rejected->value => 'Từ chối',
                ],'active' => $status ?? null,'route' => 'admin.dangky.index','param' => 'status','defaultValue' => 'Tất cả']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('admin.status-tabs'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['items' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute([
                    'Tất cả' => 'Tất cả hồ sơ',
                    \App\Enums\RegistrationStatus::Pending->value => 'Chờ duyệt',
                    \App\Enums\RegistrationStatus::ApprovedPendingPayment->value => 'Chờ thu phí',
                    \App\Enums\RegistrationStatus::Approved->value => 'Đã duyệt',
                    \App\Enums\RegistrationStatus::Completed->value => 'Hoàn tất',
                    \App\Enums\RegistrationStatus::Rejected->value => 'Từ chối',
                ]),'active' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($status ?? null),'route' => 'admin.dangky.index','param' => 'status','defaultValue' => 'Tất cả']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalca9a59ffed06600c602f2637b0b34f87)): ?>
<?php $attributes = $__attributesOriginalca9a59ffed06600c602f2637b0b34f87; ?>
<?php unset($__attributesOriginalca9a59ffed06600c602f2637b0b34f87); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalca9a59ffed06600c602f2637b0b34f87)): ?>
<?php $component = $__componentOriginalca9a59ffed06600c602f2637b0b34f87; ?>
<?php unset($__componentOriginalca9a59ffed06600c602f2637b0b34f87); ?>
<?php endif; ?>
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
                    <th>Sinh viên</th>
                    <th class="text-center">Phòng được phân</th>
                    <th class="text-center">Trạng thái</th>
                    <th class="text-center">CCCD</th>
                    <th class="text-right">Hành động</th>
                </tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $danhsachdangky; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dangky): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr class="hover:bg-slate-50/50 transition-colors group">
                        <td class="py-5">
                            <div class="flex flex-col">
                                <span class="text-sm font-bold text-slate-900 leading-tight group-hover:text-brand-emerald transition-colors"><?php echo e($dangky->ho_ten ?? $dangky->user?->name ?? 'Chưa xác định'); ?></span>
                                <div class="flex items-center gap-3 mt-1.5">
                                    <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest"><?php echo e($dangky->email ?? $dangky->user?->email ?? 'Chưa có'); ?></span>
                                    <div class="h-1 w-1 rounded-full bg-slate-200"></div>
                                    <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest tabular-nums"><?php echo e($dangky->so_dien_thoai ?? $dangky->user?->phone ?? 'Chưa có'); ?></span>
                                </div>
                            </div>
                        </td>
                        <td class="py-5 text-center">
                            <div class="flex flex-col items-center gap-1.5">
                                <span class="text-xs font-bold text-slate-600 bg-slate-100 px-2 py-1 rounded-lg">
                                    <?php echo e(\Illuminate\Support\Str::startsWith((string) $dangky->ghi_chu, 'TRA_PHONG')
                                        ? ($dangky->user?->sinhvien?->current_hopdong?->giuong?->phong?->ten_phong ?? 'Chưa có')
                                        : ($dangky->phong?->ten_phong ?? 'Chưa phân phòng')); ?>

                                </span>
                                <?php
                                    $isTraPhong = \Illuminate\Support\Str::startsWith((string) $dangky->ghi_chu, 'TRA_PHONG');
                                    $loaiDangKy = $isTraPhong ? \App\Enums\RegistrationType::Return : \App\Enums\RegistrationType::Rental;
                                ?>
                                <span class="text-[9px] font-bold uppercase tracking-widest text-slate-400"><?php echo e($loaiDangKy?->label() ?? 'Chưa có'); ?></span>
                            </div>
                        </td>
                        <td class="py-5 text-center">
                            <?php
                                $statusEnum = $dangky->trang_thai;
                                $statusBadgeDangKy = match ($statusEnum) {
                                    \App\Enums\RegistrationStatus::Approved, \App\Enums\RegistrationStatus::Completed => 'saas-badge-success',
                                    \App\Enums\RegistrationStatus::ApprovedPendingPayment => 'saas-badge-info',
                                    \App\Enums\RegistrationStatus::Rejected => 'saas-badge-error',
                                    \App\Enums\RegistrationStatus::Pending => 'saas-badge-warning',
                                    default => 'saas-badge-info'
                                };
                            ?>
                            <div class="flex flex-col items-center gap-1.5">
                                <span class="saas-badge <?php echo e($statusBadgeDangKy); ?>">
                                    <?php echo e($statusEnum?->label() ?? 'Chưa có'); ?>

                                </span>
                                <?php if($dangky->token_expires_at && $dangky->trang_thai === \App\Enums\RegistrationStatus::ApprovedPendingPayment): ?>
                                    <div class="text-[9px] font-bold text-rose-500 uppercase tracking-widest tabular-nums bg-rose-50 px-2 py-0.5 rounded-lg border border-rose-100/50">
                                        Hết hạn: <?php echo e(\Carbon\Carbon::parse($dangky->token_expires_at)->format('d/m H:i')); ?>

                                    </div>
                                <?php endif; ?>
                            </div>
                        </td>
                        <td class="py-5 text-center">
                            <?php if($dangky->anh_cccd_path): ?>
                                <div x-data="{ openPreview: false }">
                                    <button @click="openPreview = true" type="button" class="h-9 w-9 inline-flex items-center justify-center text-slate-400 hover:text-brand-emerald hover:bg-brand-emerald/10 border border-transparent hover:border-brand-emerald/20 rounded-xl transition-all shadow-sm hover:shadow-md" title="Xem CCCD">
                                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                    </button>

                                    <template x-teleport="body">
                                        <div x-show="openPreview" style="display: none;" class="fixed inset-0 z-[100] flex items-center justify-center bg-slate-950/90 backdrop-blur-xl p-10" @keydown.escape.window="openPreview = false">
                                            <div @click.away="openPreview = false" class="relative max-w-5xl w-full bg-white rounded-3xl shadow-2xl overflow-hidden border border-white/10">
                                                <div class="absolute top-6 right-6 z-10">
                                                    <button @click="openPreview = false" class="h-10 w-10 flex items-center justify-center rounded-xl bg-black/50 text-white hover:bg-black transition-all border border-white/20">
                                                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg>
                                                    </button>
                                                </div>
                                                <div class="p-3 bg-slate-950">
                                                    <img src="<?php echo e(route('private.file', ['path' => $dangky->anh_cccd_path])); ?>" class="w-full h-auto max-h-[80vh] object-contain rounded-2xl" alt="Ảnh CCCD">
                                                    <div class="p-4 bg-slate-900 mt-3 rounded-xl">
                                                        <p class="text-[10px] font-bold text-slate-500 uppercase tracking-widest text-center">Cổng xác thực danh tính</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </template>
                                </div>
                            <?php else: ?>
                                <span class="text-[10px] font-bold uppercase text-slate-300 tracking-widest">Chưa có</span>
                            <?php endif; ?>
                        </td>
                        <td class="py-5 text-right">
                            <div class="flex justify-end items-center gap-1">
                                <?php if($dangky->trang_thai === \App\Enums\RegistrationStatus::Pending): ?>
                                    <?php if(\Illuminate\Support\Str::startsWith((string) $dangky->ghi_chu, 'TRA_PHONG')): ?>
                                        <?php
                                            $coBaoHong = (bool) ($dangky->co_bao_hong ?? false);
                                            $soBaoHong = (int) ($dangky->so_bao_hong ?? 0);
                                            $phiGoiY = (int) ($dangky->phi_hu_hai_goi_y ?? 0);
                                        ?>
                                        <form method="POST" action="<?php echo e(route('admin.dangky.traphong.xuly', ['id' => $dangky->id])); ?>" data-co-bao-hong="<?php echo e($coBaoHong ? '1' : '0'); ?>" data-so-bao-hong="<?php echo e($soBaoHong); ?>" data-phi-goi-y="<?php echo e($phiGoiY); ?>" onsubmit="if (this.dataset.coBaoHong === '1') { const raw = prompt('Sinh viên có ' + this.dataset.soBaoHong + ' báo hỏng. Nhập phí hư hại để cấn trừ vào cọc (VNĐ):', this.dataset.phiGoiY); if (raw === null) return false; const fee = parseInt(String(raw).replace(/[^\d]/g, ''), 10); if (!Number.isFinite(fee) || fee < 0) { alert('Phí hư hại không hợp lệ.'); return false; } this.querySelector('input[name=phi_hu_hai]').value = String(fee); return confirm('Xác nhận trả phòng và cấn trừ ' + fee.toLocaleString('vi-VN') + 'đ vào tiền cọc?'); } return confirm('Xác nhận xử lý yêu cầu trả phòng này?');">
                                            <?php echo csrf_field(); ?>
                                            <input type="hidden" name="phi_hu_hai" value="" />
                                            <button type="submit" class="h-9 w-9 inline-flex items-center justify-center text-slate-400 hover:text-rose-600 hover:bg-rose-50 border border-transparent hover:border-rose-100 rounded-xl transition-all shadow-sm hover:shadow-md" title="Xử lý trả phòng">
                                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                                            </button>
                                        </form>
                                    <?php else: ?>
                                        <form method="POST" action="<?php echo e(route('admin.dangky.duyet', ['id' => $dangky->id])); ?>" onsubmit="return confirm('Phê duyệt hồ sơ đăng ký cư trú này?')">
                                            <?php echo csrf_field(); ?>
                                            <button type="submit" class="h-9 w-9 inline-flex items-center justify-center text-slate-400 hover:text-emerald-600 hover:bg-emerald-50 border border-transparent hover:border-emerald-100 rounded-xl transition-all shadow-sm hover:shadow-md" title="Phê duyệt">
                                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                                            </button>
                                        </form>
                                    <?php endif; ?>
                                <?php elseif($dangky->trang_thai === \App\Enums\RegistrationStatus::ApprovedPendingPayment): ?>
                                    <?php if(!\Illuminate\Support\Str::startsWith((string) $dangky->ghi_chu, 'TRA_PHONG')): ?>
                                        <form method="POST" action="<?php echo e(route('admin.dangky.xacnhanthanhtoan', ['id' => $dangky->id])); ?>" onsubmit="return confirm('Xác nhận sinh viên đã thanh toán?')">
                                            <?php echo csrf_field(); ?>
                                            <button type="submit" class="h-9 w-9 inline-flex items-center justify-center text-slate-400 hover:text-brand-emerald hover:bg-brand-emerald/10 border border-transparent hover:border-brand-emerald/20 rounded-xl transition-all shadow-sm hover:shadow-md" title="Xác nhận thanh toán">
                                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                            </button>
                                        </form>
                                    <?php endif; ?>
                                <?php endif; ?>

                                <?php if(in_array($dangky->trang_thai, [\App\Enums\RegistrationStatus::Pending, \App\Enums\RegistrationStatus::ApprovedPendingPayment])): ?>
                                    <?php
                                        $isTraPhong = \Illuminate\Support\Str::startsWith((string) $dangky->ghi_chu, 'TRA_PHONG');
                                        $rejectAction = $isTraPhong
                                            ? route('admin.dangky.traphong.tuchoi', ['id' => $dangky->id])
                                            : route('admin.dangky.tuchoi', ['id' => $dangky->id]);
                                        $rejectConfirmMessage = $isTraPhong ? 'Từ chối yêu cầu trả phòng này?' : 'Từ chối hồ sơ đăng ký này?';
                                    ?>
                                    <form method="POST" action="<?php echo e($rejectAction); ?>" data-confirm-message="<?php echo e($rejectConfirmMessage); ?>" onsubmit="return confirm(this.dataset.confirmMessage)">
                                        <?php echo csrf_field(); ?>
                                        <button type="submit" class="h-9 w-9 inline-flex items-center justify-center text-slate-400 hover:text-rose-600 hover:bg-rose-50 border border-transparent hover:border-rose-100 rounded-xl transition-all shadow-sm hover:shadow-md" title="Từ chối">
                                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg>
                                        </button>
                                    </form>
                                <?php endif; ?>

                                <?php if($dangky->trang_thai === \App\Enums\RegistrationStatus::Completed): ?>
                                    <div class="h-9 w-9 inline-flex items-center justify-center text-emerald-400 bg-emerald-50 border border-emerald-100 rounded-xl shadow-sm" title="Đã hoàn tất">
                                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="5" class="py-24 text-center">
                            <div class="flex flex-col items-center gap-4 text-slate-200">
                                <svg class="h-14 w-14" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                <p class="text-sm font-bold text-slate-400 uppercase tracking-widest">Chưa có hồ sơ đăng ký nào</p>
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

        <?php if(method_exists($danhsachdangky, 'links')): ?>
            <div class="mt-8">
                <?php echo e($danhsachdangky->appends(request()->query())->links()); ?>

            </div>
        <?php endif; ?>
    </div>
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
<?php /**PATH D:\laragon\www\hethongquanlyktxv1\resources\views/admin/dangky/danhsach.blade.php ENDPATH**/ ?>