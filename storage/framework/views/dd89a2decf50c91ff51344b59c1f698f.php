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
     <?php $__env->slot('title', null, []); ?> Điều phối Báo hỏng & Bảo trì <?php $__env->endSlot(); ?>

    <div class="space-y-8 pb-20">
        <?php
            $filters = [
                '' => 'Tất cả báo cáo',
                \App\Enums\BaohongStatus::Pending->value => \App\Enums\BaohongStatus::Pending->label(),
                \App\Enums\BaohongStatus::Processing->value => \App\Enums\BaohongStatus::Processing->label(),
                \App\Enums\BaohongStatus::Done->value => \App\Enums\BaohongStatus::Done->label(),
                \App\Enums\BaohongStatus::Rejected->value => \App\Enums\BaohongStatus::Rejected->label(),
            ];
        ?>

        <?php if (isset($component)) { $__componentOriginalcb19cb35a534439097b02b8af91726ee = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalcb19cb35a534439097b02b8af91726ee = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.page-header','data' => ['title' => 'Hệ thống báo hỏng','subtitle' => 'Giám sát luồng thông tin sự cố, điều phối nhân lực và kiểm soát chất lượng bảo trì hạ tầng.']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('admin.page-header'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Hệ thống báo hỏng','subtitle' => 'Giám sát luồng thông tin sự cố, điều phối nhân lực và kiểm soát chất lượng bảo trì hạ tầng.']); ?>
            <?php if (isset($component)) { $__componentOriginalca9a59ffed06600c602f2637b0b34f87 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalca9a59ffed06600c602f2637b0b34f87 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.status-tabs','data' => ['items' => $filters,'active' => $status ?? '','route' => 'admin.baohong.index','param' => 'status','defaultValue' => '']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('admin.status-tabs'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['items' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($filters),'active' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($status ?? ''),'route' => 'admin.baohong.index','param' => 'status','defaultValue' => '']); ?>
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
                    <th>Sinh viên báo cáo</th>
                    <th>Vị trí sự cố</th>
                    <th>Nội dung mô tả</th>
                    <th>Hình ảnh</th>
                    <th class="text-center">Trạng thái</th>
                    <th class="text-right">Xử lý</th>
                </tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $danhsachbaohong; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $baohong): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr class="hover:bg-slate-50/50 transition-colors group">
                        <td class="py-5">
                            <div class="text-sm font-bold text-slate-900 leading-tight group-hover:text-brand-emerald transition-colors"><?php echo e($baohong->sinhvien?->user?->name ?? 'Chưa có'); ?></div>
                            <div class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-1.5 tabular-nums">MSSV: <?php echo e($baohong->sinhvien?->ma_sinh_vien ?? 'Chưa có'); ?></div>
                        </td>
                        <td class="py-5">
                            <div class="inline-flex items-center gap-2 text-sm font-bold text-slate-900">
                                <span class="h-1.5 w-1.5 rounded-full bg-brand-emerald flex-shrink-0"></span>
                                <?php echo e($baohong->phong?->ten_phong ?? 'Chưa xác định'); ?>

                            </div>
                        </td>
                        <td class="py-5 max-w-sm">
                            <div class="rounded-xl bg-slate-50 px-4 py-3 text-xs font-medium leading-relaxed text-slate-600 line-clamp-3 ring-1 ring-inset ring-slate-200/60">
                                <?php echo e($baohong->mo_ta); ?>

                            </div>
                        </td>
                        <td class="py-5">
                            <?php if($baohong->hinh_anh_path): ?>
                                <a href="<?php echo e(asset($baohong->hinh_anh_path)); ?>" target="_blank" rel="noopener" class="h-9 px-3 inline-flex items-center gap-2 text-[10px] font-bold uppercase tracking-widest text-slate-500 bg-slate-50 border border-slate-200/60 rounded-xl hover:bg-slate-900 hover:text-white hover:border-slate-900 transition-all shadow-sm" title="Xem hình ảnh">
                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                    Xem ảnh
                                </a>
                            <?php else: ?>
                                <span class="text-[10px] font-bold text-slate-300 uppercase tracking-widest">Không có ảnh</span>
                            <?php endif; ?>
                        </td>
                        <td class="py-5 text-center">
                            <?php
                                $status = $baohong->trang_thai;
                                $statusClass = match ($status) {
                                    \App\Enums\BaohongStatus::Done => 'saas-badge-success',
                                    \App\Enums\BaohongStatus::Pending => 'saas-badge-warning',
                                    \App\Enums\BaohongStatus::Processing => 'saas-badge-info',
                                    \App\Enums\BaohongStatus::Rejected => 'saas-badge-error',
                                    default => 'saas-badge-info',
                                };
                            ?>
                            <span class="saas-badge <?php echo e($statusClass); ?>">
                                <?php echo e($status?->label() ?? 'Không xác định'); ?>

                            </span>
                        </td>
                        <td class="py-5 text-right">
                            <form method="POST" action="<?php echo e(route('admin.baohong.capnhat', ['id' => $baohong->id])); ?>" class="inline-flex items-center gap-2 p-1.5 rounded-xl bg-white border border-slate-200 shadow-sm transition-all">
                                <?php echo csrf_field(); ?>
                                <select name="trang_thai" class="bg-transparent border-none text-[10px] font-bold uppercase tracking-wider text-slate-700 focus:ring-0 cursor-pointer min-w-[100px] py-1">
                                    <?php $__currentLoopData = \App\Enums\BaohongStatus::cases(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ms): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($ms->value); ?>" <?php echo e($baohong->trang_thai === $ms ? 'selected' : ''); ?>><?php echo e($ms->label()); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                                <button type="submit" class="h-9 w-9 flex items-center justify-center text-slate-400 hover:text-brand-emerald hover:bg-brand-emerald/10 border border-transparent hover:border-brand-emerald/20 rounded-xl transition-all shadow-sm hover:shadow-md" title="Lưu trạng thái">
                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                                </button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="6" class="py-24 text-center">
                            <div class="flex flex-col items-center gap-4 text-slate-200">
                                <svg class="h-14 w-14" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                <p class="text-sm font-bold text-slate-400 uppercase tracking-widest">Không có báo cáo sự cố nào</p>
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

        <?php if(method_exists($danhsachbaohong, 'links')): ?>
            <div class="mt-8">
                <?php echo e($danhsachbaohong->appends(request()->query())->links()); ?>

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
<?php /**PATH D:\laragon\www\hethongquanlyktxv1\resources\views/admin/baohong/danhsach.blade.php ENDPATH**/ ?>