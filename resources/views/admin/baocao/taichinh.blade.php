<x-admin-layout>
    <x-slot name="title">Báo cáo tài chính</x-slot>

    <div class="space-y-8 animate-fade-up">
        {{-- Header & Export --}}
        <header class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h2 class="text-2xl font-black text-ink-primary uppercase tracking-tight">Tổng quan tài chính</h2>
                <p class="text-[10px] font-bold text-ink-secondary/50 uppercase tracking-widest mt-1">Dữ liệu cập nhật theo thời gian thực</p>
            </div>
            
            <div class="flex items-center gap-3">
                <form action="{{ route('admin.baocao.xuat_excel') }}" method="GET" class="flex items-center gap-2">
                    <select name="nam" class="bg-ui-card border-ui-border rounded-xl text-[10px] font-black uppercase tracking-widest px-4 py-2 focus:ring-2 focus:ring-brand-emerald/20 transition-all">
                        @for($i = date('Y'); $i >= date('Y') - 2; $i--)
                            <option value="{{ $i }}">{{ $i }}</option>
                        @endfor
                    </select>
                    <button type="submit" class="pdu-btn-primary shadow-lg shadow-brand-emerald/20 !px-6 h-10">
                        <svg class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        Xuất Excel
                    </button>
                </form>
            </div>
        </header>

        {{-- Metric Cards --}}
        <section class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <article class="pdu-card group relative overflow-hidden">
                <div class="absolute -right-6 -top-6 h-20 w-20 rounded-full bg-brand-emerald/5 transition-transform duration-700 group-hover:scale-150"></div>
                <div class="relative z-10">
                    <span class="text-[9px] font-black uppercase tracking-widest text-ink-secondary/40">Doanh thu tháng này</span>
                    <div class="mt-2 flex items-baseline gap-2">
                        <h3 class="text-2xl font-black text-ink-primary tracking-tight">{{ number_format($doanhThuThangNay) }}đ</h3>
                        <span @class([
                            'text-[10px] font-bold px-1.5 py-0.5 rounded-md',
                            'bg-status-success/10 text-status-success' => $tangTruong >= 0,
                            'bg-status-error/10 text-status-error' => $tangTruong < 0,
                        ])>
                            {{ $tangTruong >= 0 ? '+' : '' }}{{ $tangTruong }}%
                        </span>
                    </div>
                </div>
            </article>

            <article class="pdu-card group relative overflow-hidden">
                <div class="absolute -right-6 -top-6 h-20 w-20 rounded-full bg-brand-jade/5 transition-transform duration-700 group-hover:scale-150"></div>
                <div class="relative z-10">
                    <span class="text-[9px] font-black uppercase tracking-widest text-ink-secondary/40">Tổng tiền cọc</span>
                    <div class="mt-2">
                        <h3 class="text-2xl font-black text-ink-primary tracking-tight">{{ number_format($tongCocHienTai) }}đ</h3>
                        <p class="text-[9px] font-bold text-ink-secondary/30 uppercase mt-1 tracking-widest">Ký quỹ sinh viên</p>
                    </div>
                </div>
            </article>

            <article class="pdu-card group relative overflow-hidden">
                <div class="absolute -right-6 -top-6 h-20 w-20 rounded-full bg-status-info/5 transition-transform duration-700 group-hover:scale-150"></div>
                <div class="relative z-10">
                    <span class="text-[9px] font-black uppercase tracking-widest text-ink-secondary/40">Tỷ lệ lấp đầy</span>
                    <div class="mt-2">
                        <h3 class="text-2xl font-black text-ink-primary tracking-tight">{{ $tyLeLapDay }}%</h3>
                        <p class="text-[9px] font-bold text-ink-secondary/30 uppercase mt-1 tracking-widest">{{ $phongDangThue }}/{{ $tongPhong }} phòng đang ở</p>
                    </div>
                </div>
            </article>

            <article class="pdu-card group relative overflow-hidden">
                <div class="absolute -right-6 -top-6 h-20 w-20 rounded-full bg-ink-primary/5 transition-transform duration-700 group-hover:scale-150"></div>
                <div class="relative z-10">
                    <span class="text-[9px] font-black uppercase tracking-widest text-ink-secondary/40">Tổng doanh thu 12T</span>
                    <div class="mt-2">
                        <h3 class="text-2xl font-black text-ink-primary tracking-tight">{{ number_format($doanhThuTheoThang->sum('tong')) }}đ</h3>
                        <p class="text-[9px] font-bold text-ink-secondary/30 uppercase mt-1 tracking-widest">{{ $doanhThuTheoThang->sum('so_luong') }} giao dịch</p>
                    </div>
                </div>
            </article>
        </section>

        {{-- Chart & Top Rooms --}}
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
                    <canvas id="revenueChart"></canvas>
                </div>
            </article>

            <article class="lg:col-span-4 pdu-card">
                <h3 class="text-[11px] font-black text-ink-primary uppercase tracking-widest mb-6">Top 5 phòng cao điểm</h3>
                <div class="space-y-6">
                    @foreach($topPhong as $phong)
                        <div class="flex items-center justify-between group">
                            <div class="flex items-center gap-4">
                                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-ui-bg border border-ui-border group-hover:border-brand-emerald/30 transition-colors">
                                    <span class="text-xs font-black text-ink-primary">{{ $loop->iteration }}</span>
                                </div>
                                <div>
                                    <div class="text-sm font-bold text-ink-primary uppercase tracking-tight">{{ $phong->phong->tenphong }}</div>
                                    <div class="text-[9px] font-bold text-ink-secondary/40 uppercase tracking-widest">Tòa {{ $phong->phong->tang }}</div>
                                </div>
                            </div>
                            <div class="text-right">
                                <div class="text-sm font-black text-ink-primary tabular-nums tracking-tight">{{ number_format((float)$phong->tong) }}đ</div>
                                <div class="text-[8px] font-bold text-brand-emerald uppercase tracking-widest">Doanh thu</div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </article>
        </div>

        {{-- Detailed Table --}}
        <article class="pdu-card !p-0 overflow-hidden shadow-xl shadow-ink-primary/5">
            <div class="px-8 py-6 border-b border-ui-border bg-ui-bg/30">
                <h2 class="text-[11px] font-black text-ink-primary uppercase tracking-widest">Chi tiết doanh thu theo kỳ</h2>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-ui-bg/50 border-b border-ui-border text-[10px] font-black text-ink-secondary/40 uppercase tracking-[0.2em]">
                            <th class="px-8 py-4">Kỳ báo cáo</th>
                            <th class="px-8 py-4">Số hóa đơn</th>
                            <th class="px-8 py-4">Tổng doanh thu</th>
                            <th class="px-8 py-4">Trung bình/HĐ</th>
                            <th class="px-8 py-4 text-right">Xu hướng</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-ui-border">
                        @foreach($doanhThuTheoThang as $row)
                            <tr class="group hover:bg-ui-bg/30 transition-colors">
                                <td class="px-8 py-5">
                                    <span class="font-display font-black text-ink-primary uppercase tracking-tight text-base">T{{ $row->thang }}/{{ $row->nam }}</span>
                                </td>
                                <td class="px-8 py-5 font-bold text-ink-secondary tabular-nums tracking-tight">{{ $row->so_luong }}</td>
                                <td class="px-8 py-5 font-black text-ink-primary tabular-nums tracking-tight">{{ number_format((float)$row->tong) }}đ</td>
                                <td class="px-8 py-5 font-medium text-ink-secondary/60 tabular-nums tracking-tight">{{ number_format($row->tong / $row->so_luong) }}đ</td>
                                <td class="px-8 py-5 text-right">
                                    <div class="flex items-center justify-end gap-1.5 text-status-success">
                                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/></svg>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </article>
    </div>

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('revenueChart').getContext('2d');
        const data = @json($doanhThuTheoThang);
        
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
    @endpush
</x-admin-layout>
