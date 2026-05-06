<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

    <title><?php echo e($title ?? config('app.name', 'PDU Portal')); ?></title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Geist+Sans:wght@100..900&family=Quicksand:wght@400..700&display=swap" rel="stylesheet">

    <style>
        h1, h2, h3, .font-display { font-family: 'Quicksand', sans-serif !important; }
        body { font-family: 'Geist Sans', sans-serif; }
    </style>

    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
</head>
<body class="saas-layout text-ink-primary">
<?php
    $hoadonCanXuLy = isset($hoadonchuathanhtoan) && method_exists($hoadonchuathanhtoan, 'count') ? $hoadonchuathanhtoan->count() : 0;
    $hotroCanXuLy = $hoadonCanXuLy > 0 ? 1 : 0;
    $tenSinhVien = auth()->user()->name ?? 'Sinh viên';
    $vaitro = auth()->user()->vaitro;
    $isAlumni = $vaitro === 'cuu_sinhvien';
    $mssv = isset($sinhvien) && !empty($sinhvien?->mssv) ? $sinhvien->mssv : ('SV' . str_pad((string) (auth()->id() ?? 0), 6, '0', STR_PAD_LEFT));
?>

<!-- Sidebar -->
<aside class="fixed inset-y-0 left-0 z-40 hidden w-64 flex-col border-r border-brand-emerald/15 bg-brand-emerald/5 lg:flex backdrop-blur-xl">
    <!-- Brand Logo -->
    <div class="flex h-16 shrink-0 items-center px-6">
        <div class="flex items-center gap-3">
            <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-slate-900 text-white shadow-sm">
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m4 0h1m-4 12h1m4 0h1m-4-4h1m4 0h1m-4-4h1m4 0h1m-4-4h1m4 0h1m-4-4h1m4 0h1"/></svg>
            </div>
            <div class="font-display text-lg font-bold tracking-tight text-slate-900">PDU Portal</div>
        </div>
    </div>

    <!-- Navigation -->
    <nav class="flex-1 overflow-y-auto px-4 py-4 custom-scrollbar">
        <!-- Profile Card inside Sidebar -->
        <div class="mb-6 rounded-xl border border-slate-200/60 bg-white p-3 shadow-sm">
            <div class="flex items-center gap-3">
                <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-slate-100 font-medium text-slate-600">
                    <?php echo e(strtoupper(substr($tenSinhVien, 0, 1))); ?>

                </div>
                <div class="min-w-0 flex-1">
                    <div class="truncate text-sm font-semibold text-slate-900"><?php echo e($tenSinhVien); ?></div>
                    <div class="flex items-center gap-1.5 text-xs text-slate-500">
                        <span class="<?php echo \Illuminate\Support\Arr::toCssClasses([
                            'h-1.5 w-1.5 rounded-full',
                            'bg-slate-300' => $isAlumni,
                            'bg-emerald-500' => !$isAlumni,
                        ]); ?>"></span>
                        <span class="truncate"><?php echo e($mssv); ?></span>
                    </div>
                </div>
            </div>
        </div>

        <div class="mb-2 px-3 text-xs font-semibold uppercase tracking-wider text-slate-400">Hệ thống</div>
        <div class="space-y-1">
            <a href="<?php echo e(route('student.trangchu')); ?>" class="saas-sidebar-link <?php echo e(request()->routeIs('student.trangchu') ? 'saas-sidebar-link-active' : ''); ?>">
                <svg class="h-5 w-5 shrink-0 opacity-70" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2z"/></svg>
                <span>Tổng quan</span>
            </a>
            <a href="<?php echo e(route('profile.edit')); ?>" class="saas-sidebar-link <?php echo e(request()->routeIs('profile.edit') ? 'saas-sidebar-link-active' : ''); ?>">
                <svg class="h-5 w-5 shrink-0 opacity-70" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                <span>Hồ sơ cá nhân</span>
            </a>
        </div>

        <div class="mb-2 mt-6 px-3 text-xs font-semibold uppercase tracking-wider text-slate-400">Lưu trú</div>
        <div class="space-y-1">
            <?php if(!$isAlumni): ?>
                <a href="<?php echo e(route('student.phong.index')); ?>" class="saas-sidebar-link <?php echo e(request()->routeIs('student.phong.index') ? 'saas-sidebar-link-active' : ''); ?>">
                    <svg class="h-5 w-5 shrink-0 opacity-70" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    <span>Xem phòng trống</span>
                </a>
            <?php endif; ?>
            <a href="<?php echo e(route('student.hopdong.index')); ?>" class="saas-sidebar-link <?php echo e(request()->routeIs('student.hopdong.index') ? 'saas-sidebar-link-active' : ''); ?>">
                <svg class="h-5 w-5 shrink-0 opacity-70" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                <span><?php echo e($isAlumni ? 'Lịch sử nội trú' : 'Hợp đồng & gia hạn'); ?></span>
            </a>
            <?php if(!$isAlumni): ?>
                <a href="<?php echo e(route('student.phongcuatoi')); ?>" class="saas-sidebar-link <?php echo e(request()->routeIs('student.phongcuatoi*') ? 'saas-sidebar-link-active' : ''); ?>">
                    <svg class="h-5 w-5 shrink-0 opacity-70" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                    <span>Phòng của tôi</span>
                </a>
            <?php endif; ?>
        </div>

        <div class="mb-2 mt-6 px-3 text-xs font-semibold uppercase tracking-wider text-slate-400">Giao dịch</div>
        <div class="space-y-1">
            <a href="<?php echo e(route('student.hoadon.index')); ?>" class="saas-sidebar-link <?php echo e(request()->routeIs('student.hoadon.index', 'student.hoadon.chitiet') ? 'saas-sidebar-link-active' : ''); ?>">
                <div class="flex flex-1 items-center gap-3">
                    <svg class="h-5 w-5 shrink-0 opacity-70" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
                    <span>Hóa đơn</span>
                </div>
                <?php if($hoadonCanXuLy > 0): ?>
                    <span class="inline-flex min-w-[20px] items-center justify-center rounded-full bg-rose-100 px-1.5 py-0.5 text-[10px] font-bold text-rose-700"><?php echo e($hoadonCanXuLy); ?></span>
                <?php endif; ?>
            </a>
        </div>

        <div class="mb-2 mt-6 px-3 text-xs font-semibold uppercase tracking-wider text-slate-400">Tiện ích</div>
        <div class="space-y-1">
            <?php if(!$isAlumni): ?>
                <a href="<?php echo e(route('student.danhsachbaohong')); ?>" class="saas-sidebar-link <?php echo e(request()->routeIs('student.danhsachbaohong') ? 'saas-sidebar-link-active' : ''); ?>">
                    <svg class="h-5 w-5 shrink-0 opacity-70" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 012 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                    <span>Báo hỏng</span>
                </a>
            <?php endif; ?>
            <a href="<?php echo e(route('student.kyluat.index')); ?>" class="saas-sidebar-link <?php echo e(request()->routeIs('student.kyluat.index') ? 'saas-sidebar-link-active' : ''); ?>">
                <svg class="h-5 w-5 shrink-0 opacity-70" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                <span>Kỷ luật</span>
            </a>
            <a href="<?php echo e(route('student.thongbao')); ?>" class="saas-sidebar-link <?php echo e(request()->routeIs('student.thongbao*', 'student.chitietthongbao') ? 'saas-sidebar-link-active' : ''); ?>">
                <svg class="h-5 w-5 shrink-0 opacity-70" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.4-1.4a2 2 0 01-.6-1.4V11a6 6 0 1 0-12 0v3.2a2 2 0 01-.6 1.4L4 17h5m6 0a3 3 0 01-6 0"/></svg>
                <span>Thông báo</span>
            </a>
        </div>
    </nav>
