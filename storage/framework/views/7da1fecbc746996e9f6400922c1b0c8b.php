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
     <?php $__env->slot('title', null, []); ?> Báo cáo tài chính <?php $__env->endSlot(); ?>

    <div class="space-y-8 animate-fade-up">
        <?php if (isset($component)) { $__componentOriginalcb19cb35a534439097b02b8af91726ee = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalcb19cb35a534439097b02b8af91726ee = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.page-header','data' => ['title' => 'Tổng quan tài chính','subtitle' => 'Dữ liệu cập nhật theo thời gian thực']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('admin.page-header'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Tổng quan tài chính','subtitle' => 'Dữ liệu cập nhật theo thời gian thực']); ?>
            <form action="<?php echo e(route('admin.baocao.xuat_excel')); ?>" method="GET" class="flex items-center gap-2">
                <label class="sr-only" for="export-year">Năm xuất báo cáo</label>
                <select id="export-year" name="nam" class="bg-ui-card border-ui-border rounded-xl text-[10px] font-black uppercase tracking-widest px-4 py-2 focus:ring-2 focus:ring-brand-emerald/20 transition-all">
                    <?php for($i = date('Y'); $i >= date('Y') - 2; $i--): ?>
                        <option value="<?php echo e($i); ?>"><?php echo e($i); ?></option>
                    <?php endfor; ?>
                </select>
                <button type="submit" class="pdu-btn-primary shadow-lg shadow-brand-emerald/20 !px-6 h-10" aria-label="Xuất Excel báo cáo tài chính">
                    <svg class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    Xuất Excel
                </button>
            </form>
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

        
        <section class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <article class="pdu-card group relative overflow-hidden">
                <div class="absolute -right-6 -top-6 h-20 w-20 rounded-full bg-brand-emerald/5 transition-transform duration-700 group-hover:scale-150"></div>
                <div class="relative z-10">
                    <span class="text-[9px] font-black uppercase tracking-widest text-ink-secondary/40">Doanh thu tháng này</span>
                    <div class="mt-2 flex items-baseline gap-2">
                        <h3 class="text-2xl font-black text-ink-primary tracking-tight"><?php echo e(number_format($doanhThuThangNay)); ?>đ</h3>
                        <span class="<?php echo \Illuminate\Support\Arr::toCssClasses([
                            'text-[10px] font-bold px-1.5 py-0.5 rounded-md',
                            'bg-status-success/10 text-status-success' => $tangTruong >= 0,
                            'bg-status-error/10 text-status-error' => $tangTruong < 0,
                        ]); ?>">
                            <?php echo e($tangTruong >= 0 ? '+' : ''); ?><?php echo e($tangTruong); ?>%
                        </span>
                    </div>
                </div>
            </article>

            <article class="pdu-card group relative overflow-hidden">
                <div class="absolute -right-6 -top-6 h-20 w-20 rounded-full bg-brand-jade/5 transition-transform duration-700 group-hover:scale-150"></div>
                <div class="relative z-10">
                    <span class="text-[9px] font-black uppercase tracking-widest text-ink-secondary/40">Tổng tiền cọc</span>
                    <div class="mt-2">
                        <h3 class="text-2xl font-black text-ink-primary tracking-tight"><?php echo e(number_format($tongCocHienTai)); ?>đ</h3>
                        <p class="text-[9px] font-bold text-ink-secondary/30 uppercase mt-1 tracking-widest">Ký quỹ sinh viên</p>
                    </div>
                </div>
            </article>

            <article class="pdu-card group relative overflow-hidden">
                <div class="absolute -right-6 -top-6 h-20 w-20 rounded-full bg-status-info/5 transition-transform duration-700 group-hover:scale-150"></div>
                <div class="relative z-10">
                    <span class="text-[9px] font-black uppercase tracking-widest text-ink-secondary/40">Tỷ lệ lấp đầy</span>
                    <div class="mt-2">
                        <h3 class="text-2xl font-black text-ink-primary tracking-tight"><?php echo e($tyLeLapDay); ?>%</h3>
                        <p class="text-[9px] font-bold text-ink-secondary/30 uppercase mt-1 tracking-widest"><?php echo e($phongDangThue); ?>/<?php echo e($tongPhong); ?> phòng đang ở</p>
                    </div>
                </div>
            </article>

            <article class="pdu-card group relative overflow-hidden">
                <div class="absolute -right-6 -top-6 h-20 w-20 rounded-full bg-ink-primary/5 transition-transform duration-700 group-hover:scale-150"></div>
                <div class="relative z-10">
                    <span class="text-[9px] font-black uppercase tracking-widest text-ink-secondary/40">Tổng doanh thu 12T</span>
                    <div class="mt-2">
                        <h3 class="text-2xl font-black text-ink-primary tracking-tight"><?php echo e(number_format($doanhThuTheoThang->sum('tong'))); ?>đ</h3>
                        <p class="text-[9px] font-bold text-ink-secondary/30 uppercase mt-1 tracking-widest"><?php echo e($doanhThuTheoThang->sum('so_luong')); ?> giao dịch</p>
                    </div>
                </div>
            </article>
        </section>

        
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            <article class="lg:col-span-8 pdu-card">
                <div class="mb-8 flex items-center justify-between">
                    <h3 class="text-[11px] font-black text-ink-primary uppercase tracking-widest">Biểu đồ doanh thu 12 tháng</h3>
                    <div class="flex items-center gap-2">
                        <span class="flex items-center gap-1.5 text-[9px] font-bold text-ink-secondary/40 uppercase">
                            <span class="h-2 w-2 rounded-full bg-brand-emerald"></span> Doanh thu
                        </span>
                    </div>
                </div>
                <div class="h-[350px] w-full">
                    <canvas id="revenueChart" data-revenue='<?php echo json_encode($doanhThuTheoThang, 15, 512) ?>'></canvas>
                </div>
            </article>

            <article class="lg:col-span-4 pdu-card">
                <h3 class="text-[11px] font-black text-ink-primary uppercase tracking-widest mb-6">Top 5 phòng cao điểm</h3>
                <div class="space-y-6">
                    <?php $__currentLoopData = $topPhong; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $phong): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="flex items-center justify-between group">
                            <div class="flex items-center gap-4">
                                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-ui-bg border border-ui-border group-hover:border-brand-emerald/30 transition-colors">
                                    <span class="text-xs font-black text-ink-primary"><?php echo e($loop->iteration); ?></span>
                                </div>
                                <div>
                                    <div class="text-sm font-bold text-ink-primary uppercase tracking-tight"><?php echo e($phong->phong?->ten_phong ?? 'N/A'); ?></div>
                                    <div class="text-[9px] font-bold text-ink-secondary/40 uppercase tracking-widest">Tầng <?php echo e($phong->phong?->tang ?? 'N/A'); ?></div>
                                </div>
                            </div>
                            <div class="text-right">
                                <div class="text-sm font-black text-ink-primary tabular-nums tracking-tight"><?php echo e(number_format((float)$phong->tong)); ?>đ</div>
                                <div class="text-[8px] font-bold text-brand-emerald uppercase tracking-widest">Doanh thu</div>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </article>
        </div>

        
        <?php if (isset($component)) { $__componentOriginaldf54224cf245156c316d9d3b07da8b50 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginaldf54224cf245156c316d9d3b07da8b50 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.table-card','data' => ['caption' => 'Chi tiết doanh thu theo kỳ','class' => 'shadow-xl shadow-ink-primary/5']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('admin.table-card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['caption' => 'Chi tiết doanh thu theo kỳ','class' => 'shadow-xl shadow-ink-primary/5']); ?>
             <?php $__env->slot('header', null, []); ?> 
                <h2 class="text-[11px] font-black text-ink-primary uppercase tracking-widest">Chi tiết doanh thu theo kỳ</h2>
             <?php $__env->endSlot(); ?>
                <thead class="adm-tableCard__head">
                    <tr>
                        <th scope="col" class="px-8 py-4">Kỳ báo cáo</th>
                        <th scope="col" class="px-8 py-4">Số hóa đơn</th>
                        <th scope="col" class="px-8 py-4">Tổng doanh thu</th>
                        <th scope="col" class="px-8 py-4">Trung bình/HĐ</th>
                        <th scope="col" class="px-8 py-4 text-right">Xu hướng</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-ui-border">
                    <?php $__currentLoopData = $doanhThuTheoThang; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr class="group hover:bg-ui-bg/30 transition-colors">
                            <td class="px-8 py-5">
                                <span class="font-display font-black text-ink-primary uppercase tracking-tight text-base">T<?php echo e($row->thang); ?>/<?php echo e($row->nam); ?></span>
                            </td>
                            <td class="px-8 py-5 font-bold text-ink-secondary tabular-nums tracking-tight"><?php echo e($row->so_luong); ?></td>
                            <td class="px-8 py-5 font-black text-ink-primary tabular-nums tracking-tight"><?php echo e(number_format((float)$row->tong)); ?>đ</td>
                            <td class="px-8 py-5 font-medium text-ink-secondary/60 tabular-nums tracking-tight"><?php echo e(number_format($row->tong / $row->so_luong)); ?>đ</td>
                            <td class="px-8 py-5 text-right">
                                <div class="flex items-center justify-end gap-1.5 text-status-success" aria-hidden="true">
                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/></svg>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
    </div>

    <?php $__env->startPush('scripts'); ?>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const canvas = document.getElementById('revenueChart');
        const ctx = canvas.getContext('2d');
        const data = JSON.parse(canvas.dataset.revenue || '[]');
        
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: data.map(d => `T${d.thang}/${d.nam}`),
                datasets: [{
                    label: 'Doanh thu',
                    data: data.map(d => d.tong),
                    backgroundColor: 'rgba(16, 185, 129, 0.8)',
                    borderColor: 'rgb(16, 185, 129)',
                    borderWidth: 0,
                    borderRadius: 8,
                    barThickness: 32,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: '#111827',
                        titleFont: { family: 'Geist Sans', size: 10, weight: '900' },
                        bodyFont: { family: 'Geist Sans', size: 12, weight: 'bold' },
                        padding: 12,
                        cornerRadius: 12,
                        displayColors: false,
                        callbacks: {
                            label: function(context) {
                                return new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(context.raw);
                            }
                        }
                    }
                },
                scales: {
                    x: {
                        grid: { display: false },
                        border: { display: false },
                        ticks: {
                            font: { family: 'Geist Sans', size: 9, weight: 'bold' },
                            color: '#9ca3af'
                        }
                    },
                    y: {
                        grid: { color: 'rgba(229, 231, 235, 0.5)', drawTicks: false },
                        border: { display: false, dash: [4, 4] },
                        ticks: {
                            font: { family: 'Geist Sans', size: 9, weight: 'bold' },
                            color: '#9ca3af',
                            callback: function(value) {
                                if (value >= 1000000) return (value / 1000000) + 'tr';
                                return value;
                            }
                        }
                    }
                }
            }
        });
    </script>
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
<?php /**PATH D:\laragon\www\hethongquanlyktxv1\resources\views/admin/baocao/taichinh.blade.php ENDPATH**/ ?>