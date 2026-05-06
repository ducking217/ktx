<?php $__env->startSection('student_page_title', 'Hợp đồng cư trú'); ?>

<?php $__env->startSection('noidung'); ?>
    <?php
        $activeTab = (string) request()->query('tab', 'hopdong');
        $allowedTabs = ['hopdong', 'gia-han'];
        if (!in_array($activeTab, $allowedTabs, true)) {
            $activeTab = 'hopdong';
        }

        $isAlumni = (auth()->user()?->vaitro === 'cuu_sinhvien');
        $yeuCauGiaHan = $yeuCauGiaHan ?? null;
        $hopdongHieuLuc = $hopdongHieuLuc ?? null;

        $hasAnyContract = method_exists($hopdong, 'isEmpty') ? !$hopdong->isEmpty() : !empty($hopdong);
        $hasActiveContract = (bool) $hopdongHieuLuc;
        $canShowTabs = $hasAnyContract && !$isAlumni;
    ?>

    <?php if($canShowTabs): ?>
        <div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <div class="text-lg font-semibold text-slate-900">Hợp đồng & gia hạn</div>
                <div class="mt-0.5 text-xs text-slate-500">Theo dõi hợp đồng cư trú và gửi yêu cầu gia hạn tại cùng một nơi.</div>
            </div>
            <nav class="flex items-center gap-1 p-1 rounded-xl bg-slate-100/80 w-fit" aria-label="Bộ lọc">
                <?php
                    $tabItems = [
                        'hopdong' => ['label' => 'Hợp đồng'],
                        'gia-han' => ['label' => 'Gia hạn'],
                    ];
                ?>
                <?php $__currentLoopData = $tabItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tabValue => $tab): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php
                        $isActive = $activeTab === $tabValue;
                        $href = request()->fullUrlWithQuery(['tab' => $tabValue, 'page' => 1]);
                    ?>
                    <a
                        href="<?php echo e($href); ?>"
                        class="px-4 py-1.5 rounded-lg text-xs font-bold transition-all <?php echo e($isActive ? 'bg-white text-slate-900 shadow-sm' : 'text-slate-500 hover:text-slate-900'); ?>"
                        aria-current="<?php echo e($isActive ? 'page' : 'false'); ?>"
                    >
                        <?php echo e($tab['label']); ?>

                    </a>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </nav>
        </div>
    <?php endif; ?>

    <?php if($hopdong->isEmpty()): ?>
        <div class="saas-card p-16 text-center border-dashed">
            <div class="mx-auto mb-6 flex h-20 w-20 items-center justify-center rounded-full bg-slate-50 text-slate-400">
                <svg class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
            </div>
            <h3 class="text-xl font-bold text-slate-900 tracking-tight">Chưa có hợp đồng</h3>
            <p class="mt-2 text-sm text-slate-500 max-w-sm mx-auto">Hợp đồng của bạn sẽ hiển thị tại đây sau khi Ban quản lý xác nhận việc xếp phòng.</p>
            <div class="mt-8">
                <div class="text-xs text-slate-500">
                    Các thao tác khác nằm ở thanh điều hướng bên trái.
                </div>
            </div>
        </div>
    <?php elseif($activeTab === 'gia-han' && !$isAlumni): ?>
        <div class="space-y-8">
            <div class="saas-card p-6">
                <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                    <div>
                        <div class="text-sm font-semibold text-slate-900">Thao tác nhanh</div>
                        <div class="mt-0.5 text-xs text-slate-500">Gửi yêu cầu gia hạn hợp đồng cư trú.</div>
                    </div>
                    <div class="flex flex-col gap-2 sm:flex-row sm:items-center">
                        <a href="#form-gia-han" class="saas-btn-primary h-10 px-4 text-xs font-semibold">Gia hạn</a>
                    </div>
                </div>
            </div>

            <?php if($hasActiveContract): ?>
                <?php
                    $trangThaiTraPhong = $yeuCauTraPhong?->trang_thai?->value ?? null;

                    $lyDoTuChoi = null;
                    if ($trangThaiTraPhong === \App\Enums\RegistrationStatus::Rejected->value) {
                        if (is_string($yeuCauTraPhong?->ghi_chu) && \Illuminate\Support\Str::startsWith($yeuCauTraPhong->ghi_chu, 'TRA_PHONG|')) {
                            $lyDoTuChoi = trim((string) \Illuminate\Support\Str::after($yeuCauTraPhong->ghi_chu, 'TRA_PHONG|'));
                        }
                    }
                ?>

                <div class="saas-card p-6 bg-rose-50/30 border-rose-100/60">
                    <div class="flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">
                        <div class="space-y-1">
                            <div class="text-sm font-semibold text-slate-900">Kết thúc hợp đồng</div>
                            <div class="text-xs text-slate-600">Gửi yêu cầu trả phòng, Ban quản lý sẽ xem xét trước khi thanh lý.</div>
                        </div>
                        <button
                            type="button"
                            data-modal-target="modal-traphong"
                            data-modal-toggle="modal-traphong"
                            class="saas-btn-danger h-10 px-4 text-xs font-semibold"
                            <?php if($trangThaiTraPhong === \App\Enums\RegistrationStatus::Pending->value): ?> disabled <?php endif; ?>
                        >
                            Yêu cầu trả phòng
                        </button>
                    </div>

                    <?php if($trangThaiTraPhong === \App\Enums\RegistrationStatus::Pending->value): ?>
                        <div class="mt-4 rounded-xl bg-amber-50 ring-1 ring-amber-100 px-4 py-3 text-sm text-amber-700">
                            Bạn đã gửi yêu cầu trả phòng. Ban quản lý đang xem xét và sẽ phản hồi sau.
                        </div>
                    <?php elseif($trangThaiTraPhong === \App\Enums\RegistrationStatus::Rejected->value): ?>
                        <div class="mt-4 rounded-xl bg-rose-50 ring-1 ring-rose-100 px-4 py-3 text-sm text-rose-700">
                            Yêu cầu trả phòng của bạn đã bị từ chối.
                            <?php if($lyDoTuChoi): ?>
                                <span class="font-semibold">Lý do:</span> <?php echo e($lyDoTuChoi); ?>

                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endif; ?>

            <div class="grid grid-cols-1 md:grid-cols-12 gap-6 items-start">
                <aside class="md:col-span-4 space-y-4">
                    <div class="saas-card p-6 bg-slate-50/50 border-dashed">
                        <div class="text-xs font-semibold text-slate-500">Hợp đồng hiệu lực</div>
                        <?php if($hasActiveContract): ?>
                            <div class="mt-4 space-y-3">
                                <div>
                                    <div class="text-[11px] font-semibold text-slate-500">Mã hợp đồng</div>
                                    <div class="mt-0.5 font-semibold text-slate-900 tabular-nums"><?php echo e($hopdongHieuLuc->ma_hd); ?></div>
                                </div>
                                <div>
                                    <div class="text-[11px] font-semibold text-slate-500">Phòng</div>
                                    <div class="mt-0.5 font-semibold text-slate-900"><?php echo e($hopdongHieuLuc->phong?->tenphong ?? '—'); ?></div>
                                </div>
                                <div>
                                    <div class="text-[11px] font-semibold text-slate-500">Ngày kết thúc hiện tại</div>
                                    <div class="mt-0.5 font-semibold text-slate-900 tabular-nums"><?php echo e($hopdongHieuLuc->ngay_ket_thuc?->format('d/m/Y') ?? '—'); ?></div>
                                </div>
                            </div>
                        <?php else: ?>
                            <div class="mt-3 text-sm text-slate-600">Bạn chưa có hợp đồng hiệu lực để gia hạn.</div>
                        <?php endif; ?>
                    </div>

                    <div class="saas-card p-6 bg-brand-emerald/5 border-brand-emerald/15 flex gap-3">
                        <svg class="h-5 w-5 shrink-0 text-brand-emerald" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <p class="text-sm text-slate-700">
                            Yêu cầu gia hạn sẽ được Ban quản lý xét duyệt. Kết quả sẽ được thông báo khi xử lý xong.
                        </p>
                    </div>
                </aside>

                <main class="md:col-span-8 space-y-6">
                    <article id="form-gia-han" class="saas-card p-8">
                        <div class="text-sm font-semibold text-slate-900">Gửi yêu cầu gia hạn</div>
                        <div class="mt-1 text-xs text-slate-500">Chọn ngày kết thúc mới và gửi để Ban quản lý phê duyệt.</div>

                        <?php
                            $ngayKetThuc = $hopdongHieuLuc?->ngay_ket_thuc;
                            if (is_string($ngayKetThuc)) {
                                $ngayKetThuc = \Illuminate\Support\Carbon::parse($ngayKetThuc);
                            }
                            $goiMacDinh = (int) (old('goi_thang') ?: 5);
                            if (!in_array($goiMacDinh, [3, 5, 6, 12], true)) {
                                $goiMacDinh = 5;
                            }
                            $ngayMacDinh = $ngayKetThuc?->copy()->addMonths($goiMacDinh) ?? now()->addMonths($goiMacDinh);
                        ?>

                        <form action="<?php echo e(route('student.giahan.store')); ?>" method="POST" class="mt-6 space-y-6" <?php if(!$hasActiveContract): ?> data-no-loading="true" <?php endif; ?>>
                            <?php echo csrf_field(); ?>
                            <input type="hidden" name="hopdong_id" value="<?php echo e($hopdongHieuLuc?->id); ?>">

                            <div class="space-y-2">
                                <div class="grid gap-4 sm:grid-cols-2">
                                    <div class="space-y-1">
                                        <label for="goi_thang" class="saas-label">Gói gia hạn</label>
                                        <select
                                            id="goi_thang"
                                            name="goi_thang"
                                            class="saas-input h-11 font-semibold"
                                            <?php if(!$hasActiveContract): ?> disabled <?php else: ?> required <?php endif; ?>
                                        >
                                            <option value="3" <?php if($goiMacDinh === 3): echo 'selected'; endif; ?>>3 tháng</option>
                                            <option value="5" <?php if($goiMacDinh === 5): echo 'selected'; endif; ?>>5 tháng (01 học kỳ)</option>
                                            <option value="6" <?php if($goiMacDinh === 6): echo 'selected'; endif; ?>>6 tháng</option>
                                            <option value="12" <?php if($goiMacDinh === 12): echo 'selected'; endif; ?>>12 tháng</option>
                                        </select>
                                    </div>

                                    <div class="space-y-1">
                                        <label for="ngay_ket_thuc_moi_preview" class="saas-label">Ngày kết thúc mới</label>
                                        <input
                                            type="date"
                                            id="ngay_ket_thuc_moi_preview"
                                            value="<?php echo e(old('ngay_ket_thuc_moi', $ngayMacDinh->format('Y-m-d'))); ?>"
                                            class="saas-input h-11 font-semibold tabular-nums"
                                            disabled
                                        >
                                    </div>
                                </div>
                                <input
                                    type="hidden"
                                    name="ngay_ket_thuc_moi"
                                    id="ngay_ket_thuc_moi"
                                    value="<?php echo e(old('ngay_ket_thuc_moi', $ngayMacDinh->format('Y-m-d'))); ?>"
                                >
                                <div class="text-xs text-slate-500">Hệ thống sẽ tự tính ngày kết thúc theo gói bạn chọn.</div>
                            </div>

                            <div class="space-y-2">
                                <label for="ly_do" class="saas-label">Lý do (tuỳ chọn)</label>
                                <textarea
                                    name="ly_do"
                                    id="ly_do"
                                    rows="4"
                                    class="saas-input p-3 text-sm"
                                    placeholder="Ví dụ: tiếp tục học tập kỳ tiếp theo..."
                                    <?php if(!$hasActiveContract): ?> disabled <?php endif; ?>
                                ><?php echo e(old('ly_do')); ?></textarea>
                            </div>

                            <div class="flex items-center justify-end gap-3 pt-2">
                                <a href="<?php echo e(route('student.hopdong.index', ['tab' => 'hopdong'])); ?>" class="saas-btn-secondary h-10 px-4 text-xs font-semibold">Quay lại</a>
                                <button type="submit" class="saas-btn-primary h-10 px-4 text-xs font-semibold" data-loading-text="Đang gửi..." <?php if(!$hasActiveContract): ?> disabled <?php endif; ?>>
                                    Gửi yêu cầu
                                </button>
                            </div>
                        </form>
                        
                        <script>
                            document.addEventListener('DOMContentLoaded', function () {
                                const select = document.getElementById('goi_thang');
                                const hidden = document.getElementById('ngay_ket_thuc_moi');
                                const preview = document.getElementById('ngay_ket_thuc_moi_preview');
                                if (!select || !hidden || !preview) return;

                                const base = <?php echo \Illuminate\Support\Js::from(($ngayKetThuc?->format('Y-m-d')) ?: now()->format('Y-m-d'))->toHtml() ?>;

                                function addMonths(baseDate, months) {
                                    const parts = baseDate.split('-').map(Number);
                                    const year = parts[0], month = parts[1] - 1, day = parts[2];
                                    const d = new Date(Date.UTC(year, month, day));
                                    const targetMonth = d.getUTCMonth() + months;
                                    d.setUTCMonth(targetMonth);
                                    if (d.getUTCMonth() !== ((targetMonth % 12) + 12) % 12) {
                                        d.setUTCDate(0);
                                    }
                                    const yyyy = d.getUTCFullYear();
                                    const mm = String(d.getUTCMonth() + 1).padStart(2, '0');
                                    const dd = String(d.getUTCDate()).padStart(2, '0');
                                    return `${yyyy}-${mm}-${dd}`;
                                }

                                function sync() {
                                    const months = parseInt(select.value || '5', 10);
                                    const next = addMonths(base, months);
                                    hidden.value = next;
                                    preview.value = next;
                                }

                                select.addEventListener('change', sync);
                                sync();
                            });
                        </script>
                    </article>

                    <article class="saas-card overflow-hidden">
                        <div class="px-6 py-5 border-b border-slate-100 bg-slate-50/30">
                            <div class="text-sm font-semibold text-slate-900">Lịch sử yêu cầu gia hạn</div>
                            <div class="mt-0.5 text-xs text-slate-500">Theo dõi trạng thái xử lý các yêu cầu trước đó.</div>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="saas-table">
                                <thead>
                                    <tr>
                                        <th>Hợp đồng</th>
                                        <th class="text-center">Ngày mong muốn</th>
                                        <th class="text-center">Trạng thái</th>
                                        <th>Lý do</th>
                                        <th class="text-right">Ghi chú</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if($yeuCauGiaHan && $yeuCauGiaHan->count() > 0): ?>
                                        <?php $__currentLoopData = $yeuCauGiaHan; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <?php
                                                $status = $item->trang_thai->value;
                                                $badgeClass = match($status) {
                                                    'pending' => 'saas-badge-warning',
                                                    'approved' => 'saas-badge-success',
                                                    'rejected' => 'saas-badge-error',
                                                    default => 'saas-badge-info',
                                                };
                                            ?>
                                            <tr>
                                                <td>
                                                    <div class="font-semibold text-slate-900 tabular-nums"><?php echo e($item->hopdong?->ma_hd ?? '—'); ?></div>
                                                    <div class="mt-0.5 text-xs text-slate-500"><?php echo e($item->hopdong?->phong?->tenphong ?? '—'); ?></div>
                                                </td>
                                                <td class="text-center">
                                                    <span class="text-xs font-semibold text-slate-700 tabular-nums"><?php echo e($item->ngay_ket_thuc_moi?->format('d/m/Y') ?? '—'); ?></span>
                                                </td>
                                                <td class="text-center">
                                                    <span class="saas-badge <?php echo e($badgeClass); ?>"><?php echo e($item->trang_thai->label()); ?></span>
                                                </td>
                                                <td class="text-slate-600">
                                                    <div class="text-sm"><?php echo e($item->ly_do ?: '—'); ?></div>
                                                </td>
                                                <td class="text-right text-slate-600">
                                                    <div class="text-sm"><?php echo e($item->ghi_chu_admin ?: '—'); ?></div>
                                                </td>
                                            </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="5" class="py-14 text-center text-slate-500">
                                                Chưa có yêu cầu gia hạn nào.
                                            </td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                        <?php if($yeuCauGiaHan && method_exists($yeuCauGiaHan, 'links')): ?>
                            <div class="px-6 py-4 border-t border-slate-200">
                                <?php echo e($yeuCauGiaHan->links()); ?>

                            </div>
                        <?php endif; ?>
                    </article>
                </main>
            </div>
            
            <?php $__env->startPush('modals'); ?>
                <?php if (isset($component)) { $__componentOriginal9f64f32e90b9102968f2bc548315018c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9f64f32e90b9102968f2bc548315018c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.modal','data' => ['id' => 'modal-traphong','title' => 'Yêu cầu trả phòng','subtitle' => 'Nhập lý do trả phòng để Ban quản lý xem xét trước khi thanh lý hợp đồng.']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('modal'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['id' => 'modal-traphong','title' => 'Yêu cầu trả phòng','subtitle' => 'Nhập lý do trả phòng để Ban quản lý xem xét trước khi thanh lý hợp đồng.']); ?>
                    <form action="<?php echo e(route('student.yeucautraphong')); ?>" method="POST" class="space-y-6" onsubmit="return confirm('Gửi yêu cầu trả phòng? Ban quản lý sẽ xem xét trước khi thực hiện thanh lý.')">
                        <?php echo csrf_field(); ?>
                        <div class="space-y-2">
                            <label for="ly_do_traphong" class="saas-label">Lý do trả phòng</label>
                            <textarea
                                name="ly_do"
                                id="ly_do_traphong"
                                rows="4"
                                class="saas-input p-3 text-sm"
                                placeholder="Ví dụ: đã hoàn tất học kỳ, chuyển nơi ở..."
                                required
                            ><?php echo e(old('ly_do')); ?></textarea>
                            <div class="text-xs text-slate-500">Vui lòng mô tả ngắn gọn để hỗ trợ xét duyệt.</div>
                        </div>

                        <div class="flex gap-3 pt-4">
                            <button type="button" data-modal-hide="modal-traphong" class="saas-btn-secondary flex-1 h-11">Hủy</button>
                            <button type="submit" class="saas-btn-danger flex-[2] h-11">Gửi yêu cầu</button>
                        </div>
                    </form>
                 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal9f64f32e90b9102968f2bc548315018c)): ?>
