<?php $__env->startSection('student_page_title', 'Danh sách phòng trống'); ?>

<?php $__env->startSection('noidung'); ?>
    <div class="mb-6 saas-card p-5 bg-slate-50/50 border-dashed">
        <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <div class="text-sm font-semibold text-slate-900">Chọn phòng và gửi đăng ký</div>
                <div class="mt-0.5 text-xs text-slate-500">Sau khi gửi, Ban quản lý sẽ xét duyệt trước khi xếp phòng cho bạn.</div>
            </div>
            <a href="<?php echo e(route('student.phongcuatoi')); ?>" class="saas-btn-secondary h-10 px-4 text-xs font-semibold w-fit">Trạng thái đăng ký</a>
        </div>
    </div>

    <div class="mb-6 flex justify-end">
        <form method="GET" action="<?php echo e(route('student.phong.index')); ?>" class="relative group w-full md:w-72">
            <input name="q" value="<?php echo e(request('q')); ?>" type="text" placeholder="Tìm theo tên phòng..."
                   class="saas-input pl-10" />
            <div class="absolute left-3 top-1/2 -translate-y-1/2 text-slate-400">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            </div>
            <button type="submit" class="hidden">Tìm</button>
        </form>
    </div>

    <div class="saas-card overflow-hidden border-dashed">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-slate-900">
                <thead class="bg-slate-50 border-b border-slate-100 text-[10px] font-bold uppercase tracking-widest text-slate-400">
                    <tr>
                        <th class="px-6 py-4">Thông tin phòng</th>
                        <th class="px-6 py-4">Khu vực / Tòa</th>
                        <th class="px-6 py-4 text-right">Đơn giá / tháng</th>
                        <th class="px-6 py-4 text-center">Tình trạng</th>
                        <th class="px-6 py-4 text-right">Thao tác</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    <?php $__empty_1 = true; $__currentLoopData = $danhsachphong; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $phong): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <?php
                            $soNguoiDangO = (int) ($phong->so_giuong_da_o ?? ($soluongdango_theophong[$phong->id] ?? 0));
                            $sucChua = (int) ($phong->loaiphong?->suc_chua ?? 0);
                            $soChoConLai = (int) ($phong->so_giuong_trong ?? max($sucChua - $soNguoiDangO, 0));
                            $gioiTinhHanChe = $phong->gioi_tinh_han_che?->value ?? null;
                            $labelGioiTinh = match ($gioiTinhHanChe) {
                                'male' => 'Dành cho Nam',
                                'female' => 'Dành cho Nữ',
                                default => 'Phù hợp mọi giới tính',
                            };
                            $badgeClass = $soChoConLai > 0 ? 'saas-badge-success' : 'saas-badge-error';
                            $thietBiOnDinh = true;
                            $taiSanPreview = $phong->taisans?->take(2) ?? collect();
                        ?>
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <td class="px-6 py-4">
                                <div class="text-sm font-bold text-slate-900 uppercase tracking-tight"><?php echo e($phong->ten_phong); ?></div>
                                <div class="text-[10px] font-bold text-slate-500 uppercase tracking-widest mt-1 flex items-center gap-1.5">
                                    <svg class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                    <?php echo e($labelGioiTinh); ?>

                                </div>
                                <div class="text-[10px] font-bold text-slate-500 uppercase tracking-widest mt-1 flex items-center gap-1.5">
                                    <svg class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M7 7h10M7 12h10M7 17h10"/></svg>
                                    <?php echo e($phong->loaiphong?->ten_loai ?? 'Không có'); ?>

                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-xs font-bold text-slate-900 uppercase tracking-tight"><?php echo e($phong->toanha?->ten_toa_nha ?? 'Không có'); ?></div>
                                <div class="text-[10px] font-bold text-slate-500 uppercase tracking-widest mt-1">Tầng <?php echo e($phong->tang); ?></div>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <?php
                                    $donGiaThang = (int) (($phong->loaiphong?->gia_thang ?? null) ?? ($phong->giaphong ?? 0));
                                ?>
                                <div class="text-xs font-bold text-slate-900 tabular-nums"><?php echo e(number_format($donGiaThang)); ?>đ</div>
                                <div class="mt-1 text-[10px] font-bold uppercase tracking-widest text-slate-400">/ tháng</div>
                            </td>
                            <td class="px-6 py-4 text-center space-y-2">
                                <div>
                                    <span class="saas-badge <?php echo e($badgeClass); ?>">
                                        <?php echo e($soChoConLai); ?> giường trống
                                    </span>
                                </div>
                                <div class="text-[10px] font-bold text-slate-500 uppercase tracking-widest tabular-nums">
                                    <?php echo e($soNguoiDangO); ?>/<?php echo e($sucChua); ?> Đang ở
                                </div>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="inline-flex items-center justify-end gap-2">
                                    <button
                                        type="button"
                                        data-modal-target="modal-taisan-<?php echo e($phong->id); ?>"
                                        data-modal-toggle="modal-taisan-<?php echo e($phong->id); ?>"
                                        class="h-9 w-9 inline-flex items-center justify-center text-slate-400 hover:text-brand-emerald hover:bg-brand-emerald/10 border border-transparent hover:border-brand-emerald/20 rounded-xl transition-all shadow-sm hover:shadow-md"
                                        title="Tài sản trong phòng"
                                    >
                                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 7h16M4 12h16M4 17h16"/></svg>
                                    </button>
                                    <form method="POST" action="<?php echo e(route('student.dangkyphong')); ?>" class="form-dangky">
                                        <?php echo csrf_field(); ?>
                                        <input type="hidden" name="phong_id" value="<?php echo e($phong->id); ?>">
                                        <button type="submit"
                                                class="saas-btn-primary h-9 px-4 disabled:opacity-50 disabled:cursor-not-allowed text-[10px]">
                                            <span class="btn-content">Gửi đăng ký</span>
                                            <span class="btn-loader hidden">
                                                <svg class="h-3 w-3 animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                                            </span>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center">
                                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Hiện tại không có phòng nào trống phù hợp với yêu cầu của bạn.</p>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
    
    <?php if(method_exists($danhsachphong, 'links')): ?>
        <div class="mt-6">
            <?php echo e($danhsachphong->links()); ?>

        </div>
    <?php endif; ?>

    <?php if(isset($danhsachphongsaptrong) && $danhsachphongsaptrong->count() > 0): ?>
        <div class="mt-10">
            <div class="mb-4">
                <h3 class="text-sm font-bold text-slate-900 tracking-tight">Phòng sắp có chỗ trống</h3>
                <p class="text-xs font-medium text-slate-500 mt-1">Danh sách phòng hiện đang kín chỗ nhưng có hợp đồng sắp kết thúc trong 30 ngày tới.</p>
            </div>

            <div class="saas-card overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm text-slate-900">
                        <thead class="bg-slate-50 border-b border-slate-100 text-[10px] font-bold uppercase tracking-widest text-slate-400">
                            <tr>
                                <th class="px-6 py-4">Phòng</th>
                                <th class="px-6 py-4">Tòa</th>
                                <th class="px-6 py-4">Dự kiến trống</th>
                                <th class="px-6 py-4 text-right">Tài sản</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            <?php $__currentLoopData = $danhsachphongsaptrong; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $phong): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php
                                    $sapTrongDate = $phong->ngay_trong_som_nhat instanceof \Illuminate\Support\Carbon
                                        ? $phong->ngay_trong_som_nhat->format('d/m/Y')
                                        : 'Chưa có';
                                    $soGiuongSapTrong = (int) ($phong->so_giuong_sap_trong ?? 0);
                                    $taiSanPreview = $phong->taisans?->take(2) ?? collect();
                                ?>
                                <tr class="hover:bg-slate-50/50 transition-colors">
                                    <td class="px-6 py-4">
                                        <div class="text-sm font-bold text-slate-900 uppercase tracking-tight"><?php echo e($phong->ten_phong); ?></div>
                                        <div class="text-[10px] font-bold text-slate-500 uppercase tracking-widest mt-1"><?php echo e($phong->loaiphong?->ten_loai ?? 'Không có'); ?></div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-xs font-bold text-slate-900 uppercase tracking-tight"><?php echo e($phong->toanha?->ten_toa_nha ?? 'Không có'); ?></div>
                                        <div class="text-[10px] font-bold text-slate-500 uppercase tracking-widest mt-1">Tầng <?php echo e($phong->tang); ?></div>
                                    </td>
                                    <td class="px-6 py-4 space-y-2">
                                        <div>
                                            <span class="saas-badge saas-badge-warning">
                                                <?php echo e($sapTrongDate); ?>

                                            </span>
                                        </div>
                                        <div class="text-[10px] font-bold text-slate-500 uppercase tracking-widest tabular-nums"><?php echo e($soGiuongSapTrong); ?> giường</div>
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <div class="space-y-1">
                                            <?php $__currentLoopData = $taiSanPreview; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ts): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <div class="text-[10px] font-medium text-slate-600 truncate" title="<?php echo e($ts->tentaisan); ?>"><?php echo e($ts->tentaisan); ?> × <?php echo e($ts->soluong); ?></div>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </div>
                                        <div class="mt-2">
                                            <button
                                                type="button"
                                                data-modal-target="modal-taisan-<?php echo e($phong->id); ?>"
                                                data-modal-toggle="modal-taisan-<?php echo e($phong->id); ?>"
                                                class="saas-btn-secondary h-9 px-3 text-xs font-semibold"
                                            >
                                                Xem chi tiết
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <?php $__env->startPush('modals'); ?>
        <?php
            $modalRoomIds = [];
        ?>

        <?php $__currentLoopData = $danhsachphong; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $phong): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php
                if (in_array($phong->id, $modalRoomIds, true)) {
                    continue;
                }
                $modalRoomIds[] = $phong->id;

                $donGiaThang = (int) (($phong->loaiphong?->gia_thang ?? null) ?? ($phong->giaphong ?? 0));
                $taiSanAll = $phong->taisans ?? collect();
            ?>

            <?php if (isset($component)) { $__componentOriginal9f64f32e90b9102968f2bc548315018c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9f64f32e90b9102968f2bc548315018c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.modal','data' => ['id' => 'modal-taisan-'.e($phong->id).'','title' => 'Tài sản phòng '.e($phong->ten_phong).'','subtitle' => ''.e(($phong->toanha?->ten_toa_nha ?? 'Không có tòa') . ' • Tầng ' . ($phong->tang ?? '—') . ' • ' . number_format($donGiaThang) . 'đ/tháng').'']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('modal'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['id' => 'modal-taisan-'.e($phong->id).'','title' => 'Tài sản phòng '.e($phong->ten_phong).'','subtitle' => ''.e(($phong->toanha?->ten_toa_nha ?? 'Không có tòa') . ' • Tầng ' . ($phong->tang ?? '—') . ' • ' . number_format($donGiaThang) . 'đ/tháng').'']); ?>
                <div class="space-y-3">
                    <div class="flex items-center justify-between">
                        <div class="text-sm font-semibold text-slate-900">Tài sản</div>
                        <span class="saas-badge bg-slate-100 text-slate-600 !py-0.5 !px-2 text-[10px]"><?php echo e($taiSanAll->count()); ?></span>
                    </div>
                    <div class="rounded-xl ring-1 ring-slate-200/60 bg-slate-50/50 overflow-hidden">
                        <?php if($taiSanAll->count() > 0): ?>
                            <div class="divide-y divide-slate-200/60">
                                <?php $__currentLoopData = $taiSanAll; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ts): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="px-4 py-3 flex items-start justify-between gap-3">
                                        <div class="min-w-0">
                                            <div class="text-sm font-medium text-slate-900 truncate" title="<?php echo e($ts->tentaisan); ?>"><?php echo e($ts->tentaisan); ?></div>
                                            <?php if(!empty($ts->ma_tai_san)): ?>
                                                <div class="mt-0.5 text-xs text-slate-500 tabular-nums"><?php echo e($ts->ma_tai_san); ?></div>
                                            <?php endif; ?>
                                        </div>
                                        <div class="shrink-0 text-sm font-semibold text-slate-700 tabular-nums">× <?php echo e($ts->soluong); ?></div>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        <?php else: ?>
                            <div class="px-4 py-10 text-center text-sm text-slate-500">Chưa có tài sản được ghi nhận.</div>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="mt-6 flex justify-end">
                    <button type="button" data-modal-hide="modal-taisan-<?php echo e($phong->id); ?>" class="saas-btn-secondary h-10 px-4 text-xs font-semibold">Đóng</button>
                </div>
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
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

        <?php if(isset($danhsachphongsaptrong)): ?>
            <?php $__currentLoopData = $danhsachphongsaptrong; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $phong): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php
                    if (in_array($phong->id, $modalRoomIds, true)) {
                        continue;
                    }
                    $modalRoomIds[] = $phong->id;

                    $donGiaThang = (int) (($phong->loaiphong?->gia_thang ?? null) ?? ($phong->giaphong ?? 0));
                    $taiSanAll = $phong->taisans ?? collect();
                ?>

                <?php if (isset($component)) { $__componentOriginal9f64f32e90b9102968f2bc548315018c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9f64f32e90b9102968f2bc548315018c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.modal','data' => ['id' => 'modal-taisan-'.e($phong->id).'','title' => 'Tài sản phòng '.e($phong->ten_phong).'','subtitle' => ''.e(($phong->toanha?->ten_toa_nha ?? 'Không có tòa') . ' • Tầng ' . ($phong->tang ?? '—') . ' • ' . number_format($donGiaThang) . 'đ/tháng').'']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('modal'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['id' => 'modal-taisan-'.e($phong->id).'','title' => 'Tài sản phòng '.e($phong->ten_phong).'','subtitle' => ''.e(($phong->toanha?->ten_toa_nha ?? 'Không có tòa') . ' • Tầng ' . ($phong->tang ?? '—') . ' • ' . number_format($donGiaThang) . 'đ/tháng').'']); ?>
                    <div class="space-y-3">
                        <div class="flex items-center justify-between">
                            <div class="text-sm font-semibold text-slate-900">Tài sản</div>
                            <span class="saas-badge bg-slate-100 text-slate-600 !py-0.5 !px-2 text-[10px]"><?php echo e($taiSanAll->count()); ?></span>
                        </div>
                        <div class="rounded-xl ring-1 ring-slate-200/60 bg-slate-50/50 overflow-hidden">
                            <?php if($taiSanAll->count() > 0): ?>
                                <div class="divide-y divide-slate-200/60">
                                    <?php $__currentLoopData = $taiSanAll; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ts): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <div class="px-4 py-3 flex items-start justify-between gap-3">
                                            <div class="min-w-0">
                                                <div class="text-sm font-medium text-slate-900 truncate" title="<?php echo e($ts->tentaisan); ?>"><?php echo e($ts->tentaisan); ?></div>
                                                <?php if(!empty($ts->ma_tai_san)): ?>
                                                    <div class="mt-0.5 text-xs text-slate-500 tabular-nums"><?php echo e($ts->ma_tai_san); ?></div>
                                                <?php endif; ?>
                                            </div>
                                            <div class="shrink-0 text-sm font-semibold text-slate-700 tabular-nums">× <?php echo e($ts->soluong); ?></div>
                                        </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>
                            <?php else: ?>
                                <div class="px-4 py-10 text-center text-sm text-slate-500">Chưa có tài sản được ghi nhận.</div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="mt-6 flex justify-end">
                        <button type="button" data-modal-hide="modal-taisan-<?php echo e($phong->id); ?>" class="saas-btn-secondary h-10 px-4 text-xs font-semibold">Đóng</button>
                    </div>
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
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <?php endif; ?>
    <?php $__env->stopPush(); ?>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const forms = document.querySelectorAll('.form-dangky');
            forms.forEach(form => {
                form.addEventListener('submit', function() {
                    const btn = this.querySelector('button[type="submit"]');
                    const content = btn.querySelector('.btn-content');
                    const loader = btn.querySelector('.btn-loader');
                    
                    btn.disabled = true;
                    content.innerText = 'Đang gửi...';
                    loader.classList.remove('hidden');
                });
            });
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('student.layouts.chinh', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\laragon\www\hethongquanlyktxv1\resources\views/student/phong/danhsach.blade.php ENDPATH**/ ?>