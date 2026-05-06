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
     <?php $__env->slot('title', null, []); ?> Phát hành Thông báo nội khu <?php $__env->endSlot(); ?>

    <div class="space-y-8">
        <?php if (isset($component)) { $__componentOriginalcb19cb35a534439097b02b8af91726ee = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalcb19cb35a534439097b02b8af91726ee = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.page-header','data' => ['title' => 'Bảng tin KTX','subtitle' => 'Phát hành, quản lý và lưu trữ các thông báo quan trọng tới toàn thể cộng đồng cư dân.']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('admin.page-header'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Bảng tin KTX','subtitle' => 'Phát hành, quản lý và lưu trữ các thông báo quan trọng tới toàn thể cộng đồng cư dân.']); ?>
            <button type="button" data-modal-target="modal-themthongbao" data-modal-toggle="modal-themthongbao" class="saas-btn-primary h-11 px-6 shadow-lg shadow-emerald-500/20">
                <svg class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
                Tạo thông báo mới
            </button>
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
                    <th>Tiêu đề</th>
                    <th>Nội dung tóm lược</th>
                    <th class="text-right">Hành động</th>
                </tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $thongbao; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr class="hover:bg-slate-50/50 transition-colors group">
                        <td class="py-5 max-w-xs">
                            <div class="text-sm font-bold text-slate-900 leading-tight group-hover:text-brand-emerald transition-colors"><?php echo e($item->tieu_de); ?></div>
                            <div class="flex items-center gap-1.5 mt-2">
                                <span class="h-1.5 w-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Đã phát hành</span>
                            </div>
                        </td>
                        <td class="py-5 max-w-md">
                            <div class="rounded-xl bg-slate-50 px-4 py-3 text-xs font-medium leading-relaxed text-slate-600 line-clamp-2 ring-1 ring-inset ring-slate-200/60">
                                <?php echo e(Str::limit($item->noi_dung, 120)); ?>

                            </div>
                        </td>
                        <td class="py-5 text-right">
                            <div class="flex items-center justify-end gap-1">
                                <button type="button" data-modal-target="modal-suathongbao-<?php echo e($item->id); ?>" data-modal-toggle="modal-suathongbao-<?php echo e($item->id); ?>" class="h-9 w-9 inline-flex items-center justify-center text-slate-400 hover:text-brand-emerald hover:bg-brand-emerald/10 border border-transparent hover:border-brand-emerald/20 rounded-xl transition-all shadow-sm hover:shadow-md" title="Chỉnh sửa nội dung">
                                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                                </button>

                                <form method="POST" action="<?php echo e(route('admin.thongbao.xoa', ['id' => $item->id])); ?>" x-data="{ showConfirm: false }" @confirmed="$el.submit()" class="inline">
                                    <?php echo csrf_field(); ?>
                                    <button type="button" @click="showConfirm = true" class="h-9 w-9 inline-flex items-center justify-center text-slate-400 hover:text-rose-600 hover:bg-rose-50 border border-transparent hover:border-rose-100 rounded-xl transition-all shadow-sm hover:shadow-md" title="Gỡ bỏ thông báo">
                                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-4v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    </button>
                                    <?php if (isset($component)) { $__componentOriginal5b8b2d0f151a30be878e1a760ec3900c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5b8b2d0f151a30be878e1a760ec3900c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.confirmation-modal','data' => ['type' => 'danger','message' => 'Xác nhận gỡ bỏ hoàn toàn thông báo này khỏi hệ thống?']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('confirmation-modal'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'danger','message' => 'Xác nhận gỡ bỏ hoàn toàn thông báo này khỏi hệ thống?']); ?>
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
                            </div>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="3" class="py-24 text-center">
                            <div class="flex flex-col items-center gap-4 text-slate-200">
                                <svg class="h-14 w-14" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg>
                                <p class="text-sm font-bold text-slate-400 uppercase tracking-widest">Bảng tin chưa có dữ liệu</p>
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

        <?php if(method_exists($thongbao, 'links')): ?>
            <div class="mt-8">
                <?php echo e($thongbao->appends(request()->query())->links()); ?>

            </div>
        <?php endif; ?>
    </div>

    <?php $__env->startPush('modals'); ?>
        <?php if (isset($component)) { $__componentOriginal9f64f32e90b9102968f2bc548315018c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9f64f32e90b9102968f2bc548315018c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.modal','data' => ['id' => 'modal-themthongbao','title' => 'Soạn thảo thông báo','subtitle' => 'Thiết lập nội dung mới để phát hành tới cộng đồng cư dân.']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('modal'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['id' => 'modal-themthongbao','title' => 'Soạn thảo thông báo','subtitle' => 'Thiết lập nội dung mới để phát hành tới cộng đồng cư dân.']); ?>
            <form method="POST" action="<?php echo e(route('admin.thongbao.store')); ?>" class="space-y-6">
                <?php echo csrf_field(); ?>
                <div class="space-y-2">
                    <label for="tieu_de_new" class="text-[10px] font-bold uppercase tracking-widest text-slate-400 ml-1">Tiêu đề bài đăng</label>
                    <input name="tieu_de" id="tieu_de_new" type="text" placeholder="Ví dụ: Thông báo lịch vệ sinh học kỳ mới..." value="<?php echo e(old('tieu_de')); ?>" class="saas-input font-bold" required>
                </div>
                <div class="space-y-2">
                    <label for="loai_thong_bao_new" class="text-[10px] font-bold uppercase tracking-widest text-slate-400 ml-1">Phân loại</label>
                    <select name="loai_thong_bao" id="loai_thong_bao_new" class="saas-input font-bold h-12">
                        <option value="general" <?php if(old('loai_thong_bao') === 'general'): echo 'selected'; endif; ?>>Chung</option>
                        <option value="system" <?php if(old('loai_thong_bao') === 'system'): echo 'selected'; endif; ?>>Hệ thống</option>
                        <option value="finance" <?php if(old('loai_thong_bao') === 'finance'): echo 'selected'; endif; ?>>Tài chính</option>
                        <option value="maintenance" <?php if(old('loai_thong_bao') === 'maintenance'): echo 'selected'; endif; ?>>Bảo trì</option>
                        <option value="discipline" <?php if(old('loai_thong_bao') === 'discipline'): echo 'selected'; endif; ?>>Kỷ luật</option>
                    </select>
                </div>
                <div class="space-y-2">
                    <label for="noidung_new" class="text-[10px] font-bold uppercase tracking-widest text-slate-400 ml-1">Nội dung văn bản</label>
                    <textarea name="noi_dung" id="noidung_new" placeholder="Nhập nội dung chi tiết tại đây..." rows="8" class="saas-input !h-auto !py-4 font-medium leading-relaxed min-h-[200px] resize-none" required><?php echo e(old('noi_dung')); ?></textarea>
                </div>

                <div class="flex gap-3 pt-4">
                    <button type="button" data-modal-hide="modal-themthongbao" class="saas-btn-secondary flex-1 h-12">Hủy bỏ</button>
                    <button type="submit" class="saas-btn-primary flex-[2] h-12 shadow-lg shadow-emerald-500/20">Phát hành thông báo</button>
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

        <?php $__currentLoopData = $thongbao; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php if (isset($component)) { $__componentOriginal9f64f32e90b9102968f2bc548315018c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9f64f32e90b9102968f2bc548315018c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.modal','data' => ['id' => 'modal-suathongbao-'.e($item->id).'','title' => 'Hiệu chỉnh thông báo','subtitle' => 'Cập nhật lại nội dung thông báo #'.e($item->id).'.']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('modal'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['id' => 'modal-suathongbao-'.e($item->id).'','title' => 'Hiệu chỉnh thông báo','subtitle' => 'Cập nhật lại nội dung thông báo #'.e($item->id).'.']); ?>
                <form method="POST" action="<?php echo e(route('admin.thongbao.capnhat', ['id' => $item->id])); ?>" class="space-y-6">
                    <?php echo csrf_field(); ?>
                    <div class="space-y-2">
                        <label for="tieu_de_<?php echo e($item->id); ?>" class="text-[10px] font-bold uppercase tracking-widest text-slate-400 ml-1">Tiêu đề bài đăng</label>
                        <input name="tieu_de" id="tieu_de_<?php echo e($item->id); ?>" type="text" value="<?php echo e($item->tieu_de); ?>" class="saas-input font-bold" required>
                    </div>
                    <div class="space-y-2">
                        <label for="loai_thong_bao_<?php echo e($item->id); ?>" class="text-[10px] font-bold uppercase tracking-widest text-slate-400 ml-1">Phân loại</label>
                        <select name="loai_thong_bao" id="loai_thong_bao_<?php echo e($item->id); ?>" class="saas-input font-bold h-12">
                            <option value="general" <?php if($item->loai_thong_bao === 'general'): echo 'selected'; endif; ?>>Chung</option>
                            <option value="system" <?php if($item->loai_thong_bao === 'system'): echo 'selected'; endif; ?>>Hệ thống</option>
                            <option value="finance" <?php if($item->loai_thong_bao === 'finance'): echo 'selected'; endif; ?>>Tài chính</option>
                            <option value="maintenance" <?php if($item->loai_thong_bao === 'maintenance'): echo 'selected'; endif; ?>>Bảo trì</option>
                            <option value="discipline" <?php if($item->loai_thong_bao === 'discipline'): echo 'selected'; endif; ?>>Kỷ luật</option>
                        </select>
                    </div>

                    <div class="space-y-2">
                        <label for="noidung_<?php echo e($item->id); ?>" class="text-[10px] font-bold uppercase tracking-widest text-slate-400 ml-1">Nội dung chi tiết</label>
                        <textarea name="noi_dung" id="noidung_<?php echo e($item->id); ?>" rows="10" class="saas-input !h-auto !py-4 font-medium leading-relaxed min-h-[250px] resize-none" required><?php echo e($item->noi_dung); ?></textarea>
                    </div>

                    <div class="flex gap-3 pt-4">
                        <button type="button" data-modal-hide="modal-suathongbao-<?php echo e($item->id); ?>" class="saas-btn-secondary flex-1 h-12">Hủy bỏ</button>
                        <button type="submit" class="saas-btn-primary flex-[2] h-12 shadow-lg shadow-emerald-500/20">Lưu thay đổi</button>
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
<?php /**PATH D:\laragon\www\hethongquanlyktxv1\resources\views/admin/thongbao/danhsach.blade.php ENDPATH**/ ?>