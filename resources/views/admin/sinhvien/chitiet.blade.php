@extends('layouts.admin')

@section('title', 'Chi tiết Sinh viên: ' . $sinhvien->taikhoan?->name)

@section('content')
<div class="space-y-8 animate-fade-in pb-20">
    {{-- Header Section --}}
    <div class="flex flex-col gap-6 md:flex-row md:items-center md:justify-between">
        <div class="flex items-center gap-4">
            <a href="{{ route('admin.quanlysinhvien') }}" class="group flex h-10 w-10 items-center justify-center rounded-xl bg-white shadow-sm ring-1 ring-ui-border transition-all hover:ring-brand-emerald/30">
                <svg class="h-5 w-5 text-ink-secondary group-hover:text-brand-emerald" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"/></svg>
            </a>
            <div>
                <h1 class="font-display text-3xl font-black text-ink-primary uppercase tracking-tight">Hồ sơ cư dân</h1>
                <p class="text-xs font-bold text-ink-secondary/40 uppercase tracking-widest mt-1">Quản lý thông tin & lịch sử sinh viên</p>
            </div>
        </div>
        
        <div class="flex items-center gap-3">
            <button type="button" class="pdu-btn-ghost !min-h-[44px]">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                In hồ sơ
            </button>
            <button type="button" data-modal-target="modal-edit-{{ $sinhvien->id }}" data-modal-toggle="modal-edit-{{ $sinhvien->id }}" class="pdu-btn-primary !min-h-[44px]">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                Chỉnh sửa
            </button>
        </div>
    </div>

    {{-- Main Profile Card --}}
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        {{-- Left Column: Avatar & Basic Info --}}
        <div class="lg:col-span-4 space-y-8">
            <div class="bg-white rounded-3xl p-8 shadow-sm ring-1 ring-ui-border text-center">
                <div class="relative inline-block mb-6">
                    <div class="h-32 w-32 overflow-hidden rounded-3xl bg-ui-bg ring-4 ring-white shadow-xl">
                        <img src="https://ui-avatars.com/api/?name={{ urlencode($sinhvien->taikhoan?->name) }}&background=f8f9fa&color=0f172a&bold=true&size=256" alt="Avatar" class="h-full w-full object-cover">
                    </div>
                    <div class="absolute -bottom-2 -right-2 h-10 w-10 flex items-center justify-center rounded-2xl bg-brand-emerald text-white shadow-lg ring-4 ring-white">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                </div>
                
                <h2 class="font-display text-2xl font-black text-ink-primary uppercase tracking-tight">{{ $sinhvien->taikhoan?->name }}</h2>
                <p class="text-sm font-bold text-brand-emerald uppercase tracking-widest mt-1">{{ $sinhvien->masinhvien }}</p>
                
                <div class="mt-8 flex flex-wrap justify-center gap-2">
                    <span class="inline-flex items-center rounded-full bg-ui-bg px-3 py-1 text-[10px] font-black uppercase tracking-widest text-ink-secondary ring-1 ring-ui-border">
                        {{ $sinhvien->lop }}
                    </span>
                    <span class="inline-flex items-center rounded-full bg-ui-bg px-3 py-1 text-[10px] font-black uppercase tracking-widest text-ink-secondary ring-1 ring-ui-border">
                        Khóa {{ substr($sinhvien->masinhvien, 0, 2) }}
                    </span>
                </div>

                <div class="mt-8 grid grid-cols-2 gap-4 border-t border-ui-border pt-8">
                    <div>
                        <div class="text-[10px] font-bold text-ink-secondary/40 uppercase tracking-widest mb-1">Giới tính</div>
                        <div class="text-sm font-black text-ink-primary">{{ $sinhvien->gioitinh }}</div>
                    </div>
                    <div>
                        <div class="text-[10px] font-bold text-ink-secondary/40 uppercase tracking-widest mb-1">Dân tộc</div>
                        <div class="text-sm font-black text-ink-primary">Kinh</div>
                    </div>
                    <div class="col-span-2 border-t border-ui-border pt-4 mt-2">
                        <div class="text-[10px] font-bold text-ink-secondary/40 uppercase tracking-widest mb-1">Số định danh (CCCD)</div>
                        <div class="text-sm font-black text-ink-primary tabular-nums">{{ $sinhvien->so_cccd }}</div>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-3xl p-8 shadow-sm ring-1 ring-ui-border">
                <h3 class="text-[10px] font-black text-ink-primary uppercase tracking-[0.2em] mb-6">Tài liệu định danh</h3>
                <div class="grid grid-cols-2 gap-4">
                    @php
                        $latestDangky = $sinhvien->dangkys->first();
                    @endphp
                    <div class="space-y-2">
                        <div class="text-[8px] font-black text-ink-secondary/40 uppercase tracking-widest">Ảnh thẻ 3x4</div>
                        <div class="aspect-[3/4] overflow-hidden rounded-xl bg-ui-bg border border-ui-border group relative">
                            @if($latestDangky && $latestDangky->anh_the_path)
                                <img src="{{ asset('storage/' . $latestDangky->anh_the_path) }}" class="h-full w-full object-cover transition-transform group-hover:scale-110" />
                            @else
                                <div class="flex h-full w-full items-center justify-center text-[10px] font-bold text-ink-secondary/20 uppercase italic">N/A</div>
                            @endif
                        </div>
                    </div>
                    <div class="space-y-2">
                        <div class="text-[8px] font-black text-ink-secondary/40 uppercase tracking-widest">Mặt trước CCCD</div>
                        <div class="aspect-[1.6/1] overflow-hidden rounded-xl bg-ui-bg border border-ui-border group relative">
                            @if($latestDangky && $latestDangky->anh_cccd_path)
                                <img src="{{ asset('storage/' . $latestDangky->anh_cccd_path) }}" class="h-full w-full object-cover transition-transform group-hover:scale-110" />
                            @else
                                <div class="flex h-full w-full items-center justify-center text-[10px] font-bold text-ink-secondary/20 uppercase italic">N/A</div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-3xl p-8 shadow-sm ring-1 ring-ui-border">
                <h3 class="text-[10px] font-black text-ink-primary uppercase tracking-[0.2em] mb-6">Thông tin cư trú</h3>
                <div class="space-y-6">
                    <div class="flex items-start gap-4">
                        <div class="h-10 w-10 flex flex-shrink-0 items-center justify-center rounded-xl bg-ui-bg text-ink-secondary/60 ring-1 ring-ui-border">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                        </div>
                        <div>
                            <div class="text-[10px] font-bold text-ink-secondary/40 uppercase tracking-widest">Phòng hiện tại</div>
                            @if($sinhvien->phong)
                                <div class="text-sm font-black text-ink-primary uppercase">{{ $sinhvien->phong->tenphong }}</div>
                                <div class="text-[10px] font-bold text-ink-secondary mt-0.5">{{ $sinhvien->phong->toanha?->ten_toan_ha }}</div>
                            @else
                                <div class="text-sm font-black text-ink-secondary/30 uppercase italic">Chưa xếp phòng</div>
                            @endif
                        </div>
                    </div>

                    <div class="flex items-start gap-4">
                        <div class="h-10 w-10 flex flex-shrink-0 items-center justify-center rounded-xl bg-ui-bg text-ink-secondary/60 ring-1 ring-ui-border">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <div>
                            <div class="text-[10px] font-bold text-ink-secondary/40 uppercase tracking-widest">Ngày nhập phòng</div>
                            <div class="text-sm font-black text-ink-primary tabular-nums tracking-tight">
                                {{ $sinhvien->hopdongs->where('trang_thai', \App\Enums\ContractStatus::Active)->first()?->ngay_bat_dau ?? 'N/A' }}
                            </div>
                        </div>
                    </div>

                    <div class="flex items-start gap-4 pt-4 border-t border-ui-border/50">
                        <div class="h-10 w-10 flex flex-shrink-0 items-center justify-center rounded-xl bg-status-error/5 text-status-error/40 ring-1 ring-status-error/10">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                        </div>
                        <div>
                            <div class="text-[10px] font-bold text-status-error/40 uppercase tracking-widest">Liên hệ khẩn cấp</div>
                            <div class="text-sm font-black text-ink-primary">Chưa cập nhật</div>
                            <div class="text-[9px] font-bold text-ink-secondary/30 mt-0.5 italic">Cần bổ sung thông tin người thân</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Right Column: Detailed Info & History --}}
        <div class="lg:col-span-8 space-y-8">
            {{-- Tabs / Stats --}}
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <div class="bg-white rounded-2xl p-5 shadow-sm ring-1 ring-ui-border">
                    <div class="text-[10px] font-bold text-ink-secondary/40 uppercase tracking-widest mb-2">Hợp đồng</div>
                    <div class="text-2xl font-display font-black text-ink-primary tabular-nums">{{ $sinhvien->hopdongs->count() }}</div>
                </div>
                <div class="bg-white rounded-2xl p-5 shadow-sm ring-1 ring-ui-border">
                    <div class="text-[10px] font-bold text-ink-secondary/40 uppercase tracking-widest mb-2 text-status-error">Kỷ luật</div>
                    <div class="text-2xl font-display font-black text-status-error tabular-nums">{{ $sinhvien->kyluats->count() }}</div>
                </div>
                <div class="bg-white rounded-2xl p-5 shadow-sm ring-1 ring-ui-border">
                    <div class="text-[10px] font-bold text-ink-secondary/40 uppercase tracking-widest mb-2 text-status-success">Đánh giá</div>
                    <div class="text-2xl font-display font-black text-status-success tabular-nums">{{ $sinhvien->danhgias->count() }}</div>
                </div>
                <div class="bg-white rounded-2xl p-5 shadow-sm ring-1 ring-ui-border">
                    <div class="text-[10px] font-bold text-ink-secondary/40 uppercase tracking-widest mb-2 text-brand-emerald">Hóa đơn</div>
                    <div class="text-2xl font-display font-black text-brand-emerald tabular-nums">{{ $hoadons->count() }}</div>
                </div>
            </div>

            {{-- Information Sections --}}
            <div class="bg-white rounded-3xl shadow-sm ring-1 ring-ui-border overflow-hidden">
                <div class="border-b border-ui-border px-8 py-6">
                    <h3 class="text-sm font-black text-ink-primary uppercase tracking-widest">Thông tin chi tiết</h3>
                </div>
                <div class="p-8">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-x-12 gap-y-8">
                        <div class="space-y-1">
                            <label class="text-[10px] font-bold text-ink-secondary/40 uppercase tracking-widest">Email học thuật</label>
                            <div class="text-sm font-bold text-ink-primary break-all">{{ $sinhvien->taikhoan?->email }}</div>
                        </div>
                        <div class="space-y-1">
                            <label class="text-[10px] font-bold text-ink-secondary/40 uppercase tracking-widest">Số điện thoại</label>
                            <div class="text-sm font-bold text-ink-primary tabular-nums tracking-tight">{{ $sinhvien->sodienthoai }}</div>
                        </div>
                        <div class="space-y-1">
                            <label class="text-[10px] font-bold text-ink-secondary/40 uppercase tracking-widest">Ngày sinh</label>
                            <div class="text-sm font-bold text-ink-primary tabular-nums tracking-tight">{{ $sinhvien->ngaysinh }}</div>
                        </div>
                        <div class="space-y-1">
                            <label class="text-[10px] font-bold text-ink-secondary/40 uppercase tracking-widest">Địa chỉ liên hệ</label>
                            <div class="text-sm font-bold text-ink-primary">{{ $sinhvien->diachi }}</div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- History Sections --}}
            <div x-data="{ activeTab: 'contracts' }" class="space-y-4">
                <div class="flex items-center gap-1 bg-ui-bg p-1 rounded-2xl ring-1 ring-ui-border w-fit">
                    <button @click="activeTab = 'contracts'" :class="activeTab === 'contracts' ? 'bg-white text-ink-primary shadow-sm ring-1 ring-ui-border' : 'text-ink-secondary hover:text-ink-primary'" class="px-5 py-2 rounded-xl text-xs font-black uppercase tracking-widest transition-all">Hợp đồng</button>
                    <button @click="activeTab = 'discipline'" :class="activeTab === 'discipline' ? 'bg-white text-status-error shadow-sm ring-1 ring-ui-border' : 'text-ink-secondary hover:text-ink-primary'" class="px-5 py-2 rounded-xl text-xs font-black uppercase tracking-widest transition-all">Kỷ luật</button>
                    <button @click="activeTab = 'evaluations'" :class="activeTab === 'evaluations' ? 'bg-white text-status-success shadow-sm ring-1 ring-ui-border' : 'text-ink-secondary hover:text-ink-primary'" class="px-5 py-2 rounded-xl text-xs font-black uppercase tracking-widest transition-all">Đánh giá</button>
                    <button @click="activeTab = 'bills'" :class="activeTab === 'bills' ? 'bg-white text-brand-emerald shadow-sm ring-1 ring-ui-border' : 'text-ink-secondary hover:text-ink-primary'" class="px-5 py-2 rounded-xl text-xs font-black uppercase tracking-widest transition-all">Hóa đơn</button>
                </div>

                <div class="bg-white rounded-3xl shadow-sm ring-1 ring-ui-border overflow-hidden min-h-[400px]">
                    {{-- Contracts Tab --}}
                    <div x-show="activeTab === 'contracts'" class="animate-fade-in">
                        <table class="w-full text-left">
                            <thead class="bg-ui-bg/50 border-b border-ui-border">
                                <tr>
                                    <th class="px-8 py-4 text-[10px] font-black text-ink-secondary uppercase tracking-widest">Mã HD</th>
                                    <th class="px-8 py-4 text-[10px] font-black text-ink-secondary uppercase tracking-widest">Phòng</th>
                                    <th class="px-8 py-4 text-[10px] font-black text-ink-secondary uppercase tracking-widest">Thời hạn</th>
                                    <th class="px-8 py-4 text-[10px] font-black text-ink-secondary uppercase tracking-widest">Trạng thái</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-ui-border">
                                @forelse($sinhvien->hopdongs as $hopdong)
                                    <tr class="hover:bg-ui-bg/20 transition-colors">
                                        <td class="px-8 py-5 text-sm font-black text-ink-primary tabular-nums tracking-tight">#{{ $hopdong->id }}</td>
                                        <td class="px-8 py-5 text-sm font-bold text-ink-primary">{{ $hopdong->phong?->tenphong }}</td>
                                        <td class="px-8 py-5">
                                            <div class="flex items-center gap-2 text-[11px] font-bold tabular-nums tracking-tight">
                                                <span class="text-ink-secondary">{{ $hopdong->ngay_bat_dau }}</span>
                                                <svg class="h-3 w-3 text-ink-secondary/20" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                                                <span class="text-brand-emerald">{{ $hopdong->ngay_ket_thuc }}</span>
                                            </div>
                                        </td>
                                        <td class="px-8 py-5">
                                            <span @class([
                                                'inline-flex items-center rounded-lg px-2.5 py-1 text-[9px] font-black uppercase tracking-widest ring-1',
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
                                        <td colspan="4" class="px-8 py-20 text-center">
                                            <p class="text-[10px] font-black text-ink-secondary/20 uppercase tracking-widest">Không có dữ liệu hợp đồng</p>
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
                                    <th class="px-8 py-4 text-[10px] font-black text-ink-secondary uppercase tracking-widest">Ngày vi phạm</th>
                                    <th class="px-8 py-4 text-[10px] font-black text-ink-secondary uppercase tracking-widest">Mức độ</th>
                                    <th class="px-8 py-4 text-[10px] font-black text-ink-secondary uppercase tracking-widest">Nội dung</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-ui-border">
                                @forelse($sinhvien->kyluats as $kyluat)
                                    <tr class="hover:bg-ui-bg/20 transition-colors">
                                        <td class="px-8 py-5 text-sm font-black text-ink-primary tabular-nums tracking-tight">{{ $kyluat->ngayvipham }}</td>
                                        <td class="px-8 py-5">
                                            <span class="inline-flex items-center rounded-lg px-2.5 py-1 text-[9px] font-black uppercase tracking-widest bg-rose-50 text-rose-600 ring-1 ring-rose-100">
                                                {{ $kyluat->mucdo->label() }}
                                            </span>
                                        </td>
                                        <td class="px-8 py-5 text-xs text-ink-secondary font-medium leading-relaxed max-w-xs">
                                            {{ $kyluat->noidung }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="px-8 py-20 text-center">
                                            <p class="text-[10px] font-black text-ink-secondary/20 uppercase tracking-widest">Chưa có vi phạm nào</p>
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
                                    <th class="px-8 py-4 text-[10px] font-black text-ink-secondary uppercase tracking-widest">Kỳ hóa đơn</th>
                                    <th class="px-8 py-4 text-[10px] font-black text-ink-secondary uppercase tracking-widest">Số tiền</th>
                                    <th class="px-8 py-4 text-[10px] font-black text-ink-secondary uppercase tracking-widest">Trạng thái</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-ui-border">
                                @forelse($hoadons as $hoadon)
                                    <tr class="hover:bg-ui-bg/20 transition-colors">
                                        <td class="px-8 py-5 text-sm font-black text-ink-primary uppercase tracking-tight">Kỳ T{{ $hoadon->thang }}/{{ $hoadon->nam }}</td>
                                        <td class="px-8 py-5 text-sm font-black text-ink-primary tabular-nums tracking-tight">{{ number_format($hoadon->tongtien) }}đ</td>
                                        <td class="px-8 py-5">
                                            <span @class([
                                                'inline-flex items-center rounded-lg px-2.5 py-1 text-[9px] font-black uppercase tracking-widest ring-1',
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
                                        <td colspan="3" class="px-8 py-20 text-center">
                                            <p class="text-[10px] font-black text-ink-secondary/20 uppercase tracking-widest">Không có lịch sử hóa đơn</p>
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
                                    <th class="px-8 py-4 text-[10px] font-black text-ink-secondary uppercase tracking-widest">Ngày đánh giá</th>
                                    <th class="px-8 py-4 text-[10px] font-black text-ink-secondary uppercase tracking-widest">Điểm</th>
                                    <th class="px-8 py-4 text-[10px] font-black text-ink-secondary uppercase tracking-widest">Nội dung</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-ui-border">
                                @forelse($sinhvien->danhgias as $danhgia)
                                    <tr class="hover:bg-ui-bg/20 transition-colors">
                                        <td class="px-8 py-5 text-sm font-black text-ink-primary tabular-nums tracking-tight">{{ $danhgia->ngaydanhgia }}</td>
                                        <td class="px-8 py-5">
                                            <div class="flex items-center gap-0.5 text-status-success">
                                                @for($i = 1; $i <= 5; $i++)
                                                    <svg class="h-3 w-3 {{ $i <= $danhgia->diem ? 'fill-current' : 'text-ui-border' }}" viewBox="0 0 20 20" fill="currentColor">
                                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                                    </svg>
                                                @endfor
                                            </div>
                                        </td>
                                        <td class="px-8 py-5 text-xs text-ink-secondary font-medium leading-relaxed">
                                            {{ $danhgia->noidung }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="px-8 py-20 text-center">
                                            <p class="text-[10px] font-black text-ink-secondary/20 uppercase tracking-widest">Chưa có đánh giá nào</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Modals --}}
@include('admin.sinhvien.partials.modal-edit')

@endsection
