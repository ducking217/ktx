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
     <?php $__env->slot('title', null, []); ?> Hồ sơ cư dân định danh: <?php echo e($sinhvien->user?->name); ?> <?php $__env->endSlot(); ?>

    <div class="space-y-8 animate-fade-in pb-20">
        <?php if (isset($component)) { $__componentOriginalcb19cb35a534439097b02b8af91726ee = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalcb19cb35a534439097b02b8af91726ee = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.page-header','data' => ['title' => 'Hồ sơ sinh viên','subtitle' => 'Thông tin định danh, lịch sử cư trú và biến động tài chính của cư dân.']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('admin.page-header'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Hồ sơ sinh viên','subtitle' => 'Thông tin định danh, lịch sử cư trú và biến động tài chính của cư dân.']); ?>
            <div class="flex items-center gap-2">
                <a href="<?php echo e(route('admin.sinhvien.index')); ?>" class="saas-btn-secondary h-9 px-4 text-xs">
                    <svg class="mr-2 h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"/></svg>
                    Quay lại
                </a>
                
                <button type="button" data-modal-target="modal-edit-<?php echo e($sinhvien->id); ?>" data-modal-toggle="modal-edit-<?php echo e($sinhvien->id); ?>" class="saas-btn-primary h-9 px-5 text-xs shadow-lg shadow-emerald-500/20">
                    <svg class="mr-2 h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                    Chỉnh sửa hồ sơ sinh viên
                </button>
            </div>
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

        <?php
            $anhTheUrl = $sinhvien->anh_the_path ? \App\Http\Controllers\Shared\FileController::generateSignedUrl($sinhvien->anh_the_path) : null;
            $anhCccdUrl = $sinhvien->anh_cccd_path ? \App\Http\Controllers\Shared\FileController::generateSignedUrl($sinhvien->anh_cccd_path) : null;
        ?>
        
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            
            <div class="lg:col-span-4 space-y-8">
                <div class="saas-card p-8 text-center relative overflow-hidden group border-slate-200/60 shadow-sm hover:shadow-md transition-all">
                    <div class="relative z-10 inline-block mb-8">
                        <div class="h-32 w-32 overflow-hidden rounded-2xl bg-slate-100 ring-4 ring-white shadow-lg transition-all duration-700 border border-slate-200">
                            <?php if($anhTheUrl): ?>
                                <img src="<?php echo e($anhTheUrl); ?>" alt="Avatar" class="h-full w-full object-cover">
                            <?php else: ?>
                                <div class="h-full w-full flex items-center justify-center bg-slate-50 text-slate-300">
                                    <svg class="h-12 w-12" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="absolute -bottom-2 -right-2 h-10 w-10 flex items-center justify-center rounded-xl bg-brand-emerald text-white shadow-lg ring-4 ring-white">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                    </div>
                    
                    <div class="relative z-10">
                        <h2 class="text-xl font-bold text-slate-900 tracking-tight"><?php echo e($sinhvien->user?->name); ?></h2>
                        <div class="flex items-center justify-center gap-2 mt-2">
                            <span class="text-[10px] font-bold text-emerald-700 uppercase tracking-widest bg-emerald-50 px-3 py-1 rounded-lg border border-emerald-100/60"><?php echo e($sinhvien->ma_sinh_vien); ?></span>
                        </div>
                        
                        <div class="mt-6 flex flex-wrap justify-center gap-2">
                            <span class="inline-flex items-center rounded-lg bg-slate-900 px-3 py-1.5 text-[9px] font-bold uppercase tracking-wider text-white">
                                <?php echo e($sinhvien->lop); ?>

                            </span>
                            <span class="inline-flex items-center rounded-lg bg-slate-50 border border-slate-200 px-3 py-1.5 text-[9px] font-bold uppercase tracking-wider text-slate-500">
                                Khóa <?php echo e(substr($sinhvien->ma_sinh_vien, 0, 2)); ?>

                            </span>
                        </div>

                        <div class="mt-8 grid grid-cols-2 gap-6 border-t border-slate-100 pt-8">
                            <div class="text-left">
                                <div class="text-[9px] font-bold text-slate-400 uppercase tracking-widest mb-1">Giới tính</div>
                                <div class="text-xs font-bold text-slate-900 uppercase"><?php echo e($sinhvien->user?->gender?->label()); ?></div>
                            </div>
                            <div class="text-left">
                                <div class="text-[9px] font-bold text-slate-400 uppercase tracking-widest mb-1">Dân tộc</div>
                                <div class="text-xs font-bold text-slate-900 uppercase"><?php echo e($sinhvien->user?->ethnicity ?? 'Kinh'); ?></div>
                            </div>
                            <div class="col-span-2 border-t border-slate-50 pt-6 mt-1 text-left">
                                <div class="text-[9px] font-bold text-slate-400 uppercase tracking-widest mb-1">Số định danh (CCCD/Passport)</div>
                                <div class="text-base font-bold text-slate-900 tabular-nums tracking-tight"><?php echo e($sinhvien->user?->id_card); ?></div>
                            </div>
                        </div>
                    </div>
                </div>

                
                <div class="saas-card p-6 border-slate-200/60 shadow-sm">
                    <h3 class="text-[9px] font-bold text-slate-400 uppercase tracking-widest mb-4 flex items-center gap-2">
                        <span class="h-1.5 w-1.5 rounded-full bg-slate-300"></span>
                        Tài liệu định danh
                    </h3>
                    <div class="grid grid-cols-2 gap-3">
                        <div class="space-y-2">
                            <div class="aspect-[3/4] overflow-hidden rounded-lg bg-slate-50 border border-slate-100 group/doc relative">
                                <?php if($anhTheUrl): ?>
                                    <a href="<?php echo e($anhTheUrl); ?>" target="_blank" rel="noopener" class="block h-full w-full">
                                        <img src="<?php echo e($anhTheUrl); ?>" class="h-full w-full object-cover transition-all duration-500 group-hover/doc:scale-105" />
                                    </a>
                                <?php else: ?>
                                    <div class="flex h-full w-full items-center justify-center text-[9px] font-bold text-slate-300 uppercase">Chưa có ảnh</div>
                                <?php endif; ?>
                            </div>
                            <div class="text-[8px] font-bold text-slate-400 uppercase tracking-widest text-center">Ảnh thẻ</div>
                        </div>
                        <div class="space-y-2">
                            <div class="aspect-[3/4] overflow-hidden rounded-lg bg-slate-50 border border-slate-100 group/doc relative">
                                <?php if($anhCccdUrl): ?>
                                    <a href="<?php echo e($anhCccdUrl); ?>" target="_blank" rel="noopener" class="block h-full w-full">
                                        <img src="<?php echo e($anhCccdUrl); ?>" class="h-full w-full object-cover transition-all duration-500 group-hover/doc:scale-105" />
                                    </a>
                                <?php else: ?>
                                    <div class="flex h-full w-full items-center justify-center text-[9px] font-bold text-slate-300 uppercase">Chưa có CCCD</div>
                                <?php endif; ?>
                            </div>
                            <div class="text-[8px] font-bold text-slate-400 uppercase tracking-widest text-center">CCCD</div>
                        </div>
                    </div>
                </div>

                
                <div class="saas-card p-6 bg-slate-900 border-none shadow-xl shadow-slate-900/10">
                    <div class="space-y-6">
                        <div class="flex items-center gap-4">
                            <div class="h-10 w-10 flex flex-shrink-0 items-center justify-center rounded-xl bg-brand-emerald/10 text-brand-emerald border border-brand-emerald/20">
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1-1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                            </div>
                            <div>
                                <div class="text-[8px] font-bold text-slate-500 uppercase tracking-widest mb-0.5">Phòng cư trú</div>
                                <?php if($sinhvien->phong_hien_tai()): ?>
                                    <div class="text-sm font-bold text-white uppercase tracking-tight leading-none"><?php echo e($sinhvien->phong_hien_tai()->ten_phong); ?></div>
                                    <div class="text-[9px] font-bold text-brand-emerald/80 mt-1 uppercase tracking-widest"><?php echo e($sinhvien->phong_hien_tai()->toanha?->ten_toa_nha); ?></div>
                                <?php else: ?>
                                    <div class="text-xs font-bold text-slate-600 uppercase tracking-widest">Chưa xếp phòng</div>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="flex items-center gap-4">
                            <div class="h-10 w-10 flex flex-shrink-0 items-center justify-center rounded-xl bg-slate-800 text-slate-400 border border-slate-700">
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            </div>
                            <div>
                                <div class="text-[8px] font-bold text-slate-500 uppercase tracking-widest mb-0.5">Ngày nhập nội</div>
                                <div class="text-sm font-bold text-white tabular-nums tracking-tight leading-none">
                                    <?php echo e($sinhvien->hopdongs->where('trang_thai', \App\Enums\ContractStatus::Active)->first()?->ngay_bat_dau?->format('d/m/Y') ?? 'Chưa có'); ?>

                                </div>
                            </div>
                        </div>

                        <div class="pt-6 border-t border-slate-800 flex items-center gap-4">
                            <div class="h-10 w-10 flex flex-shrink-0 items-center justify-center rounded-xl bg-rose-500/10 text-rose-500 border border-rose-500/20">
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                            </div>
                            <div>
                                <div class="text-[8px] font-bold text-rose-500/80 uppercase tracking-widest mb-0.5">Liên hệ khẩn cấp</div>
                                <div class="text-xs font-bold text-white">Chưa cập nhật</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            
            <div class="lg:col-span-8 space-y-8">
                
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    <div class="saas-card p-5 bg-slate-50/50 border-none group hover:bg-white hover:shadow-xl transition-all duration-300">
                        <div class="text-[8px] font-bold text-slate-400 uppercase tracking-widest mb-3">Hợp đồng</div>
                        <div class="text-2xl font-bold text-slate-900 tabular-nums tracking-tight group-hover:text-brand-emerald transition-colors"><?php echo e($sinhvien->hopdongs->count()); ?></div>
                        <div class="h-0.5 w-4 bg-slate-200 mt-3 group-hover:w-8 group-hover:bg-brand-emerald transition-all"></div>
                    </div>
                    <div class="saas-card p-5 bg-rose-50/20 border-none group hover:bg-white hover:shadow-xl transition-all duration-300">
                        <div class="text-[8px] font-bold text-rose-400 uppercase tracking-widest mb-3">Kỷ luật</div>
                        <div class="text-2xl font-bold text-rose-600 tabular-nums tracking-tight"><?php echo e($sinhvien->kyluats->count()); ?></div>
                        <div class="h-0.5 w-4 bg-rose-200 mt-3 group-hover:w-8 group-hover:bg-rose-500 transition-all"></div>
                    </div>
                    <div class="saas-card p-5 bg-emerald-50/20 border-none group hover:bg-white hover:shadow-xl transition-all duration-300">
                        <div class="text-[8px] font-bold text-emerald-700 uppercase tracking-widest mb-3">Hóa đơn</div>
                        <div class="text-2xl font-bold text-emerald-700 tabular-nums tracking-tight"><?php echo e($hoadons->count()); ?></div>
                        <div class="h-0.5 w-4 bg-emerald-200 mt-3 group-hover:w-8 group-hover:bg-emerald-600 transition-all"></div>
                    </div>
                </div>

                
                <div class="saas-card overflow-hidden border-slate-200/60 shadow-sm">
                    <div class="bg-slate-50/50 border-b border-slate-100 px-8 py-5 flex items-center justify-between">
                        <h3 class="text-[10px] font-bold text-slate-900 uppercase tracking-widest flex items-center gap-2">
                            <span class="h-2 w-2 rounded-full bg-brand-emerald"></span>
                            Thông tin chi tiết
                        </h3>
                    </div>
                    <div class="p-8">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-12 gap-y-8">
                            <div class="space-y-1.5">
                                <label class="text-[9px] font-bold text-slate-400 uppercase tracking-widest flex items-center gap-2">
                                    <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                    Mã sinh viên
                                </label>
                                <div class="text-sm font-bold text-slate-900 tabular-nums tracking-tight"><?php echo e($sinhvien->ma_sinh_vien); ?></div>
                            </div>
                            <div class="space-y-1.5">
                                <label class="text-[9px] font-bold text-slate-400 uppercase tracking-widest flex items-center gap-2">
                                    <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                                    Lớp
                                </label>
                                <div class="text-sm font-bold text-slate-900 tracking-tight"><?php echo e($sinhvien->lop ?? 'Chưa có'); ?></div>
                            </div>
                            <div class="space-y-1.5">
                                <label class="text-[9px] font-bold text-slate-400 uppercase tracking-widest flex items-center gap-2">
                                    <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                                    Email định danh
                                </label>
                                <div class="text-sm font-bold text-slate-900 break-all tracking-tight"><?php echo e($sinhvien->user?->email ?? 'Chưa có'); ?></div>
                            </div>
                            <div class="space-y-1.5">
                                <label class="text-[9px] font-bold text-slate-400 uppercase tracking-widest flex items-center gap-2">
                                    <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                                    Số điện thoại
                                </label>
                                <div class="text-sm font-bold text-slate-900 tabular-nums tracking-tight"><?php echo e($sinhvien->user?->phone ?? 'Chưa có'); ?></div>
                            </div>
                            <div class="space-y-1.5">
                                <label class="text-[9px] font-bold text-slate-400 uppercase tracking-widest flex items-center gap-2">
                                    <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                                    Ngày sinh
                                </label>
                                <div class="text-sm font-bold text-slate-900 tabular-nums tracking-tight"><?php echo e($sinhvien->user?->dob?->format('d/m/Y') ?? 'Chưa có'); ?></div>
                            </div>
                            <div class="space-y-1.5">
                                <label class="text-[9px] font-bold text-slate-400 uppercase tracking-widest flex items-center gap-2">
                                    <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                    Địa chỉ thường trú
                                </label>
                                <div class="text-sm font-bold text-slate-900 leading-relaxed tracking-tight"><?php echo e($sinhvien->user?->address ?? 'Chưa có'); ?></div>
                            </div>
                            <div class="space-y-1.5">
                                <label class="text-[9px] font-bold text-slate-400 uppercase tracking-widest flex items-center gap-2">
                                    <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8c-1.657 0-3 .895-3 2v2c0 1.105 1.343 2 3 2s3-.895 3-2v-2c0-1.105-1.343-2-3-2z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 21H5a2 2 0 01-2-2V7a2 2 0 012-2h14a2 2 0 012 2v12a2 2 0 01-2 2z"/></svg>
                                    Số CCCD / Định danh
                                </label>
                                <div class="text-sm font-bold text-slate-900 tabular-nums tracking-tight"><?php echo e($sinhvien->user?->id_card ?? 'Chưa có'); ?></div>
                            </div>
                            <div class="space-y-1.5">
                                <label class="text-[9px] font-bold text-slate-400 uppercase tracking-widest flex items-center gap-2">
                                    <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                    Khoa
                                </label>
                                <div class="text-sm font-bold text-slate-900 tracking-tight"><?php echo e($sinhvien->khoa ?? 'Chưa có'); ?></div>
                            </div>
                            <div class="space-y-1.5">
                                <label class="text-[9px] font-bold text-slate-400 uppercase tracking-widest flex items-center gap-2">
                                    <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                                    Ngày nhập học
                                </label>
                                <div class="text-sm font-bold text-slate-900 tabular-nums tracking-tight"><?php echo e($sinhvien->ngay_nhap_hoc?->format('d/m/Y') ?? 'Chưa có'); ?></div>
                            </div>
                        </div>
                    </div>
                </div>

                
                <div x-data="{ activeTab: 'contracts' }" class="space-y-6">
                    <div class="flex items-center gap-1.5 bg-slate-100/50 p-1 rounded-xl border border-slate-200/60 w-fit shadow-inner">
                        <button @click="activeTab = 'contracts'" :class="activeTab === 'contracts' ? 'bg-white text-brand-emerald shadow-sm border-slate-200' : 'text-slate-400 hover:text-slate-600'" class="px-5 py-2 rounded-lg text-[9px] font-bold uppercase tracking-wider transition-all border border-transparent">Hợp đồng</button>
                        <button @click="activeTab = 'discipline'" :class="activeTab === 'discipline' ? 'bg-white text-rose-600 shadow-sm border-slate-200' : 'text-slate-400 hover:text-slate-600'" class="px-5 py-2 rounded-lg text-[9px] font-bold uppercase tracking-wider transition-all border border-transparent">Kỷ luật</button>
                        <button @click="activeTab = 'bills'" :class="activeTab === 'bills' ? 'bg-white text-brand-emerald shadow-sm border-slate-200' : 'text-slate-400 hover:text-slate-600'" class="px-5 py-2 rounded-lg text-[9px] font-bold uppercase tracking-wider transition-all border border-transparent">Hóa đơn</button>
                    </div>

                    <div class="saas-card overflow-hidden border-slate-200/60 shadow-sm">
                        
                        <div x-show="activeTab === 'contracts'" x-transition class="animate-fade-in">
                            <table class="w-full text-left">
                                <thead class="bg-slate-50/50 border-b border-slate-100">
                                    <tr>
                                        <th class="px-6 py-4 text-[9px] font-bold text-slate-400 uppercase tracking-widest">ID</th>
                                        <th class="px-6 py-4 text-[9px] font-bold text-slate-400 uppercase tracking-widest">Phòng</th>
                                        <th class="px-6 py-4 text-[9px] font-bold text-slate-400 uppercase tracking-widest">Thời hạn</th>
                                        <th class="px-6 py-4 text-[9px] font-bold text-slate-400 uppercase tracking-widest text-center">Trạng thái</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-100">
                                    <?php $__empty_1 = true; $__currentLoopData = $sinhvien->hopdongs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $hopdong): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                        <tr class="hover:bg-slate-50/30 transition-all">
                                            <td class="px-6 py-4 text-xs font-bold text-slate-900 tabular-nums">#<?php echo e($hopdong->id); ?></td>
                                            <td class="px-6 py-4">
                                                <div class="text-xs font-bold text-slate-900">P.<?php echo e($hopdong->phong?->ten_phong ?? 'Chưa có'); ?></div>
                                            </td>
                                            <td class="px-6 py-4">
                                                <div class="flex items-center gap-3 text-[10px] font-bold tabular-nums">
                                                    <span class="text-slate-500"><?php echo e($hopdong->ngay_bat_dau->format('d/m/Y')); ?></span>
                                                    <svg class="h-3 w-3 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                                                    <span class="text-brand-emerald"><?php echo e($hopdong->ngay_ket_thuc->format('d/m/Y')); ?></span>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 text-center">
                                                <?php
                                                    $statusBadge = match($hopdong->trang_thai) {
                                                        \App\Enums\ContractStatus::Active => 'saas-badge-success',
                                                        \App\Enums\ContractStatus::Expired => 'saas-badge-warning',
                                                        \App\Enums\ContractStatus::Terminated => 'saas-badge-error',
                                                        default => 'saas-badge-info',
                                                    };
                                                ?>
                                                <span class="saas-badge <?php echo e($statusBadge); ?> text-[8px] font-bold px-3 py-1">
                                                    <?php echo e($hopdong->trang_thai->label()); ?>

                                                </span>
                                            </td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                        <tr>
                                            <td colspan="4" class="px-6 py-20 text-center">
                                                <p class="text-[10px] font-bold text-slate-300 uppercase tracking-widest">Không có dữ liệu hợp đồng</p>
                                            </td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>

                        
                        <div x-show="activeTab === 'discipline'" x-transition class="animate-fade-in">
                            <table class="w-full text-left">
                                <thead class="bg-slate-50/50 border-b border-slate-100">
                                    <tr>
                                        <th class="px-6 py-4 text-[9px] font-bold text-slate-400 uppercase tracking-widest">Ngày</th>
                                        <th class="px-6 py-4 text-[9px] font-bold text-slate-400 uppercase tracking-widest">Mức độ</th>
                                        <th class="px-6 py-4 text-[9px] font-bold text-slate-400 uppercase tracking-widest">Nội dung</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-100">
                                    <?php $__empty_1 = true; $__currentLoopData = $sinhvien->kyluats; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $kyluat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                        <tr class="hover:bg-slate-50/30 transition-all">
                                            <td class="px-6 py-4 text-xs font-bold text-slate-900 tabular-nums"><?php echo e($kyluat->ngay_vi_pham->format('d/m/Y')); ?></td>
                                            <td class="px-6 py-4">
                                                <?php
                                                    $mucDoValue = $kyluat->muc_do?->value ?? $kyluat->muc_do;
                                                    $badgeClass = match($mucDoValue) {
                                                        \App\Enums\DisciplineLevel::High->value => 'saas-badge-error',
                                                        \App\Enums\DisciplineLevel::Medium->value => 'saas-badge-warning',
                                                        default => 'saas-badge-info',
                                                    };
                                                ?>
                                                <span class="saas-badge <?php echo e($badgeClass); ?> text-[8px] font-bold px-3 py-1">
                                                    <?php echo e($kyluat->muc_do?->label() ?? 'Bình thường'); ?>

                                                </span>
                                            </td>
                                            <td class="px-6 py-4 text-xs text-slate-600 font-medium max-w-sm">
                                                <?php echo e($kyluat->noi_dung); ?>

                                            </td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                        <tr>
                                            <td colspan="3" class="px-6 py-20 text-center">
                                                <p class="text-[10px] font-bold text-slate-300 uppercase tracking-widest">Chưa có kỷ luật</p>
                                            </td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>

                        
                        <div x-show="activeTab === 'bills'" x-transition class="animate-fade-in">
                            <table class="w-full text-left">
                                <thead class="bg-slate-50/50 border-b border-slate-100">
                                    <tr>
                                        <th class="px-6 py-4 text-[9px] font-bold text-slate-400 uppercase tracking-widest">Tháng hóa đơn</th>
                                        <th class="px-6 py-4 text-[9px] font-bold text-slate-400 uppercase tracking-widest text-right">Tổng tiền</th>
                                        <th class="px-6 py-4 text-[9px] font-bold text-slate-400 uppercase tracking-widest text-center">Trạng thái</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-100">
                                    <?php $__empty_1 = true; $__currentLoopData = $hoadons; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $hoadon): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                        <tr class="hover:bg-slate-50/30 transition-all">
                                            <td class="px-6 py-4">
                                                <div class="text-xs font-bold text-slate-900">Tháng <?php echo e($hoadon->ngay_thanh_toan?->format('m/Y') ?? $hoadon->created_at->format('m/Y')); ?></div>
                                            </td>
                                            <td class="px-6 py-4 text-right text-xs font-bold text-slate-900 tabular-nums"><?php echo e(number_format((int) $hoadon->tong_tien)); ?>đ</td>
                                            <td class="px-6 py-4 text-center">
                                                <?php
                                                    $invoiceBadge = match($hoadon->trang_thai) {
                                                        \App\Enums\InvoiceStatus::Paid => 'saas-badge-success',
                                                        \App\Enums\InvoiceStatus::Unpaid => 'saas-badge-warning',
                                                        \App\Enums\InvoiceStatus::Overdue => 'saas-badge-error',
                                                        default => 'saas-badge-info',
                                                    };
                                                ?>
                                                <span class="saas-badge <?php echo e($invoiceBadge); ?> text-[8px] font-bold px-3 py-1">
                                                    <?php echo e($hoadon->trang_thai->label()); ?>

                                                </span>
                                            </td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                        <tr>
                                            <td colspan="3" class="px-6 py-20 text-center">
                                                <p class="text-[10px] font-bold text-slate-300 uppercase tracking-widest">Không có hóa đơn</p>
                                            </td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php $__env->startPush('modals'); ?>
        <?php if (isset($component)) { $__componentOriginal9f64f32e90b9102968f2bc548315018c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9f64f32e90b9102968f2bc548315018c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.modal','data' => ['id' => 'modal-edit-'.e($sinhvien->id).'','title' => 'Hiệu chỉnh hồ sơ sinh viên','subtitle' => 'Cập nhật thông tin định danh và hồ sơ học vụ.']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('modal'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['id' => 'modal-edit-'.e($sinhvien->id).'','title' => 'Hiệu chỉnh hồ sơ sinh viên','subtitle' => 'Cập nhật thông tin định danh và hồ sơ học vụ.']); ?>
            <form method="POST" action="<?php echo e(route('admin.sinhvien.capnhat', $sinhvien->id)); ?>" enctype="multipart/form-data" class="space-y-6">
                <?php echo csrf_field(); ?>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-2">
                        <label for="name" class="text-[10px] font-bold uppercase tracking-widest text-slate-400 ml-1">Họ và tên</label>
                        <input id="name" name="name" type="text" class="saas-input" value="<?php echo e(old('name', $sinhvien->user?->name)); ?>" required />
                        <?php if (isset($component)) { $__componentOriginalf94ed9c5393ef72725d159fe01139746 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf94ed9c5393ef72725d159fe01139746 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.input-error','data' => ['class' => 'mt-1 ml-1','messages' => $errors->get('name')]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('input-error'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'mt-1 ml-1','messages' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($errors->get('name'))]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalf94ed9c5393ef72725d159fe01139746)): ?>
<?php $attributes = $__attributesOriginalf94ed9c5393ef72725d159fe01139746; ?>
<?php unset($__attributesOriginalf94ed9c5393ef72725d159fe01139746); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalf94ed9c5393ef72725d159fe01139746)): ?>
<?php $component = $__componentOriginalf94ed9c5393ef72725d159fe01139746; ?>
<?php unset($__componentOriginalf94ed9c5393ef72725d159fe01139746); ?>
<?php endif; ?>
                    </div>
                    <div class="space-y-2">
                        <label for="email" class="text-[10px] font-bold uppercase tracking-widest text-slate-400 ml-1">Địa chỉ thư điện tử</label>
                        <input id="email" name="email" type="email" class="saas-input" value="<?php echo e(old('email', $sinhvien->user?->email)); ?>" required />
                        <?php if (isset($component)) { $__componentOriginalf94ed9c5393ef72725d159fe01139746 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf94ed9c5393ef72725d159fe01139746 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.input-error','data' => ['class' => 'mt-1 ml-1','messages' => $errors->get('email')]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('input-error'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'mt-1 ml-1','messages' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($errors->get('email'))]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalf94ed9c5393ef72725d159fe01139746)): ?>
<?php $attributes = $__attributesOriginalf94ed9c5393ef72725d159fe01139746; ?>
<?php unset($__attributesOriginalf94ed9c5393ef72725d159fe01139746); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalf94ed9c5393ef72725d159fe01139746)): ?>
<?php $component = $__componentOriginalf94ed9c5393ef72725d159fe01139746; ?>
<?php unset($__componentOriginalf94ed9c5393ef72725d159fe01139746); ?>
<?php endif; ?>
                    </div>

                    <div class="space-y-2">
                        <label for="ma_sinh_vien" class="text-[10px] font-bold uppercase tracking-widest text-slate-400 ml-1">Mã sinh viên</label>
                        <input id="ma_sinh_vien" name="ma_sinh_vien" type="text" class="saas-input font-bold tabular-nums" value="<?php echo e(old('ma_sinh_vien', $sinhvien->ma_sinh_vien)); ?>" required />
                        <?php if (isset($component)) { $__componentOriginalf94ed9c5393ef72725d159fe01139746 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf94ed9c5393ef72725d159fe01139746 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.input-error','data' => ['class' => 'mt-1 ml-1','messages' => $errors->get('ma_sinh_vien')]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('input-error'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'mt-1 ml-1','messages' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($errors->get('ma_sinh_vien'))]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalf94ed9c5393ef72725d159fe01139746)): ?>
<?php $attributes = $__attributesOriginalf94ed9c5393ef72725d159fe01139746; ?>
<?php unset($__attributesOriginalf94ed9c5393ef72725d159fe01139746); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalf94ed9c5393ef72725d159fe01139746)): ?>
<?php $component = $__componentOriginalf94ed9c5393ef72725d159fe01139746; ?>
<?php unset($__componentOriginalf94ed9c5393ef72725d159fe01139746); ?>
<?php endif; ?>
                    </div>
                    <div class="space-y-2">
                        <label for="lop" class="text-[10px] font-bold uppercase tracking-widest text-slate-400 ml-1">Lớp</label>
                        <input id="lop" name="lop" type="text" class="saas-input" value="<?php echo e(old('lop', $sinhvien->lop)); ?>" placeholder="Ví dụ: CNTT K15" />
                        <?php if (isset($component)) { $__componentOriginalf94ed9c5393ef72725d159fe01139746 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf94ed9c5393ef72725d159fe01139746 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.input-error','data' => ['class' => 'mt-1 ml-1','messages' => $errors->get('lop')]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('input-error'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'mt-1 ml-1','messages' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($errors->get('lop'))]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalf94ed9c5393ef72725d159fe01139746)): ?>
<?php $attributes = $__attributesOriginalf94ed9c5393ef72725d159fe01139746; ?>
<?php unset($__attributesOriginalf94ed9c5393ef72725d159fe01139746); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalf94ed9c5393ef72725d159fe01139746)): ?>
<?php $component = $__componentOriginalf94ed9c5393ef72725d159fe01139746; ?>
<?php unset($__componentOriginalf94ed9c5393ef72725d159fe01139746); ?>
<?php endif; ?>
                    </div>

                    <div class="space-y-2">
                        <label for="khoa" class="text-[10px] font-bold uppercase tracking-widest text-slate-400 ml-1">Khoa</label>
                        <input id="khoa" name="khoa" type="text" class="saas-input" value="<?php echo e(old('khoa', $sinhvien->khoa)); ?>" placeholder="Ví dụ: Công nghệ thông tin" />
                        <?php if (isset($component)) { $__componentOriginalf94ed9c5393ef72725d159fe01139746 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf94ed9c5393ef72725d159fe01139746 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.input-error','data' => ['class' => 'mt-1 ml-1','messages' => $errors->get('khoa')]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('input-error'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'mt-1 ml-1','messages' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($errors->get('khoa'))]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalf94ed9c5393ef72725d159fe01139746)): ?>
<?php $attributes = $__attributesOriginalf94ed9c5393ef72725d159fe01139746; ?>
<?php unset($__attributesOriginalf94ed9c5393ef72725d159fe01139746); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalf94ed9c5393ef72725d159fe01139746)): ?>
<?php $component = $__componentOriginalf94ed9c5393ef72725d159fe01139746; ?>
<?php unset($__componentOriginalf94ed9c5393ef72725d159fe01139746); ?>
<?php endif; ?>
                    </div>
                    <div class="space-y-2">
                        <label for="ngay_nhap_hoc" class="text-[10px] font-bold uppercase tracking-widest text-slate-400 ml-1">Ngày nhập học</label>
                        <input id="ngay_nhap_hoc" name="ngay_nhap_hoc" type="date" class="saas-input tabular-nums" value="<?php echo e(old('ngay_nhap_hoc', $sinhvien->ngay_nhap_hoc?->format('Y-m-d'))); ?>" />
                        <?php if (isset($component)) { $__componentOriginalf94ed9c5393ef72725d159fe01139746 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf94ed9c5393ef72725d159fe01139746 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.input-error','data' => ['class' => 'mt-1 ml-1','messages' => $errors->get('ngay_nhap_hoc')]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('input-error'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'mt-1 ml-1','messages' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($errors->get('ngay_nhap_hoc'))]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalf94ed9c5393ef72725d159fe01139746)): ?>
<?php $attributes = $__attributesOriginalf94ed9c5393ef72725d159fe01139746; ?>
<?php unset($__attributesOriginalf94ed9c5393ef72725d159fe01139746); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalf94ed9c5393ef72725d159fe01139746)): ?>
<?php $component = $__componentOriginalf94ed9c5393ef72725d159fe01139746; ?>
<?php unset($__componentOriginalf94ed9c5393ef72725d159fe01139746); ?>
<?php endif; ?>
                    </div>

                    <div class="space-y-2">
                        <label for="phone" class="text-[10px] font-bold uppercase tracking-widest text-slate-400 ml-1">Số điện thoại</label>
                        <input id="phone" name="phone" type="text" class="saas-input tabular-nums" value="<?php echo e(old('phone', $sinhvien->user?->phone)); ?>" />
                        <?php if (isset($component)) { $__componentOriginalf94ed9c5393ef72725d159fe01139746 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf94ed9c5393ef72725d159fe01139746 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.input-error','data' => ['class' => 'mt-1 ml-1','messages' => $errors->get('phone')]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('input-error'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'mt-1 ml-1','messages' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($errors->get('phone'))]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalf94ed9c5393ef72725d159fe01139746)): ?>
<?php $attributes = $__attributesOriginalf94ed9c5393ef72725d159fe01139746; ?>
<?php unset($__attributesOriginalf94ed9c5393ef72725d159fe01139746); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalf94ed9c5393ef72725d159fe01139746)): ?>
<?php $component = $__componentOriginalf94ed9c5393ef72725d159fe01139746; ?>
<?php unset($__componentOriginalf94ed9c5393ef72725d159fe01139746); ?>
<?php endif; ?>
                    </div>
                    <div class="space-y-2">
                        <label for="gender" class="text-[10px] font-bold uppercase tracking-widest text-slate-400 ml-1">Giới tính</label>
                        <select id="gender" name="gender" class="saas-input font-bold !pr-10">
                            <option value="">-- Chọn giới tính --</option>
                            <option value="male" <?php echo e(old('gender', $sinhvien->user?->gender?->value) === 'male' ? 'selected' : ''); ?>>Nam</option>
                            <option value="female" <?php echo e(old('gender', $sinhvien->user?->gender?->value) === 'female' ? 'selected' : ''); ?>>Nữ</option>
                            <option value="other" <?php echo e(old('gender', $sinhvien->user?->gender?->value) === 'other' ? 'selected' : ''); ?>>Khác</option>
                        </select>
                        <?php if (isset($component)) { $__componentOriginalf94ed9c5393ef72725d159fe01139746 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf94ed9c5393ef72725d159fe01139746 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.input-error','data' => ['class' => 'mt-1 ml-1','messages' => $errors->get('gender')]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('input-error'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'mt-1 ml-1','messages' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($errors->get('gender'))]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalf94ed9c5393ef72725d159fe01139746)): ?>
<?php $attributes = $__attributesOriginalf94ed9c5393ef72725d159fe01139746; ?>
<?php unset($__attributesOriginalf94ed9c5393ef72725d159fe01139746); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalf94ed9c5393ef72725d159fe01139746)): ?>
<?php $component = $__componentOriginalf94ed9c5393ef72725d159fe01139746; ?>
<?php unset($__componentOriginalf94ed9c5393ef72725d159fe01139746); ?>
<?php endif; ?>
                    </div>

                    <div class="space-y-2">
                        <label for="dob" class="text-[10px] font-bold uppercase tracking-widest text-slate-400 ml-1">Ngày sinh</label>
                        <input id="dob" name="dob" type="date" class="saas-input tabular-nums" value="<?php echo e(old('dob', $sinhvien->user?->dob?->format('Y-m-d'))); ?>" />
                        <?php if (isset($component)) { $__componentOriginalf94ed9c5393ef72725d159fe01139746 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf94ed9c5393ef72725d159fe01139746 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.input-error','data' => ['class' => 'mt-1 ml-1','messages' => $errors->get('dob')]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('input-error'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'mt-1 ml-1','messages' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($errors->get('dob'))]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalf94ed9c5393ef72725d159fe01139746)): ?>
<?php $attributes = $__attributesOriginalf94ed9c5393ef72725d159fe01139746; ?>
<?php unset($__attributesOriginalf94ed9c5393ef72725d159fe01139746); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalf94ed9c5393ef72725d159fe01139746)): ?>
<?php $component = $__componentOriginalf94ed9c5393ef72725d159fe01139746; ?>
<?php unset($__componentOriginalf94ed9c5393ef72725d159fe01139746); ?>
<?php endif; ?>
                    </div>
                    <div class="space-y-2">
                        <label for="id_card" class="text-[10px] font-bold uppercase tracking-widest text-slate-400 ml-1">Số CCCD / Định danh</label>
                        <input id="id_card" name="id_card" type="text" class="saas-input tabular-nums" value="<?php echo e(old('id_card', $sinhvien->user?->id_card)); ?>" />
                        <?php if (isset($component)) { $__componentOriginalf94ed9c5393ef72725d159fe01139746 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf94ed9c5393ef72725d159fe01139746 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.input-error','data' => ['class' => 'mt-1 ml-1','messages' => $errors->get('id_card')]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('input-error'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'mt-1 ml-1','messages' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($errors->get('id_card'))]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalf94ed9c5393ef72725d159fe01139746)): ?>
<?php $attributes = $__attributesOriginalf94ed9c5393ef72725d159fe01139746; ?>
<?php unset($__attributesOriginalf94ed9c5393ef72725d159fe01139746); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalf94ed9c5393ef72725d159fe01139746)): ?>
<?php $component = $__componentOriginalf94ed9c5393ef72725d159fe01139746; ?>
<?php unset($__componentOriginalf94ed9c5393ef72725d159fe01139746); ?>
<?php endif; ?>
                    </div>
                </div>

                <div class="space-y-2">
                    <label for="address" class="text-[10px] font-bold uppercase tracking-widest text-slate-400 ml-1">Địa chỉ liên hệ</label>
                    <textarea id="address" name="address" rows="2" class="saas-input !h-auto py-3 resize-none font-medium" placeholder="Số nhà, tên đường, xã/phường, quận/huyện, tỉnh/thành phố..."><?php echo e(old('address', $sinhvien->user?->address)); ?></textarea>
                    <?php if (isset($component)) { $__componentOriginalf94ed9c5393ef72725d159fe01139746 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf94ed9c5393ef72725d159fe01139746 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.input-error','data' => ['class' => 'mt-1 ml-1','messages' => $errors->get('address')]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('input-error'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'mt-1 ml-1','messages' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($errors->get('address'))]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalf94ed9c5393ef72725d159fe01139746)): ?>
<?php $attributes = $__attributesOriginalf94ed9c5393ef72725d159fe01139746; ?>
<?php unset($__attributesOriginalf94ed9c5393ef72725d159fe01139746); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalf94ed9c5393ef72725d159fe01139746)): ?>
<?php $component = $__componentOriginalf94ed9c5393ef72725d159fe01139746; ?>
<?php unset($__componentOriginalf94ed9c5393ef72725d159fe01139746); ?>
<?php endif; ?>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-2">
                        <div class="text-[10px] font-bold uppercase tracking-widest text-slate-400 ml-1">Ảnh thẻ (3x4)</div>
                        <div class="overflow-hidden rounded-xl border border-slate-200/60 bg-slate-50/50 p-4">
                            <div class="flex items-start gap-4">
                                <div class="h-20 w-16 overflow-hidden rounded-lg bg-slate-100 border border-slate-200">
                                    <?php if($anhTheUrl): ?>
                                        <a href="<?php echo e($anhTheUrl); ?>" target="_blank" rel="noopener">
                                            <img src="<?php echo e($anhTheUrl); ?>" class="h-full w-full object-cover" />
                                        </a>
                                    <?php else: ?>
                                        <div class="flex h-full w-full items-center justify-center text-[10px] font-bold text-slate-300 uppercase italic">Chưa có</div>
                                    <?php endif; ?>
                                </div>
                                <div class="flex-1 space-y-2">
                                    <input type="file" name="anh_the" class="block w-full text-xs text-slate-500 file:mr-3 file:py-2 file:px-4 file:border-0 file:border-r file:border-slate-200 file:text-[10px] file:font-bold file:uppercase file:tracking-widest file:bg-white file:text-slate-900 hover:file:bg-slate-50 transition-colors cursor-pointer border border-slate-200 bg-white rounded-lg" />
                                    <?php if (isset($component)) { $__componentOriginalf94ed9c5393ef72725d159fe01139746 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf94ed9c5393ef72725d159fe01139746 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.input-error','data' => ['class' => 'mt-1 ml-1','messages' => $errors->get('anh_the')]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('input-error'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'mt-1 ml-1','messages' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($errors->get('anh_the'))]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalf94ed9c5393ef72725d159fe01139746)): ?>
<?php $attributes = $__attributesOriginalf94ed9c5393ef72725d159fe01139746; ?>
<?php unset($__attributesOriginalf94ed9c5393ef72725d159fe01139746); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalf94ed9c5393ef72725d159fe01139746)): ?>
<?php $component = $__componentOriginalf94ed9c5393ef72725d159fe01139746; ?>
<?php unset($__componentOriginalf94ed9c5393ef72725d159fe01139746); ?>
<?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="space-y-2">
                        <div class="text-[10px] font-bold uppercase tracking-widest text-slate-400 ml-1">Ảnh CCCD</div>
                        <div class="overflow-hidden rounded-xl border border-slate-200/60 bg-slate-50/50 p-4">
                            <div class="flex items-start gap-4">
                                <div class="h-20 w-32 overflow-hidden rounded-lg bg-slate-100 border border-slate-200">
                                    <?php if($anhCccdUrl): ?>
                                        <a href="<?php echo e($anhCccdUrl); ?>" target="_blank" rel="noopener">
                                            <img src="<?php echo e($anhCccdUrl); ?>" class="h-full w-full object-cover" />
                                        </a>
                                    <?php else: ?>
                                        <div class="flex h-full w-full items-center justify-center text-[10px] font-bold text-slate-300 uppercase italic">Chưa có</div>
                                    <?php endif; ?>
                                </div>
                                <div class="flex-1 space-y-2">
                                    <input type="file" name="anh_cccd" class="block w-full text-xs text-slate-500 file:mr-3 file:py-2 file:px-4 file:border-0 file:border-r file:border-slate-200 file:text-[10px] file:font-bold file:uppercase file:tracking-widest file:bg-white file:text-slate-900 hover:file:bg-slate-50 transition-colors cursor-pointer border border-slate-200 bg-white rounded-lg" />
                                    <?php if (isset($component)) { $__componentOriginalf94ed9c5393ef72725d159fe01139746 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf94ed9c5393ef72725d159fe01139746 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.input-error','data' => ['class' => 'mt-1 ml-1','messages' => $errors->get('anh_cccd')]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('input-error'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'mt-1 ml-1','messages' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($errors->get('anh_cccd'))]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalf94ed9c5393ef72725d159fe01139746)): ?>
<?php $attributes = $__attributesOriginalf94ed9c5393ef72725d159fe01139746; ?>
<?php unset($__attributesOriginalf94ed9c5393ef72725d159fe01139746); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalf94ed9c5393ef72725d159fe01139746)): ?>
<?php $component = $__componentOriginalf94ed9c5393ef72725d159fe01139746; ?>
<?php unset($__componentOriginalf94ed9c5393ef72725d159fe01139746); ?>
<?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex items-center justify-end gap-3 pt-6 border-t border-slate-100">
                    <button type="submit" class="saas-btn-primary h-11 px-6 shadow-lg shadow-emerald-500/20">
                        Lưu thay đổi
                    </button>
                    <button type="button" data-modal-hide="modal-edit-<?php echo e($sinhvien->id); ?>" class="saas-btn-secondary h-11 px-6">
                        Hủy bỏ
                    </button>
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
<?php /**PATH D:\laragon\www\hethongquanlyktxv1\resources\views/admin/sinhvien/chitiet.blade.php ENDPATH**/ ?>