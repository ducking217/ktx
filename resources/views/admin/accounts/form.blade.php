<x-admin-layout>
    <x-slot name="title">{{ isset($user) ? 'Chỉnh sửa tài khoản' : 'Tạo tài khoản mới' }}</x-slot>

    <div class="max-w-4xl mx-auto space-y-8 animate-fade-up">
        <header class="flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-black text-ink-primary uppercase tracking-tight">{{ isset($user) ? 'Cập nhật tài khoản' : 'Thêm thành viên mới' }}</h2>
                <p class="text-[10px] font-bold text-ink-secondary/50 uppercase tracking-widest mt-1">
                    {{ isset($user) ? 'Thay đổi thông tin cho ' . $user->name : 'Cấp quyền truy cập hệ thống vận hành' }}
                </p>
            </div>
            
            <a href="{{ route('admin.accounts.index') }}" class="pdu-btn-secondary !py-2">
                Quay lại
            </a>
        </header>

        <form action="{{ isset($user) ? route('admin.accounts.capnhat', $user->id) : route('admin.accounts.luu') }}" method="POST" class="space-y-6">
            @csrf
            @if(isset($user)) @method('PUT') @endif

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- Thông tin cơ bản --}}
                <div class="md:col-span-2 pdu-card space-y-6">
                    <h3 class="text-[11px] font-black text-ink-primary uppercase tracking-widest border-b border-ui-border pb-4">Thông tin định danh</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-2">
                            <label class="text-[10px] font-black uppercase tracking-widest text-ink-secondary">Họ và tên</label>
                            <input type="text" name="name" value="{{ old('name', $user->name ?? '') }}" required
                                class="pdu-input w-full" placeholder="Nguyễn Văn A">
                            @error('name') <p class="text-[10px] font-bold text-status-error uppercase mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div class="space-y-2">
                            <label class="text-[10px] font-black uppercase tracking-widest text-ink-secondary">Địa chỉ Email</label>
                            <input type="email" name="email" value="{{ old('email', $user->email ?? '') }}" required
                                class="pdu-input w-full" placeholder="admin@pdu.edu.vn">
                            @error('email') <p class="text-[10px] font-bold text-status-error uppercase mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>
                </div>

                {{-- Mật khẩu --}}
                <div class="pdu-card space-y-6">
                    <h3 class="text-[11px] font-black text-ink-primary uppercase tracking-widest border-b border-ui-border pb-4">Bảo mật</h3>
                    
                    <div class="space-y-4">
                        <div class="space-y-2">
                            <label class="text-[10px] font-black uppercase tracking-widest text-ink-secondary">Mật khẩu {{ isset($user) ? '(Để trống nếu không đổi)' : '' }}</label>
                            <input type="password" name="password" class="pdu-input w-full" placeholder="••••••••">
                            @error('password') <p class="text-[10px] font-bold text-status-error uppercase mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div class="space-y-2">
                            <label class="text-[10px] font-black uppercase tracking-widest text-ink-secondary">Xác nhận mật khẩu</label>
                            <input type="password" name="password_confirmation" class="pdu-input w-full" placeholder="••••••••">
                        </div>
                    </div>
                </div>

                {{-- Vai trò & Trạng thái --}}
                <div class="pdu-card space-y-6">
                    <h3 class="text-[11px] font-black text-ink-primary uppercase tracking-widest border-b border-ui-border pb-4">Phân quyền & Trạng thái</h3>
                    
                    <div class="space-y-4">
                        <div class="space-y-2">
                            <label class="text-[10px] font-black uppercase tracking-widest text-ink-secondary">Vai trò người dùng</label>
                            <select name="vaitro" class="pdu-input w-full bg-white" required>
                                @foreach(\App\Enums\UserRole::cases() as $role)
                                    @if($role->isAdminGroup())
                                        <option value="{{ $role->value }}" @selected(old('vaitro', $user->vaitro->value ?? '') == $role->value)>
                                            {{ $role->label() }}
                                        </option>
                                    @endif
                                @endforeach
                            </select>
                            @error('vaitro') <p class="text-[10px] font-bold text-status-error uppercase mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div class="flex items-center justify-between p-4 bg-ui-bg rounded-xl border border-ui-border">
                            <div>
                                <div class="text-xs font-bold text-ink-primary">Trạng thái hoạt động</div>
                                <div class="text-[9px] font-medium text-ink-secondary/60 uppercase tracking-widest mt-0.5">Cho phép đăng nhập</div>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="hidden" name="is_active" value="0">
                                <input type="checkbox" name="is_active" value="1" class="sr-only peer" @checked(old('is_active', $user->is_active ?? true))>
                                <div class="w-11 h-6 bg-ui-border peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-brand-emerald"></div>
                            </label>
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex items-center justify-end gap-4 pt-4">
                <button type="submit" class="pdu-btn-primary shadow-xl shadow-brand-emerald/20 !px-12 h-12">
                    <svg class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                    {{ isset($user) ? 'Lưu thay đổi' : 'Xác nhận tạo tài khoản' }}
                </button>
            </div>
        </form>
    </div>
</x-admin-layout>
