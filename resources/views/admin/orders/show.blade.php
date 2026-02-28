<x-layouts.admin title="Detail Pesanan" header="Detail Pesanan: {{ $order->invoice_number }}">

    @if(session('success'))
        <div class="mb-4 p-4 bg-green-100 border border-green-200 text-green-700 rounded-xl flex items-center gap-2">
            <i class="fa-solid fa-circle-check"></i> {{ session('success') }}
        </div>
    @endif

    <div class="flex items-center gap-4 mb-6">
        <a href="{{ route('admin.orders.index') }}" class="text-textLight hover:text-primary transition-colors flex items-center gap-2">
            <i class="fa-solid fa-arrow-left"></i> Kembali ke Daftar
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <div class="lg:col-span-2 space-y-6">
            
            <div class="bg-surface rounded-xl shadow-sm border border-gray-100 p-6">
                <h3 class="text-lg font-semibold text-secondary mb-4 border-b border-gray-100 pb-2">Informasi Pelanggan</h3>
                <div class="grid grid-cols-2 gap-4 text-sm">
                    <div>
                        <p class="text-textLight mb-1">Nama Pembeli</p>
                        <p class="font-medium text-textDark">{{ $order->customer_name }}</p>
                    </div>
                    <div>
                        <p class="text-textLight mb-1">Email</p>
                        <p class="font-medium text-textDark">{{ $order->customer_email }}</p>
                    </div>
                    <div>
                        <p class="text-textLight mb-1">No. WhatsApp / HP</p>
                        <p class="font-medium text-textDark">{{ $order->customer_phone }}</p>
                    </div>
                    <div class="col-span-2">
                        <p class="text-textLight mb-1">Alamat Pengiriman</p>
                        <p class="font-medium text-textDark">{{ $order->customer_address }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-surface rounded-xl shadow-sm border border-gray-100 p-6">
                <h3 class="text-lg font-semibold text-secondary mb-4 border-b border-gray-100 pb-2">Daftar Barang</h3>
                <div class="space-y-4">
                    @foreach($order->items as $item)
                    <div class="flex justify-between items-center py-2 border-b border-gray-50 last:border-0">
                        <div>
                            <p class="font-semibold text-textDark">{{ $item->product_name }}</p>
                            <p class="text-xs text-textLight">{{ $item->quantity }}x @ Rp {{ number_format($item->price, 0, ',', '.') }}</p>
                        </div>
                        <div class="font-medium text-primary">
                            Rp {{ number_format($item->quantity * $item->price, 0, ',', '.') }}
                        </div>
                    </div>
                    @endforeach
                </div>
                <div class="mt-4 pt-4 border-t border-gray-100 flex justify-between items-center">
                    <p class="font-bold text-textDark">Total Pembayaran</p>
                    <p class="text-xl font-bold text-primary">Rp {{ number_format($order->total_price, 0, ',', '.') }}</p>
                </div>
            </div>
        </div>

        <div class="space-y-6">
            <div class="bg-surface rounded-xl shadow-sm border border-gray-100 p-6">
                <h3 class="text-lg font-semibold text-secondary mb-4 border-b border-gray-100 pb-2">Update Pesanan</h3>
                
                <form action="{{ route('admin.orders.update', $order->id) }}" method="POST" class="space-y-4">
                    @csrf
                    @method('PUT')
                    
                    <div>
                        <label class="block text-sm font-medium text-textDark mb-2">Status Pesanan</label>
                        <select name="status" class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary outline-none text-sm">
                            <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Menunggu Pembayaran</option>
                            <option value="paid" {{ $order->status == 'paid' ? 'selected' : '' }}>Sudah Dibayar</option>
                            <option value="processed" {{ $order->status == 'processed' ? 'selected' : '' }}>Sedang Diproses</option>
                            <option value="shipped" {{ $order->status == 'shipped' ? 'selected' : '' }}>Dikirim</option>
                            <option value="completed" {{ $order->status == 'completed' ? 'selected' : '' }}>Selesai</option>
                            <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Dibatalkan</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-textDark mb-2">Nomor Resi Pengiriman</label>
                        <input type="text" name="tracking_number" value="{{ $order->tracking_number }}" class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary outline-none text-sm" placeholder="Contoh: JNT123456789">
                        <p class="text-xs text-textLight mt-1">Isi jika status diubah menjadi Dikirim.</p>
                    </div>

                    <button type="submit" class="w-full bg-primary hover:bg-secondary text-white py-2 rounded-lg text-sm font-medium transition-colors flex justify-center items-center gap-2">
                        <i class="fa-solid fa-floppy-disk"></i> Simpan Perubahan
                    </button>
                </form>
            </div>
        </div>

    </div>
</x-layouts.admin>