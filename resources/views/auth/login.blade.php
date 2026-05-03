<x-guest-layout>
    <div class="mb-8">
        <a href="{{ route('home') }}" class="group inline-flex items-center gap-2 text-[10px] font-black uppercase tracking-[0.25em] text-ink-secondary/40 transition-colors hover:text-ink-primary">
            <svg class="h-3 w-3 transition-transform group-hover:-translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            Quay lại trang chủ
        </a>
    </div>

    <div class="mb-10">
        <h1 class="text-4xl font-black tracking-tighter text-ink-primary font-display uppercase leading-none mb-3">Đăng nhập.</h1>
        <p class="text-sm font-bold text-ink-secondary/60 leading-relaxed">Truy cập cổng thông tin cư trú của bạn.</p>
    </div>

    <x-auth-session-status class="mb-6 rounded-2xl bg-brand-emerald/5 p-4 text-xs font-bold text-brand-emerald ring-1 ring-brand-emerald/10" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-6">
        @csrf

        <div class="space-y-2 group">
            <label for="email" class="text-[10px] font-black uppercase tracking-[0.2em] text-ink-secondary/40 ml-1 transition-colors group-focus-within:text-brand-emerald">Địa chỉ Email</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" class="pdu-input" placeholder="name@university.edu.vn" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-1 ml-1" />
        </div>

        <div class="space-y-2 group">
            <div class="flex items-center justify-between px-1">
                <label for="password" class="text-[10px] font-black uppercase tracking-[0.2em] text-ink-secondary/40 transition-colors group-focus-within:text-brand-emerald">Mật khẩu</label>
                @if (Route::has('password.request'))
                    <a class="text-[10px] font-black uppercase tracking-[0.2em] text-brand-emerald/60 hover:text-brand-emerald transition-colors" href="{{ route('password.request') }}">Quên?</a>
                @endif
            </div>
            <input id="password" type="password" name="password" class="pdu-input" placeholder="••••••••" required autocomplete="current-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-1 ml-1" />
        </div>

        <div class="flex items-center px-1">
            <label for="remember_me" class="group flex cursor-pointer items-center gap-3">
                <div class="relative flex h-5 w-5 items-center justify-center">
                    <input id="remember_me" type="checkbox" name="remember" class="peer h-full w-full appearance-none rounded-lg border border-ui-border bg-ui-card transition-all checked:border-brand-emerald checked:bg-brand-emerald focus:outline-none" />
                    <svg class="pointer-events-none absolute h-3.5 w-3.5 scale-0 text-white transition-transform peer-checked:scale-100" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="4"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                </div>
                <span class="text-xs font-black text-ink-secondary/60 transition-colors group-hover:text-ink-primary uppercase tracking-widest">Ghi nhớ tôi</span>
            </label>
        </div>

        <button type="submit" class="pdu-btn-primary w-full py-4 text-sm font-black uppercase tracking-[0.2em] shadow-xl shadow-brand-emerald/10">
            Tiếp tục truy cập
        </button>

        <div class="pt-6 text-center border-t border-ui-border">
            <p class="text-[11px] font-bold text-ink-secondary/60">
                Chưa có tài khoản cư trú? 
                <a href="{{ route('register') }}" class="font-black text-brand-emerald hover:underline transition-colors ml-1 uppercase tracking-widest">Yêu cầu cấp mới</a>
            </p>
        </div>
    </form>
</x-guest-layout>
