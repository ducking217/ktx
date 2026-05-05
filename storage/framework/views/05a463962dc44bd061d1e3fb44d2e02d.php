<?php $__env->startSection('student_page_title', 'Chi tiết thông báo'); ?>

<?php $__env->startSection('noidung'); ?>
    <div class="space-y-6">
        
        <div class="flex items-center justify-between">
            <a href="<?php echo e(route('student.thongbao')); ?>" class="inline-flex items-center gap-2 text-[10px] font-bold uppercase tracking-widest text-slate-400 hover:text-slate-900 transition-colors group">
                <svg class="h-3.5 w-3.5 transition-transform group-hover:-translate-x-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
                </svg>
                Quay lại danh sách
            </a>
            
            <button onclick="window.print()" class="saas-btn-secondary h-8 px-3 text-[10px] font-bold uppercase tracking-widest gap-2">
                <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" /></svg>
                In bản tin
            </button>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
            
            <main class="lg:col-span-8 space-y-8">
                <article class="saas-card p-10 bg-white">
                    <header class="mb-10 pb-10 border-b border-slate-100">
                        <div class="flex items-center gap-3 mb-6">
                            <span class="saas-badge saas-badge-success !py-0 !px-2 text-[10px]">Thông báo chính thức</span>
                            <span class="h-1 w-1 rounded-full bg-slate-200"></span>
                            <time class="text-[10px] font-bold text-slate-400 uppercase tracking-widest tabular-nums">Đăng ngày <?php echo e($thongbao->created_at?->format('d/m/Y')); ?></time>
                        </div>
                        <h1 class="text-3xl font-black text-slate-900 tracking-tight leading-tight"><?php echo e($thongbao->tieu_de); ?></h1>
                    </header>

                    <div class="prose prose-slate max-w-none 
                        prose-p:text-sm prose-p:leading-relaxed prose-p:text-slate-600 prose-p:font-medium
                        prose-headings:text-slate-900 prose-headings:font-bold prose-headings:tracking-tight
                        prose-strong:text-slate-900 prose-strong:font-bold
                        prose-ul:list-disc prose-li:text-sm prose-li:text-slate-600
                        prose-img:rounded-2xl prose-img:border prose-img:border-slate-100">
                        <?php echo nl2br(e($thongbao->noi_dung)); ?>

                    </div>
                    
                    <footer class="mt-16 pt-10 border-t border-slate-100 flex items-center justify-between">
                        <div class="flex items-center gap-4">
                            <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-slate-900 text-white border border-slate-900">
                                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                            </div>
                            <div>
                                <div class="text-[11px] font-bold uppercase tracking-widest text-slate-900">Ban quản lý KTX PDU</div>
                                <div class="text-[9px] font-bold uppercase tracking-widest text-slate-400">Nội dung đã được xác thực</div>
                            </div>
                        </div>
                    </footer>
                </article>
            </main>

            
            <aside class="lg:col-span-4 space-y-8">
                
                <article class="saas-card overflow-hidden">
                    <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/30">
                        <h3 class="text-[10px] font-bold uppercase tracking-widest text-slate-400">Bản tin liên quan</h3>
                    </div>
                    <div class="divide-y divide-slate-50">
                        <?php $__empty_1 = true; $__currentLoopData = $thongbaoLienQuan; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tb): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <a href="<?php echo e(route('student.chitietthongbao', $tb->id)); ?>" class="group block p-5 transition-colors hover:bg-slate-50/50">
                                <time class="text-[9px] font-bold text-blue-600 uppercase tracking-widest mb-1.5 block tabular-nums"><?php echo e($tb->created_at?->format('d/m/Y')); ?></time>
                                <h4 class="text-xs font-bold text-slate-900 leading-snug tracking-tight group-hover:text-blue-600 transition-colors line-clamp-2"><?php echo e($tb->tieu_de); ?></h4>
                            </a>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <div class="py-12 text-center">
                                <p class="text-[10px] font-bold text-slate-300 uppercase tracking-widest">Không có tin liên quan</p>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="p-4 bg-slate-50/50 border-t border-slate-100">
                        <a href="<?php echo e(route('student.thongbao')); ?>" class="saas-btn-secondary w-full h-10 text-[10px] uppercase font-bold tracking-widest">Xem tất cả bản tin</a>
                    </div>
                </article>
                
                
                <article class="saas-card bg-slate-900 border-slate-800 p-8 text-white relative overflow-hidden group">
                    <div class="absolute -right-8 -top-8 h-32 w-32 rounded-full bg-slate-800/30 blur-3xl group-hover:bg-blue-500/10 transition-all duration-700"></div>
                    <div class="relative z-10">
                        <div class="flex items-center gap-3 mb-6 border-b border-slate-800 pb-5">
                            <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-slate-800 text-slate-400 ring-1 ring-slate-700">
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            </div>
                            <h2 class="text-[10px] font-bold uppercase tracking-widest text-slate-500">Hỗ trợ thông tin</h2>
                        </div>
                        <p class="text-[11px] font-medium leading-relaxed text-slate-400 mb-8">Nếu bạn có thắc mắc về nội dung bản tin này, vui lòng liên hệ văn phòng BQL tại tầng 1 tòa A1 để được giải đáp.</p>
                        <div class="flex flex-col gap-1 group/line">
                            <span class="text-[9px] font-bold uppercase tracking-widest text-slate-600 group-hover/line:text-slate-400 transition-colors">Văn phòng BQL</span>
                            <a href="tel:0241234567" class="text-sm font-bold tabular-nums tracking-tight hover:text-blue-400 transition-colors text-slate-300">024.123.4567</a>
                        </div>
                    </div>
                </article>
            </aside>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('student.layouts.chinh', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\laragon\www\hethongquanlyktxv1\resources\views/student/thongbao/chitiet.blade.php ENDPATH**/ ?>