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
     <?php $__env->slot('title', null, []); ?> Quản lý Phòng nội trú <?php $__env->endSlot(); ?>

    <div class="space-y-8">
        <?php if (isset($component)) { $__componentOriginalcb19cb35a534439097b02b8af91726ee = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalcb19cb35a534439097b02b8af91726ee = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.page-header','data' => ['title' => 'Hệ thống phòng','subtitle' => 'Quản lý quỹ phòng, nhân khẩu và trạng thái hạ tầng toàn bộ KTX.']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('admin.page-header'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Hệ thống phòng','subtitle' => 'Quản lý quỹ phòng, nhân khẩu và trạng thái hạ tầng toàn bộ KTX.']); ?>
            <div class="flex items-center gap-2">
                <button type="button" data-modal-target="modal-themphong" data-modal-toggle="modal-themphong" class="saas-btn-primary h-11 px-6 shadow-lg shadow-blue-500/20">
                    <svg class="mr-2 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
                    Thêm phòng mới
                </button>
                <button type="button" data-modal-target="modal-gan-taisan" data-modal-toggle="modal-gan-taisan" class="saas-btn-secondary h-11 px-6">
                    <svg class="mr-2 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M20 7h-7m7 0v7m0-7-2 2m-6 0H4v12h12V9m0 0 2-2"/></svg>
                    Thêm tài sản
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

        
        <div class="saas-card p-6 bg-slate-50/50 border-dashed">
            <form action="<?php echo e(route('admin.phong.index')); ?>" method="GET" class="flex flex-wrap items-end gap-6">
                <div class="flex-1 min-w-[300px]">
                    <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-2 ml-1">Tìm kiếm định danh</label>
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-4 flex items-center text-slate-400 group-focus-within:text-blue-500 transition-colors pointer-events-none">
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="m21 21-4.35-4.35M10.5 18a7.5 7.5 0 1 1 0-15 7.5 7.5 0 0 1 0 15z" /></svg>
                        </div>
                        <input type="text" name="q" value="<?php echo e(request('q')); ?>" placeholder="Mã phòng (VD: P.101)..." class="saas-input pl-12 h-11">
                    </div>
                </div>

                <div class="w-auto min-w-[200px]">
                    <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-2 ml-1">Khu vực tòa nhà</label>
                    <div class="relative group">
                        <select name="toa_nha_id" class="saas-input font-bold h-11 !pr-10" onchange="this.form.submit()">
                            <option value="">Tất cả các tòa</option>
                            <?php $__currentLoopData = $toanhis; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $toa): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($toa->id); ?>" <?php if(request('toa_nha_id') == $toa->id): echo 'selected'; endif; ?>><?php echo e($toa->ten_toa_nha); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                </div>

                <div class="w-auto min-w-[140px]">
                    <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-2 ml-1">Vị trí tầng</label>
                    <select name="tang" class="saas-input font-bold h-11" onchange="this.form.submit()">
                        <option value="">Tất cả tầng</option>
                        <?php $__currentLoopData = $danhsachtang; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $t): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($t); ?>" <?php if(request('tang') == $t): echo 'selected'; endif; ?>>Tầng <?php echo e($t); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>

                <div class="flex items-center gap-1.5 h-11 bg-white p-1 rounded-xl border border-slate-200 shadow-sm">
                    <a href="<?php echo e(route('admin.phong.index', array_merge(request()->query(), ['view' => 'table']))); ?>" 
                       class="flex h-9 w-9 items-center justify-center rounded-lg transition-all <?php echo e($viewMode === 'table' ? 'bg-slate-900 text-white shadow-md' : 'text-slate-400 hover:text-slate-600 hover:bg-slate-50'); ?>" title="Chế độ bảng">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 6h16M4 10h16M4 14h16M4 18h16"/></svg>
                    </a>
                    <a href="<?php echo e(route('admin.phong.index', array_merge(request()->query(), ['view' => 'grid']))); ?>" 
                       class="flex h-9 w-9 items-center justify-center rounded-lg transition-all <?php echo e($viewMode === 'grid' ? 'bg-slate-900 text-white shadow-md' : 'text-slate-400 hover:text-slate-600 hover:bg-slate-50'); ?>" title="Chế độ lưới">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/></svg>
                    </a>
                </div>
            </form>
        </div>

        <?php if($viewMode === 'table'): ?>
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
                        <th class="text-center">Sức chứa</th>
                        <th class="text-center">Đối tượng</th>
                        <th>Mật độ lấp đầy</th>
                        <th class="text-center">Trạng thái</th>
                        <th class="text-right">Đơn giá</th>
                        <th class="text-right">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $danhsachphong; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $phong): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <?php
                            $succhuamax = $phong->loaiphong->suc_chua ?? 0;
                            $soluongdango = $soluongdango_theophong[$phong->id] ?? 0;
                            $daydu = $succhuamax > 0 && $soluongdango >= $succhuamax;
                            $phantram = $succhuamax > 0 ? min(100, round($soluongdango / $succhuamax * 100)) : 0;
                        ?>
                        <tr class="hover:bg-slate-50/50 transition-colors group">
                            <td class="py-5">
                                <div class="text-sm font-bold text-slate-900 leading-tight group-hover:text-blue-600 transition-colors"><?php echo e($phong->ten_phong); ?></div>
                                <div class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-1.5">Tầng <?php echo e($phong->tang); ?> • Tòa <?php echo e($phong->toanha->ten_toa_nha ?? 'Chưa có'); ?></div>
                            </td>
                            <td class="py-5 text-center">
                                <span class="text-xs font-bold text-slate-600 tabular-nums bg-slate-100 px-2 py-1 rounded-lg"><?php echo e($succhuamax); ?> người</span>
                            </td>
                            <td class="py-5 text-center">
                                <?php
                                    $genderBadgeRoom = match($phong->gioi_tinh_han_che->value) {
                                        'male' => 'saas-badge-info',
                                        'female' => 'saas-badge-error',
                                        default => 'saas-badge-success',
                                    };
                                ?>
                                <span class="saas-badge <?php echo e($genderBadgeRoom); ?>">
                                    <?php echo e($phong->gioi_tinh_han_che->label()); ?>

                                </span>
                            </td>
                            <td class="py-5 min-w-[150px]">
                                <div class="flex items-center gap-3">
                                    <div class="flex-1 h-1.5 bg-slate-100 rounded-full overflow-hidden">
                                        <div class="h-full rounded-full transition-all duration-700 <?php echo e($daydu ? 'bg-slate-900' : 'bg-blue-600'); ?>" style="<?php echo \Illuminate\Support\Arr::toCssStyles(["width: $phantram%"]) ?>"></div>
                                    </div>
                                    <span class="text-[11px] font-bold text-slate-900 tabular-nums"><?php echo e($soluongdango); ?>/<?php echo e($succhuamax); ?></span>
                                </div>
                            </td>
                            <td class="py-5 text-center">
                                <?php if($daydu): ?>
                                    <span class="inline-flex items-center gap-1.5 text-[10px] font-bold text-slate-400 uppercase tracking-wider">
                                        <span class="h-1.5 w-1.5 rounded-full bg-slate-300"></span>
                                        Kín chỗ
                                    </span>
                                <?php else: ?>
                                    <span class="inline-flex items-center gap-1.5 text-[10px] font-bold text-emerald-600 uppercase tracking-wider">
                                        <span class="h-1.5 w-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                                        Còn trống
                                    </span>
                                <?php endif; ?>
                            </td>
                            <td class="py-5 text-right">
                                <div class="text-sm font-bold text-slate-900 tabular-nums"><?php echo e(number_format($phong->loaiphong->gia_thang ?? 0, 0, ',', '.')); ?>đ</div>
                                <div class="text-[9px] text-slate-400 font-bold uppercase tracking-widest mt-1">VND / Tháng</div>
                            </td>
                            <td class="py-5 text-right">
                                <div class="flex items-center justify-end gap-1">
                                    <a href="<?php echo e(route('admin.phong.chitiet', ['id' => $phong->id])); ?>" class="h-9 w-9 inline-flex items-center justify-center text-slate-400 hover:text-blue-600 hover:bg-blue-50 border border-transparent hover:border-blue-100 rounded-xl transition-all shadow-sm hover:shadow-md" title="Chi tiết cư trú">
                                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                    </a>
                                    <button type="button" data-modal-target="modal-capnhatphong-<?php echo e($phong->id); ?>" data-modal-toggle="modal-capnhatphong-<?php echo e($phong->id); ?>" class="h-9 w-9 inline-flex items-center justify-center text-slate-400 hover:text-blue-600 hover:bg-blue-50 border border-transparent hover:border-blue-100 rounded-xl transition-all shadow-sm hover:shadow-md" title="Chỉnh sửa thông số">
                                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                    </button>
                                    <form method="POST" action="<?php echo e(route('admin.phong.xoa', ['id' => $phong->id])); ?>" onsubmit="return confirm('Xác nhận loại bỏ hoàn toàn phòng này khỏi hệ thống?')" class="inline">
                                        <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                        <button type="submit" class="h-9 w-9 inline-flex items-center justify-center text-slate-400 hover:text-rose-600 hover:bg-rose-50 border border-transparent hover:border-rose-100 rounded-xl transition-all shadow-sm hover:shadow-md" title="Loại bỏ">
                                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6M9 7h6m-7 0V5a2 2 0 012-2h2a2 2 0 012 2v2"/></svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="7" class="py-24 text-center">
                                <div class="flex flex-col items-center gap-4 text-slate-200">
                                    <svg class="h-14 w-14" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m4 0h1m-4 12h1m4 0h1m-4-4h1m4 0h1m-4-4h1m4 0h1m-4-4h1m4 0h1"/></svg>
                                    <p class="text-sm font-bold text-slate-400 uppercase tracking-widest">Không có dữ liệu phòng phù hợp</p>
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
            <?php if(method_exists($danhsachphong, 'links')): ?>
                <div class="mt-8">
                    <?php echo e($danhsachphong->appends(request()->query())->links()); ?>

                </div>
            <?php endif; ?>
        <?php else: ?>
            <div class="grid grid-cols-1 gap-8 sm:grid-cols-2 lg:grid-cols-3">
                <?php $__empty_1 = true; $__currentLoopData = $danhsachphong; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $phong): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <?php
                        $succhuamax = $phong->loaiphong->suc_chua ?? 0;
                        $soluongdango = $soluongdango_theophong[$phong->id] ?? 0;
                        $daydu = $succhuamax > 0 && $soluongdango >= $succhuamax;
                        $phantram = $succhuamax > 0 ? min(100, round($soluongdango / $succhuamax * 100)) : 0;
                        $isFemaleRoom = $phong->gioi_tinh_han_che->value === 'female';
                        $isMaleRoom = $phong->gioi_tinh_han_che->value === 'male';
                    ?>
                    <article class="saas-card p-6 relative overflow-hidden group hover:border-blue-200 transition-all hover:shadow-xl hover:shadow-blue-500/5">
                        <div class="absolute top-0 right-0 h-1.5 w-full <?php echo e($daydu ? 'bg-slate-900' : ($isFemaleRoom ? 'bg-rose-500' : ($isMaleRoom ? 'bg-blue-500' : 'bg-emerald-500'))); ?>"></div>
                        
                        <header class="flex items-start justify-between mb-10">
                            <div>
                                <h3 class="text-4xl font-bold text-slate-900 leading-none tabular-nums group-hover:text-blue-600 transition-colors"><?php echo e($phong->ten_phong); ?></h3>
                                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-3">Tầng <?php echo e($phong->tang); ?> • Tòa <?php echo e($phong->toanha->ten_toa_nha ?? 'Chưa có'); ?></p>
                            </div>
                            <div class="h-11 w-11 rounded-xl bg-slate-50 flex items-center justify-center text-slate-400 group-hover:bg-blue-50 group-hover:text-blue-500 transition-colors border border-slate-100 shadow-sm">
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                            </div>
                        </header>

                        <div class="space-y-6">
                            <div>
                                <div class="flex items-end justify-between mb-2.5">
                                    <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Mật độ lấp đầy</span>
                                    <span class="text-xs font-bold text-slate-900 tabular-nums"><?php echo e($soluongdango); ?> / <?php echo e($succhuamax); ?> <span class="text-slate-300 font-medium">Giường</span></span>
                                </div>
                                <div class="h-2 w-full bg-slate-100 rounded-full overflow-hidden">
                                    <div class="h-full rounded-full transition-all duration-1000 <?php echo e($daydu ? 'bg-slate-900' : 'bg-blue-600'); ?>" style="<?php echo \Illuminate\Support\Arr::toCssStyles(["width: $phantram%"]) ?>"></div>
                                </div>
                            </div>
                            
                            <div class="flex items-center justify-between pt-5 border-t border-slate-100">
                                <div class="flex flex-col">
                                    <span class="text-[9px] font-bold text-slate-400 uppercase tracking-widest">Đơn giá định kỳ</span>
                                    <span class="text-sm font-bold text-slate-900 tabular-nums"><?php echo e(number_format($phong->loaiphong->gia_thang ?? 0, 0, ',', '.')); ?>đ</span>
                                </div>
                                <span class="saas-badge <?php echo e($daydu ? 'saas-badge-error' : 'saas-badge-success'); ?>">
                                    <?php echo e($daydu ? 'Full' : 'Available'); ?>

                                </span>
                            </div>
                        </div>

                        <div class="mt-8 flex items-center justify-end gap-1.5">
                            <a href="<?php echo e(route('admin.phong.chitiet', ['id' => $phong->id])); ?>" class="h-9 w-9 inline-flex items-center justify-center text-slate-400 hover:text-blue-600 hover:bg-blue-50 border border-transparent hover:border-blue-100 rounded-xl transition-all shadow-sm hover:shadow-md" title="Chi tiết cư trú">
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                            </a>
                            <button type="button" data-modal-target="modal-capnhatphong-<?php echo e($phong->id); ?>" data-modal-toggle="modal-capnhatphong-<?php echo e($phong->id); ?>" class="h-9 w-9 inline-flex items-center justify-center text-slate-400 hover:text-blue-600 hover:bg-blue-50 border border-transparent hover:border-blue-100 rounded-xl transition-all shadow-sm hover:shadow-md" title="Chỉnh sửa">
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                            </button>
                            <form method="POST" action="<?php echo e(route('admin.phong.xoa', ['id' => $phong->id])); ?>" onsubmit="return confirm('Xác nhận loại bỏ phòng?')" class="inline">
                                <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                <button type="submit" class="h-9 w-9 inline-flex items-center justify-center text-slate-400 hover:text-rose-600 hover:bg-rose-50 border border-transparent hover:border-rose-100 rounded-xl transition-all shadow-sm hover:shadow-md" title="Loại bỏ">
                                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6M9 7h6m-7 0V5a2 2 0 012-2h2a2 2 0 012 2v2"/></svg>
                                </button>
                            </form>
                        </div>
                    </article>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <div class="col-span-full py-24 text-center saas-card bg-slate-50/50 border-dashed border-2">
                        <div class="inline-flex h-16 w-16 items-center justify-center rounded-2xl bg-white text-slate-200 mb-5 shadow-sm border border-slate-100">
                            <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m4 0h1m-4 12h1m4 0h1m-4-4h1m4 0h1m-4-4h1m4 0h1m-4-4h1m4 0h1m-4-4h1m4 0h1"/></svg>
                        </div>
                        <h3 class="text-base font-bold text-slate-900 uppercase tracking-tight">Chưa có dữ liệu phòng</h3>
                        <p class="mt-2 text-xs text-slate-500 max-w-sm mx-auto font-medium">Hệ thống hiện tại chưa ghi nhận phòng nội trú nào phù hợp với các tiêu chí lọc đã chọn.</p>
                    </div>
                <?php endif; ?>
            </div>
            <?php if(method_exists($danhsachphong, 'links')): ?>
                <div class="mt-8">
                    <?php echo e($danhsachphong->appends(request()->query())->links()); ?>

                </div>
            <?php endif; ?>
        <?php endif; ?>
    </div>

    <?php $__env->startPush('modals'); ?>
        
        <?php if (isset($component)) { $__componentOriginal9f64f32e90b9102968f2bc548315018c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9f64f32e90b9102968f2bc548315018c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.modal','data' => ['id' => 'modal-themphong','title' => 'Thêm phòng mới','subtitle' => 'Khởi tạo thực thể phòng mới trong cơ sở hạ tầng KTX.']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('modal'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['id' => 'modal-themphong','title' => 'Thêm phòng mới','subtitle' => 'Khởi tạo thực thể phòng mới trong cơ sở hạ tầng KTX.']); ?>
            <form method="POST" action="<?php echo e(route('admin.phong.luu')); ?>" class="space-y-6">
                <?php echo csrf_field(); ?>
                <div class="grid grid-cols-2 gap-6">
                    <div class="space-y-2">
                        <label class="text-[10px] font-bold uppercase tracking-widest text-slate-400 ml-1">Khu vực tòa nhà</label>
                        <select name="toa_nha_id" class="saas-input font-bold" required>
                            <option value="">-- Chọn tòa --</option>
                            <?php $__currentLoopData = $toanhis; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $toa): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($toa->id); ?>"><?php echo e($toa->ten_toa_nha); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                    <div class="space-y-2">
                        <label class="text-[10px] font-bold uppercase tracking-widest text-slate-400 ml-1">Vị trí tầng</label>
                        <input name="tang" type="number" value="<?php echo e(old('tang')); ?>" class="saas-input font-bold" placeholder="VD: 1, 2..." required />
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-6">
                    <div class="space-y-2">
                        <label class="text-[10px] font-bold uppercase tracking-widest text-slate-400 ml-1">Tên phòng (Mã định danh)</label>
                        <input name="ten_phong" value="<?php echo e(old('ten_phong')); ?>" class="saas-input font-bold" placeholder="VD: P.101" required />
                        <input type="hidden" name="loai_phong_id" value="<?php echo e($loaiphongs->first()->id ?? 1); ?>" />
                    </div>
                    <div class="space-y-2">
                        <label class="text-[10px] font-bold uppercase tracking-widest text-slate-400 ml-1">Giới tính quy định</label>
                        <select name="gioi_tinh_han_che" class="saas-input font-bold" required>
                            <option value="male">Nam giới</option>
                            <option value="female">Nữ giới</option>
                            <option value="any">Không giới hạn</option>
                        </select>
                    </div>
                </div>

                <div class="space-y-2">
                    <label class="text-[10px] font-bold uppercase tracking-widest text-slate-400 ml-1">Ghi chú vận hành (tùy chọn)</label>
                    <textarea name="mo_ta" rows="3" class="saas-input !h-auto !py-4 resize-none font-medium" placeholder="Thông tin bổ sung về hiện trạng, tiện nghi hoặc các lưu ý đặc biệt..."></textarea>
                </div>

                <div class="flex gap-4 pt-4">
                    <button type="button" data-modal-hide="modal-themphong" class="flex-1 saas-btn-secondary h-12">Hủy bỏ</button>
                    <button type="submit" class="flex-[2] saas-btn-primary h-12 shadow-lg shadow-blue-500/20">Khởi tạo phòng ngay</button>
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

        <?php if (isset($component)) { $__componentOriginal9f64f32e90b9102968f2bc548315018c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9f64f32e90b9102968f2bc548315018c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.modal','data' => ['id' => 'modal-gan-taisan','title' => 'Thêm tài sản (gán hàng loạt)','subtitle' => 'Nhập loại tài sản và gán cho toàn bộ phòng trong 1 tòa, hoặc gán cho 1 phòng cụ thể.']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('modal'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['id' => 'modal-gan-taisan','title' => 'Thêm tài sản (gán hàng loạt)','subtitle' => 'Nhập loại tài sản và gán cho toàn bộ phòng trong 1 tòa, hoặc gán cho 1 phòng cụ thể.']); ?>
            <form method="POST" action="<?php echo e(route('admin.taisan.gan_hang_loat')); ?>" class="space-y-6" x-data="{ phamVi: '<?php echo e(old('pham_vi', 'toa')); ?>' }">
                <?php echo csrf_field(); ?>

                <div class="space-y-2">
                    <label class="text-[10px] font-bold uppercase tracking-widest text-slate-400 ml-1">Phạm vi áp dụng</label>
                    <div class="grid grid-cols-2 gap-2 rounded-2xl bg-slate-50 p-1 border border-slate-100">
                        <label class="cursor-pointer">
                            <input type="radio" name="pham_vi" value="toa" class="sr-only" x-model="phamVi">
                            <div :class="phamVi === 'toa' ? 'bg-slate-900 text-white shadow-sm' : 'text-slate-600 hover:text-slate-900'" class="h-10 rounded-xl flex items-center justify-center text-[10px] font-bold uppercase tracking-widest transition-all">
                                Theo tòa
                            </div>
                        </label>
                        <label class="cursor-pointer">
                            <input type="radio" name="pham_vi" value="phong" class="sr-only" x-model="phamVi">
                            <div :class="phamVi === 'phong' ? 'bg-slate-900 text-white shadow-sm' : 'text-slate-600 hover:text-slate-900'" class="h-10 rounded-xl flex items-center justify-center text-[10px] font-bold uppercase tracking-widest transition-all">
                                Theo phòng
                            </div>
                        </label>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-2" x-show="phamVi === 'toa'" x-cloak>
                        <label class="text-[10px] font-bold uppercase tracking-widest text-slate-400 ml-1">Chọn tòa</label>
                        <select name="toa_nha_id" class="saas-input font-bold" :required="phamVi === 'toa'">
                            <option value="">-- Chọn tòa --</option>
                            <?php $__currentLoopData = $toanhis; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $toa): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($toa->id); ?>" <?php if(old('toa_nha_id') == $toa->id): echo 'selected'; endif; ?>><?php echo e($toa->ten_toa_nha); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>

                    <div class="space-y-2" x-show="phamVi === 'phong'" x-cloak>
                        <label class="text-[10px] font-bold uppercase tracking-widest text-slate-400 ml-1">Chọn phòng</label>
                        <select name="phong_id" class="saas-input font-bold" :required="phamVi === 'phong'">
                            <option value="">-- Chọn phòng --</option>
                            <?php $__currentLoopData = $toanhis; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $toa): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php $phongsByToa = ($tatCaPhongChoChon ?? collect())->where('toa_nha_id', $toa->id); ?>
                                <?php if($phongsByToa->count() > 0): ?>
                                    <optgroup label="Tòa <?php echo e($toa->ten_toa_nha); ?>">
                                        <?php $__currentLoopData = $phongsByToa; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($p->id); ?>" <?php if(old('phong_id') == $p->id): echo 'selected'; endif; ?>><?php echo e($p->ten_phong); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </optgroup>
                                <?php endif; ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>

                    <div class="space-y-2">
                        <label class="text-[10px] font-bold uppercase tracking-widest text-slate-400 ml-1">Tên tài sản</label>
                        <input name="ten_tai_san" value="<?php echo e(old('ten_tai_san')); ?>" class="saas-input font-bold" placeholder="VD: Giường đơn, Tủ, Quạt..." required maxlength="100" />
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-6">
                    <div class="space-y-2">
                        <label class="text-[10px] font-bold uppercase tracking-widest text-slate-400 ml-1">Số lượng</label>
                        <input name="so_luong" type="number" value="<?php echo e(old('so_luong', 1)); ?>" class="saas-input font-bold tabular-nums" min="1" required />
                    </div>
                    <div class="space-y-2">
                        <label class="text-[10px] font-bold uppercase tracking-widest text-slate-400 ml-1">Tình trạng</label>
                        <input name="tinh_trang" value="<?php echo e(old('tinh_trang', 'Tốt')); ?>" class="saas-input font-bold" maxlength="100" required />
                    </div>
                </div>

                <label class="flex items-center gap-3 rounded-2xl bg-slate-50 p-4 border border-slate-100">
                    <input type="checkbox" name="cong_don" value="1" class="h-4 w-4 rounded border-slate-300 text-blue-600 focus:ring-blue-500" <?php if(old('cong_don', '1') == '1'): echo 'checked'; endif; ?>>
                    <div class="min-w-0">
                        <div class="text-xs font-bold text-slate-900">Nếu phòng đã có tài sản này</div>
                        <div class="text-[11px] font-medium text-slate-500">Cộng dồn số lượng (không tạo bản ghi trùng tên tài sản).</div>
                    </div>
                </label>

                <div class="flex gap-4 pt-2">
                    <button type="button" data-modal-hide="modal-gan-taisan" class="flex-1 saas-btn-secondary h-12">Hủy bỏ</button>
                    <button type="submit" class="flex-[2] saas-btn-primary h-12 shadow-lg shadow-blue-500/20">Gán tài sản</button>
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

        
        <?php $__currentLoopData = $danhsachphong; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $phong): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php if (isset($component)) { $__componentOriginal9f64f32e90b9102968f2bc548315018c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9f64f32e90b9102968f2bc548315018c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.modal','data' => ['id' => 'modal-capnhatphong-'.e($phong->id).'','title' => 'Cập nhật phòng','subtitle' => 'Thay đổi thông số vận hành và quy định cho phòng '.e($phong->ten_phong).'.']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('modal'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['id' => 'modal-capnhatphong-'.e($phong->id).'','title' => 'Cập nhật phòng','subtitle' => 'Thay đổi thông số vận hành và quy định cho phòng '.e($phong->ten_phong).'.']); ?>
                <form method="POST" action="<?php echo e(route('admin.phong.capnhat', ['id' => $phong->id])); ?>" class="space-y-6">
                    <?php echo csrf_field(); ?>
                    <div class="grid grid-cols-2 gap-6">
                        <div class="space-y-2">
                            <label class="text-[10px] font-bold uppercase tracking-widest text-slate-400 ml-1">Khu vực tòa nhà</label>
                            <select name="toa_nha_id" class="saas-input font-bold" required>
                                <?php $__currentLoopData = $toanhis; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $toa): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($toa->id); ?>" <?php if($phong->toa_nha_id == $toa->id): echo 'selected'; endif; ?>><?php echo e($toa->ten_toa_nha); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                        <div class="space-y-2">
                            <label class="text-[10px] font-bold uppercase tracking-widest text-slate-400 ml-1">Vị trí tầng</label>
                            <input name="tang" type="number" value="<?php echo e($phong->tang); ?>" class="saas-input font-bold" required />
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-6">
                        <div class="space-y-2">
                            <label class="text-[10px] font-bold uppercase tracking-widest text-slate-400 ml-1">Mã định danh phòng</label>
                            <input name="ten_phong" value="<?php echo e($phong->ten_phong); ?>" class="saas-input font-bold" required />
                            <input type="hidden" name="loai_phong_id" value="<?php echo e($phong->loai_phong_id); ?>" />
                        </div>
                        <div class="space-y-2">
                            <label class="text-[10px] font-bold uppercase tracking-widest text-slate-400 ml-1">Giới tính quy định</label>
                            <select name="gioi_tinh_han_che" class="saas-input font-bold" required>
                                <?php $__currentLoopData = \App\Enums\Gender::cases(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $gender): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($gender->value); ?>" <?php if($phong->gioi_tinh_han_che->value == $gender->value): echo 'selected'; endif; ?>><?php echo e($gender->label()); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                    </div>

                    <div class="space-y-2">
                        <label class="text-[10px] font-bold uppercase tracking-widest text-slate-400 ml-1">Ghi chú vận hành</label>
                        <textarea name="mo_ta" rows="3" class="saas-input !h-auto !py-4 resize-none font-medium"><?php echo e($phong->mo_ta); ?></textarea>
                    </div>

                    <div class="flex gap-4 pt-4">
                        <button type="button" data-modal-hide="modal-capnhatphong-<?php echo e($phong->id); ?>" class="flex-1 saas-btn-secondary h-12">Hủy bỏ</button>
                        <button type="submit" class="flex-[2] saas-btn-primary h-12 shadow-lg shadow-blue-500/20">Lưu thay đổi</button>
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
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
<?php /**PATH D:\laragon\www\hethongquanlyktxv1\resources\views/admin/phong/danhsach.blade.php ENDPATH**/ ?>