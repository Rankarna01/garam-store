<x-layouts.app title="{{ $product->name }} - GaramPro">
    
    <div class="bg-white shadow-sm">
        <x-navbar />
    </div>

    <x-cart-drawer />

    <main class="pt-32 pb-20 bg-[#f8fdff] min-h-screen">
        <div class="w-full px-4 sm:px-6 lg:px-8 xl:px-16 2xl:px-24">
            
            <div class="flex items-center gap-2 text-sm text-grey-text mb-8">
                <a href="{{ route('home') }}" class="hover:text-sea-blue transition-colors">Beranda</a>
                <i data-lucide="chevron-right" class="w-4 h-4"></i>
                <a href="{{ route('home') }}#products" class="hover:text-sea-blue transition-colors">Produk</a>
                <i data-lucide="chevron-right" class="w-4 h-4"></i>
                <span class="text-dark-text font-medium">{{ $product->name }}</span>
            </div>

            <div class="bg-white rounded-3xl shadow-xl overflow-hidden">
                <div class="grid md:grid-cols-2 gap-0">
                    
                    <div class="relative h-[400px] md:h-full min-h-[500px] bg-gray-50">
                        @if($product->image)
                            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-gray-300">
                                <i data-lucide="image" class="w-24 h-24"></i>
                            </div>
                        @endif
                        
                        @if($product->original_price > $product->price)
                        <div class="absolute top-6 right-6 px-4 py-2 bg-red-500 text-white font-bold rounded-full shadow-lg">
                            Sedang Diskon!
                        </div>
                        @endif
                    </div>

                    <div class="p-8 md:p-12 lg:p-16 flex flex-col justify-center">
                        <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full {{ $product->stock > 0 ? 'bg-light-blue' : 'bg-red-50' }} mb-6 w-max">
                            <span class="w-2 h-2 rounded-full {{ $product->stock > 0 ? 'bg-sea-blue' : 'bg-red-500' }}"></span>
                            <span class="text-sm font-medium {{ $product->stock > 0 ? 'text-deep-blue' : 'text-red-600' }}">
                                @if($product->stock > 0)
                                    Stok: {{ $product->stock }} tersedia
                                @else
                                    Stok Habis
                                @endif
                            </span>
                        </div>

                        <h1 class="text-3xl lg:text-4xl font-bold font-poppins text-dark-text mb-4">
                            {{ $product->name }}
                        </h1>
                        
                        <div class="flex items-center gap-1 mb-6">
                            <i data-lucide="star" class="w-5 h-5 text-yellow-400 fill-yellow-400"></i>
                            <i data-lucide="star" class="w-5 h-5 text-yellow-400 fill-yellow-400"></i>
                            <i data-lucide="star" class="w-5 h-5 text-yellow-400 fill-yellow-400"></i>
                            <i data-lucide="star" class="w-5 h-5 text-yellow-400 fill-yellow-400"></i>
                            <i data-lucide="star" class="w-5 h-5 text-yellow-400 fill-yellow-400"></i>
                            <span class="text-sm text-grey-text ml-2">(Berdasarkan 100+ ulasan)</span>
                        </div>

                        <div class="flex items-end gap-4 mb-8 pb-8 border-b border-gray-100">
                            <span class="text-4xl font-bold text-sea-blue font-poppins">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                            @if($product->original_price > $product->price)
                                <span class="text-xl text-grey-text line-through mb-1">Rp {{ number_format($product->original_price, 0, ',', '.') }}</span>
                            @endif
                        </div>

                        <div class="mb-6">
                            <h3 class="font-bold text-dark-text mb-2">Informasi Produk:</h3>
                            <ul class="space-y-2 text-grey-text text-sm">
                                <li><strong class="text-dark-text">Berat Bersih:</strong> {{ $product->weight }} KG</li>
                                <li><strong class="text-dark-text">Kategori:</strong> Garam Laut Alami</li>
                            </ul>
                        </div>

                        <div class="mb-8">
                            <h3 class="font-bold text-dark-text mb-2">Deskripsi:</h3>
                            <p class="text-grey-text leading-relaxed">
                                {{ $product->description ?? 'Garam kualitas premium yang diproses secara alami untuk mempertahankan kandungan mineral terbaik bagi kesehatan keluarga Anda.' }}
                            </p>
                        </div>

                        @if($product->stock > 0)
                        <div class="mb-8 flex items-center gap-4">
                            <span class="font-medium text-dark-text text-sm">Jumlah:</span>
                            <div class="flex items-center border border-light-blue rounded-xl overflow-hidden bg-[#f8fdff]">
                                <button type="button" onclick="decrementDetailQty()" class="px-4 py-2 hover:bg-light-blue text-dark-text font-bold transition-colors">-</button>
                                <input type="number" id="detail-qty" value="1" min="1" max="{{ $product->stock }}" class="w-16 py-2 text-center text-sm font-semibold bg-transparent outline-none" onchange="validateDetailQty(this, {{ $product->stock }})">
                                <button type="button" onclick="incrementDetailQty({{ $product->stock }})" class="px-4 py-2 hover:bg-light-blue text-dark-text font-bold transition-colors">+</button>
                            </div>
                            <span class="text-xs text-grey-text">Maks: {{ $product->stock }}</span>
                        </div>

                        <div class="mt-auto">
                            <button onclick="addToCart({{ $product->id }}, '{{ addslashes($product->name) }}', parseInt(document.getElementById('detail-qty').value) || 1)" class="btn-primary w-full justify-center text-lg py-4 shadow-xl shadow-sea-blue/20 flex items-center gap-2">
                                <i data-lucide="shopping-cart" class="w-6 h-6"></i>
                                Tambahkan ke Keranjang
                            </button>
                        </div>
                        @else
                        <div class="mt-auto">
                            <button disabled class="w-full bg-gray-200 text-gray-400 rounded-full py-4 text-lg font-medium cursor-not-allowed flex items-center justify-center gap-2 shadow-none">
                                <i data-lucide="slash" class="w-6 h-6"></i>
                                Stok Habis
                            </button>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </main>

    <x-footer />

    <script>
        function decrementDetailQty() {
            const el = document.getElementById('detail-qty');
            if (el) {
                let val = parseInt(el.value) || 1;
                if (val > 1) el.value = val - 1;
            }
        }
        function incrementDetailQty(maxStock) {
            const el = document.getElementById('detail-qty');
            if (el) {
                let val = parseInt(el.value) || 1;
                if (val < maxStock) {
                    el.value = val + 1;
                } else {
                    alert(`Maksimal pesanan sesuai stok adalah ${maxStock}`);
                }
            }
        }
        function validateDetailQty(el, maxStock) {
            let val = parseInt(el.value) || 1;
            if (val < 1) el.value = 1;
            if (val > maxStock) {
                alert(`Maksimal pesanan sesuai stok adalah ${maxStock}`);
                el.value = maxStock;
            }
        }
    </script>
</x-layouts.app>