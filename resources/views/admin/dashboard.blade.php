<x-layouts.admin title="Dasbor - SaltPro Admin" header="Ringkasan Dasbor">
    
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="bg-surface rounded-xl p-6 shadow-sm border border-gray-100 flex items-center justify-between hover:shadow-md transition-shadow">
            <div>
                <p class="text-sm text-textLight mb-1">Total Pendapatan</p>
                <h3 class="text-2xl font-bold text-secondary">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</h3>
            </div>
            <div class="w-12 h-12 rounded-full bg-primary/10 flex items-center justify-center text-primary">
                <i class="fa-solid fa-wallet text-xl"></i>
            </div>
        </div>
        
        <div class="bg-surface rounded-xl p-6 shadow-sm border border-gray-100 flex items-center justify-between hover:shadow-md transition-shadow">
            <div>
                <p class="text-sm text-textLight mb-1">Pesanan Baru</p>
                <h3 class="text-2xl font-bold text-secondary">{{ $newOrdersCount }}</h3>
            </div>
            <div class="w-12 h-12 rounded-full bg-accent/10 flex items-center justify-center text-accent">
                <i class="fa-solid fa-bag-shopping text-xl"></i>
            </div>
        </div>

        <div class="bg-surface rounded-xl p-6 shadow-sm border border-gray-100 flex items-center justify-between hover:shadow-md transition-shadow">
            <div>
                <p class="text-sm text-textLight mb-1">Total Produk</p>
                <h3 class="text-2xl font-bold text-secondary">{{ $totalProducts }}</h3>
            </div>
            <div class="w-12 h-12 rounded-full bg-blue-500/10 flex items-center justify-center text-blue-500">
                <i class="fa-solid fa-box text-xl"></i>
            </div>
        </div>

        <div class="bg-surface rounded-xl p-6 shadow-sm border border-gray-100 flex items-center justify-between hover:shadow-md transition-shadow">
            <div>
                <p class="text-sm text-textLight mb-1">Pelanggan Aktif</p>
                <h3 class="text-2xl font-bold text-secondary">{{ $activeCustomers }}</h3>
            </div>
            <div class="w-12 h-12 rounded-full bg-green-500/10 flex items-center justify-center text-green-500">
                <i class="fa-solid fa-users text-xl"></i>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <div class="lg:col-span-2 bg-surface rounded-xl p-6 shadow-sm border border-gray-100">
            <h3 class="text-lg font-semibold text-secondary mb-4">Grafik Penjualan (7 Hari Terakhir)</h3>
            <div class="relative h-72 w-full">
                <canvas id="salesChart"></canvas>
            </div>
        </div>

        <div class="bg-surface rounded-xl p-6 shadow-sm border border-gray-100">
            <div class="flex justify-between items-center mb-4 border-b border-gray-100 pb-2">
                <h3 class="text-lg font-semibold text-secondary">Pesanan Terbaru</h3>
                <a href="{{ route('admin.orders.index') }}" class="text-sm text-primary hover:underline">Lihat Semua</a>
            </div>
            <div class="space-y-4 max-h-72 overflow-y-auto pr-2">
                @forelse($recentOrders as $order)
                <div class="flex items-center justify-between pb-3 border-b border-gray-50 last:border-0">
                    <div>
                        <a href="{{ route('admin.orders.show', $order->id) }}" class="font-medium text-sm text-textDark hover:text-primary transition-colors">{{ $order->invoice_number }}</a>
                        <p class="text-xs text-textLight">{{ $order->customer_name }}</p>
                    </div>
                    <div class="text-right">
                        <p class="font-semibold text-sm text-primary">Rp {{ number_format($order->total_price, 0, ',', '.') }}</p>
                        
                        @php
                            $statusColors = [
                                'pending' => 'bg-gray-100 text-gray-600',
                                'paid' => 'bg-blue-100 text-blue-600',
                                'processed' => 'bg-orange-100 text-orange-600',
                                'shipped' => 'bg-indigo-100 text-indigo-600',
                                'completed' => 'bg-green-100 text-green-600',
                                'cancelled' => 'bg-red-100 text-red-600',
                            ];
                        @endphp
                        <span class="text-[10px] font-bold px-2 py-1 rounded-full {{ $statusColors[$order->status] }}">
                            {{ strtoupper($order->status) }}
                        </span>
                    </div>
                </div>
                @empty
                <div class="text-center py-6 text-sm text-textLight">
                    Belum ada pesanan masuk.
                </div>
                @endforelse
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('salesChart').getContext('2d');
            
            // Ambil data dinamis dari Laravel Controller
            const labels = {!! json_encode($chartLabels) !!};
            const dataTotals = {!! json_encode($chartTotals) !!};
            
            // Setup Gradient
            let gradient = ctx.createLinearGradient(0, 0, 0, 400);
            gradient.addColorStop(0, 'rgba(47, 172, 224, 0.5)'); 
            gradient.addColorStop(1, 'rgba(47, 172, 224, 0.0)');

            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Pendapatan (Rp)',
                        data: dataTotals,
                        borderColor: '#2face0', 
                        backgroundColor: gradient,
                        borderWidth: 3,
                        pointBackgroundColor: '#253b70', 
                        pointBorderColor: '#fff',
                        pointBorderWidth: 2,
                        pointRadius: 4,
                        fill: true,
                        tension: 0.4 
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
                                    let label = context.dataset.label || '';
                                    if (label) { label += ': '; }
                                    if (context.parsed.y !== null) {
                                        label += new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', maximumSignificantDigits: 3 }).format(context.parsed.y);
                                    }
                                    return label;
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: { borderDash: [5, 5], color: '#e5e7eb' },
                            border: { display: false }
                        },
                        x: {
                            grid: { display: false },
                            border: { display: false }
                        }
                    }
                }
            });
        });
    </script>
</x-layouts.admin>