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
     <?php $__env->slot('title', null, []); ?> <?php echo e(isset($toaNha) ? 'Hiệu chỉnh cấu trúc tòa nhà' : 'Khởi tạo thực thể tòa nhà'); ?> <?php $__env->endSlot(); ?>

    <div class="space-y-10 max-w-5xl">
        <?php if (isset($component)) { $__componentOriginalcb19cb35a534439097b02b8af91726ee = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalcb19cb35a534439097b02b8af91726ee = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.page-header','data' => ['title' => ''.e(isset($toaNha) ? 'Cấu hình tòa nhà' : 'Khởi tạo hạ tầng').'','subtitle' => 'Thiết lập các thông số định danh, phân bổ tầng và giới hạn quy mô cư trú.']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('admin.page-header'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => ''.e(isset($toaNha) ? 'Cấu hình tòa nhà' : 'Khởi tạo hạ tầng').'','subtitle' => 'Thiết lập các thông số định danh, phân bổ tầng và giới hạn quy mô cư trú.']); ?>
            <a href="<?php echo e(route('admin.toanha.index')); ?>" class="saas-btn-secondary h-11 px-5 shadow-sm">
                <svg class="mr-2.5 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"/></svg>
                Trở về danh sách
            </a>
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

        <form method="POST" action="<?php echo e(isset($toaNha) ? route('admin.toanha.capnhat', $toaNha->id) : route('admin.toanha.luu')); ?>" class="grid grid-cols-1 lg:grid-cols-12 gap-10 items-start">
            <?php echo csrf_field(); ?>
            <?php if(isset($toaNha)): ?>
                <?php echo method_field('PUT'); ?>
            <?php endif; ?>

            <div class="lg:col-span-7 space-y-10">
                <div class="saas-card p-10 border-slate-200/60 shadow-xl shadow-slate-200/10">
                    <h3 class="text-[10px] font-black text-slate-400 uppercase tracking-[0.25em] mb-10 flex items-center gap-2">
                        <span class="h-1.5 w-1.5 rounded-full bg-slate-400"></span>
                        Thông tin định danh thực thể
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div class="space-y-2.5">
                            <label for="ten_toa_nha" class="text-[10px] font-black text-slate-500 uppercase tracking-widest ml-1">Tên hiển thị nội bộ <span class="text-rose-500">*</span></label>
                            <input type="text" name="ten_toa_nha" id="ten_toa_nha" value="<?php echo e(old('ten_toa_nha', $toaNha->ten_toa_nha ?? '')); ?>" placeholder="Ví dụ: Tòa nhà A1" class="saas-input h-12 font-bold px-5" required />
                            <?php $__errorArgs = ['ten_toa_nha'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <p class="text-[10px] font-bold text-rose-500 uppercase tracking-wide mt-1.5 ml-1"><?php echo e($message); ?></p>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div class="space-y-2.5">
                            <label for="ma_toa_nha" class="text-[10px] font-black text-slate-500 uppercase tracking-widest ml-1">Mã định danh hệ thống <span class="text-rose-500">*</span></label>
                            <input type="text" name="ma_toa_nha" id="ma_toa_nha" value="<?php echo e(old('ma_toa_nha', $toaNha->ma_toa_nha ?? '')); ?>" placeholder="Ví dụ: A1" class="saas-input h-12 font-bold px-5" required />
                            <?php $__errorArgs = ['ma_toa_nha'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <p class="text-[10px] font-bold text-rose-500 uppercase tracking-wide mt-1.5 ml-1"><?php echo e($message); ?></p>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div class="md:col-span-2 space-y-2.5">
                            <label for="mo_ta" class="text-[10px] font-black text-slate-500 uppercase tracking-widest ml-1">Mô tả đặc tính vận hành</label>
                            <textarea name="mo_ta" id="mo_ta" rows="5" placeholder="Mô tả chi tiết về vị trí, quy tắc hoặc đặc điểm kỹ thuật riêng biệt của tòa nhà này..." class="saas-input p-5 resize-none leading-relaxed"><?php echo e(old('mo_ta', $toaNha->mo_ta ?? '')); ?></textarea>
                            <?php $__errorArgs = ['mo_ta'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <p class="text-[10px] font-bold text-rose-500 uppercase tracking-wide mt-1.5 ml-1"><?php echo e($message); ?></p>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                    </div>
                </div>

                <div class="flex items-center justify-end gap-5 pt-4">
                    <a href="<?php echo e(route('admin.toanha.index')); ?>" class="text-[11px] font-black text-slate-400 hover:text-slate-900 uppercase tracking-widest px-6 py-3 transition-all">Hủy bỏ thao tác</a>
                    <button type="submit" class="saas-btn-primary h-14 px-12 shadow-2xl shadow-emerald-500/30 text-xs font-black uppercase tracking-widest">
                        <?php echo e(isset($toaNha) ? 'Lưu cấu hình hệ thống' : 'Khởi tạo thực thể'); ?>

                    </button>
                </div>
            </div>

            <div class="lg:col-span-5 space-y-10">
                <div class="saas-card p-10 bg-slate-50/50 border-dashed border-slate-300">
                    <h3 class="text-[10px] font-black text-slate-400 uppercase tracking-[0.25em] mb-10 flex items-center gap-2">
                        <span class="h-1.5 w-1.5 rounded-full bg-brand-emerald shadow-[0_0_8px_rgba(16,185,129,0.45)]"></span>
                        Quy mô & Phân bổ hạ tầng
                    </h3>
                    
                    <div class="space-y-8">
                        <div class="space-y-2.5">
                            <label for="so_tang" class="text-[10px] font-black text-slate-500 uppercase tracking-widest ml-1">Giới hạn số tầng</label>
                            <div class="relative group">
                                <input type="number" name="so_tang" id="so_tang" value="<?php echo e(old('so_tang', $toaNha->so_tang ?? '')); ?>" min="1" max="50" placeholder="0" class="saas-input h-12 pl-14 font-black tabular-nums transition-all group-hover:border-slate-400 focus:border-brand-emerald" />
                                <div class="absolute inset-y-0 left-5 flex items-center text-slate-400 group-hover:text-brand-emerald transition-colors">
                                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                                </div>
                            </div>
                            <?php $__errorArgs = ['so_tang'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <p class="text-[10px] font-bold text-rose-500 uppercase tracking-wide mt-1.5 ml-1"><?php echo e($message); ?></p>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div class="space-y-2.5">
                            <label for="so_phong" class="text-[10px] font-black text-slate-500 uppercase tracking-widest ml-1">Định mức tổng số phòng</label>
                            <div class="relative group">
                                <input type="number" name="so_phong" id="so_phong" value="<?php echo e(old('so_phong', $toaNha->so_phong ?? '')); ?>" min="1" max="2000" placeholder="0" class="saas-input h-12 pl-14 font-black tabular-nums transition-all group-hover:border-slate-400 focus:border-brand-emerald" />
                                <div class="absolute inset-y-0 left-5 flex items-center text-slate-400 group-hover:text-brand-emerald transition-colors">
                                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                                </div>
                            </div>
                            <?php $__errorArgs = ['so_phong'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <p class="text-[10px] font-bold text-rose-500 uppercase tracking-wide mt-1.5 ml-1"><?php echo e($message); ?></p>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <?php
                            $selectedGender = old('gioi_tinh_han_che', $defaultGioiTinhHanChe ?? 'any');
                        ?>
                        <div class="space-y-2.5">
                            <label for="gioi_tinh_han_che" class="text-[10px] font-black text-slate-500 uppercase tracking-widest ml-1">Phân hệ đối tượng mặc định</label>
                            <select name="gioi_tinh_han_che" id="gioi_tinh_han_che" class="saas-input h-12 font-bold px-5 border-slate-200">
                                <option value="any" <?php if($selectedGender === 'any'): echo 'selected'; endif; ?>>Phân hệ: Hỗn hợp / Toàn bộ</option>
                                <option value="male" <?php if($selectedGender === 'male'): echo 'selected'; endif; ?>>Phân hệ: Chỉ Nam giới</option>
                                <option value="female" <?php if($selectedGender === 'female'): echo 'selected'; endif; ?>>Phân hệ: Chỉ Nữ giới</option>
                            </select>
                        </div>

                        <div class="p-6 rounded-2xl <?php echo e(isset($toaNha) ? 'bg-slate-100 border-slate-200' : 'bg-emerald-50 border-emerald-100/60 shadow-emerald-500/5'); ?> border shadow-sm mt-4">
                            <div class="flex gap-4">
                                <svg class="h-5 w-5 <?php echo e(isset($toaNha) ? 'text-slate-400' : 'text-emerald-600'); ?> flex-shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                <p class="text-[11px] font-bold <?php echo e(isset($toaNha) ? 'text-slate-500' : 'text-emerald-800'); ?> leading-relaxed uppercase tracking-tight">
                                    <?php if(isset($toaNha)): ?>
                                        Áp dụng khi hệ thống tự tạo thêm phòng theo quy mô mới, các phòng đã tồn tại sẽ giữ nguyên.
                                    <?php else: ?>
                                        Quy tắc khởi tạo tự động: <span class="<?php echo e(isset($toaNha) ? 'text-slate-900' : 'text-emerald-950'); ?>">[MãTòa][Tầng][STT]</span> (Ví dụ: A1101, B2105...).
                                    <?php endif; ?>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
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
<?php /**PATH D:\laragon\www\hethongquanlyktxv1\resources\views/admin/toanha/form.blade.php ENDPATH**/ ?>