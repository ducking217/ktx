<x-guest-layout>
    <div class="mb-8">
        <a href="{{ route('home') }}" class="group inline-flex items-center gap-2 text-[10px] font-black uppercase tracking-[0.25em] text-ink-secondary/40 transition-colors hover:text-ink-primary">
            <svg class="h-3 w-3 transition-transform group-hover:-translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            Quay lại trang chủ
        </a>
    </div>

    <div class="mb-10">
        <h1 class="text-4xl font-black tracking-tighter text-ink-primary font-display uppercase leading-none mb-3">Đăng ký.</h1>
        <p class="text-sm font-bold text-ink-secondary/60 leading-relaxed">Khởi đầu hành trình lưu trú của bạn.</p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-6">
        @csrf

        <div class="space-y-2 group">
            <label for="name" class="text-[10px] font-black uppercase tracking-[0.2em] text-ink-secondary/40 ml-1 transition-colors group-focus-within:text-brand-emerald">Họ và tên đầy đủ</label>
            <input id="name" type="text" name="name" value="{{ old('name') }}" class="pdu-input" placeholder="Nguyễn Văn A" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-1 ml-1" />
        </div>

        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
            <div class="space-y-2 group">
                <label for="mssv" class="text-[10px] font-black uppercase tracking-[0.2em] text-ink-secondary/40 ml-1 transition-colors group-focus-within:text-brand-emerald">Mã sinh viên</label>
                <input id="mssv" type="text" name="mssv" value="{{ old('mssv', $prefillMssv ?? '') }}" class="pdu-input tabular-nums" placeholder="SV123456" autocomplete="off" />
            </div>

            <div class="space-y-2 group">
                <label for="gioitinh" class="text-[10px] font-black uppercase tracking-[0.2em] text-ink-secondary/40 ml-1 transition-colors group-focus-within:text-brand-emerald">Giới tính</label>
                <select id="gioitinh" name="gioitinh" class="pdu-select" required>
                    <option value="">Chọn</option>
                    <option value="Nam" {{ old('gioitinh') === 'Nam' ? 'selected' : '' }}>Nam</option>
                    <option value="Nữ" {{ old('gioitinh') === 'Nữ' ? 'selected' : '' }}>Nữ</option>
                </select>
                <x-input-error :messages="$errors->get('gioitinh')" class="mt-1 ml-1" />
            </div>
        </div>

        <div class="space-y-2 group">
            <label for="email" class="text-[10px] font-black uppercase tracking-[0.2em] text-ink-secondary/40 ml-1 transition-colors group-focus-within:text-brand-emerald">Địa chỉ Email</label>
            <input id="email" type="email" name="email" value="{{ old('email', $prefillEmail ?? '') }}" class="pdu-input" placeholder="name@university.edu.vn" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-1 ml-1" />
        </div>

        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
            <div class="space-y-2 group">
                <label for="password" class="text-[10px] font-black uppercase tracking-[0.2em] text-ink-secondary/40 ml-1 transition-colors group-focus-within:text-brand-emerald">Mật khẩu</label>
                <input id="password" type="password" name="password" class="pdu-input" placeholder="••••••••" required autocomplete="new-password" />
                <x-input-error :messages="$errors->get('password')" class="mt-1 ml-1" />
            </div>

            <div class="space-y-2 group">
                <label for="password_confirmation" class="text-[10px] font-black uppercase tracking-[0.2em] text-ink-secondary/40 ml-1 transition-colors group-focus-within:text-brand-emerald">Xác nhận</label>
                <input id="password_confirmation" type="password" name="password_confirmation" class="pdu-input" placeholder="••••••••" required autocomplete="new-password" />
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1 ml-1" />
            </div>
        </div>

        <button type="submit" class="pdu-btn-primary w-full py-4 text-sm font-black uppercase tracking-[0.2em] shadow-xl shadow-brand-emerald/10">
            Khởi tạo tài khoản
        </button>

        <div class="pt-6 text-center border-t border-ui-border">
            <p class="text-[11px] font-bold text-ink-secondary/60">
                Đã có tài khoản cư trú? 
                <a href="{{ route('login') }}" class="font-black text-brand-emerald hover:underline transition-colors ml-1 uppercase tracking-widest">Quay lại đăng nhập</a>
            </p>
        </div>
    </form>
</x-guest-layout>
