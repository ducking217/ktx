<x-admin-layout>
    <x-slot:title>Kiến trúc Thông số Vận hành Hệ thống</x-slot:title>

    <div class="space-y-10 pb-20">
        <x-admin.page-header
            title="Cấu hình hệ thống"
            subtitle="Thiết lập các định mức tài chính, tham số vận hành và giao thức truyền thông cốt lõi của toàn hệ thống."
        />

        <div class="max-w-4xl">
            <div class="saas-card overflow-hidden shadow-2xl shadow-slate-200/40 border-slate-200/60">
                <div class="bg-slate-50/50 border-b border-slate-200/60 px-10 py-5">
                    <h3 class="text-[11px] font-black uppercase tracking-[0.25em] text-slate-900 flex items-center gap-2.5">
                        <span class="h-1.5 w-1.5 rounded-full bg-brand-emerald"></span>
                        Tham số vận hành
                    </h3>
                </div>
                
                <form method="POST" action="{{ route('admin.cauhinh.capnhat') }}" class="p-10 space-y-10">
                    @csrf
                    <div class="grid gap-10 md:grid-cols-2">
                        <div class="space-y-8">
                            <div>
                                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-3 ml-1">Đơn giá Điện (kWh)</label>
                                <div class="relative group">
                                    <input type="number" min="0" step="0.01" name="gia_dien"
                                           value="{{ old('gia_dien', $cauhinh['gia_dien']->giatri ?? '') }}"
                                           class="saas-input w-full h-12 font-black tabular-nums pr-16 bg-slate-50/30 border-slate-200/80 focus:bg-white transition-all" required>
                                    <span class="absolute right-5 top-1/2 -translate-y-1/2 text-[10px] font-black text-slate-400 uppercase tracking-widest pointer-events-none">VNĐ</span>
                                </div>
                            </div>
                            <div>
                                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-3 ml-1">Đơn giá Nước (m³)</label>
                                <div class="relative group">
                                    <input type="number" min="0" step="0.01" name="gia_nuoc"
                                           value="{{ old('gia_nuoc', $cauhinh['gia_nuoc']->giatri ?? '') }}"
                                           class="saas-input w-full h-12 font-black tabular-nums pr-16 bg-slate-50/30 border-slate-200/80 focus:bg-white transition-all" required>
                                    <span class="absolute right-5 top-1/2 -translate-y-1/2 text-[10px] font-black text-slate-400 uppercase tracking-widest pointer-events-none">VNĐ</span>
                                </div>
                            </div>
                        </div>

                        <div class="space-y-8">
                            <div>
                                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-3 ml-1">Đường dây nóng</label>
                                <div class="relative group">
                                    <div class="absolute left-4.5 top-1/2 -translate-y-1/2 text-slate-400 group-focus-within:text-brand-emerald transition-colors pointer-events-none">
                                        <svg class="h-4.5 w-4.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1.01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                                    </div>
                                    <input type="text" name="hotline"
                                           value="{{ old('hotline', $cauhinh['hotline']->giatri ?? '') }}"
                                           class="saas-input w-full h-12 font-black tabular-nums pl-13 bg-slate-50/30 border-slate-200/80 focus:bg-white transition-all" required>
                                </div>
                            </div>
                            
                            <div class="rounded-2xl bg-emerald-50/40 p-7 border border-emerald-100/60 shadow-sm">
                                <div class="flex items-start gap-4 text-emerald-950/70">
                                    <div class="h-8 w-8 rounded-xl bg-brand-emerald text-white flex items-center justify-center shrink-0 shadow-lg shadow-emerald-600/20">
                                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                    </div>
                                    <p class="text-[11px] font-bold leading-relaxed italic mt-1 uppercase tracking-tight">
                                        Các tham số này sẽ được áp dụng định lượng khi đối soát chu kỳ và kết xuất hóa đơn tự động hàng tháng cho toàn thể cư dân nội trú.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="flex justify-end pt-10 border-t border-slate-100">
                        <button type="submit" class="saas-btn-primary h-12 px-10 shadow-xl shadow-emerald-500/20 group">
                            <svg class="h-4.5 w-4.5 mr-2.5 group-hover:rotate-12 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                            Lưu cấu hình
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-admin-layout>
