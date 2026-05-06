<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <meta name="description" content="Ký túc xá Đại học Phương Đông — Không gian nội trú an toàn, hiện đại dành cho sinh viên. Đăng ký online, nhận phòng nhanh chóng.">

    <title><?php echo e($title ?? 'Ký túc xá Đại học Phương Đông'); ?></title>

    <!-- Preconnect & Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300..700&display=swap" rel="stylesheet">

    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
    
    <style>
        /* Custom sleek fonts, avoiding Inter if requested, using Quicksand or standard sans for structure */
        body { font-family: 'Quicksand', sans-serif; }
        .font-display { font-family: 'Quicksand', sans-serif; }
    </style>
</head>
<body class="bg-ui-bg text-ink-primary antialiased selection:bg-brand-emerald/10 selection:text-brand-emerald relative min-h-screen flex flex-col">

    <!-- Navigation (Solid Minimal) -->
    <header id="site-header" class="fixed top-0 w-full z-[100] bg-ui-card/80 backdrop-blur-xl border-b border-ui-border shadow-sm">
        <div class="max-w-[1200px] mx-auto px-6">
            <nav class="flex items-center justify-between h-20">
                <!-- Logo -->
                <a href="/" class="flex items-center gap-3 group" aria-label="Trang chủ KTX Phương Đông">
                    <div class="w-8 h-8 rounded-lg bg-ink-primary flex items-center justify-center transition-transform duration-300 group-hover:scale-105 shadow-lg shadow-ink-primary/10">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="square" stroke-linejoin="miter" stroke-width="2.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                    </div>
                    <span class="font-display font-bold text-[15px] tracking-tight text-ink-primary group-hover:text-brand-emerald transition-colors duration-200 uppercase italic">PDU <span class="text-brand-emerald">KTX</span></span>
                </a>

                <!-- Desktop Nav -->
                <div class="hidden items-center gap-8 text-[12px] font-bold uppercase tracking-widest text-ink-secondary lg:flex">
                    <a href="/#tong-quan" class="hover:text-ink-primary transition-colors duration-200">Tổng quan</a>
                    <a href="<?php echo e(route('public.danhsachphong')); ?>" class="transition-colors duration-200 <?php echo e(request()->routeIs('public.danhsachphong') ? 'text-ink-primary font-black' : 'hover:text-ink-primary'); ?>">Phòng nội trú</a>
                    <a href="/#chi-phi" class="hover:text-ink-primary transition-colors duration-200">Chi phí</a>
                    <a href="<?php echo e(route('guest.lookup')); ?>" class="hover:text-ink-primary transition-colors duration-200">Tra cứu đơn</a>
                    <a href="/#lien-he" class="hover:text-ink-primary transition-colors duration-200">Hỗ trợ</a>
                </div>

                <!-- CTA -->
                <div class="flex items-center gap-4">
                    <?php if(auth()->guard()->check()): ?>
                        <a href="<?php echo e(route('dieuhuong')); ?>" class="hidden sm:inline-flex text-[12px] font-bold uppercase tracking-widest text-ink-secondary hover:text-ink-primary transition-colors duration-200">Bảng điều khiển</a>
                        <form method="POST" action="<?php echo e(route('logout')); ?>" class="m-0">
                            <?php echo csrf_field(); ?>
                            <button type="submit" class="bg-ui-bg hover:bg-ui-muted text-ink-primary px-5 py-3 rounded-xl text-[12px] font-bold uppercase tracking-widest transition-all duration-200 border border-ui-border">Đăng xuất</button>
                        </form>
                    <?php else: ?>
                        <a href="<?php echo e(route('login')); ?>" class="hidden sm:inline-flex text-[12px] font-bold uppercase tracking-widest text-ink-secondary hover:text-ink-primary transition-colors duration-200">Đăng nhập</a>
                        <a href="<?php echo e(route('public.danhsachphong')); ?>" class="pdu-btn-primary !py-2.5 !px-5 !text-[11px] !rounded-xl">
                            Đăng ký ngay
                        </a>
                    <?php endif; ?>
                </div>
            </nav>
        </div>
    </header>

    <main class="relative z-10 flex-grow pt-20">
        <?php echo e($slot); ?>

    </main>

    <!-- Minimal, structured footer -->
    <footer class="bg-ui-card border-t border-ui-border pt-24 pb-12 mt-0 relative z-20">
        <div class="max-w-[1280px] mx-auto px-6 grid grid-cols-1 md:grid-cols-12 gap-16 items-start">
            <div class="md:col-span-4 flex flex-col gap-6">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-lg bg-ink-primary flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="square" stroke-linejoin="miter" stroke-width="2.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                    </div>
                    <span class="font-display font-bold text-[15px] tracking-tight text-ink-primary uppercase">PDU KTX</span>
                </div>
                <p class="text-ink-secondary/60 text-sm leading-relaxed max-w-[280px]">Môi trường nội trú hiện đại, an toàn và minh bạch dành riêng cho sinh viên Đại học Phương Đông.</p>
            </div>

            <div class="md:col-span-2 md:col-start-7 flex flex-col gap-5">
                <h4 class="text-[10px] font-black uppercase tracking-[0.2em] text-ink-secondary/40">Kết nối</h4>
                <div class="flex flex-col gap-3 text-xs font-bold uppercase tracking-widest text-ink-secondary">
                    <a href="#" class="hover:text-ink-primary transition-colors duration-200">Facebook</a>
                    <a href="#" class="hover:text-ink-primary transition-colors duration-200">Zalo OA</a>
                    <a href="#" class="hover:text-ink-primary transition-colors duration-200">Thư điện tử</a>
                </div>
            </div>

            <div class="md:col-span-3 flex flex-col gap-5">
                <h4 class="text-[10px] font-black uppercase tracking-[0.2em] text-ink-secondary/40">Pháp lý</h4>
                <div class="flex flex-col gap-3 text-xs font-bold uppercase tracking-widest text-ink-secondary">
                    <a href="#" class="hover:text-ink-primary transition-colors duration-200">Quy định nội trú</a>
                    <a href="#" class="hover:text-ink-primary transition-colors duration-200">Chính sách bảo mật</a>
                    <a href="#" class="hover:text-ink-primary transition-colors duration-200">Điều khoản dịch vụ</a>
                </div>
            </div>
        </div>
        
        <div class="max-w-[1280px] mx-auto px-6 mt-20 pt-8 border-t border-ui-border flex flex-col sm:flex-row items-center justify-between text-[10px] font-bold uppercase tracking-widest text-ink-secondary/40">
            <span>&copy; <?php echo e(date('Y')); ?> Đại học Phương Đông. Bảo lưu mọi quyền.</span>
            <span class="mt-2 sm:mt-0 flex items-center gap-1">Thiết kế cho vận hành tại Hà Nội.</span>
        </div>
    </footer>
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
</body>
</html>
<?php /**PATH D:\laragon\www\hethongquanlyktxv1\resources\views/layouts/landing.blade.php ENDPATH**/ ?>