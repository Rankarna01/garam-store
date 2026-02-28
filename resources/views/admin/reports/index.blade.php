<x-layouts.admin title="Laporan Penjualan" header="Analitik & Laporan">
    
    <div class="flex flex-wrap justify-between items-center mb-6 gap-4">
        <div>
            <h2 class="text-2xl font-bold text-secondary">Total Pendapatan Bersih: Rp {{ number_format($totalRevenue, 0, ',', '.') }}</h2>
            <p class="text-sm text-textLight">Berdasarkan pesanan yang telah dibayar / selesai.</p>
        </div>
        
        <div class="flex gap-3">
            <a href="{{ route('admin.reports.excel') }}" class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-xl text-sm font-medium transition-colors flex items-center gap-2 shadow-sm">
                <i class="fa-solid fa-file-excel"></i> Export Excel (CSV)
            </a>
            <a href="{{ route('admin.reports.print') }}" target="_blank" class="bg-secondary hover:bg-primary text-white px-4 py-2 rounded-xl text-sm font-medium transition-colors flex items-center gap-2 shadow-sm">
                <i class="fa-solid fa-print"></i> Cetak PDF / Print
            </a>
        </div>
    </div>

    <div class="bg-surface rounded-xl p-6 shadow-sm border border-gray-100 mb-8">
        <h3 class="font-semibold text-secondary mb-4">Grafik Pertumbuhan Pendapatan</h3>
        <div class="relative h-80 w-full">
            <canvas id="reportChart"></canvas>
        </div>
    </div>

    <div class="bg-surface rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-6 border-b border-gray-100">
            <h3 class="font-semibold text-secondary">Daftar Transaksi Terselesaikan</h3>
        </div>
        <div class="overflow-x-auto max-h-[500px]">
            <table class="w-full text-left border-collapse">
                <thead class="sticky top-0 bg-background z-10">
                    <tr class="text-textLight text-sm uppercase tracking-wider">
                        <th class="p-4 font-medium">Tanggal</th>
                        <th class="p-4 font-medium">Invoice</th>
                        <th class="p-4 font-medium">Pelanggan</th>
                        <th class="p-4 font-medium">Status</th>
                        <th class="p-4 font-medium text-right">Pendapatan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($orders as $order)
                    <tr class="hover:bg-gray-50 transition-colors text-sm">
                        <td class="p-4 text-textLight">{{ $order->created_at->format('d M Y, H:i') }}</td>
                        <td class="p-4 font-semibold text-textDark">{{ $order->invoice_number }}</td>
                        <td class="p-4">{{ $order->customer_name }}</td>
                        <td class="p-4"><span class="px-2 py-1 bg-green-100 text-green-700 text-xs font-bold rounded">{{ strtoupper($order->status) }}</span></td>
                        <td class="p-4 font-bold text-primary text-right">Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
                    </tr>
                    @empty
                    <tr><td colspan="5" class="p-8 text-center text-textLight">Belum ada data pendapatan.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('reportChart').getContext('2d');
            
            // Ambil data PHP dan ubah jadi JS Array
            const dates = {!! $salesData->pluck('date')->toJson() !!};
            const totals = {!! $salesData->pluck('total')->toJson() !!};
            
            let gradient = ctx.createLinearGradient(0, 0, 0, 400);
            gradient.addColorStop(0, 'rgba(47, 172, 224, 0.5)'); 
            gradient.addColorStop(1, 'rgba(47, 172, 224, 0.0)');

            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: dates,
                    datasets: [{
                        label: 'Pendapatan Harian (Rp)',
                        data: totals,
                        borderColor: '#2face0', 
                        backgroundColor: gradient,
                        borderWidth: 3,
                        pointBackgroundColor: '#253b70',
                        pointBorderColor: '#fff',
                        pointBorderWidth: 2,
                        fill: true,
                        tension: 0.3
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { legend: { display: false } },
                    scales: {
                        y: { beginAtZero: true, grid: { borderDash: [5, 5] } },
                        x: { grid: { display: false } }
                    }
                }
            });
        });
    </script>
</x-layouts.admin>