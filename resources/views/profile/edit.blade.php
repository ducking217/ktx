@php
    $vaitro = auth()->user()->vaitro;
    $isAdmin = auth()->user()->isAdminGroup();
    $layout = $isAdmin ? 'admin-layout' : 'student-layout';
@endphp

<x-dynamic-component :component="$layout">
    <x-slot:title>Hồ sơ cá nhân</x-slot:title>

    <div class="animate-in fade-in slide-in-from-bottom-4 duration-700">
        <div class="grid grid-cols-1 gap-8 lg:grid-cols-12">
            {{-- Main Column --}}
            <div class="lg:col-span-8 space-y-8">
                {{-- Profile Info Section --}}
                <article class="rounded-3xl border border-ui-border bg-ui-card/50 backdrop-blur-xl p-8 shadow-sm transition-all hover:border-brand-emerald/20">
                    @include('profile.partials.update-profile-information-form')
                </article>

                @if(($user->vaitro === 'sinhvien' || $user->vaitro === \App\Enums\UserRole::SinhVien) && $sinhvien)
                    {{-- History Dashboard (New for Student) --}}
                    <div class="space-y-6">
                        <div class="flex items-center justify-between">
                            <h2 class="font-display text-2xl font-black text-ink-primary uppercase tracking-tight">Hồ sơ <span class="text-brand-emerald">lưu trú</span></h2>
                        </div>

                        <div x-data="{ activeTab: 'contracts' }" class="space-y-4">
                            <div class="flex items-center gap-1 bg-ui-bg p-1 rounded-2xl ring-1 ring-ui-border w-fit">
                                <button @click="activeTab = 'contracts'" :class="activeTab === 'contracts' ? 'bg-white text-ink-primary shadow-sm ring-1 ring-ui-border' : 'text-ink-secondary hover:text-ink-primary'" class="px-5 py-2 rounded-xl text-[10px] font-black uppercase tracking-widest transition-all">Hợp đồng</button>
                                <button @click="activeTab = 'discipline'" :class="activeTab === 'discipline' ? 'bg-white text-status-error shadow-sm ring-1 ring-ui-border' : 'text-ink-secondary hover:text-ink-primary'" class="px-5 py-2 rounded-xl text-[10px] font-black uppercase tracking-widest transition-all">Kỷ luật</button>
                                <button @click="activeTab = 'evaluations'" :class="activeTab === 'evaluations' ? 'bg-white text-status-success shadow-sm ring-1 ring-ui-border' : 'text-ink-secondary hover:text-ink-primary'" class="px-5 py-2 rounded-xl text-[10px] font-black uppercase tracking-widest transition-all">Đánh giá</button>
                                <button @click="activeTab = 'bills'" :class="activeTab === 'bills' ? 'bg-white text-brand-emerald shadow-sm ring-1 ring-ui-border' : 'text-ink-secondary hover:text-ink-primary'" class="px-5 py-2 rounded-xl text-[10px] font-black uppercase tracking-widest transition-all">Hóa đơn</button>
                            </div>

                            <div class="bg-white rounded-3xl shadow-sm ring-1 ring-ui-border overflow-hidden min-h-[300px]">
                                {{-- Contracts Tab --}}
                                <div x-show="activeTab === 'contracts'" class="animate-fade-in">
                                    <table class="w-full text-left">
                                        <thead class="bg-ui-bg/50 border-b border-ui-border">
                                            <tr>
                                                <th class="px-6 py-4 text-[9px] font-black text-ink-secondary uppercase tracking-widest">Mã HD</th>
                                                <th class="px-6 py-4 text-[9px] font-black text-ink-secondary uppercase tracking-widest">Phòng</th>
                                                <th class="px-6 py-4 text-[9px] font-black text-ink-secondary uppercase tracking-widest">Thời hạn</th>
                                                <th class="px-6 py-4 text-[9px] font-black text-ink-secondary uppercase tracking-widest">Trạng thái</th>
                                            </tr>
                                        </thead>
                                        <tbody class="divide-y divide-ui-border">
                                            @forelse($sinhvien->hopdongs as $hopdong)
                                                <tr class="hover:bg-ui-bg/20 transition-colors">
                                                    <td class="px-6 py-4 text-xs font-black text-ink-primary tabular-nums tracking-tight">#{{ $hopdong->id }}</td>
                                                    <td class="px-6 py-4 text-xs font-bold text-ink-primary">{{ $hopdong->phong?->tenphong }}</td>
                                                    <td class="px-6 py-4">
                                                        <div class="flex items-center gap-2 text-[10px] font-bold tabular-nums tracking-tight">
                                                            <span class="text-ink-secondary">{{ $hopdong->ngay_bat_dau }}</span>
                                                            <span class="text-brand-emerald">{{ $hopdong->ngay_ket_thuc }}</span>
                                                        </div>
                                                    </td>
                                                    <td class="px-6 py-4">
                                                        <span @class([
                                                            'inline-flex items-center rounded-lg px-2 py-0.5 text-[8px] font-black uppercase tracking-widest ring-1',
                                                            'bg-status-success/10 text-status-success ring-status-success/20' => $hopdong->trang_thai === \App\Enums\ContractStatus::Active,
                                                            'bg-status-warning/10 text-status-warning ring-status-warning/20' => $hopdong->trang_thai === \App\Enums\ContractStatus::Expired,
                                                            'bg-status-error/10 text-status-error ring-status-error/20' => $hopdong->trang_thai === \App\Enums\ContractStatus::Terminated,
                                                        ])>
                                                            {{ $hopdong->trang_thai->label() }}
                                                        </span>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="4" class="px-6 py-20 text-center">
                                                        <p class="text-[9px] font-black text-ink-secondary/20 uppercase tracking-widest">Không có dữ liệu hợp đồng</p>
                                                    </td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>

                                {{-- Discipline Tab --}}
                                <div x-show="activeTab === 'discipline'" class="animate-fade-in">
                                    <table class="w-full text-left">
                                        <thead class="bg-ui-bg/50 border-b border-ui-border">
                                            <tr>
                                                <th class="px-6 py-4 text-[9px] font-black text-ink-secondary uppercase tracking-widest">Ngày vi phạm</th>
                                                <th class="px-6 py-4 text-[9px] font-black text-ink-secondary uppercase tracking-widest">Mức độ</th>
                                                <th class="px-6 py-4 text-[9px] font-black text-ink-secondary uppercase tracking-widest">Nội dung</th>
                                            </tr>
                                        </thead>
                                        <tbody class="divide-y divide-ui-border">
                                            @forelse($sinhvien->kyluats as $kyluat)
                                                <tr class="hover:bg-ui-bg/20 transition-colors">
                                                    <td class="px-6 py-4 text-xs font-black text-ink-primary tabular-nums tracking-tight">{{ $kyluat->ngayvipham }}</td>
                                                    <td class="px-6 py-4">
                                                        <span class="inline-flex items-center rounded-lg px-2 py-0.5 text-[8px] font-black uppercase tracking-widest bg-rose-50 text-rose-600 ring-1 ring-rose-100">
                                                            {{ $kyluat->mucdo->label() }}
                                                        </span>
                                                    </td>
                                                    <td class="px-6 py-4 text-[11px] text-ink-secondary font-medium leading-relaxed">
                                                        {{ $kyluat->noidung }}
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="3" class="px-6 py-20 text-center">
                                                        <p class="text-[9px] font-black text-ink-secondary/20 uppercase tracking-widest">Chưa có vi phạm nào</p>
                                                    </td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>

                                {{-- Evaluation Tab --}}
                                <div x-show="activeTab === 'evaluations'" class="animate-fade-in">
                                    <table class="w-full text-left">
                                        <thead class="bg-ui-bg/50 border-b border-ui-border">
                                            <tr>
                                                <th class="px-6 py-4 text-[9px] font-black text-ink-secondary uppercase tracking-widest">Ngày</th>
                                                <th class="px-6 py-4 text-[9px] font-black text-ink-secondary uppercase tracking-widest">Điểm</th>
                                                <th class="px-6 py-4 text-[9px] font-black text-ink-secondary uppercase tracking-widest">Nội dung</th>
                                            </tr>
                                        </thead>
                                        <tbody class="divide-y divide-ui-border">
                                            @forelse($sinhvien->danhgias as $danhgia)
                                                <tr class="hover:bg-ui-bg/20 transition-colors">
                                                    <td class="px-6 py-4 text-xs font-black text-ink-primary tabular-nums tracking-tight">{{ $danhgia->ngaydanhgia }}</td>
                                                    <td class="px-6 py-4">
                                                        <div class="flex items-center gap-0.5 text-status-success">
                                                            @for($i = 1; $i <= 5; $i++)
                                                                <svg class="h-3 w-3 {{ $i <= $danhgia->diem ? 'fill-current' : 'text-ui-border' }}" viewBox="0 0 20 20" fill="currentColor">
                                                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                                                </svg>
                                                            @endfor
                                                        </div>
                                                    </td>
                                                    <td class="px-6 py-4 text-[11px] text-ink-secondary font-medium leading-relaxed">
                                                        {{ $danhgia->noidung }}
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="3" class="px-6 py-20 text-center">
                                                        <p class="text-[9px] font-black text-ink-secondary/20 uppercase tracking-widest">Chưa có đánh giá nào</p>
                                                    </td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>

                                {{-- Bills Tab --}}
                                <div x-show="activeTab === 'bills'" class="animate-fade-in">
                                    <table class="w-full text-left">
                                        <thead class="bg-ui-bg/50 border-b border-ui-border">
                                            <tr>
                                                <th class="px-6 py-4 text-[9px] font-black text-ink-secondary uppercase tracking-widest">Kỳ hóa đơn</th>
                                                <th class="px-6 py-4 text-[9px] font-black text-ink-secondary uppercase tracking-widest">Số tiền</th>
                                                <th class="px-6 py-4 text-[9px] font-black text-ink-secondary uppercase tracking-widest">Trạng thái</th>
                                            </tr>
                                        </thead>
                                        <tbody class="divide-y divide-ui-border">
                                            @forelse($hoadons as $hoadon)
                                                <tr class="hover:bg-ui-bg/20 transition-colors">
                                                    <td class="px-6 py-4 text-xs font-black text-ink-primary uppercase tracking-tight">Kỳ T{{ $hoadon->thang }}/{{ $hoadon->nam }}</td>
                                                    <td class="px-6 py-4 text-xs font-black text-ink-primary tabular-nums tracking-tight">{{ number_format($hoadon->tongtien) }}đ</td>
                                                    <td class="px-6 py-4">
                                                        <span @class([
                                                            'inline-flex items-center rounded-lg px-2 py-0.5 text-[8px] font-black uppercase tracking-widest ring-1',
                                                            'bg-status-success/10 text-status-success ring-status-success/20' => $hoadon->trang_thai === \App\Enums\InvoiceStatus::Paid,
                                                            'bg-status-warning/10 text-status-warning ring-status-warning/20' => $hoadon->trang_thai === \App\Enums\InvoiceStatus::Unpaid,
                                                            'bg-status-error/10 text-status-error ring-status-error/20' => $hoadon->trang_thai === \App\Enums\InvoiceStatus::Overdue,
                                                        ])>
                                                            {{ $hoadon->trang_thai->label() }}
                                                        </span>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="3" class="px-6 py-20 text-center">
                                                        <p class="text-[9px] font-black text-ink-secondary/20 uppercase tracking-widest">Không có lịch sử hóa đơn</p>
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
                <article class="rounded-3xl border border-ui-border bg-ui-card/50 backdrop-blur-xl p-8 shadow-sm transition-all hover:border-brand-emerald/20">
                    @include('profile.partials.update-password-form')
                </article>
            </div>

            {{-- Sidebar Column --}}
            <aside class="lg:col-span-4 space-y-8">
                {{-- Residence Summary (New) --}}
                @if($user->sinhvien && $user->sinhvien->phong)
                    <article class="rounded-3xl border border-ui-border bg-white p-8 shadow-sm relative overflow-hidden group">
                        <div class="absolute -right-12 -top-12 h-32 w-32 rounded-full bg-brand-emerald/5 transition-transform duration-700 group-hover:scale-150"></div>
                        <h3 class="text-[10px] font-black uppercase tracking-[0.2em] text-ink-secondary/40 mb-6">Định danh lưu trú</h3>
                        
                        <div class="flex items-center gap-5 mb-8">
                            <div class="h-16 w-16 overflow-hidden rounded-2xl bg-ui-bg ring-1 ring-ui-border shadow-sm">
                                @php $latestDangky = $user->sinhvien->dangkys->first(); @endphp
                                @if($latestDangky && $latestDangky->anh_the_path)
                                    <img src="{{ asset('storage/' . $latestDangky->anh_the_path) }}" class="h-full w-full object-cover" />
                                @else
                                    <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=f8f9fa&color=0f172a&bold=true" class="h-full w-full object-cover" />
                                @endif
                            </div>
                            <div>
                                <div class="text-sm font-black text-ink-primary uppercase tracking-tight">{{ $user->sinhvien->phong->tenphong }}</div>
                                <div class="text-[10px] font-bold text-ink-secondary/60 uppercase tracking-widest mt-1">Giường số {{ $user->sinhvien->giuong_no ?? 'N/A' }}</div>
                            </div>
                        </div>

                        <div class="space-y-4 pt-6 border-t border-ui-border">
                            <div class="flex items-center justify-between">
                                <span class="text-[10px] font-bold text-ink-secondary uppercase tracking-widest">MSSV</span>
                                <span class="text-xs font-black text-ink-primary tabular-nums">{{ $user->sinhvien->masinhvien }}</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-[10px] font-bold text-ink-secondary uppercase tracking-widest">Hợp đồng</span>
                                <span class="rounded-full bg-brand-emerald/10 px-2 py-0.5 text-[8px] font-black uppercase text-brand-emerald ring-1 ring-inset ring-brand-emerald/20">
                                    {{ $user->sinhvien->hopdongs->where('trang_thai', \App\Enums\ContractStatus::Active)->first() ? 'Còn hiệu lực' : 'N/A' }}
                                </span>
                            </div>
                        </div>
                    </article>
                @endif

                {{-- Status Card --}}
                <article class="rounded-3xl border border-ui-border bg-white p-6 shadow-sm overflow-hidden relative group">
                    <div class="absolute -right-4 -top-4 h-24 w-24 rounded-full bg-brand-emerald/5 blur-2xl group-hover:scale-150 transition-transform duration-700"></div>
                    <div class="relative">
                        <div class="flex items-center gap-3 mb-4">
                            <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-brand-50 text-brand-emerald">
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                            </div>
                            <h3 class="text-[11px] font-black uppercase tracking-[0.2em] text-ink-primary">Trạng thái hồ sơ</h3>
                        </div>
                        <div class="space-y-4">
                            <div class="flex items-center justify-between">
                                <span class="text-xs font-medium text-ink-secondary">Xác minh danh tính</span>
                                <span class="rounded-full bg-emerald-50 px-2 py-0.5 text-[8px] font-black uppercase text-emerald-600 ring-1 ring-inset ring-emerald-500/20">Đã xác minh</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-xs font-medium text-ink-secondary">Bảo mật 2 lớp</span>
                                <span class="text-[10px] font-bold text-ink-secondary/40 italic">Chưa kích hoạt</span>
                            </div>
                        </div>
                    </div>
                </article>

                {{-- Support Card --}}
                <article class="rounded-3xl bg-ink-primary p-8 text-white shadow-xl shadow-slate-900/10 relative overflow-hidden group">
                    <div class="absolute -right-8 -bottom-8 h-32 w-32 rounded-full bg-white/5 blur-2xl group-hover:scale-150 transition-transform duration-700"></div>
                    <div class="relative">
                        <div class="h-12 w-12 flex items-center justify-center rounded-2xl bg-white/10 mb-6">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <h4 class="font-display text-lg font-black uppercase tracking-tight mb-2">Hỗ trợ hồ sơ?</h4>
                        <p class="text-xs font-medium leading-relaxed text-white/60">Nếu bạn không thể cập nhật MSSV hoặc Giới tính, vui lòng liên hệ Ban quản lý KTX để được hỗ trợ xác minh trực tiếp.</p>
                    </div>
                </article>

                {{-- Delete Account Section --}}
                <article class="rounded-3xl border border-rose-100 bg-rose-50/20 p-8 shadow-sm">
                    @include('profile.partials.delete-user-form')
                </article>
            </aside>
        </div>
    </div>
</x-dynamic-component>
