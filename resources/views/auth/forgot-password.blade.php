<x-guest-layout>
    <div class="space-y-12">
        {{-- Header Section --}}
        <div>
            <div class="mb-8">
                <a href="{{ route('login') }}" class="inline-flex items-center gap-2 text-[10px] font-bold uppercase tracking-widest text-slate-400 hover:text-slate-900 transition-colors group">
                    <svg class="h-3.5 w-3.5 transition-transform group-hover:-translate-x-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
                    </svg>
                    Quay lại đăng nhập
                </a>
            </div>

            <div class="relative">
                <div class="absolute -left-4 top-0 h-12 w-1 bg-slate-900 rounded-full"></div>
                <h1 class="text-4xl font-black tracking-tight text-slate-900 leading-none mb-3">Quên mật khẩu?</h1>
                <p class="text-sm font-medium text-slate-500 leading-relaxed">Nhập email để hệ thống gửi liên kết đặt lại mật khẩu bảo mật.</p>
            </div>
        </div>

        {{-- Session Status --}}
        <x-auth-session-status class="mb-8" :status="session('status')" />

        {{-- Forgot Password Form --}}
        <form method="POST" action="{{ route('password.email') }}" class="space-y-8">
            @csrf

            <div class="space-y-2.5 group">
                <label for="email" class="text-[10px] font-bold uppercase tracking-widest text-slate-400 ml-1 group-focus-within:text-slate-900 transition-colors">Địa chỉ Email xác thực</label>
                <div class="relative">
                    <input id="email" type="email" name="email" value="{{ old('email') }}" 
                           class="saas-input h-14 pl-12 bg-slate-50/30 border-slate-100 focus:bg-white transition-all" 
                           placeholder="mssv@university.edu.vn" required autofocus />
                    <div class="absolute inset-y-0 left-4 flex items-center pointer-events-none text-slate-300 group-focus-within:text-slate-900 transition-colors">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.206"/></svg>
                    </div>
                </div>
                <x-input-error :messages="$errors->get('email')" class="ml-1" />
            </div>

            <div class="pt-4">
                <button type="submit" class="saas-btn-primary w-full h-14 text-[11px] font-bold uppercase tracking-[0.2em] shadow-2xl shadow-slate-900/10 active:scale-[0.98] transition-transform">
                    Gửi yêu cầu khôi phục
                </button>
            </div>
        </form>
    </div>
</x-guest-layout>
