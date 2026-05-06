<header class="saas-header">
    <!-- Left: Page Title & Mobile Toggle -->
    <div class="flex items-center gap-4">
        <button
            type="button"
            class="lg:hidden p-2 text-slate-500 hover:bg-slate-100 rounded-lg min-h-11 min-w-11 flex items-center justify-center"
            aria-label="Mở menu"
            aria-controls="admin-sidebar"
            @click="sidebarOpen = true"
        >
            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
        </button>
        <h1 class="text-lg font-semibold tracking-tight text-slate-900">{{ $pageTitle ?? 'Bảng điều khiển' }}</h1>
    </div>

    <!-- Right: Actions -->
    <div class="flex items-center gap-3">
        <!-- Global Search -->
        <div class="hidden md:flex relative group">
            <div class="absolute inset-y-0 left-3 flex items-center text-slate-400 group-focus-within:text-brand-emerald transition-colors">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m21 21-4.35-4.35M10.5 18a7.5 7.5 0 1 1 0-15 7.5 7.5 0 0 1 0 15z" /></svg>
            </div>
            <input type="search" class="w-64 saas-input pl-9" placeholder="Tìm kiếm nhanh..." />
        </div>

        <div class="h-6 w-px bg-slate-200 mx-2 hidden sm:block"></div>

        <!-- Notifications -->
        <a href="{{ route('admin.thongbao.index') }}" class="saas-btn-secondary !p-2 relative min-h-11 min-w-11 flex items-center justify-center">
            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.4-1.4A2 2 0 0 1 18 14.2V11a6 6 0 1 0-12 0v3.2a2 2 0 0 1-.6 1.4L4 17h5m6 0a3 3 0 0 1-6 0"/>
            </svg>
            @if(($soYeuCauTraPhongMoi ?? 0) > 0)
                <span class="absolute top-1.5 right-1.5 h-2 w-2 rounded-full bg-rose-500 ring-2 ring-white"></span>
            @endif
        </a>

        <!-- Profile -->
        <a href="{{ route('profile.edit') }}" class="saas-btn-secondary gap-2.5 px-3">
            <div class="h-6 w-6 rounded-md bg-slate-900 flex items-center justify-center text-[10px] font-bold text-white uppercase">
                {{ substr(auth()->user()->name ?? 'A', 0, 1) }}
            </div>
            <span class="text-sm font-medium hidden sm:inline">{{ auth()->user()->name ?? 'Quản trị' }}</span>
        </a>
    </div>
</header>
