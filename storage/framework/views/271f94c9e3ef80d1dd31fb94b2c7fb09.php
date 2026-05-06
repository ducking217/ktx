<?php $__env->startSection('student_page_title', 'Báo hỏng tài sản'); ?>

<?php $__env->startSection('noidung'); ?>
    <?php
        $total = $danhsachbaohong->count();
        $pending = $danhsachbaohong->filter(function ($item) {
            $value = $item->trang_thai?->value ?? $item->trang_thai;
            return in_array($value, [\App\Enums\BaohongStatus::Pending->value, \App\Enums\BaohongStatus::Processing->value], true);
        })->count();
        $fixed = $danhsachbaohong->filter(function ($item) {
            $value = $item->trang_thai?->value ?? $item->trang_thai;
            return $value === \App\Enums\BaohongStatus::Done->value;
        })->count();
    ?>

    <div class="space-y-8">
        <?php if (isset($component)) { $__componentOriginalcb19cb35a534439097b02b8af91726ee = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalcb19cb35a534439097b02b8af91726ee = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.page-header','data' => ['title' => 'Báo hỏng tài sản','subtitle' => 'Ghi nhận và theo dõi tiến độ khắc phục sự cố tại phòng.']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('admin.page-header'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Báo hỏng tài sản','subtitle' => 'Ghi nhận và theo dõi tiến độ khắc phục sự cố tại phòng.']); ?>
            <?php if($sinhvien?->current_hopdong): ?>
                <button type="button" data-modal-target="modal-thembaohong" data-modal-toggle="modal-thembaohong" class="saas-btn-primary h-11 px-6 shadow-lg shadow-emerald-500/20">
                    <svg class="mr-2 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
                    Gửi yêu cầu mới
                </button>
            <?php else: ?>
                <button type="button" disabled class="saas-btn-primary opacity-50 cursor-not-allowed h-11 px-6 shadow-lg shadow-emerald-500/20">
                    <svg class="mr-2 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
                    Chưa có phòng để báo hỏng
                </button>
            <?php endif; ?>
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

        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <article class="saas-card p-6 relative overflow-hidden group">
                <div class="relative flex items-center gap-4">
                    <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-slate-50 text-slate-600 ring-1 ring-slate-500/10">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                    </div>
                    <div>
                        <div class="text-[10px] font-bold uppercase tracking-widest text-slate-400 mb-0.5">Tổng số yêu cầu</div>
                        <div class="text-2xl font-bold text-slate-900 tabular-nums"><?php echo e($total); ?></div>
                    </div>
                </div>
            </article>

            <article class="saas-card p-6 relative overflow-hidden group">
                <div class="relative flex items-center gap-4">
                    <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-amber-50 text-amber-600 ring-1 ring-amber-500/10">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <div>
                        <div class="text-[10px] font-bold uppercase tracking-widest text-slate-400 mb-0.5">Đang xử lý</div>
                        <div class="text-2xl font-bold text-slate-900 tabular-nums"><?php echo e($pending); ?></div>
                    </div>
                </div>
            </article>

            <article class="saas-card p-6 relative overflow-hidden group">
                <div class="relative flex items-center gap-4">
                    <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-emerald-50 text-emerald-600 ring-1 ring-emerald-500/10">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <div>
                        <div class="text-[10px] font-bold uppercase tracking-widest text-slate-400 mb-0.5">Đã hoàn thành</div>
                        <div class="text-2xl font-bold text-slate-900 tabular-nums"><?php echo e($fixed); ?></div>
                    </div>
                </div>
            </article>
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
                    <th class="px-8 py-6">Nội dung sự cố</th>
                    <th class="px-8 py-6 text-center">Hình ảnh</th>
                    <th class="px-8 py-6 text-center">Tiến độ</th>
                    <th class="px-8 py-6 text-right">Cập nhật</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                <?php $__empty_1 = true; $__currentLoopData = $danhsachbaohong; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $baohong): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr class="hover:bg-slate-50/50 transition-colors group">
                        <td class="px-8 py-5">
                            <div class="text-sm font-medium text-slate-900 leading-relaxed"><?php echo e($baohong->mo_ta); ?></div>
                            <div class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-2 flex items-center gap-2">
                                <span class="bg-slate-100 text-slate-500 px-2 py-0.5 rounded">#REP-<?php echo e(str_pad((string)$baohong->id, 5, '0', STR_PAD_LEFT)); ?></span>
                                <span><?php echo e($baohong->created_at->format('d/m/Y')); ?></span>
                            </div>
                        </td>
                        <td class="px-8 py-5 text-center">
                            <?php if($baohong->hinh_anh_path): ?>
                                <a href="<?php echo e(asset($baohong->hinh_anh_path)); ?>" target="_blank" class="inline-flex h-12 w-12 items-center justify-center rounded-xl bg-slate-50 border border-slate-200 p-0.5 shadow-sm transition-all hover:scale-105">
                                    <img src="<?php echo e(asset($baohong->hinh_anh_path)); ?>" class="h-full w-full object-cover rounded-lg" />
                                </a>
                            <?php else: ?>
                                <div class="inline-flex h-10 w-10 items-center justify-center rounded-xl bg-slate-50 text-slate-300 border border-slate-100">
                                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2-2v12a2 2 0 002 2z"/></svg>
                                </div>
                            <?php endif; ?>
                        </td>
                        <td class="px-8 py-5 text-center">
                            <?php
                                $status = $baohong->trang_thai?->value ?? $baohong->trang_thai;
                                $badgeClass = match($status) {
                                    \App\Enums\BaohongStatus::Done->value => 'saas-badge-success',
                                    \App\Enums\BaohongStatus::Processing->value => 'saas-badge-warning',
                                    \App\Enums\BaohongStatus::Rejected->value => 'saas-badge-error',
                                    default => 'saas-badge-info',
                                };
                                $canEdit = in_array($status, [\App\Enums\BaohongStatus::Pending->value, \App\Enums\BaohongStatus::Processing->value], true);
                            ?>
                            <span class="saas-badge <?php echo e($badgeClass); ?>">
                                <?php echo e($baohong->trang_thai?->label() ?? 'Không xác định'); ?>

                            </span>
                        </td>
                        <td class="px-8 py-5 text-right">
                            <div class="text-sm font-bold text-slate-900"><?php echo e($baohong->updated_at?->format('d/m/Y') ?? '-'); ?></div>
                            <div class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-1"><?php echo e($baohong->updated_at?->format('H:i') ?? '-'); ?></div>
                            <?php if($canEdit): ?>
                                <div class="mt-3">
                                    <button
                                        type="button"
                                        data-modal-target="modal-suabaohong-<?php echo e($baohong->id); ?>"
                                        data-modal-toggle="modal-suabaohong-<?php echo e($baohong->id); ?>"
                                        class="saas-btn-secondary h-9 px-3 text-xs font-semibold"
                                    >
                                        Chỉnh sửa
                                    </button>
                                </div>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="4" class="px-8 py-24 text-center">
                            <div class="flex flex-col items-center gap-4 text-slate-200">
                                <svg class="h-14 w-14" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                                <p class="text-sm font-bold text-slate-400 uppercase tracking-widest">Không có sự cố nào</p>
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
    </div>

    <?php $__env->startPush('modals'); ?>
        <?php if (isset($component)) { $__componentOriginal9f64f32e90b9102968f2bc548315018c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9f64f32e90b9102968f2bc548315018c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.modal','data' => ['id' => 'modal-thembaohong','title' => 'Yêu cầu sửa chữa','subtitle' => 'Mô tả chi tiết sự cố tại phòng để BQL KTX hỗ trợ khắc phục.']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('modal'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['id' => 'modal-thembaohong','title' => 'Yêu cầu sửa chữa','subtitle' => 'Mô tả chi tiết sự cố tại phòng để BQL KTX hỗ trợ khắc phục.']); ?>
            <form action="<?php echo e(route('student.thembaohong')); ?>" method="POST" class="space-y-6" enctype="multipart/form-data">
                <?php echo csrf_field(); ?>
                <div class="space-y-2">
                    <label class="text-[10px] font-bold uppercase tracking-widest text-slate-400 ml-1">Tài sản trong phòng</label>
                    <select name="taisan_id" class="saas-input font-bold h-12">
                        <option value="">-- Chọn tài sản (không bắt buộc) --</option>
                        <?php $__currentLoopData = ($taisanTrongPhong ?? collect()); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ts): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($ts->id); ?>" <?php if(old('taisan_id') == $ts->id): echo 'selected'; endif; ?>>
                                <?php echo e($ts->ten_tai_san); ?>

                            </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>

                <div class="space-y-2">
                    <label class="text-[10px] font-bold uppercase tracking-widest text-slate-400 ml-1">Mô tả sự cố</label>
                    <textarea name="mota" rows="4" class="saas-input !h-auto !py-4 resize-none font-medium" placeholder="Mô tả chi tiết những gì đang bị hỏng..." required></textarea>
                </div>
                
                <div class="space-y-2">
                    <label class="text-[10px] font-bold uppercase tracking-widest text-slate-400 ml-1">Hình ảnh đính kèm (Tùy chọn)</label>
                    <input type="file" name="anhminhhoa" class="saas-input h-auto py-2.5 px-3">
                    <?php $__errorArgs = ['anhminhhoa'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="text-rose-500 text-xs font-medium mt-1"><?php echo e($message); ?></p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <div class="flex gap-4 pt-4">
                    <button type="button" data-modal-hide="modal-thembaohong" class="flex-1 saas-btn-secondary h-12">Hủy bỏ</button>
                    <button type="submit" class="flex-[2] saas-btn-primary h-12 shadow-lg shadow-emerald-500/20" data-no-loading="true">Gửi yêu cầu ngay</button>
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

        <?php $__currentLoopData = $danhsachbaohong; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $baohong): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php
                $status = $baohong->trang_thai?->value ?? $baohong->trang_thai;
                $canEdit = in_array($status, [\App\Enums\BaohongStatus::Pending->value, \App\Enums\BaohongStatus::Processing->value], true);
            ?>
            <?php if($canEdit): ?>
                <?php if (isset($component)) { $__componentOriginal9f64f32e90b9102968f2bc548315018c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9f64f32e90b9102968f2bc548315018c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.modal','data' => ['id' => 'modal-suabaohong-'.e($baohong->id).'','title' => 'Chỉnh sửa báo hỏng','subtitle' => 'Cập nhật mô tả và hình ảnh minh họa cho yêu cầu #REP-'.e(str_pad((string)$baohong->id, 5, '0', STR_PAD_LEFT)).'.']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('modal'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['id' => 'modal-suabaohong-'.e($baohong->id).'','title' => 'Chỉnh sửa báo hỏng','subtitle' => 'Cập nhật mô tả và hình ảnh minh họa cho yêu cầu #REP-'.e(str_pad((string)$baohong->id, 5, '0', STR_PAD_LEFT)).'.']); ?>
                    <form action="<?php echo e(route('student.baohong.update', ['id' => $baohong->id])); ?>" method="POST" class="space-y-6" enctype="multipart/form-data">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('PATCH'); ?>
                        <div class="space-y-2">
                            <label class="text-[10px] font-bold uppercase tracking-widest text-slate-400 ml-1">Tài sản trong phòng</label>
                            <select name="taisan_id" class="saas-input font-bold h-12">
                                <option value="">-- Không chọn tài sản --</option>
                                <?php $__currentLoopData = ($taisanTrongPhong ?? collect()); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ts): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($ts->id); ?>" <?php if((string) ($baohong->taisan_id ?? '') === (string) $ts->id): echo 'selected'; endif; ?>>
                                        <?php echo e($ts->ten_tai_san); ?>

                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>

                        <div class="space-y-2">
                            <label class="text-[10px] font-bold uppercase tracking-widest text-slate-400 ml-1">Mô tả sự cố</label>
                            <textarea name="mota" rows="4" class="saas-input !h-auto !py-4 resize-none font-medium" required><?php echo e(old('mota', $baohong->mo_ta)); ?></textarea>
                        </div>

                        <div class="space-y-2">
                            <label class="text-[10px] font-bold uppercase tracking-widest text-slate-400 ml-1">Cập nhật hình ảnh (Tùy chọn)</label>
                            <input type="file" name="anhminhhoa" class="saas-input h-auto py-2.5 px-3">
                        </div>

                        <div class="flex gap-4 pt-4">
                            <button type="button" data-modal-hide="modal-suabaohong-<?php echo e($baohong->id); ?>" class="flex-1 saas-btn-secondary h-12">Hủy</button>
                            <button type="submit" class="flex-[2] saas-btn-primary h-12 shadow-lg shadow-emerald-500/20" data-no-loading="true">Lưu thay đổi</button>
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
            <?php endif; ?>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    <?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('student.layouts.chinh', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\laragon\www\hethongquanlyktxv1\resources\views/student/baohong/danhsach.blade.php ENDPATH**/ ?>