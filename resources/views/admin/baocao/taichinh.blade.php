<x-admin-layout>
    <x-slot:title>Báo cáo tài chính</x-slot:title>

    <div class="space-y-10 pb-20">
        <x-admin.page-header
            title="Báo cáo tài chính"
            subtitle="Phân tích định lượng luồng tiền, biến động doanh thu và hiệu suất tài sản lưu trú."
        >
            <form action="{{ route('admin.baocao.taichinh') }}" method="GET" class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-end">
                <div class="relative group w-full sm:w-auto">
                    <select name="nam" onchange="this.form.submit()" class="saas-input h-11 px-5 pr-10 text-sm font-semibold bg-white border-slate-200 focus:ring-slate-900/5 appearance-none cursor-pointer w-full sm:w-auto">
                        @for($i = date('Y'); $i >= date('Y') - 2; $i--)
                            <option value="{{ $i }}" @selected((int) request()->query('nam', date('Y')) === (int) $i)>Năm {{ $i }}</option>
                        @endfor
                    </select>
                    <div class="absolute inset-y-0 right-3.5 flex items-center pointer-events-none text-slate-400">
                        <svg class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M19 9l-7 7-7-7"/></svg>
                    </div>
                </div>
                <button type="submit" formaction="{{ route('admin.baocao.xuat_excel') }}" class="saas-btn-primary h-11 px-6 sm:px-8 shadow-lg shadow-emerald-500/20 group whitespace-nowrap w-full sm:w-auto justify-center" aria-label="Xuất Excel">
                    <svg class="h-4.5 w-4.5 mr-2.5 group-hover:translate-y-0.5 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    <span class="sm:hidden">Xuất Excel</span>
                    <span class="hidden sm:inline">Xuất Excel</span>
                </button>
            </form>
        </x-admin.page-header>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <div class="saas-card p-6">
                <div class="flex items-start justify-between gap-4">
                    <div>
                        <div class="text-xs font-semibold text-slate-600">Doanh thu tháng</div>
                        <div class="mt-2 text-2xl font-black text-slate-900 tabular-nums tracking-tight">
                            {{ number_format($doanhThuThangNay) }}
                            <span class="ml-1 text-xs font-bold text-slate-400">VNĐ</span>
                        </div>
                    </div>
                    <div @class([
                        'mt-0.5 inline-flex items-center gap-1 rounded-full px-2.5 py-1 text-[11px] font-bold tabular-nums ring-1 ring-inset',
                        'bg-emerald-50 text-emerald-700 ring-emerald-200/60' => $tangTruong >= 0,
                        'bg-rose-50 text-rose-700 ring-rose-200/60' => $tangTruong < 0,
                    ])>
                        <span aria-hidden="true">{{ $tangTruong >= 0 ? '↑' : '↓' }}</span>
                        {{ abs($tangTruong) }}%
                    </div>
                </div>
            </div>

            <div class="saas-card p-6">
                <div class="text-xs font-semibold text-slate-600">Tổng tiền cọc</div>
                <div class="mt-2 text-2xl font-black text-slate-900 tabular-nums tracking-tight">
                    {{ number_format($tongCocHienTai) }}
                    <span class="ml-1 text-xs font-bold text-slate-400">VNĐ</span>
                </div>
                <div class="mt-3 text-xs text-slate-500">Ký quỹ đang quản lý</div>
            </div>

            <div class="saas-card p-6">
                <div class="text-xs font-semibold text-slate-600">Tỷ lệ lấp đầy</div>
                <div class="mt-2 text-2xl font-black text-slate-900 tabular-nums tracking-tight">
                    {{ $tyLeLapDay }}<span class="ml-1 text-xs font-bold text-slate-400">%</span>
                </div>
                <div class="mt-3 text-xs text-slate-500">{{ $phongDangThue }}/{{ $tongPhong }} phòng đang vận hành</div>
            </div>

            <div class="saas-card p-6">
                <div class="text-xs font-semibold text-slate-600">Tổng doanh thu năm</div>
                <div class="mt-2 text-2xl font-black text-slate-900 tabular-nums tracking-tight">
                    {{ number_format($doanhThuTheoThang->sum('tong')) }}
                    <span class="ml-1 text-xs font-bold text-slate-400">VNĐ</span>
                </div>
                <div class="mt-3 text-xs text-slate-500">Theo {{ $doanhThuTheoThang->sum('so_luong') }} giao dịch</div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            <div class="lg:col-span-8 saas-card p-6 sm:p-8">
                <div class="flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between mb-6">
                    <div>
                        <h3 class="text-sm font-black text-slate-900 tracking-tight">Doanh thu theo tháng</h3>
                        <p class="mt-1 text-xs text-slate-500">Theo dõi biến động doanh thu 12 tháng gần nhất.</p>
                    </div>
                    <div class="flex items-center gap-2 text-xs font-semibold text-slate-500">
                        <span class="h-2 w-2 rounded-full bg-brand-emerald"></span>
                        Doanh thu (VNĐ)
                    </div>
                </div>
                <div class="h-[260px] sm:h-[320px] lg:h-[340px]">
                    <canvas id="revenueChart" data-revenue='@json($doanhThuTheoThang)'></canvas>
                </div>
            </div>

            <div class="lg:col-span-4 saas-card p-6 sm:p-8">
                <h3 class="text-sm font-black text-slate-900 tracking-tight">Phòng doanh thu cao</h3>
                <p class="mt-1 text-xs text-slate-500">Top phòng theo tổng doanh thu.</p>
                <div class="mt-6 space-y-4">
                    @foreach($topPhong as $phong)
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-5">
                                <div class="h-10 w-10 rounded-xl bg-slate-50 border border-slate-200/60 flex items-center justify-center text-xs font-bold text-slate-500 tabular-nums">
                                    {{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}
                                </div>
                                <div>
                                    <div class="text-sm font-bold text-slate-900 leading-none">{{ $phong->phong?->ten_phong ?? 'Không có' }}</div>
                                    <div class="mt-1 text-xs text-slate-500">Tầng {{ $phong->phong?->tang ?? '0' }}</div>
                                </div>
                            </div>
                            <div class="text-right">
                                <div class="text-sm font-black text-slate-900 tabular-nums tracking-tight leading-none">{{ number_format((float)$phong->tong) }}</div>
                                <div class="mt-1 text-xs text-slate-500">VNĐ</div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <x-admin.table-card>
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
                @foreach($doanhThuTheoThang as $row)
                    <tr class="hover:bg-slate-50/50 transition-colors group">
                        <td class="py-6">
                            <div class="text-sm font-black text-slate-900 tracking-tight group-hover:text-brand-emerald transition-colors">Tháng {{ str_pad($row->thang, 2, '0', STR_PAD_LEFT) }} / {{ $row->nam }}</div>
                            <div class="mt-1 text-xs text-slate-500">Đối soát theo giao dịch phát sinh</div>
                        </td>
                        <td class="py-6 text-center">
                            <div class="text-xs font-bold text-slate-700 tabular-nums bg-white px-3 py-1.5 rounded-xl inline-block border border-slate-200/60 shadow-sm min-w-[45px]">{{ $row->so_luong }}</div>
                        </td>
                        <td class="py-6 text-right">
                            <div class="text-sm font-black text-slate-900 tabular-nums tracking-tight leading-none">{{ number_format((float)$row->tong) }}<small class="ml-0.5 text-slate-400">VNĐ</small></div>
                        </td>
                        <td class="py-6 text-right">
                            <div class="text-xs font-bold text-slate-500 tabular-nums tracking-tight">{{ number_format($row->tong / $row->so_luong) }}<small class="ml-0.5 opacity-60">VNĐ</small></div>
                        </td>
                        <td class="py-6 text-right">
                            <div class="flex items-center justify-end">
                                <div class="h-9 w-9 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center border border-emerald-100 shadow-sm">
                                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/></svg>
                                </div>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </x-admin.table-card>
    </div>

    @push('scripts')
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
                            titleFont: { size: 10, weight: '900', family: 'Geist Sans' },
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
                                font: { size: 10, weight: '700', family: 'Geist Sans' },
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
                                font: { size: 10, weight: '700', family: 'Geist Sans' },
                                color: '#94a3b8',
                                padding: 15,
                                callback: function(value) {
                                    if (value >= 1000000) return (value / 1000000) + 'tr';
                                    return value;
                                }
                            }
                        }
                    }
                }
            });
        });
    </script>
    @endpush
</x-admin-layout>
