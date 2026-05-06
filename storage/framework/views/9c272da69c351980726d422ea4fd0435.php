<?php if (isset($component)) { $__componentOriginal61b7c119be9b054fc3033ecd71de14c0 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal61b7c119be9b054fc3033ecd71de14c0 = $attributes; } ?>
<?php $component = App\View\Components\LandingLayout::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('landing-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(App\View\Components\LandingLayout::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
     <?php $__env->slot('title', null, []); ?> Tra cứu đơn đăng ký - KTX ABC <?php $__env->endSlot(); ?>

    <div class="pt-36 pb-24 min-h-screen bg-[#fafafa] relative overflow-hidden">
        <!-- Minimal Dot Grid -->
        <div class="absolute inset-0 opacity-100 bg-[radial-gradient(#d1d5db_1.5px,transparent_1.5px)] [background-size:32px_32px] [mask-image:linear-gradient(to_bottom,white,transparent)] pointer-events-none"></div>

        <div class="max-w-[1000px] mx-auto px-6 relative z-10">
            
            <div class="text-center mb-16">
                <h1 class="font-display text-4xl font-bold tracking-tight text-ink-primary sm:text-5xl mb-4">
                    Theo dõi hành trình nội trú.
                </h1>
                <p class="mx-auto max-w-2xl text-lg text-ink-secondary leading-relaxed">
                    Nhập mã định danh duy nhất được gửi tới hòm thư của bạn để cập nhật trạng thái xét duyệt hồ sơ và hướng dẫn nhận phòng.
                </p>
            </div>

            
            <div class="bg-white border border-ui-border p-3 mb-12 shadow-sm">
                <form action="<?php echo e(route('guest.lookup')); ?>" method="GET" class="flex flex-col sm:flex-row gap-3">
                    <div class="flex-grow relative">
                        <div class="absolute left-4 top-1/2 -translate-y-1/2 text-ink-secondary">
                            <span class="text-lg opacity-50">🔍</span>
                        </div>
                        <input type="text" name="token" value="<?php echo e($token); ?>" 
                               class="w-full bg-white border-none text-ink-primary text-base focus:ring-0 focus:border-transparent py-4 pl-12 placeholder-ink-secondary/50" 
                               placeholder="Nhập mã tra cứu (VD: a1b2c3d4...)"
                               required>
                    </div>
                    <button type="submit" class="bg-ink-primary text-white hover:bg-brand-emerald px-8 py-4 shrink-0 text-sm font-bold uppercase tracking-widest transition-colors">
                        Kiểm tra ngay
                    </button>
                </form>
            </div>

            
            <?php if($token && !$dangky): ?>
                <div class="bg-white border border-red-500/20 p-10 lg:p-12 text-center shadow-sm">
                    <div class="w-16 h-16 bg-red-500/5 border border-red-500/20 flex items-center justify-center text-3xl mx-auto mb-6">❌</div>
                    <h3 class="text-2xl font-display font-bold text-ink-primary mb-3">Mã tra cứu không tồn tại</h3>
                    <p class="text-ink-secondary max-w-md mx-auto leading-relaxed mb-8">
                        Chúng tôi không tìm thấy hồ sơ nào khớp với mã bạn vừa cung cấp. Vui lòng kiểm tra lại chính xác từng ký tự trong thư điện tử xác nhận.
                    </p>
                    <a href="mailto:support@ktx.edu.vn" class="text-ink-primary border-b border-ink-primary font-bold hover:text-brand-emerald hover:border-brand-emerald transition-colors pb-0.5">Liên hệ hỗ trợ kỹ thuật →</a>
                </div>
            <?php endif; ?>

            
            <?php if($dangky): ?>
                <?php
                    $statusEnum = $dangky->trang_thai instanceof \App\Enums\RegistrationStatus
                        ? $dangky->trang_thai
                        : \App\Enums\RegistrationStatus::tryFrom((string) ($dangky->trang_thai ?? ''));
                    $isCompleted = $statusEnum?->value === \App\Enums\RegistrationStatus::Completed->value;
                ?>
                <div class="space-y-8">
                    <div class="bg-white border border-ui-border shadow-sm">
                        
                        <div class="bg-ink-primary px-8 py-10 lg:px-12 text-white border-b border-ink-primary">
                            <div class="flex flex-col md:flex-row md:items-end justify-between gap-6">
                                <div>
                                    <div class="flex items-center gap-3 mb-4">
                                        <span class="px-3 py-1 bg-white/10 border border-white/20 text-[10px] font-bold uppercase tracking-widest text-white/70">Phiếu đăng ký</span>
                                        <span class="text-white/70 text-sm font-bold"><?php echo e($dangky->created_at->format('d/m/Y')); ?></span>
                                    </div>
                                    <h3 class="text-4xl font-display font-bold tracking-tight">Hồ sơ #<?php echo e($dangky->id); ?></h3>
                                </div>
                                <div class="px-5 py-2.5 text-sm font-bold uppercase tracking-widest border <?php echo e($isCompleted ? 'bg-brand-emerald text-white border-brand-emerald' : 'bg-white text-ink-primary border-white'); ?>">
                                    <?php echo e($statusEnum?->label() ?? 'Không xác định'); ?>

                                </div>
                            </div>
                        </div>

                        
                        <div class="p-8 lg:p-12">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-10 lg:gap-16">
                                <div>
                                    <h4 class="text-[10px] font-bold text-ink-secondary uppercase tracking-widest mb-6 border-b border-ui-border pb-2">Thông tin cá nhân</h4>
                                    <div class="space-y-6">
                                        <div class="flex items-start gap-4">
                                            <div class="w-10 h-10 bg-ui-bg border border-ui-border flex items-center justify-center text-ink-primary shrink-0 opacity-50">👤</div>
                                            <div class="pt-0.5">
                                                <p class="text-[10px] font-bold text-ink-secondary uppercase tracking-widest mb-1">Chủ hồ sơ</p>
                                                <p class="text-base font-bold text-ink-primary"><?php echo e($dangky->ho_ten); ?></p>
                                            </div>
                                        </div>
                                        <div class="flex items-start gap-4">
                                            <div class="w-10 h-10 bg-ui-bg border border-ui-border flex items-center justify-center text-ink-primary shrink-0 opacity-50">📧</div>
                                            <div class="pt-0.5">
                                                <p class="text-[10px] font-bold text-ink-secondary uppercase tracking-widest mb-1">Hòm thư liên hệ</p>
                                                <p class="text-base font-bold text-ink-primary"><?php echo e($dangky->email); ?></p>
                                            </div>
                                        </div>
                                        <div class="flex items-start gap-4">
                                            <div class="w-10 h-10 bg-ui-bg border border-ui-border flex items-center justify-center text-ink-primary shrink-0 opacity-50">📱</div>
                                            <div class="pt-0.5">
                                                <p class="text-[10px] font-bold text-ink-secondary uppercase tracking-widest mb-1">Số điện thoại</p>
                                                <p class="text-base font-bold text-ink-primary"><?php echo e($dangky->so_dien_thoai); ?></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div>
                                    <h4 class="text-[10px] font-bold text-ink-secondary uppercase tracking-widest mb-6 border-b border-ui-border pb-2">Cấu hình lưu trú</h4>
                                    <div class="space-y-6">
                                        <div class="flex items-start gap-4">
                                            <div class="w-10 h-10 bg-ui-bg border border-ui-border flex items-center justify-center text-ink-primary shrink-0 opacity-50">🏠</div>
                                            <div class="pt-0.5">
                                                <p class="text-[10px] font-bold text-ink-secondary uppercase tracking-widest mb-1">Phòng dự kiến</p>
                                                <p class="text-base font-bold text-ink-primary"><?php echo e($dangky->phong?->tenphong ?? 'Chưa xác định'); ?></p>
                                            </div>
                                        </div>
                                        <div class="flex items-start gap-4">
                                            <div class="w-10 h-10 bg-ui-bg border border-ui-border flex items-center justify-center text-ink-primary shrink-0 opacity-50">📅</div>
                                            <div class="pt-0.5">
                                                <p class="text-[10px] font-bold text-ink-secondary uppercase tracking-widest mb-1">Thời hạn giữ chỗ</p>
                                                <p class="text-base font-bold text-ink-primary"><?php echo e($dangky->token_expires_at ? $dangky->token_expires_at->format('d/m/Y H:i') : 'Vô thời hạn'); ?></p>
                                            </div>
                                        </div>
                                        <div class="flex items-start gap-4">
                                            <div class="w-10 h-10 bg-brand-emerald/5 border border-brand-emerald/20 flex items-center justify-center text-brand-emerald shrink-0">💰</div>
                                            <div class="pt-0.5">
                                                <p class="text-[10px] font-bold text-ink-secondary uppercase tracking-widest mb-1">Phí cọc (Tiêu chuẩn)</p>
                                                <p class="text-base font-bold text-brand-emerald"><?php echo e(number_format($dangky->phong?->giaphong ?? 0)); ?>đ</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            
                            <div class="mt-12 pt-12 border-t border-ui-border">
                                <h4 class="text-[10px] font-bold text-ink-secondary uppercase tracking-widest mb-10 text-center">Tiến trình xử lý hồ sơ</h4>
                                
                                <div class="relative max-w-2xl mx-auto">
                                    <?php
                                        $statusValue = $statusEnum?->value;
                                        $statuses = [
                                            ['label' => 'Đã tiếp nhận', 'desc' => 'Hệ thống đã nhận đơn', 'active' => true],
                                            ['label' => 'Đang thẩm định', 'desc' => 'Ban quản lý đang kiểm tra thông tin', 'active' => in_array($statusValue, [\App\Enums\RegistrationStatus::Approved->value, \App\Enums\RegistrationStatus::ApprovedPendingPayment->value, \App\Enums\RegistrationStatus::Completed->value], true)],
                                            ['label' => 'Chờ thanh toán', 'desc' => 'Vui lòng nộp phí giữ chỗ', 'active' => in_array($statusValue, [\App\Enums\RegistrationStatus::ApprovedPendingPayment->value, \App\Enums\RegistrationStatus::Completed->value], true)],
                                            ['label' => 'Hoàn tất', 'desc' => 'Đã sẵn sàng nhận phòng', 'active' => $statusValue === \App\Enums\RegistrationStatus::Completed->value],
                                        ];
                                        $currentStep = 0;
                                        foreach($statuses as $idx => $s) if($s['active']) $currentStep = $idx;
                                    ?>

                                    <div class="space-y-10 pl-4 md:pl-0">
                                        <?php $__currentLoopData = $statuses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $step): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <div class="flex gap-6 relative md:justify-center md:text-center md:flex-col md:items-center">
                                                
                                                <?php if($index < count($statuses) - 1): ?>
                                                    <div class="absolute left-4 top-10 w-px h-12 md:hidden <?php echo e($statuses[$index+1]['active'] ? 'bg-ink-primary' : 'bg-ui-border'); ?>"></div>
                                                <?php endif; ?>
                                                
                                                
                                                <?php if($index < count($statuses) - 1): ?>
                                                    <div class="hidden md:block absolute left-[50%] top-4 w-full h-px <?php echo e($statuses[$index+1]['active'] ? 'bg-ink-primary' : 'bg-ui-border'); ?>"></div>
                                                <?php endif; ?>

                                                <div class="w-8 h-8 flex items-center justify-center shrink-0 z-10 transition-colors <?php echo e($step['active'] ? 'bg-ink-primary text-white border border-ink-primary' : 'bg-white border border-ui-border text-ink-secondary'); ?>">
                                                    <?php if($step['active'] && $index < $currentStep): ?>
                                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                                    <?php else: ?>
                                                        <span class="font-display font-bold text-xs"><?php echo e($index + 1); ?></span>
                                                    <?php endif; ?>
                                                </div>
                                                
                                                <div class="pt-1 md:pt-0">
                                                    <h5 class="text-sm font-bold uppercase tracking-wide <?php echo e($step['active'] ? 'text-ink-primary' : 'text-ink-secondary'); ?>"><?php echo e($step['label']); ?></h5>
                                                    <p class="text-xs mt-1 <?php echo e($step['active'] ? 'text-ink-secondary' : 'text-ink-secondary/60'); ?>"><?php echo e($step['desc']); ?></p>
                                                </div>
                                            </div>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </div>
                                </div>

                                
                                <?php if(($statusEnum?->value) === \App\Enums\RegistrationStatus::ApprovedPendingPayment->value): ?>
                                    <div class="mt-16 p-8 bg-brand-emerald/5 border border-brand-emerald/20">
                                        <div class="flex items-center gap-3 mb-4">
                                            <div class="w-8 h-8 bg-brand-emerald text-white flex items-center justify-center text-sm">ℹ</div>
                                            <h5 class="text-lg font-display font-bold text-ink-primary uppercase tracking-wide">Yêu cầu hoàn tất lệ phí</h5>
                                        </div>
                                        <p class="text-ink-secondary leading-relaxed mb-6">
                                            Chúc mừng! Hồ sơ của bạn đã được phê duyệt sơ bộ. Vui lòng hoàn tất thanh toán lệ phí giữ chỗ trước <span class="font-bold text-ink-primary border-b border-ink-primary"><?php echo e($dangky->token_expires_at?->format('H:i, d/m/Y') ?? 'Chưa có'); ?></span> để giữ quyền ưu tiên nhận phòng.
                                        </p>
                                        <div class="bg-white p-6 border border-ui-border flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                                            <div>
                                                <p class="text-[10px] font-bold text-ink-secondary uppercase tracking-widest mb-1">Nội dung chuyển khoản chuẩn</p>
                                                <code class="text-lg font-bold text-ink-primary">KTX <?php echo e($dangky->id); ?> <?php echo e($dangky->so_dien_thoai); ?></code>
                                            </div>
                                            <button onclick="navigator.clipboard.writeText('KTX <?php echo e($dangky->id); ?> <?php echo e($dangky->so_dien_thoai); ?>')" class="bg-ink-primary text-white hover:bg-brand-emerald px-6 py-2.5 text-xs font-bold uppercase tracking-widest transition-colors">
                                                Sao chép
                                            </button>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>

                    
                    <div class="flex flex-col md:flex-row items-center justify-between gap-6 px-8 py-6 bg-white border border-ui-border shadow-sm">
                        <div class="flex items-center gap-3 text-ink-secondary">
                            <span class="text-ink-primary">ℹ</span>
                            <p class="text-sm">Bạn có thắc mắc về kết quả xét duyệt? Đọc kỹ <a href="#" class="text-ink-primary font-bold border-b border-ink-primary hover:text-brand-emerald hover:border-brand-emerald transition-colors pb-0.5">Quy định nội trú</a>.</p>
                        </div>
                        <button onclick="window.print()" class="text-ink-primary border border-ink-primary hover:bg-ui-bg px-6 py-3 text-xs font-bold uppercase tracking-widest flex items-center gap-2 shrink-0 transition-colors">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="square" stroke-linejoin="miter" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                            In biên lai
                        </button>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal61b7c119be9b054fc3033ecd71de14c0)): ?>
<?php $attributes = $__attributesOriginal61b7c119be9b054fc3033ecd71de14c0; ?>
<?php unset($__attributesOriginal61b7c119be9b054fc3033ecd71de14c0); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal61b7c119be9b054fc3033ecd71de14c0)): ?>
<?php $component = $__componentOriginal61b7c119be9b054fc3033ecd71de14c0; ?>
<?php unset($__componentOriginal61b7c119be9b054fc3033ecd71de14c0); ?>
<?php endif; ?>
<?php /**PATH D:\laragon\www\hethongquanlyktxv1\resources\views/landing/lookup.blade.php ENDPATH**/ ?>