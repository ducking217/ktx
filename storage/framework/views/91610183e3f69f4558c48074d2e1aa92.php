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
     <?php $__env->slot('title', null, []); ?> Dormitory Visualizer — PDU KTX <?php $__env->endSlot(); ?>

    <div class="space-y-10">
        
        <div class="grid grid-cols-1 gap-6 sm:grid-cols-4">
            <article class="relative overflow-hidden rounded-2xl border border-ui-border bg-white p-6 shadow-sm transition-all hover:shadow-md">
                <div class="text-[10px] font-bold uppercase tracking-[0.15em] text-ink-secondary/50">Tổng quy mô</div>
                <div class="mt-2 flex items-baseline gap-2">
                    <span class="text-3xl font-bold text-ink-primary font-display tabular-nums">384</span>
                    <span class="text-[10px] font-bold text-ink-secondary/40 uppercase">Giường</span>
                </div>
                <div class="mt-4 flex items-center gap-1.5 text-[9px] font-bold text-ink-secondary/40 uppercase tracking-wider">
                    <svg class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m4 0h1m-4 12h1m4 0h1m-4-4h1m4 0h1m-4-4h1m4 0h1"/></svg>
                    48 Phòng • 2 Tòa • 3 Tầng
                </div>
            </article>

            <article class="relative overflow-hidden rounded-2xl border border-ui-border bg-white p-6 shadow-sm transition-all hover:shadow-md">
                <div class="text-[10px] font-bold uppercase tracking-[0.15em] text-ink-secondary/50 text-emerald-600/70">Sẵn sàng</div>
                <div class="mt-2 flex items-baseline gap-2">
                    <span class="text-3xl font-bold text-emerald-600 font-display tabular-nums"><?php echo e(number_format($campusStats['available'])); ?></span>
                    <span class="text-[10px] font-bold text-emerald-600/40 uppercase italic">Trống</span>
                </div>
                <div class="mt-4 h-1 w-full overflow-hidden rounded-full bg-ui-bg">
                    <div class="h-full bg-emerald-500 shadow-[0_0_8px_rgba(16,185,129,0.3)]" style="<?php echo \Illuminate\Support\Arr::toCssStyles(['width' => ($campusStats['available'] / 384 * 100) . '%']) ?>"></div>
                </div>
            </article>

            <article class="relative overflow-hidden rounded-2xl border border-ui-border bg-white p-6 shadow-sm transition-all hover:shadow-md">
                <div class="text-[10px] font-bold uppercase tracking-[0.15em] text-ink-secondary/50 text-ink-primary">Đã lưu trú</div>
                <div class="mt-2 flex items-baseline gap-2">
                    <span class="text-3xl font-bold text-ink-primary font-display tabular-nums"><?php echo e(number_format($campusStats['occupied'])); ?></span>
                    <span class="text-[10px] font-bold text-ink-primary/40 uppercase italic">Người</span>
                </div>
                <div class="mt-4 h-1 w-full overflow-hidden rounded-full bg-ui-bg">
                    <div class="h-full bg-ink-primary" style="<?php echo \Illuminate\Support\Arr::toCssStyles(['width' => ($campusStats['occupied'] / 384 * 100) . '%']) ?>"></div>
                </div>
            </article>

            <article class="relative overflow-hidden rounded-2xl border border-ui-border bg-white p-6 shadow-sm transition-all hover:shadow-md">
                <div class="text-[10px] font-bold uppercase tracking-[0.15em] text-ink-secondary/50 text-amber-600/70">Đang chờ</div>
                <div class="mt-2 flex items-baseline gap-2">
                    <span class="text-3xl font-bold text-amber-600 font-display tabular-nums"><?php echo e(number_format($campusStats['pending'])); ?></span>
                    <span class="text-[10px] font-bold text-amber-600/40 uppercase italic">Hồ sơ</span>
                </div>
                <div class="mt-4 h-1 w-full overflow-hidden rounded-full bg-ui-bg">
                    <div class="h-full bg-amber-500 shadow-[0_0_8px_rgba(245,158,11,0.3)]" style="<?php echo \Illuminate\Support\Arr::toCssStyles(['width' => ($campusStats['pending'] / 384 * 100) . '%']) ?>"></div>
                </div>
            </article>
        </div>

        
        <header class="flex flex-col gap-6 lg:flex-row lg:items-center lg:justify-between">
            <div>
                <h1 class="text-2xl font-bold text-ink-primary font-display tracking-tight uppercase">Sơ đồ thực địa</h1>
                <p class="text-xs font-medium text-ink-secondary/60">Giám sát vị trí Tòa <?php echo e($toa); ?> — Tầng <?php echo e($tang); ?></p>
            </div>

            <div class="flex items-center gap-4">
                <div class="flex items-center gap-1 rounded-xl bg-ui-bg p-1 ring-1 ring-ui-border shadow-sm">
                    <?php $__currentLoopData = $allToa; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $t): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <a href="<?php echo e(request()->fullUrlWithQuery(['toa_nha_id' => $t->id, 'tang' => request('tang')])); ?>" 
                           class="rounded-lg px-5 py-2 text-[10px] font-bold uppercase tracking-widest transition-all <?php echo e($toaNhaId == $t->id ? 'bg-white text-ink-primary shadow-sm ring-1 ring-ui-border' : 'text-ink-secondary hover:text-ink-primary'); ?>">
                            Tòa <?php echo e($t->ten_toa_nha); ?>

                        </a>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>

                <div class="flex items-center gap-1 rounded-xl bg-ui-bg p-1 ring-1 ring-ui-border shadow-sm">
                    <?php $__currentLoopData = $allTang; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tg): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <a href="<?php echo e(request()->fullUrlWithQuery(['tang' => $tg])); ?>" 
                           class="rounded-lg px-5 py-2 text-[10px] font-bold uppercase tracking-widest transition-all <?php echo e($tang === $tg ? 'bg-white text-ink-primary shadow-sm ring-1 ring-ui-border' : 'text-ink-secondary hover:text-ink-primary'); ?>">
                            Tầng <?php echo e($tg); ?>

                        </a>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
        </header>

        
        <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
            <?php $__empty_1 = true; $__currentLoopData = $mapData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <?php 
                    $phong = $data['phong']; 
                    $soluongdango = $phong->so_nguoi_dang_o ?? 0;
                    $succhuamax = $phong->loaiphong->suc_chua ?? 0;
                ?>
                <article class="group relative rounded-2xl border border-ui-border bg-white p-5 shadow-sm transition-all hover:border-ink-primary/20 hover:shadow-md">
                    
                    <div class="absolute right-4 top-4">
                        <span class="inline-flex items-center rounded-full px-2 py-0.5 text-[8px] font-bold uppercase tracking-widest ring-1 ring-inset <?php echo e($phong->gioi_tinh_han_che->value === 'female' ? 'bg-rose-50 text-rose-600 ring-rose-500/20' : ($phong->gioi_tinh_han_che->value === 'male' ? 'bg-blue-50 text-blue-600 ring-blue-500/20' : 'bg-gray-50 text-gray-600 ring-gray-500/20')); ?>">
                            <?php echo e($phong->gioi_tinh_han_che->label()); ?>

                        </span>
                    </div>

                    <header class="mb-5">
                        <a href="<?php echo e(route('admin.phong.chitiet', $phong->id)); ?>" class="group/title block">
                            <h3 class="text-lg font-bold text-ink-primary font-display uppercase tracking-tight group-hover/title:text-ink-primary/70 transition-colors"><?php echo e($phong->ten_phong); ?></h3>
                        </a>
                        <div class="mt-1 flex items-center gap-2">
                            <span class="text-[9px] font-bold uppercase tracking-widest text-ink-secondary/40"><span class="tabular-nums"><?php echo e($soluongdango); ?>/<?php echo e($succhuamax); ?></span> Đang ở</span>
                        </div>
                    </header>

                    <?php
                        $bedList = collect($data['beds'] ?? []);
                        $availableCount = $bedList->where('status', 'AVAILABLE')->count();
                        $pendingCount = $bedList->where('status', 'PENDING')->count();
                        $occupiedCount = $bedList->where('status', 'OCCUPIED')->count();
                        $totalCount = max(1, $availableCount + $pendingCount + $occupiedCount);
                    ?>

                    <div class="space-y-3">
                        <div class="flex items-center gap-2">
                            <span class="inline-flex items-center rounded-full bg-emerald-50 px-2 py-1 text-[9px] font-bold uppercase tracking-widest text-emerald-700 ring-1 ring-inset ring-emerald-600/10">
                                Trống <?php echo e($availableCount); ?>

                            </span>
                            <span class="inline-flex items-center rounded-full bg-amber-50 px-2 py-1 text-[9px] font-bold uppercase tracking-widest text-amber-700 ring-1 ring-inset ring-amber-600/10">
                                Chờ <?php echo e($pendingCount); ?>

                            </span>
                            <span class="inline-flex items-center rounded-full bg-ui-bg px-2 py-1 text-[9px] font-bold uppercase tracking-widest text-ink-primary/70 ring-1 ring-inset ring-ui-border">
                                Đã ở <?php echo e($occupiedCount); ?>

                            </span>
                        </div>
                        <div class="h-2 w-full overflow-hidden rounded-full bg-ui-bg ring-1 ring-ui-border">
                            <div class="flex h-full w-full">
                                <div class="h-full bg-emerald-500/70" style="<?php echo \Illuminate\Support\Arr::toCssStyles(['width' => (($availableCount / $totalCount) * 100) . '%']) ?>"></div>
                                <div class="h-full bg-amber-500/70" style="<?php echo \Illuminate\Support\Arr::toCssStyles(['width' => (($pendingCount / $totalCount) * 100) . '%']) ?>"></div>
                                <div class="h-full bg-ink-primary/70" style="<?php echo \Illuminate\Support\Arr::toCssStyles(['width' => (($occupiedCount / $totalCount) * 100) . '%']) ?>"></div>
                            </div>
                        </div>
                    </div>

                    <footer class="mt-5 border-t border-ui-border pt-4">
                        <a href="<?php echo e(route('admin.phong.chitiet', $phong->id)); ?>" class="flex items-center justify-between text-[10px] font-bold uppercase tracking-widest text-ink-secondary/60 transition-colors hover:text-ink-primary">
                            Hồ sơ vận hành
                            <svg class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                        </a>
                    </footer>
                </article>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <div class="col-span-full py-20 text-center">
                    <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-2xl bg-ui-bg text-ink-secondary/20">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m4 0h1m-4 12h1m4 0h1"/></svg>
                    </div>
                    <p class="mt-4 text-[10px] font-bold uppercase tracking-widest text-ink-secondary/40">Không tìm thấy dữ liệu phòng</p>
                </div>
            <?php endif; ?>
        </div>

        
        <div class="flex items-center justify-center gap-8 border-t border-ui-border pt-10 text-[9px] font-bold uppercase tracking-[0.2em] text-ink-secondary/40">
            <div class="flex items-center gap-2">
                <span class="h-2 w-2 rounded-full bg-emerald-500 shadow-[0_0_8px_rgba(16,185,129,0.3)]"></span> Trống
            </div>
            <div class="flex items-center gap-2">
                <span class="h-2 w-2 rounded-full bg-amber-500 shadow-[0_0_8px_rgba(245,158,11,0.3)]"></span> Đang chờ
            </div>
            <div class="flex items-center gap-2">
                <span class="h-2 w-2 rounded-full bg-ink-primary shadow-[0_0_8px_rgba(15,23,42,0.1)]"></span> Đã ở
            </div>
        </div>
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
<?php /**PATH D:\laragon\www\hethongquanlyktxv1\resources\views/admin/phong/map.blade.php ENDPATH**/ ?>