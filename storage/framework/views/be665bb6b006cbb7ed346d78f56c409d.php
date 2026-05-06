<?php $__env->startSection('student_page_title', 'Lịch sử kỷ luật'); ?>

<?php $__env->startSection('noidung'); ?>
    <div class="space-y-8">
        <?php if (isset($component)) { $__componentOriginalcb19cb35a534439097b02b8af91726ee = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalcb19cb35a534439097b02b8af91726ee = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.page-header','data' => ['title' => 'Lịch sử vi phạm','subtitle' => 'Theo dõi các biên bản ghi nhận vi phạm nội quy nội trú.']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('admin.page-header'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Lịch sử vi phạm','subtitle' => 'Theo dõi các biên bản ghi nhận vi phạm nội quy nội trú.']); ?>
            <div class="flex items-center gap-3 rounded-xl bg-slate-50 border border-slate-200 px-4 py-2.5">
                <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-rose-600 text-white shadow-sm">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>
                </div>
                <div>
                    <div class="text-[10px] font-bold uppercase tracking-widest text-slate-500">Tổng vi phạm</div>
                    <div class="text-sm font-bold text-slate-900 tabular-nums"><?php echo e($kyluat->count()); ?> Lần</div>
                </div>
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
                    <th class="px-6 py-4">Ngày ghi nhận</th>
                    <th class="px-6 py-4">Nội dung vi phạm</th>
                    <th class="px-6 py-4 text-center">Hình thức xử lý</th>
                    <th class="px-6 py-4 text-right">Mức độ</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                <?php $__empty_1 = true; $__currentLoopData = $kyluat; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr class="hover:bg-slate-50/50 transition-colors group">
                        <td class="px-6 py-5">
                            <div class="text-sm font-bold text-slate-900 tabular-nums"><?php echo e(date('d/m/Y', strtotime($item->ngay_vi_pham))); ?></div>
                            <div class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-1">Học kỳ <?php echo e(date('m', strtotime($item->ngay_vi_pham)) > 6 ? 'I' : 'II'); ?> • <?php echo e(date('Y', strtotime($item->ngay_vi_pham))); ?></div>
                        </td>
                        <td class="px-6 py-5">
                            <div class="max-w-md">
                                <div class="text-sm font-medium text-slate-700 leading-relaxed"><?php echo e($item->noi_dung); ?></div>
                                <div class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-2 flex items-center gap-1.5">
                                    <span class="bg-slate-100 text-slate-500 px-2 py-0.5 rounded">#KL-<?php echo e(str_pad((string)$item->id, 4, '0', STR_PAD_LEFT)); ?></span>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-5 text-center">
                            <span class="text-xs font-bold text-slate-600 bg-slate-100 px-3 py-1 rounded-lg border border-slate-200">
                                <?php echo e($item->hinh_thuc_xu_ly ?? '—'); ?>

                            </span>
                        </td>
                        <td class="px-6 py-5 text-right">
                            <?php
                                $mucdoEnum = $item->muc_do?->value ?? $item->muc_do;
                                $badgeClass = match($mucdoEnum) {
                                    \App\Enums\DisciplineLevel::High->value => 'saas-badge-error',
                                    \App\Enums\DisciplineLevel::Medium->value => 'saas-badge-warning',
                                    default => 'saas-badge-info',
                                };
                            ?>
                            <span class="saas-badge <?php echo e($badgeClass); ?>">
                                <?php echo e($item->muc_do?->label() ?? 'Không xác định'); ?>

                            </span>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="4" class="px-6 py-20 text-center">
                            <div class="flex flex-col items-center gap-4 text-slate-200">
                                <svg class="h-14 w-14" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>
                                <p class="text-sm font-bold text-slate-400 uppercase tracking-widest">Chưa có biên bản nào</p>
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
<?php $__env->stopSection(); ?>

<?php echo $__env->make('student.layouts.chinh', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\laragon\www\hethongquanlyktxv1\resources\views/student/kyluat/index.blade.php ENDPATH**/ ?>