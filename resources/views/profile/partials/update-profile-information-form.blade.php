<section>
    <header class="mb-8 border-b border-slate-100 pb-4">
        <h2 class="text-lg font-bold text-slate-900 tracking-tight">Thông tin định danh</h2>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="space-y-8" enctype="multipart/form-data">
        @csrf
        @method('patch')

        {{-- Basic Info Grid --}}
        <div class="grid gap-6 md:grid-cols-2">
            {{-- Name --}}
            <div class="space-y-2">
                <label for="name" class="text-[10px] font-bold uppercase tracking-widest text-slate-400 ml-1">Họ và tên</label>
                <div class="relative group">
                    <input id="name" name="name" type="text" class="saas-input pl-11" value="{{ old('name', $user->name) }}" required autofocus autocomplete="name" />
                    <div class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 group-focus-within:text-blue-500 transition-colors pointer-events-none">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                    </div>
                </div>
                <x-input-error class="mt-1 ml-1" :messages="$errors->get('name')" />
            </div>

            {{-- Email --}}
            <div class="space-y-2">
                <label for="email" class="text-[10px] font-bold uppercase tracking-widest text-slate-400 ml-1">Địa chỉ Email</label>
                <div class="relative group">
                    <input id="email" name="email" type="email" class="saas-input pl-11" value="{{ old('email', $user->email) }}" required autocomplete="username" />
                    <div class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 group-focus-within:text-blue-500 transition-colors pointer-events-none">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                    </div>
                </div>
                <x-input-error class="mt-1 ml-1" :messages="$errors->get('email')" />

                @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                    <div class="mt-3 text-[10px] font-bold text-amber-600 flex items-center gap-1.5">
                        <svg class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                        <span>Email chưa được xác minh.</span>
                        <button form="send-verification" class="ml-1 underline hover:text-amber-800 transition-colors">
                            Gửi lại mã
                        </button>
                    </div>
                @endif
            </div>
        </div>

        @if($user->vaitro === \App\Enums\UserRole::SinhVien)
            <div class="pt-8 border-t border-slate-100 grid gap-6 md:grid-cols-2">
                {{-- Mã sinh viên --}}
                <div class="space-y-2">
                    <label for="ma_sinh_vien" class="text-[10px] font-bold uppercase tracking-widest text-slate-400 ml-1">Mã sinh viên</label>
                    <input id="ma_sinh_vien" name="ma_sinh_vien" type="text" class="saas-input bg-slate-50 text-slate-500 cursor-not-allowed" value="{{ old('ma_sinh_vien', optional($user->sinhvien)->ma_sinh_vien) }}" readonly />
                    <p class="text-[9px] font-medium text-slate-400 ml-1 italic">Liên hệ BQL để thay đổi MSSV</p>
                </div>

                {{-- Lớp --}}
                <div class="space-y-2">
                    <label for="lop" class="text-[10px] font-bold uppercase tracking-widest text-slate-400 ml-1">Lớp / Khóa học</label>
                    <input id="lop" name="lop" type="text" class="saas-input" value="{{ old('lop', optional($user->sinhvien)->lop) }}" placeholder="Ví dụ: CNTT K15" />
                    <x-input-error class="mt-1 ml-1" :messages="$errors->get('lop')" />
                </div>

                {{-- Số điện thoại --}}
                <div class="space-y-2">
                    <label for="phone" class="text-[10px] font-bold uppercase tracking-widest text-slate-400 ml-1">Số điện thoại</label>
                    <div class="relative group">
                        <input id="phone" name="phone" type="text" class="saas-input pl-11" value="{{ old('phone', $user->phone) }}" />
                        <div class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 group-focus-within:text-blue-500 transition-colors pointer-events-none">
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                        </div>
                    </div>
                    <x-input-error class="mt-1 ml-1" :messages="$errors->get('phone')" />
                </div>

                {{-- Giới tính --}}
                <div class="space-y-2">
                    <label for="gender" class="text-[10px] font-bold uppercase tracking-widest text-slate-400 ml-1">Giới tính</label>
                    <select id="gender" name="gender" class="saas-input font-bold !pr-10">
                        <option value="">-- Chọn giới tính --</option>
                        <option value="male" {{ old('gender', $user->gender?->value) === 'male' ? 'selected' : '' }}>Nam</option>
                        <option value="female" {{ old('gender', $user->gender?->value) === 'female' ? 'selected' : '' }}>Nữ</option>
                        <option value="other" {{ old('gender', $user->gender?->value) === 'other' ? 'selected' : '' }}>Khác</option>
                    </select>
                    <x-input-error class="mt-1 ml-1" :messages="$errors->get('gender')" />
                </div>

                {{-- Ngày sinh --}}
                <div class="space-y-2">
                    <label for="dob" class="text-[10px] font-bold uppercase tracking-widest text-slate-400 ml-1">Ngày sinh</label>
                    <input id="dob" name="dob" type="date" class="saas-input" value="{{ old('dob', $user->dob?->format('Y-m-d')) }}" />
                    <x-input-error class="mt-1 ml-1" :messages="$errors->get('dob')" />
                </div>

                {{-- CCCD --}}
                <div class="space-y-2">
                    <label for="id_card" class="text-[10px] font-bold uppercase tracking-widest text-slate-400 ml-1">Số CCCD / Định danh</label>
                    <input id="id_card" name="id_card" type="text" class="saas-input" value="{{ old('id_card', $user->id_card) }}" />
                    <x-input-error class="mt-1 ml-1" :messages="$errors->get('id_card')" />
                </div>

                @php
                    $sv = $user->sinhvien;
                    $anhTheUrl = $sv?->anh_the_path ? \App\Http\Controllers\Shared\FileController::generateSignedUrl($sv->anh_the_path) : null;
                    $anhCccdUrl = $sv?->anh_cccd_path ? \App\Http\Controllers\Shared\FileController::generateSignedUrl($sv->anh_cccd_path) : null;
                @endphp
                <div class="md:col-span-2 grid gap-6 md:grid-cols-2">
                    <div class="space-y-2">
                        <div class="text-[10px] font-bold uppercase tracking-widest text-slate-400 ml-1">Ảnh sinh viên (3x4)</div>
                        <div class="overflow-hidden rounded-xl border border-slate-200 bg-slate-50/50 p-4">
                            <div class="flex items-start gap-4">
                                <div class="h-20 w-16 overflow-hidden rounded-lg bg-slate-100 border border-slate-200">
                                    @if($anhTheUrl)
                                        <a href="{{ $anhTheUrl }}" target="_blank" rel="noopener">
                                            <img src="{{ $anhTheUrl }}" class="h-full w-full object-cover" />
                                        </a>
                                    @else
                                        <div class="flex h-full w-full items-center justify-center text-[10px] font-bold text-slate-300 uppercase italic">N/A</div>
                                    @endif
                                </div>
                                <div class="flex-1 space-y-2">
                                    <input type="file" name="anh_the" class="block w-full text-xs text-slate-500 file:mr-3 file:py-2 file:px-4 file:border-0 file:border-r file:border-slate-200 file:text-[10px] file:font-bold file:uppercase file:tracking-widest file:bg-white file:text-slate-900 hover:file:bg-slate-50 transition-colors cursor-pointer border border-slate-200 bg-white rounded-lg" />
                                    <x-input-error class="mt-1 ml-1" :messages="$errors->get('anh_the')" />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="space-y-2">
                        <div class="text-[10px] font-bold uppercase tracking-widest text-slate-400 ml-1">Ảnh CCCD</div>
                        <div class="overflow-hidden rounded-xl border border-slate-200 bg-slate-50/50 p-4">
                            <div class="flex items-start gap-4">
                                <div class="h-20 w-32 overflow-hidden rounded-lg bg-slate-100 border border-slate-200">
                                    @if($anhCccdUrl)
                                        <a href="{{ $anhCccdUrl }}" target="_blank" rel="noopener">
                                            <img src="{{ $anhCccdUrl }}" class="h-full w-full object-cover" />
                                        </a>
                                    @else
                                        <div class="flex h-full w-full items-center justify-center text-[10px] font-bold text-slate-300 uppercase italic">N/A</div>
                                    @endif
                                </div>
                                <div class="flex-1 space-y-2">
                                    <input type="file" name="anh_cccd" class="block w-full text-xs text-slate-500 file:mr-3 file:py-2 file:px-4 file:border-0 file:border-r file:border-slate-200 file:text-[10px] file:font-bold file:uppercase file:tracking-widest file:bg-white file:text-slate-900 hover:file:bg-slate-50 transition-colors cursor-pointer border border-slate-200 bg-white rounded-lg" />
                                    <x-input-error class="mt-1 ml-1" :messages="$errors->get('anh_cccd')" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Địa chỉ --}}
                <div class="md:col-span-2 space-y-2">
                    <label for="address" class="text-[10px] font-bold uppercase tracking-widest text-slate-400 ml-1">Địa chỉ liên hệ</label>
                    <textarea id="address" name="address" rows="2" class="saas-input !h-auto py-3 resize-none font-medium" placeholder="Số nhà, tên đường, xã/phường, quận/huyện, tỉnh/thành phố...">{{ old('address', $user->address) }}</textarea>
                    <x-input-error class="mt-1 ml-1" :messages="$errors->get('address')" />
                </div>
            </div>
        @endif

        <div class="flex items-center gap-4 pt-6 border-t border-slate-100">
            <button type="submit" class="saas-btn-primary h-11 px-6 shadow-lg shadow-blue-500/20">
                Lưu hồ sơ
            </button>

            @if (session('status') === 'profile-updated')
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
