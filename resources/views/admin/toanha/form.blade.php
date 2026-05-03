<x-admin-layout>
    <x-slot:title>{{ isset($toaNha) ? 'Hiệu chỉnh tòa nhà' : 'Thêm tòa nhà mới' }}</x-slot:title>

    <div class="mb-8">
        <a href="{{ route('admin.toanha.index') }}" class="inline-flex items-center gap-2 text-[10px] font-bold uppercase tracking-widest text-ink-secondary hover:text-ink-primary transition-colors">
            <svg class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            Quay lại danh sách
        </a>
        <h1 class="mt-2 text-xl font-bold text-ink-primary font-display uppercase tracking-tight">
            {{ isset($toaNha) ? 'Hiệu chỉnh thông tin tòa nhà' : 'Khởi tạo thực thể tòa nhà' }}
        </h1>
    </div>

    <div class="max-w-2xl">
        <form method="POST" action="{{ isset($toaNha) ? route('admin.toanha.capnhat', $toaNha->id) : route('admin.toanha.luu') }}" class="space-y-6 rounded-2xl border border-ui-border bg-white p-8 shadow-sm">
            @csrf
            @if(isset($toaNha))
                @method('PUT')
            @endif

            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                <div class="space-y-1.5">
                    <label for="ten_toa_nha" class="text-[10px] font-bold uppercase tracking-widest text-ink-secondary">Tên tòa nhà <span class="text-rose-500">*</span></label>
                    <input type="text" name="ten_toa_nha" id="ten_toa_nha" value="{{ old('ten_toa_nha', $toaNha->ten_toa_nha ?? '') }}" placeholder="VD: Tòa nhà A1" class="w-full rounded-xl border border-ui-border bg-ui-bg/30 py-3 px-4 text-sm font-medium text-ink-primary placeholder:text-ink-secondary/30 focus:border-ink-primary/30 focus:outline-none focus:ring-4 focus:ring-ink-primary/5 transition-all @error('ten_toa_nha') border-rose-500 ring-rose-500/10 @enderror" required />
                    @error('ten_toa_nha')
                        <p class="text-[10px] font-bold text-rose-500 uppercase tracking-wide">{{ $message }}</p>
                    @enderror
                </div>

                <div class="space-y-1.5">
                    <label for="ma_toa_nha" class="text-[10px] font-bold uppercase tracking-widest text-ink-secondary">Mã tòa nhà <span class="text-rose-500">*</span></label>
                    <input type="text" name="ma_toa_nha" id="ma_toa_nha" value="{{ old('ma_toa_nha', $toaNha->ma_toa_nha ?? '') }}" placeholder="VD: A1" class="w-full rounded-xl border border-ui-border bg-ui-bg/30 py-3 px-4 text-sm font-medium text-ink-primary placeholder:text-ink-secondary/30 focus:border-ink-primary/30 focus:outline-none focus:ring-4 focus:ring-ink-primary/5 transition-all @error('ma_toa_nha') border-rose-500 ring-rose-500/10 @enderror" required />
                    @error('ma_toa_nha')
                        <p class="text-[10px] font-bold text-rose-500 uppercase tracking-wide">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="space-y-1.5">
                <label for="mo_ta" class="text-[10px] font-bold uppercase tracking-widest text-ink-secondary">Mô tả chi tiết</label>
                <textarea name="mo_ta" id="mo_ta" rows="4" placeholder="Nhập mô tả về tòa nhà (vị trí, đặc điểm...)" class="w-full rounded-xl border border-ui-border bg-ui-bg/30 py-3 px-4 text-sm font-medium text-ink-primary placeholder:text-ink-secondary/30 focus:border-ink-primary/30 focus:outline-none focus:ring-4 focus:ring-ink-primary/5 transition-all">{{ old('mo_ta', $toaNha->mo_ta ?? '') }}</textarea>
                @error('mo_ta')
                    <p class="text-[10px] font-bold text-rose-500 uppercase tracking-wide">{{ $message }}</p>
                @enderror
            </div>

            <div class="pt-4 flex items-center justify-end gap-3">
                <a href="{{ route('admin.toanha.index') }}" class="rounded-xl px-6 py-3 text-xs font-bold text-ink-secondary hover:bg-ui-bg transition-all">Hủy bỏ</a>
                <button type="submit" class="rounded-xl bg-ink-primary px-8 py-3 text-xs font-bold text-white shadow-sm transition-all hover:bg-ink-primary/90 active:scale-[0.98]">
                    {{ isset($toaNha) ? 'Cập nhật tòa nhà' : 'Khởi tạo tòa nhà' }}
                </button>
            </div>
        </form>
    </div>
</x-admin-layout>
