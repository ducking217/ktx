<?php $__env->startSection('student_page_title', 'Gia hạn hợp đồng'); ?>

<?php $__env->startSection('noidung'); ?>
    <div class="space-y-8">
        <?php if (isset($component)) { $__componentOriginalcb19cb35a534439097b02b8af91726ee = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalcb19cb35a534439097b02b8af91726ee = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.page-header','data' => ['title' => 'Gia hạn hợp đồng','subtitle' => 'Lịch sử yêu cầu gia hạn thời gian lưu trú.']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('admin.page-header'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Gia hạn hợp đồng','subtitle' => 'Lịch sử yêu cầu gia hạn thời gian lưu trú.']); ?>
            <a href="<?php echo e(route('student.giahan.tao')); ?>" class="saas-btn-primary h-11 px-6 shadow-lg shadow-blue-500/20">
                <svg class="mr-2 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
                Gửi yêu cầu mới
            </a>
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

        <!-- Data Table -->
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
                    <th>Hợp đồng</th>
                    <th class="text-center">Ngày mong muốn</th>
                    <th class="text-center">Trạng thái</th>
                    <th>Lý do</th>
                    <th class="text-right">Ghi chú từ BQL</th>
                </tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $yeuCauGiaHan; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr class="hover:bg-slate-50/50 transition-colors group">
                        <td class="py-4">
                            <div class="text-sm font-bold text-slate-900 uppercase tracking-tight"><?php echo e($item->hopdong->ma_hd); ?></div>
                            <div class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-1"><?php echo e($item->hopdong->phong->tenphong ?? 'N/A'); ?></div>
                        </td>
                        <td class="py-4 text-center">
                            <span class="text-xs font-bold text-slate-600 tabular-nums bg-slate-100 px-2 py-1 rounded-lg uppercase tracking-widest"><?php echo e($item->ngay_ket_thuc_moi->format('d/m/Y')); ?></span>
                        </td>
                        <td class="py-4 text-center">
                            <?php
                                $status = $item->trang_thai->value;
                                $badgeClass = match($status) {
                                    'pending' => 'saas-badge-warning',
                                    'approved' => 'saas-badge-success',
                                    'rejected' => 'saas-badge-error',
                                    default => 'bg-slate-100 text-slate-600',
                                };
                            ?>
                            <span class="saas-badge <?php echo e($badgeClass); ?>">
                                <?php if($status === 'pending'): ?>
                                    <span class="mr-1.5 h-1.5 w-1.5 rounded-full bg-current animate-pulse"></span>
                                <?php endif; ?>
                                <?php echo e($item->trang_thai->label()); ?>

                            </span>
                        </td>
                        <td class="py-4">
                            <p class="text-xs font-medium text-slate-700 line-clamp-1" title="<?php echo e($item->ly_do); ?>"><?php echo e($item->ly_do ?: 'Không có lý do'); ?></p>
                        </td>
                        <td class="py-4 text-right">
                            <p class="text-xs font-medium text-slate-500 italic"><?php echo e($item->ghi_chu_admin ?: '—'); ?></p>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="5" class="py-24 text-center">
                            <div class="flex flex-col items-center gap-4 text-slate-200">
                                <svg class="h-14 w-14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                <p class="text-sm font-bold text-slate-400 uppercase tracking-widest">Chưa có yêu cầu gia hạn nào</p>
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
        
        <?php if($yeuCauGiaHan->hasPages()): ?>
            <div class="mt-8">
                <?php echo e($yeuCauGiaHan->links()); ?>

            </div>
        <?php endif; ?>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('student.layouts.chinh', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\laragon\www\hethongquanlyktxv1\resources\views/student/giahan/danhsach.blade.php ENDPATH**/ ?>