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
                        <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-light-blue mb-6 w-max">
                            <span class="w-2 h-2 rounded-full bg-sea-blue"></span>
                            <span class="text-sm font-medium text-deep-blue">Stok: {{ $product->stock }} tersedia</span>
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

                        <div class="mb-8">
                            <h3 class="font-bold text-dark-text mb-2">Informasi Produk:</h3>
                            <ul class="space-y-2 text-grey-text text-sm">
                                <li><strong class="text-dark-text">Berat Bersih:</strong> {{ $product->weight }} KG</li>
                                <li><strong class="text-dark-text">Kategori:</strong> Garam Laut Alami</li>
                            </ul>
                        </div>

                        <div class="mb-10">
                            <h3 class="font-bold text-dark-text mb-2">Deskripsi:</h3>
                            <p class="text-grey-text leading-relaxed">
                                {{ $product->description ?? 'Garam kualitas premium yang diproses secara alami untuk mempertahankan kandungan mineral terbaik bagi kesehatan keluarga Anda.' }}
                            </p>
                        </div>

                        <div class="mt-auto">
                            <button onclick="addToCart({{ $product->id }}, '{{ $product->name }}')" class="btn-primary w-full justify-center text-lg py-4 shadow-xl shadow-sea-blue/20">
                                <i data-lucide="shopping-cart" class="w-6 h-6 mr-2"></i>
                                Tambahkan ke Keranjang
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <x-footer />

    <script>
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

        function toggleCartDrawer() {
            const drawer = document.getElementById('cart-drawer');
            const overlay = document.getElementById('cart-drawer-overlay');
            
            if (drawer.classList.contains('translate-x-full')) {
                overlay.classList.remove('hidden');
                setTimeout(() => overlay.classList.remove('opacity-0'), 10);
                drawer.classList.remove('translate-x-full');
            } else {
                overlay.classList.add('opacity-0');
                drawer.classList.add('translate-x-full');
                setTimeout(() => overlay.classList.add('hidden'), 300);
            }
        }

        let cartItems = 0; // Simulasi sementara
        function addToCart(productId, productName) {
            cartItems++;
            alert(`${productName} berhasil ditambahkan ke keranjang!`);
            toggleCartDrawer(); 
            // Nanti disini tempat panggil fetch('/cart/add')
        }
    </script>
</x-layouts.app>