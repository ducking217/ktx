<section class="space-y-6">
    <header class="border-b border-rose-200 pb-4">
        <h2 class="text-lg font-bold text-rose-600 tracking-tight">Vùng nguy hiểm</h2>
        <p class="mt-1 text-xs font-medium text-rose-500">
            Hành động này sẽ xóa vĩnh viễn tài khoản và tất cả dữ liệu liên quan.
        </p>
    </header>

    <button
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
        class="w-full flex items-center justify-center gap-2 rounded-xl bg-rose-50 px-4 py-2.5 text-[10px] font-bold uppercase tracking-widest text-rose-600 ring-1 ring-inset ring-rose-200 hover:bg-rose-600 hover:text-white transition-colors"
    >
        Xóa tài khoản
    </button>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-6 bg-white">
            @csrf
            @method('delete')

            <h2 class="text-lg font-bold text-slate-900 tracking-tight">
                Xác nhận xóa tài khoản?
            </h2>

            <p class="mt-3 text-sm text-slate-500">
                Khi tài khoản bị xóa, mọi dữ liệu cư trú, hóa đơn và lịch sử báo hỏng của bạn sẽ biến mất vĩnh viễn. Vui lòng nhập mật khẩu để xác nhận.
            </p>

            <div class="mt-6 space-y-2">
                <label for="password" class="text-[10px] font-bold uppercase tracking-widest text-slate-400 ml-1">Mật khẩu xác nhận</label>
                <div class="relative group">
                    <input
                        id="password"
                        name="password"
                        type="password"
                        class="saas-input pl-11 focus:border-rose-500 focus:ring-rose-500/20"
                        placeholder="••••••••"
                    />
                    <div class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 pointer-events-none">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                    </div>
                </div>

                <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2 ml-1" />
            </div>

            <div class="mt-8 flex justify-end gap-3">
                <button type="submit" class="flex items-center justify-center gap-2 rounded-xl bg-rose-600 px-6 h-11 text-[10px] font-bold uppercase tracking-widest text-white shadow-sm hover:bg-rose-700 transition-colors">
                    Xác nhận xóa
                </button>

                <button type="button" x-on:click="$dispatch('close')" class="saas-btn-secondary h-11 px-6">
                    Hủy bỏ
                </button>
            </div>
        </form>
    </x-modal>
</section>
