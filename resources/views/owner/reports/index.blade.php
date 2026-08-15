<x-layouts.owner title="Laporan Penjualan" header="Laporan Keuangan & Penjualan">
    
    <div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4">
        <div>
            <h2 class="text-xl font-bold text-secondary font-poppins">Rekapitulasi Pendapatan</h2>
            <p class="text-sm text-textLight">Daftar seluruh transaksi yang berhasil dan telah dibayar.</p>
        </div>
        <div class="flex gap-3 w-full md:w-auto">
            <a href="{{ route('owner.reports.excel') }}" class="flex-1 md:flex-none bg-green-600 hover:bg-green-700 text-white px-5 py-2.5 rounded-xl text-sm font-medium transition-colors shadow-md shadow-green-600/20 flex items-center justify-center gap-2">
                <i class="fa-solid fa-file-excel"></i> Export Excel
            </a>
            <a href="{{ route('owner.reports.print') }}" target="_blank" class="flex-1 md:flex-none bg-secondary hover:bg-primary text-white px-5 py-2.5 rounded-xl text-sm font-medium transition-colors shadow-md shadow-secondary/20 flex items-center justify-center gap-2">
                <i class="fa-solid fa-print"></i> Cetak PDF
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
        <div class="bg-surface p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center gap-4">
            <div class="w-14 h-14 rounded-full bg-primary/10 flex items-center justify-center text-primary text-2xl">
                <i class="fa-solid fa-money-bill-wave"></i>
            </div>
            <div>
                <p class="text-sm text-textLight font-medium">Total Omzet Keseluruhan</p>
                <p class="text-2xl font-bold text-dark-text font-poppins">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</p>
            </div>
        </div>
        <div class="bg-surface p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center gap-4">
            <div class="w-14 h-14 rounded-full bg-green-500/10 flex items-center justify-center text-green-500 text-2xl">
                <i class="fa-solid fa-cart-check"></i>
            </div>
            <div>
                <p class="text-sm text-textLight font-medium">Total Transaksi Berhasil</p>
                <p class="text-2xl font-bold text-dark-text font-poppins">{{ $orders->count() }} Transaksi</p>
            </div>
        </div>
    </div>

    <div class="bg-surface rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-background text-textLight text-sm uppercase tracking-wider border-b border-gray-100">
                        <th class="p-5 font-medium">Tanggal</th>
                        <th class="p-5 font-medium">No. Invoice</th>
                        <th class="p-5 font-medium">Pelanggan</th>
                        <th class="p-5 font-medium">Metode / Tipe</th>
                        <th class="p-5 font-medium">Status</th>
                        <th class="p-5 font-medium text-right">Nominal (Rp)</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($orders as $order)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="p-5 text-sm text-textDark">{{ $order->created_at->format('d/m/Y H:i') }}</td>
                        <td class="p-5 text-sm font-semibold text-primary">{{ $order->invoice_number }}</td>
                        <td class="p-5 text-sm text-textDark">{{ $order->customer_name }}</td>
                        <td class="p-5 text-xs">
                            @if($order->payment_method === 'cash' || $order->order_type === 'offline')
                                <span class="px-2.5 py-1 rounded-md bg-emerald-100 text-emerald-800 font-bold inline-flex items-center gap-1">
                                    <i class="fa-solid fa-money-bill-wave"></i> Cash (Offline)
                                </span>
                            @else
                                <span class="px-2.5 py-1 rounded-md bg-blue-100 text-blue-800 font-semibold inline-flex items-center gap-1">
                                    <i class="fa-solid fa-globe"></i> Online (Midtrans)
                                </span>
                            @endif
                        </td>
                        <td class="p-5">
                            @if($order->status == 'completed')
                                <span class="px-3 py-1 bg-green-100 text-green-700 text-xs font-bold rounded-full">Selesai</span>
                            @else
                                <span class="px-3 py-1 bg-blue-100 text-blue-700 text-xs font-bold rounded-full">{{ strtoupper($order->status) }}</span>
                            @endif
                        </td>
                        <td class="p-5 text-sm font-bold text-textDark text-right">Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="p-8 text-center text-textLight">Belum ada data penjualan yang sukses.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</x-layouts.owner>