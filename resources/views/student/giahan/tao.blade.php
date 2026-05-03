@extends('student.layouts.chinh')

@section('student_page_title', 'Yêu cầu gia hạn')

@section('noidung')
    <div class="max-w-3xl mx-auto space-y-8 animate-fade-up">
        <header class="flex items-center justify-between">
            <div>
                <h2 class="text-xl font-black text-ink-primary uppercase tracking-tight">Gia hạn hợp đồng</h2>
                <p class="text-[10px] font-bold text-ink-secondary/50 uppercase tracking-widest mt-1">Năm học {{ date('Y') }}-{{ date('Y')+1 }}</p>
            </div>
            <a href="{{ route('student.giahan.index') }}" class="pdu-btn-ghost !px-4">
                <svg class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                Quay lại
            </a>
        </header>

        <div class="grid grid-cols-1 md:grid-cols-12 gap-8">
            {{-- Thông tin hợp đồng hiện tại --}}
            <aside class="md:col-span-4 space-y-6">
                <div class="pdu-card !p-6 bg-ui-bg/30 border-dashed">
                    <h3 class="text-[10px] font-black text-ink-secondary/40 uppercase tracking-[0.2em] mb-4">Hợp đồng hiện tại</h3>
                    
                    <div class="space-y-4">
                        <div>
                            <span class="text-[9px] font-black uppercase text-ink-secondary/50 block tracking-widest">Mã hợp đồng</span>
                            <span class="font-display font-black text-ink-primary tracking-tight">{{ $hopdong->ma_hd }}</span>
                        </div>
                        <div>
                            <span class="text-[9px] font-black uppercase text-ink-secondary/50 block tracking-widest">Phòng</span>
                            <span class="font-bold text-ink-primary tracking-tight">{{ $hopdong->phong->tenphong }}</span>
                        </div>
                        <div>
                            <span class="text-[9px] font-black uppercase text-ink-secondary/50 block tracking-widest">Ngày kết thúc</span>
                            <span class="font-bold text-ink-primary tabular-nums tracking-tight">{{ $hopdong->ngay_ket_thuc->format('d/m/Y') }}</span>
                        </div>
                    </div>
                </div>

                <div class="p-6 rounded-2xl bg-brand-emerald/5 border border-brand-emerald/10">
                    <div class="flex gap-3 text-brand-emerald">
                        <svg class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <p class="text-[11px] font-medium leading-relaxed">
                            Yêu cầu của bạn sẽ được Ban quản lý KTX xem xét trong vòng 24-48h làm việc. Kết quả sẽ được thông báo qua Email.
                        </p>
                    </div>
                </div>
            </aside>

            {{-- Form đăng ký --}}
            <main class="md:col-span-8">
                <article class="pdu-card shadow-xl shadow-ink-primary/5">
                    <form action="{{ route('student.giahan.store') }}" method="POST" class="space-y-6">
                        @csrf
                        <input type="hidden" name="hopdong_id" value="{{ $hopdong->id }}">

                        <div class="space-y-2">
                            <label for="ngay_ket_thuc_moi" class="text-[10px] font-black text-ink-primary uppercase tracking-widest">Ngày kết thúc mới <span class="text-status-error">*</span></label>
                            <div class="relative group">
                                <input type="date" 
                                       name="ngay_ket_thuc_moi" 
                                       id="ngay_ket_thuc_moi"
                                       value="{{ old('ngay_ket_thuc_moi', $hopdong->ngay_ket_thuc->addMonths(5)->format('Y-m-d')) }}"
                                       class="w-full bg-ui-bg border-ui-border rounded-xl px-4 py-3.5 font-bold text-ink-primary focus:ring-2 focus:ring-brand-emerald/20 focus:border-brand-emerald transition-all"
                                       required>
                                <div class="absolute inset-y-0 right-4 flex items-center pointer-events-none text-ink-secondary/30 group-focus-within:text-brand-emerald transition-colors">
                                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                </div>
                            </div>
                            <p class="text-[9px] font-bold text-ink-secondary/40 uppercase tracking-widest">Gợi ý: Mặc định gia hạn thêm 5 tháng</p>
                        </div>

                        <div class="space-y-2">
                            <label for="ly_do" class="text-[10px] font-black text-ink-primary uppercase tracking-widest">Lý do gia hạn</label>
                            <textarea name="ly_do" 
                                      id="ly_do" 
                                      rows="4" 
                                      placeholder="Ví dụ: Tiếp tục học tập tại trường kỳ tiếp theo..."
                                      class="w-full bg-ui-bg border-ui-border rounded-xl px-4 py-3.5 font-medium text-ink-primary placeholder:text-ink-secondary/30 focus:ring-2 focus:ring-brand-emerald/20 focus:border-brand-emerald transition-all resize-none">{{ old('ly_do') }}</textarea>
                        </div>

                        <div class="pt-4 flex items-center justify-end gap-4 border-t border-ui-border">
                            <button type="reset" class="pdu-btn-ghost">Hủy</button>
                            <button type="submit" class="pdu-btn-primary !px-8 h-12 shadow-lg shadow-brand-emerald/20">
                                Gửi yêu cầu gia hạn
                                <svg class="h-4 w-4 ml-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
                            </button>
                        </div>
                    </form>
                </article>
            </main>
        </div>
    </div>
@endsection