<?php $attributes = $__attributesOriginal9f64f32e90b9102968f2bc548315018c; ?>
<?php unset($__attributesOriginal9f64f32e90b9102968f2bc548315018c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9f64f32e90b9102968f2bc548315018c)): ?>
<?php $component = $__componentOriginal9f64f32e90b9102968f2bc548315018c; ?>
<?php unset($__componentOriginal9f64f32e90b9102968f2bc548315018c); ?>
<?php endif; ?>
            <?php $__env->stopPush(); ?>
        </div>
    <?php else: ?>
        <div class="saas-card overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm text-slate-900">
                    <thead class="bg-slate-50 border-b border-slate-100 text-[10px] font-bold uppercase tracking-widest text-slate-400">
                        <tr>
                            <th class="px-6 py-4">Mã hợp đồng</th>
                            <th class="px-6 py-4">Phòng ở</th>
                            <th class="px-6 py-4">Thời hạn cư trú</th>
                            <th class="px-6 py-4 text-right">Giá ký kết</th>
                            <th class="px-6 py-4 text-center">Trạng thái</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        <?php $__currentLoopData = $hopdong; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr class="hover:bg-slate-50/50 transition-colors">
                                <td class="px-6 py-4">
                                    <div class="text-sm font-bold text-slate-900 tabular-nums tracking-tight"><?php echo e($item->ma_hd); ?></div>
                                    <div class="text-[10px] font-bold text-slate-500 uppercase tracking-widest mt-1">Năm học <?php echo e(date('Y', strtotime($item->ngay_bat_dau))); ?>-<?php echo e(date('Y', strtotime($item->ngay_ket_thuc))); ?></div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-brand-emerald/10 text-brand-emerald ring-1 ring-brand-emerald/20">
                                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                                        </div>
                                        <div>
                                            <div class="font-bold text-slate-900 text-sm uppercase tracking-tight"><?php echo e($item->phong->tenphong ?? 'Chưa xác định'); ?></div>
                                            <div class="text-[10px] font-bold text-slate-500 uppercase tracking-widest mt-0.5"><?php echo e($item->phong->toa ?? 'Chưa có'); ?> • Tầng <?php echo e($item->phong->tang ?? 'Chưa có'); ?></div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-4">
                                        <div class="space-y-0.5">
                                            <div class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Từ ngày</div>
                                            <div class="font-bold text-slate-900 tabular-nums text-xs"><?php echo e(date('d/m/Y', strtotime($item->ngay_bat_dau))); ?></div>
                                        </div>
                                        <svg class="h-4 w-4 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                                        <div class="space-y-0.5">
                                            <div class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Đến ngày</div>
                                            <div class="font-bold text-slate-900 tabular-nums text-xs"><?php echo e(date('d/m/Y', strtotime($item->ngay_ket_thuc))); ?></div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <div class="text-sm font-bold text-slate-900 tabular-nums tracking-tight"><?php echo e(number_format($item->gia_thuc_te)); ?>đ</div>
                                    <div class="text-[10px] font-bold text-slate-500 uppercase tracking-widest">/ tháng</div>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <?php
                                        $statusValue = $item->trang_thai instanceof \App\Enums\ContractStatus
                                            ? $item->trang_thai->value
                                            : (string) $item->trang_thai;

                                        $statusLabel = $item->trang_thai instanceof \App\Enums\ContractStatus
                                            ? $item->trang_thai->label()
                                            : (\App\Enums\ContractStatus::tryFrom($statusValue)?->label() ?? 'Không xác định');

                                        $badgeClass = match ($statusValue) {
                                            \App\Enums\ContractStatus::Active->value => 'saas-badge-success',
                                            \App\Enums\ContractStatus::Expired->value => 'saas-badge-warning',
                                            \App\Enums\ContractStatus::Terminated->value => 'saas-badge-error',
                                            default => 'saas-badge-secondary',
                                        };
                                    ?>
                                    <span class="saas-badge <?php echo e($badgeClass); ?>">
                                        <?php echo e($statusLabel); ?>

                                    </span>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>
        </div>
    <?php endif; ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('student.layouts.chinh', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\laragon\www\hethongquanlyktxv1\resources\views/student/hopdong/index.blade.php ENDPATH**/ ?>