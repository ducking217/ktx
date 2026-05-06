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
     <?php $__env->slot('title', null, []); ?> Quản lý Liên hệ <?php $__env->endSlot(); ?>

    <div class="space-y-10 pb-20">
        <?php if (isset($component)) { $__componentOriginalcb19cb35a534439097b02b8af91726ee = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalcb19cb35a534439097b02b8af91726ee = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.page-header','data' => ['title' => 'Hộp thư liên hệ','subtitle' => 'Tiếp nhận và phản hồi các kiến nghị, đóng góp để nâng cao chất lượng vận hành.']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('admin.page-header'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Hộp thư liên hệ','subtitle' => 'Tiếp nhận và phản hồi các kiến nghị, đóng góp để nâng cao chất lượng vận hành.']); ?>
            <?php if (isset($component)) { $__componentOriginalca9a59ffed06600c602f2637b0b34f87 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalca9a59ffed06600c602f2637b0b34f87 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.status-tabs','data' => ['items' => [
                    'Tất cả' => 'Tất cả',
                    \App\Models\Lienhe::TRANG_THAI_CHUA_XU_LY => \App\Models\Lienhe::TRANG_THAI_CHUA_XU_LY,
                    \App\Models\Lienhe::TRANG_THAI_DA_XU_LY => \App\Models\Lienhe::TRANG_THAI_DA_XU_LY,
                ],'active' => $status ?? null,'route' => 'admin.quanlylienhe','param' => 'status','defaultValue' => 'Tất cả']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('admin.status-tabs'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['items' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute([
                    'Tất cả' => 'Tất cả',
                    \App\Models\Lienhe::TRANG_THAI_CHUA_XU_LY => \App\Models\Lienhe::TRANG_THAI_CHUA_XU_LY,
                    \App\Models\Lienhe::TRANG_THAI_DA_XU_LY => \App\Models\Lienhe::TRANG_THAI_DA_XU_LY,
                ]),'active' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($status ?? null),'route' => 'admin.quanlylienhe','param' => 'status','defaultValue' => 'Tất cả']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalca9a59ffed06600c602f2637b0b34f87)): ?>
