<x-guest-layout>
    <div class="space-y-12">
        {{-- Header Section --}}
        <div>
            <div class="mb-8">
                <a href="{{ route('home') }}" class="inline-flex items-center gap-2 text-[10px] font-bold uppercase tracking-widest text-slate-400 hover:text-slate-900 transition-colors group">
                    <svg class="h-3.5 w-3.5 transition-transform group-hover:-translate-x-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
                    </svg>
                    Quay lại trang chủ
                </a>
            </div>

            <div class="relative">
                <div class="absolute -left-4 top-0 h-12 w-1 bg-slate-900 rounded-full"></div>
                <h1 class="text-4xl font-black tracking-tight text-slate-900 leading-none mb-3">Đăng nhập.</h1>
                <p class="text-sm font-medium text-slate-500 leading-relaxed">Cổng thông tin quản lý cư trú sinh viên PDU.</p>
            </div>
        </div>

        {{-- Status Messages --}}
        <x-auth-session-status class="mb-4" :status="session('status')" />

        {{-- Login Form --}}
        <form method="POST" action="{{ route('login') }}" class="space-y-8">
            @csrf

            <div class="space-y-6">
                {{-- Email Field --}}
                <div class="space-y-2.5 group">
                    <label for="email" class="text-[10px] font-bold uppercase tracking-widest text-slate-400 ml-1 group-focus-within:text-slate-900 transition-colors">Địa chỉ Email</label>
                    <div class="relative">
                        <input id="email" type="email" name="email" value="{{ old('email') }}" 
                               class="saas-input h-14 pl-12 bg-slate-50/30 border-slate-100 focus:bg-white transition-all" 
                               placeholder="mssv@university.edu.vn" required autofocus autocomplete="username" />
                        <div class="absolute inset-y-0 left-4 flex items-center pointer-events-none text-slate-300 group-focus-within:text-slate-900 transition-colors">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.206"/></svg>
                        </div>
                    </div>
                    <x-input-error :messages="$errors->get('email')" class="ml-1" />
                </div>

                {{-- Password Field --}}
                <div class="space-y-2.5 group">
                    <div class="flex items-center justify-between px-1">
                        <label for="password" class="text-[10px] font-bold uppercase tracking-widest text-slate-400 group-focus-within:text-slate-900 transition-colors">Mật khẩu bảo mật</label>
                        @if (Route::has('password.request'))
                            <a class="text-[10px] font-bold uppercase tracking-widest text-blue-600 hover:text-blue-700 transition-colors" href="{{ route('password.request') }}">Quên mật khẩu?</a>
                        @endif
                    </div>
                    <div class="relative">
                        <input id="password" type="password" name="password" 
                               class="saas-input h-14 pl-12 bg-slate-50/30 border-slate-100 focus:bg-white transition-all" 
                               placeholder="••••••••" required autocomplete="current-password" />
                        <div class="absolute inset-y-0 left-4 flex items-center pointer-events-none text-slate-300 group-focus-within:text-slate-900 transition-colors">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                        </div>
                    </div>
                    <x-input-error :messages="$errors->get('password')" class="ml-1" />
                </div>
            </div>

            {{-- Remember Me --}}
            <div class="flex items-center px-1">
                <label for="remember_me" class="group flex cursor-pointer items-center gap-3">
                    <div class="relative flex h-5 w-5 items-center justify-center">
                        <input id="remember_me" type="checkbox" name="remember" class="peer h-full w-full appearance-none rounded-lg border border-slate-200 bg-white transition-all checked:border-slate-900 checked:bg-slate-900 focus:outline-none" />
                        <svg class="pointer-events-none absolute h-3 w-3 scale-0 text-white transition-transform peer-checked:scale-100" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="4"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                    </div>
                    <span class="text-[11px] font-bold text-slate-500 transition-colors group-hover:text-slate-900 uppercase tracking-[0.1em]">Duy trì trạng thái đăng nhập</span>
                </label>
            </div>

            {{-- Submit Action --}}
            <div class="pt-4">
                <button type="submit" class="saas-btn-primary w-full h-14 text-[11px] font-bold uppercase tracking-[0.2em] shadow-2xl shadow-slate-900/10 active:scale-[0.98] transition-transform">
                    Xác nhận truy cập
                </button>
            </div>

            {{-- Footer Links --}}
            <div class="pt-10 text-center border-t border-slate-50">
                <p class="text-[11px] font-bold text-slate-400 uppercase tracking-widest">
                    Chưa có tài khoản cư trú? 
                    <a href="{{ route('register') }}" class="font-black text-blue-600 hover:text-blue-700 ml-1 transition-colors group">
                        Đăng ký ngay
                        <span class="inline-block transition-transform group-hover:translate-x-0.5">→</span>
                    </a>
                </p>
            </div>
        </form>
    </div>
</x-guest-layout>
