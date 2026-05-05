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
     <?php $__env->slot('title', null, []); ?> <?php echo e(isset($user) ? 'Chỉnh sửa tài khoản' : 'Tạo tài khoản mới'); ?> <?php $__env->endSlot(); ?>

    <div class="max-w-4xl mx-auto space-y-8 animate-fade-up">
        <header class="flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-black text-ink-primary uppercase tracking-tight"><?php echo e(isset($user) ? 'Cập nhật tài khoản' : 'Thêm thành viên mới'); ?></h2>
                <p class="text-[10px] font-bold text-ink-secondary/50 uppercase tracking-widest mt-1">
                    <?php echo e(isset($user) ? 'Thay đổi thông tin cho ' . $user->name : 'Cấp quyền truy cập hệ thống vận hành'); ?>

                </p>
            </div>
            
            <a href="<?php echo e(route('admin.accounts.index')); ?>" class="pdu-btn-secondary !py-2">
                Quay lại
            </a>
        </header>

        <form action="<?php echo e(isset($user) ? route('admin.accounts.capnhat', $user->id) : route('admin.accounts.luu')); ?>" method="POST" class="space-y-6">
            <?php echo csrf_field(); ?>
            <?php if(isset($user)): ?> <?php echo method_field('PUT'); ?> <?php endif; ?>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                
                <div class="md:col-span-2 pdu-card space-y-6">
                    <h3 class="text-[11px] font-black text-ink-primary uppercase tracking-widest border-b border-ui-border pb-4">Thông tin định danh</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-2">
                            <label class="text-[10px] font-black uppercase tracking-widest text-ink-secondary">Họ và tên</label>
                            <input type="text" name="name" value="<?php echo e(old('name', $user->name ?? '')); ?>" required
                                class="pdu-input w-full" placeholder="Nguyễn Văn A">
                            <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-[10px] font-bold text-status-error uppercase mt-1"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div class="space-y-2">
                            <label class="text-[10px] font-black uppercase tracking-widest text-ink-secondary">Địa chỉ Email</label>
                            <input type="email" name="email" value="<?php echo e(old('email', $user->email ?? '')); ?>" required
                                class="pdu-input w-full" placeholder="admin@pdu.edu.vn">
                            <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-[10px] font-bold text-status-error uppercase mt-1"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                    </div>
                </div>

                
                <div class="pdu-card space-y-6">
                    <h3 class="text-[11px] font-black text-ink-primary uppercase tracking-widest border-b border-ui-border pb-4">Bảo mật</h3>
                    
                    <div class="space-y-4">
                        <div class="space-y-2">
                            <label class="text-[10px] font-black uppercase tracking-widest text-ink-secondary">Mật khẩu <?php echo e(isset($user) ? '(Để trống nếu không đổi)' : ''); ?></label>
                            <input type="password" name="password" class="pdu-input w-full" placeholder="••••••••">
                            <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-[10px] font-bold text-status-error uppercase mt-1"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div class="space-y-2">
                            <label class="text-[10px] font-black uppercase tracking-widest text-ink-secondary">Xác nhận mật khẩu</label>
                            <input type="password" name="password_confirmation" class="pdu-input w-full" placeholder="••••••••">
                        </div>
                    </div>
                </div>

                
                <div class="pdu-card space-y-6">
                    <h3 class="text-[11px] font-black text-ink-primary uppercase tracking-widest border-b border-ui-border pb-4">Phân quyền & Trạng thái</h3>
                    
                    <div class="space-y-4">
                        <div class="space-y-2">
                            <label class="text-[10px] font-black uppercase tracking-widest text-ink-secondary">Vai trò người dùng</label>
                            <select name="vaitro" class="pdu-input w-full bg-white" required>
                                <?php $__currentLoopData = \App\Enums\UserRole::cases(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php if($role->isAdminGroup()): ?>
                                        <option value="<?php echo e($role->value); ?>" <?php if(old('vaitro', $user->vaitro->value ?? '') == $role->value): echo 'selected'; endif; ?>>
                                            <?php echo e($role->label()); ?>

                                        </option>
                                    <?php endif; ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                            <?php $__errorArgs = ['vaitro'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-[10px] font-bold text-status-error uppercase mt-1"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div class="flex items-center justify-between p-4 bg-ui-bg rounded-xl border border-ui-border">
                            <div>
                                <div class="text-xs font-bold text-ink-primary">Trạng thái hoạt động</div>
                                <div class="text-[9px] font-medium text-ink-secondary/60 uppercase tracking-widest mt-0.5">Cho phép đăng nhập</div>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="hidden" name="is_active" value="0">
                                <input type="checkbox" name="is_active" value="1" class="sr-only peer" <?php if(old('is_active', $user->is_active ?? true)): echo 'checked'; endif; ?>>
                                <div class="w-11 h-6 bg-ui-border peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-brand-emerald"></div>
                            </label>
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex items-center justify-end gap-4 pt-4">
                <button type="submit" class="pdu-btn-primary shadow-xl shadow-brand-emerald/20 !px-12 h-12">
                    <svg class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                    <?php echo e(isset($user) ? 'Lưu thay đổi' : 'Xác nhận tạo tài khoản'); ?>

                </button>
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
<?php /**PATH D:\laragon\www\hethongquanlyktxv1\resources\views/admin/accounts/form.blade.php ENDPATH**/ ?>