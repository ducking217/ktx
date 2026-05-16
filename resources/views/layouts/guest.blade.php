<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Hệ thống quản lý KTX') }}</title>

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Geist+Sans:wght@100..900&family=Quicksand:wght@300..700&display=swap" rel="stylesheet">

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="bg-ui-bg font-sans antialiased text-ink-primary transition-colors duration-300">
        <div class="min-h-screen flex">
            <!-- Left Side: Branding (Hidden on mobile) -->
            <div class="hidden lg:flex lg:w-1/2 relative bg-ink-primary items-center justify-center overflow-hidden">
                <!-- Visual Pattern -->
                <div class="absolute inset-0 opacity-20 bg-[radial-gradient(oklch(var(--brand-emerald-lch))_1.5px,transparent_1.5px)] [background-size:32px_32px]"></div>
                
                <div class="relative z-10 max-w-lg px-12">
                    <div class="flex items-center gap-4 mb-12">
                        <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-brand-emerald text-white shadow-lg shadow-brand-emerald/20">
                            <svg class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m4 0h1m-4 12h1m4 0h1m-4-4h1m4 0h1m-4-4h1m4 0h1m-4-4h1m4 0h1m-4-4h1m4 0h1m-4-4h1m4 0h1"/></svg>
                        </div>
                        <div class="font-display text-3xl font-black tracking-tighter text-white uppercase">PDU <span class="text-brand-emerald">PORTAL</span></div>
                    </div>

                    <h2 class="text-5xl font-display font-black text-white mb-8 leading-[1.1] tracking-tight">
                        Kiến tạo <br>
                        <span class="text-brand-emerald">trải nghiệm sống</span> <br>
                        sinh viên vượt trội.
                    </h2>
                    
                    <p class="text-lg text-white/50 leading-relaxed font-medium max-w-[40ch]">
                        Hệ thống quản lý cư trú tập trung. Minh bạch, an toàn và tối ưu cho hành trình học tập của bạn.
                    </p>
                </div>
            </div>

            <!-- Right Side: Form Area -->
            <div class="w-full lg:w-1/2 flex items-center justify-center p-6 sm:p-12 relative bg-ui-bg">
                <!-- Dot Grid Overlay -->
                <div class="absolute inset-0 opacity-100 bg-[radial-gradient(oklch(var(--ui-border-lch))_1.5px,transparent_1.5px)] [background-size:32px_32px] [mask-image:linear-gradient(to_bottom,white,transparent)] pointer-events-none"></div>

                <div class="relative w-full max-w-md z-10">
                    <!-- Mobile Logo -->
                    <div class="mb-12 flex justify-center lg:hidden">
                        <div class="flex items-center gap-3">
                            <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-brand-emerald text-white shadow-lg shadow-brand-emerald/20">
                                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m4 0h1m-4 12h1m4 0h1m-4-4h1m4 0h1m-4-4h1m4 0h1m-4-4h1m4 0h1m-4-4h1m4 0h1m-4-4h1m4 0h1"/></svg>
                            </div>
                            <div class="font-display text-2xl font-black tracking-tighter text-ink-primary uppercase">PDU <span class="text-brand-emerald">PORTAL</span></div>
                        </div>
                    </div>

                    <div class="animate-fade-up">
                        {{ $slot }}
                    </div>
                    
                    <div class="mt-12 text-center text-[10px] font-black uppercase tracking-[0.2em] text-ink-secondary/20">
                        &copy; {{ date('Y') }} PDU DORMITORY SYSTEM. ALL RIGHTS RESERVED.
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
