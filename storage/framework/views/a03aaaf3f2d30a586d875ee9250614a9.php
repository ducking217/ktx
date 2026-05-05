<?php $__env->startSection('student_page_title', 'Thông báo hệ thống'); ?>

<?php $__env->startSection('noidung'); ?>
    <div class="space-y-8">
        <?php if (isset($component)) { $__componentOriginalcb19cb35a534439097b02b8af91726ee = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalcb19cb35a534439097b02b8af91726ee = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.page-header','data' => ['title' => 'Thông báo hệ thống','subtitle' => 'Cập nhật các tin tức và thông báo mới nhất từ Ban quản lý KTX.']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('admin.page-header'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Thông báo hệ thống','subtitle' => 'Cập nhật các tin tức và thông báo mới nhất từ Ban quản lý KTX.']); ?>
            <div class="flex items-center gap-1.5 bg-slate-100 p-1 rounded-xl border border-slate-200">
                <a href="<?php echo e(route('student.thongbao')); ?>" 
                   class="px-4 py-2 text-[10px] font-bold uppercase tracking-widest transition-all rounded-lg <?php echo e($loai === 'tatca' ? 'bg-white text-slate-900 shadow-sm' : 'text-slate-500 hover:text-slate-900'); ?>">
                    Tất cả
                </a>
                <a href="<?php echo e(route('student.thongbao', ['loai' => 'moi_nhat'])); ?>" 
                   class="px-4 py-2 text-[10px] font-bold uppercase tracking-widest transition-all rounded-lg <?php echo e($loai === 'moi_nhat' ? 'bg-white text-slate-900 shadow-sm' : 'text-slate-500 hover:text-slate-900'); ?>">
                    Mới nhất
                </a>
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

        
        <div class="grid gap-6 sm:grid-cols-3">
            <article class="saas-card p-6 relative overflow-hidden group">
                <div class="relative flex items-center gap-4">
                    <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-blue-50 text-blue-600 ring-1 ring-blue-500/10">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" /></svg>
                    </div>
                    <div>
                        <div class="text-[10px] font-bold uppercase tracking-widest text-slate-400 mb-0.5">Tổng số thông báo</div>
                        <div class="text-2xl font-bold text-slate-900 tabular-nums"><?php echo e($thongKe['tong_so']); ?></div>
                    </div>
                </div>
            </article>
            <article class="saas-card p-6 relative overflow-hidden group">
                <div class="relative flex items-center gap-4">
                    <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-slate-50 text-slate-600 ring-1 ring-slate-500/10">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                    </div>
                    <div>
                        <div class="text-[10px] font-bold uppercase tracking-widest text-slate-400 mb-0.5">Trong tháng này</div>
                        <div class="text-2xl font-bold text-slate-900 tabular-nums"><?php echo e($thongKe['trong_thang']); ?></div>
                    </div>
                </div>
            </article>
            <article class="saas-card p-6 relative overflow-hidden group">
                <div class="relative flex items-center gap-4">
                    <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-emerald-50 text-emerald-600 ring-1 ring-emerald-500/10">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-7.714 2.143L11 21l-2.286-6.857L1 12l7.714-2.143L11 3z" /></svg>
                    </div>
                    <div>
                        <div class="text-[10px] font-bold uppercase tracking-widest text-slate-400 mb-0.5">Tin mới tuần này</div>
                        <div class="text-2xl font-bold text-slate-900 tabular-nums"><?php echo e($thongKe['tuan_nay']); ?></div>
                    </div>
                </div>
            </article>
        </div>

        
        <div class="space-y-4">
            <?php $__empty_1 = true; $__currentLoopData = $thongbao; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tb): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <a href="<?php echo e(route('student.chitietthongbao', $tb->id)); ?>" class="saas-card p-6 flex items-start gap-6 group hover:border-blue-200 transition-all hover:shadow-xl hover:shadow-blue-500/5">
                    <div class="hidden sm:flex h-14 w-14 shrink-0 items-center justify-center rounded-xl bg-slate-50 border border-slate-100 group-hover:bg-blue-50 group-hover:border-blue-100 transition-colors">
                        <svg class="h-6 w-6 text-slate-400 group-hover:text-blue-500 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.114 5.636a9 9 0 010 12.728M16.463 8.288a5.25 5.25 0 010 7.424M6.75 8.25l4.72-4.72a.75.75 0 011.28.53v15.88a.75.75 0 01-1.28.53l-4.72-4.72H4.51c-.88 0-1.704-.507-1.938-1.354A9.01 9.01 0 012.25 12c0-.83.112-1.633.322-2.396C2.806 8.756 3.63 8.25 4.51 8.25H6.75z" />
                        </svg>
                    </div>
                    <div class="flex-1">
                        <div class="flex items-center gap-3 mb-2">
                            <h3 class="text-base font-bold text-slate-900 group-hover:text-blue-600 transition-colors"><?php echo e($tb->tieu_de); ?></h3>
                            <?php if(now()->diffInDays($tb->created_at) <= 3): ?>
                                <span class="saas-badge saas-badge-success !py-0.5 !px-2 animate-pulse">Mới</span>
                            <?php endif; ?>
                        </div>
                        <p class="text-sm font-medium text-slate-500 leading-relaxed line-clamp-2"><?php echo e(Str::limit(strip_tags($tb->noi_dung), 150)); ?></p>
                        <div class="mt-4 flex items-center gap-4 text-[10px] font-bold uppercase tracking-widest text-slate-400">
                            <span class="flex items-center gap-1.5">
                                <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                <?php echo e($tb->created_at?->format('d/m/Y H:i')); ?>

                            </span>
                            <span class="flex items-center gap-1.5">
                                <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                                Ban Quản Lý KTX
                            </span>
                        </div>
                    </div>
                </a>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <div class="saas-card py-24 text-center border-dashed">
                    <div class="mx-auto mb-5 flex h-16 w-16 items-center justify-center rounded-2xl bg-slate-50 border border-slate-100 text-slate-300">
                        <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0a2 2 0 01-2 2H6a2 2 0 01-2-2m16 0l-8 4-8-4m8 4v10" /></svg>
                    </div>
                    <h3 class="text-base font-bold text-slate-900 uppercase tracking-tight">Hộp thư trống</h3>
                    <p class="mt-2 text-xs font-medium text-slate-500 max-w-sm mx-auto">Hiện tại không có thông báo nào mới dành cho bạn.</p>
                </div>
            <?php endif; ?>
        </div>

        
        <?php if(method_exists($thongbao, 'links')): ?>
            <div class="mt-8">
                <?php echo e($thongbao->links()); ?>

            </div>
        <?php endif; ?>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('student.layouts.chinh', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\laragon\www\hethongquanlyktxv1\resources\views/student/thongbao/danhsach.blade.php ENDPATH**/ ?>