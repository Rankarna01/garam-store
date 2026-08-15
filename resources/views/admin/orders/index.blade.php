<x-layouts.admin title="Manajemen Pesanan" header="Daftar Pesanan">
    
    @if(session('success'))
        <div class="mb-4 p-4 bg-green-100 border border-green-200 text-green-700 rounded-xl flex items-center gap-2">
            <i class="fa-solid fa-circle-check"></i> {{ session('success') }}
        </div>
    @endif

    <div class="bg-surface rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-6 border-b border-gray-100 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h2 class="text-lg font-semibold text-secondary">Semua Transaksi & Pesanan</h2>
                <p class="text-xs text-textLight">Daftar transaksi pesanan online dan transaksi langsung kasir/offline.</p>
            </div>
            <a href="{{ route('admin.orders.create') }}" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2.5 rounded-xl text-sm font-semibold transition-colors shadow-md shadow-green-600/20 flex items-center justify-center gap-2">
                <i class="fa-solid fa-plus"></i> Input Transaksi Cash / Manual
            </a>
        </div>
        
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-background text-textLight text-sm uppercase tracking-wider">
                        <th class="p-4 font-medium">Invoice</th>
                        <th class="p-4 font-medium">Pelanggan</th>
                        <th class="p-4 font-medium">Tipe / Pembayaran</th>
                        <th class="p-4 font-medium">Total</th>
                        <th class="p-4 font-medium">Status</th>
                        <th class="p-4 font-medium text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($orders as $order)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="p-4 font-semibold text-textDark">
                            {{ $order->invoice_number }}<br>
                            <span class="text-xs text-textLight font-normal">{{ $order->created_at->format('d M Y H:i') }}</span>
                        </td>
                        <td class="p-4 text-sm">
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
                                    <i class="fa-solid fa-globe"></i> Online (Midtrans)
                                </span>
                            @endif
                        </td>
                        <td class="p-4 font-bold text-primary">Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
                        <td class="p-4">
                            @php
                                $statusColors = [
                                    'pending' => 'bg-gray-100 text-gray-700',
                                    'paid' => 'bg-blue-100 text-blue-700',
                                    'processed' => 'bg-accent/20 text-accent',
                                    'shipped' => 'bg-indigo-100 text-indigo-700',
                                    'completed' => 'bg-green-100 text-green-700',
                                    'cancelled' => 'bg-red-100 text-red-700',
                                ];
                                $statusLabels = [
                                    'pending' => 'Menunggu Pembayaran', 
                                    'paid' => 'Sudah Dibayar',
                                    'processed' => 'Diproses', 
                                    'shipped' => 'Dikirim',
                                    'completed' => 'Selesai', 
                                    'cancelled' => 'Dibatalkan'
                                ];
                            @endphp
                            <span class="px-3 py-1 text-xs font-bold rounded-full {{ $statusColors[$order->status] ?? 'bg-gray-100 text-gray-700' }}">
                                {{ $statusLabels[$order->status] ?? ucfirst($order->status) }}
                            </span>
                        </td>
                        <td class="p-4 text-center">
                            <div class="flex items-center justify-center gap-1.5">
                                @if($order->status === 'pending')
                                    <button disabled class="inline-flex items-center justify-center w-8 h-8 rounded bg-gray-100 text-gray-400 cursor-not-allowed opacity-50 text-xs" title="Aksi terkunci: Pelanggan belum membayar">
                                        <i class="fa-solid fa-lock"></i>
                                    </button>
                                @else
                                    <a href="{{ route('admin.orders.show', $order->id) }}" class="inline-flex items-center justify-center w-8 h-8 rounded bg-primary/10 text-primary hover:bg-primary hover:text-white transition-colors shadow-sm text-xs" title="Lihat Detail Pesanan">
                                        <i class="fa-solid fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.orders.invoice', $order->id) }}" target="_blank" class="inline-flex items-center justify-center w-8 h-8 rounded bg-gray-100 text-gray-700 hover:bg-secondary hover:text-white transition-colors shadow-sm text-xs" title="Cetak Struk / Invoice">
                                        <i class="fa-solid fa-print"></i>
                                    </a>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="p-8 text-center text-textLight">Belum ada pesanan masuk.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-4 border-t border-gray-100">
            {{ $orders->links() }}
        </div>
    </div>
</x-layouts.admin>