<?php if (isset($component)) { $__componentOriginal61b7c119be9b054fc3033ecd71de14c0 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal61b7c119be9b054fc3033ecd71de14c0 = $attributes; } ?>
<?php $component = App\View\Components\LandingLayout::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('landing-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(App\View\Components\LandingLayout::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
     <?php $__env->slot('title', null, []); ?> Danh sách phòng KTX <?php $__env->endSlot(); ?>

    <section class="pt-36 pb-20 lg:pt-44 lg:pb-28 bg-[#fafafa] relative overflow-hidden min-h-screen">
        <!-- Minimal Dot Grid -->
        <div class="absolute inset-0 opacity-100 bg-[radial-gradient(#d1d5db_1.5px,transparent_1.5px)] [background-size:32px_32px] [mask-image:linear-gradient(to_bottom,white,transparent)] pointer-events-none"></div>
        
        <div class="max-w-[1200px] mx-auto px-6 relative z-10">
            <div class="mb-12 border-b border-ui-border pb-8">
                <p class="text-xs font-bold uppercase tracking-widest text-ink-secondary mb-3">Phòng nội trú</p>
                <h1 class="font-display text-4xl sm:text-5xl font-bold tracking-tight text-ink-primary">Chọn phòng phù hợp với bạn.</h1>
                <p class="mt-4 text-ink-secondary max-w-lg text-lg">Tất cả thông tin phòng được cập nhật theo thời gian thực.</p>
            </div>

            
            <div class="flex flex-wrap gap-3 mb-10">
                <select id="filter-gender" class="bg-white border border-ui-border text-ink-primary text-sm font-bold rounded-none focus:ring-0 focus:border-ink-primary p-3 transition-colors cursor-pointer w-full sm:w-[180px] shadow-sm">
                    <option value="all">Tất cả giới tính</option>
                    <option value="Nam">Phòng Nam</option>
                    <option value="Nữ">Phòng Nữ</option>
                </select>
                <select id="filter-status" class="bg-white border border-ui-border text-ink-primary text-sm font-bold rounded-none focus:ring-0 focus:border-ink-primary p-3 transition-colors cursor-pointer w-full sm:w-[200px] shadow-sm">
                    <option value="all">Tất cả trạng thái</option>
                    <option value="available">Còn trống</option>
                    <option value="full">Đã kín chỗ</option>
                </select>
            </div>

            
            <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-5" id="room-container">
                <?php $__empty_1 = true; $__currentLoopData = $danhsachphong; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $phong): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <?php
                        $dangO = (int) ($soluongdango_theophong[$phong->id] ?? ($phong->so_nguoi_dang_o ?? 0));
                        $conTrong = max(0, $phong->succhuamax - $dangO);
                        $isAvailable = $conTrong > 0;
                        $pct = $phong->succhuamax > 0 ? min(100, ($dangO / $phong->succhuamax) * 100) : 0;
                        $sapTrongDate = $phong->ngay_trong_som_nhat instanceof \Illuminate\Support\Carbon
                            ? $phong->ngay_trong_som_nhat->format('d/m')
                            : null;
                        $soGiuongSapTrong = (int) ($phong->so_giuong_sap_trong ?? 0);
                    ?>
                    <div class="room-card bg-white p-5 border border-ui-border hover:border-ink-primary transition-colors duration-300 flex flex-col group shadow-sm hover:shadow-md"
                         data-gender="<?php echo e($phong->gioitinh); ?>"
                         data-available="<?php echo e($isAvailable ? 'available' : 'full'); ?>"
                         style="display:none;">
                        
                        <div class="flex justify-between items-start mb-5">
                            <div>
                                <h3 class="text-base font-display font-bold text-ink-primary mb-0.5"><?php echo e($phong->tenphong); ?></h3>
                                <p class="text-[10px] font-bold text-ink-secondary uppercase tracking-wider">Tầng <?php echo e($phong->tang); ?> · <?php echo e($phong->gioitinh); ?></p>
                            </div>
                            <span class="px-2 py-0.5 text-[9px] font-bold uppercase tracking-wider border <?php echo e($isAvailable ? 'border-brand-emerald text-brand-emerald bg-brand-emerald/5' : 'border-red-500 text-red-600 bg-red-500/5'); ?>">
                                <?php echo e($isAvailable ? 'Còn '.$conTrong : 'Kín chỗ'); ?>

                            </span>
                        </div>
                        <?php if(!$isAvailable && $sapTrongDate && $soGiuongSapTrong > 0): ?>
                            <div class="mb-5">
                                <span class="inline-flex items-center px-2 py-0.5 text-[9px] font-bold uppercase tracking-wider border border-amber-500/40 bg-amber-50 text-amber-700">
                                    Sắp trống <?php echo e($sapTrongDate); ?> (<?php echo e($soGiuongSapTrong); ?> giường)
                                </span>
                            </div>
                        <?php endif; ?>

                        <div class="mb-6">
                            <div class="flex items-baseline gap-1">
                                <span class="text-xl font-display font-bold text-ink-primary tracking-tight"><?php echo e(number_format($phong->giaphong, 0, ',', '.')); ?></span>
                                <span class="text-xs font-bold text-ink-secondary">đ/tháng</span>
                            </div>
                        </div>

                        <div class="space-y-5 flex-grow">
                            <div>
                                <div class="flex justify-between text-[10px] font-bold text-ink-secondary mb-1.5">
                                    <span>Sức chứa: <?php echo e($phong->succhuamax); ?></span>
                                    <span class="<?php echo e($isAvailable ? 'text-ink-primary' : 'text-red-500'); ?>">Đang ở: <?php echo e($dangO); ?></span>
                                </div>
                                <div class="w-full bg-ui-bg h-1 overflow-hidden">
                                    <div class="h-full transition-all duration-500 ease-out <?php echo e($isAvailable ? 'bg-brand-emerald' : 'bg-red-500'); ?>" style="<?php echo \Illuminate\Support\Arr::toCssStyles(["width: $pct%"]) ?>"></div>
                                </div>
                            </div>
                            <?php
                                $vatTuPreview = $phong->vattus?->take(2) ?? collect();
                                $taiSanPreview = $phong->taisans?->take(1) ?? collect();
                                $tongVatTu = $phong->vattus?->count() ?? 0;
                                $tongTaiSan = $phong->taisans?->count() ?? 0;
                                $tongMucVatTuTaiSan = $tongVatTu + $tongTaiSan;
                                $soMucDangHien = $vatTuPreview->count() + $taiSanPreview->count();
                                $soMucConLai = max(0, $tongMucVatTuTaiSan - $soMucDangHien);
                            ?>
                            <div class="flex flex-wrap gap-1.5">
                                <?php if($tongMucVatTuTaiSan > 0): ?>
                                    <?php $__currentLoopData = $vatTuPreview; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $vt): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <span class="inline-flex items-center gap-1.5 px-1.5 py-0.5 bg-ui-bg text-ink-primary text-[10px] font-medium border border-ui-border truncate max-w-full" title="<?php echo e($vt->tenvattu); ?>">
                                            <?php echo e($vt->tenvattu); ?> <span class="opacity-60">× <?php echo e($vt->soluong); ?></span>
                                        </span>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php $__currentLoopData = $taiSanPreview; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ts): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <span class="inline-flex items-center gap-1.5 px-1.5 py-0.5 bg-ui-bg text-ink-primary text-[10px] font-medium border border-ui-border truncate max-w-full" title="<?php echo e($ts->tentaisan); ?>">
                                            <?php echo e($ts->tentaisan); ?> <span class="opacity-60">× <?php echo e($ts->soluong); ?></span>
                                        </span>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php if($soMucConLai > 0): ?>
                                        <span class="inline-flex items-center px-1.5 py-0.5 bg-ui-card text-ink-secondary text-[10px] font-bold border border-ui-border">
                                            +<?php echo e($soMucConLai); ?>

                                        </span>
                                    <?php endif; ?>
                                <?php else: ?>
                                    <span class="inline-flex items-center px-1.5 py-0.5 bg-ui-bg text-ink-secondary text-[10px] font-medium border border-ui-border">
                                        Chưa cập nhật vật tư
                                    </span>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="mt-5 pt-4 border-t border-ui-border">
                            <a href="<?php echo e(route('public.chitietvattu', $phong->id)); ?>" class="w-full mb-2 bg-ui-bg text-ink-primary hover:bg-ui-border py-2.5 text-[11px] font-bold tracking-wide transition-colors flex items-center justify-center gap-2 uppercase border border-ui-border">
                                Xem vật tư
                            </a>
                            <?php if($isAvailable): ?>
                                <a href="<?php echo e(route('guest.dangky.create', ['phong_id' => $phong->id])); ?>" class="w-full bg-ink-primary text-white hover:bg-brand-emerald py-2.5 text-[11px] font-bold tracking-wide transition-colors flex items-center justify-center gap-2 group-hover:gap-3 uppercase">
                                    Đăng ký <span class="transition-all">→</span>
                                </a>
                            <?php else: ?>
                                <button disabled class="w-full bg-ui-bg text-ink-secondary py-2.5 text-[11px] font-bold tracking-wide cursor-not-allowed border border-ui-border uppercase">
                                    Đã kín chỗ
                                </button>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <div class="col-span-full text-center py-20 bg-white border border-ui-border shadow-sm">
                        <div class="text-3xl mb-4 opacity-50">🏢</div>
                        <h3 class="text-lg font-bold text-ink-primary mb-2 font-display">Chưa có dữ liệu phòng</h3>
                        <p class="text-sm text-ink-secondary">Vui lòng quay lại sau hoặc thử lại với bộ lọc khác.</p>
                    </div>
                <?php endif; ?>
            </div>
            <div id="pagination-controls" class="mt-12 flex justify-center gap-2"></div>
        </div>
    </section>

    <script>
    document.addEventListener('DOMContentLoaded', function () {
        const fG = document.getElementById('filter-gender'), fS = document.getElementById('filter-status');
        const cards = Array.from(document.querySelectorAll('.room-card')), pagC = document.getElementById('pagination-controls');
        let page = 1, perPage = 9, filtered = [];

        function render() {
            if (!pagC) return; pagC.innerHTML = '';
            const total = Math.ceil(filtered.length / perPage);
            if (total <= 1) return;
            for (let i = 1; i <= total; i++) {
                const b = document.createElement('button'); b.innerText = i;
                b.className = `w-9 h-9 rounded-full font-bold text-sm flex items-center justify-center transition-colors ${i===page?'bg-brand-emerald text-slate-100':'bg-ui-card border border-ui-border text-ink-secondary hover:bg-ui-muted'}`;
                b.onclick = () => { page = i; update(); window.scrollTo({top:0,behavior:'smooth'}); };
                pagC.appendChild(b);
            }
        }
        function update() {
            cards.forEach(c => c.style.display = 'none');
            filtered.slice((page-1)*perPage, page*perPage).forEach(c => { c.style.display='flex'; c.style.animation='none'; void c.offsetWidth; c.style.animation='sweep .35s ease-out forwards'; });
            render();
        }
        function filter() {
            const g = fG.value, s = fS.value;
            filtered = cards.filter(c => (g==='all'||g===c.dataset.gender) && (s==='all'||s===c.dataset.available));
            page = 1; update();
        }
        if (fG && fS && cards.length) { fG.addEventListener('change', filter); fS.addEventListener('change', filter); filter(); }
    });
    </script>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal61b7c119be9b054fc3033ecd71de14c0)): ?>
<?php $attributes = $__attributesOriginal61b7c119be9b054fc3033ecd71de14c0; ?>
<?php unset($__attributesOriginal61b7c119be9b054fc3033ecd71de14c0); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal61b7c119be9b054fc3033ecd71de14c0)): ?>
<?php $component = $__componentOriginal61b7c119be9b054fc3033ecd71de14c0; ?>
<?php unset($__componentOriginal61b7c119be9b054fc3033ecd71de14c0); ?>
<?php endif; ?>
<?php /**PATH D:\laragon\www\hethongquanlyktxv1\resources\views/landing/phong/danhsach.blade.php ENDPATH**/ ?>