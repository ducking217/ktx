<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? config('app.name', 'PDU Portal') }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Geist+Sans:wght@100..900&family=Quicksand:wght@400..700&display=swap" rel="stylesheet">

    <style>
        h1, h2, h3, .font-display { font-family: 'Quicksand', sans-serif !important; }
        body { font-family: 'Geist Sans', sans-serif; }
    </style>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="saas-layout text-ink-primary">
@php
    $hoadonCanXuLy = isset($hoadonchuathanhtoan) && method_exists($hoadonchuathanhtoan, 'count') ? $hoadonchuathanhtoan->count() : 0;
    $hotroCanXuLy = $hoadonCanXuLy > 0 ? 1 : 0;
    $tenSinhVien = auth()->user()->name ?? 'Sinh viên';
    $vaitro = auth()->user()->vaitro;
    $isAlumni = $vaitro === 'cuu_sinhvien';
    $mssv = isset($sinhvien) && !empty($sinhvien?->mssv) ? $sinhvien->mssv : ('SV' . str_pad((string) (auth()->id() ?? 0), 6, '0', STR_PAD_LEFT));
@endphp

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
                    {{ strtoupper(substr($tenSinhVien, 0, 1)) }}
                </div>
                <div class="min-w-0 flex-1">
                    <div class="truncate text-sm font-semibold text-slate-900">{{ $tenSinhVien }}</div>
                    <div class="flex items-center gap-1.5 text-xs text-slate-500">
                        <span @class([
                            'h-1.5 w-1.5 rounded-full',
                            'bg-slate-300' => $isAlumni,
                            'bg-emerald-500' => !$isAlumni,
                        ])></span>
                        <span class="truncate">{{ $mssv }}</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="mb-2 px-3 text-xs font-semibold uppercase tracking-wider text-slate-400">Hệ thống</div>
        <div class="space-y-1">
            <a href="{{ route('student.trangchu') }}" class="saas-sidebar-link {{ request()->routeIs('student.trangchu') ? 'saas-sidebar-link-active' : '' }}">
                <svg class="h-5 w-5 shrink-0 opacity-70" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2z"/></svg>
                <span>Tổng quan</span>
            </a>
            <a href="{{ route('profile.edit') }}" class="saas-sidebar-link {{ request()->routeIs('profile.edit') ? 'saas-sidebar-link-active' : '' }}">
                <svg class="h-5 w-5 shrink-0 opacity-70" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                <span>Hồ sơ cá nhân</span>
            </a>
        </div>

        <div class="mb-2 mt-6 px-3 text-xs font-semibold uppercase tracking-wider text-slate-400">Lưu trú</div>
        <div class="space-y-1">
            @if(!$isAlumni)
                <a href="{{ route('student.phong.index') }}" class="saas-sidebar-link {{ request()->routeIs('student.phong.index') ? 'saas-sidebar-link-active' : '' }}">
                    <svg class="h-5 w-5 shrink-0 opacity-70" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    <span>Xem phòng trống</span>
                </a>
            @endif
            <a href="{{ route('student.hopdong.index') }}" class="saas-sidebar-link {{ request()->routeIs('student.hopdong.index') ? 'saas-sidebar-link-active' : '' }}">
                <svg class="h-5 w-5 shrink-0 opacity-70" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                <span>{{ $isAlumni ? 'Lịch sử nội trú' : 'Hợp đồng & gia hạn' }}</span>
            </a>
            @if(!$isAlumni)
                <a href="{{ route('student.phongcuatoi') }}" class="saas-sidebar-link {{ request()->routeIs('student.phongcuatoi*') ? 'saas-sidebar-link-active' : '' }}">
                    <svg class="h-5 w-5 shrink-0 opacity-70" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                    <span>Phòng của tôi</span>
                </a>
            @endif
        </div>

        <div class="mb-2 mt-6 px-3 text-xs font-semibold uppercase tracking-wider text-slate-400">Giao dịch</div>
        <div class="space-y-1">
            <a href="{{ route('student.hoadon.index') }}" class="saas-sidebar-link {{ request()->routeIs('student.hoadon.index', 'student.hoadon.chitiet') ? 'saas-sidebar-link-active' : '' }}">
                <div class="flex flex-1 items-center gap-3">
                    <svg class="h-5 w-5 shrink-0 opacity-70" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
                    <span>Hóa đơn</span>
                </div>
                @if ($hoadonCanXuLy > 0)
                    <span class="inline-flex min-w-[20px] items-center justify-center rounded-full bg-rose-100 px-1.5 py-0.5 text-[10px] font-bold text-rose-700">{{ $hoadonCanXuLy }}</span>
                @endif
            </a>
        </div>

        <div class="mb-2 mt-6 px-3 text-xs font-semibold uppercase tracking-wider text-slate-400">Tiện ích</div>
        <div class="space-y-1">
            @if(!$isAlumni)
                <a href="{{ route('student.danhsachbaohong') }}" class="saas-sidebar-link {{ request()->routeIs('student.danhsachbaohong') ? 'saas-sidebar-link-active' : '' }}">
                    <svg class="h-5 w-5 shrink-0 opacity-70" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 012 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                    <span>Báo hỏng</span>
                </a>
            @endif
            <a href="{{ route('student.kyluat.index') }}" class="saas-sidebar-link {{ request()->routeIs('student.kyluat.index') ? 'saas-sidebar-link-active' : '' }}">
                <svg class="h-5 w-5 shrink-0 opacity-70" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                <span>Kỷ luật</span>
            </a>
            <a href="{{ route('student.thongbao') }}" class="saas-sidebar-link {{ request()->routeIs('student.thongbao*', 'student.chitietthongbao') ? 'saas-sidebar-link-active' : '' }}">
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
                @if(isset($title))
                    {{ $title }}
                @else
                    @yield('student_page_title', 'Tổng quan')
                @endif
            </h1>
        </div>

        <div class="flex items-center gap-3">
            <a href="{{ route('student.thongbao') }}" class="saas-btn-ghost rounded-full !p-2 relative text-slate-500 hover:text-slate-900">
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.4-1.4a2 2 0 0 1-.6-1.4V11a6 6 0 1 0-12 0v3.2a2 2 0 0 1-.6 1.4L4 17h5m6 0a3 3 0 0 1-6 0"/></svg>
            </a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="saas-btn-secondary h-9 px-4 text-xs font-semibold">Đăng xuất</button>
            </form>
        </div>
    </header>

    <!-- Page Content -->
    <main class="flex-1 p-6 pb-32 lg:pb-12">
        @if ($errors->any())
            <div class="mb-6 rounded-xl border border-rose-200 bg-rose-50 p-4 text-sm text-rose-600 shadow-sm">
                <div class="mb-2 flex items-center gap-2 font-semibold">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <span>Vui lòng kiểm tra lại thông tin:</span>
                </div>
                <ul class="list-inside list-disc space-y-1 pl-7">
                    @foreach ($errors->all() as $loi)
                        <li>{{ $loi }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="animate-in fade-in slide-in-from-bottom-2 duration-500">
            @yield('noidung')
            {{ $slot ?? '' }}
        </div>
    </main>
</div>

<x-toast />
@stack('modals')

<!-- Mobile Navigation (Floating Dock) -->
<nav class="fixed bottom-6 left-1/2 z-50 flex w-[calc(100%-3rem)] max-w-sm -translate-x-1/2 items-center justify-around rounded-2xl border border-slate-200/60 bg-white/95 p-2 shadow-xl backdrop-blur-xl lg:hidden">
    <a href="{{ route('student.trangchu') }}" class="flex flex-col items-center gap-1 rounded-xl p-2 transition-colors {{ request()->routeIs('student.trangchu') ? 'text-slate-900 bg-slate-100' : 'text-slate-500 hover:text-slate-900' }}">
        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
        <span class="text-[10px] font-medium">Trang chủ</span>
    </a>
    <a href="{{ route('student.hoadon.index') }}" class="flex flex-col items-center gap-1 rounded-xl p-2 transition-colors relative {{ request()->routeIs('student.hoadon.index', 'student.hoadon.chitiet') ? 'text-slate-900 bg-slate-100' : 'text-slate-500 hover:text-slate-900' }}">
        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        <span class="text-[10px] font-medium">Hóa đơn</span>
        @if ($hoadonCanXuLy > 0)
            <span class="absolute top-1 right-2 h-2 w-2 rounded-full bg-rose-500"></span>
        @endif
    </a>
    <a href="{{ route('student.danhsachbaohong') }}" class="flex flex-col items-center gap-1 rounded-xl p-2 transition-colors {{ request()->routeIs('student.danhsachbaohong') ? 'text-slate-900 bg-slate-100' : 'text-slate-500 hover:text-slate-900' }}">
        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 012 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
        <span class="text-[10px] font-medium">Báo hỏng</span>
    </a>
    <a href="{{ route('profile.edit') }}" class="flex flex-col items-center gap-1 rounded-xl p-2 transition-colors {{ request()->routeIs('profile.edit') ? 'text-slate-900 bg-slate-100' : 'text-slate-500 hover:text-slate-900' }}">
        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
        <span class="text-[10px] font-medium">Hồ sơ</span>
    </a>
</nav>

</body>
</html>
