<?php if (isset($component)) { $__componentOriginal91fdd17964e43374ae18c674f95cdaa3 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal91fdd17964e43374ae18c674f95cdaa3 = $attributes; } ?>
<?php $component = App\View\Components\AdminLayout::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('admin-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(App\View\Components\AdminLayout::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
     <?php $__env->slot('title', null, []); ?> Quản lý Công nợ <?php $__env->endSlot(); ?>

    <div class="space-y-8 pb-20">
        <?php if (isset($component)) { $__componentOriginalcb19cb35a534439097b02b8af91726ee = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalcb19cb35a534439097b02b8af91726ee = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.page-header','data' => ['title' => 'Sổ nợ hệ thống','subtitle' => 'Đối soát các chứng từ quyết toán quá hạn trên '.e($ngayQuaHan).' chu kỳ thanh toán.']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('admin.page-header'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Sổ nợ hệ thống','subtitle' => 'Đối soát các chứng từ quyết toán quá hạn trên '.e($ngayQuaHan).' chu kỳ thanh toán.']); ?>
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

        
        <section class="grid gap-6 grid-cols-1 md:grid-cols-2 lg:grid-cols-4">
            <div class="saas-card p-6 border-l-[4px] border-slate-900 hover:shadow-xl hover:shadow-slate-900/10 transition-all duration-500">
                <div class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-3">Phòng có nợ</div>
                <div class="text-3xl font-black text-slate-900 tabular-nums tracking-tighter"><?php echo e($thongke['tong_phong_no'] ?? 0); ?></div>
                <div class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-1">Đơn vị phòng</div>
            </div>

            <div class="saas-card p-6 border-l-[4px] border-blue-600 hover:shadow-xl hover:shadow-blue-600/10 transition-all duration-500">
                <div class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-3">Sinh viên nợ</div>
                <div class="text-3xl font-black text-slate-900 tabular-nums tracking-tighter"><?php echo e($thongke['tong_sinh_vien_no'] ?? 0); ?></div>
                <div class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-1">Cư dân</div>
            </div>

            <div class="saas-card p-6 border-l-[4px] border-amber-500 hover:shadow-xl hover:shadow-amber-500/10 transition-all duration-500">
                <div class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-3">Hóa đơn quá hạn</div>
                <div class="text-3xl font-black text-slate-900 tabular-nums tracking-tighter"><?php echo e($thongke['so_hoa_don_qua_han'] ?? 0); ?></div>
                <div class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-1">Chứng từ</div>
            </div>

            <div class="saas-card p-6 border-l-[4px] border-rose-600 hover:shadow-xl hover:shadow-rose-600/10 transition-all duration-500">
                <div class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-3">Tổng nợ tồn đọng</div>
                <div class="text-2xl font-black text-rose-600 tabular-nums tracking-tighter"><?php echo e(number_format($thongke['tong_tien_no'] ?? 0)); ?><span class="text-xs font-bold text-rose-300 ml-1">đ</span></div>
                <div class="text-[10px] font-bold text-rose-400/70 uppercase tracking-widest mt-1">VND</div>
            </div>
        </section>

        <?php if (isset($component)) { $__componentOriginaldf54224cf245156c316d9d3b07da8b50 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginaldf54224cf245156c316d9d3b07da8b50 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.table-card','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('admin.table-card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
            <thead>
                <tr>
                    <th>Phòng nội trú</th>
                    <th>Cư dân liên quan</th>
                    <th>Chi tiết kỳ nợ</th>
                    <th>Tổng nợ</th>
                    <th class="text-right">Hành động</th>
                </tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $congnoTheoPhong; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $phongId => $dong): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <?php
                        $phong = $dong['phong'] ?? null;
                        $danhsachSinhvien = $dong['sinhvien'] ?? collect();
                        $danhsachHoadon = collect($dong['hoadon'] ?? []);
                        $tongTien = (int) ($dong['tongtien'] ?? 0);
                    ?>
                    <tr class="align-top group hover:bg-slate-50/50 transition-colors">
                        <td class="py-6">
                            <div class="flex items-center gap-3 font-bold text-slate-900 text-sm group-hover:text-blue-600 transition-colors">
                                <div class="h-9 w-9 flex items-center justify-center rounded-xl bg-slate-50 text-slate-400 border border-slate-200/60 shadow-sm flex-shrink-0">
                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                                </div>
                                <?php echo e($phong->ten_phong ?? 'Chưa xác định'); ?>

                            </div>
                            <div class="text-[9px] font-bold text-slate-400 uppercase tracking-widest mt-1.5 ml-12">Mã: <?php echo e($phongId); ?></div>
                        </td>
                        <td class="py-6">
                            <?php if($danhsachSinhvien->isEmpty()): ?>
                                <span class="inline-flex items-center gap-1.5 text-[10px] font-bold text-slate-400 uppercase tracking-wider">
                                    <span class="h-1.5 w-1.5 rounded-full bg-slate-300"></span>
                                    Phòng trống
                                </span>
                            <?php else: ?>
                                <div class="space-y-3">
                                    <?php $__currentLoopData = $danhsachSinhvien; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sv): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <div class="flex items-center gap-2.5">
                                            <div class="h-7 w-7 rounded-full bg-slate-900 text-white flex items-center justify-center text-[10px] font-bold ring-2 ring-white flex-shrink-0">
                                                <?php echo e(substr($sv->user->name ?? '?', 0, 1)); ?>

                                            </div>
                                            <div class="flex flex-col">
                                                <span class="text-[11px] font-bold text-slate-700 leading-none"><?php echo e($sv->user->name ?? 'Không rõ'); ?></span>
                                                <span class="text-[9px] font-bold text-slate-400 uppercase tabular-nums mt-1"><?php echo e($sv->ma_sinh_vien); ?></span>
                                            </div>
                                        </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>
                            <?php endif; ?>
                        </td>
                        <td class="py-6">
                            <div class="space-y-2 bg-white p-4 rounded-xl border border-slate-200/60 shadow-sm max-w-[220px]">
                                <?php $__currentLoopData = $danhsachHoadon; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $hoadon): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="flex items-center justify-between gap-3">
                                        <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest tabular-nums">Kỳ <?php echo e(str_pad($hoadon->thang, 2, '0', STR_PAD_LEFT)); ?>/<?php echo e($hoadon->nam); ?></span>
                                        <div class="h-px flex-1 border-t border-dashed border-slate-200"></div>
                                        <span class="text-[11px] font-bold text-slate-900 tabular-nums"><?php echo e(number_format($hoadon->tongtien)); ?><small class="ml-0.5 opacity-50">đ</small></span>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        </td>
                        <td class="py-6">
                            <div class="text-lg font-black tabular-nums text-rose-600 tracking-tighter leading-none"><?php echo e(number_format($tongTien)); ?><small class="ml-0.5 text-[10px] uppercase tracking-widest opacity-60">đ</small></div>
                            <div class="text-[9px] font-bold text-rose-400 uppercase tracking-widest mt-1.5">Tổng nợ tồn</div>
                        </td>
                        <td class="py-6 text-right">
                            <form method="POST" action="<?php echo e(route('admin.guinhacnho', $phongId)); ?>" x-data="{ showConfirm: false }" @confirmed="$el.submit()">
                                <?php echo csrf_field(); ?>
                                <button type="button" @click="showConfirm = true" class="h-9 w-9 inline-flex items-center justify-center text-slate-400 hover:text-blue-600 hover:bg-blue-50 border border-transparent hover:border-blue-100 rounded-xl transition-all shadow-sm hover:shadow-md" title="Gửi thông báo nhắc nợ">
                                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                                </button>
                                <?php if (isset($component)) { $__componentOriginal5b8b2d0f151a30be878e1a760ec3900c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5b8b2d0f151a30be878e1a760ec3900c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.confirmation-modal','data' => ['message' => 'Hệ thống sẽ gửi thông báo nhắc nợ tới toàn bộ cư dân thuộc phòng này. Tiếp tục?']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('confirmation-modal'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['message' => 'Hệ thống sẽ gửi thông báo nhắc nợ tới toàn bộ cư dân thuộc phòng này. Tiếp tục?']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal5b8b2d0f151a30be878e1a760ec3900c)): ?>
<?php $attributes = $__attributesOriginal5b8b2d0f151a30be878e1a760ec3900c; ?>
<?php unset($__attributesOriginal5b8b2d0f151a30be878e1a760ec3900c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal5b8b2d0f151a30be878e1a760ec3900c)): ?>
<?php $component = $__componentOriginal5b8b2d0f151a30be878e1a760ec3900c; ?>
<?php unset($__componentOriginal5b8b2d0f151a30be878e1a760ec3900c); ?>
<?php endif; ?>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="5" class="py-24 text-center">
                            <div class="flex flex-col items-center gap-4 text-slate-200">
                                <svg class="h-14 w-14" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                <p class="text-sm font-bold text-slate-400 uppercase tracking-widest">Không có công nợ tồn đọng</p>
                                <p class="text-[11px] text-slate-400 font-medium max-w-xs">Tất cả cư dân đang duy trì trạng thái tài chính minh bạch.</p>
                            </div>
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
         <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginaldf54224cf245156c316d9d3b07da8b50)): ?>
<?php $attributes = $__attributesOriginaldf54224cf245156c316d9d3b07da8b50; ?>
<?php unset($__attributesOriginaldf54224cf245156c316d9d3b07da8b50); ?>
<?php endif; ?>
<?php if (isset($__componentOriginaldf54224cf245156c316d9d3b07da8b50)): ?>
<?php $component = $__componentOriginaldf54224cf245156c316d9d3b07da8b50; ?>
<?php unset($__componentOriginaldf54224cf245156c316d9d3b07da8b50); ?>
<?php endif; ?>
    </div>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal91fdd17964e43374ae18c674f95cdaa3)): ?>
<?php $attributes = $__attributesOriginal91fdd17964e43374ae18c674f95cdaa3; ?>
<?php unset($__attributesOriginal91fdd17964e43374ae18c674f95cdaa3); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal91fdd17964e43374ae18c674f95cdaa3)): ?>
<?php $component = $__componentOriginal91fdd17964e43374ae18c674f95cdaa3; ?>
<?php unset($__componentOriginal91fdd17964e43374ae18c674f95cdaa3); ?>
<?php endif; ?>
<?php /**PATH D:\laragon\www\hethongquanlyktxv1\resources\views/admin/congno/danhsach.blade.php ENDPATH**/ ?>