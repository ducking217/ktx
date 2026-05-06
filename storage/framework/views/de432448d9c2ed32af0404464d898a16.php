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
     <?php $__env->slot('title', null, []); ?> Ký túc xá Đại học Phương Đông - Không gian sống lý tưởng <?php $__env->endSlot(); ?>

    <div class="relative z-10 bg-ui-bg">
    <?php if(session('success')): ?>
        <div class="fixed top-24 left-1/2 -translate-x-1/2 z-[100] w-full max-w-md px-6">
            <div class="bg-ink-primary text-ink-white px-5 py-3.5 rounded-xl shadow-lg border border-ui-border flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <svg class="w-5 h-5 text-brand-emerald" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    <span class="font-bold text-[13px] tracking-wide"><?php echo e(session('success')); ?></span>
                </div>
                <button onclick="this.parentElement.parentElement.remove()" class="text-ink-secondary/60 hover:text-ink-white transition-colors"><svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg></button>
            </div>
        </div>
    <?php endif; ?>
    <?php if($errors->any()): ?>
        <div class="fixed top-24 left-1/2 -translate-x-1/2 z-[100] w-full max-w-md px-6">
            <div class="bg-white text-gray-900 px-5 py-4 rounded-xl shadow-lg border border-red-200">
                <div class="flex items-center justify-between mb-2 border-b border-gray-100 pb-2">
                    <span class="font-bold text-[13px] text-red-600 flex items-center gap-2"><svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg> Lỗi đăng ký</span>
                    <button onclick="this.parentElement.parentElement.parentElement.remove()" class="text-gray-400 hover:text-gray-900"><svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg></button>
                </div>
                <ul class="text-[13px] list-none space-y-1 mt-3 text-gray-600"><?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><li class="flex items-start gap-2"><span class="text-red-400 mt-1">•</span> <?php echo e($error); ?></li><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></ul>
            </div>
        </div>
    <?php endif; ?>

    
    <section id="hero" class="relative pt-32 pb-24 lg:pt-48 lg:pb-32 overflow-hidden border-b border-ui-border bg-ui-bg">
        <!-- Minimal Dot Grid - Enhanced for Hero -->
        <div class="absolute inset-0 opacity-100 bg-[radial-gradient(oklch(var(--ui-border-lch))_1.5px,transparent_1.5px)] [background-size:32px_32px] [mask-image:linear-gradient(to_bottom,white,transparent)]"></div>

        <div class="max-w-[1280px] mx-auto px-6 relative z-10 w-full">
            <div class="max-w-[800px] mx-auto text-center flex flex-col items-center">
                
                <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-ui-card border border-ui-border text-[11px] font-bold uppercase tracking-widest text-ink-secondary/60 mb-8 shadow-sm">
                    <span class="w-1.5 h-1.5 rounded-full bg-brand-emerald animate-pulse"></span>
                    Năm học 2026–2027
                </div>
                
                <h1 class="font-display text-[clamp(3.5rem,8vw,6rem)] font-bold tracking-tighter text-ink-primary leading-[1.05] mb-6">
                    Sống hiện đại.<br>
                    <span class="text-ink-secondary/40">Học hiệu quả.</span>
                </h1>
                
                <p class="text-[clamp(1rem,2vw,1.25rem)] text-ink-secondary max-w-[60ch] leading-relaxed mb-10 font-medium">
                    Ký túc xá Đại học Phương Đông mang đến không gian lưu trú an toàn, tiện nghi và minh bạch. Bệ phóng cho những năm tháng đại học rực rỡ nhất của bạn.
                </p>
                
                <div class="flex flex-col sm:flex-row items-center justify-center gap-4 w-full sm:w-auto">
                    <?php if(auth()->guard()->check()): ?>
                        <a href="<?php echo e(route('dieuhuong')); ?>" class="pdu-btn-primary w-full sm:w-auto gap-2 shadow-lg shadow-ink-primary/10">
                            Đi đến Bảng điều khiển
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                        </a>
                    <?php else: ?>
                        <a href="<?php echo e(route('public.danhsachphong')); ?>" class="pdu-btn-primary w-full sm:w-auto gap-2 shadow-lg shadow-ink-primary/10">
                            Đăng ký giữ chỗ
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                        </a>
                        <a href="#phong-o" class="pdu-btn-ghost w-full sm:w-auto bg-ui-card">
                            Xem phòng trống
                        </a>
                    <?php endif; ?>
                </div>
            </div>

            
            <div class="mt-24 max-w-[1000px] mx-auto relative z-20 bg-ui-card rounded-2xl border border-ui-border shadow-sm overflow-hidden">
                <div class="grid grid-cols-2 md:grid-cols-4 divide-x divide-y md:divide-y-0 divide-ui-border">
                    <div class="p-8 flex flex-col items-center text-center group">
                        <span class="font-display text-4xl font-bold text-ink-primary mb-1 tracking-tight"><?php echo e($soSinhVien); ?></span>
                        <span class="text-[11px] font-bold uppercase tracking-widest text-ink-secondary/60">Sinh viên</span>
                    </div>
                    <div class="p-8 flex flex-col items-center text-center group">
                        <span class="font-display text-4xl font-bold text-ink-primary mb-1 tracking-tight"><?php echo e($tongSoPhong); ?></span>
                        <span class="text-[11px] font-bold uppercase tracking-widest text-ink-secondary/60">Phòng ở</span>
                    </div>
                    <div class="p-8 flex flex-col items-center text-center group">
                        <span class="font-display text-4xl font-bold text-ink-primary mb-1 tracking-tight"><?php echo e($soToa); ?></span>
                        <span class="text-[11px] font-bold uppercase tracking-widest text-ink-secondary/60">Tòa nhà</span>
                    </div>
                    <div class="p-8 flex flex-col items-center text-center group bg-ui-bg/50">
                        <span class="font-display text-4xl font-bold text-brand-emerald mb-1 tracking-tight">PDU</span>
                        <span class="text-[11px] font-bold uppercase tracking-widest text-ink-secondary/60">Ký túc xá</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    
    <section id="tong-quan" class="py-24 lg:py-32 bg-white relative">
        <div class="max-w-[1280px] mx-auto px-6">
            <div class="flex flex-col lg:flex-row gap-16 lg:gap-24 items-center">
                <div class="flex-1 relative z-10">
                    <h2 class="font-display text-[clamp(2rem,4vw,3rem)] font-bold tracking-tighter text-ink-primary mb-6 leading-[1.1]">
                        Hơn cả một nơi để ở.<br>
                        <span class="text-ink-secondary/40">Đó là một cộng đồng.</span>
                    </h2>
                    <p class="text-lg text-ink-secondary/60 mb-12 max-w-prose leading-relaxed">
                        Được xây dựng theo tiêu chuẩn hiện đại, KTX Phương Đông hướng tới môi trường sống chất lượng cao. Nơi sự riêng tư được tôn trọng và cộng đồng được kết nối.
                    </p>
                    
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <div class="flex flex-col gap-4 p-6 rounded-2xl bg-ui-bg border border-ui-border hover:border-brand-emerald/30 transition-colors">
                            <div class="w-10 h-10 rounded-lg bg-ink-primary flex items-center justify-center shadow-sm">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M11 20A7 7 0 0 1 9.8 6.1C15.5 5 17 4.48 19 2c1 2 2 4.18 2 8a7 7 0 0 1-7 7c-1.14 0-2.23-.3-3.17-.85"/><path d="M11 20c0-2.33.66-4.5 1.84-6.34"/></svg>
                            </div>
                            <div>
                                <h4 class="font-bold text-ink-primary text-base mb-1 uppercase tracking-tight">Không gian Xanh</h4>
                                <p class="text-sm text-ink-secondary/60 leading-relaxed">Mảng xanh phân bổ tinh tế khắp hành lang và sân thượng.</p>
                            </div>
                        </div>
                        <div class="flex flex-col gap-4 p-6 rounded-2xl bg-ui-bg border border-ui-border hover:border-brand-emerald/30 transition-colors">
                            <div class="w-10 h-10 rounded-lg bg-ink-primary flex items-center justify-center shadow-sm">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/><path d="m9 12 2 2 4-4"/></svg>
                            </div>
                            <div>
                                <h4 class="font-bold text-ink-primary text-base mb-1 uppercase tracking-tight">An ninh 24/7</h4>
                                <p class="text-sm text-ink-secondary/60 leading-relaxed">Camera giám sát AI, bảo vệ trực ban và thẻ từ đa lớp.</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="flex-1 w-full">
                    <!-- Clean Bento Grid -->
                    <div class="grid grid-cols-2 gap-4 auto-rows-[160px]">
                        <div class="col-span-2 row-span-2 rounded-2xl overflow-hidden bg-gray-100 relative group border border-gray-200/50 shadow-sm">
                            <img src="https://images.unsplash.com/photo-1568667256549-094345857637?auto=format&fit=crop&w=800&q=80" alt="Thư viện" class="w-full h-full object-cover transition-transform duration-[1.5s] ease-out group-hover:scale-105">
                            <div class="absolute inset-0 bg-black/20 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                            <div class="absolute bottom-6 left-6 z-20 opacity-0 group-hover:opacity-100 transition-all duration-300 translate-y-2 group-hover:translate-y-0">
                                <span class="bg-white/90 backdrop-blur-md text-gray-900 px-4 py-2 rounded-lg text-sm font-bold shadow-sm">Thư viện tự học</span>
                            </div>
                        </div>
                        <div class="rounded-2xl overflow-hidden bg-gray-100 relative group border border-gray-200/50 shadow-sm">
                            <img src="https://images.unsplash.com/photo-1540569014015-19a7be504e3a?auto=format&fit=crop&w=400&q=80" alt="Gym" class="w-full h-full object-cover transition-transform duration-[1.5s] ease-out group-hover:scale-105">
                        </div>
                        <div class="rounded-2xl overflow-hidden bg-gray-100 relative group border border-gray-200/50 shadow-sm">
                            <img src="https://images.unsplash.com/photo-1555854877-bab0e564b8d5?auto=format&fit=crop&w=400&q=80" alt="Căng tin" class="w-full h-full object-cover transition-transform duration-[1.5s] ease-out group-hover:scale-105">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    
    <section id="phong-o" class="py-24 lg:py-32 bg-white relative border-y border-ui-border">
        <div class="max-w-[1200px] mx-auto px-6 relative z-10">
            <div class="flex flex-col md:flex-row justify-between items-end mb-16 gap-8">
                <div class="max-w-2xl">
                    <p class="text-xs font-bold uppercase tracking-widest text-brand-emerald mb-3">Danh sách phòng</p>
                    <h2 class="font-display text-[clamp(2.5rem,4vw,3.5rem)] font-bold text-ink-primary tracking-tight leading-[1.1]">Tra cứu phòng ở.</h2>
                    <p class="mt-4 text-ink-secondary text-lg">Tình trạng phòng được cập nhật theo thời gian thực từ hệ thống.</p>
                </div>
                <div class="flex flex-col sm:flex-row gap-3 w-full md:w-auto">
                    <select id="filter-gender" class="bg-white border border-ui-border text-ink-primary text-sm font-bold rounded-none focus:ring-0 focus:border-ink-primary block w-full sm:w-[180px] p-3 transition-colors cursor-pointer shadow-sm">
                        <option value="all">Tất cả giới tính</option>
                        <option value="Nam">Phòng Nam</option>
                        <option value="Nữ">Phòng Nữ</option>
                    </select>
                    <select id="filter-status" class="bg-white border border-ui-border text-ink-primary text-sm font-bold rounded-none focus:ring-0 focus:border-ink-primary block w-full sm:w-[200px] p-3 transition-colors cursor-pointer shadow-sm">
                        <option value="all">Tất cả trạng thái</option>
                        <option value="available">Còn trống</option>
                        <option value="full">Đã kín chỗ</option>
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-4" id="room-container">
                <?php $__empty_1 = true; $__currentLoopData = $phongList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $phong): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <?php
                        $sucChua = $phong->loaiphong->suc_chua ?? 0;
                        $dangO = $phong->dango_count ?? 0;
                        $conTrong = max(0, $sucChua - $dangO);
                        $isAvailable = $conTrong > 0;
                        $percentage = $sucChua > 0 ? ($dangO / $sucChua) * 100 : 0;
                    ?>
                    <div class="room-card bg-white p-5 border border-ui-border hover:border-ink-primary transition-colors duration-300 flex flex-col group shadow-sm hover:shadow-md" data-gender="<?php echo e($phong->gioi_tinh_han_che?->label() ?? 'all'); ?>" data-available="<?php echo e($isAvailable ? 'available' : 'full'); ?>" style="display:none;">
                        
                        <div class="flex justify-between items-start mb-5">
                            <div>
                                <h3 class="text-base font-display font-bold text-ink-primary mb-0.5"><?php echo e($phong->ten_phong); ?></h3>
                                <p class="text-[10px] font-bold text-ink-secondary uppercase tracking-wider">Tầng <?php echo e($phong->tang); ?> · <?php echo e($phong->gioi_tinh_han_che?->label() ?? 'Không có'); ?></p>
                            </div>
                            <span class="px-2 py-0.5 text-[9px] font-bold uppercase tracking-wider border <?php echo e($isAvailable ? 'border-brand-emerald text-brand-emerald bg-brand-emerald/5' : 'border-red-500 text-red-600 bg-red-500/5'); ?>">
                                <?php echo e($isAvailable ? 'Còn '.$conTrong : 'Kín chỗ'); ?>

                            </span>
                        </div>

                        <div class="mb-6">
                            <div class="flex items-baseline gap-1">
                                <span class="text-xl font-display font-bold text-ink-primary tracking-tight"><?php echo e(number_format($phong->loaiphong->gia_thang ?? 0, 0, ',', '.')); ?></span>
                                <span class="text-xs font-bold text-ink-secondary">đ/tháng</span>
                            </div>
                        </div>

                        <div class="space-y-5 flex-grow">
                            <!-- Progress Bar Minimal -->
                            <div>
                                <div class="flex justify-between text-[10px] font-bold text-ink-secondary mb-1.5">
                                    <span>Sức chứa: <?php echo e($sucChua); ?></span>
                                    <span class="<?php echo e($isAvailable ? 'text-ink-primary' : 'text-red-500'); ?>">Đang ở: <?php echo e($dangO); ?></span>
                                </div>
                                <div class="w-full bg-ui-bg h-1 rounded-full overflow-hidden">
                                     
                                     <div class="h-full rounded-full transition-all duration-500 ease-out <?php echo e($isAvailable ? 'bg-brand-emerald' : 'bg-red-500'); ?>" style="<?php echo \Illuminate\Support\Arr::toCssStyles(["width: " . (int)$percentage . "%"]) ?>"></div>
                                 </div>
                            </div>
                            
                            <a href="<?php echo e(route('public.chitietvattu', $phong->id)); ?>" class="inline-flex items-center justify-center gap-2 px-3 py-2 bg-ui-bg text-ink-primary text-[10px] font-bold uppercase tracking-widest border border-ui-border hover:bg-ui-muted transition-colors">
                                <svg class="w-4 h-4 opacity-50" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V7a2 2 0 0 0-2-2h-2.5M4 19V7a2 2 0 0 1 2-2h2.5M8 21h8M12 17v4M7 13h10M7 9h10"/>
                                </svg>
                                Xem chi tiết vật tư
                            </a>
                        </div>

                        <div class="mt-5 pt-4 border-t border-ui-border">
                            <?php if($isAvailable): ?>
                                <a href="<?php echo e(route('guest.dangky.create', ['phong_id' => $phong->id])); ?>" class="w-full bg-ink-primary text-white hover:bg-brand-emerald py-2.5 text-[11px] font-bold tracking-wide transition-colors flex items-center justify-center gap-2 group-hover:gap-3">
                                    Đăng ký <span class="transition-all">→</span>
                                </a>
                            <?php else: ?>
                                <button disabled class="w-full bg-ui-bg text-ink-secondary py-2.5 text-[11px] font-bold tracking-wide cursor-not-allowed border border-ui-border">
                                    Đã kín chỗ
                                </button>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <div class="col-span-full text-center py-24 bg-ui-bg border border-ui-border">
                        <h3 class="text-xl font-bold text-ink-primary mb-2">Chưa có dữ liệu phòng</h3>
                        <p class="text-sm text-ink-secondary max-w-md mx-auto">Hệ thống đang được cập nhật dữ liệu từ Ban quản lý.</p>
                    </div>
                <?php endif; ?>
            </div>
            
            <div id="pagination-controls" class="mt-16 flex justify-center gap-2"></div>
        </div>
    </section>
    
    <section id="chi-phi" class="py-24 lg:py-32 relative bg-ui-bg border-b border-ui-border">
        <div class="max-w-[1280px] mx-auto px-6">
            <div class="text-center max-w-2xl mx-auto mb-16">
                <p class="text-brand-emerald font-bold tracking-widest uppercase text-xs mb-3">Minh bạch & Rõ ràng</p>
                <h2 class="font-display text-4xl md:text-5xl font-bold text-ink-primary tracking-tight">Chi phí sinh hoạt.</h2>
                <p class="mt-4 text-ink-secondary text-lg">Mọi khoản phí đều được niêm yết công khai theo quy định của Đại học Phương Đông.</p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 lg:gap-12">
                <!-- Bảng giá dịch vụ -->
                <div class="bg-white border border-ui-border p-8 md:p-10 transition-colors duration-300 hover:border-ink-primary group">
                    <h3 class="text-2xl font-display font-bold text-ink-primary mb-8">Bảng giá dịch vụ</h3>
                    
                    <div class="space-y-3">
                        <div class="flex justify-between items-center p-4 bg-ui-bg border border-ui-border group-hover:border-ink-primary/20 transition-colors">
                            <div class="flex items-center gap-4">
                                <div class="w-10 h-10 flex items-center justify-center border border-ui-border text-ink-primary">
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M13 2 3 14h9l-1 8 10-12h-9l1-8z"/></svg>
                                </div>
                                <span class="font-bold text-ink-primary text-xs uppercase tracking-widest">Giá điện</span>
                            </div>
                            <span class="font-bold text-ink-primary text-lg tabular-nums tracking-tighter"><?php echo e(isset($cauhinh['gia_dien']) ? number_format($cauhinh['gia_dien'], 0, ',', '.') : '3.500'); ?>đ<span class="text-[10px] text-ink-secondary font-black uppercase tracking-widest ml-1">/kWh</span></span>
                        </div>
                        <div class="flex justify-between items-center p-4 bg-ui-bg border border-ui-border group-hover:border-ink-primary/20 transition-colors">
                            <div class="flex items-center gap-4">
                                <div class="w-10 h-10 flex items-center justify-center border border-ui-border text-ink-primary">
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22a7 7 0 0 0 7-7c0-2-1-3.9-3-5.5s-3.5-4-4-6.5c-.5 2.5-2 4.9-4 6.5s-3 3.5-3 5.5a7 7 0 0 0 7 7z"/></svg>
                                </div>
                                <span class="font-bold text-ink-primary text-xs uppercase tracking-widest">Nước sinh hoạt</span>
                            </div>
                            <span class="font-bold text-ink-primary text-lg tabular-nums tracking-tighter"><?php echo e(isset($cauhinh['gia_nuoc']) ? number_format($cauhinh['gia_nuoc'], 0, ',', '.') : '15.000'); ?>đ<span class="text-[10px] text-ink-secondary font-black uppercase tracking-widest ml-1">/m³</span></span>
                        </div>
                        <div class="flex justify-between items-center p-4 bg-brand-emerald/5 border border-brand-emerald/20">
                            <div class="flex items-center gap-4">
                                <div class="w-10 h-10 flex items-center justify-center border border-brand-emerald/20 text-brand-emerald">
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12.55a11 11 0 0 1 14.08 0"/><path d="M1.42 9a16 16 0 0 1 21.16 0"/><path d="M8.53 16.11a6 6 0 0 1 6.95 0"/><line x1="12" y1="20" x2="12.01" y2="20"/></svg>
                                </div>
                                <span class="font-bold text-brand-emerald text-xs uppercase tracking-widest">Internet / WiFi</span>
                            </div>
                            <span class="font-black text-brand-emerald text-[10px] uppercase tracking-[0.2em]">Miễn phí</span>
                        </div>
                        <div class="flex justify-between items-center p-4 bg-brand-emerald/5 border border-brand-emerald/20">
                            <div class="flex items-center gap-4">
                                <div class="w-10 h-10 flex items-center justify-center border border-brand-emerald/20 text-brand-emerald">
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                                </div>
                                <span class="font-bold text-brand-emerald text-xs uppercase tracking-widest">Vệ sinh hành lang</span>
                            </div>
                            <span class="font-black text-brand-emerald text-[10px] uppercase tracking-[0.2em]">Miễn phí</span>
                        </div>
                        <div class="flex justify-between items-center p-4 bg-ui-bg border border-ui-border group-hover:border-ink-primary/20 transition-colors">
                            <div class="flex items-center gap-4">
                                <div class="w-10 h-10 flex items-center justify-center border border-ui-border text-ink-primary">
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="6" cy="17" r="3"/><circle cx="18" cy="17" r="3"/><path d="M12 17h1"/><path d="m14 10 2 2 3.5-3.5"/><path d="M15 17h1"/><path d="M7 10h1.5l1.5 2 2-2 1.5 2H17"/><path d="M9 17h1"/></svg>
                                </div>
                                <span class="font-bold text-ink-primary text-xs uppercase tracking-widest">Gửi xe máy</span>
                            </div>
                            <span class="font-bold text-ink-primary text-lg tabular-nums tracking-tighter">120.000đ<span class="text-[10px] text-ink-secondary font-black uppercase tracking-widest ml-1">/tháng</span></span>
                        </div>
                    </div>
                </div>
                
                <!-- Nội quy cơ bản -->
                <div class="bg-ink-primary text-white border border-ink-primary p-8 md:p-10">
                    <h3 class="text-2xl font-display font-bold text-white mb-8">Nội quy cơ bản</h3>
                    <ul class="space-y-6">
                        <li class="flex gap-4">
                            <div class="w-8 h-8 flex items-center justify-center shrink-0 border border-white/20">
                                <svg class="w-4 h-4 text-brand-emerald" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                            <div>
                                <strong class="block text-white mb-1">Giờ giới nghiêm</strong>
                                <span class="text-white/70 text-sm leading-relaxed">Đóng cửa KTX vào lúc 23:00 và mở cửa vào 05:00 sáng hôm sau.</span>
                            </div>
                        </li>
                        <li class="flex gap-4">
                            <div class="w-8 h-8 flex items-center justify-center shrink-0 border border-white/20">
                                <svg class="w-4 h-4 text-brand-emerald" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                            </div>
                            <div>
                                <strong class="block text-white mb-1">Khách đến thăm</strong>
                                <span class="text-white/70 text-sm leading-relaxed">Đăng ký tại phòng bảo vệ. Thời gian từ 08:00 – 21:00. Không ở lại qua đêm.</span>
                            </div>
                        </li>
                        <li class="flex gap-4">
                            <div class="w-8 h-8 flex items-center justify-center shrink-0 border border-white/20">
                                <svg class="w-4 h-4 text-brand-emerald" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                            </div>
                            <div>
                                <strong class="block text-white mb-1">Thiết bị điện</strong>
                                <span class="text-white/70 text-sm leading-relaxed">Nghiêm cấm sử dụng bếp gas, bếp từ cá nhân và các thiết bị công suất lớn trong phòng.</span>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    
    <section id="quy-trinh" class="py-24 lg:py-32 bg-ui-bg border-b border-ui-border">
        <div class="max-w-[1280px] mx-auto px-6">
            <div class="text-center max-w-[800px] mx-auto mb-20">
                <p class="text-xs font-bold uppercase tracking-widest text-brand-emerald mb-3">100% Online</p>
                <h2 class="font-display text-[clamp(2.25rem,4vw,3rem)] font-bold text-ink-primary tracking-tight">Quy trình đăng ký siêu tốc.</h2>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-5 gap-8 text-center max-w-[1100px] mx-auto relative z-10">
                <?php $__currentLoopData = [
                    ['num'=>1,'title'=>'Tạo tài khoản','desc'=>'Bằng MSSV & Email'],
                    ['num'=>2,'title'=>'Chọn phòng','desc'=>'Xem ảnh & giá thực tế'],
                    ['num'=>3,'title'=>'Nộp hồ sơ','desc'=>'Điền form online','active'=>true],
                    ['num'=>4,'title'=>'Ký hợp đồng','desc'=>'Hợp đồng điện tử'],
                    ['num'=>5,'title'=>'Nhận phòng','desc'=>'Dọn vào ở ngay']
                ]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $step): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="flex flex-col items-center relative group">
                    <!-- Connector Line (Desktop only) -->
                    <?php if(!$loop->last): ?>
                        <div class="hidden md:block absolute top-8 left-[60%] w-full h-[1px] bg-ui-border -z-10">
                            <div class="h-full bg-ink-primary w-0 group-hover:w-full transition-all duration-500 ease-out"></div>
                        </div>
                    <?php endif; ?>
                    
                    <div class="w-16 h-16 flex items-center justify-center text-xl font-display font-bold mb-6 transition-colors duration-300 border <?php echo e(isset($step['active']) ? 'bg-ink-primary text-white border-ink-primary' : 'bg-white text-ink-primary border-ui-border group-hover:border-ink-primary'); ?>">
                        <?php echo e($step['num']); ?>

                    </div>
                    <h3 class="text-base font-bold text-ink-primary mb-1"><?php echo e($step['title']); ?></h3>
                    <p class="text-xs font-medium text-ink-secondary"><?php echo e($step['desc']); ?></p>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>

            <div class="mt-20 text-center">
                <a href="#phong-o" class="inline-flex items-center justify-center gap-3 bg-ink-primary hover:bg-brand-emerald text-white px-8 py-4 text-sm font-bold tracking-wide transition-colors group">
                    Bắt đầu chọn phòng ngay <span class="transition-transform group-hover:translate-x-1">→</span>
                </a>
            </div>
        </div>
    </section>

    
    <section id="lien-he" class="py-24 lg:py-32 bg-white relative">
        <div class="max-w-[1280px] mx-auto px-6">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-20">
                <div class="lg:col-span-5 flex flex-col justify-center">
                    <p class="text-xs font-bold uppercase tracking-widest text-brand-emerald mb-3">Liên hệ</p>
                    <h2 class="font-display text-[clamp(2.25rem,4vw,3rem)] font-bold mb-6 text-ink-primary leading-tight">Hỗ trợ sinh viên 24/7.</h2>
                    <p class="text-ink-secondary text-lg mb-12 leading-relaxed max-w-[400px]">Ban quản lý KTX Đại học Phương Đông luôn sẵn sàng giải đáp mọi thắc mắc về thủ tục, chi phí và cuộc sống tại KTX.</p>
                    
                    <div class="space-y-8">
                        <div class="flex items-start gap-4">
                            <div class="w-12 h-12 flex items-center justify-center shrink-0 border border-ui-border text-ink-secondary/40">
                                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            </div>
                            <div>
                                <h4 class="font-bold text-sm mb-1 text-ink-primary uppercase tracking-wide">Văn phòng BQL</h4>
                                <p class="text-sm text-ink-secondary leading-relaxed">Phòng 101, Tầng trệt, Tòa nhà KTX<br>Số 4, Ngõ 228 Minh Khai, Q.Hai Bà Trưng, HN</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-4">
                            <div class="w-12 h-12 flex items-center justify-center shrink-0 border border-ui-border text-ink-secondary/40">
                                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                            </div>
                            <div>
                                <h4 class="font-bold text-sm mb-1 text-ink-primary uppercase tracking-wide">Hotline (Zalo)</h4>
                                <p class="text-sm text-ink-secondary leading-relaxed"><?php echo e($cauhinh['hotline'] ?? '024 3624 1394'); ?></p>
                            </div>
                        </div>
                        <div class="flex items-start gap-4">
                            <div class="w-12 h-12 flex items-center justify-center shrink-0 border border-ui-border text-ink-secondary/40">
                                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 01-2 2H7a2 2 0 01-2-2V7a2 2 0 012-2h14a2 2 0 012 2v12z"/></svg>
                            </div>
                            <div>
                                <h4 class="font-bold text-sm mb-1 text-ink-primary uppercase tracking-wide">Email hỗ trợ</h4>
                                <p class="text-sm text-ink-secondary leading-relaxed">ktx@phuongdong.edu.vn</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="lg:col-span-7">
                    <div class="bg-ui-bg p-8 sm:p-12 border border-ui-border">
                        <h3 class="text-2xl font-display font-bold text-ink-primary mb-8">Gửi yêu cầu hỗ trợ</h3>
                        
                        <form action="<?php echo e(route('landing.lienhe')); ?>" method="POST" class="space-y-6">
                            <?php echo csrf_field(); ?>
                            <?php if(session('lienhe_thanhcong')): ?>
                                <div class="bg-brand-emerald/10 border border-brand-emerald px-6 py-4 flex items-center gap-3">
                                    <span class="text-brand-emerald text-xl">✓</span>
                                    <p class="text-sm font-bold text-brand-emerald"><?php echo e(session('lienhe_thanhcong')); ?></p>
                                </div>
                            <?php endif; ?>
                            
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-xs font-bold uppercase tracking-wider text-ink-secondary mb-2">Họ và tên</label>
                                    <input type="text" name="ho_ten" value="<?php echo e(old('ho_ten')); ?>" class="w-full bg-white border border-ui-border text-ink-primary rounded-none focus:ring-0 focus:border-ink-primary p-3.5 transition-colors" placeholder="Nguyễn Văn A">
                                    <?php $__errorArgs = ['ho_ten'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="mt-2 text-xs font-medium text-red-500"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                                <div>
                                    <label class="block text-xs font-bold uppercase tracking-wider text-ink-secondary mb-2">Email hoặc SĐT</label>
                                    <input type="text" name="email" value="<?php echo e(old('email')); ?>" class="w-full bg-white border border-ui-border text-ink-primary rounded-none focus:ring-0 focus:border-ink-primary p-3.5 transition-colors" placeholder="lienhe@phuongdong.edu.vn">
                                    <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="mt-2 text-xs font-medium text-red-500"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                            </div>
                            
                            <div>
                                <label class="block text-xs font-bold uppercase tracking-wider text-ink-secondary mb-2">Nội dung cần hỗ trợ</label>
                                <textarea rows="4" name="noi_dung" class="w-full bg-white border border-ui-border text-ink-primary rounded-none focus:ring-0 focus:border-ink-primary p-3.5 transition-colors resize-none" placeholder="Bạn cần Ban quản lý hỗ trợ vấn đề gì?"><?php echo e(old('noi_dung')); ?></textarea>
                                <?php $__errorArgs = ['noi_dung'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="mt-2 text-xs font-medium text-red-500"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                            
                            <button type="submit" class="w-full bg-ink-primary text-white py-4 text-sm font-bold tracking-wide transition-colors hover:bg-brand-emerald">
                                Gửi yêu cầu ngay
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    

    <script>
    document.addEventListener('DOMContentLoaded', function () {
        // Navbar scroll
        const header = document.getElementById('site-header');
        if (header) {
            window.addEventListener('scroll', () => {
                header.classList.toggle('shadow-md', window.scrollY > 20);
                header.classList.toggle('backdrop-blur-xl', window.scrollY > 20);
            });
        }

        // Room Filtering & Pagination
        const filterGender = document.getElementById('filter-gender');
        const filterStatus = document.getElementById('filter-status');
        const roomCards = Array.from(document.querySelectorAll('.room-card'));
        const pagCtrl = document.getElementById('pagination-controls');
        let currentPage = 1, itemsPerPage = 6, filteredCards = [];

        function renderPagination() {
            if (!pagCtrl) return;
            pagCtrl.innerHTML = '';
            const total = Math.ceil(filteredCards.length / itemsPerPage);
            if (total <= 1) return;
            for (let i = 1; i <= total; i++) {
                const btn = document.createElement('button');
                btn.innerText = i;
                btn.className = `w-10 h-10 rounded-xl font-bold text-sm flex items-center justify-center transition-all duration-300 ${i === currentPage ? 'bg-brand-emerald text-white shadow-lg shadow-brand-emerald/30 scale-110' : 'bg-white border border-ui-border text-ink-secondary hover:border-brand-emerald/50 hover:text-brand-emerald'}`;
                btn.onclick = () => { 
                    currentPage = i; 
                    updateDisplay(); 
                    document.getElementById('phong-o').scrollIntoView({behavior:'smooth',block:'start'}); 
                };
                pagCtrl.appendChild(btn);
            }
        }

        function updateDisplay() {
            roomCards.forEach(c => c.style.display = 'none');
            const start = (currentPage - 1) * itemsPerPage;
            filteredCards.slice(start, start + itemsPerPage).forEach(c => {
                c.style.display = 'flex';
                c.style.animation = 'none';
                void c.offsetWidth;
                c.style.animation = 'sweep .5s cubic-bezier(0.16, 1, 0.3, 1) forwards';
            });
            renderPagination();
        }

        function filterRooms() {
            const g = filterGender.value, s = filterStatus.value;
            filteredCards = roomCards.filter(c => (g === 'all' || g === c.dataset.gender) && (s === 'all' || s === c.dataset.available));
            currentPage = 1;
            updateDisplay();
        }

        if (filterGender && filterStatus && roomCards.length > 0) {
            filterGender.addEventListener('change', filterRooms);
            filterStatus.addEventListener('change', filterRooms);
            filterRooms();
        }
    });
    </script>
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
<?php /**PATH D:\laragon\www\hethongquanlyktxv1\resources\views/landing/index.blade.php ENDPATH**/ ?>