<x-layouts.app title="Checkout Pesanan - GaramPro">
    
    <div class="bg-white shadow-sm">
        <x-navbar />
    </div>

    <main class="pt-32 pb-24 bg-[#f8fdff] min-h-screen">
        <div class="w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="flex items-center gap-2 text-sm text-grey-text mb-8">
                <a href="{{ route('home') }}" class="hover:text-sea-blue transition-colors">Beranda</a>
                <i data-lucide="chevron-right" class="w-4 h-4"></i>
                <a href="#" onclick="toggleCartDrawer()" class="hover:text-sea-blue transition-colors">Keranjang</a>
                <i data-lucide="chevron-right" class="w-4 h-4"></i>
                <span class="text-dark-text font-medium">Checkout</span>
            </div>

            <h1 class="text-3xl lg:text-4xl font-bold font-poppins text-dark-text mb-10">
                Selesaikan <span class="text-gradient">Pesanan Anda</span>
            </h1>

            <div class="grid lg:grid-cols-12 gap-10">
                
                <div class="lg:col-span-7 xl:col-span-8">
                    <div class="bg-white rounded-3xl shadow-xl p-8 border border-light-blue">
                        <h2 class="text-xl font-bold font-poppins text-dark-text mb-6 flex items-center gap-2">
                            <i data-lucide="map-pin" class="text-sea-blue"></i> Informasi Pengiriman
                        </h2>

                        <form action="{{ route('checkout.process') }}" method="POST" id="checkout-form" class="space-y-6">
                            @csrf
                            
                            <div class="grid md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-sm font-medium text-dark-text mb-2">Nama Lengkap</label>
                                    <input type="text" name="name" required class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-sea-blue focus:ring-2 focus:ring-sea-blue/20 transition-all outline-none" placeholder="Budi Santoso">
                                </div>
                                
                                <div>
                                    <label class="block text-sm font-medium text-dark-text mb-2">No. WhatsApp / HP</label>
                                    <input type="tel" name="phone" required class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-sea-blue focus:ring-2 focus:ring-sea-blue/20 transition-all outline-none" placeholder="081234567890">
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-dark-text mb-2">Alamat Email</label>
                                <input type="email" name="email" required class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-sea-blue focus:ring-2 focus:ring-sea-blue/20 transition-all outline-none" placeholder="budi@email.com">
                                <p class="text-xs text-grey-text mt-1">Invoice dan detail pesanan akan dikirim ke email ini.</p>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-dark-text mb-2">Alamat Lengkap Pengiriman</label>
                                <textarea name="address" required rows="4" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-sea-blue focus:ring-2 focus:ring-sea-blue/20 transition-all outline-none resize-none" placeholder="Nama Jalan, RT/RW, Kelurahan, Kecamatan, Kota/Kabupaten, Provinsi, Kode Pos..."></textarea>
                            </div>

                            <div class="pt-6 border-t border-gray-100">
                                <h2 class="text-xl font-bold font-poppins text-dark-text mb-4 flex items-center gap-2">
                                    <i data-lucide="credit-card" class="text-sea-blue"></i> Metode Pembayaran
                                </h2>
                                <div class="p-4 border border-sea-blue bg-light-blue/30 rounded-xl flex items-center gap-4">
                                    <div class="w-12 h-12 bg-white rounded-full flex items-center justify-center shadow-sm">
                                        <i data-lucide="shield-check" class="text-sea-blue w-6 h-6"></i>
                                    </div>
                                    <div>
                                        <p class="font-bold text-dark-text">Pembayaran Aman via Midtrans</p>
                                        <p class="text-sm text-grey-text">GoPay, QRIS, Virtual Account, Transfer Bank</p>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="lg:col-span-5 xl:col-span-4">
                    <div class="bg-white rounded-3xl shadow-xl p-8 border border-light-blue sticky top-32">
                        <h2 class="text-xl font-bold font-poppins text-dark-text mb-6 border-b border-gray-100 pb-4">
                            Ringkasan Pesanan
                        </h2>

                        <div class="space-y-4 mb-6 max-h-[300px] overflow-y-auto pr-2">
                            @forelse($cartItems ?? [] as $id => $details)
                            <div class="flex gap-4">
                                @if(isset($details['image']))
                                    <img src="{{ asset('storage/' . $details['image']) }}" alt="Produk" class="w-16 h-16 rounded-xl object-cover border border-gray-100">
                                @else
                                    <div class="w-16 h-16 rounded-xl bg-gray-100 flex items-center justify-center">
                                        <i data-lucide="image" class="text-gray-400 w-6 h-6"></i>
                                    </div>
                                @endif
                                <div class="flex-1">
                                    <h4 class="font-bold text-dark-text text-sm line-clamp-2">{{ $details['name'] ?? 'Produk Garam' }}</h4>
                                    <p class="text-xs text-grey-text mt-1">{{ $details['quantity'] }}x @ Rp {{ number_format($details['price'], 0, ',', '.') }}</p>
                                </div>
                                <div class="font-bold text-sea-blue text-sm">
                                    Rp {{ number_format($details['price'] * $details['quantity'], 0, ',', '.') }}
                                </div>
                            </div>
                            @empty
                            <div class="flex gap-4 opacity-60">
                                <div class="w-16 h-16 rounded-xl bg-gray-100 flex items-center justify-center">
                                    <i data-lucide="package" class="text-gray-400 w-6 h-6"></i>
                                </div>
                                <div class="flex-1">
                                    <h4 class="font-bold text-dark-text text-sm">Garam Premium (Contoh)</h4>
                                    <p class="text-xs text-grey-text mt-1">1x @ Rp 150.000</p>
                                </div>
                                <div class="font-bold text-sea-blue text-sm">Rp 150.000</div>
                            </div>
                            @endforelse
                        </div>

                        <div class="border-t border-gray-100 pt-4 space-y-3 mb-6">
                            <div class="flex justify-between text-sm text-grey-text">
                                <span>Subtotal Produk</span>
                                <span>Rp {{ number_format($totalAmount ?? 150000, 0, ',', '.') }}</span>
                            </div>
                            <div class="flex justify-between text-sm text-grey-text">
                                <span>Estimasi Ongkos Kirim</span>
                                <span class="text-green-500 font-medium">Gratis</span>
                            </div>
                        </div>

                        <div class="border-t border-gray-100 pt-4 mb-8">
                            <div class="flex justify-between items-end">
                                <span class="font-bold text-dark-text">Total Bayar</span>
                                <span class="text-3xl font-bold text-sea-blue font-poppins">Rp {{ number_format($totalAmount ?? 150000, 0, ',', '.') }}</span>
                            </div>
                        </div>

                        <button onclick="document.getElementById('checkout-form').submit()" class="w-full btn-primary justify-center text-lg py-4 shadow-xl shadow-sea-blue/20 flex items-center gap-2 transition-transform hover:-translate-y-1">
                            Lanjut Pembayaran <i data-lucide="arrow-right" class="w-5 h-5"></i>
                        </button>
                    </div>
                </div>

            </div>
        </div>
    </main>

    <x-footer />
</x-layouts.app>