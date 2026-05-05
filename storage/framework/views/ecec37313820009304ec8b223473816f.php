<?php $__env->startSection('student_page_title', 'Bảng điều khiển'); ?>

<?php $__env->startSection('noidung'); ?>
    <?php
        $tongTienCanDong = (int) $hoadonchuathanhtoan->sum('tong_tien');
        $tongThanhVien = (isset($thanhviencungphong) ? $thanhviencungphong->count() : 0) + ($sinhvien ? 1 : 0);
        $hoaDonGanNhat = $hoadonchuathanhtoan->take(3);
    ?>

    <div class="space-y-8">
        <?php if (isset($component)) { $__componentOriginalcb19cb35a534439097b02b8af91726ee = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalcb19cb35a534439097b02b8af91726ee = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.page-header','data' => ['title' => 'Tổng quan cư dân','subtitle' => 'Theo dõi trạng thái cư trú, hóa đơn và các thông báo mới nhất từ Ban quản lý.']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('admin.page-header'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Tổng quan cư dân','subtitle' => 'Theo dõi trạng thái cư trú, hóa đơn và các thông báo mới nhất từ Ban quản lý.']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalcb19cb35a534439097b02b8af91726ee)): ?>
<?php $attributes = $__attributesOriginalcb19cb35a534439097b02b8af91726ee; ?>
<?php unset($__attributesOriginalcb19cb35a534439097b02b8af91726ee); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalcb19cb35a534439097b02b8af91726ee)): ?>
<?php $component = $__componentOriginalcb19cb35a534439097b02b8af91726ee; ?>
<?php unset($__componentOriginalcb19cb35a534439097b02b8af91726ee); ?>
<?php endif; ?>

        
        <section class="grid grid-cols-1 md:grid-cols-3 gap-6">
            
            <article class="saas-card p-6 flex flex-col justify-between group hover:border-slate-300 transition-all">
                <div class="mb-5">
                    <div class="flex items-center justify-between mb-4">
                        <div class="h-10 w-10 rounded-xl bg-slate-50 flex items-center justify-center text-slate-400 group-hover:bg-slate-900 group-hover:text-white transition-all duration-300 border border-slate-100">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                        </div>
                        <span class="text-[10px] font-bold uppercase tracking-widest text-slate-400">Vị trí hiện tại</span>
                    </div>
                    <h3 class="text-2xl font-bold tracking-tight text-slate-900 leading-tight mb-1"><?php echo e($phonghientai->ten_phong ?? 'Chưa xếp phòng'); ?></h3>
                    <div class="text-[11px] font-bold text-slate-400 uppercase tracking-widest">
                        <?php echo e($phonghientai ? ('Tòa '.$phonghientai->toa.' • Tầng '.$phonghientai->tang) : 'Liên hệ BQL để được sắp xếp'); ?>

                    </div>
                </div>
                <div class="inline-flex items-center gap-1.5 rounded-lg bg-slate-50 px-3 py-1.5 text-[10px] font-bold text-slate-600 uppercase tracking-widest border border-slate-200 w-fit tabular-nums">
                    <?php echo e($tongThanhVien); ?> Thành viên
                </div>
            </article>

            
            <article class="saas-card p-6 flex flex-col justify-between group hover:border-slate-300 transition-all">
                <div class="mb-5">
                    <div class="flex items-center justify-between mb-4">
                        <div class="h-10 w-10 rounded-xl bg-slate-50 flex items-center justify-center text-slate-400 border border-slate-100 transition-all duration-300 <?php echo e($tongTienCanDong > 0 ? 'group-hover:bg-rose-600 group-hover:text-white' : 'group-hover:bg-slate-900 group-hover:text-white'); ?>">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <span class="text-[10px] font-bold uppercase tracking-widest text-slate-400">Công nợ hiện tại</span>
                    </div>
                    <div class="flex items-baseline gap-1 mb-1">
                        <span class="text-2xl font-bold tracking-tight tabular-nums <?php echo e($tongTienCanDong > 0 ? 'text-rose-600' : 'text-slate-900'); ?>"><?php echo e(number_format($tongTienCanDong)); ?></span>
                        <span class="text-xs font-bold text-slate-300">VNĐ</span>
                    </div>
                    <div class="text-[11px] font-bold uppercase tracking-widest <?php echo e($tongTienCanDong > 0 ? 'text-rose-400' : 'text-slate-400'); ?>">
                        <?php echo e($tongTienCanDong > 0 ? 'Cần thanh toán ngay' : 'Đã hoàn tất nghĩa vụ'); ?>

                    </div>
                </div>
                <a href="<?php echo e(route('student.hoadoncuaem')); ?>" class="inline-flex items-center gap-1.5 text-[10px] font-bold uppercase tracking-widest text-blue-600 hover:text-blue-700 transition-colors w-fit">
                    Chi tiết hóa đơn
                    <svg class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                </a>
            </article>

            
            <?php if (isset($component)) { $__componentOriginal272a52fa6d83078d600b1920ad2d3190 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal272a52fa6d83078d600b1920ad2d3190 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.countdown-hopdong','data' => ['hopdong' => $hopdongHienTai,'soNgayCon' => $soNgayCon]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('countdown-hopdong'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['hopdong' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($hopdongHienTai),'soNgayCon' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($soNgayCon)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal272a52fa6d83078d600b1920ad2d3190)): ?>
<?php $attributes = $__attributesOriginal272a52fa6d83078d600b1920ad2d3190; ?>
<?php unset($__attributesOriginal272a52fa6d83078d600b1920ad2d3190); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal272a52fa6d83078d600b1920ad2d3190)): ?>
<?php $component = $__componentOriginal272a52fa6d83078d600b1920ad2d3190; ?>
<?php unset($__componentOriginal272a52fa6d83078d600b1920ad2d3190); ?>
<?php endif; ?>
        </section>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            
            <div class="lg:col-span-8 space-y-8">
                <article class="saas-card overflow-hidden">
                    <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between bg-slate-50/30">
                        <h2 class="text-[10px] font-bold uppercase tracking-widest text-slate-400">Giao dịch gần nhất</h2>
                        <a href="<?php echo e(route('student.hoadoncuaem')); ?>" class="text-[10px] font-bold uppercase tracking-widest text-blue-600 hover:text-blue-700">Tất cả</a>
                    </div>

                    <div class="divide-y divide-slate-50">
                        <?php $__empty_1 = true; $__currentLoopData = $hoaDonGanNhat; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $hoadon): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <div class="flex items-center justify-between px-6 py-4 hover:bg-slate-50/50 transition-colors group">
                                <div class="flex items-center gap-4">
                                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-slate-50 text-slate-400 border border-slate-100 group-hover:bg-white transition-colors">
                                        <?php if($hoadon->loai_hoadon === 'dien_nuoc'): ?>
                                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                                        <?php else: ?>
                                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                                        <?php endif; ?>
                                    </div>
                                    <div>
                                        <h4 class="text-sm font-bold text-slate-900 tracking-tight"><?php echo e($hoadon->ghi_chu); ?></h4>
                                        <div class="text-[9px] text-slate-400 font-bold uppercase tracking-widest mt-0.5"><?php echo e($hoadon->loai_hoadon === 'dien_nuoc' ? 'Hóa đơn dịch vụ' : 'Hợp đồng cư trú'); ?></div>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <div class="text-sm font-bold text-slate-900 tabular-nums mb-1"><?php echo e(number_format($hoadon->tong_tien)); ?>đ</div>
                                    <?php
                                        $isPaid = $hoadon->trang_thai === \App\Enums\InvoiceStatus::Paid;
                                    ?>
                                    <span class="saas-badge <?php echo e($isPaid ? 'saas-badge-success' : 'saas-badge-error'); ?> !py-0.5 !px-2">
                                        <?php echo e($isPaid ? 'Đã thu' : 'Chờ nộp'); ?>

                                    </span>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <div class="py-12 text-center">
                                <p class="text-[10px] font-bold text-slate-300 uppercase tracking-widest">Không có dữ liệu giao dịch</p>
                            </div>
                        <?php endif; ?>
                    </div>
                </article>

                
                <div class="grid grid-cols-3 gap-6">
                    <?php
                        $quickActions = [
                            ['route' => 'student.hoadoncuaem', 'label' => 'Thanh toán', 'icon' => 'M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z'],
                            ['route' => 'student.giahan.index', 'label' => 'Gia hạn', 'icon' => 'M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z'],
                            ['route' => 'student.thongbao', 'label' => 'Bản tin', 'icon' => 'M15 17h5l-1.4-1.4a2 2 0 01-.6-1.4V11a6 6 0 1 0-12 0v3.2a2 2 0 01-.6 1.4L4 17h5m6 0a3 3 0 01-6 0'],
                        ];
                    ?>
                    <?php $__currentLoopData = $quickActions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $action): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <a href="<?php echo e(route($action['route'])); ?>" class="saas-card p-5 group flex flex-col items-center gap-3 transition-all hover:border-slate-300 text-center">
                            <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-slate-50 text-slate-400 border border-slate-100 group-hover:bg-slate-900 group-hover:text-white group-hover:border-slate-900 transition-all duration-300">
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="<?php echo e($action['icon']); ?>"/></svg>
                            </div>
                            <span class="text-[10px] font-bold text-slate-500 uppercase tracking-widest group-hover:text-slate-900 transition-colors"><?php echo e($action['label']); ?></span>
                        </a>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>

            
            <aside class="lg:col-span-4 space-y-8">
                <article class="saas-card overflow-hidden">
                    <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/30">
                        <h2 class="text-[10px] font-bold uppercase tracking-widest text-slate-400">Thông báo mới nhất</h2>
                    </div>
                    <div class="divide-y divide-slate-50">
                        <?php $__empty_1 = true; $__currentLoopData = $thongbao; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <a href="<?php echo e(route('student.chitietthongbao', $item->id)); ?>" class="group block p-5 transition-colors hover:bg-slate-50/50">
                                <div class="text-[9px] font-bold text-slate-400 uppercase tracking-widest mb-1 tabular-nums"><?php echo e($item->created_at->format('d/m/Y')); ?></div>
                                <h4 class="text-xs font-bold text-slate-900 leading-snug line-clamp-2 tracking-tight group-hover:text-blue-600 transition-colors"><?php echo e($item->tieu_de); ?></h4>
                            </a>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <div class="py-12 text-center">
                                <p class="text-[10px] font-bold text-slate-300 uppercase tracking-widest">Không có thông báo mới</p>
                            </div>
                        <?php endif; ?>
                    </div>
                </article>

                <article class="saas-card bg-slate-900 border-slate-800 p-6 text-white relative overflow-hidden group">
                    <div class="absolute -right-8 -top-8 h-32 w-32 rounded-full bg-slate-800/30 blur-3xl group-hover:bg-blue-500/10 transition-colors duration-700"></div>
                    <div class="relative z-10">
                        <div class="flex items-center gap-3 mb-6 border-b border-slate-800 pb-5">
                            <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-slate-800 text-slate-400 ring-1 ring-slate-700">
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            </div>
                            <h2 class="text-[10px] font-bold uppercase tracking-widest text-slate-500">Đường dây nóng</h2>
                        </div>
                        <div class="space-y-5">
                            <?php $__currentLoopData = $lienhekhancap; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $contact): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="flex flex-col gap-1 group/line">
                                    <span class="text-[9px] font-bold uppercase tracking-widest text-slate-600 group-hover/line:text-slate-400 transition-colors"><?php echo e($contact['title']); ?></span>
                                    <a href="tel:<?php echo e($contact['phone']); ?>" class="text-sm font-bold tabular-nums tracking-tight hover:text-blue-400 transition-colors text-slate-300"><?php echo e($contact['phone']); ?></a>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>
                </article>
            </aside>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('student.layouts.chinh', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\laragon\www\hethongquanlyktxv1\resources\views/student/trangchu.blade.php ENDPATH**/ ?>