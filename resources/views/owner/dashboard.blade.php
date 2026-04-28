<x-layouts.owner title="Ringkasan Bisnis - SaltPro" header="Ringkasan Bisnis">

    <div class="mb-8 p-6 bg-gradient-to-r from-secondary to-primary rounded-2xl shadow-lg text-white relative overflow-hidden">
        <div class="relative z-10">
            <h2 class="text-2xl font-bold font-poppins mb-1">Selamat datang kembali, Bapak/Ibu Owner! 👋</h2>
            <p class="text-white/80 text-sm">Berikut adalah ringkasan performa bisnis CV Merisa Jaya hari ini.</p>
        </div>
        <i class="fa-solid fa-chart-line absolute -bottom-4 -right-4 text-white/10 text-8xl transform -rotate-12 pointer-events-none"></i>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        
        <div class="bg-gradient-to-br from-white to-[#f8fdff] rounded-2xl p-6 shadow-sm border border-light-blue relative overflow-hidden group hover:shadow-md transition-all hover:-translate-y-1">
            <div class="relative z-10">
                <p class="text-sm font-medium text-textLight mb-1">Total Omzet Keseluruhan</p>
                <h3 class="text-3xl font-bold font-poppins text-primary">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</h3>
            </div>
            <div class="absolute top-6 right-6 w-12 h-12 rounded-full bg-primary/10 flex items-center justify-center text-primary group-hover:scale-110 transition-transform">
                <i class="fa-solid fa-wallet text-xl"></i>
            </div>
            <div class="absolute -bottom-2 -left-2 w-16 h-16 bg-primary/5 rounded-full blur-xl"></div>
        </div>
        
        <div class="bg-surface rounded-2xl p-6 shadow-sm border border-gray-100 flex items-center justify-between group hover:shadow-md transition-all hover:-translate-y-1">
            <div>
                <p class="text-sm font-medium text-textLight mb-1">Transaksi Berhasil</p>
                <h3 class="text-2xl font-bold font-poppins text-secondary">{{ number_format($totalOrders, 0, ',', '.') }}</h3>
            </div>
            <div class="w-12 h-12 rounded-full bg-green-500/10 flex items-center justify-center text-green-500 group-hover:bg-green-500 group-hover:text-white transition-colors">
                <i class="fa-solid fa-bag-shopping text-xl"></i>
            </div>
        </div>

        <div class="bg-surface rounded-2xl p-6 shadow-sm border border-gray-100 flex items-center justify-between group hover:shadow-md transition-all hover:-translate-y-1">
            <div>
                <p class="text-sm font-medium text-textLight mb-1">Pelanggan Terdaftar</p>
                <h3 class="text-2xl font-bold font-poppins text-secondary">{{ number_format($totalCustomers, 0, ',', '.') }}</h3>
            </div>
            <div class="w-12 h-12 rounded-full bg-accent/10 flex items-center justify-center text-accent group-hover:bg-accent group-hover:text-white transition-colors">
                <i class="fa-solid fa-users text-xl"></i>
            </div>
        </div>

        <div class="bg-surface rounded-2xl p-6 shadow-sm border border-gray-100 flex items-center justify-between group hover:shadow-md transition-all hover:-translate-y-1">
            <div>
                <p class="text-sm font-medium text-textLight mb-1">Produk Dijual</p>
                <h3 class="text-2xl font-bold font-poppins text-secondary">{{ $totalProducts }}</h3>
            </div>
            <div class="w-12 h-12 rounded-full bg-purple-500/10 flex items-center justify-center text-purple-500 group-hover:bg-purple-500 group-hover:text-white transition-colors">
                <i class="fa-solid fa-box text-xl"></i>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <div class="lg:col-span-2 bg-surface rounded-2xl p-6 shadow-sm border border-gray-100">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-lg font-semibold text-secondary font-poppins">Grafik Omzet (7 Hari Terakhir)</h3>
                <a href="{{ route('owner.reports.index') }}" class="text-sm text-primary hover:underline font-medium">Lihat Laporan Lengkap</a>
            </div>
            <div class="relative h-[300px] w-full">
                <canvas id="revenueChart"></canvas>
            </div>
        </div>

        <div class="bg-surface rounded-2xl p-6 shadow-sm border border-gray-100">
            <h3 class="text-lg font-semibold text-secondary font-poppins mb-6 border-b border-gray-100 pb-3">Pemasukan Terbaru</h3>
            
            <div class="space-y-5">
                @forelse($recentOrders as $order)
                <div class="flex items-center justify-between group">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-light-blue flex items-center justify-center text-primary group-hover:bg-primary group-hover:text-white transition-colors">
                            <i class="fa-solid fa-receipt"></i>
                        </div>
                        <div>
                            <p class="font-semibold text-sm text-textDark">{{ $order->invoice_number }}</p>
                            <p class="text-xs text-textLight">{{ $order->customer_name }}</p>
                        </div>
                    </div>
                    <div class="text-right">
                        <p class="font-bold text-sm text-green-600">+ Rp {{ number_format($order->total_price, 0, ',', '.') }}</p>
                        <p class="text-[10px] text-textLight">{{ $order->created_at->diffForHumans() }}</p>
                    </div>
                </div>
                @empty
                <div class="text-center py-8">
                    <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-3 text-gray-300">
                        <i class="fa-solid fa-folder-open text-2xl"></i>
                    </div>
                    <p class="text-sm text-textLight">Belum ada pemasukan terbaru.</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('revenueChart').getContext('2d');
            
            // Ambil data dinamis dari Controller PHP
            const labels = {!! json_encode($chartLabels) !!};
            const dataTotals = {!! json_encode($chartTotals) !!};
            
            // Bikin efek gradient di bawah garis grafik supaya mewah
            let gradient = ctx.createLinearGradient(0, 0, 0, 400);
            gradient.addColorStop(0, 'rgba(47, 172, 224, 0.4)'); // Primary color semi transparan
            gradient.addColorStop(1, 'rgba(47, 172, 224, 0.0)');

            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Omzet (Rp)',
                        data: dataTotals,
                        borderColor: '#2face0', // Primary color
                        backgroundColor: gradient,
                        borderWidth: 3,
                        pointBackgroundColor: '#ffffff',
                        pointBorderColor: '#2face0',
                        pointBorderWidth: 2,
                        pointRadius: 4,
                        pointHoverRadius: 6,
                        fill: true,
                        tension: 0.4 // Melengkung halus
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            backgroundColor: '#253b70',
                            padding: 12,
                            titleFont: { family: 'Poppins', size: 13 },
                            bodyFont: { family: 'Poppins', size: 14, weight: 'bold' },
                            callbacks: {
                                label: function(context) {
                                    return 'Rp ' + new Intl.NumberFormat('id-ID').format(context.parsed.y);
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: { borderDash: [5, 5], color: '#f3f4f6' },
                            border: { display: false },
                            ticks: {
                                font: { family: 'Poppins', size: 11 },
                                color: '#6b7280',
                                callback: function(value) {
                                    if(value >= 1000000) return 'Rp ' + (value/1000000) + ' Jt';
                                    if(value >= 1000) return 'Rp ' + (value/1000) + ' Rb';
                                    return 'Rp ' + value;
                                }
                            }
                        },
                        x: {
                            grid: { display: false },
                            border: { display: false },
                            ticks: {
                                font: { family: 'Poppins', size: 11 },
                                color: '#6b7280'
                            }
                        }
                    },
                    interaction: {
                        intersect: false,
                        mode: 'index',
                    },
                }
            });
        });
    </script>
</x-layouts.owner>