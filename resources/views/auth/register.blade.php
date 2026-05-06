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
                <h1 class="text-4xl font-black tracking-tight text-slate-900 leading-none mb-3">Đăng ký.</h1>
                <p class="text-sm font-medium text-slate-500 leading-relaxed">Khởi tạo hồ sơ cư trú sinh viên PDU.</p>
            </div>
        </div>

        {{-- Registration Form --}}
        <form method="POST" action="{{ route('register') }}" class="space-y-8">
            @csrf

            <div class="space-y-6">
                {{-- Họ và tên --}}
                <div class="space-y-2.5 group">
                    <label for="name" class="text-[10px] font-bold uppercase tracking-widest text-slate-400 ml-1 group-focus-within:text-slate-900 transition-colors">Họ và tên đầy đủ</label>
                    <div class="relative">
                        <input id="name" type="text" name="name" value="{{ old('name') }}" 
                               class="saas-input h-14 pl-12 bg-slate-50/30 border-slate-100 focus:bg-white transition-all" 
                               placeholder="Nguyễn Văn A" required autofocus autocomplete="name" />
                        <div class="absolute inset-y-0 left-4 flex items-center pointer-events-none text-slate-300 group-focus-within:text-slate-900 transition-colors">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                        </div>
                    </div>
                    <x-input-error :messages="$errors->get('name')" class="ml-1" />
                </div>

                {{-- Email & Giới tính --}}
                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                    <div class="space-y-2.5 group sm:col-span-1">
                        <label for="email" class="text-[10px] font-bold uppercase tracking-widest text-slate-400 ml-1 group-focus-within:text-slate-900 transition-colors">Địa chỉ thư điện tử</label>
                        <input id="email" type="email" name="email" value="{{ old('email', $prefillEmail ?? '') }}" 
                               class="saas-input h-14 bg-slate-50/30 border-slate-100 focus:bg-white transition-all" 
                               placeholder="mssv@pdu.edu.vn" required autocomplete="username" />
                        <x-input-error :messages="$errors->get('email')" class="ml-1" />
                    </div>

                    <div class="space-y-2.5 group sm:col-span-1">
                        <label for="gioitinh" class="text-[10px] font-bold uppercase tracking-widest text-slate-400 ml-1 group-focus-within:text-slate-900 transition-colors">Giới tính</label>
                        <select id="gioitinh" name="gioitinh" class="saas-input h-14 bg-slate-50/30 border-slate-100 focus:bg-white transition-all" required>
                            <option value="">Chọn</option>
                            <option value="Nam" {{ old('gioitinh') === 'Nam' ? 'selected' : '' }}>Nam</option>
                            <option value="Nữ" {{ old('gioitinh') === 'Nữ' ? 'selected' : '' }}>Nữ</option>
                        </select>
                        <x-input-error :messages="$errors->get('gioitinh')" class="ml-1" />
                    </div>
                </div>

                {{-- Mật khẩu --}}
                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                    <div class="space-y-2.5 group">
                        <label for="password" class="text-[10px] font-bold uppercase tracking-widest text-slate-400 ml-1 group-focus-within:text-slate-900 transition-colors">Mật khẩu</label>
                        <input id="password" type="password" name="password" 
                               class="saas-input h-14 bg-slate-50/30 border-slate-100 focus:bg-white transition-all" 
                               placeholder="••••••••" required autocomplete="new-password" />
                        <x-input-error :messages="$errors->get('password')" class="ml-1" />
                    </div>

                    <div class="space-y-2.5 group">
                        <label for="password_confirmation" class="text-[10px] font-bold uppercase tracking-widest text-slate-400 ml-1 group-focus-within:text-slate-900 transition-colors">Xác nhận</label>
                        <input id="password_confirmation" type="password" name="password_confirmation" 
                               class="saas-input h-14 bg-slate-50/30 border-slate-100 focus:bg-white transition-all" 
                               placeholder="••••••••" required autocomplete="new-password" />
                        <x-input-error :messages="$errors->get('password_confirmation')" class="ml-1" />
                    </div>
                </div>
            </div>

            {{-- Submit Action --}}
            <div class="pt-4">
                <button type="submit" class="saas-btn-primary w-full h-14 text-[11px] font-bold uppercase tracking-[0.2em] shadow-2xl shadow-slate-900/10 active:scale-[0.98] transition-transform">
                    Khởi tạo hồ sơ
                </button>
            </div>

            {{-- Footer Links --}}
            <div class="pt-10 text-center border-t border-slate-50">
                <p class="text-[11px] font-bold text-slate-400 uppercase tracking-widest">
                    Đã có tài khoản cư trú? 
                    <a href="{{ route('login') }}" class="font-black text-blue-600 hover:text-blue-700 ml-1 transition-colors group">
                        Đăng nhập ngay
                        <span class="inline-block transition-transform group-hover:translate-x-0.5">→</span>
                    </a>
                </p>
            </div>
        </form>
    </div>
</x-guest-layout>
