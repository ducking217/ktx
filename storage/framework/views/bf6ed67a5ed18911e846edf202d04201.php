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
     <?php $__env->slot('title', null, []); ?> Quản lý Kỷ luật Nội trú <?php $__env->endSlot(); ?>

    <div class="space-y-8 pb-20">
        <?php if (isset($component)) { $__componentOriginalcb19cb35a534439097b02b8af91726ee = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalcb19cb35a534439097b02b8af91726ee = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.page-header','data' => ['title' => 'Hệ thống kỷ luật','subtitle' => 'Ghi nhận, theo dõi và xử lý các vi phạm nội quy nội trú, đảm bảo tính nghiêm minh và minh bạch.']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('admin.page-header'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Hệ thống kỷ luật','subtitle' => 'Ghi nhận, theo dõi và xử lý các vi phạm nội quy nội trú, đảm bảo tính nghiêm minh và minh bạch.']); ?>
            <button type="button"
                    data-modal-target="modal-themkyluat"
                    data-modal-toggle="modal-themkyluat"
                    class="saas-btn-primary h-10 px-5 text-xs font-bold shadow-lg shadow-emerald-500/20">
                <svg class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
                Ghi nhận vi phạm
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

        
        <div class="saas-card p-6 bg-slate-50/50 border-dashed">
            <form method="GET" action="<?php echo e(route('admin.kyluat.index')); ?>" class="flex flex-wrap items-end gap-6">
                <div class="flex-1 min-w-[200px] space-y-2">
                    <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest ml-1">Sinh viên</label>
                    <select name="sinhvien_id" class="saas-input font-bold h-11" onchange="this.form.submit()">
                        <option value="">Tất cả sinh viên</option>
                        <?php $__currentLoopData = $sinhviens; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($s->id); ?>" <?php echo e($selectedSinhvien == $s->id ? 'selected' : ''); ?>>
                                <?php echo e($s->masinhvien); ?> — <?php echo e($s->user->name ?? 'Chưa có'); ?>

                            </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                <div class="flex-1 min-w-[180px] space-y-2">
                    <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest ml-1">Mức độ vi phạm</label>
                    <select name="muc_do" class="saas-input font-bold h-11" onchange="this.form.submit()">
                        <option value="">Tất cả mức độ</option>
                        <?php $__currentLoopData = \App\Enums\DisciplineLevel::cases(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $m): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($m->value); ?>" <?php echo e($selectedMucDo == $m->value ? 'selected' : ''); ?>><?php echo e($m->label()); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                <?php if(request('sinhvien_id') || request('muc_do')): ?>
                    <a href="<?php echo e(route('admin.kyluat.index')); ?>" class="saas-btn-secondary h-11 px-4 text-xs font-bold">
                        Xóa bộ lọc
                    </a>
                <?php endif; ?>
            </form>
        </div>

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
                    <th>Mã SV</th>
                    <th>Sinh viên</th>
                    <th>Nội dung vi phạm</th>
                    <th class="text-center">Hình thức xử lý</th>
                    <th>Ngày vi phạm</th>
                    <th class="text-center">Mức độ</th>
                    <th class="text-right">Hành động</th>
                </tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $kyluat; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr class="hover:bg-slate-50/50 transition-colors group">
                        <?php
                            $mucDoValue = $item->muc_do?->value ?? $item->muc_do;
                        ?>
                        <td class="py-5">
                            <span class="text-[11px] font-bold text-slate-400 tabular-nums bg-slate-50 px-2 py-0.5 rounded border border-slate-200/60 uppercase tracking-widest">
                                <?php echo e($item->sinhvien?->ma_sinh_vien ?? 'Chưa có'); ?>

                            </span>
                        </td>
                        <td class="py-5">
                            <div class="text-sm font-bold text-slate-900 leading-tight group-hover:text-brand-emerald transition-colors"><?php echo e($item->sinhvien->user->name ?? 'Chưa xác định'); ?></div>
                            <div class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-1.5">
                                <?php echo e($item->sinhvien?->current_hopdong?->giuong?->phong?->ten_phong ?? 'Chưa xếp phòng'); ?>

                            </div>
                        </td>
                        <td class="py-5 max-w-sm">
                            <div class="text-sm font-bold text-slate-900 leading-tight mb-1"><?php echo e($item->tieu_de); ?></div>
                            <div class="rounded-xl bg-slate-50 px-4 py-3 text-xs font-medium leading-relaxed text-slate-600 line-clamp-2 ring-1 ring-inset ring-slate-200/60">
                                <?php echo e($item->noi_dung); ?>

                            </div>
                        </td>
                        <td class="py-5 text-center">
                            <span class="text-xs font-bold text-slate-600 bg-slate-100 px-3 py-1 rounded-lg border border-slate-200">
                                <?php echo e($item->hinh_thuc_xu_ly ?? '—'); ?>

                            </span>
                        </td>
                        <td class="py-5">
                            <div class="text-[11px] font-bold text-slate-900 tabular-nums"><?php echo e(date('d.m.Y', strtotime($item->ngay_vi_pham))); ?></div>
                        </td>
                        <td class="py-5 text-center">
                            <?php
                                $badgeClass = match($mucDoValue) {
                                    \App\Enums\DisciplineLevel::Low->value   => 'saas-badge-info',
                                    \App\Enums\DisciplineLevel::Medium->value => 'saas-badge-warning',
                                    \App\Enums\DisciplineLevel::High->value   => 'saas-badge-error',
                                    default => 'saas-badge-info',
                                };
                            ?>
                            <span class="saas-badge <?php echo e($badgeClass); ?>"><?php echo e($item->muc_do?->label() ?? 'Bình thường'); ?></span>
                        </td>
                        <td class="py-5 text-right">
                            <div class="flex items-center justify-end gap-1">
                                <button type="button"
                                        data-modal-target="modal-suakyluat-<?php echo e($item->id); ?>"
                                        data-modal-toggle="modal-suakyluat-<?php echo e($item->id); ?>"
                                        class="h-9 w-9 inline-flex items-center justify-center text-slate-400 hover:text-brand-emerald hover:bg-brand-emerald/10 border border-transparent hover:border-brand-emerald/20 rounded-xl transition-all shadow-sm hover:shadow-md"
                                        title="Chỉnh sửa">
                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                                </button>
                                <form action="<?php echo e(route('admin.kyluat.xoa', $item->id)); ?>" method="POST"
                                      onsubmit="return confirm('Xác nhận xóa bản ghi vi phạm này?');" class="inline">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('DELETE'); ?>
                                    <button type="submit"
                                            class="h-9 w-9 inline-flex items-center justify-center text-slate-400 hover:text-rose-600 hover:bg-rose-50 border border-transparent hover:border-rose-100 rounded-xl transition-all shadow-sm hover:shadow-md"
                                            title="Xóa">
                                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6M9 7h6m-7 0V5a2 2 0 012-2h2a2 2 0 012 2v2"/></svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="7" class="py-24 text-center">
                            <div class="flex flex-col items-center gap-4 text-slate-200">
                                <svg class="h-14 w-14" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                                <p class="text-sm font-bold text-slate-400 uppercase tracking-widest">Không có vi phạm nào được ghi nhận</p>
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

        <?php if(method_exists($kyluat, 'links')): ?>
            <div class="mt-8">
                <?php echo e($kyluat->appends(request()->query())->links()); ?>

            </div>
        <?php endif; ?>
    </div>

    <?php $__env->startPush('modals'); ?>
        
        <?php if (isset($component)) { $__componentOriginal9f64f32e90b9102968f2bc548315018c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9f64f32e90b9102968f2bc548315018c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.modal','data' => ['id' => 'modal-themkyluat','title' => 'Ghi nhận vi phạm mới','subtitle' => 'Lưu thông tin vi phạm nội quy nội trú cho sinh viên được chỉ định.']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('modal'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['id' => 'modal-themkyluat','title' => 'Ghi nhận vi phạm mới','subtitle' => 'Lưu thông tin vi phạm nội quy nội trú cho sinh viên được chỉ định.']); ?>
            <form method="POST" action="<?php echo e(route('admin.kyluat.store')); ?>" class="space-y-6">
                <?php echo csrf_field(); ?>
                <div class="space-y-2">
                    <label for="sinhvien_id_new" class="text-[10px] font-bold uppercase tracking-widest text-slate-400 ml-1">Sinh viên</label>
                    <select name="sinhvien_id" id="sinhvien_id_new" required class="saas-input h-11 font-bold">
                        <option value="">-- Chọn sinh viên --</option>
                        <?php $__currentLoopData = $sinhviens; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($s->id); ?>"><?php echo e($s->masinhvien); ?> — <?php echo e($s->user->name ?? 'Chưa có'); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>

                <div class="space-y-2">
                    <label for="tieu_de_new" class="text-[10px] font-bold uppercase tracking-widest text-slate-400 ml-1">Tiêu đề vi phạm</label>
                    <input name="tieu_de" id="tieu_de_new" required maxlength="255" class="saas-input h-11 font-bold" placeholder="Ví dụ: Gây ồn ào sau giờ quy định" />
                </div>

                <div class="space-y-2">
                    <label for="noi_dung_new" class="text-[10px] font-bold uppercase tracking-widest text-slate-400 ml-1">Mô tả chi tiết</label>
                    <textarea name="noi_dung" id="noi_dung_new" required rows="4" class="saas-input !h-auto !py-3 resize-none font-medium text-sm leading-relaxed" placeholder="Mô tả hành vi và tình huống xảy ra vi phạm..."></textarea>
                </div>

                <div class="grid grid-cols-2 gap-5">
                    <div class="space-y-2">
                        <label for="ngay_vi_pham_new" class="text-[10px] font-bold uppercase tracking-widest text-slate-400 ml-1">Ngày vi phạm</label>
                        <input name="ngay_vi_pham" id="ngay_vi_pham_new" required type="date" value="<?php echo e(date('Y-m-d')); ?>" class="saas-input h-11 font-bold tabular-nums" />
                    </div>
                    <div class="space-y-2">
                        <label for="muc_do_new" class="text-[10px] font-bold uppercase tracking-widest text-slate-400 ml-1">Mức độ</label>
                        <select name="muc_do" id="muc_do_new" required class="saas-input h-11 font-bold">
                            <option value="<?php echo e(\App\Enums\DisciplineLevel::Low->value); ?>"><?php echo e(\App\Enums\DisciplineLevel::Low->label()); ?></option>
                            <option value="<?php echo e(\App\Enums\DisciplineLevel::Medium->value); ?>" selected><?php echo e(\App\Enums\DisciplineLevel::Medium->label()); ?></option>
                            <option value="<?php echo e(\App\Enums\DisciplineLevel::High->value); ?>"><?php echo e(\App\Enums\DisciplineLevel::High->label()); ?></option>
                        </select>
                    </div>
                </div>

                <div class="space-y-2">
                    <label for="hinh_thuc_xu_ly_new" class="text-[10px] font-bold uppercase tracking-widest text-slate-400 ml-1">Hình thức xử lý</label>
                    <input name="hinh_thuc_xu_ly" id="hinh_thuc_xu_ly_new" maxlength="255" class="saas-input h-11 font-bold" placeholder="Ví dụ: Nhắc nhở, cảnh cáo, phạt..." />
                </div>

                <div class="flex gap-4 pt-2">
                    <button type="submit" class="saas-btn-primary flex-1 h-11 shadow-lg shadow-emerald-500/20">Lưu vi phạm</button>
                    <button type="button" data-modal-hide="modal-themkyluat" class="saas-btn-secondary flex-1 h-11">Hủy</button>
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

        
        <?php $__currentLoopData = $kyluat; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php if (isset($component)) { $__componentOriginal9f64f32e90b9102968f2bc548315018c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9f64f32e90b9102968f2bc548315018c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.modal','data' => ['id' => 'modal-suakyluat-'.e($item->id).'','title' => 'Chỉnh sửa vi phạm','subtitle' => 'Cập nhật thông tin bản ghi vi phạm đã ghi nhận.']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('modal'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['id' => 'modal-suakyluat-'.e($item->id).'','title' => 'Chỉnh sửa vi phạm','subtitle' => 'Cập nhật thông tin bản ghi vi phạm đã ghi nhận.']); ?>
                <form method="POST" action="<?php echo e(route('admin.kyluat.capnhat', ['id' => $item->id])); ?>" class="space-y-6">
                    <?php echo csrf_field(); ?>
                    <div class="p-5 rounded-xl bg-slate-50 border border-slate-200/60 flex items-center gap-4">
                        <div class="h-10 w-10 rounded-xl bg-white border border-slate-200 flex items-center justify-center text-lg shadow-sm">👤</div>
                        <div>
                            <div class="text-sm font-bold text-slate-900 leading-none"><?php echo e($item->sinhvien->user->name ?? 'Chưa có'); ?></div>
                            <div class="text-[10px] font-bold uppercase tracking-widest text-slate-400 mt-1.5"><?php echo e($item->sinhvien?->ma_sinh_vien ?? 'Chưa có'); ?></div>
                        </div>
                    </div>

                    <div class="space-y-2">
                        <label for="tieu_de_<?php echo e($item->id); ?>" class="text-[10px] font-bold uppercase tracking-widest text-slate-400 ml-1">Tiêu đề vi phạm</label>
                        <input name="tieu_de" id="tieu_de_<?php echo e($item->id); ?>" required maxlength="255" class="saas-input h-11 font-bold" value="<?php echo e($item->tieu_de); ?>" />
                    </div>

                    <div class="space-y-2">
                        <label for="noi_dung_<?php echo e($item->id); ?>" class="text-[10px] font-bold uppercase tracking-widest text-slate-400 ml-1">Mô tả chi tiết</label>
                        <textarea name="noi_dung" id="noi_dung_<?php echo e($item->id); ?>" required rows="4" class="saas-input !h-auto !py-3 resize-none font-medium text-sm leading-relaxed"><?php echo e($item->noi_dung); ?></textarea>
                    </div>

                    <div class="grid grid-cols-2 gap-5">
                        <div class="space-y-2">
                            <label for="ngay_vi_pham_<?php echo e($item->id); ?>" class="text-[10px] font-bold uppercase tracking-widest text-slate-400 ml-1">Ngày vi phạm</label>
                            <input class="saas-input h-11 font-bold tabular-nums" id="ngay_vi_pham_<?php echo e($item->id); ?>" type="date" name="ngay_vi_pham" value="<?php echo e($item->ngay_vi_pham); ?>" required />
                        </div>
                        <div class="space-y-2">
                            <label for="muc_do_<?php echo e($item->id); ?>" class="text-[10px] font-bold uppercase tracking-widest text-slate-400 ml-1">Mức độ</label>
                            <select name="muc_do" id="muc_do_<?php echo e($item->id); ?>" required class="saas-input h-11 font-bold">
                                <?php $__currentLoopData = \App\Enums\DisciplineLevel::cases(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $m): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($m->value); ?>" <?php echo e(($item->muc_do?->value ?? $item->muc_do) === $m->value ? 'selected' : ''); ?>><?php echo e($m->label()); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                    </div>

                    <div class="space-y-2">
                        <label for="hinh_thuc_xu_ly_<?php echo e($item->id); ?>" class="text-[10px] font-bold uppercase tracking-widest text-slate-400 ml-1">Hình thức xử lý</label>
                        <input name="hinh_thuc_xu_ly" id="hinh_thuc_xu_ly_<?php echo e($item->id); ?>" maxlength="255" class="saas-input h-11 font-bold" value="<?php echo e($item->hinh_thuc_xu_ly); ?>" />
                    </div>

                    <div class="flex gap-4 pt-2">
                        <button type="submit" class="saas-btn-primary flex-1 h-11 shadow-lg shadow-emerald-500/20">Lưu thay đổi</button>
                        <button type="button" data-modal-hide="modal-suakyluat-<?php echo e($item->id); ?>" class="saas-btn-secondary flex-1 h-11">Hủy</button>
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
<?php /**PATH D:\laragon\www\hethongquanlyktxv1\resources\views/admin/kyluat/danhsach.blade.php ENDPATH**/ ?>