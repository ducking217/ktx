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
     <?php $__env->slot('title', null, []); ?> Quản lý Gia hạn cư trú <?php $__env->endSlot(); ?>

    <div class="space-y-8">
        <?php if (isset($component)) { $__componentOriginalcb19cb35a534439097b02b8af91726ee = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalcb19cb35a534439097b02b8af91726ee = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.page-header','data' => ['title' => 'Yêu cầu gia hạn','subtitle' => 'Thẩm định nguyện vọng kéo dài thời gian lưu trú và cập nhật chu kỳ hợp đồng mới.']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('admin.page-header'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Yêu cầu gia hạn','subtitle' => 'Thẩm định nguyện vọng kéo dài thời gian lưu trú và cập nhật chu kỳ hợp đồng mới.']); ?>
            <form action="<?php echo e(route('admin.giahan.index')); ?>" method="GET" class="flex items-center gap-3">
                <label class="sr-only" for="extension-status">Bộ lọc trạng thái</label>
                <div class="relative group">
                    <select id="extension-status" name="status" onchange="this.form.submit()" class="saas-input !h-11 !pr-10 font-bold uppercase tracking-widest text-[10px] min-w-[200px] shadow-sm">
                        <option value="Tất cả" <?php echo e($status === 'Tất cả' ? 'selected' : ''); ?>>Mọi trạng thái</option>
                        <?php $__currentLoopData = \App\Enums\ExtensionStatus::cases(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $case): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($case->value); ?>" <?php echo e($status === $case->value ? 'selected' : ''); ?>><?php echo e($case->label()); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                    <div class="absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none text-slate-400 group-hover:text-brand-emerald transition-colors">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"/></svg>
                    </div>
                </div>
            </form>
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
                    <th>Cư dân / Định danh</th>
                    <th>Hợp đồng hiện tại</th>
                    <th class="text-center">Chu kỳ cũ</th>
                    <th class="text-center">Đề xuất gia hạn</th>
                    <th class="text-center">Trạng thái</th>
                    <th class="text-right">Hành động</th>
                </tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $yeuCauGiaHan; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr class="hover:bg-slate-50/50 transition-colors group">
                        <td class="py-5">
                            <div class="text-sm font-bold text-slate-900 group-hover:text-brand-emerald transition-colors leading-tight"><?php echo e($item->sinhvien?->user?->name ?? $item->sinhvien?->taikhoan?->name ?? 'Chưa có'); ?></div>
                            <div class="text-[10px] font-bold text-slate-400 uppercase tracking-[0.1em] mt-1.5"><?php echo e($item->sinhvien?->ma_sinh_vien ?? $item->sinhvien?->masinhvien ?? 'Chưa có'); ?></div>
                        </td>
                        <td class="py-5">
                            <div class="text-xs font-bold text-slate-900 tabular-nums tracking-tight"><?php echo e($item->hopdong?->ma_hd ?? ($item->hopdong ? 'HĐ-' . $item->hopdong->id : 'Chưa có')); ?></div>
                            <div class="flex items-center gap-1.5 text-[10px] font-bold text-brand-emerald uppercase tracking-widest mt-1.5">
                                <span class="h-1 w-1 rounded-full bg-brand-emerald"></span>
                                <?php echo e($item->hopdong?->phong?->ten_phong ?? 'Chưa có'); ?>

                            </div>
                        </td>
                        <td class="py-5 text-center">
                            <div class="text-xs font-bold text-slate-500 tabular-nums tracking-tight">
                                <?php echo e($item->hopdong?->ngay_ket_thuc?->format('d/m/Y') ?? 'Chưa có'); ?>

                            </div>
                        </td>
                        <td class="py-5 text-center">
                            <div class="text-xs font-bold text-emerald-600 tabular-nums tracking-tight bg-emerald-50 px-2.5 py-1 rounded-lg inline-block">
                                <?php echo e($item->ngay_ket_thuc_moi?->format('d/m/Y') ?? 'Chưa có'); ?>

                            </div>
                        </td>
                        <td class="py-5 text-center">
                            <?php
                                $statusEnumExt = $item->trang_thai;
                                $statusBadgeExt = match($statusEnumExt->value) {
                                    'pending' => 'saas-badge-warning',
                                    'approved' => 'saas-badge-success',
                                    'rejected' => 'saas-badge-error',
                                    default => 'saas-badge-info',
                                };
                            ?>
                            <span class="saas-badge <?php echo e($statusBadgeExt); ?>">
                                <?php echo e($statusEnumExt->label()); ?>

                            </span>
                        </td>
                        <td class="py-5 text-right">
                            <div class="flex items-center justify-end gap-1">
                                <?php if($item->trang_thai->value === 'pending'): ?>
                                    <button type="button" data-modal-target="modal-approve-<?php echo e($item->id); ?>" data-modal-toggle="modal-approve-<?php echo e($item->id); ?>" class="p-2 text-emerald-500 hover:text-emerald-600 hover:bg-emerald-50 rounded transition-colors" title="Chấp thuận gia hạn">
                                        <svg class="h-4.5 w-4.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                    </button>
                                    <button type="button" data-modal-target="modal-reject-<?php echo e($item->id); ?>" data-modal-toggle="modal-reject-<?php echo e($item->id); ?>" class="p-2 text-rose-500 hover:text-rose-600 hover:bg-rose-50 rounded transition-colors" title="Từ chối yêu cầu">
                                        <svg class="h-4.5 w-4.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg>
                                    </button>
                                <?php else: ?>
                                    <span class="text-[10px] font-bold text-slate-300 uppercase tracking-widest px-2">Xử lý xong</span>
                                <?php endif; ?>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="6" class="py-24 text-center">
                            <div class="flex flex-col items-center gap-4 text-slate-200">
                                <svg class="h-14 w-14" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                <p class="text-sm font-bold text-slate-400 uppercase tracking-widest">Không tìm thấy yêu cầu gia hạn</p>
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

    <?php $__env->startPush('modals'); ?>
        <?php $__currentLoopData = $yeuCauGiaHan; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            
            <?php if (isset($component)) { $__componentOriginal9f64f32e90b9102968f2bc548315018c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9f64f32e90b9102968f2bc548315018c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.modal','data' => ['id' => 'modal-approve-'.e($item->id).'','title' => 'Phê duyệt gia hạn','subtitle' => 'Xác nhận kéo dài thời hạn lưu trú cho cư dân theo đề xuất mới.']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('modal'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['id' => 'modal-approve-'.e($item->id).'','title' => 'Phê duyệt gia hạn','subtitle' => 'Xác nhận kéo dài thời hạn lưu trú cho cư dân theo đề xuất mới.']); ?>
                <div class="p-6 rounded-2xl bg-emerald-50/50 border border-emerald-100/60 mb-6">
                    <div class="flex items-center gap-4">
                        <div class="h-12 w-12 rounded-xl bg-white border border-emerald-100/60 flex items-center justify-center shadow-sm">
                            <svg class="h-6 w-6 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        </div>
                        <div>
                            <div class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Hạn cư trú mới</div>
                            <div class="text-lg font-bold text-slate-900 tabular-nums"><?php echo e($item->ngay_ket_thuc_moi?->format('d/m/Y') ?? 'Chưa có'); ?></div>
                        </div>
                    </div>
                </div>

                <form action="<?php echo e(route('admin.giahan.duyet', $item->id)); ?>" method="POST" class="space-y-6">
                    <?php echo csrf_field(); ?>
                    <div class="space-y-2">
                        <label for="ghi_chu_admin_approve_<?php echo e($item->id); ?>" class="text-[10px] font-bold text-slate-400 uppercase tracking-widest ml-1">Phản hồi cho cư dân</label>
                        <textarea id="ghi_chu_admin_approve_<?php echo e($item->id); ?>" name="ghi_chu_admin" rows="4" class="saas-input !h-auto !py-4 resize-none" placeholder="Ví dụ: Đã phê duyệt gia hạn. Vui lòng hoàn tất nghĩa vụ tài chính trước ngày ghi nhận..."></textarea>
                    </div>
                    <div class="flex gap-3 pt-2">
                        <button type="button" data-modal-hide="modal-approve-<?php echo e($item->id); ?>" class="saas-btn-secondary flex-1 h-12">Hủy bỏ</button>
                        <button type="submit" class="saas-btn-primary flex-1 h-12 shadow-lg shadow-emerald-500/20 !bg-emerald-600 hover:!bg-emerald-700">Xác nhận phê duyệt</button>
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
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.modal','data' => ['id' => 'modal-reject-'.e($item->id).'','title' => 'Từ chối gia hạn','subtitle' => 'Yêu cầu cung cấp lý do cụ thể khi không chấp thuận gia hạn cư trú cho sinh viên.']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('modal'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['id' => 'modal-reject-'.e($item->id).'','title' => 'Từ chối gia hạn','subtitle' => 'Yêu cầu cung cấp lý do cụ thể khi không chấp thuận gia hạn cư trú cho sinh viên.']); ?>
                <form action="<?php echo e(route('admin.giahan.tuchoi', $item->id)); ?>" method="POST" class="space-y-6">
                    <?php echo csrf_field(); ?>
                    <div class="space-y-2">
                        <label for="ghi_chu_admin_reject_<?php echo e($item->id); ?>" class="text-[10px] font-bold text-slate-400 uppercase tracking-widest ml-1">Lý do từ chối <span class="text-rose-500">*</span></label>
                        <textarea id="ghi_chu_admin_reject_<?php echo e($item->id); ?>" name="ghi_chu_admin" rows="4" required class="saas-input !h-auto !py-4 border-rose-100 focus:border-rose-500 resize-none" placeholder="Vui lòng nêu rõ lý do không gia hạn (Vi phạm kỷ luật, không thuộc đối tượng ưu tiên...)"></textarea>
                    </div>
                    <div class="flex gap-3 pt-2">
                        <button type="button" data-modal-hide="modal-reject-<?php echo e($item->id); ?>" class="saas-btn-secondary flex-1 h-12">Quay lại</button>
                        <button type="submit" class="saas-btn-primary flex-1 h-12 shadow-lg shadow-rose-500/20 !bg-rose-600 hover:!bg-rose-700">Xác nhận từ chối</button>
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
<?php /**PATH D:\laragon\www\hethongquanlyktxv1\resources\views/admin/giahan/danhsach.blade.php ENDPATH**/ ?>