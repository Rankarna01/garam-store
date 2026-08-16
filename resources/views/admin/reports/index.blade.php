<x-layouts.admin title="Laporan Penjualan" header="Analitik & Laporan Penjualan">
    
    <!-- HEADER & AKSI EKSPOR -->
    <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4 mb-6">
        <div>
            <h2 class="text-xl font-bold text-secondary flex items-center gap-2">
                <i class="fa-solid fa-chart-line text-primary"></i>
                Laporan Pendapatan: <span class="text-primary">{{ $periodLabel }}</span>
            </h2>
            <p class="text-xs text-textLight mt-1">Data penjualan yang berhasil dan telah terselesaikan di sistem.</p>
        </div>
        
        <div class="flex flex-wrap gap-2.5">
            <a href="{{ route('admin.reports.excel', request()->query()) }}" class="bg-emerald-600 hover:bg-emerald-700 text-white px-4 py-2.5 rounded-xl text-xs font-semibold transition-colors flex items-center gap-2 shadow-sm shadow-emerald-600/20">
                <i class="fa-solid fa-file-excel"></i> Export Excel (CSV)
            </a>
            <a href="{{ route('admin.reports.print', request()->query()) }}" target="_blank" class="bg-secondary hover:bg-primary text-white px-4 py-2.5 rounded-xl text-xs font-semibold transition-colors flex items-center gap-2 shadow-sm">
                <i class="fa-solid fa-print"></i> Cetak Dokumen PDF
            </a>
        </div>
    </div>

    <!-- PANEL FILTER PERIODE LAPORAN (Harian, Mingguan, Bulanan, Custom) -->
    <div class="bg-surface rounded-2xl shadow-sm border border-gray-100 p-5 mb-6">
        <div class="flex flex-col gap-4">
            
            <!-- Quick Preset Tabs -->
            <div class="flex flex-wrap items-center gap-2 border-b border-gray-100 pb-4">
                <span class="text-xs font-bold text-textDark mr-2 flex items-center gap-1.5">
                    <i class="fa-solid fa-filter text-primary"></i> Filter Periode:
                </span>
                
                <a href="{{ route('admin.reports.index', ['period' => 'all']) }}" 
                   class="px-3.5 py-1.5 rounded-xl text-xs font-semibold transition-all {{ $period === 'all' ? 'bg-primary text-white shadow-sm' : 'bg-gray-100 text-textDark hover:bg-gray-200' }}">
                    Semua Waktu
                </a>
                
                <a href="{{ route('admin.reports.index', ['period' => 'daily', 'date' => date('Y-m-d')]) }}" 
                   class="px-3.5 py-1.5 rounded-xl text-xs font-semibold transition-all {{ $period === 'daily' || $period === 'today' ? 'bg-primary text-white shadow-sm' : 'bg-gray-100 text-textDark hover:bg-gray-200' }}">
                    <i class="fa-solid fa-calendar-day mr-1"></i> Harian (Hari Ini)
                </a>
                
                <a href="{{ route('admin.reports.index', ['period' => 'weekly']) }}" 
                   class="px-3.5 py-1.5 rounded-xl text-xs font-semibold transition-all {{ $period === 'weekly' ? 'bg-primary text-white shadow-sm' : 'bg-gray-100 text-textDark hover:bg-gray-200' }}">
                    <i class="fa-solid fa-calendar-week mr-1"></i> Mingguan (Minggu Ini)
                </a>
                
                <a href="{{ route('admin.reports.index', ['period' => 'monthly', 'month' => date('Y-m')]) }}" 
                   class="px-3.5 py-1.5 rounded-xl text-xs font-semibold transition-all {{ $period === 'monthly' ? 'bg-primary text-white shadow-sm' : 'bg-gray-100 text-textDark hover:bg-gray-200' }}">
                    <i class="fa-solid fa-calendar-days mr-1"></i> Bulanan (Bulan Ini)
                </a>

                <button type="button" onclick="toggleCustomFilter()" 
                        class="px-3.5 py-1.5 rounded-xl text-xs font-semibold transition-all {{ $period === 'custom' ? 'bg-primary text-white shadow-sm' : 'bg-gray-100 text-textDark hover:bg-gray-200' }}">
                    <i class="fa-solid fa-sliders mr-1"></i> Pilih Tanggal Kustom
                </button>
            </div>

            <!-- Form Pilih Tanggal Spesifik -->
            <form action="{{ route('admin.reports.index') }}" method="GET" class="flex flex-wrap items-center gap-3 pt-1">
                <input type="hidden" name="period" id="filterPeriodInput" value="{{ $period }}">

                <!-- Jika Filter Harian: Pilih Tanggal Tertentu -->
                @if($period === 'daily' || $period === 'today')
                    <div class="flex items-center gap-2">
                        <label class="text-xs font-medium text-textLight">Pilih Tanggal:</label>
                        <input type="date" name="date" value="{{ request('date', date('Y-m-d')) }}" class="px-3 py-1.5 rounded-xl border border-gray-200 text-xs font-semibold outline-none focus:ring-2 focus:ring-primary">
                        <button type="submit" class="bg-secondary hover:bg-primary text-white px-3 py-1.5 rounded-xl text-xs font-semibold transition-colors">
                            Tampilkan
                        </button>
                    </div>
                @endif

                <!-- Jika Filter Bulanan: Pilih Bulan Tertentu -->
                @if($period === 'monthly')
                    <div class="flex items-center gap-2">
                        <label class="text-xs font-medium text-textLight">Pilih Bulan & Tahun:</label>
                        <input type="month" name="month" value="{{ request('month', date('Y-m')) }}" class="px-3 py-1.5 rounded-xl border border-gray-200 text-xs font-semibold outline-none focus:ring-2 focus:ring-primary">
                        <button type="submit" class="bg-secondary hover:bg-primary text-white px-3 py-1.5 rounded-xl text-xs font-semibold transition-colors">
                            Tampilkan
                        </button>
                    </div>
                @endif

                <!-- Form Rentang Tanggal Kustom (Custom Date Range) -->
                <div id="customFilterBox" class="{{ $period === 'custom' ? 'flex' : 'hidden' }} flex-wrap items-center gap-2 w-full sm:w-auto">
                    <span class="text-xs font-medium text-textLight">Dari:</span>
                    <input type="date" name="start_date" value="{{ request('start_date', $startDate) }}" class="px-3 py-1.5 rounded-xl border border-gray-200 text-xs font-semibold outline-none focus:ring-2 focus:ring-primary">
                    <span class="text-xs font-medium text-textLight">Sampai:</span>
                    <input type="date" name="end_date" value="{{ request('end_date', $endDate) }}" class="px-3 py-1.5 rounded-xl border border-gray-200 text-xs font-semibold outline-none focus:ring-2 focus:ring-primary">
                    <button type="submit" class="bg-primary hover:bg-secondary text-white px-4 py-1.5 rounded-xl text-xs font-semibold transition-colors shadow-sm">
                        Filter Tanggal
                    </button>
                </div>
            </form>

        </div>
    </div>

    <!-- 4 KARTU METRIK STATISTIK -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
        <div class="bg-surface p-5 rounded-2xl shadow-sm border border-gray-100 flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-primary/10 text-primary flex items-center justify-center text-xl">
                <i class="fa-solid fa-money-bill-trend-up"></i>
            </div>
            <div>
                <p class="text-xs text-textLight font-medium">Total Omzet Pendapatan</p>
                <p class="text-xl font-bold text-primary font-poppins">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</p>
            </div>
        </div>

        <div class="bg-surface p-5 rounded-2xl shadow-sm border border-gray-100 flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center text-xl">
                <i class="fa-solid fa-receipt"></i>
            </div>
            <div>
                <p class="text-xs text-textLight font-medium">Total Transaksi Selesai</p>
                <p class="text-xl font-bold text-textDark font-poppins">{{ $totalTransactions }} Transaksi</p>
            </div>
        </div>

        <div class="bg-surface p-5 rounded-2xl shadow-sm border border-gray-100 flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-xl">
                <i class="fa-solid fa-money-bill-wave"></i>
            </div>
            <div>
                <p class="text-xs text-textLight font-medium">Transaksi Cash (Offline)</p>
                <p class="text-xl font-bold text-emerald-700 font-poppins">{{ $cashTransactions }} Transaksi</p>
            </div>
        </div>

        <div class="bg-surface p-5 rounded-2xl shadow-sm border border-gray-100 flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center text-xl">
                <i class="fa-solid fa-globe"></i>
            </div>
            <div>
                <p class="text-xs text-textLight font-medium">Transaksi Midtrans (Online)</p>
                <p class="text-xl font-bold text-blue-700 font-poppins">{{ $onlineTransactions }} Transaksi</p>
            </div>
        </div>
    </div>

    <!-- GRAFIK TREN PENDAPATAN -->
    <div class="bg-surface rounded-2xl p-6 shadow-sm border border-gray-100 mb-6">
        <div class="flex items-center justify-between mb-4">
            <div>
                <h3 class="font-bold text-secondary text-base">Grafik Pendapatan</h3>
                <p class="text-xs text-textLight">Tren penjualan untuk periode: {{ $periodLabel }}</p>
            </div>
        </div>
        <div class="relative h-72 w-full">
            <canvas id="reportChart"></canvas>
        </div>
    </div>

    <!-- TABEL DAFTAR TRANSAKSI -->
    <div class="bg-surface rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-6 border-b border-gray-100 flex items-center justify-between">
            <div>
                <h3 class="font-bold text-secondary text-base">Rincian Transaksi Terselesaikan</h3>
                <p class="text-xs text-textLight">Menampilkan {{ $orders->count() }} data transaksi.</p>
            </div>
        </div>
        <div class="overflow-x-auto max-h-[550px]">
            <table class="w-full text-left border-collapse">
                <thead class="sticky top-0 bg-background z-10">
                    <tr class="text-textLight text-xs uppercase tracking-wider">
                        <th class="p-4 font-medium">Tanggal</th>
                        <th class="p-4 font-medium">No. Invoice</th>
                        <th class="p-4 font-medium">Pelanggan</th>
                        <th class="p-4 font-medium">Metode / Tipe</th>
                        <th class="p-4 font-medium text-center">Status</th>
                        <th class="p-4 font-medium text-right">Pendapatan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 text-sm">
                    @forelse($orders as $order)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="p-4 text-textLight text-xs font-medium">{{ $order->created_at->format('d M Y, H:i') }}</td>
                        <td class="p-4 font-bold text-textDark">
                            <a href="{{ route('admin.orders.show', $order->id) }}" class="text-secondary hover:text-primary transition-colors">
                                {{ $order->invoice_number }}
                            </a>
                        </td>
                        <td class="p-4">
                            <p class="font-medium text-textDark">{{ $order->customer_name }}</p>
                            <p class="text-xs text-textLight">{{ $order->customer_phone ?? '-' }}</p>
                        </td>
                        <td class="p-4 text-xs">
                            @if($order->payment_method === 'cash' || $order->order_type === 'offline')
                                <span class="px-2.5 py-1 rounded-md bg-emerald-100 text-emerald-800 font-bold inline-flex items-center gap-1">
                                    <i class="fa-solid fa-money-bill-wave"></i> Cash (Offline)
                                </span>
                            @else
                                <span class="px-2.5 py-1 rounded-md bg-blue-100 text-blue-800 font-semibold inline-flex items-center gap-1">
                                    <i class="fa-solid fa-globe"></i> Midtrans
                                </span>
                            @endif
                        </td>
                        <td class="p-4 text-center">
                            <span class="px-2.5 py-1 bg-green-100 text-green-700 text-xs font-bold rounded-full">
                                {{ strtoupper($order->status) }}
                            </span>
                        </td>
                        <td class="p-4 font-bold text-primary text-right">Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="p-10 text-center text-textLight">
                            <i class="fa-solid fa-folder-open text-3xl mb-2 block text-gray-300"></i>
                            Tidak ada transaksi pada periode {{ $periodLabel }}.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
                @if($orders->count() > 0)
                <tfoot class="bg-gray-50 border-t-2 border-gray-200">
                    <tr>
                        <td colspan="5" class="p-4 font-bold text-textDark text-right">TOTAL PENDAPATAN ({{ $periodLabel }}):</td>
                        <td class="p-4 font-extrabold text-primary text-right text-base">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</td>
                    </tr>
                </tfoot>
                @endif
            </table>
        </div>
    </div>

    <script>
        function toggleCustomFilter() {
            const box = document.getElementById('customFilterBox');
            const input = document.getElementById('filterPeriodInput');
            if (box.classList.contains('hidden')) {
                box.classList.remove('hidden');
                box.classList.add('flex');
                input.value = 'custom';
            } else {
                box.classList.add('hidden');
                box.classList.remove('flex');
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('reportChart').getContext('2d');
            
            // Data tanggal & total dari controller
            const dates = {!! $salesData->pluck('date')->toJson() !!};
            const totals = {!! $salesData->pluck('total')->toJson() !!};
            
            let gradient = ctx.createLinearGradient(0, 0, 0, 300);
            gradient.addColorStop(0, 'rgba(47, 172, 224, 0.45)'); 
            gradient.addColorStop(1, 'rgba(47, 172, 224, 0.0)');

            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: dates.length > 0 ? dates : ['Tidak Ada Data'],
                    datasets: [{
                        label: 'Pendapatan (Rp)',
                        data: totals.length > 0 ? totals : [0],
                        borderColor: '#2face0', 
                        backgroundColor: gradient,
                        borderWidth: 3,
                        pointBackgroundColor: '#253b70',
                        pointBorderColor: '#fff',
                        pointBorderWidth: 2,
                        pointRadius: 4,
                        fill: true,
                        tension: 0.3
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { 
                        legend: { display: false },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    return ' Rp ' + context.parsed.y.toLocaleString('id-ID');
                                }
                            }
                        }
                    },
                    scales: {
                        y: { 
                            beginAtZero: true, 
                            grid: { borderDash: [5, 5] },
                            ticks: {
                                callback: function(value) {
                                    return 'Rp ' + value.toLocaleString('id-ID');
                                }
                            }
                        },
                        x: { 
                            grid: { display: false } 
                        }
                    }
                }
            });
        });
    </script>
</x-layouts.admin>