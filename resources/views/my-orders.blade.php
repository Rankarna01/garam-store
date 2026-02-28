<x-layouts.app title="Riwayat Pesanan Saya - GaramPro">
    
    <div class="bg-white shadow-sm">
        <x-navbar />
    </div>

    <x-cart-drawer />

    <main class="pt-32 pb-24 bg-[#f8fdff] min-h-screen">
        <div class="w-full max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="text-center mb-12">
                <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-light-blue mb-4">
                    <span class="w-2 h-2 rounded-full bg-sea-blue"></span>
                    <span class="text-sm font-medium text-deep-blue">Aktivitas Akun</span>
                </div>
                <h1 class="text-3xl lg:text-4xl font-bold font-poppins text-dark-text mb-2">
                    Riwayat <span class="text-gradient">Pesanan Saya</span>
                </h1>
                <p class="text-grey-text">Halo {{ explode(' ', auth()->user()->name)[0] }}, berikut adalah daftar belanjaan Anda.</p>
            </div>

            <div class="space-y-6">
                @forelse($orders as $order)
                    <div class="bg-white rounded-3xl shadow-lg border border-light-blue overflow-hidden transition-transform hover:-translate-y-1 duration-300">
                        <div class="bg-gray-50 px-6 py-4 border-b border-gray-100 flex flex-wrap justify-between items-center gap-4">
                            <div>
                                <span class="text-xs text-grey-text flex items-center gap-1 mb-1">
                                    <i data-lucide="calendar" class="w-3 h-3"></i> {{ $order->created_at->format('d M Y, H:i') }}
                                </span>
                                <h3 class="font-bold font-poppins text-dark-text text-lg">{{ $order->invoice_number }}</h3>
                            </div>
                            
                            @php
                                $statusColors = [
                                    'pending' => 'bg-gray-200 text-gray-700',
                                    'paid' => 'bg-blue-100 text-blue-700',
                                    'processed' => 'bg-orange-100 text-orange-700',
                                    'shipped' => 'bg-indigo-100 text-indigo-700',
                                    'completed' => 'bg-green-100 text-green-700',
                                    'cancelled' => 'bg-red-100 text-red-700',
                                ];
                                $statusLabels = [
                                    'pending' => 'Menunggu Pembayaran', 'paid' => 'Sudah Dibayar',
                                    'processed' => 'Diproses', 'shipped' => 'Dikirim',
                                    'completed' => 'Selesai', 'cancelled' => 'Dibatalkan'
                                ];
                            @endphp
                            <span class="px-4 py-1.5 text-xs font-bold rounded-full shadow-sm border border-white {{ $statusColors[$order->status] }}">
                                {{ $statusLabels[$order->status] }}
                            </span>
                        </div>
                        
                        <div class="p-6 flex flex-col md:flex-row justify-between items-center gap-6">
                            <div class="w-full md:w-auto">
                                <p class="text-sm text-grey-text mb-1">Total Pembayaran</p>
                                <p class="text-3xl font-bold text-sea-blue font-poppins">Rp {{ number_format($order->total_price, 0, ',', '.') }}</p>
                                <div class="mt-3 flex items-center gap-2 text-sm text-gray-500">
                                    <i data-lucide="map-pin" class="w-4 h-4"></i>
                                    <span class="truncate max-w-[200px]">{{ $order->customer_address }}</span>
                                </div>
                            </div>
                            
                            <div class="w-full md:w-auto flex flex-col sm:flex-row gap-3">
                                @if($order->status === 'pending')
                                    <a href="{{ route('checkout.payment', $order->invoice_number) }}" class="btn-primary justify-center text-sm py-2.5 px-6 shadow-md shadow-sea-blue/20">
                                        <i data-lucide="credit-card" class="w-4 h-4 mr-2"></i> Bayar Sekarang
                                    </a>
                                @endif
                                <a href="{{ route('order.track', $order->invoice_number) }}" class="btn-secondary justify-center text-sm py-2.5 px-6">
                                    <i data-lucide="eye" class="w-4 h-4 mr-2"></i> Detail Pesanan
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-20 bg-white rounded-3xl shadow-sm border border-light-blue">
                        <div class="w-24 h-24 bg-light-blue rounded-full flex items-center justify-center mx-auto mb-6 text-sea-blue">
                            <i data-lucide="shopping-bag" class="w-12 h-12"></i>
                        </div>
                        <h3 class="text-2xl font-bold text-dark-text mb-2 font-poppins">Keranjang Riwayat Kosong</h3>
                        <p class="text-grey-text mb-8">Anda belum pernah melakukan transaksi. Yuk, mulai belanja sekarang!</p>
                        <a href="{{ route('home') }}#products" class="btn-primary inline-flex text-lg px-8 shadow-xl shadow-sea-blue/20 transition-transform hover:-translate-y-1">
                            Mulai Belanja Garam Premium
                        </a>
                    </div>
                @endforelse
            </div>

        </div>
    </main>

    <x-footer />
</x-layouts.app>