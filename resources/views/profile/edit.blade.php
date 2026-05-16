@php
    $vaitro = auth()->user()->vaitro;
    $isAdmin = auth()->user()->isAdminGroup();
    $layout = $isAdmin ? 'admin-layout' : 'student-layout';
@endphp

<x-dynamic-component :component="$layout">
    <x-slot:title>Hồ sơ cá nhân</x-slot:title>

    <div class="space-y-8">
        @if(!$isAdmin)
            <div class="mb-8">
                <h1 class="text-2xl font-bold text-slate-900 tracking-tight">Hồ sơ cá nhân</h1>
                <p class="text-sm font-medium text-slate-500 mt-1">Quản lý thông tin định danh, bảo mật và lịch sử lưu trú.</p>
            </div>
        @else
            <x-admin.page-header
                title="Hồ sơ cá nhân"
                subtitle="Quản lý thông tin định danh, bảo mật và lịch sử lưu trú."
            />
        @endif

        <div class="grid grid-cols-1 gap-8 lg:grid-cols-12">
            {{-- Main Column --}}
            <div class="lg:col-span-8 space-y-8">
                {{-- Profile Info Section --}}
                <div class="saas-card p-6">
                    @include('profile.partials.update-profile-information-form')
                </div>

                @if(($user->vaitro === 'sinhvien' || $user->vaitro === \App\Enums\UserRole::SinhVien) && $sinhvien)
                    {{-- History Dashboard --}}
                    <div class="saas-card p-6 space-y-6">
                        <div class="flex items-center justify-between border-b border-slate-100 pb-4">
                            <h2 class="text-lg font-bold text-slate-900 tracking-tight">Hồ sơ lưu trú</h2>
                        </div>

                        <div x-data="{ activeTab: 'contracts' }" class="space-y-4">
                            <div class="flex items-center gap-1.5 bg-slate-50 p-1.5 rounded-xl border border-slate-200 w-fit">
                                <button @click="activeTab = 'contracts'" :class="activeTab === 'contracts' ? 'bg-white text-slate-900 shadow-sm border border-slate-200' : 'text-slate-500 hover:text-slate-700'" class="px-5 py-2 rounded-lg text-[10px] font-bold uppercase tracking-widest transition-all">Hợp đồng</button>
                                <button @click="activeTab = 'discipline'" :class="activeTab === 'discipline' ? 'bg-white text-rose-600 shadow-sm border border-slate-200' : 'text-slate-500 hover:text-slate-700'" class="px-5 py-2 rounded-lg text-[10px] font-bold uppercase tracking-widest transition-all">Kỷ luật</button>
                                <button @click="activeTab = 'evaluations'" :class="activeTab === 'evaluations' ? 'bg-white text-emerald-600 shadow-sm border border-slate-200' : 'text-slate-500 hover:text-slate-700'" class="px-5 py-2 rounded-lg text-[10px] font-bold uppercase tracking-widest transition-all">Đánh giá</button>
                                <button @click="activeTab = 'bills'" :class="activeTab === 'bills' ? 'bg-white text-blue-600 shadow-sm border border-slate-200' : 'text-slate-500 hover:text-slate-700'" class="px-5 py-2 rounded-lg text-[10px] font-bold uppercase tracking-widest transition-all">Hóa đơn</button>
                            </div>

                            <div class="bg-white border border-slate-200 rounded-xl overflow-hidden min-h-[300px]">
                                {{-- Contracts Tab --}}
                                <div x-show="activeTab === 'contracts'">
                                    <table class="w-full text-left">
                                        <thead class="bg-slate-50 border-b border-slate-200">
                                            <tr>
                                                <th class="px-6 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest">Mã HD</th>
                                                <th class="px-6 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest">Phòng</th>
                                                <th class="px-6 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest">Thời hạn</th>
                                                <th class="px-6 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest">Trạng thái</th>
                                            </tr>
                                        </thead>
                                        <tbody class="divide-y divide-slate-100">
                                            @forelse($sinhvien->hopdongs as $hopdong)
                                                <tr class="hover:bg-slate-50/50 transition-colors">
                                                    <td class="px-6 py-4 text-xs font-bold text-slate-900 tabular-nums tracking-tight">#{{ $hopdong->id }}</td>
                                                    <td class="px-6 py-4 text-xs font-bold text-slate-900">{{ $hopdong->phong?->ten_phong }}</td>
                                                    <td class="px-6 py-4">
                                                        <div class="flex items-center gap-2 text-[10px] font-bold tabular-nums tracking-tight">
                                                            <span class="text-slate-500">{{ $hopdong->ngay_bat_dau }}</span>
                                                            <span class="text-blue-600">{{ $hopdong->ngay_ket_thuc }}</span>
                                                        </div>
                                                    </td>
                                                    <td class="px-6 py-4">
                                                        @php
                                                            $badgeClass = match($hopdong->trang_thai) {
                                                                \App\Enums\ContractStatus::Active => 'saas-badge-success',
                                                                \App\Enums\ContractStatus::Expired => 'saas-badge-warning',
                                                                \App\Enums\ContractStatus::Terminated => 'saas-badge-error',
                                                                default => 'saas-badge-info',
                                                            };
                                                        @endphp
                                                        <span class="saas-badge {{ $badgeClass }}">
                                                            {{ $hopdong->trang_thai->label() }}
                                                        </span>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="4" class="px-6 py-20 text-center">
                                                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Không có dữ liệu hợp đồng</p>
                                                    </td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>

                                {{-- Discipline Tab --}}
                                <div x-show="activeTab === 'discipline'" style="display: none;">
                                    <table class="w-full text-left">
                                        <thead class="bg-slate-50 border-b border-slate-200">
                                            <tr>
                                                <th class="px-6 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest">Ngày vi phạm</th>
                                                <th class="px-6 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest">Mức độ</th>
                                                <th class="px-6 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest">Nội dung</th>
                                            </tr>
                                        </thead>
                                        <tbody class="divide-y divide-slate-100">
                                            @forelse($sinhvien->kyluats as $kyluat)
                                                <tr class="hover:bg-slate-50/50 transition-colors">
                                                    <td class="px-6 py-4 text-xs font-bold text-slate-900 tabular-nums tracking-tight">{{ $kyluat->ngay_vi_pham }}</td>
                                                    <td class="px-6 py-4">
                                                        @php
                                                            $mucDoValue = $kyluat->muc_do?->value ?? $kyluat->muc_do;
                                                            $badgeClass = match($mucDoValue) {
                                                                \App\Enums\DisciplineLevel::High->value => 'saas-badge-error',
                                                                \App\Enums\DisciplineLevel::Medium->value => 'saas-badge-warning',
                                                                default => 'saas-badge-info',
                                                            };
                                                        @endphp
                                                        <span class="saas-badge {{ $badgeClass }}">
                                                            {{ $kyluat->muc_do?->label() ?? 'Bình thường' }}
                                                        </span>
                                                    </td>
                                                    <td class="px-6 py-4 text-sm text-slate-600">
                                                        {{ $kyluat->noi_dung }}
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="3" class="px-6 py-20 text-center">
                                                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Chưa có vi phạm nào</p>
                                                    </td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>

                                {{-- Evaluation Tab --}}
                                <div x-show="activeTab === 'evaluations'" style="display: none;">
                                    <table class="w-full text-left">
                                        <thead class="bg-slate-50 border-b border-slate-200">
                                            <tr>
                                                <th class="px-6 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest">Ngày</th>
                                                <th class="px-6 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest">Điểm</th>
                                                <th class="px-6 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest">Nội dung</th>
                                            </tr>
                                        </thead>
                                        <tbody class="divide-y divide-slate-100">
                                            @forelse($sinhvien->danhgias as $danhgia)
                                                <tr class="hover:bg-slate-50/50 transition-colors">
                                                    <td class="px-6 py-4 text-xs font-bold text-slate-900 tabular-nums tracking-tight">{{ $danhgia->ngaydanhgia }}</td>
                                                    <td class="px-6 py-4">
                                                        <div class="flex items-center gap-0.5 text-amber-400">
                                                            @for($i = 1; $i <= 5; $i++)
                                                                <svg class="h-4 w-4 {{ $i <= $danhgia->diem ? 'fill-current' : 'text-slate-200' }}" viewBox="0 0 20 20" fill="currentColor">
                                                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                                                </svg>
                                                            @endfor
                                                        </div>
                                                    </td>
                                                    <td class="px-6 py-4 text-sm text-slate-600">
                                                        {{ $danhgia->noidung }}
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="3" class="px-6 py-20 text-center">
                                                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Chưa có đánh giá nào</p>
                                                    </td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>

                                {{-- Bills Tab --}}
                                <div x-show="activeTab === 'bills'" style="display: none;">
                                    <table class="w-full text-left">
                                        <thead class="bg-slate-50 border-b border-slate-200">
                                            <tr>
                                                <th class="px-6 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest">Tháng hóa đơn</th>
                                                <th class="px-6 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest">Số tiền</th>
                                                <th class="px-6 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest">Trạng thái</th>
                                            </tr>
                                        </thead>
                                        <tbody class="divide-y divide-slate-100">
                                            @forelse($hoadons as $hoadon)
                                                <tr class="hover:bg-slate-50/50 transition-colors">
                                                    @php
                                                        $ky = null;
                                                        if (is_string($hoadon->ghi_chu) && preg_match('/Ky\s+(\d{1,2}\/\d{4})/u', $hoadon->ghi_chu, $m)) {
                                                            $ky = $m[1];
                                                        }
                                                        $kyHienThi = $ky
                                                            ?? ($hoadon->ngay_thanh_toan?->format('m/Y') ?? $hoadon->created_at?->format('m/Y'))
                                                            ?? 'Chưa có';
                                                    @endphp
                                                    <td class="px-6 py-4 text-xs font-bold text-slate-900 uppercase tracking-tight">Tháng {{ $kyHienThi }}</td>
                                                    <td class="px-6 py-4 text-xs font-bold text-slate-900 tabular-nums tracking-tight">{{ number_format((int) $hoadon->tong_tien) }}đ</td>
                                                    <td class="px-6 py-4">
                                                        @php
                                                            $invoiceType = (string) ($hoadon->loai_hoadon ?? '');
                                                            $billBadgeClass = $hoadon->trang_thai->badgeClass($invoiceType);
                                                        @endphp
                                                        <span class="saas-badge {{ $billBadgeClass }}">
                                                            {{ $hoadon->trang_thai->displayLabel($invoiceType) }}
                                                        </span>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="3" class="px-6 py-20 text-center">
                                                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Không có lịch sử hóa đơn</p>
                                                    </td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                
                {{-- Password Section --}}
                <div class="saas-card p-6">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            {{-- Sidebar Column --}}
            <aside class="lg:col-span-4 space-y-8">
                {{-- Residence Summary --}}
                @if($user->sinhvien && ($phongHienTai || $user->sinhvien->phong))
                    <div class="saas-card p-6 border-dashed">
                        <h3 class="text-[10px] font-bold uppercase tracking-widest text-slate-400 mb-6">Định danh lưu trú</h3>
                        
                        <div class="flex items-center gap-4 mb-6">
                            <div class="h-14 w-14 overflow-hidden rounded-xl bg-slate-100 border border-slate-200">
                                @php
                                    $anhTheUrl = $user->sinhvien?->anh_the_path ? \App\Http\Controllers\Shared\FileController::generateSignedUrl($user->sinhvien->anh_the_path) : null;
                                @endphp
                                @if($anhTheUrl)
                                    <img src="{{ $anhTheUrl }}" class="h-full w-full object-cover" />
                                @else
                                    <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=f1f5f9&color=0f172a&bold=true" class="h-full w-full object-cover" />
                                @endif
                            </div>
                            <div>
                                <div class="text-sm font-bold text-slate-900 leading-none">{{ $phongHienTai?->ten_phong ?? $user->sinhvien->phong?->ten_phong ?? 'Chưa có' }}</div>
                                <div class="text-[10px] font-bold text-slate-500 uppercase tracking-widest mt-1.5">Giường {{ $giuongHienTai?->ma_giuong ?? $hopdongHienTai?->giuong?->ma_giuong ?? 'Chưa có' }}</div>
                            </div>
                        </div>

                        <div class="space-y-3 pt-6 border-t border-slate-100">
                            <div class="flex items-center justify-between">
                                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">MSSV</span>
                                <span class="text-xs font-bold text-slate-900 tabular-nums">{{ $user->sinhvien->ma_sinh_vien ?? 'Chưa có' }}</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Hợp đồng</span>
                                <span class="saas-badge {{ $user->sinhvien->hopdongs->where('trang_thai', \App\Enums\ContractStatus::Active)->first() ? 'saas-badge-success' : 'saas-badge-error' }}">
                                    {{ $user->sinhvien->hopdongs->where('trang_thai', \App\Enums\ContractStatus::Active)->first() ? 'Còn hiệu lực' : 'Không có' }}
                                </span>
                            </div>
                        </div>
                    </div>
                @endif

                {{-- Status Card --}}
                <div class="saas-card p-6">
                    <h3 class="text-[10px] font-bold uppercase tracking-widest text-slate-400 mb-6">Trạng thái bảo mật</h3>
                    <div class="space-y-4">
                        <div class="flex items-center justify-between">
                            <span class="text-[11px] font-bold text-slate-600">Xác minh danh tính</span>
                            <span class="saas-badge saas-badge-success">Đã xác minh</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-[11px] font-bold text-slate-600">Bảo mật 2 lớp</span>
                            <span class="saas-badge saas-badge-info">Chưa kích hoạt</span>
                        </div>
                    </div>
                </div>

                {{-- Delete Account Section --}}
                <div class="saas-card p-6 border-rose-100 bg-rose-50/50">
                    @include('profile.partials.delete-user-form')
                </div>
            </aside>
        </div>
    </div>
</x-dynamic-component>
