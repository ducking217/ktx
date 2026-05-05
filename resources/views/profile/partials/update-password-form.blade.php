<section>
    <header class="mb-8 border-b border-slate-100 pb-4">
        <h2 class="text-lg font-bold text-slate-900 tracking-tight">Bảo mật tài khoản</h2>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="space-y-8">
        @csrf
        @method('put')

        <div class="grid gap-6 md:grid-cols-1">
            @if(!session('magic_login'))
                <div class="space-y-2">
                    <label for="update_password_current_password" class="text-[10px] font-bold uppercase tracking-widest text-slate-400 ml-1">Mật khẩu hiện tại</label>
                    <div class="relative group">
                        <input id="update_password_current_password" name="current_password" type="password" class="saas-input pl-11" autocomplete="current-password" />
                        <div class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 group-focus-within:text-blue-500 transition-colors pointer-events-none">
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25zm10-10V7a4.5 4.5 0 00-8 0v4h8z"/></svg>
                        </div>
                    </div>
                    <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-1 ml-1" />
                </div>
            @else
                <div class="rounded-xl bg-blue-50 p-4 border border-blue-100">
                    <p class="text-[10px] font-bold uppercase tracking-widest text-blue-600">
                        Bạn đang đăng nhập bằng link email. Hãy đặt mật khẩu để lần sau đăng nhập nhanh hơn.
                    </p>
                </div>
            @endif

            <div class="grid gap-6 md:grid-cols-2">
                {{-- New Password --}}
                <div class="space-y-2">
                    <label for="update_password_password" class="text-[10px] font-bold uppercase tracking-widest text-slate-400 ml-1">Mật khẩu mới</label>
                    <div class="relative group">
                        <input id="update_password_password" name="password" type="password" class="saas-input pl-11" autocomplete="new-password" />
                        <div class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 group-focus-within:text-blue-500 transition-colors pointer-events-none">
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/></svg>
                        </div>
                    </div>
                    <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-1 ml-1" />
                </div>

                {{-- Confirm Password --}}
                <div class="space-y-2">
                    <label for="update_password_password_confirmation" class="text-[10px] font-bold uppercase tracking-widest text-slate-400 ml-1">Xác nhận mật khẩu</label>
                    <div class="relative group">
                        <input id="update_password_password_confirmation" name="password_confirmation" type="password" class="saas-input pl-11" autocomplete="new-password" />
                        <div class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 group-focus-within:text-blue-500 transition-colors pointer-events-none">
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                        </div>
                    </div>
                    <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-1 ml-1" />
                </div>
            </div>
        </div>

        <div class="flex items-center gap-4 pt-6 border-t border-slate-100">
            <button type="submit" class="saas-btn-primary h-11 px-6 shadow-lg shadow-blue-500/20">
                Đổi mật khẩu
            </button>

            @if (session('status') === 'password-updated')
                <div
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 translate-x-4"
                    x-transition:enter-end="opacity-100 translate-x-0"
                    x-init="setTimeout(() => show = false, 4000)"
                    class="flex items-center gap-2 text-[10px] font-bold uppercase tracking-widest text-emerald-600"
                >
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                    Đã cập nhật
                </div>
            @endif
        </div>
    </form>
</section>
