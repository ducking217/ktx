<x-admin-layout>
    <x-slot:title>Kiến trúc Nhập Chỉ số Hạ tầng Định kỳ</x-slot:title>

    <div class="space-y-10 pb-20">
        <x-admin.page-header
            title="Nhập chỉ số điện nước (hàng loạt)"
            subtitle="Hệ thống kê khai chỉ số hạ tầng tập trung, tối ưu hóa quy trình kết xuất hóa đơn đa điểm cho toàn thể đơn vị cư trú."
        >
            <a href="{{ route('admin.hoadon.index') }}" class="saas-btn-secondary h-12 px-6 text-[10px] font-black uppercase tracking-[0.15em] border-slate-200">
                <svg class="h-4 w-4 mr-2.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                Quay lại
            </a>
        </x-admin.page-header>

        <div x-data="{ 
            thang: {{ $thangHienTai }}, 
            nam: {{ $namHienTai }},
            rooms: {{ $danhsachphong->toJson() }},
            isValid(room) {
                return room.chisodienmoi >= room.chisodien_cuoi && room.chisonuocmoi >= room.chisonuoc_cuoi;
            }
        }">
            <form action="{{ route('admin.hoadon.luu_hang_loat') }}" method="POST" class="space-y-10">
                @csrf

                <div class="saas-card overflow-hidden shadow-2xl shadow-slate-200/40 border-slate-200/60 max-w-4xl">
                    <div class="bg-slate-50/50 border-b border-slate-200/60 px-10 py-5">
                        <h3 class="text-[11px] font-black uppercase tracking-[0.25em] text-slate-900 flex items-center gap-2.5">
                            <span class="h-1.5 w-1.5 rounded-full bg-brand-emerald"></span>
                            Tháng nhập chỉ số
                        </h3>
                    </div>
                    <div class="p-10 grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div>
                            <label class="block text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 mb-3 ml-1">Tháng</label>
                            <select name="thang" x-model="thang" class="saas-input h-12 font-black tabular-nums bg-slate-50/30 border-slate-200/80 focus:bg-white transition-all">
                                @for($i = 1; $i <= 12; $i++)
                                    <option value="{{ $i }}">Tháng {{ str_pad($i, 2, '0', STR_PAD_LEFT) }}</option>
                                @endfor
                            </select>
                        </div>
                        <div>
                            <label class="block text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 mb-3 ml-1">Năm</label>
                            <select name="nam" x-model="nam" class="saas-input h-12 font-black tabular-nums bg-slate-50/30 border-slate-200/80 focus:bg-white transition-all">
                                @for($i = now()->year - 1; $i <= now()->year + 1; $i++)
                                    <option value="{{ $i }}">Năm {{ $i }}</option>
                                @endfor
                            </select>
                        </div>
                    </div>
                </div>

                <x-admin.table-card>
                    <thead>
                        <tr>
                            <th>Phòng</th>
                            <th class="text-center">Chỉ số điện (cũ → mới)</th>
                            <th class="text-center">Chỉ số nước (cũ → mới)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <template x-for="room in rooms" :key="room.id">
                            <tr class="hover:bg-slate-50/50 transition-colors group">
                                <td class="py-6">
                                    <div class="flex items-center gap-3">
                                        <div class="h-9 w-9 flex items-center justify-center rounded-xl bg-slate-50 text-slate-400 border border-slate-200/60 group-hover:bg-brand-emerald group-hover:text-white group-hover:border-brand-emerald transition-all">
                                            <svg class="h-4.5 w-4.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                                        </div>
                                        <div class="text-[13px] font-black text-slate-900" x-text="room.ten_phong"></div>
                                    </div>
                                    <input type="hidden" :name="`hoa_don[${room.id}][phong_id]`" :value="room.id">
                                </td>
                                <td class="py-6">
                                    <div class="flex items-center justify-center gap-4 bg-white p-2 rounded-2xl border border-slate-200/60 shadow-sm max-w-[300px] mx-auto">
                                        <input type="number" :name="`hoa_don[${room.id}][chisodiencu]`" x-model.number="room.chisodien_cuoi" readonly class="w-20 bg-transparent border-none text-center text-[12px] font-black text-slate-300 tabular-nums focus:ring-0">
                                        <div class="h-6 w-px bg-slate-100"></div>
                                        <svg class="h-4 w-4 text-slate-200 group-hover:text-brand-emerald transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
                                        <input type="number" :name="`hoa_don[${room.id}][chisodienmoi]`" x-model.number="room.chisodienmoi" required min="0"
                                            :class="room.chisodienmoi < room.chisodien_cuoi ? 'bg-rose-50 text-rose-600 border-rose-200' : 'bg-emerald-50/30 text-emerald-700 border-emerald-200/60'"
                                            class="w-24 h-10 rounded-xl border text-center text-[14px] font-black transition-all tabular-nums outline-none focus:ring-4 focus:ring-emerald-500/10">
                                    </div>
                                </td>
                                <td class="py-6">
                                    <div class="flex items-center justify-center gap-4 bg-white p-2 rounded-2xl border border-slate-200/60 shadow-sm max-w-[300px] mx-auto">
                                        <input type="number" :name="`hoa_don[${room.id}][chisonuoccu]`" x-model.number="room.chisonuoc_cuoi" readonly class="w-20 bg-transparent border-none text-center text-[12px] font-black text-slate-300 tabular-nums focus:ring-0">
                                        <div class="h-6 w-px bg-slate-100"></div>
                                        <svg class="h-4 w-4 text-slate-200 group-hover:text-cyan-500 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
                                        <input type="number" :name="`hoa_don[${room.id}][chisonuocmoi]`" x-model.number="room.chisonuocmoi" required min="0"
                                            :class="room.chisonuocmoi < room.chisonuoc_cuoi ? 'bg-rose-50 text-rose-600 border-rose-200' : 'bg-cyan-50/30 text-cyan-600 border-cyan-200/60'"
                                            class="w-24 h-10 rounded-xl border text-center text-[14px] font-black transition-all tabular-nums outline-none focus:ring-4 focus:ring-cyan-500/10">
                                    </div>
                                </td>
                            </tr>
                        </template>
                    </tbody>
                </x-admin.table-card>

                <div class="flex items-center justify-between pt-10 border-t border-slate-100">
                    <div class="flex items-center gap-3 text-slate-400">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <p class="text-[11px] font-bold uppercase tracking-tight italic">
                            Xác thực dữ liệu: Đảm bảo chỉ số cuối tháng ≥ chỉ số đầu tháng để hệ thống tính toán giá trị thực thi.
                        </p>
                    </div>
                    <div class="flex items-center gap-4">
                        <a href="{{ route('admin.hoadon.index') }}" class="saas-btn-secondary h-12 px-8 text-[10px] font-black uppercase tracking-widest border-slate-200">Hủy bỏ</a>
                        <button type="submit"
                            class="saas-btn-primary h-12 px-10 text-[10px] font-black uppercase tracking-widest shadow-xl shadow-emerald-500/20 disabled:opacity-40 disabled:cursor-not-allowed group"
                            :disabled="!rooms.every(r => isValid(r))">
                            <svg class="h-4 w-4 mr-2.5 group-hover:scale-110 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                            Lưu {{ count($danhsachphong) }} chỉ số
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-admin-layout>
