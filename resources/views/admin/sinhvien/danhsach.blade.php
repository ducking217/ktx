<x-admin-layout>
    <x-slot:title>Quản lý Hồ sơ Sinh viên Nội trú</x-slot:title>

    <div class="space-y-8">
        <x-admin.page-header
            title="Cơ sở dữ liệu cư dân"
            subtitle="Quản lý định danh, hồ sơ nhân khẩu và lịch sử cư trú sinh viên."
        />

        {{-- Filter Bar --}}
        <div class="saas-card p-6 bg-slate-50/50 border-dashed">
            <form action="{{ route('admin.quanlysinhvien') }}" method="GET" class="flex flex-wrap items-end gap-6">
                <div class="flex-1 min-w-[300px]">
                    <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-2 ml-1">Tìm kiếm sinh viên</label>
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-4 flex items-center text-slate-400 group-focus-within:text-blue-500 transition-colors pointer-events-none">
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="m21 21-4.35-4.35M10.5 18a7.5 7.5 0 1 1 0-15 7.5 7.5 0 0 1 0 15z" /></svg>
                        </div>
                        <input type="text" name="q" value="{{ request('q') }}" placeholder="Mã sinh viên hoặc họ tên..." class="saas-input pl-12 h-11">
                    </div>
                </div>
                <div class="flex items-end gap-3">
                    <button type="submit" class="saas-btn-primary h-11 px-6">Tìm kiếm</button>
                    @if(request('q'))
                        <a href="{{ route('admin.quanlysinhvien') }}" class="saas-btn-secondary h-11 px-5">Xóa lọc</a>
                    @endif
                </div>
            </form>
        </div>

        <x-admin.table-card>
            <thead>
                <tr>
                    <th>Sinh viên</th>
                    <th>Lớp học</th>
                    <th>Phòng hiện tại</th>
                    <th>Liên hệ</th>
                    <th>Ngày tạo hồ sơ</th>
                    <th class="text-right">Hành động</th>
                </tr>
            </thead>
            <tbody>
                @forelse($danhsachsinhvien as $sinhvien)
                    <tr class="hover:bg-slate-50/50 transition-colors group">
                        <td class="py-5">
                            <div class="flex items-center gap-4">
                                <div class="h-10 w-10 rounded-xl bg-slate-100 border border-slate-200 flex items-center justify-center flex-shrink-0">
                                    <span class="text-xs font-bold text-slate-500 uppercase tabular-nums">{{ mb_substr($sinhvien->taikhoan?->name ?? 'N', 0, 2) }}</span>
                                </div>
                                <div>
                                    <div class="text-sm font-bold text-slate-900 leading-tight group-hover:text-blue-600 transition-colors">{{ $sinhvien->taikhoan?->name ?? 'N/A' }}</div>
                                    <div class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-1.5 tabular-nums">
                                        MSSV: {{ $sinhvien->ma_sinh_vien }}
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td class="py-5">
                            <div class="text-xs font-bold text-slate-700 tracking-tight uppercase">{{ $sinhvien->lop }}</div>
                        </td>
                        <td class="py-5">
                            @if($sinhvien->phong_hien_tai())
                                <div class="inline-flex items-center gap-2 font-bold text-slate-900 text-sm">
                                    <div class="h-7 w-7 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center border border-blue-100 shadow-sm flex-shrink-0">
                                        <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1-1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                                    </div>
                                    {{ $sinhvien->phong_hien_tai()->ten_phong }}
                                </div>
                            @else
                                <span class="inline-flex items-center gap-1.5 text-[10px] font-bold text-slate-400 uppercase tracking-wider">
                                    <span class="h-1.5 w-1.5 rounded-full bg-slate-300"></span>
                                    Chưa xếp phòng
                                </span>
                            @endif
                        </td>
                        <td class="py-5">
                            <div class="text-xs font-bold text-slate-900 tabular-nums">{{ $sinhvien->user?->phone ?? 'N/A' }}</div>
                            <div class="text-[10px] text-slate-400 font-medium mt-1 lowercase">{{ $sinhvien->user?->email ?? 'N/A' }}</div>
                        </td>
                        <td class="py-5">
                            <div class="text-xs font-bold text-slate-900 tabular-nums">{{ $sinhvien->created_at->format('d/m/Y') }}</div>
                        </td>
                        <td class="py-5 text-right">
                            <div class="flex items-center justify-end gap-1">
                                <a href="{{ route('admin.sinhvien.chitiet', $sinhvien->id) }}" class="h-9 w-9 inline-flex items-center justify-center text-slate-400 hover:text-blue-600 hover:bg-blue-50 border border-transparent hover:border-blue-100 rounded-xl transition-all shadow-sm hover:shadow-md" title="Xem hồ sơ">
                                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                </a>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="py-24 text-center">
                            <div class="flex flex-col items-center gap-4 text-slate-200">
                                <svg class="h-14 w-14" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                                <p class="text-sm font-bold text-slate-400 uppercase tracking-widest">Không có dữ liệu sinh viên phù hợp</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </x-admin.table-card>

        @if(method_exists($danhsachsinhvien, 'links'))
            <div class="mt-8">
                {{ $danhsachsinhvien->withQueryString()->links() }}
            </div>
        @endif
    </div>
</x-admin-layout>
