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
     <?php $__env->slot('title', null, []); ?> Lịch trình bảo trì định kỳ <?php $__env->endSlot(); ?>

    <div class="space-y-6">
        <?php if (isset($component)) { $__componentOriginalcb19cb35a534439097b02b8af91726ee = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalcb19cb35a534439097b02b8af91726ee = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.page-header','data' => ['title' => 'Kế hoạch bảo trì','subtitle' => 'Điều phối hoạt động bảo dưỡng hạ tầng.']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('admin.page-header'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Kế hoạch bảo trì','subtitle' => 'Điều phối hoạt động bảo dưỡng hạ tầng.']); ?>
            <button type="button" data-modal-target="modal-thembaotri" data-modal-toggle="modal-thembaotri" class="pdu-btn-primary !min-h-[44px]" aria-label="Lập lịch bảo trì mới">
                Lập lịch mới
            </button>
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
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.table-card','data' => ['caption' => 'Danh sách lịch trình bảo trì']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('admin.table-card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['caption' => 'Danh sách lịch trình bảo trì']); ?>
            <thead class="adm-tableCard__head">
                <tr>
                    <th scope="col" class="px-6 py-4 font-bold">Đối tượng (Phòng)</th>
                    <th scope="col" class="px-6 py-4 font-bold">Nội dung công việc</th>
                    <th scope="col" class="px-6 py-4 font-bold">Ngày thực hiện</th>
                    <th scope="col" class="px-6 py-4 font-bold">Kỹ thuật viên</th>
                    <th scope="col" class="px-6 py-4 font-bold text-center">Trạng thái</th>
                    <th scope="col" class="px-6 py-4 font-bold text-right">Điều phối</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-ui-border">
                <?php $__empty_1 = true; $__currentLoopData = $baotri; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr class="group transition-colors hover:bg-ui-bg/50">
                            <td class="px-6 py-5">
                                <div class="flex items-center gap-2 font-bold text-ink-primary">
                                    <div class="h-8 w-8 flex items-center justify-center rounded-lg bg-ui-bg text-ink-secondary/60 ring-1 ring-ui-border">
                                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                                    </div>
                                    <?php echo e($item->phong->tenphong ?? 'Tất cả'); ?>

                                </div>
                            </td>
                            <td class="px-6 py-5 max-w-xs">
                                <div class="text-sm font-medium leading-relaxed text-ink-secondary line-clamp-2 italic">"<?php echo e($item->noidung); ?>"</div>
                            </td>
                            <td class="px-6 py-5">
                                <div class="text-sm font-bold text-ink-primary tabular-nums"><?php echo e(date('d/m/Y', strtotime($item->ngaybaotri))); ?></div>
                            </td>
                            <td class="px-6 py-5">
                                <div class="flex items-center gap-2">
                                    <div class="h-6 w-6 rounded-full bg-ui-bg border border-ui-border flex items-center justify-center text-[10px]">🛠️</div>
                                    <span class="text-sm font-bold text-ink-primary"><?php echo e($item->nguoithuchien); ?></span>
                                </div>
                            </td>
                            <td class="px-6 py-5 text-center">
                                <?php
                                    $badgeClass = $item->trangthai === 'Đã hoàn thành' 
                                        ? 'bg-emerald-50 text-emerald-700 ring-1 ring-inset ring-emerald-600/20' 
                                        : 'bg-amber-50 text-amber-700 ring-1 ring-inset ring-amber-600/20';
                                ?>
                                <span class="inline-flex items-center rounded-md px-2.5 py-1 text-[10px] font-bold uppercase tracking-wider <?php echo e($badgeClass); ?>">
                                    <?php echo e($item->trangthai); ?>

                                </span>
                            </td>
                            <td class="px-6 py-5 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <button type="button" data-modal-target="modal-suabaotri-<?php echo e($item->id); ?>" data-modal-toggle="modal-suabaotri-<?php echo e($item->id); ?>" class="flex h-8 w-8 items-center justify-center rounded-lg border border-ui-border bg-white text-ink-secondary shadow-sm transition-colors hover:bg-ui-bg hover:text-ink-primary" aria-label="Chỉnh sửa lịch">
                                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                                    </button>

                                    <?php if($item->trangthai !== 'Đã hoàn thành'): ?>
                                        <form method="POST" action="<?php echo e(route('admin.hoanthanhbaotri', $item->id)); ?>" x-data="{ showConfirm: false }" x-on:confirmed="$el.requestSubmit()">
                                            <?php echo csrf_field(); ?>
                                            <button type="button" @click="showConfirm = true" class="flex h-8 items-center justify-center rounded-lg border border-brand-emerald/20 bg-emerald-50 px-3 text-[10px] font-bold uppercase tracking-widest text-emerald-600 shadow-sm transition-colors hover:bg-emerald-600 hover:text-white">Hoàn tất</button>
                                            <?php if (isset($component)) { $__componentOriginal5b8b2d0f151a30be878e1a760ec3900c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5b8b2d0f151a30be878e1a760ec3900c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.confirmation-modal','data' => ['message' => 'Xác nhận công tác bảo trì này đã hoàn tất?']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('confirmation-modal'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['message' => 'Xác nhận công tác bảo trì này đã hoàn tất?']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal5b8b2d0f151a30be878e1a760ec3900c)): ?>
<?php $attributes = $__attributesOriginal5b8b2d0f151a30be878e1a760ec3900c; ?>
<?php unset($__attributesOriginal5b8b2d0f151a30be878e1a760ec3900c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal5b8b2d0f151a30be878e1a760ec3900c)): ?>
<?php $component = $__componentOriginal5b8b2d0f151a30be878e1a760ec3900c; ?>
<?php unset($__componentOriginal5b8b2d0f151a30be878e1a760ec3900c); ?>
<?php endif; ?>
                                        </form>
                                    <?php endif; ?>

                                    <form method="POST" action="<?php echo e(route('admin.xoabaotri', $item->id)); ?>" x-data="{ showConfirm: false }" x-on:confirmed="$el.requestSubmit()">
                                        <?php echo csrf_field(); ?>
                                        <button type="button" @click="showConfirm = true" class="flex h-8 w-8 items-center justify-center rounded-lg border border-rose-100 bg-rose-50 text-rose-600 shadow-sm transition-colors hover:bg-rose-600 hover:text-white" aria-label="Hủy lịch">
                                            <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-4v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                        </button>
                                        <?php if (isset($component)) { $__componentOriginal5b8b2d0f151a30be878e1a760ec3900c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5b8b2d0f151a30be878e1a760ec3900c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.confirmation-modal','data' => ['type' => 'danger','message' => 'Bạn có chắc chắn muốn hủy lịch bảo trì này?']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('confirmation-modal'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'danger','message' => 'Bạn có chắc chắn muốn hủy lịch bảo trì này?']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal5b8b2d0f151a30be878e1a760ec3900c)): ?>
<?php $attributes = $__attributesOriginal5b8b2d0f151a30be878e1a760ec3900c; ?>
<?php unset($__attributesOriginal5b8b2d0f151a30be878e1a760ec3900c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal5b8b2d0f151a30be878e1a760ec3900c)): ?>
<?php $component = $__componentOriginal5b8b2d0f151a30be878e1a760ec3900c; ?>
<?php unset($__componentOriginal5b8b2d0f151a30be878e1a760ec3900c); ?>
<?php endif; ?>
                                    </form>
                                </div>
                            </td>
                        </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="6" class="adm-empty">
                            <?php if (isset($component)) { $__componentOriginal074a021b9d42f490272b5eefda63257c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal074a021b9d42f490272b5eefda63257c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.empty-state','data' => ['title' => 'Trống lịch trình bảo trì','description' => 'Chưa có kế hoạch bảo trì nào được thiết lập trong thời gian tới.']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('empty-state'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Trống lịch trình bảo trì','description' => 'Chưa có kế hoạch bảo trì nào được thiết lập trong thời gian tới.']); ?>
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

        <?php if(method_exists($baotri, 'links')): ?>
            <div class="border-t border-ui-border px-6 py-4 bg-ui-bg/30 rounded-2xl">
                <?php echo e($baotri->appends(request()->query())->links()); ?>

            </div>
        <?php endif; ?>
    </div>

    <?php $__env->startPush('modals'); ?>
        <?php if (isset($component)) { $__componentOriginal9f64f32e90b9102968f2bc548315018c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9f64f32e90b9102968f2bc548315018c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.modal','data' => ['id' => 'modal-thembaotri','title' => 'Thiết lập lịch trình','subtitle' => 'Lên kế hoạch bảo trì mới cho hạ tầng hoặc thiết bị.']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('modal'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['id' => 'modal-thembaotri','title' => 'Thiết lập lịch trình','subtitle' => 'Lên kế hoạch bảo trì mới cho hạ tầng hoặc thiết bị.']); ?>
            <form method="POST" action="<?php echo e(route('admin.thembaotri')); ?>" class="space-y-6">
                <?php echo csrf_field(); ?>
                <div>
                    <label class="text-[10px] font-bold uppercase tracking-widest text-ink-secondary/50">Phòng chỉ định (Tùy chọn)</label>
                    <select name="phong_id" class="linear-select mt-1.5 font-bold">
                        <option value="">-- Tất cả các phòng --</option>
                        <?php $__currentLoopData = $phongs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $phong): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($phong->id); ?>"><?php echo e($phong->tenphong); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>

                <div>
                    <label class="text-[10px] font-bold uppercase tracking-widest text-ink-secondary/50">Nội dung bảo trì</label>
                    <textarea name="noidung" required rows="3" class="linear-textarea mt-1.5" placeholder="Mô tả công việc cần thực hiện..."></textarea>
                </div>

                <div class="grid grid-cols-2 gap-5">
                    <div>
                        <label class="text-[10px] font-bold uppercase tracking-widest text-ink-secondary/50">Ngày thực hiện</label>
                        <input name="ngaybaotri" required type="date" value="<?php echo e(date('Y-m-d')); ?>" class="linear-input mt-1.5 font-bold tabular-nums" />
                    </div>
                    <div>
                        <label class="text-[10px] font-bold uppercase tracking-widest text-ink-secondary/50">Kỹ thuật viên phụ trách</label>
                        <input name="nguoithuchien" required type="text" class="linear-input mt-1.5 font-bold" placeholder="Tên nhân viên..." />
                    </div>
                </div>

                <div class="flex gap-3 pt-4">
                    <button type="button" data-modal-hide="modal-thembaotri" class="flex-1 rounded-xl bg-ui-bg py-3 text-sm font-bold text-ink-primary ring-1 ring-ui-border transition-colors hover:bg-white">Hủy bỏ</button>
                    <button type="submit" class="flex-[2] rounded-xl bg-ink-primary py-3 text-sm font-bold text-white shadow-lg shadow-ink-primary/20 transition-all hover:bg-brand-emerald">Xác nhận lịch trình</button>
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

        <?php $__currentLoopData = $baotri; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php if (isset($component)) { $__componentOriginal9f64f32e90b9102968f2bc548315018c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9f64f32e90b9102968f2bc548315018c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.modal','data' => ['id' => 'modal-suabaotri-'.e($item->id).'','title' => 'Hiệu chỉnh lịch trình','subtitle' => 'Cập nhật thông tin kế hoạch bảo trì #'.e($item->id).'.']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('modal'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['id' => 'modal-suabaotri-'.e($item->id).'','title' => 'Hiệu chỉnh lịch trình','subtitle' => 'Cập nhật thông tin kế hoạch bảo trì #'.e($item->id).'.']); ?>
                <form method="POST" action="<?php echo e(route('admin.suabaotri', $item->id)); ?>" class="space-y-6">
                    <?php echo csrf_field(); ?>
                    <div>
                        <label class="text-[10px] font-bold uppercase tracking-widest text-ink-secondary/50">Vị trí thực hiện</label>
                        <select name="phong_id" class="linear-select mt-1.5 font-bold">
                            <option value="">-- Tất cả các phòng --</option>
                            <?php $__currentLoopData = $phongs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $phong): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($phong->id); ?>" <?php echo e($item->phong_id == $phong->id ? 'selected' : ''); ?>><?php echo e($phong->tenphong); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>

                    <div>
                        <label class="text-[10px] font-bold uppercase tracking-widest text-ink-secondary/50">Nội dung công việc</label>
                        <textarea name="noidung" required rows="3" class="linear-textarea mt-1.5"><?php echo e($item->noidung); ?></textarea>
                    </div>

                    <div class="grid grid-cols-2 gap-5">
                        <div>
                            <label class="text-[10px] font-bold uppercase tracking-widest text-ink-secondary/50">Ngày bảo trì</label>
                            <input name="ngaybaotri" required type="date" value="<?php echo e($item->ngaybaotri); ?>" class="linear-input mt-1.5 font-bold tabular-nums" />
                        </div>
                        <div>
                            <label class="text-[10px] font-bold uppercase tracking-widest text-ink-secondary/50">Người thực hiện</label>
                            <input name="nguoithuchien" required type="text" value="<?php echo e($item->nguoithuchien); ?>" class="linear-input mt-1.5 font-bold" />
                        </div>
                    </div>

                    <div>
                        <label class="text-[10px] font-bold uppercase tracking-widest text-ink-secondary/50">Trạng thái vận hành</label>
                        <select name="trangthai" class="linear-select mt-1.5 font-bold">
                            <option value="Chưa thực hiện" <?php echo e($item->trangthai === 'Chưa thực hiện' ? 'selected' : ''); ?>>Chưa thực hiện</option>
                            <option value="Đã hoàn thành" <?php echo e($item->trangthai === 'Đã hoàn thành' ? 'selected' : ''); ?>>Đã hoàn thành</option>
                        </select>
                    </div>

                    <div class="flex gap-3 pt-4">
                        <button type="button" data-modal-hide="modal-suabaotri-<?php echo e($item->id); ?>" class="flex-1 rounded-xl bg-ui-bg py-3 text-sm font-bold text-ink-primary ring-1 ring-ui-border transition-colors hover:bg-white">Hủy bỏ</button>
                        <button type="submit" class="flex-[2] rounded-xl bg-ink-primary py-3 text-sm font-bold text-white shadow-lg shadow-ink-primary/20 transition-all hover:bg-brand-emerald">Lưu thay đổi</button>
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
<?php /**PATH D:\laragon\www\hethongquanlyktxv1\resources\views/admin/baotri/danhsach.blade.php ENDPATH**/ ?>