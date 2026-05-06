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
     <?php $__env->slot('title', null, []); ?> Quản lý Hồ sơ Sinh viên Nội trú <?php $__env->endSlot(); ?>

    <div class="space-y-8">
        <?php if (isset($component)) { $__componentOriginalcb19cb35a534439097b02b8af91726ee = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalcb19cb35a534439097b02b8af91726ee = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.page-header','data' => ['title' => 'Cơ sở dữ liệu cư dân','subtitle' => 'Quản lý định danh, hồ sơ nhân khẩu và lịch sử cư trú sinh viên.']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('admin.page-header'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Cơ sở dữ liệu cư dân','subtitle' => 'Quản lý định danh, hồ sơ nhân khẩu và lịch sử cư trú sinh viên.']); ?>
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

        
        <div class="saas-card p-6 bg-slate-50/50 border-dashed">
            <form action="<?php echo e(route('admin.quanlysinhvien')); ?>" method="GET" class="flex flex-wrap items-end gap-6">
                <div class="flex-1 min-w-[300px]">
                    <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-2 ml-1">Tìm kiếm sinh viên</label>
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-4 flex items-center text-slate-400 group-focus-within:text-blue-500 transition-colors pointer-events-none">
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="m21 21-4.35-4.35M10.5 18a7.5 7.5 0 1 1 0-15 7.5 7.5 0 0 1 0 15z" /></svg>
                        </div>
                        <input type="text" name="q" value="<?php echo e(request('q')); ?>" placeholder="Mã sinh viên hoặc họ tên..." class="saas-input pl-12 h-11">
                    </div>
                </div>
                <div class="flex items-end gap-3">
                    <button type="submit" class="saas-btn-primary h-11 px-6">Tìm kiếm</button>
                    <?php if(request('q')): ?>
                        <a href="<?php echo e(route('admin.quanlysinhvien')); ?>" class="saas-btn-secondary h-11 px-5">Xóa lọc</a>
                    <?php endif; ?>
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
                    <th>Sinh viên</th>
                    <th>Lớp học</th>
                    <th>Phòng hiện tại</th>
                    <th>Liên hệ</th>
                    <th>Ngày tạo hồ sơ</th>
                    <th class="text-right">Hành động</th>
                </tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $danhsachsinhvien; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sinhvien): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr class="hover:bg-slate-50/50 transition-colors group">
                        <td class="py-5">
                            <div class="flex items-center gap-4">
                                <div class="h-10 w-10 rounded-xl bg-slate-100 border border-slate-200 flex items-center justify-center flex-shrink-0">
                                    <span class="text-xs font-bold text-slate-500 uppercase tabular-nums"><?php echo e(mb_substr($sinhvien->taikhoan?->name ?? 'N', 0, 2)); ?></span>
                                </div>
                                <div>
                                    <div class="text-sm font-bold text-slate-900 leading-tight group-hover:text-blue-600 transition-colors"><?php echo e($sinhvien->taikhoan?->name ?? 'Chưa có'); ?></div>
                                    <div class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-1.5 tabular-nums">
                                        MSSV: <?php echo e($sinhvien->ma_sinh_vien); ?>

                                    </div>
                                </div>
                            </div>
                        </td>
                        <td class="py-5">
                            <div class="text-xs font-bold text-slate-700 tracking-tight uppercase"><?php echo e($sinhvien->lop); ?></div>
                        </td>
                        <td class="py-5">
                            <?php if($sinhvien->phong_hien_tai()): ?>
                                <div class="inline-flex items-center gap-2 font-bold text-slate-900 text-sm">
                                    <div class="h-7 w-7 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center border border-blue-100 shadow-sm flex-shrink-0">
                                        <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1-1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                                    </div>
                                    <?php echo e($sinhvien->phong_hien_tai()->ten_phong); ?>

                                </div>
                            <?php else: ?>
                                <span class="inline-flex items-center gap-1.5 text-[10px] font-bold text-slate-400 uppercase tracking-wider">
                                    <span class="h-1.5 w-1.5 rounded-full bg-slate-300"></span>
                                    Chưa xếp phòng
                                </span>
                            <?php endif; ?>
                        </td>
                        <td class="py-5">
                            <div class="text-xs font-bold text-slate-900 tabular-nums"><?php echo e($sinhvien->user?->phone ?? 'Chưa có'); ?></div>
                            <div class="text-[10px] text-slate-400 font-medium mt-1 lowercase"><?php echo e($sinhvien->user?->email ?? 'Chưa có'); ?></div>
                        </td>
                        <td class="py-5">
                            <div class="text-xs font-bold text-slate-900 tabular-nums"><?php echo e($sinhvien->created_at->format('d/m/Y')); ?></div>
                        </td>
                        <td class="py-5 text-right">
                            <div class="flex items-center justify-end gap-1">
                                <a href="<?php echo e(route('admin.sinhvien.chitiet', $sinhvien->id)); ?>" class="h-9 w-9 inline-flex items-center justify-center text-slate-400 hover:text-blue-600 hover:bg-blue-50 border border-transparent hover:border-blue-100 rounded-xl transition-all shadow-sm hover:shadow-md" title="Xem hồ sơ">
                                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                </a>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="6" class="py-24 text-center">
                            <div class="flex flex-col items-center gap-4 text-slate-200">
                                <svg class="h-14 w-14" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                                <p class="text-sm font-bold text-slate-400 uppercase tracking-widest">Không có dữ liệu sinh viên phù hợp</p>
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

        <?php if(method_exists($danhsachsinhvien, 'links')): ?>
            <div class="mt-8">
                <?php echo e($danhsachsinhvien->withQueryString()->links()); ?>

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
<?php /**PATH D:\laragon\www\hethongquanlyktxv1\resources\views/admin/sinhvien/danhsach.blade.php ENDPATH**/ ?>