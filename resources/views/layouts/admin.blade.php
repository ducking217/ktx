<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
@php
    $pageTitle = $title ?? trim($__env->yieldContent('title')) ?: 'Bảng điều khiển';
@endphp
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $pageTitle }} - Quản trị KTX</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Geist+Sans:wght@100..900&family=Quicksand:wght@400..700&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-ui-bg font-sans antialiased text-ink-primary">
    <div x-data="{ sidebarOpen: false }" class="saas-layout">
        <div
            x-cloak
            x-show="sidebarOpen"
            x-transition.opacity.duration.150ms
            class="fixed inset-0 z-40 bg-slate-900/20 backdrop-blur-sm lg:hidden"
            @click="sidebarOpen = false"
        ></div>

        <!-- Sidebar -->
        @include('admin.partials.sidebar')

        <div class="flex-1 pl-64 flex flex-col min-h-screen">
            <!-- Navbar -->
            @include('admin.partials.navbar', ['pageTitle' => $pageTitle])

            <main class="flex-1 p-4 md:p-8 lg:p-10 pb-24 lg:pb-12">
                <!-- Breadcrumbs -->
                <div class="mb-6">
                    @if(isset($breadcrumbs))
                        {{ $breadcrumbs }}
                    @else
                        <x-breadcrumbs />
                    @endif
                </div>

                <!-- Notifications/Alerts -->
                @if ($errors->any())
                    <div class="mb-6 saas-card bg-rose-50 border-rose-100 p-4 animate-in fade-in slide-in-from-top-4">
                        <div class="flex gap-3">
                            <svg class="h-5 w-5 text-rose-500 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            <div>
                                <p class="text-sm font-semibold text-rose-800">Phát hiện lỗi nhập liệu:</p>
                                <ul class="mt-1 list-inside list-disc text-xs text-rose-700/80 space-y-0.5">
                                    @foreach ($errors->all() as $loi)
                                        <li>{{ $loi }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                @endif

                @if(session('success'))
                    <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)" class="fixed top-6 right-6 z-[100] animate-in fade-in zoom-in slide-in-from-right-8 duration-300">
                        <div class="saas-card flex items-center gap-3 px-4 py-3 shadow-xl border-slate-200/50">
                            <div class="h-8 w-8 rounded-full bg-emerald-100 flex items-center justify-center shrink-0">
                                <svg class="h-5 w-5 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            </div>
                            <span class="text-sm font-medium text-slate-700">{{ session('success') }}</span>
                            <button @click="show = false" class="ml-2 text-slate-400 hover:text-slate-600">
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                            </button>
                        </div>
                    </div>
                @endif

                <!-- Content Slot -->
                <div class="relative min-h-[500px]">
                    @isset($slot)
                        {{ $slot }}
                    @else
                        @yield('content')
                    @endisset
                </div>
            </main>
        </div>

        <x-toast />

        <!-- Mobile Navigation -->
        <nav class="fixed bottom-0 left-0 right-0 z-40 bg-white/90 backdrop-blur-lg border-t border-ui-border p-2 lg:hidden">
            <div class="flex items-center justify-around max-w-md mx-auto">
                <a href="{{ route('admin.trangchu') }}" class="flex flex-col items-center gap-1 p-2 rounded-lg transition-colors {{ request()->routeIs('admin.trangchu') ? 'text-brand-emerald bg-brand-emerald/10' : 'text-slate-500 hover:text-slate-900' }}">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                    <span class="text-[10px] font-medium">Trang chủ</span>
                </a>
                <a href="{{ route('admin.hoadon.index') }}" class="flex flex-col items-center gap-1 p-2 rounded-lg transition-colors {{ request()->routeIs('admin.hoadon.*') ? 'text-brand-emerald bg-brand-emerald/10' : 'text-slate-500 hover:text-slate-900' }}">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-6m0 0V9a2 2 0 1 1 4 0v2m0 2v6M5 11h14" /></svg>
                    <span class="text-[10px] font-medium">Hóa đơn</span>
                </a>
                <a href="{{ route('admin.baohong.index') }}" class="flex flex-col items-center gap-1 p-2 rounded-lg transition-colors {{ request()->routeIs('admin.baohong.*') ? 'text-brand-emerald bg-brand-emerald/10' : 'text-slate-500 hover:text-slate-900' }}">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <span class="text-[10px] font-medium">Báo hỏng</span>
                </a>
                <a href="{{ route('admin.sinhvien.index') }}" class="flex flex-col items-center gap-1 p-2 rounded-lg transition-colors {{ request()->routeIs('admin.sinhvien.*') ? 'text-brand-emerald bg-brand-emerald/10' : 'text-slate-500 hover:text-slate-900' }}">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                    <span class="text-[10px] font-medium">Sinh viên</span>
                </a>
            </div>
        </nav>
    </div>
    @stack('modals')
    @stack('scripts')
</body>
</html>
