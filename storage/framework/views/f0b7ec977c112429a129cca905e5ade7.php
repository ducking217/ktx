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
     <?php $__env->slot('title', null, []); ?> Quản lý tài khoản <?php $__env->endSlot(); ?>

    <div class="space-y-6">
        <?php if (isset($component)) { $__componentOriginalcb19cb35a534439097b02b8af91726ee = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalcb19cb35a534439097b02b8af91726ee = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.page-header','data' => ['title' => 'Tài khoản quản trị','subtitle' => 'Quản lý nhân sự và phân quyền vận hành hệ thống KTX.']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('admin.page-header'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Tài khoản quản trị','subtitle' => 'Quản lý nhân sự và phân quyền vận hành hệ thống KTX.']); ?>
            <a href="<?php echo e(route('admin.accounts.tao')); ?>" class="saas-btn-primary h-9 px-4 text-xs shadow-sm shadow-emerald-500/20">
                <svg class="mr-1.5 h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
                Tạo tài khoản
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

        <div class="saas-card p-5 border-slate-200/60 shadow-sm">
            <form action="<?php echo e(route('admin.accounts.index')); ?>" method="GET" class="flex flex-wrap items-end gap-4">
                <div class="flex-1 min-w-[240px]">
                    <label class="block text-[9px] font-bold text-slate-400 uppercase tracking-widest mb-1.5">Tìm kiếm</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-3 flex items-center text-slate-400 pointer-events-none">
                            <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m21 21-4.35-4.35M10.5 18a7.5 7.5 0 1 1 0-15 7.5 7.5 0 0 1 0 15z"/></svg>
                        </div>
                        <input type="text" name="search" value="<?php echo e(request('search')); ?>" placeholder="Tên, thư điện tử hoặc số điện thoại..." class="saas-input pl-9 text-xs">
                    </div>
                </div>
                <div class="w-44">
                    <label class="block text-[9px] font-bold text-slate-400 uppercase tracking-widest mb-1.5">Vai trò</label>
                    <select name="role" class="saas-input text-xs font-bold">
                        <option value="">Tất cả vai trò</option>
                        <?php $__currentLoopData = \App\Enums\UserRole::cases(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php if($role->isAdminGroup()): ?>
                                <option value="<?php echo e($role->value); ?>" <?php if(request('role') == $role->value): echo 'selected'; endif; ?>><?php echo e($role->label()); ?></option>
                            <?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                <button type="submit" class="saas-btn-secondary h-9 px-4 text-xs font-bold">Lọc</button>
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
                    <th class="w-[35%]">Thành viên</th>
                    <th>Vai trò</th>
                    <th class="text-center">Trạng thái</th>
                    <th>Ngày tham gia</th>
                    <th class="text-right">Thao tác</th>
                </tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $accounts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $acc): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr class="hover:bg-slate-50/50 transition-colors">
                        <td class="py-4">
                            <div class="flex items-center gap-3">
                                <div class="h-8 w-8 rounded-lg bg-slate-900 flex items-center justify-center text-xs font-bold text-white uppercase shadow-sm flex-shrink-0">
                                    <?php echo e(substr($acc->name, 0, 1)); ?>

                                </div>
                                <div class="min-w-0">
                                    <div class="text-xs font-bold text-slate-900 truncate"><?php echo e($acc->name); ?></div>
                                    <div class="text-[9px] font-medium text-slate-400 truncate mt-0.5"><?php echo e($acc->email); ?></div>
                                </div>
                            </div>
                        </td>
                        <td class="py-4">
                            <?php $roleBadge = $acc->vaitro === \App\Enums\UserRole::Admin ? 'saas-badge-error' : 'saas-badge-info'; ?>
                            <span class="saas-badge <?php echo e($roleBadge); ?> text-[8px] px-2.5 py-0.5"><?php echo e($acc->vaitro->label()); ?></span>
                        </td>
                        <td class="py-4 text-center">
                            <?php if($acc->is_active): ?>
                                <span class="inline-flex items-center gap-1.5 text-[9px] font-bold text-emerald-600 uppercase tracking-wider">
                                    <span class="h-1.5 w-1.5 rounded-full bg-emerald-500 animate-pulse"></span>Hoạt động
                                </span>
                            <?php else: ?>
                                <span class="inline-flex items-center gap-1.5 text-[9px] font-bold text-slate-300 uppercase tracking-wider">
                                    <span class="h-1.5 w-1.5 rounded-full bg-slate-200"></span>Vô hiệu
                                </span>
                            <?php endif; ?>
                        </td>
                        <td class="py-4 text-xs font-bold text-slate-500 tabular-nums"><?php echo e($acc->created_at->format('d/m/Y')); ?></td>
                        <td class="py-4 text-right">
                            <div class="flex items-center justify-end gap-1">
                                <a href="<?php echo e(route('admin.accounts.sua', $acc->id)); ?>" class="h-8 w-8 inline-flex items-center justify-center text-slate-400 hover:text-brand-emerald hover:bg-brand-emerald/10 border border-transparent hover:border-brand-emerald/20 rounded-lg transition-all" title="Chỉnh sửa">
                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                </a>
                                <?php if(auth()->id() !== $acc->id): ?>
                                    <form action="<?php echo e(route('admin.accounts.xoa', $acc->id)); ?>" method="POST" onsubmit="return confirm('Xác nhận xóa tài khoản này?')" class="inline">
                                        <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                        <button type="submit" class="h-8 w-8 inline-flex items-center justify-center text-slate-400 hover:text-rose-600 hover:bg-rose-50 border border-transparent hover:border-rose-100 rounded-lg transition-all" title="Xóa">
                                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6M9 7h6m-7 0V5a2 2 0 012-2h2a2 2 0 012 2v2"/></svg>
                                        </button>
                                    </form>
                                <?php endif; ?>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="5" class="py-16 text-center">
                            <p class="text-[10px] font-bold text-slate-300 uppercase tracking-widest">Không có tài khoản nào phù hợp</p>
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

        <?php if($accounts->hasPages()): ?>
            <div class="py-4"><?php echo e($accounts->links()); ?></div>
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
<?php /**PATH D:\laragon\www\hethongquanlyktxv1\resources\views/admin/accounts/index.blade.php ENDPATH**/ ?>