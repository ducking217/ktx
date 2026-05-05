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
     <?php $__env->slot('title', null, []); ?> Hồ sơ phòng <?php echo e($phong->ten_phong); ?> <?php $__env->endSlot(); ?>

    <div class="mb-10">
        <?php if (isset($component)) { $__componentOriginalcb19cb35a534439097b02b8af91726ee = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalcb19cb35a534439097b02b8af91726ee = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.page-header','data' => ['title' => 'Phòng '.e($phong->ten_phong).'','subtitle' => 'Thông tin định danh, danh sách nhân khẩu và lịch sử vận hành chi tiết.']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('admin.page-header'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Phòng '.e($phong->ten_phong).'','subtitle' => 'Thông tin định danh, danh sách nhân khẩu và lịch sử vận hành chi tiết.']); ?>
            <a href="<?php echo e(route('admin.phong.index')); ?>" class="pdu-btn-ghost !px-4">
                <svg class="mr-2 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                Quay lại
            </a>

            <div class="flex items-center gap-2 rounded-2xl bg-ui-bg p-1.5 ring-1 ring-inset ring-ui-border">
                <span class="inline-flex items-center gap-1.5 rounded-xl bg-ui-card px-4 py-2 text-[10px] font-bold uppercase tracking-widest text-ink-primary shadow-sm ring-1 ring-ui-border">
                    <span class="h-1.5 w-1.5 rounded-full <?php echo e($phong->gioi_tinh_han_che->value === 'male' ? 'bg-blue-500' : ($phong->gioi_tinh_han_che->value === 'female' ? 'bg-rose-500' : 'bg-gray-500')); ?>"></span>
                    Dành cho <?php echo e($phong->gioi_tinh_han_che->label()); ?>

                </span>
                <span class="inline-flex items-center gap-1.5 rounded-xl bg-ui-card px-4 py-2 text-[10px] font-bold uppercase tracking-widest text-ink-primary shadow-sm ring-1 ring-ui-border">
                    Tầng <?php echo e($phong->tang); ?>

                </span>
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
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Sidebar: Stats & Info -->
        <div class="space-y-8 lg:col-span-1">
            <article class="rounded-3xl bg-ui-card border border-ui-border p-8 shadow-sm">
                <h3 class="text-[10px] font-bold uppercase tracking-widest text-ink-secondary mb-6">Trạng thái lấp đầy</h3>
                <?php
                    $soluongdango = count($sinhviens);
                    $succhuamax = $phong->loaiphong->suc_chua ?? 0;
                    $daydu = $succhuamax > 0 && $soluongdango >= $succhuamax;
                    $phantram = $succhuamax > 0 ? min(100, round($soluongdango / $succhuamax * 100)) : 0;
                ?>
                
                <div class="flex items-end justify-between mb-4">
                    <span class="text-5xl font-black text-ink-primary tabular-nums font-display"><?php echo e($soluongdango); ?><span class="text-xl text-ink-secondary/40">/<?php echo e($succhuamax); ?></span></span>
                    <span class="text-sm font-bold text-ink-secondary uppercase">Giường đã ở</span>
                </div>

                <div class="h-3 w-full overflow-hidden rounded-full bg-ui-bg ring-1 ring-inset ring-ui-border">
                    <div class="h-full rounded-full transition-all duration-1000 ease-out <?php echo e($daydu ? 'bg-ink-primary' : 'bg-brand-emerald shadow-[0_0_8px_rgba(16,185,129,0.3)]'); ?>" style="<?php echo \Illuminate\Support\Arr::toCssStyles(["width: $phantram%"]) ?>"></div>
                </div>

                <div class="mt-8 space-y-4 pt-8 border-t border-ui-border">
                    <div class="flex justify-between items-center">
                        <span class="text-xs font-bold text-ink-secondary uppercase">Đơn giá tháng</span>
                        <span class="text-lg font-black text-ink-primary tabular-nums font-display"><?php echo e(number_format($phong->loaiphong->gia_thang ?? 0)); ?>đ</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-xs font-bold text-ink-secondary uppercase">Loại phòng</span>
                        <span class="text-sm font-bold text-ink-primary"><?php echo e($succhuamax); ?> người</span>
                    </div>
                </div>
            </article>

            <article class="rounded-3xl bg-ui-bg/50 border border-ui-border p-8 ring-1 ring-inset ring-ui-border">
                <h3 class="text-[10px] font-bold uppercase tracking-widest text-ink-secondary mb-4">Ghi chú vận hành</h3>
                <p class="text-sm font-medium text-ink-secondary leading-relaxed italic">
                    <?php echo e($phong->ghichu ?? 'Không có ghi chú đặc biệt cho phòng này.'); ?>

                </p>
            </article>
        </div>

        <!-- Main Content: Resident List -->
        <div class="lg:col-span-2 space-y-8">
            <article class="rounded-3xl bg-ui-card border border-ui-border shadow-sm overflow-hidden">
                <div class="bg-ui-bg/50 border-b border-ui-border px-8 py-4 flex items-center justify-between">
                    <h3 class="text-[10px] font-bold uppercase tracking-widest text-ink-secondary">Danh sách nhân khẩu hiện tại</h3>
                    <span class="text-[10px] font-bold text-ink-secondary/40 uppercase tabular-nums"><?php echo e(count($sinhviens)); ?> cư dân</span>
                </div>

                <div class="divide-y divide-ui-border">
                    <?php $__empty_1 = true; $__currentLoopData = $sinhviens; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sinhvien): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <div class="group flex items-center justify-between p-6 transition-colors hover:bg-ui-bg/30">
                            <div class="flex items-center gap-4">
                                <div class="h-12 w-12 flex-shrink-0 overflow-hidden rounded-2xl bg-ui-bg ring-1 ring-ui-border">
                                    <img src="https://ui-avatars.com/api/?name=<?php echo e(urlencode($sinhvien->user?->name ?? 'N/A')); ?>&background=f8f9fa&color=0f172a&bold=true" alt="Avatar" />
                                </div>
                                <div>
                                    <div class="font-bold text-ink-primary font-display text-lg"><?php echo e($sinhvien->user?->name ?? 'N/A'); ?></div>
                                    <div class="flex items-center gap-2 mt-0.5">
                                        <span class="text-[10px] font-bold uppercase tracking-widest text-ink-secondary"><?php echo e($sinhvien->ma_sinh_vien ?? $sinhvien->masinhvien); ?></span>
                                        <span class="h-1 w-1 rounded-full bg-ui-border"></span>
                                        <span class="text-[10px] font-bold uppercase tracking-widest text-ink-secondary"><?php echo e($sinhvien->lop); ?></span>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="flex items-center gap-4">
                                <div class="text-right hidden sm:block">
                                    <div class="text-xs font-bold text-ink-primary tabular-nums"><?php echo e($sinhvien->user?->phone ?? 'N/A'); ?></div>
                                    <div class="text-[10px] font-medium text-ink-secondary/40 uppercase tracking-widest mt-0.5">Liên lạc</div>
                                </div>
                                <a href="<?php echo e(route('admin.quanlysinhvien', ['q' => $sinhvien->ma_sinh_vien ?? $sinhvien->masinhvien])); ?>" class="flex h-9 w-9 items-center justify-center rounded-xl bg-ui-bg text-ink-secondary hover:text-ink-primary ring-1 ring-ui-border transition-colors">
                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                </a>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <div class="px-8 py-24 text-center">
                            <div class="inline-flex h-12 w-12 items-center justify-center rounded-full bg-ui-bg text-ink-secondary/50 mb-4">
                                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                            </div>
                            <h4 class="text-sm font-bold text-ink-primary uppercase tracking-widest">Phòng đang trống</h4>
                            <p class="mt-1 text-[11px] text-ink-secondary">Hiện tại chưa có sinh viên nào được xếp vào phòng này.</p>
                        </div>
                    <?php endif; ?>
                </div>
            </article>

            <!-- Maintenance History -->
            <article class="rounded-3xl bg-ui-card border border-ui-border shadow-sm overflow-hidden">
                <div class="bg-ui-bg/50 border-b border-ui-border px-8 py-4">
                    <h3 class="text-[10px] font-bold uppercase tracking-widest text-ink-secondary">Nhật ký bảo trì & Sửa chữa</h3>
                </div>
                
                <div class="p-8">
                    <?php
                        $baotris = \App\Models\Baohong::where('phong_id', $phong->id)->orderBy('created_at', 'desc')->get();
                    ?>
                    
                    <?php if($baotris->isNotEmpty()): ?>
                        <div class="space-y-6">
                            <?php $__currentLoopData = $baotris; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $bt): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="flex gap-4">
                                    <div class="flex flex-col items-center">
                                        <div class="h-2.5 w-2.5 rounded-full ring-4 ring-ui-bg <?php echo e($bt->trang_thai->value === 'completed' ? 'bg-brand-emerald' : 'bg-amber-500'); ?>"></div>
                                        <div class="w-px flex-1 bg-ui-border my-2"></div>
                                    </div>
                                    <div class="flex-1 pb-6">
                                        <div class="flex items-center justify-between mb-1">
                                            <span class="text-[10px] font-bold text-ink-secondary uppercase tabular-nums tracking-widest"><?php echo e(date('d/m/Y', strtotime($bt->created_at))); ?></span>
                                            <span class="text-[10px] font-bold uppercase tracking-widest <?php echo e($bt->trang_thai->value === 'completed' ? 'text-brand-emerald' : 'text-amber-600'); ?>"><?php echo e($bt->trang_thai->label()); ?></span>
                                        </div>
                                        <p class="text-sm font-bold text-ink-primary mb-1"><?php echo e($bt->mo_ta); ?></p>
                                        <p class="text-xs font-medium text-ink-secondary/60">Thực hiện: Ban quản lý</p>
                                    </div>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    <?php else: ?>
                        <div class="text-center py-6">
                            <p class="text-xs font-bold text-ink-secondary/40 uppercase tracking-widest">Chưa có dữ liệu bảo trì</p>
                        </div>
                    <?php endif; ?>
                </div>
            </article>

            <!-- Room Assets -->
            <article class="rounded-3xl bg-ui-card border border-ui-border shadow-sm overflow-hidden">
                <div class="bg-ui-bg/50 border-b border-ui-border px-8 py-4 flex items-center justify-between gap-4">
                    <h3 class="text-[10px] font-bold uppercase tracking-widest text-ink-secondary">Danh mục tài sản trong phòng</h3>
                    <button type="button" data-modal-target="modal-themtaisan" data-modal-toggle="modal-themtaisan" class="saas-btn-primary h-9 px-4 text-[10px] uppercase font-bold tracking-widest shadow-sm shadow-blue-500/15">
                        <svg class="mr-2 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
                        Thêm tài sản
                    </button>
                </div>
                <div class="p-8">
                    <?php if($taisan->isNotEmpty()): ?>
                        <div class="grid grid-cols-2 sm:grid-cols-3 gap-4">
                            <?php $__currentLoopData = $taisan; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ts): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="p-4 rounded-2xl bg-ui-bg/30 ring-1 ring-inset ring-ui-border">
                                    <div class="flex items-start justify-between gap-3">
                                        <div class="min-w-0">
                                            <div class="text-[8px] font-bold text-ink-secondary/40 uppercase tracking-widest mb-1"><?php echo e($ts->ma_tai_san); ?></div>
                                            <div class="text-xs font-bold text-ink-primary truncate" title="<?php echo e($ts->ten_tai_san); ?>"><?php echo e($ts->ten_tai_san); ?></div>
                                        </div>
                                        <div class="flex items-center gap-1">
                                            <button type="button" data-modal-target="modal-capnhat-taisan-<?php echo e($ts->id); ?>" data-modal-toggle="modal-capnhat-taisan-<?php echo e($ts->id); ?>" class="h-8 w-8 inline-flex items-center justify-center text-ink-secondary/60 hover:text-blue-600 hover:bg-blue-50 border border-transparent hover:border-blue-100 rounded-lg transition-all" title="Chỉnh sửa">
                                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                            </button>
                                            <form method="POST" action="<?php echo e(route('admin.taisan.xoa', ['id' => $phong->id, 'taisanId' => $ts->id])); ?>" onsubmit="return confirm('Xác nhận xóa tài sản này khỏi phòng?')">
                                                <?php echo csrf_field(); ?>
                                                <button type="submit" class="h-8 w-8 inline-flex items-center justify-center text-ink-secondary/60 hover:text-rose-600 hover:bg-rose-50 border border-transparent hover:border-rose-100 rounded-lg transition-all" title="Xóa">
                                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                                </button>
                                            </form>
                                        </div>
                                    </div>

                                    <div class="mt-3 flex items-center justify-between gap-3">
                                        <div class="text-[10px] font-bold uppercase tracking-widest text-ink-secondary/50">SL</div>
                                        <div class="text-[11px] font-black text-ink-primary tabular-nums"><?php echo e($ts->so_luong); ?></div>
                                    </div>

                                    <div class="mt-2 text-[10px] font-black uppercase tracking-widest <?php echo e($ts->tinh_trang === 'Tốt' ? 'text-brand-emerald' : 'text-status-error'); ?>">
                                        <?php echo e($ts->tinh_trang); ?>

                                    </div>
                                </div>

                                <div id="modal-capnhat-taisan-<?php echo e($ts->id); ?>" tabindex="-1" aria-hidden="true" class="fixed inset-0 z-50 hidden items-center justify-center bg-slate-900/60 p-4 backdrop-blur-sm animate-in fade-in duration-200">
                                    <div class="w-full max-w-md rounded-2xl bg-white p-8 shadow-2xl border border-slate-200 animate-in zoom-in-95 duration-200">
                                        <div class="mb-8 flex items-center justify-between">
                                            <div>
                                                <h3 class="text-xl font-bold text-slate-900 tracking-tight">Cập nhật tài sản</h3>
                                                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-1"><?php echo e($phong->ten_phong); ?></p>
                                            </div>
                                            <button type="button" class="flex h-10 w-10 items-center justify-center rounded-xl bg-slate-50 text-slate-400 hover:bg-slate-900 hover:text-white transition-all" data-modal-hide="modal-capnhat-taisan-<?php echo e($ts->id); ?>">
                                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                                            </button>
                                        </div>

                                        <form method="POST" action="<?php echo e(route('admin.taisan.capnhat', ['id' => $phong->id, 'taisanId' => $ts->id])); ?>" class="space-y-4">
                                            <?php echo csrf_field(); ?>
                                            <div>
                                                <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-2 ml-1">Tên tài sản</label>
                                                <input type="text" name="ten_tai_san" value="<?php echo e($ts->ten_tai_san); ?>" class="saas-input h-11 font-bold" required maxlength="100" />
                                            </div>
                                            <div class="grid grid-cols-2 gap-3">
                                                <div>
                                                    <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-2 ml-1">Số lượng</label>
                                                    <input type="number" name="so_luong" value="<?php echo e($ts->so_luong); ?>" class="saas-input h-11 font-bold tabular-nums" required min="1" />
                                                </div>
                                                <div>
                                                    <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-2 ml-1">Tình trạng</label>
                                                    <input type="text" name="tinh_trang" value="<?php echo e($ts->tinh_trang); ?>" class="saas-input h-11 font-bold" required maxlength="100" />
                                                </div>
                                            </div>

                                            <div class="pt-2 flex items-center gap-2">
                                                <button type="submit" class="saas-btn-primary h-11 px-6 text-[10px] uppercase font-bold tracking-widest flex-1">Lưu</button>
                                                <button type="button" class="saas-btn-secondary h-11 px-6 text-[10px] uppercase font-bold tracking-widest" data-modal-hide="modal-capnhat-taisan-<?php echo e($ts->id); ?>">Hủy</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    <?php else: ?>
                        <div class="text-center py-6">
                            <p class="text-xs font-bold text-ink-secondary/40 uppercase tracking-widest">Chưa gán tài sản</p>
                        </div>
                    <?php endif; ?>
                </div>
            </article>

            <div id="modal-themtaisan" tabindex="-1" aria-hidden="true" class="fixed inset-0 z-50 hidden items-center justify-center bg-slate-900/60 p-4 backdrop-blur-sm animate-in fade-in duration-200">
                <div class="w-full max-w-md rounded-2xl bg-white p-8 shadow-2xl border border-slate-200 animate-in zoom-in-95 duration-200">
                    <div class="mb-8 flex items-center justify-between">
                        <div>
                            <h3 class="text-xl font-bold text-slate-900 tracking-tight">Thêm tài sản</h3>
                            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-1"><?php echo e($phong->ten_phong); ?></p>
                        </div>
                        <button type="button" class="flex h-10 w-10 items-center justify-center rounded-xl bg-slate-50 text-slate-400 hover:bg-slate-900 hover:text-white transition-all" data-modal-hide="modal-themtaisan">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                        </button>
                    </div>

                    <form method="POST" action="<?php echo e(route('admin.taisan.them', $phong->id)); ?>" class="space-y-4">
                        <?php echo csrf_field(); ?>
                        <div>
                            <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-2 ml-1">Tên tài sản</label>
                            <input type="text" name="ten_tai_san" class="saas-input h-11 font-bold" required maxlength="100" />
                        </div>
                        <div class="grid grid-cols-2 gap-3">
                            <div>
                                <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-2 ml-1">Số lượng</label>
                                <input type="number" name="so_luong" value="1" class="saas-input h-11 font-bold tabular-nums" required min="1" />
                            </div>
                            <div>
                                <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-2 ml-1">Tình trạng</label>
                                <input type="text" name="tinh_trang" value="Tốt" class="saas-input h-11 font-bold" required maxlength="100" />
                            </div>
                        </div>

                        <div class="pt-2 flex items-center gap-2">
                            <button type="submit" class="saas-btn-primary h-11 px-6 text-[10px] uppercase font-bold tracking-widest flex-1">Thêm</button>
                            <button type="button" class="saas-btn-secondary h-11 px-6 text-[10px] uppercase font-bold tracking-widest" data-modal-hide="modal-themtaisan">Hủy</button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
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
<?php /**PATH D:\laragon\www\hethongquanlyktxv1\resources\views/admin/phong/chitiet.blade.php ENDPATH**/ ?>