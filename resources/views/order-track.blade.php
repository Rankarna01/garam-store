<x-layouts.app title="Lacak Pesanan - {{ $order->invoice_number }}">
    
    <div class="bg-white shadow-sm">
        <x-navbar />
    </div>

    <main class="pt-32 pb-24 bg-[#f8fdff] min-h-screen">
        <div class="w-full max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="text-center mb-10">
                <h1 class="text-3xl font-bold font-poppins text-dark-text mb-2">
                    Status <span class="text-gradient">Pesanan</span>
                </h1>
                <p class="text-grey-text">Lacak proses pesanan Anda di bawah ini</p>
            </div>

            @if(session('success'))
            <div class="mb-8 p-4 bg-green-100 border border-green-200 text-green-700 rounded-2xl flex items-center justify-center gap-2">
                <i data-lucide="check-circle" class="w-5 h-5"></i>
                <span class="font-medium">{{ session('success') }}</span>
            </div>
            @endif

            <div class="grid lg:grid-cols-3 gap-8">
                
                <div class="lg:col-span-2 space-y-8">
                    
                    <div class="bg-white rounded-3xl shadow-xl p-8 border border-light-blue">
                        <div class="flex flex-wrap justify-between items-center gap-4 mb-6 border-b border-gray-100 pb-6">
                            <div>
                                <p class="text-sm text-grey-text mb-1">Nomor Invoice</p>
                                <h3 class="text-xl font-bold text-dark-text">{{ $order->invoice_number }}</h3>
                            </div>
                            <div class="text-right">
                                <p class="text-sm text-grey-text mb-1">Tanggal Transaksi</p>
                                <p class="font-medium text-dark-text">{{ $order->created_at->format('d M Y, H:i') }}</p>
                            </div>
                        </div>

                        <div class="relative pt-4">
                            @if($order->status === 'cancelled')
                                <div class="p-4 bg-red-50 text-red-600 rounded-xl flex items-center gap-3">
                                    <i data-lucide="x-circle" class="w-8 h-8"></i>
                                    <div>
                                        <h4 class="font-bold">Pesanan Dibatalkan</h4>
                                        <p class="text-sm">Transaksi ini telah dibatalkan atau kedaluwarsa.</p>
                                    </div>
                                </div>
                            @else
                                @php
                                    $statuses = ['pending', 'paid', 'processed', 'shipped', 'completed'];
                                    $currentIndex = array_search($order->status, $statuses);
                                @endphp
                                
                                <div class="flex flex-col md:flex-row justify-between relative z-10">
                                    
                                    <div class="flex flex-col items-center mb-6 md:mb-0 relative w-full">
                                        <div class="w-10 h-10 rounded-full flex items-center justify-center {{ $currentIndex >= 0 ? 'bg-sea-blue text-white shadow-lg shadow-sea-blue/30' : 'bg-gray-100 text-gray-400' }} z-10 relative transition-colors duration-500">
                                            <i data-lucide="clock" class="w-5 h-5"></i>
                                        </div>
                                        <p class="text-xs font-medium text-center mt-3 {{ $currentIndex >= 0 ? 'text-dark-text' : 'text-grey-text' }}">Menunggu<br>Pembayaran</p>
                                        <div class="hidden md:block absolute top-5 left-[50%] w-full h-1 {{ $currentIndex >= 1 ? 'bg-sea-blue' : 'bg-gray-100' }} -z-0"></div>
                                    </div>

                                    <div class="flex flex-col items-center mb-6 md:mb-0 relative w-full">
                                        <div class="w-10 h-10 rounded-full flex items-center justify-center {{ $currentIndex >= 1 ? 'bg-sea-blue text-white shadow-lg shadow-sea-blue/30' : 'bg-gray-100 text-gray-400' }} z-10 relative transition-colors duration-500">
                                            <i data-lucide="wallet" class="w-5 h-5"></i>
                                        </div>
                                        <p class="text-xs font-medium text-center mt-3 {{ $currentIndex >= 1 ? 'text-dark-text' : 'text-grey-text' }}">Sudah<br>Dibayar</p>
                                        <div class="hidden md:block absolute top-5 left-[50%] w-full h-1 {{ $currentIndex >= 2 ? 'bg-sea-blue' : 'bg-gray-100' }} -z-0"></div>
                                    </div>

                                    <div class="flex flex-col items-center mb-6 md:mb-0 relative w-full">
                                        <div class="w-10 h-10 rounded-full flex items-center justify-center {{ $currentIndex >= 2 ? 'bg-sea-blue text-white shadow-lg shadow-sea-blue/30' : 'bg-gray-100 text-gray-400' }} z-10 relative transition-colors duration-500">
                                            <i data-lucide="package" class="w-5 h-5"></i>
                                        </div>
                                        <p class="text-xs font-medium text-center mt-3 {{ $currentIndex >= 2 ? 'text-dark-text' : 'text-grey-text' }}">Sedang<br>Diproses</p>
                                        <div class="hidden md:block absolute top-5 left-[50%] w-full h-1 {{ $currentIndex >= 3 ? 'bg-sea-blue' : 'bg-gray-100' }} -z-0"></div>
                                    </div>

                                    <div class="flex flex-col items-center mb-6 md:mb-0 relative w-full">
                                        <div class="w-10 h-10 rounded-full flex items-center justify-center {{ $currentIndex >= 3 ? 'bg-sea-blue text-white shadow-lg shadow-sea-blue/30' : 'bg-gray-100 text-gray-400' }} z-10 relative transition-colors duration-500">
                                            <i data-lucide="truck" class="w-5 h-5"></i>
                                        </div>
                                        <p class="text-xs font-medium text-center mt-3 {{ $currentIndex >= 3 ? 'text-dark-text' : 'text-grey-text' }}">Pesanan<br>Dikirim</p>
                                        <div class="hidden md:block absolute top-5 left-[50%] w-full h-1 {{ $currentIndex >= 4 ? 'bg-sea-blue' : 'bg-gray-100' }} -z-0"></div>
                                    </div>

                                    <div class="flex flex-col items-center relative w-full">
                                        <div class="w-10 h-10 rounded-full flex items-center justify-center {{ $currentIndex >= 4 ? 'bg-green-500 text-white shadow-lg shadow-green-500/30' : 'bg-gray-100 text-gray-400' }} z-10 relative transition-colors duration-500">
                                            <i data-lucide="check-circle-2" class="w-5 h-5"></i>
                                        </div>
                                        <p class="text-xs font-medium text-center mt-3 {{ $currentIndex >= 4 ? 'text-green-600' : 'text-grey-text' }}">Pesanan<br>Selesai</p>
                                    </div>

                                </div>
                            @endif
                        </div>
                    </div>

                    @if($order->status === 'shipped' || $order->status === 'completed')
                    <div class="bg-gradient-to-br from-sea-blue to-deep-blue rounded-3xl shadow-xl p-8 text-white relative overflow-hidden">
                        <div class="relative z-10">
                            <h3 class="text-lg font-bold mb-2 flex items-center gap-2">
                                <i data-lucide="truck" class="w-5 h-5"></i> Nomor Resi Pengiriman
                            </h3>
                            <p class="text-white/80 text-sm mb-4">Pesanan Anda sedang dalam perjalanan. Gunakan nomor resi berikut untuk melacak paket di situs kurir.</p>
                            <div class="bg-white/10 p-4 rounded-xl backdrop-blur-sm border border-white/20 flex justify-between items-center">
                                <span class="text-2xl font-bold font-poppins tracking-wider">{{ $order->tracking_number ?? 'Belum Diinput' }}</span>
                                <button onclick="navigator.clipboard.writeText('{{ $order->tracking_number }}'); alert('Resi disalin!');" class="p-2 hover:bg-white/20 rounded-lg transition-colors" title="Salin Resi">
                                    <i data-lucide="copy" class="w-5 h-5"></i>
                                </button>
                            </div>
                        </div>
                        <i data-lucide="box" class="absolute -bottom-4 -right-4 w-32 h-32 text-white/5 pointer-events-none transform -rotate-12"></i>
                    </div>
                    @endif

                    <div class="bg-white rounded-3xl shadow-xl p-8 border border-light-blue">
                        <h3 class="text-lg font-bold font-poppins text-dark-text mb-4 border-b border-gray-100 pb-4 flex items-center gap-2">
                            <i data-lucide="map-pin" class="text-sea-blue"></i> Informasi Pengiriman
                        </h3>
                        <div class="grid md:grid-cols-2 gap-6 text-sm">
                            <div>
                                <p class="text-grey-text mb-1">Nama Penerima</p>
                                <p class="font-semibold text-dark-text">{{ $order->customer_name }}</p>
                            </div>
                            <div>
                                <p class="text-grey-text mb-1">Nomor Kontak</p>
                                <p class="font-semibold text-dark-text">{{ $order->customer_phone }}</p>
                            </div>
                            <div class="md:col-span-2">
                                <p class="text-grey-text mb-1">Alamat Lengkap</p>
                                <p class="font-medium text-dark-text leading-relaxed">{{ $order->customer_address }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="lg:col-span-1">
                    <div class="bg-white rounded-3xl shadow-xl p-6 border border-light-blue sticky top-32">
                        <h3 class="text-lg font-bold font-poppins text-dark-text mb-4 border-b border-gray-100 pb-4">
                            Rincian Pembelian
                        </h3>
                        
                        <div class="space-y-4 mb-6">
                            @foreach($order->items as $item)
                            <div class="flex justify-between items-start gap-4">
                                <div class="flex-1">
                                    <h4 class="font-semibold text-dark-text text-sm line-clamp-2">{{ $item->product_name }}</h4>
                                    <p class="text-xs text-grey-text mt-1">{{ $item->quantity }}x @ Rp {{ number_format($item->price, 0, ',', '.') }}</p>
                                </div>
                                <div class="font-bold text-sea-blue text-sm whitespace-nowrap">
                                    Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}
                                </div>
                            </div>
                            @endforeach
                        </div>

                        <div class="border-t border-gray-100 pt-4 mt-6">
                            <div class="flex justify-between items-end">
                                <span class="font-bold text-dark-text">Total Bayar</span>
                                <span class="text-2xl font-bold text-sea-blue font-poppins">Rp {{ number_format($order->total_price, 0, ',', '.') }}</span>
                            </div>
                        </div>
                        
                        @if($order->status === 'pending')
                            <div class="mt-6 p-4 bg-orange-50 border border-orange-200 rounded-xl text-center">
                                <p class="text-sm text-orange-700 font-medium mb-3">Pesanan Anda belum dibayar.</p>
                                <a href="{{ route('checkout.payment', $order->invoice_number) }}" class="inline-block w-full py-2 bg-orange-500 hover:bg-orange-600 text-white rounded-lg font-semibold transition-colors">
                                    Lanjutkan Pembayaran
                                </a>
                            </div>
                        @endif

                    </div>
                </div>

            </div>
            
            <div class="text-center mt-10">
                <p class="text-sm text-grey-text mb-4">Simpan link halaman ini untuk mengecek status pesanan Anda secara berkala.</p>
                <a href="{{ route('home') }}" class="inline-flex items-center gap-2 text-sea-blue font-medium hover:underline">
                    <i data-lucide="arrow-left" class="w-4 h-4"></i> Kembali ke Beranda
                </a>
            </div>

        </div>
    </main>

    <x-footer />
</x-layouts.app>