</aside>

<!-- Main Content Area -->
<div class="flex flex-1 flex-col lg:pl-64">
    <!-- Topbar -->
    <header class="sticky top-0 z-30 flex h-16 shrink-0 items-center justify-between border-b border-ui-border bg-ui-card/80 px-6 backdrop-blur-xl transition-all">
        <div class="flex items-center gap-4">
            <h1 class="font-display text-lg font-bold tracking-tight text-slate-900">
                <?php if(isset($title)): ?>
                    <?php echo e($title); ?>

                <?php else: ?>
                    <?php echo $__env->yieldContent('student_page_title', 'Tổng quan'); ?>
                <?php endif; ?>
            </h1>
        </div>

        <div class="flex items-center gap-3">
            <a href="<?php echo e(route('student.thongbao')); ?>" class="saas-btn-ghost rounded-full !p-2 relative text-slate-500 hover:text-slate-900">
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.4-1.4a2 2 0 0 1-.6-1.4V11a6 6 0 1 0-12 0v3.2a2 2 0 0 1-.6 1.4L4 17h5m6 0a3 3 0 0 1-6 0"/></svg>
            </a>
            <form method="POST" action="<?php echo e(route('logout')); ?>">
                <?php echo csrf_field(); ?>
                <button type="submit" class="saas-btn-secondary h-9 px-4 text-xs font-semibold">Đăng xuất</button>
            </form>
        </div>
    </header>

    <!-- Page Content -->
    <main class="flex-1 p-6 pb-32 lg:pb-12">
        <?php if($errors->any()): ?>
            <div class="mb-6 rounded-xl border border-rose-200 bg-rose-50 p-4 text-sm text-rose-600 shadow-sm">
                <div class="mb-2 flex items-center gap-2 font-semibold">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <span>Vui lòng kiểm tra lại thông tin:</span>
                </div>
                <ul class="list-inside list-disc space-y-1 pl-7">
                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $loi): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li><?php echo e($loi); ?></li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            </div>
        <?php endif; ?>

        <div class="animate-in fade-in slide-in-from-bottom-2 duration-500">
            <?php echo $__env->yieldContent('noidung'); ?>
            <?php echo e($slot ?? ''); ?>

        </div>
    </main>
