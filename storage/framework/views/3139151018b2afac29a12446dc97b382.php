<?php $__env->startSection('student_page_title', 'Yêu cầu gia hạn'); ?>

<?php $__env->startSection('noidung'); ?>
    <div class="max-w-4xl mx-auto space-y-8">
        
        <header class="flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-black text-slate-900 tracking-tight uppercase">Gia hạn lưu trú</h2>
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-1">Đăng ký tiếp tục cư trú tại Ký túc xá PDU</p>
            </div>
            <a href="<?php echo e(route('student.giahan.index')); ?>" class="saas-btn-secondary h-10 px-4 text-[10px] font-bold uppercase tracking-widest gap-2">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                Quay lại
            </a>
        </header>

        <div class="grid grid-cols-1 md:grid-cols-12 gap-8 items-start">
            
            <aside class="md:col-span-4 space-y-6">
                <article class="saas-card p-6 bg-slate-50/50 border-dashed">
                    <h3 class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-6">Thông tin hiện tại</h3>
                    
                    <div class="space-y-5">
                        <div>
                            <label class="text-[9px] font-bold uppercase text-slate-400 block tracking-widest mb-1">Mã hợp đồng</label>
                            <span class="text-sm font-bold text-slate-900 tracking-tight tabular-nums"><?php echo e($hopdong->ma_hd); ?></span>
                        </div>
                        <div>
                            <label class="text-[9px] font-bold uppercase text-slate-400 block tracking-widest mb-1">Vị trí phòng</label>
                            <span class="text-sm font-bold text-slate-900 tracking-tight"><?php echo e($hopdong->phong->tenphong); ?></span>
                        </div>
                        <div>
                            <label class="text-[9px] font-bold uppercase text-slate-400 block tracking-widest mb-1">Ngày kết thúc cũ</label>
                            <span class="text-sm font-bold text-slate-900 tabular-nums tracking-tight"><?php echo e($hopdong->ngay_ket_thuc?->format('d/m/Y') ?? 'Chưa xác định'); ?></span>
                        </div>
                    </div>
                </article>

                <div class="saas-card p-6 bg-blue-50 border-blue-100 flex gap-4">
                    <svg class="h-5 w-5 shrink-0 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <p class="text-[11px] font-medium leading-relaxed text-blue-700">
                        Yêu cầu sẽ được Ban quản lý xem xét trong 24-48h. Kết quả phê duyệt sẽ được gửi qua email sinh viên.
                    </p>
                </div>
            </aside>

            
            <main class="md:col-span-8">
                <article class="saas-card p-8">
                    <form action="<?php echo e(route('student.giahan.store')); ?>" method="POST" class="space-y-8">
                        <?php echo csrf_field(); ?>
                        <input type="hidden" name="hopdong_id" value="<?php echo e($hopdong->id); ?>">

                        <div class="space-y-3">
                            <label for="ngay_ket_thuc_moi" class="text-[10px] font-bold text-slate-900 uppercase tracking-widest">Thời hạn gia hạn mong muốn <span class="text-rose-500">*</span></label>
                            <div class="relative group">
                                <input type="date" 
                                       name="ngay_ket_thuc_moi" 
                                       id="ngay_ket_thuc_moi"
                                       value="<?php echo e(old('ngay_ket_thuc_moi', $hopdong->ngay_ket_thuc->addMonths(5)->format('Y-m-d'))); ?>"
                                       class="saas-input h-12 pr-12 font-bold tabular-nums"
                                       required>
                                <div class="absolute inset-y-0 right-4 flex items-center pointer-events-none text-slate-300 group-focus-within:text-blue-500 transition-colors">
                                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                </div>
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="h-1 w-1 rounded-full bg-slate-200"></span>
                                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Gợi ý: Mặc định gia hạn thêm 01 học kỳ (5 tháng)</p>
                            </div>
                        </div>

                        <div class="space-y-3">
                            <label for="ly_do" class="text-[10px] font-bold text-slate-900 uppercase tracking-widest">Lý do gia hạn</label>
                            <textarea name="ly_do" 
                                      id="ly_do" 
                                      rows="5" 
                                      placeholder="Ví dụ: Tiếp tục học tập tại trường kỳ tiếp theo..."
                                      class="saas-input p-4 text-sm font-medium resize-none"><?php echo e(old('ly_do')); ?></textarea>
                        </div>

                        <div class="pt-8 flex items-center justify-end gap-4 border-t border-slate-50">
                            <button type="reset" class="saas-btn-secondary h-11 px-6 text-[10px] font-bold uppercase tracking-widest">Hủy bỏ</button>
                            <button type="submit" class="saas-btn-primary h-11 px-8 text-[10px] uppercase font-bold tracking-widest gap-2">
                                Gửi yêu cầu phê duyệt
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
                            </button>
                        </div>
                    </form>
                </article>
            </main>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('student.layouts.chinh', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\laragon\www\hethongquanlyktxv1\resources\views/student/giahan/tao.blade.php ENDPATH**/ ?>