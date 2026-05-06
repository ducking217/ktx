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
     <?php $__env->slot('title', null, []); ?> Phân tích Tài chính & Vận hành Hệ thống <?php $__env->endSlot(); ?>

    <div class="space-y-10 pb-20">
        <?php if (isset($component)) { $__componentOriginalcb19cb35a534439097b02b8af91726ee = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalcb19cb35a534439097b02b8af91726ee = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.page-header','data' => ['title' => 'Báo cáo tài chính','subtitle' => 'Phân tích định lượng luồng tiền, biến động doanh thu và hiệu suất tài sản lưu trú.']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('admin.page-header'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Báo cáo tài chính','subtitle' => 'Phân tích định lượng luồng tiền, biến động doanh thu và hiệu suất tài sản lưu trú.']); ?>
            <form action="<?php echo e(route('admin.baocao.xuat_excel')); ?>" method="GET" class="flex items-center gap-3">
                <div class="relative group">
                    <select name="nam" class="saas-input h-11 px-5 pr-10 text-[11px] font-black uppercase tracking-[0.2em] bg-white border-slate-200 focus:ring-slate-900/5 appearance-none cursor-pointer">
                        <?php for($i = date('Y'); $i >= date('Y') - 2; $i--): ?>
                            <option value="<?php echo e($i); ?>" <?php if((int) request()->query('nam', date('Y')) === (int) $i): echo 'selected'; endif; ?>>Năm <?php echo e($i); ?></option>
                        <?php endfor; ?>
                    </select>
                    <div class="absolute inset-y-0 right-3.5 flex items-center pointer-events-none text-slate-400">
                        <svg class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M19 9l-7 7-7-7"/></svg>
                    </div>
                </div>
                <button type="submit" class="saas-btn-primary h-11 px-8 shadow-lg shadow-emerald-500/20 group">
                    <svg class="h-4.5 w-4.5 mr-2.5 group-hover:translate-y-0.5 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    Xuất dữ liệu
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

        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <div class="saas-card p-8 bg-emerald-50/5 hover:shadow-2xl hover:shadow-emerald-500/10 transition-all duration-500 group">
                <div class="text-[10px] font-black text-slate-400 uppercase tracking-[0.25em] mb-4 flex items-center gap-2">
                    <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>
                    Doanh thu (tháng)
                </div>
                <div class="flex items-end justify-between">
                    <div class="text-3xl font-black text-slate-900 tabular-nums tracking-tighter"><?php echo e(number_format($doanhThuThangNay)); ?><span class="text-xs font-black text-slate-300 ml-1.5 uppercase tracking-tighter">vnđ</span></div>
                    <div class="<?php echo \Illuminate\Support\Arr::toCssClasses([
                        'text-[10px] font-black px-2.5 py-1.5 rounded-xl shadow-sm border',
                        'bg-emerald-50 text-emerald-600 border-emerald-100' => $tangTruong >= 0,
                        'bg-rose-50 text-rose-600 border-rose-100' => $tangTruong < 0,
                    ]); ?>">
                        <?php echo e($tangTruong >= 0 ? '↑' : '↓'); ?> <?php echo e(abs($tangTruong)); ?>%
                    </div>
                </div>
                <div class="mt-4 h-1 w-8 bg-emerald-100 group-hover:w-16 transition-all duration-500"></div>
            </div>

            <div class="saas-card p-8 bg-emerald-50/5 hover:shadow-2xl hover:shadow-emerald-500/10 transition-all duration-500 group">
                <div class="text-[10px] font-black text-slate-400 uppercase tracking-[0.25em] mb-4 flex items-center gap-2">
                    <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>
                    Tổng tiền cọc
                </div>
                <div class="text-3xl font-black text-slate-900 tabular-nums tracking-tighter"><?php echo e(number_format($tongCocHienTai)); ?><span class="text-xs font-black text-slate-300 ml-1.5 uppercase tracking-tighter">vnđ</span></div>
                <div class="text-[9px] font-black text-emerald-700 uppercase tracking-[0.2em] mt-3 bg-emerald-50/60 w-fit px-2 py-0.5 rounded-lg border border-emerald-100/60">
                    Ký quỹ an sinh cư dân
                </div>
            </div>

            <div class="saas-card p-8 bg-amber-50/5 hover:shadow-2xl hover:shadow-amber-500/10 transition-all duration-500 group">
                <div class="text-[10px] font-black text-slate-400 uppercase tracking-[0.25em] mb-4 flex items-center gap-2">
                    <span class="h-1.5 w-1.5 rounded-full bg-amber-500"></span>
                    Tỷ lệ lấp đầy
                </div>
                <div class="text-3xl font-black text-slate-900 tabular-nums tracking-tighter"><?php echo e($tyLeLapDay); ?><span class="text-xs font-black text-slate-300 ml-1.5 uppercase tracking-tighter">%</span></div>
                <div class="text-[10px] font-black text-amber-600 uppercase tracking-widest mt-3 flex items-center gap-1.5">
                    <svg class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                    <?php echo e($phongDangThue); ?>/<?php echo e($tongPhong); ?> phòng đang vận hành
                </div>
            </div>

            <div class="saas-card p-8 bg-slate-900/5 hover:shadow-2xl hover:shadow-slate-900/10 transition-all duration-500 group">
                <div class="text-[10px] font-black text-slate-400 uppercase tracking-[0.25em] mb-4 flex items-center gap-2">
                    <span class="h-1.5 w-1.5 rounded-full bg-slate-900"></span>
                    Tổng doanh thu năm
                </div>
                <div class="text-3xl font-black text-slate-900 tabular-nums tracking-tighter"><?php echo e(number_format($doanhThuTheoThang->sum('tong'))); ?><span class="text-xs font-black text-slate-300 ml-1.5 uppercase tracking-tighter">vnđ</span></div>
                <div class="text-[9px] font-black text-slate-500 uppercase tracking-[0.2em] mt-3">
                    Đối soát theo <?php echo e($doanhThuTheoThang->sum('so_luong')); ?> giao dịch
                </div>
            </div>
        </div>

        
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            <div class="lg:col-span-8 saas-card p-10 border-slate-200/60 shadow-xl shadow-slate-200/5">
                <div class="flex items-center justify-between mb-12">
                    <div>
                        <h3 class="text-[11px] font-black text-slate-900 uppercase tracking-[0.25em]">Phân tích doanh thu</h3>
                        <p class="text-[10px] text-slate-400 font-bold mt-2 uppercase tracking-tight">Biểu đồ đối soát biến động dòng tiền 12 chu kỳ gần nhất</p>
                    </div>
                    <div class="flex items-center gap-5">
                        <div class="flex items-center gap-2">
                            <span class="h-2 w-2 rounded-full bg-brand-emerald shadow-[0_0_8px_rgba(16,185,129,0.35)]"></span>
                            <span class="text-[9px] font-black text-slate-500 uppercase tracking-widest">Doanh thu (VNĐ)</span>
                        </div>
                    </div>
                </div>
                <div class="h-[380px]">
                    <canvas id="revenueChart" data-revenue='<?php echo json_encode($doanhThuTheoThang, 15, 512) ?>'></canvas>
                </div>
            </div>

            <div class="lg:col-span-4 saas-card p-10 border-slate-200/60 shadow-xl shadow-slate-200/5">
                <h3 class="text-[11px] font-black text-slate-900 uppercase tracking-[0.25em] mb-10 flex items-center gap-2">
                    <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>
                    Phòng doanh thu cao
                </h3>
                <div class="space-y-8">
                    <?php $__currentLoopData = $topPhong; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $phong): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="flex items-center justify-between group cursor-pointer transition-transform hover:translate-x-1">
                            <div class="flex items-center gap-5">
                                <div class="h-11 w-11 rounded-2xl bg-slate-50 border border-slate-200/60 flex items-center justify-center text-[11px] font-black text-slate-400 group-hover:bg-slate-900 group-hover:text-white group-hover:border-slate-900 group-hover:rotate-6 transition-all shadow-sm">
                                    <?php echo e(str_pad($loop->iteration, 2, '0', STR_PAD_LEFT)); ?>

                                </div>
                                <div>
                                    <div class="text-[13px] font-black text-slate-900 uppercase tracking-tight group-hover:text-brand-emerald transition-colors leading-none"><?php echo e($phong->phong?->ten_phong ?? 'Không có'); ?></div>
                                    <div class="text-[9px] font-bold text-slate-400 uppercase tracking-widest mt-2 flex items-center gap-1.5">
                                        <span class="h-1 w-1 rounded-full bg-slate-300"></span>
                                        Tầng <?php echo e($phong->phong?->tang ?? '0'); ?>

                                    </div>
                                </div>
                            </div>
                            <div class="text-right">
                                <div class="text-[15px] font-black text-slate-900 tabular-nums tracking-tighter leading-none"><?php echo e(number_format((float)$phong->tong)); ?></div>
                                <div class="text-[9px] font-black text-emerald-500 uppercase tracking-[0.15em] mt-2">Doanh thu</div>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
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
                    <th>Tháng báo cáo</th>
                    <th class="text-center">Số giao dịch</th>
                    <th class="text-right">Tổng doanh thu</th>
                    <th class="text-right">Trung bình/giao dịch</th>
                    <th class="text-right">Tình trạng</th>
                </tr>
            </thead>
            <tbody>
                <?php $__currentLoopData = $doanhThuTheoThang; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr class="hover:bg-slate-50/50 transition-colors group">
                        <td class="py-6">
                            <div class="text-[13px] font-black text-slate-900 uppercase tracking-tight group-hover:text-brand-emerald transition-colors">Tháng <?php echo e(str_pad($row->thang, 2, '0', STR_PAD_LEFT)); ?> / <?php echo e($row->nam); ?></div>
                            <div class="text-[9px] text-slate-400 font-black uppercase tracking-[0.2em] mt-1.5 flex items-center gap-1.5">
                                <span class="h-1 w-1 rounded-full bg-slate-300"></span>
                                Báo cáo nội bộ
                            </div>
                        </td>
                        <td class="py-6 text-center">
                            <div class="text-[11px] font-black text-slate-600 tabular-nums bg-white px-3 py-1.5 rounded-xl inline-block border border-slate-200/60 shadow-sm min-w-[45px]"><?php echo e($row->so_luong); ?></div>
                        </td>
                        <td class="py-6 text-right">
                            <div class="text-[15px] font-black text-slate-900 tabular-nums tracking-tighter leading-none"><?php echo e(number_format((float)$row->tong)); ?><small class="ml-0.5 text-slate-400">VNĐ</small></div>
                        </td>
                        <td class="py-6 text-right">
                            <div class="text-[11px] font-black text-slate-400 tabular-nums tracking-tighter"><?php echo e(number_format($row->tong / $row->so_luong)); ?><small class="ml-0.5 opacity-50">VNĐ</small></div>
                        </td>
                        <td class="py-6 text-right">
                            <div class="flex items-center justify-end">
                                <div class="h-9 w-9 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center border border-emerald-100 shadow-sm group-hover:scale-110 transition-transform">
                                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/></svg>
                                </div>
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
        document.addEventListener('DOMContentLoaded', function() {
            const canvas = document.getElementById('revenueChart');
            if (!canvas) return;
            const ctx = canvas.getContext('2d');
            const data = JSON.parse(canvas.dataset.revenue || '[]');
            
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: data.map(d => `T${d.thang}/${d.nam}`),
                    datasets: [{
                        label: 'Phân tích doanh thu',
                        data: data.map(d => d.tong),
                        backgroundColor: 'rgba(16, 185, 129, 0.90)',
                        hoverBackgroundColor: '#0f172a',
                        borderWidth: 0,
                        borderRadius: 12,
                        barThickness: 36,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    layout: {
                        padding: { top: 20 }
                    },
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            backgroundColor: '#0f172a',
                            titleFont: { size: 10, weight: '900', family: 'Geist Sans', letterSpacing: 1 },
                            bodyFont: { size: 13, weight: '900', family: 'Geist Sans' },
                            padding: 20,
                            cornerRadius: 16,
                            displayColors: false,
                            borderWidth: 1,
                            borderColor: 'rgba(255,255,255,0.1)',
                            callbacks: {
                                label: function(context) {
                                    return new Intl.NumberFormat('vi-VN', { 
                                        style: 'currency', 
                                        currency: 'VND',
                                        maximumFractionDigits: 0
                                    }).format(context.raw);
                                }
                            }
                        }
                    },
                    scales: {
                        x: {
                            grid: { display: false },
                            border: { display: false },
                            ticks: {
                                font: { size: 9, weight: '900', family: 'Inter' },
                                color: '#94a3b8',
                                padding: 10
                            }
                        },
                        y: {
                            grid: { 
                                color: 'rgba(226, 232, 240, 0.5)', 
                                drawTicks: false,
                                lineWidth: 1
                            },
                            border: { 
                                display: false, 
                                dash: [8, 8] 
                            },
                            ticks: {
                                font: { size: 9, weight: '900', family: 'Inter' },
                                color: '#94a3b8',
                                padding: 15,
                                callback: function(value) {
                                    if (value >= 1000000) return (value / 1000000) + 'M';
                                    return value;
                                }
                            }
                        }
                    }
                }
            });
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