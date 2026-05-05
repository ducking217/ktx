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
     <?php $__env->slot('title', null, []); ?> Quản lý gia hạn <?php $__env->endSlot(); ?>

    <div class="space-y-8 animate-fade-up">
        <?php if (isset($component)) { $__componentOriginalcb19cb35a534439097b02b8af91726ee = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalcb19cb35a534439097b02b8af91726ee = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.page-header','data' => ['title' => 'Yêu cầu gia hạn','subtitle' => 'Danh sách sinh viên gửi yêu cầu kéo dài thời gian lưu trú']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('admin.page-header'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Yêu cầu gia hạn','subtitle' => 'Danh sách sinh viên gửi yêu cầu kéo dài thời gian lưu trú']); ?>
            <form action="<?php echo e(route('admin.giahan.index')); ?>" method="GET" class="flex items-center gap-2">
                <label class="sr-only" for="extension-status">Trạng thái yêu cầu gia hạn</label>
                <select id="extension-status" name="status" onchange="this.form.submit()" class="bg-ui-card border-ui-border rounded-xl text-[10px] font-black uppercase tracking-widest px-4 py-2 focus:ring-2 focus:ring-brand-emerald/20 transition-all">
                    <option value="Tất cả" <?php echo e($status === 'Tất cả' ? 'selected' : ''); ?>>Tất cả trạng thái</option>
                    <?php $__currentLoopData = \App\Enums\ExtensionStatus::cases(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $case): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($case->value); ?>" <?php echo e($status === $case->value ? 'selected' : ''); ?>><?php echo e($case->label()); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
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

        <article class="pdu-card !p-0 overflow-hidden shadow-xl shadow-ink-primary/5">
            <div class="hidden md:block overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="adm-tableCard__head">
                            <th scope="col" class="px-6 py-4">Sinh viên</th>
                            <th scope="col" class="px-6 py-4">Hợp đồng</th>
                            <th scope="col" class="px-6 py-4">Ngày hết hạn cũ</th>
                            <th scope="col" class="px-6 py-4">Ngày mong muốn</th>
                            <th scope="col" class="px-6 py-4">Lý do</th>
                            <th scope="col" class="px-6 py-4">Trạng thái</th>
                            <th scope="col" class="px-6 py-4 text-right">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-ui-border">
                        <?php $__empty_1 = true; $__currentLoopData = $yeuCauGiaHan; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr class="group hover:bg-ui-bg/30 transition-colors">
                                <td class="px-6 py-5">
                                    <div class="font-bold text-ink-primary tracking-tight"><?php echo e($item->sinhvien?->user?->name ?? $item->sinhvien?->taikhoan?->name ?? 'N/A'); ?></div>
                                    <div class="text-[10px] font-bold text-ink-secondary/40 uppercase tracking-widest"><?php echo e($item->sinhvien?->ma_sinh_vien ?? $item->sinhvien?->masinhvien ?? 'N/A'); ?></div>
                                </td>
                                <td class="px-6 py-5">
                                    <div class="font-display font-black text-ink-primary tracking-tight"><?php echo e($item->hopdong ? 'HD-' . $item->hopdong->id : 'N/A'); ?></div>
                                    <div class="text-[10px] font-bold text-ink-secondary/40 uppercase tracking-widest"><?php echo e($item->hopdong?->phong?->ten_phong ?? 'N/A'); ?></div>
                                </td>
                                <td class="px-6 py-5 font-medium text-ink-secondary tabular-nums tracking-tight">
                                    <?php echo e($item->hopdong?->ngay_ket_thuc?->format('d/m/Y') ?? 'N/A'); ?>

                                </td>
                                <td class="px-6 py-5 font-bold text-brand-emerald tabular-nums tracking-tight">
                                    <?php echo e($item->ngay_ket_thuc_moi?->format('d/m/Y') ?? 'N/A'); ?>

                                </td>
                                <td class="px-6 py-5">
                                    <p class="text-xs text-ink-secondary/70 max-w-xs truncate" title="<?php echo e($item->ly_do); ?>">
                                        <?php echo e($item->ly_do ?: '—'); ?>

                                    </p>
                                </td>
                                <td class="px-6 py-5">
                                    <span class="<?php echo \Illuminate\Support\Arr::toCssClasses([
                                        'inline-flex items-center rounded-lg px-2.5 py-1 text-[9px] font-black uppercase tracking-widest ring-1',
                                        'bg-status-warning/10 text-status-warning ring-status-warning/20' => $item->trang_thai->value === 'pending',
                                        'bg-status-success/10 text-status-success ring-status-success/20' => $item->trang_thai->value === 'approved',
                                        'bg-status-error/10 text-status-error ring-status-error/20' => $item->trang_thai->value === 'rejected',
                                    ]); ?>">
                                        <?php echo e($item->trang_thai->label()); ?>

                                    </span>
                                </td>
                                <td class="px-6 py-5 text-right">
                                    <?php if($item->trang_thai->value === 'pending'): ?>
                                        <div class="flex items-center justify-end gap-2">
                                            <button onclick="openModal('modal-approve-<?php echo e($item->id); ?>')" class="pdu-btn-ghost !text-status-success !bg-status-success/5 hover:!bg-status-success/10 !px-3 !py-1.5 text-[9px] uppercase tracking-widest" aria-label="Duyệt yêu cầu">Duyệt</button>
                                            <button onclick="openModal('modal-reject-<?php echo e($item->id); ?>')" class="pdu-btn-ghost !text-status-error !bg-status-error/5 hover:!bg-status-error/10 !px-3 !py-1.5 text-[9px] uppercase tracking-widest" aria-label="Từ chối yêu cầu">Từ chối</button>
                                        </div>
                                    <?php else: ?>
                                        <span class="text-[9px] font-black text-ink-secondary/30 uppercase tracking-widest">Đã xử lý</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="7" class="adm-empty">
                                    <?php if (isset($component)) { $__componentOriginal074a021b9d42f490272b5eefda63257c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal074a021b9d42f490272b5eefda63257c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.empty-state','data' => ['title' => 'Không có yêu cầu nào','description' => 'Chưa có yêu cầu gia hạn phù hợp với bộ lọc hiện tại.']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('empty-state'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Không có yêu cầu nào','description' => 'Chưa có yêu cầu gia hạn phù hợp với bộ lọc hiện tại.']); ?>
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
                </table>
            </div>

            
            <div class="md:hidden divide-y divide-ui-border">
                <?php $__empty_1 = true; $__currentLoopData = $yeuCauGiaHan; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <div class="p-5 space-y-4">
                        <div class="flex items-start justify-between">
                            <div>
                                <div class="font-bold text-ink-primary tracking-tight"><?php echo e($item->sinhvien?->user?->name ?? $item->sinhvien?->taikhoan?->name ?? 'N/A'); ?></div>
                                <div class="text-[10px] font-bold text-ink-secondary/40 uppercase tracking-widest"><?php echo e($item->sinhvien?->ma_sinh_vien ?? $item->sinhvien?->masinhvien ?? 'N/A'); ?></div>
                            </div>
                            <span class="<?php echo \Illuminate\Support\Arr::toCssClasses([
                                'inline-flex items-center rounded-lg px-2 py-0.5 text-[8px] font-black uppercase tracking-widest ring-1',
                                'bg-status-warning/10 text-status-warning ring-status-warning/20' => $item->trang_thai->value === 'pending',
                                'bg-status-success/10 text-status-success ring-status-success/20' => $item->trang_thai->value === 'approved',
                                'bg-status-error/10 text-status-error ring-status-error/20' => $item->trang_thai->value === 'rejected',
                            ]); ?>">
                                <?php echo e($item->trang_thai->label()); ?>

                            </span>
                        </div>

                        <div class="grid grid-cols-2 gap-4 rounded-xl bg-ui-bg/30 p-4 ring-1 ring-inset ring-ui-border">
                            <div class="space-y-1">
                                <div class="text-[8px] font-bold text-ink-secondary/40 uppercase tracking-widest">Phòng cư trú</div>
                                <div class="text-xs font-bold text-ink-primary"><?php echo e($item->hopdong?->phong?->ten_phong ?? 'N/A'); ?></div>
                            </div>
                            <div class="space-y-1">
                                <div class="text-[8px] font-bold text-ink-secondary/40 uppercase tracking-widest">Hợp đồng</div>
                                <div class="text-xs font-bold text-ink-primary tabular-nums"><?php echo e($item->hopdong ? 'HD-' . $item->hopdong->id : 'N/A'); ?></div>
                            </div>
                            <div class="space-y-1">
                                <div class="text-[8px] font-bold text-ink-secondary/40 uppercase tracking-widest">Hết hạn cũ</div>
                                <div class="text-xs font-bold text-ink-secondary tabular-nums tracking-tight"><?php echo e($item->hopdong?->ngay_ket_thuc?->format('d/m/Y') ?? 'N/A'); ?></div>
                            </div>
                            <div class="space-y-1">
                                <div class="text-[8px] font-bold text-ink-secondary/40 uppercase tracking-widest text-brand-emerald">Gia hạn đến</div>
                                <div class="text-xs font-bold text-brand-emerald tabular-nums tracking-tight"><?php echo e($item->ngay_ket_thuc_moi?->format('d/m/Y') ?? 'N/A'); ?></div>
                            </div>
                        </div>

                        <?php if($item->trang_thai->value === 'pending'): ?>
                            <div class="flex items-center gap-2">
                                <button onclick="openModal('modal-approve-<?php echo e($item->id); ?>')" class="flex-1 h-11 flex items-center justify-center rounded-xl bg-status-success text-[10px] font-black uppercase tracking-widest text-white shadow-lg shadow-status-success/10">Duyệt</button>
                                <button onclick="openModal('modal-reject-<?php echo e($item->id); ?>')" class="flex-1 h-11 flex items-center justify-center rounded-xl bg-status-error text-[10px] font-black uppercase tracking-widest text-white shadow-lg shadow-status-error/10">Từ chối</button>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <div class="py-16 px-6">
                        <?php if (isset($component)) { $__componentOriginal074a021b9d42f490272b5eefda63257c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal074a021b9d42f490272b5eefda63257c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.empty-state','data' => ['title' => 'Không có yêu cầu nào','description' => 'Chưa có yêu cầu gia hạn phù hợp với bộ lọc hiện tại.']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('empty-state'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Không có yêu cầu nào','description' => 'Chưa có yêu cầu gia hạn phù hợp với bộ lọc hiện tại.']); ?>
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
                    </div>
                <?php endif; ?>
            </div>

            <?php if($yeuCauGiaHan->hasPages()): ?>
                <div class="px-6 py-4 bg-ui-bg/30 border-t border-ui-border">
                    <?php echo e($yeuCauGiaHan->links()); ?>

                </div>
            <?php endif; ?>
        </article>
    </div>

    <?php $__env->startPush('modals'); ?>
        <?php $__currentLoopData = $yeuCauGiaHan; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            
            <div id="modal-approve-<?php echo e($item->id); ?>" class="fixed inset-0 z-[100] hidden items-center justify-center p-4 bg-ink-primary/60 backdrop-blur-sm animate-fade-in">
                <div class="bg-ui-card w-full max-w-md rounded-2xl p-8 shadow-2xl animate-pop-in">
                    <h3 class="font-display text-xl font-black text-ink-primary uppercase tracking-tight mb-2">Duyệt gia hạn</h3>
                    <p class="text-xs text-ink-secondary/60 mb-6">Bạn đang duyệt gia hạn cho sinh viên <strong><?php echo e($item->sinhvien?->taikhoan?->name ?? 'N/A'); ?></strong> đến ngày <strong class="tabular-nums tracking-tight"><?php echo e($item->ngay_ket_thuc_moi?->format('d/m/Y') ?? 'N/A'); ?></strong>.</p>
                    
                    <form action="<?php echo e(route('admin.giahan.duyet', $item->id)); ?>" method="POST" class="space-y-4 text-left">
                        <?php echo csrf_field(); ?>
                        <div class="space-y-2">
                            <label class="text-[10px] font-black text-ink-primary uppercase tracking-widest">Ghi chú cho sinh viên</label>
                            <textarea name="ghi_chu_admin" rows="3" class="w-full bg-ui-bg border-ui-border rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-brand-emerald/20 transition-all resize-none" placeholder="Ví dụ: Đã duyệt gia hạn cho học kỳ tiếp theo..."></textarea>
                        </div>
                        <div class="flex items-center justify-end gap-3 pt-4 border-t border-ui-border">
                            <button type="button" onclick="closeModal('modal-approve-<?php echo e($item->id); ?>')" class="pdu-btn-ghost">Hủy</button>
                            <button type="submit" class="pdu-btn-primary !bg-status-success !border-status-success shadow-lg shadow-status-success/20">Xác nhận duyệt</button>
                        </div>
                    </form>
                </div>
            </div>

            
            <div id="modal-reject-<?php echo e($item->id); ?>" class="fixed inset-0 z-[100] hidden items-center justify-center p-4 bg-ink-primary/60 backdrop-blur-sm animate-fade-in">
                <div class="bg-ui-card w-full max-w-md rounded-2xl p-8 shadow-2xl animate-pop-in">
                    <h3 class="font-display text-xl font-black text-status-error uppercase tracking-tight mb-2">Từ chối gia hạn</h3>
                    <p class="text-xs text-ink-secondary/60 mb-6">Vui lòng nhập lý do từ chối yêu cầu của <strong><?php echo e($item->sinhvien?->taikhoan?->name ?? 'N/A'); ?></strong>.</p>
                    
                    <form action="<?php echo e(route('admin.giahan.tuchoi', $item->id)); ?>" method="POST" class="space-y-4 text-left">
                        <?php echo csrf_field(); ?>
                        <div class="space-y-2">
                            <label class="text-[10px] font-black text-ink-primary uppercase tracking-widest">Lý do từ chối <span class="text-status-error">*</span></label>
                            <textarea name="ghi_chu_admin" rows="3" required class="w-full bg-ui-bg border-ui-border rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-status-error/20 transition-all resize-none" placeholder="Ví dụ: Sinh viên vi phạm kỷ luật, không đủ điều kiện gia hạn..."></textarea>
                        </div>
                        <div class="flex items-center justify-end gap-3 pt-4 border-t border-ui-border">
                            <button type="button" onclick="closeModal('modal-reject-<?php echo e($item->id); ?>')" class="pdu-btn-ghost">Hủy</button>
                            <button type="submit" class="pdu-btn-primary !bg-status-error !border-status-error shadow-lg shadow-status-error/20">Từ chối ngay</button>
                        </div>
                    </form>
                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    <?php $__env->stopPush(); ?>

    <script>
        function openModal(id) {
            document.getElementById(id).classList.remove('hidden');
            document.getElementById(id).classList.add('flex');
            document.body.classList.add('overflow-hidden');
        }
        function closeModal(id) {
            document.getElementById(id).classList.add('hidden');
            document.getElementById(id).classList.remove('flex');
            document.body.classList.remove('overflow-hidden');
        }
    </script>
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