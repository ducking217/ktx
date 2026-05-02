<x-admin-layout>
    <x-slot name="header">
        <h2 class="text-xl font-bold leading-tight text-ink-primary">
            {{ __('Nhập chỉ số điện nước hàng loạt') }}
        </h2>
    </x-slot>

    <div class="py-12" x-data="{ 
        thang: {{ $thangHienTai }}, 
        nam: {{ $namHienTai }},
        rooms: {{ $danhsachphong->toJson() }},
        isValid(room) {
            return room.chisodienmoi >= room.chisodien_cuoi && room.chisonuocmoi >= room.chisonuoc_cuoi;
        }
    }">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <form action="{{ route('admin.hoadon.luu_hang_loat') }}" method="POST" class="space-y-6">
                @csrf
                
                <!-- Bộ lọc Kỳ hóa đơn -->
                <div class="rounded-3xl border border-ui-border bg-ui-card p-6 shadow-sm">
                    <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                        <div>
                            <label class="mb-2 block text-[11px] font-black uppercase tracking-widest text-ink-secondary/50">Tháng</label>
                            <select name="thang" x-model="thang" class="w-full rounded-2xl border-ui-border bg-ui-bg font-bold text-ink-primary focus:border-brand-emerald focus:ring-brand-emerald">
                                @for($i = 1; $i <= 12; $i++)
                                    <option value="{{ $i }}">Tháng {{ $i }}</option>
                                @endfor
                            </select>
                        </div>
                        <div>
                            <label class="mb-2 block text-[11px] font-black uppercase tracking-widest text-ink-secondary/50">Năm</label>
                            <select name="nam" x-model="nam" class="w-full rounded-2xl border-ui-border bg-ui-bg font-bold text-ink-primary focus:border-brand-emerald focus:ring-brand-emerald">
                                @for($i = now()->year - 1; $i <= now()->year + 1; $i++)
                                    <option value="{{ $i }}">{{ $i }}</option>
                                @endfor
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Bảng nhập liệu -->
                <div class="overflow-hidden rounded-3xl border border-ui-border bg-ui-card shadow-sm">
                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-sm">
                            <thead>
                                <tr class="border-b border-ui-border bg-ui-bg/50">
                                    <th class="px-6 py-4 text-[10px] font-black uppercase tracking-widest text-ink-secondary/50">Phòng</th>
                                    <th class="px-6 py-4 text-[10px] font-black uppercase tracking-widest text-ink-secondary/50">Điện (Cũ -> Mới)</th>
                                    <th class="px-6 py-4 text-[10px] font-black uppercase tracking-widest text-ink-secondary/50">Nước (Cũ -> Mới)</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-ui-border">
                                <template x-for="(room, index) in rooms" :key="room.id">
                                    <tr class="group transition-colors hover:bg-ui-bg/30">
                                        <td class="px-6 py-4">
                                            <div class="font-bold text-ink-primary" x-text="room.tenphong"></div>
                                            <input type="hidden" :name="`hoa_don[${room.id}][phong_id]`" :value="room.id">
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="flex items-center gap-3">
                                                <input type="number" :name="`hoa_don[${room.id}][chisodiencu]`" x-model.number="room.chisodien_cuoi" readonly class="w-24 rounded-xl border-none bg-ui-bg/50 text-center text-xs font-bold text-ink-secondary/40 focus:ring-0">
                                                <svg class="h-4 w-4 text-ink-secondary/20" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
                                                <input type="number" :name="`hoa_don[${room.id}][chisodienmoi]`" x-model.number="room.chisodienmoi" required min="0" 
                                                    :class="room.chisodienmoi < room.chisodien_cuoi ? 'border-rose-500 ring-rose-500' : 'border-ui-border focus:border-brand-emerald focus:ring-brand-emerald'"
                                                    class="w-24 rounded-xl bg-ui-bg text-center text-sm font-black text-ink-primary transition-all">
                                            </div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="flex items-center gap-3">
                                                <input type="number" :name="`hoa_don[${room.id}][chisonuoccu]`" x-model.number="room.chisonuoc_cuoi" readonly class="w-24 rounded-xl border-none bg-ui-bg/50 text-center text-xs font-bold text-ink-secondary/40 focus:ring-0">
                                                <svg class="h-4 w-4 text-ink-secondary/20" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
                                                <input type="number" :name="`hoa_don[${room.id}][chisonuocmoi]`" x-model.number="room.chisonuocmoi" required min="0"
                                                    :class="room.chisonuocmoi < room.chisonuoc_cuoi ? 'border-rose-500 ring-rose-500' : 'border-ui-border focus:border-brand-emerald focus:ring-brand-emerald'"
                                                    class="w-24 rounded-xl bg-ui-bg text-center text-sm font-black text-ink-primary transition-all">
                                            </div>
                                        </td>
                                    </tr>
                                </template>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Nút Submit -->
                <div class="flex justify-end gap-4">
                    <a href="{{ route('admin.quanlyhoadon') }}" class="rounded-2xl border border-ui-border bg-ui-card px-8 py-3 text-sm font-bold text-ink-secondary transition-all hover:bg-ui-bg">Hủy bỏ</a>
                    <button type="submit" 
                        class="rounded-2xl bg-brand-emerald px-10 py-3 text-sm font-bold text-white shadow-lg shadow-brand-emerald/20 transition-all hover:scale-[1.02] active:scale-[0.98] disabled:opacity-50 disabled:grayscale"
                        :disabled="!rooms.every(r => isValid(r))">
                        Lưu {{ count($danhsachphong) }} hóa đơn
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-admin-layout>
