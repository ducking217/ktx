<x-admin-layout>
    <x-slot:title>Điều phối Báo hỏng & Bảo trì</x-slot:title>

    <div class="space-y-8 pb-20">
        @php
            $filters = [
                '' => 'Tất cả báo cáo',
                \App\Enums\BaohongStatus::Pending->value => \App\Enums\BaohongStatus::Pending->label(),
                \App\Enums\BaohongStatus::Processing->value => \App\Enums\BaohongStatus::Processing->label(),
                \App\Enums\BaohongStatus::Done->value => \App\Enums\BaohongStatus::Done->label(),
                \App\Enums\BaohongStatus::Rejected->value => \App\Enums\BaohongStatus::Rejected->label(),
            ];
        @endphp

        <x-admin.page-header
            title="Hệ thống báo hỏng"
            subtitle="Giám sát luồng thông tin sự cố, điều phối nhân lực và kiểm soát chất lượng bảo trì hạ tầng."
        >
            <x-admin.status-tabs
                :items="$filters"
                :active="$status ?? ''"
                route="admin.quanlybaohong"
                param="status"
                defaultValue=""
            />
        </x-admin.page-header>

        <x-admin.table-card>
            <thead>
                <tr>
                    <th>Sinh viên báo cáo</th>
                    <th>Vị trí sự cố</th>
                    <th>Nội dung mô tả</th>
                    <th>Hình ảnh</th>
                    <th class="text-center">Trạng thái</th>
                    <th class="text-right">Xử lý</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($danhsachbaohong as $baohong)
                    <tr class="hover:bg-slate-50/50 transition-colors group">
                        <td class="py-5">
                            <div class="text-sm font-bold text-slate-900 leading-tight group-hover:text-blue-600 transition-colors">{{ $baohong->sinhvien?->user?->name ?? 'N/A' }}</div>
                            <div class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-1.5 tabular-nums">MSSV: {{ $baohong->sinhvien?->ma_sinh_vien ?? 'N/A' }}</div>
                        </td>
                        <td class="py-5">
                            <div class="inline-flex items-center gap-2 text-sm font-bold text-slate-900">
                                <span class="h-1.5 w-1.5 rounded-full bg-blue-500 flex-shrink-0"></span>
                                {{ $baohong->phong?->ten_phong ?? 'Chưa xác định' }}
                            </div>
                        </td>
                        <td class="py-5 max-w-sm">
                            <div class="text-xs font-medium leading-relaxed text-slate-600 border-l-2 border-slate-100 pl-3 py-0.5 line-clamp-3">
                                {{ $baohong->mo_ta }}
                            </div>
                        </td>
                        <td class="py-5">
                            @if ($baohong->hinh_anh_path)
                                <a href="{{ asset($baohong->hinh_anh_path) }}" target="_blank" rel="noopener" class="h-9 px-3 inline-flex items-center gap-2 text-[10px] font-bold uppercase tracking-widest text-slate-500 bg-slate-50 border border-slate-200/60 rounded-xl hover:bg-slate-900 hover:text-white hover:border-slate-900 transition-all shadow-sm" title="Xem hình ảnh">
                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                    Xem ảnh
                                </a>
                            @else
                                <span class="text-[10px] font-bold text-slate-300 uppercase tracking-widest">Không có ảnh</span>
                            @endif
                        </td>
                        <td class="py-5 text-center">
                            @php
                                $status = $baohong->trang_thai;
                                $statusClass = match ($status) {
                                    \App\Enums\BaohongStatus::Done => 'saas-badge-success',
                                    \App\Enums\BaohongStatus::Pending => 'saas-badge-warning',
                                    \App\Enums\BaohongStatus::Processing => 'saas-badge-info',
                                    \App\Enums\BaohongStatus::Rejected => 'saas-badge-error',
                                    default => 'saas-badge-info',
                                };
                            @endphp
                            <span class="saas-badge {{ $statusClass }}">
                                {{ $status?->label() ?? 'N/A' }}
                            </span>
                        </td>
                        <td class="py-5 text-right">
                            <form method="POST" action="{{ route('admin.capnhatbaohong', ['id' => $baohong->id]) }}" class="inline-flex items-center gap-2 p-1.5 rounded-xl bg-white border border-slate-200 shadow-sm transition-all">
                                @csrf
                                <select name="trang_thai" class="bg-transparent border-none text-[10px] font-bold uppercase tracking-wider text-slate-700 focus:ring-0 cursor-pointer min-w-[100px] py-1">
                                    @foreach(\App\Enums\BaohongStatus::cases() as $ms)
                                        <option value="{{ $ms->value }}" {{ $baohong->trang_thai === $ms ? 'selected' : '' }}>{{ $ms->label() }}</option>
                                    @endforeach
                                </select>
                                <button type="submit" class="h-9 w-9 flex items-center justify-center text-slate-400 hover:text-blue-600 hover:bg-blue-50 border border-transparent hover:border-blue-100 rounded-xl transition-all shadow-sm hover:shadow-md" title="Lưu trạng thái">
                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="py-24 text-center">
                            <div class="flex flex-col items-center gap-4 text-slate-200">
                                <svg class="h-14 w-14" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                <p class="text-sm font-bold text-slate-400 uppercase tracking-widest">Không có báo cáo sự cố nào</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </x-admin.table-card>

        @if(method_exists($danhsachbaohong, 'links'))
            <div class="mt-8">
                {{ $danhsachbaohong->appends(request()->query())->links() }}
            </div>
        @endif
    </div>
</x-admin-layout>
