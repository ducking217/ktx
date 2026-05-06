<x-admin-layout>
    <x-slot:title>Quản lý Liên hệ</x-slot:title>

    <div class="space-y-10 pb-20">
        <x-admin.page-header
            title="Hộp thư liên hệ"
            subtitle="Tiếp nhận và phản hồi các kiến nghị, đóng góp để nâng cao chất lượng vận hành."
        >
            <x-admin.status-tabs
                :items="[
                    'Tất cả' => 'Tất cả',
                    \App\Models\Lienhe::TRANG_THAI_CHUA_XU_LY => \App\Models\Lienhe::TRANG_THAI_CHUA_XU_LY,
                    \App\Models\Lienhe::TRANG_THAI_DA_XU_LY => \App\Models\Lienhe::TRANG_THAI_DA_XU_LY,
                ]"
                :active="$status ?? null"
                route="admin.lienhe.index"
                param="status"
                defaultValue="Tất cả"
            />
        </x-admin.page-header>

        <x-admin.table-card>
            <thead>
                <tr>
                    <th>Người gửi</th>
                    <th>Kênh liên hệ</th>
                    <th>Nội dung</th>
                    <th>Thời gian</th>
                    <th class="text-center">Trạng thái</th>
                    <th class="text-right">Thao tác</th>
                </tr>
            </thead>
            <tbody x-data="{ openId: null }">
                @forelse ($danhsachlienhe as $lienhe)
                    <tr class="hover:bg-slate-50/50 transition-colors group">
                        <td class="py-6">
                            <div class="text-[13px] font-black text-slate-900 leading-none group-hover:text-brand-emerald transition-colors">{{ $lienhe->ho_ten }}</div>
                            <div class="text-[9px] font-black text-slate-400 uppercase tracking-[0.15em] mt-2.5">Người gửi</div>
                        </td>
                        <td class="py-6">
                            <div class="flex items-center gap-3 text-[12px] font-black text-slate-600 tabular-nums">
                                <div class="h-8 w-8 rounded-xl bg-slate-50 flex items-center justify-center text-slate-400 border border-slate-200/60 shadow-sm group-hover:bg-brand-emerald/10 group-hover:text-brand-emerald transition-all">
                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                                </div>
                                {{ $lienhe->email }}
                            </div>
                        </td>
                        <td class="py-6 max-w-sm">
                            <div class="text-[11px] font-semibold leading-relaxed text-slate-600 line-clamp-2 rounded-xl bg-slate-50/70 px-4 py-3 ring-1 ring-slate-200/50">
                                "{{ Str::limit($lienhe->noi_dung, 150) }}"
                            </div>
                        </td>
                        <td class="py-6">
                            <div class="text-[12px] font-black text-slate-900 tabular-nums tracking-tighter">{{ $lienhe->created_at->format('d/m/Y') }}</div>
                            <div class="text-[9px] font-black text-slate-400 tabular-nums uppercase mt-1.5">{{ $lienhe->created_at->format('H:i') }}</div>
                        </td>
                        <td class="py-6 text-center">
                            @php
                                $isProcessedContact = $lienhe->trang_thai === 'Đã xử lý';
                                $statusBadgeContact = $isProcessedContact ? 'saas-badge-success' : 'saas-badge-warning';
                            @endphp
                            <span class="saas-badge {{ $statusBadgeContact }} font-black px-4 py-1.5 border-none shadow-sm">
                                {{ $lienhe->trang_thai }}
                            </span>
                        </td>
                        <td class="py-6 text-right">
                            <div class="flex items-center justify-end gap-2">
                                <button
                                    type="button"
                                    @click="openId = openId === {{ (int) $lienhe->id }} ? null : {{ (int) $lienhe->id }}"
                                    class="h-9 w-9 inline-flex items-center justify-center text-slate-400 hover:text-brand-emerald hover:bg-brand-emerald/10 border border-transparent hover:border-brand-emerald/20 rounded-xl transition-all shadow-sm hover:shadow-md"
                                    title="Xem và phản hồi"
                                >
                                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M7 8h10M7 12h6m-6 4h8M5 20h14a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                </button>
                                @if (!$isProcessedContact)
                                    <form method="POST" action="{{ route('admin.lienhe.capnhattrangthai', ['id' => $lienhe->id]) }}" x-data="{ showConfirm: false }" @confirmed="$el.submit()" class="inline">
                                        @csrf
                                        <input type="hidden" name="trang_thai" value="Đã xử lý">
                                        <button type="button" @click="showConfirm = true" class="h-9 w-9 inline-flex items-center justify-center text-slate-400 hover:text-emerald-600 hover:bg-emerald-50 border border-transparent hover:border-emerald-100 rounded-xl transition-all shadow-sm hover:shadow-md" title="Đánh dấu đã xử lý">
                                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                                        </button>
                                        <x-confirmation-modal message="Xác nhận đánh dấu kiến nghị này đã được thẩm định và giải quyết triệt để?" />
                                    </form>
                                @else
                                    <div class="h-9 w-9 inline-flex items-center justify-center text-emerald-500 bg-emerald-50 border border-emerald-100 rounded-xl shadow-sm" title="Đã xử lý">
                                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                                    </div>
                                @endif
                            </div>
                        </td>
                    </tr>
                    <tr x-show="openId === {{ (int) $lienhe->id }}" x-cloak class="bg-slate-50/30">
                        <td colspan="6" class="pb-6">
                            <div class="px-6">
                                <div class="rounded-2xl bg-ui-card ring-1 ring-ui-border shadow-sm p-6">
                                    <div class="flex flex-col gap-6 lg:flex-row lg:items-start lg:justify-between">
                                        <div class="min-w-0 flex-1">
                                            <div class="text-xs font-black uppercase tracking-widest text-slate-500">Nội dung liên hệ</div>
                                            <div class="mt-3 text-sm text-slate-700 leading-relaxed whitespace-pre-line">{{ $lienhe->noi_dung }}</div>
                                            <div class="mt-4 flex flex-wrap items-center gap-x-4 gap-y-2 text-xs text-slate-500">
                                                <div class="font-semibold text-slate-600">{{ $lienhe->email }}</div>
                                                <div class="tabular-nums">{{ $lienhe->created_at?->format('H:i • d/m/Y') }}</div>
                                            </div>
                                        </div>

                                        <div class="w-full lg:w-[420px]">
                                            <form
                                                method="POST"
                                                action="{{ route('admin.lienhe.capnhattrangthai', ['id' => $lienhe->id]) }}"
                                                x-data="{
                                                    showConfirm: false,
                                                    guiEmail: 0,
                                                    trangThai: @js($lienhe->trang_thai),
                                                    datGhiChu() { this.guiEmail = 0; this.trangThai = @js($lienhe->trang_thai); },
                                                    datGuiPhanHoi() { this.guiEmail = 1; this.trangThai = @js(\App\Models\Lienhe::TRANG_THAI_DA_XU_LY); this.showConfirm = true; },
                                                }"
                                                @confirmed="$el.submit()"
                                                class="space-y-3"
                                            >
                                                @csrf
                                                <input type="hidden" name="trang_thai" x-model="trangThai">
                                                <input type="hidden" name="gui_email" x-model="guiEmail">

                                                <div>
                                                    <label class="block text-xs font-semibold text-slate-600">Phản hồi của Ban quản lý</label>
                                                    <textarea name="ghi_chu_admin" rows="5" class="mt-2 w-full rounded-xl border border-slate-200/60 bg-ui-bg px-4 py-3 text-sm text-slate-900 shadow-sm focus:border-brand-emerald focus:ring-4 focus:ring-emerald-500/10" placeholder="Soạn phản hồi để gửi qua thư điện tử, hoặc ghi chú nội bộ...">{{ old('ghi_chu_admin', $lienhe->ghi_chu_admin) }}</textarea>
                                                    @error('ghi_chu_admin')
                                                        <div class="mt-2 text-xs font-medium text-red-600">{{ $message }}</div>
                                                    @enderror
                                                </div>

                                                <div class="flex items-center justify-end gap-2">
                                                    <button type="submit" @click="datGhiChu()" class="h-10 rounded-xl px-4 text-xs font-semibold text-slate-700 bg-slate-100 hover:bg-slate-200 transition-colors">
                                                        Lưu ghi chú
                                                    </button>
                                                    <button type="button" @click="datGuiPhanHoi()" class="h-10 rounded-xl px-4 text-xs font-semibold text-white bg-emerald-600 hover:bg-emerald-700 transition-colors">
                                                        Gửi phản hồi
                                                    </button>
                                                </div>

                                                <x-confirmation-modal
                                                    type="info"
                                                    title="Gửi phản hồi"
                                                    message="Gửi phản hồi qua thư điện tử cho người gửi và đánh dấu liên hệ là đã xử lý?"
                                                    confirmText="Gửi"
                                                />
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="py-40 text-center">
                            <div class="flex flex-col items-center gap-6">
                                <div class="h-24 w-24 bg-slate-50 rounded-full flex items-center justify-center text-slate-200 border border-slate-100 border-dashed">
                                    <svg class="h-12 w-12" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/></svg>
                                </div>
                                <h4 class="text-sm font-black text-slate-400 uppercase tracking-widest">Không có liên hệ</h4>
                                <p class="text-[11px] text-slate-400 font-medium max-w-xs">Hiện chưa có liên hệ nào cần xử lý tại thời điểm này.</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </x-admin.table-card>

        @if(method_exists($danhsachlienhe, 'links'))
            <div class="py-12">
                {{ $danhsachlienhe->appends(request()->query())->links() }}
            </div>
        @endif
    </div>
</x-admin-layout>