</div>

<?php if (isset($component)) { $__componentOriginal7cfab914afdd05940201ca0b2cbc009b = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal7cfab914afdd05940201ca0b2cbc009b = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.toast','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('toast'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal7cfab914afdd05940201ca0b2cbc009b)): ?>
<?php $attributes = $__attributesOriginal7cfab914afdd05940201ca0b2cbc009b; ?>
<?php unset($__attributesOriginal7cfab914afdd05940201ca0b2cbc009b); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal7cfab914afdd05940201ca0b2cbc009b)): ?>
<?php $component = $__componentOriginal7cfab914afdd05940201ca0b2cbc009b; ?>
<?php unset($__componentOriginal7cfab914afdd05940201ca0b2cbc009b); ?>
<?php endif; ?>
<?php echo $__env->yieldPushContent('modals'); ?>

<!-- Mobile Navigation (Floating Dock) -->
<nav class="fixed bottom-6 left-1/2 z-50 flex w-[calc(100%-3rem)] max-w-sm -translate-x-1/2 items-center justify-around rounded-2xl border border-slate-200/60 bg-white/95 p-2 shadow-xl backdrop-blur-xl lg:hidden">
    <a href="<?php echo e(route('student.trangchu')); ?>" class="flex flex-col items-center gap-1 rounded-xl p-2 transition-colors <?php echo e(request()->routeIs('student.trangchu') ? 'text-slate-900 bg-slate-100' : 'text-slate-500 hover:text-slate-900'); ?>">
        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
        <span class="text-[10px] font-medium">Trang chủ</span>
    </a>
    <a href="<?php echo e(route('student.hoadon.index')); ?>" class="flex flex-col items-center gap-1 rounded-xl p-2 transition-colors relative <?php echo e(request()->routeIs('student.hoadon.index', 'student.hoadon.chitiet') ? 'text-slate-900 bg-slate-100' : 'text-slate-500 hover:text-slate-900'); ?>">
        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        <span class="text-[10px] font-medium">Hóa đơn</span>
        <?php if($hoadonCanXuLy > 0): ?>
            <span class="absolute top-1 right-2 h-2 w-2 rounded-full bg-rose-500"></span>
        <?php endif; ?>
    </a>
    <a href="<?php echo e(route('student.danhsachbaohong')); ?>" class="flex flex-col items-center gap-1 rounded-xl p-2 transition-colors <?php echo e(request()->routeIs('student.danhsachbaohong') ? 'text-slate-900 bg-slate-100' : 'text-slate-500 hover:text-slate-900'); ?>">
        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 012 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
        <span class="text-[10px] font-medium">Báo hỏng</span>
    </a>
    <a href="<?php echo e(route('profile.edit')); ?>" class="flex flex-col items-center gap-1 rounded-xl p-2 transition-colors <?php echo e(request()->routeIs('profile.edit') ? 'text-slate-900 bg-slate-100' : 'text-slate-500 hover:text-slate-900'); ?>">
        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
        <span class="text-[10px] font-medium">Hồ sơ</span>
    </a>
</nav>

</body>
</html>
<?php /**PATH D:\laragon\www\hethongquanlyktxv1\resources\views/student/layouts/chinh.blade.php ENDPATH**/ ?>