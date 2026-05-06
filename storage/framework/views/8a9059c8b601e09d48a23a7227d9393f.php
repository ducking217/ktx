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
     <?php $__env->slot('title', null, []); ?> Nhật ký hoạt động <?php $__env->endSlot(); ?>

    <div class="space-y-6">
        <?php if (isset($component)) { $__componentOriginalcb19cb35a534439097b02b8af91726ee = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalcb19cb35a534439097b02b8af91726ee = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.page-header','data' => ['title' => 'Nhật ký hoạt động','subtitle' => 'Truy xuất nguồn gốc thao tác và kiểm soát biến động dữ liệu toàn cục.']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('admin.page-header'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Nhật ký hoạt động','subtitle' => 'Truy xuất nguồn gốc thao tác và kiểm soát biến động dữ liệu toàn cục.']); ?>
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

        
        <div class="saas-card p-5 border-slate-200/60 shadow-sm">
            <form action="<?php echo e(route('admin.activity-log')); ?>" method="GET" class="grid grid-cols-1 gap-4 md:grid-cols-3 lg:grid-cols-5">
                <div>
                    <label class="block text-[9px] font-bold uppercase tracking-widest text-slate-400 mb-1.5">Thực thể</label>
                    <select name="model" class="saas-input text-xs font-bold">
                        <option value="">Tất cả</option>
                        <?php $__currentLoopData = $models; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $m): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($m); ?>" <?php echo e(request('model') == $m ? 'selected' : ''); ?>><?php echo e($m); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                <div>
                    <label class="block text-[9px] font-bold uppercase tracking-widest text-slate-400 mb-1.5">Quản trị viên</label>
                    <select name="user_id" class="saas-input text-xs font-bold">
                        <option value="">Tất cả</option>
                        <?php $__currentLoopData = $admins; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $admin): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($admin->id); ?>" <?php echo e(request('user_id') == $admin->id ? 'selected' : ''); ?>><?php echo e($admin->name); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                <div>
                    <label class="block text-[9px] font-bold uppercase tracking-widest text-slate-400 mb-1.5">Loại hành động</label>
                    <select name="action" class="saas-input text-xs font-bold">
                        <option value="">Tất cả</option>
                        <?php $__currentLoopData = $actions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $act): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($act); ?>" <?php echo e(request('action') == $act ? 'selected' : ''); ?>><?php echo e($act); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                <div>
                    <label class="block text-[9px] font-bold uppercase tracking-widest text-slate-400 mb-1.5">Từ ngày</label>
                    <input type="date" name="from" value="<?php echo e(request('from')); ?>" class="saas-input text-xs font-bold tabular-nums">
                </div>
                <div class="flex items-end gap-2">
                    <div class="flex-1">
                        <label class="block text-[9px] font-bold uppercase tracking-widest text-slate-400 mb-1.5">Đến ngày</label>
                        <input type="date" name="to" value="<?php echo e(request('to')); ?>" class="saas-input text-xs font-bold tabular-nums">
                    </div>
                    <button type="submit" aria-label="Tìm kiếm" class="saas-btn-primary h-11 w-11 flex-shrink-0 flex items-center justify-center">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="m21 21-4.35-4.35M10.5 18a7.5 7.5 0 1 1 0-15 7.5 7.5 0 0 1 0 15z" /></svg>
                    </button>
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
                    <th>Thời gian</th>
                    <th>Người thực hiện</th>
                    <th>Đối tượng</th>
                    <th class="text-center">Hành động</th>
                    <th class="text-right">Chi tiết</th>
                </tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $logs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $log): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr class="hover:bg-slate-50/50 transition-colors group">
                        <td class="py-4 whitespace-nowrap">
                            <div class="text-xs font-bold text-slate-900 tabular-nums group-hover:text-brand-emerald transition-colors"><?php echo e($log->created_at->format('d/m/Y')); ?></div>
                            <div class="text-[9px] font-bold text-slate-400 tabular-nums mt-0.5 uppercase tracking-widest"><?php echo e($log->created_at->format('H:i:s')); ?></div>
                        </td>
                        <td class="py-4">
                            <div class="flex items-center gap-3">
                                <div class="h-7 w-7 rounded-lg bg-slate-900 flex items-center justify-center text-[9px] font-bold text-white flex-shrink-0">
                                    <?php echo e(substr($log->user->name ?? '?', 0, 1)); ?>

                                </div>
                                <div>
                                    <div class="text-xs font-bold text-slate-900"><?php echo e($log->user->name ?? 'Hệ thống'); ?></div>
                                    <div class="text-[9px] font-bold text-slate-400 uppercase tracking-widest mt-0.5">Quản trị viên</div>
                                </div>
                            </div>
                        </td>
                        <td class="py-4">
                            <div class="flex items-center gap-2">
                                <span class="px-2 py-0.5 rounded bg-slate-100 border border-slate-200/50 text-[9px] font-bold text-slate-600 uppercase tracking-tight"><?php echo e($log->ten_model); ?></span>
                                <span class="text-[9px] font-bold text-slate-400 tabular-nums">#<?php echo e($log->id_ban_ghi); ?></span>
                            </div>
                        </td>
                        <td class="py-4 text-center">
                            <?php
                                $action = strtolower($log->hanh_dong);
                                $badgeClass = match(true) {
                                    str_contains($action, 'tạo') || str_contains($action, 'thêm') || str_contains($action, 'create') => 'saas-badge-success',
                                    str_contains($action, 'cập nhật') || str_contains($action, 'sửa') || str_contains($action, 'update') => 'saas-badge-warning',
                                    str_contains($action, 'xóa') || str_contains($action, 'delete') => 'saas-badge-error',
                                    default => 'saas-badge-info'
                                };
                            ?>
                            <span class="saas-badge <?php echo e($badgeClass); ?> text-[8px] font-bold px-2.5 py-0.5"><?php echo e($log->hanh_dong); ?></span>
                        </td>
                        <td class="py-4 text-right">
                            <button type="button" aria-label="Xem chi tiết" data-modal-target="modal-log-<?php echo e($log->id); ?>" data-modal-toggle="modal-log-<?php echo e($log->id); ?>" class="h-11 w-11 inline-flex items-center justify-center text-slate-400 hover:text-brand-emerald hover:bg-brand-emerald/10 border border-transparent hover:border-brand-emerald/15 rounded-lg transition-all" title="Xem chi tiết">
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            </button>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="5" class="py-16 text-center">
                            <p class="text-[10px] font-bold text-slate-300 uppercase tracking-widest">Không tìm thấy dữ liệu nhật ký</p>
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

        <?php if($logs->hasPages()): ?>
            <div class="py-4">
                <?php echo e($logs->links()); ?>

            </div>
        <?php endif; ?>
    </div>

    <?php $__env->startPush('modals'); ?>
        <?php $__currentLoopData = $logs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $log): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php if (isset($component)) { $__componentOriginal9f64f32e90b9102968f2bc548315018c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9f64f32e90b9102968f2bc548315018c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.modal','data' => ['id' => 'modal-log-'.e($log->id).'','title' => 'Chi tiết thay đổi','subtitle' => 'Biến động dữ liệu của bản ghi #'.e($log->id_ban_ghi).' — '.e($log->ten_model).'']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('modal'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['id' => 'modal-log-'.e($log->id).'','title' => 'Chi tiết thay đổi','subtitle' => 'Biến động dữ liệu của bản ghi #'.e($log->id_ban_ghi).' — '.e($log->ten_model).'']); ?>
                <div class="space-y-5">
                    <div class="grid grid-cols-2 gap-3 rounded-xl bg-slate-50 p-4 border border-slate-100">
                        <div>
                            <div class="text-[9px] font-bold text-slate-400 uppercase tracking-widest mb-1">Thời gian</div>
                            <div class="text-xs font-bold text-slate-900 tabular-nums"><?php echo e($log->created_at->format('d/m/Y H:i:s')); ?></div>
                        </div>
                        <div>
                            <div class="text-[9px] font-bold text-slate-400 uppercase tracking-widest mb-1">Người thực hiện</div>
                            <div class="text-xs font-bold text-slate-900"><?php echo e($log->user->name ?? 'Hệ thống'); ?></div>
                        </div>
                        <div>
                            <div class="text-[9px] font-bold text-slate-400 uppercase tracking-widest mb-1">Hành động</div>
                            <div class="text-xs font-bold text-brand-emerald uppercase"><?php echo e($log->hanh_dong); ?></div>
                        </div>
                        <div>
                            <div class="text-[9px] font-bold text-slate-400 uppercase tracking-widest mb-1">Đối tượng</div>
                            <div class="text-xs font-bold text-slate-900"><?php echo e($log->ten_model); ?> #<?php echo e($log->id_ban_ghi); ?></div>
                        </div>
                    </div>

                    <?php if($log->du_lieu_cu): ?>
                        <div class="space-y-2">
                            <label class="text-[9px] font-bold text-slate-400 uppercase tracking-widest flex items-center gap-1.5">
                                <span class="h-1.5 w-1.5 rounded-full bg-slate-400"></span>
                                Trước thay đổi
                            </label>
                            <div class="bg-slate-900 rounded-xl p-4 border border-slate-800">
                                <pre class="w-full text-[11px] text-slate-300 overflow-x-auto font-mono leading-relaxed"><?php echo e(json_encode($log->du_lieu_cu, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)); ?></pre>
                            </div>
                        </div>
                    <?php endif; ?>

                    <?php if($log->du_lieu_moi): ?>
                        <div class="space-y-2">
                            <label class="text-[9px] font-bold text-brand-emerald uppercase tracking-widest flex items-center gap-1.5">
                                <span class="h-1.5 w-1.5 rounded-full bg-brand-emerald"></span>
                                Sau thay đổi
                            </label>
                            <div class="bg-brand-emerald/5 border border-brand-emerald/15 rounded-xl p-4">
                                <pre class="w-full text-[11px] text-ink-primary overflow-x-auto font-mono leading-relaxed"><?php echo e(json_encode($log->du_lieu_moi, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)); ?></pre>
                            </div>
                        </div>
                    <?php endif; ?>

                    <button type="button" data-modal-hide="modal-log-<?php echo e($log->id); ?>" class="saas-btn-secondary w-full justify-center h-9 text-xs font-bold uppercase tracking-widest">Đóng</button>
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
<?php /**PATH D:\laragon\www\hethongquanlyktxv1\resources\views/admin/activity-log.blade.php ENDPATH**/ ?>