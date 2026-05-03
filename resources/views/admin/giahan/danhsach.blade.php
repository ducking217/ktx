<x-admin-layout>
    <x-slot name="title">Quản lý gia hạn</x-slot>

    <div class="space-y-8 animate-fade-up">
        <header class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h2 class="text-2xl font-black text-ink-primary uppercase tracking-tight">Yêu cầu gia hạn</h2>
                <p class="text-[10px] font-bold text-ink-secondary/50 uppercase tracking-widest mt-1">Danh sách sinh viên gửi yêu cầu kéo dài thời gian lưu trú</p>
            </div>
            
            <div class="flex items-center gap-3">
                <form action="{{ route('admin.giahan.index') }}" method="GET" class="flex items-center gap-2">
                    <select name="status" onchange="this.form.submit()" class="bg-ui-card border-ui-border rounded-xl text-[10px] font-black uppercase tracking-widest px-4 py-2 focus:ring-2 focus:ring-brand-emerald/20 transition-all">
                        <option value="Tất cả" {{ $status === 'Tất cả' ? 'selected' : '' }}>Tất cả trạng thái</option>
                        @foreach(\App\Enums\ExtensionStatus::cases() as $case)
                            <option value="{{ $case->value }}" {{ $status === $case->value ? 'selected' : '' }}>{{ $case->label() }}</option>
                        @endforeach
                    </select>
                </form>
            </div>
        </header>

        <article class="pdu-card !p-0 overflow-hidden shadow-xl shadow-ink-primary/5">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-ui-bg/50 border-b border-ui-border text-[10px] font-black text-ink-secondary/40 uppercase tracking-[0.2em]">
                            <th class="px-6 py-4">Sinh viên</th>
                            <th class="px-6 py-4">Hợp đồng</th>
                            <th class="px-6 py-4">Ngày hết hạn cũ</th>
                            <th class="px-6 py-4">Ngày mong muốn</th>
                            <th class="px-6 py-4">Lý do</th>
                            <th class="px-6 py-4">Trạng thái</th>
                            <th class="px-6 py-4 text-right">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-ui-border">
                        @forelse ($yeuCauGiaHan as $item)
                            <tr class="group hover:bg-ui-bg/30 transition-colors">
                                <td class="px-6 py-5">
                                    <div class="font-bold text-ink-primary tracking-tight">{{ $item->sinhvien->taikhoan->name }}</div>
                                    <div class="text-[10px] font-bold text-ink-secondary/40 uppercase tracking-widest">{{ $item->sinhvien->masinhvien }}</div>
                                </td>
                                <td class="px-6 py-5">
                                    <div class="font-display font-black text-ink-primary tracking-tight">{{ $item->hopdong->ma_hd }}</div>
                                    <div class="text-[10px] font-bold text-ink-secondary/40 uppercase tracking-widest">{{ $item->hopdong->phong->tenphong }}</div>
                                </td>
                                <td class="px-6 py-5 font-medium text-ink-secondary tabular-nums tracking-tight">
                                    {{ $item->hopdong->ngay_ket_thuc->format('d/m/Y') }}
                                </td>
                                <td class="px-6 py-5 font-bold text-brand-emerald tabular-nums tracking-tight">
                                    {{ $item->ngay_ket_thuc_moi->format('d/m/Y') }}
                                </td>
                                <td class="px-6 py-5">
                                    <p class="text-xs text-ink-secondary/70 max-w-xs truncate" title="{{ $item->ly_do }}">
                                        {{ $item->ly_do ?: '—' }}
                                    </p>
                                </td>
                                <td class="px-6 py-5">
                                    <span @class([
                                        'inline-flex items-center rounded-lg px-2.5 py-1 text-[9px] font-black uppercase tracking-widest ring-1',
                                        'bg-status-warning/10 text-status-warning ring-status-warning/20' => $item->trang_thai->value === 'pending',
                                        'bg-status-success/10 text-status-success ring-status-success/20' => $item->trang_thai->value === 'approved',
                                        'bg-status-error/10 text-status-error ring-status-error/20' => $item->trang_thai->value === 'rejected',
                                    ])>
                                        {{ $item->trang_thai->label() }}
                                    </span>
                                </td>
                                <td class="px-6 py-5 text-right">
                                    @if($item->trang_thai->value === 'pending')
                                        <div class="flex items-center justify-end gap-2">
                                            <button onclick="openModal('modal-approve-{{ $item->id }}')" class="pdu-btn-ghost !text-status-success !bg-status-success/5 hover:!bg-status-success/10 !px-3 !py-1.5 text-[9px] uppercase tracking-widest">Duyệt</button>
                                            <button onclick="openModal('modal-reject-{{ $item->id }}')" class="pdu-btn-ghost !text-status-error !bg-status-error/5 hover:!bg-status-error/10 !px-3 !py-1.5 text-[9px] uppercase tracking-widest">Từ chối</button>
                                        </div>

                                        {{-- Modal Duyệt --}}
                                        <div id="modal-approve-{{ $item->id }}" class="fixed inset-0 z-[100] hidden items-center justify-center p-4 bg-ink-primary/60 backdrop-blur-sm animate-fade-in">
                                            <div class="bg-ui-card w-full max-w-md rounded-2xl p-8 shadow-2xl animate-pop-in">
                                                <h3 class="font-display text-xl font-black text-ink-primary uppercase tracking-tight mb-2">Duyệt gia hạn</h3>
                                                <p class="text-xs text-ink-secondary/60 mb-6">Bạn đang duyệt gia hạn cho sinh viên <strong>{{ $item->sinhvien->taikhoan->name }}</strong> đến ngày <strong>{{ $item->ngay_ket_thuc_moi->format('d/m/Y') }}</strong>.</p>
                                                
                                                <form action="{{ route('admin.giahan.duyet', $item->id) }}" method="POST" class="space-y-4 text-left">
                                                    @csrf
                                                    <div class="space-y-2">
                                                        <label class="text-[10px] font-black text-ink-primary uppercase tracking-widest">Ghi chú cho sinh viên</label>
                                                        <textarea name="ghi_chu_admin" rows="3" class="w-full bg-ui-bg border-ui-border rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-brand-emerald/20 transition-all resize-none" placeholder="Ví dụ: Đã duyệt gia hạn cho học kỳ tiếp theo..."></textarea>
                                                    </div>
                                                    <div class="flex items-center justify-end gap-3 pt-4 border-t border-ui-border">
                                                        <button type="button" onclick="closeModal('modal-approve-{{ $item->id }}')" class="pdu-btn-ghost">Hủy</button>
                                                        <button type="submit" class="pdu-btn-primary !bg-status-success !border-status-success shadow-lg shadow-status-success/20">Xác nhận duyệt</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>

                                        {{-- Modal Từ chối --}}
                                        <div id="modal-reject-{{ $item->id }}" class="fixed inset-0 z-[100] hidden items-center justify-center p-4 bg-ink-primary/60 backdrop-blur-sm animate-fade-in">
                                            <div class="bg-ui-card w-full max-w-md rounded-2xl p-8 shadow-2xl animate-pop-in">
                                                <h3 class="font-display text-xl font-black text-status-error uppercase tracking-tight mb-2">Từ chối gia hạn</h3>
                                                <p class="text-xs text-ink-secondary/60 mb-6">Vui lòng nhập lý do từ chối yêu cầu của <strong>{{ $item->sinhvien->taikhoan->name }}</strong>.</p>
                                                
                                                <form action="{{ route('admin.giahan.tuchoi', $item->id) }}" method="POST" class="space-y-4 text-left">
                                                    @csrf
                                                    <div class="space-y-2">
                                                        <label class="text-[10px] font-black text-ink-primary uppercase tracking-widest">Lý do từ chối <span class="text-status-error">*</span></label>
                                                        <textarea name="ghi_chu_admin" rows="3" required class="w-full bg-ui-bg border-ui-border rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-status-error/20 transition-all resize-none" placeholder="Ví dụ: Sinh viên vi phạm kỷ luật, không đủ điều kiện gia hạn..."></textarea>
                                                    </div>
                                                    <div class="flex items-center justify-end gap-3 pt-4 border-t border-ui-border">
                                                        <button type="button" onclick="closeModal('modal-reject-{{ $item->id }}')" class="pdu-btn-ghost">Hủy</button>
                                                        <button type="submit" class="pdu-btn-primary !bg-status-error !border-status-error shadow-lg shadow-status-error/20">Từ chối ngay</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    @else
                                        <span class="text-[9px] font-black text-ink-secondary/30 uppercase tracking-widest">Đã xử lý</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="py-32 text-center text-ink-secondary/20 uppercase font-black text-[10px] tracking-widest">Không có yêu cầu nào</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($yeuCauGiaHan->hasPages())
                <div class="px-6 py-4 bg-ui-bg/30 border-t border-ui-border">
                    {{ $yeuCauGiaHan->links() }}
                </div>
            @endif
        </article>
    </div>

    <script>
        function openModal(id) {
            document.getElementById(id).classList.remove('hidden');
            document.getElementById(id).classList.add('flex');
            document.body.classList.add('overflow-hidden');
        }
        function closeModal(id) {
            document.getElementById(id).classList.add('hidden');
            document.getElementById(id).classList.remove('flex');
            document.body.classList.remove('overflow-hidden');
        }
    </script>
</x-admin-layout>
