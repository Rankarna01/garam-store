@props(['products'])

<section id="products" class="relative py-20 lg:py-32 overflow-hidden bg-gradient-to-b from-white to-[#f8fdff]">
    <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[800px] h-[800px] rounded-full bg-light-blue blur-3xl opacity-30"></div>
    
    <div class="relative z-10 w-full px-4 sm:px-6 lg:px-8 xl:px-16 2xl:px-24">
        <div class="text-center mb-16">
            <div class="animate-product-header inline-flex items-center gap-2 px-4 py-2 rounded-full bg-light-blue mb-4 opacity-0 translate-y-5">
                <span class="w-2 h-2 rounded-full bg-sea-blue"></span>
                <span class="text-sm font-medium text-deep-blue">Produk Kami</span>
            </div>
            
            <h2 class="animate-product-header text-3xl sm:text-4xl lg:text-5xl font-bold font-poppins text-dark-text mb-4 opacity-0 translate-y-5">
                Temukan <span class="text-gradient">Koleksi Premium</span> Kami
            </h2>
            
            <p class="animate-product-header text-grey-text text-lg max-w-2xl mx-auto opacity-0 translate-y-5">
                Jelajahi berbagai pilihan garam alami kami, masing-masing dengan cerita dan profil rasa unik, bersumber dengan hati-hati dari lokasi terbaik di seluruh dunia.
            </p>
        </div>
        
        <div id="cart-indicator" class="fixed bottom-6 right-6 z-50 hidden cursor-pointer">
            <div class="bg-gradient-to-br from-sea-blue to-deep-blue text-white px-6 py-3 rounded-full shadow-lg flex items-center gap-3 transition-transform hover:scale-105">
                <i data-lucide="shopping-cart" class="w-5 h-5"></i>
                <span id="cart-count" class="font-medium">0 item di keranjang</span>
            </div>
        </div>
        
        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6 lg:gap-8">
            
            @forelse($products as $product)
            <div class="product-card product-item opacity-0 translate-y-10">
                <div class="relative h-56 overflow-hidden group">
                    @if($product->image)
                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full bg-gray-200 flex items-center justify-center text-gray-400">
                            <i data-lucide="image" class="w-12 h-12"></i>
                        </div>
                    @endif
                    
                    <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    
                    <div class="absolute top-4 left-4">
                        <span class="px-3 py-1 rounded-full bg-white/90 backdrop-blur-sm text-xs font-medium text-deep-blue">Garam Premium</span>
                    </div>
                    
                    @if($product->original_price > $product->price)
                    <div class="absolute top-4 right-4">
                        <span class="px-3 py-1 rounded-full bg-red-500 text-white text-xs font-medium">Diskon</span>
                    </div>
                    @endif
                    
                    <a href="{{ route('product.show', $product->slug) }}" class="absolute bottom-4 left-1/2 -translate-x-1/2 px-6 py-2 bg-white rounded-full text-sm font-medium text-dark-text opacity-0 group-hover:opacity-100 transition-all duration-300 translate-y-4 group-hover:translate-y-0 shadow-lg whitespace-nowrap">
                        Lihat Detail
                    </a>
                </div>
                <div class="p-6">
                    <div class="flex items-center gap-1 mb-2">
                        <i data-lucide="star" class="w-4 h-4 text-yellow-400 fill-yellow-400"></i>
                        <i data-lucide="star" class="w-4 h-4 text-yellow-400 fill-yellow-400"></i>
                        <i data-lucide="star" class="w-4 h-4 text-yellow-400 fill-yellow-400"></i>
                        <i data-lucide="star" class="w-4 h-4 text-yellow-400 fill-yellow-400"></i>
                        <i data-lucide="star" class="w-4 h-4 text-yellow-400 fill-yellow-400"></i>
                    </div>
                    <h3 class="text-lg font-bold text-dark-text font-poppins mb-1">{{ $product->name }}</h3>
                    <p class="text-sm text-grey-text mb-3">{{ $product->weight }} gram</p>
                    <p class="text-sm text-grey-text line-clamp-2 mb-4">{{ Str::limit($product->description, 80) }}</p>
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <span class="text-2xl font-bold text-sea-blue font-poppins">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                            @if($product->original_price > $product->price)
                                <span class="text-sm text-grey-text line-through">Rp {{ number_format($product->original_price, 0, ',', '.') }}</span>
                            @endif
                        </div>
                        <button onclick="addToCart({{ $product->id }}, '{{ $product->name }}')" class="w-10 h-10 rounded-full bg-light-blue flex items-center justify-center hover:bg-sea-blue hover:text-white transition-all duration-300 add-to-cart-btn shrink-0">
                            <i data-lucide="shopping-cart" class="w-5 h-5"></i>
                        </button>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-span-full text-center py-12">
                <i data-lucide="package-open" class="w-16 h-16 text-gray-300 mx-auto mb-4"></i>
                <p class="text-gray-500 text-lg">Belum ada produk yang tersedia saat ini.</p>
            </div>
            @endforelse
            
        </div>
    </div>
</section>