<?php $attributes = $__attributesOriginalca9a59ffed06600c602f2637b0b34f87; ?>
<?php unset($__attributesOriginalca9a59ffed06600c602f2637b0b34f87); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalca9a59ffed06600c602f2637b0b34f87)): ?>
<?php $component = $__componentOriginalca9a59ffed06600c602f2637b0b34f87; ?>
<?php unset($__componentOriginalca9a59ffed06600c602f2637b0b34f87); ?>
<?php endif; ?>
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
                    <th>Người gửi</th>
                    <th>Kênh liên hệ</th>
                    <th>Nội dung</th>
                    <th>Thời gian</th>
                    <th class="text-center">Trạng thái</th>
                    <th class="text-right">Thao tác</th>
                </tr>
            </thead>
            <tbody x-data="{ openId: null }">
                <?php $__empty_1 = true; $__currentLoopData = $danhsachlienhe; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lienhe): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr class="hover:bg-slate-50/50 transition-colors group">
                        <td class="py-6">
                            <div class="text-[13px] font-black text-slate-900 leading-none group-hover:text-blue-600 transition-colors"><?php echo e($lienhe->ho_ten); ?></div>
                            <div class="text-[9px] font-black text-slate-400 uppercase tracking-[0.15em] mt-2.5">Người gửi</div>
                        </td>
                        <td class="py-6">
                            <div class="flex items-center gap-3 text-[12px] font-black text-slate-600 tabular-nums">
                                <div class="h-8 w-8 rounded-xl bg-slate-50 flex items-center justify-center text-slate-400 border border-slate-200/60 shadow-sm group-hover:bg-blue-50 group-hover:text-blue-600 transition-all">
                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                                </div>
                                <?php echo e($lienhe->email); ?>

                            </div>
                        </td>
                        <td class="py-6 max-w-sm">
                            <div class="text-[11px] font-semibold leading-relaxed text-slate-600 line-clamp-2 rounded-xl bg-slate-50/70 px-4 py-3 ring-1 ring-slate-200/50">
                                "<?php echo e(Str::limit($lienhe->noi_dung, 150)); ?>"
                            </div>
                        </td>
                        <td class="py-6">
                            <div class="text-[12px] font-black text-slate-900 tabular-nums tracking-tighter"><?php echo e($lienhe->created_at->format('d/m/Y')); ?></div>
                            <div class="text-[9px] font-black text-slate-400 tabular-nums uppercase mt-1.5"><?php echo e($lienhe->created_at->format('H:i')); ?></div>
                        </td>
                        <td class="py-6 text-center">
                            <?php
                                $isProcessedContact = $lienhe->trang_thai === 'Đã xử lý';
                                $statusBadgeContact = $isProcessedContact ? 'saas-badge-success' : 'saas-badge-warning';
                            ?>
                            <span class="saas-badge <?php echo e($statusBadgeContact); ?> font-black px-4 py-1.5 border-none shadow-sm">
                                <?php echo e($lienhe->trang_thai); ?>

                            </span>
                        </td>
                        <td class="py-6 text-right">
                            <div class="flex items-center justify-end gap-2">
                                <button
                                    type="button"
                                    @click="openId = openId === <?php echo e((int) $lienhe->id); ?> ? null : <?php echo e((int) $lienhe->id); ?>"
                                    class="h-9 w-9 inline-flex items-center justify-center text-slate-400 hover:text-blue-600 hover:bg-blue-50 border border-transparent hover:border-blue-100 rounded-xl transition-all shadow-sm hover:shadow-md"
                                    title="Xem và phản hồi"
                                >
                                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M7 8h10M7 12h6m-6 4h8M5 20h14a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                </button>
                                <?php if(!$isProcessedContact): ?>
                                    <form method="POST" action="<?php echo e(route('admin.capnhattrangthailienhe', ['id' => $lienhe->id])); ?>" x-data="{ showConfirm: false }" @confirmed="$el.submit()" class="inline">
                                        <?php echo csrf_field(); ?>
                                        <input type="hidden" name="trang_thai" value="Đã xử lý">
                                        <button type="button" @click="showConfirm = true" class="h-9 w-9 inline-flex items-center justify-center text-slate-400 hover:text-emerald-600 hover:bg-emerald-50 border border-transparent hover:border-emerald-100 rounded-xl transition-all shadow-sm hover:shadow-md" title="Đánh dấu đã xử lý">
                                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                                        </button>
                                        <?php if (isset($component)) { $__componentOriginal5b8b2d0f151a30be878e1a760ec3900c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5b8b2d0f151a30be878e1a760ec3900c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.confirmation-modal','data' => ['message' => 'Xác nhận đánh dấu kiến nghị này đã được thẩm định và giải quyết triệt để?']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('confirmation-modal'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['message' => 'Xác nhận đánh dấu kiến nghị này đã được thẩm định và giải quyết triệt để?']); ?>
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
                                <?php else: ?>
                                    <div class="h-9 w-9 inline-flex items-center justify-center text-emerald-500 bg-emerald-50 border border-emerald-100 rounded-xl shadow-sm" title="Đã xử lý">
                                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </td>
                    </tr>
                    <tr x-show="openId === <?php echo e((int) $lienhe->id); ?>" x-cloak class="bg-slate-50/30">
                        <td colspan="6" class="pb-6">
                            <div class="px-6">
                                <div class="rounded-2xl bg-ui-card ring-1 ring-ui-border shadow-sm p-6">
                                    <div class="flex flex-col gap-6 lg:flex-row lg:items-start lg:justify-between">
                                        <div class="min-w-0 flex-1">
                                            <div class="text-xs font-black uppercase tracking-widest text-slate-500">Nội dung liên hệ</div>
                                            <div class="mt-3 text-sm text-slate-700 leading-relaxed whitespace-pre-line"><?php echo e($lienhe->noi_dung); ?></div>
                                            <div class="mt-4 flex flex-wrap items-center gap-x-4 gap-y-2 text-xs text-slate-500">
                                                <div class="font-semibold text-slate-600"><?php echo e($lienhe->email); ?></div>
                                                <div class="tabular-nums"><?php echo e($lienhe->created_at?->format('H:i • d/m/Y')); ?></div>
                                            </div>
                                        </div>

                                        <div class="w-full lg:w-[420px]">
                                            <form
                                                method="POST"
                                                action="<?php echo e(route('admin.capnhattrangthailienhe', ['id' => $lienhe->id])); ?>"
                                                x-data="{
                                                    showConfirm: false,
                                                    guiEmail: 0,
                                                    trangThai: <?php echo \Illuminate\Support\Js::from($lienhe->trang_thai)->toHtml() ?>,
                                                    datGhiChu() { this.guiEmail = 0; this.trangThai = <?php echo \Illuminate\Support\Js::from($lienhe->trang_thai)->toHtml() ?>; },
                                                    datGuiPhanHoi() { this.guiEmail = 1; this.trangThai = <?php echo \Illuminate\Support\Js::from(\App\Models\Lienhe::TRANG_THAI_DA_XU_LY)->toHtml() ?>; this.showConfirm = true; },
                                                }"
                                                @confirmed="$el.submit()"
                                                class="space-y-3"
                                            >
                                                <?php echo csrf_field(); ?>
                                                <input type="hidden" name="trang_thai" x-model="trangThai">
                                                <input type="hidden" name="gui_email" x-model="guiEmail">

                                                <div>
                                                    <label class="block text-xs font-semibold text-slate-600">Phản hồi của Ban quản lý</label>
                                                    <textarea name="ghi_chu_admin" rows="5" class="mt-2 w-full rounded-xl border border-slate-200/60 bg-ui-bg px-4 py-3 text-sm text-slate-900 shadow-sm focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10" placeholder="Soạn phản hồi để gửi qua thư điện tử, hoặc ghi chú nội bộ..."><?php echo e(old('ghi_chu_admin', $lienhe->ghi_chu_admin)); ?></textarea>
                                                    <?php $__errorArgs = ['ghi_chu_admin'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                        <div class="mt-2 text-xs font-medium text-red-600"><?php echo e($message); ?></div>
                                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                                </div>

                                                <div class="flex items-center justify-end gap-2">
                                                    <button type="submit" @click="datGhiChu()" class="h-10 rounded-xl px-4 text-xs font-semibold text-slate-700 bg-slate-100 hover:bg-slate-200 transition-colors">
                                                        Lưu ghi chú
                                                    </button>
                                                    <button type="button" @click="datGuiPhanHoi()" class="h-10 rounded-xl px-4 text-xs font-semibold text-white bg-blue-600 hover:bg-blue-700 transition-colors">
                                                        Gửi phản hồi
                                                    </button>
                                                </div>

                                                <?php if (isset($component)) { $__componentOriginal5b8b2d0f151a30be878e1a760ec3900c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5b8b2d0f151a30be878e1a760ec3900c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.confirmation-modal','data' => ['type' => 'info','title' => 'Gửi phản hồi','message' => 'Gửi phản hồi qua thư điện tử cho người gửi và đánh dấu liên hệ là đã xử lý?','confirmText' => 'Gửi']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('confirmation-modal'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'info','title' => 'Gửi phản hồi','message' => 'Gửi phản hồi qua thư điện tử cho người gửi và đánh dấu liên hệ là đã xử lý?','confirmText' => 'Gửi']); ?>
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
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="6" class="py-40 text-center">
                            <div class="flex flex-col items-center gap-6">
                                <div class="h-24 w-24 bg-slate-50 rounded-full flex items-center justify-center text-slate-200 border border-slate-100 border-dashed">
                                    <svg class="h-12 w-12" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/></svg>
                                </div>
                                <h4 class="text-sm font-black text-slate-400 uppercase tracking-widest">Không có liên hệ</h4>
                                <p class="text-[11px] text-slate-400 font-medium max-w-xs">Hiện chưa có liên hệ nào cần xử lý tại thời điểm này.</p>
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

        <?php if(method_exists($danhsachlienhe, 'links')): ?>
            <div class="py-12">
                <?php echo e($danhsachlienhe->appends(request()->query())->links()); ?>

            </div>
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
<?php /**PATH D:\laragon\www\hethongquanlyktxv1\resources\views/admin/lienhe/danhsach.blade.php ENDPATH**/ ?>