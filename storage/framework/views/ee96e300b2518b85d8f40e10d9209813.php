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
     <?php $__env->slot('title', null, []); ?> Thiết lập thông số vận hành <?php $__env->endSlot(); ?>

    <?php if (isset($component)) { $__componentOriginalcb19cb35a534439097b02b8af91726ee = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalcb19cb35a534439097b02b8af91726ee = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.page-header','data' => ['title' => 'Trung tâm Cấu hình','subtitle' => 'Quản lý định mức tài chính và thông số định danh hệ thống.']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('admin.page-header'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Trung tâm Cấu hình','subtitle' => 'Quản lý định mức tài chính và thông số định danh hệ thống.']); ?>
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

    <div class="mt-10">
        <article class="max-w-4xl rounded-[2.5rem] bg-ui-card border border-ui-border shadow-soft overflow-hidden">
            <div class="bg-ui-bg/20 border-b border-ui-border/60 px-10 py-6 flex items-center justify-between">
                <div>
                    <h3 class="text-[10px] font-black uppercase tracking-[0.2em] text-ink-secondary/40">Bảng tham số định mức</h3>
                    <p class="text-xs font-medium text-ink-secondary/60 mt-1">Dữ liệu cơ sở cho thuật toán kết xuất hóa đơn.</p>
                </div>
                <div class="h-10 w-10 flex items-center justify-center rounded-xl bg-ui-bg text-ink-secondary/40 ring-1 ring-ui-border">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                </div>
            </div>
            
            <form method="POST" action="<?php echo e(route('admin.capnhatcauhinh')); ?>" class="p-10 space-y-12">
                <?php echo csrf_field(); ?>
                <div class="grid gap-10 md:grid-cols-2">
                    <div class="space-y-8">
                        <div class="space-y-3">
                            <label class="block text-[10px] font-black text-ink-secondary/40 uppercase tracking-[0.2em] ml-2">Đơn giá Điện năng (kWh)</label>
                            <div class="relative group">
                                <input type="number" min="0" step="0.01" name="gia_dien"
                                       value="<?php echo e(old('gia_dien', $cauhinh['gia_dien']->giatri ?? '')); ?>"
                                       class="linear-input w-full !py-4 font-black tabular-nums pr-16 text-sm" required>
                                <span class="absolute right-5 top-1/2 -translate-y-1/2 text-[10px] font-black text-ink-secondary/30 uppercase tracking-widest">VNĐ</span>
                            </div>
                        </div>
                        <div class="space-y-3">
                            <label class="block text-[10px] font-black text-ink-secondary/40 uppercase tracking-[0.2em] ml-2">Đơn giá Thủy lượng (m³)</label>
                            <div class="relative group">
                                <input type="number" min="0" step="0.01" name="gia_nuoc"
                                       value="<?php echo e(old('gia_nuoc', $cauhinh['gia_nuoc']->giatri ?? '')); ?>"
                                       class="linear-input w-full !py-4 font-black tabular-nums pr-16 text-sm" required>
                                <span class="absolute right-5 top-1/2 -translate-y-1/2 text-[10px] font-black text-ink-secondary/30 uppercase tracking-widest">VNĐ</span>
                            </div>
                        </div>
                    </div>

                    <div class="space-y-8">
                        <div class="space-y-3">
                            <label class="block text-[10px] font-black text-ink-secondary/40 uppercase tracking-[0.2em] ml-2">Hotline Điều hành</label>
                            <div class="relative group">
                                <input type="text" name="hotline"
                                       value="<?php echo e(old('hotline', $cauhinh['hotline']->giatri ?? '')); ?>"
                                       class="linear-input w-full !py-4 font-black tabular-nums pl-14 text-sm" required>
                                <div class="absolute left-5 top-1/2 -translate-y-1/2 text-ink-secondary/30 transition-colors group-focus-within:text-brand-emerald">
                                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1.01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                                </div>
                            </div>
                        </div>
                        
                        <div class="rounded-3xl bg-ui-bg/30 p-6 ring-1 ring-ui-border/60 shadow-soft">
                            <div class="flex gap-4">
                                <div class="h-10 w-10 shrink-0 flex items-center justify-center rounded-xl bg-ui-bg text-ink-secondary/40 ring-1 ring-ui-border">
                                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                </div>
                                <p class="text-xs font-medium leading-relaxed italic text-ink-secondary/60">
                                    Mọi thay đổi tại đây sẽ có hiệu lực tức thì cho các chu kỳ tính toán tài chính tiếp theo. Hãy đảm bảo tính chính xác tuyệt đối.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex justify-end pt-8 border-t border-ui-border/60">
                    <button type="submit" class="pdu-btn-primary !px-10 !py-4 shadow-xl shadow-brand-emerald/10 uppercase tracking-widest text-[11px] font-black">
                        Lưu tham số vận hành
                    </button>
                </div>
            </form>
        </article>
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
<?php /**PATH D:\laragon\www\hethongquanlyktxv1\resources\views/admin/cauhinh/index.blade.php ENDPATH**/ ?>