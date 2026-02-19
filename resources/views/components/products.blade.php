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
        
        <div id="cart-indicator" class="fixed bottom-6 right-6 z-50 hidden">
            <div class="bg-gradient-to-br from-sea-blue to-deep-blue text-white px-6 py-3 rounded-full shadow-lg flex items-center gap-3">
                <i data-lucide="shopping-cart" class="w-5 h-5"></i>
                <span id="cart-count" class="font-medium">0 item di keranjang</span>
            </div>
        </div>
        
        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6 lg:gap-8">
            
            <div class="product-card product-item opacity-0 translate-y-10">
                <div class="relative h-56 overflow-hidden">
                    <img src="{{ asset('images/fine-table-salt.jpg') }}" alt="Garam Meja Halus" class="w-full h-full object-cover">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/30 to-transparent opacity-0 hover:opacity-100 transition-opacity duration-300"></div>
                    <div class="absolute top-4 left-4">
                        <span class="px-3 py-1 rounded-full bg-white/90 backdrop-blur-sm text-xs font-medium text-deep-blue">Garam Meja</span>
                    </div>
                    <div class="absolute top-4 right-4">
                        <span class="px-3 py-1 rounded-full bg-red-500 text-white text-xs font-medium">Diskon</span>
                    </div>
                    <button onclick="openProductModal(1)" class="absolute bottom-4 left-1/2 -translate-x-1/2 px-6 py-2 bg-white rounded-full text-sm font-medium text-dark-text opacity-0 hover:opacity-100 transition-all duration-300 translate-y-4 hover:translate-y-0 shadow-lg">
                        Lihat Cepat
                    </button>
                </div>
                <div class="p-6">
                    <div class="flex items-center gap-1 mb-2">
                        <i data-lucide="star" class="w-4 h-4 text-yellow-400 fill-yellow-400"></i>
                        <i data-lucide="star" class="w-4 h-4 text-yellow-400 fill-yellow-400"></i>
                        <i data-lucide="star" class="w-4 h-4 text-yellow-400 fill-yellow-400"></i>
                        <i data-lucide="star" class="w-4 h-4 text-yellow-400 fill-yellow-400"></i>
                        <i data-lucide="star" class="w-4 h-4 text-yellow-400 fill-yellow-400"></i>
                        <span class="text-sm text-grey-text ml-1">(4.8)</span>
                    </div>
                    <h3 class="text-lg font-bold text-dark-text font-poppins mb-1">Garam Meja Halus</h3>
                    <p class="text-sm text-grey-text mb-3">1 kg</p>
                    <p class="text-sm text-grey-text line-clamp-2 mb-4">Garam meja halus beryodium premium, sempurna untuk memasak sehari-hari. Larut dengan cepat dan merata.</p>
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <span class="text-2xl font-bold text-sea-blue font-poppins">Rp 180.000</span>
                            <span class="text-sm text-grey-text line-through">Rp 225.000</span>
                        </div>
                        <button onclick="addToCart(1, 'Garam Meja Halus')" class="w-10 h-10 rounded-full bg-light-blue flex items-center justify-center hover:bg-sea-blue hover:text-white transition-all duration-300 add-to-cart-btn">
                            <i data-lucide="shopping-cart" class="w-5 h-5"></i>
                        </button>
                    </div>
                </div>
            </div>
            
            <div class="product-card product-item opacity-0 translate-y-10">
                <div class="relative h-56 overflow-hidden">
                    <img src="{{ asset('images/coarse-sea-salt.jpg') }}" alt="Garam Laut Kasar" class="w-full h-full object-cover">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/30 to-transparent opacity-0 hover:opacity-100 transition-opacity duration-300"></div>
                    <div class="absolute top-4 left-4">
                        <span class="px-3 py-1 rounded-full bg-white/90 backdrop-blur-sm text-xs font-medium text-deep-blue">Garam Laut</span>
                    </div>
                    <button onclick="openProductModal(2)" class="absolute bottom-4 left-1/2 -translate-x-1/2 px-6 py-2 bg-white rounded-full text-sm font-medium text-dark-text opacity-0 hover:opacity-100 transition-all duration-300 translate-y-4 hover:translate-y-0 shadow-lg">
                        Lihat Cepat
                    </button>
                </div>
                <div class="p-6">
                    <div class="flex items-center gap-1 mb-2">
                        <i data-lucide="star" class="w-4 h-4 text-yellow-400 fill-yellow-400"></i>
                        <i data-lucide="star" class="w-4 h-4 text-yellow-400 fill-yellow-400"></i>
                        <i data-lucide="star" class="w-4 h-4 text-yellow-400 fill-yellow-400"></i>
                        <i data-lucide="star" class="w-4 h-4 text-yellow-400 fill-yellow-400"></i>
                        <i data-lucide="star" class="w-4 h-4 text-yellow-400 fill-yellow-400"></i>
                        <span class="text-sm text-grey-text ml-1">(4.9)</span>
                    </div>
                    <h3 class="text-lg font-bold text-dark-text font-poppins mb-1">Garam Laut Kasar</h3>
                    <p class="text-sm text-grey-text mb-3">500g</p>
                    <p class="text-sm text-grey-text line-clamp-2 mb-4">Kristal garam laut kasar alami, ideal untuk digiling, dipanggang, dan taburan akhir hidangan.</p>
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <span class="text-2xl font-bold text-sea-blue font-poppins">Rp 225.000</span>
                        </div>
                        <button onclick="addToCart(2, 'Garam Laut Kasar')" class="w-10 h-10 rounded-full bg-light-blue flex items-center justify-center hover:bg-sea-blue hover:text-white transition-all duration-300 add-to-cart-btn">
                            <i data-lucide="shopping-cart" class="w-5 h-5"></i>
                        </button>
                    </div>
                </div>
            </div>
            
            <div class="product-card product-item opacity-0 translate-y-10">
                <div class="relative h-56 overflow-hidden">
                    <img src="{{ asset('images/himalayan-pink-salt.jpg') }}" alt="Garam Merah Muda Himalaya" class="w-full h-full object-cover">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/30 to-transparent opacity-0 hover:opacity-100 transition-opacity duration-300"></div>
                    <div class="absolute top-4 left-4">
                        <span class="px-3 py-1 rounded-full bg-white/90 backdrop-blur-sm text-xs font-medium text-deep-blue">Spesial</span>
                    </div>
                    <div class="absolute top-4 right-4">
                        <span class="px-3 py-1 rounded-full bg-red-500 text-white text-xs font-medium">Diskon</span>
                    </div>
                    <button onclick="openProductModal(3)" class="absolute bottom-4 left-1/2 -translate-x-1/2 px-6 py-2 bg-white rounded-full text-sm font-medium text-dark-text opacity-0 hover:opacity-100 transition-all duration-300 translate-y-4 hover:translate-y-0 shadow-lg">
                        Lihat Cepat
                    </button>
                </div>
                <div class="p-6">
                    <div class="flex items-center gap-1 mb-2">
                        <i data-lucide="star" class="w-4 h-4 text-yellow-400 fill-yellow-400"></i>
                        <i data-lucide="star" class="w-4 h-4 text-yellow-400 fill-yellow-400"></i>
                        <i data-lucide="star" class="w-4 h-4 text-yellow-400 fill-yellow-400"></i>
                        <i data-lucide="star" class="w-4 h-4 text-yellow-400 fill-yellow-400"></i>
                        <i data-lucide="star" class="w-4 h-4 text-yellow-400 fill-yellow-400"></i>
                        <span class="text-sm text-grey-text ml-1">(5.0)</span>
                    </div>
                    <h3 class="text-lg font-bold text-dark-text font-poppins mb-1">Garam Merah Muda Himalaya</h3>
                    <p class="text-sm text-grey-text mb-3">500g</p>
                    <p class="text-sm text-grey-text line-clamp-2 mb-4">Garam merah muda Himalaya kuno yang kaya mineral. Memberikan sentuhan manis halus dan warna indah.</p>
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <span class="text-2xl font-bold text-sea-blue font-poppins">Rp 270.000</span>
                            <span class="text-sm text-grey-text line-through">Rp 330.000</span>
                        </div>
                        <button onclick="addToCart(3, 'Garam Merah Muda Himalaya')" class="w-10 h-10 rounded-full bg-light-blue flex items-center justify-center hover:bg-sea-blue hover:text-white transition-all duration-300 add-to-cart-btn">
                            <i data-lucide="shopping-cart" class="w-5 h-5"></i>
                        </button>
                    </div>
                </div>
            </div>
            
            <div class="product-card product-item opacity-0 translate-y-10">
                <div class="relative h-56 overflow-hidden">
                    <img src="{{ asset('images/smoked-sea-salt.jpg') }}" alt="Garam Laut Asap" class="w-full h-full object-cover">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/30 to-transparent opacity-0 hover:opacity-100 transition-opacity duration-300"></div>
                    <div class="absolute top-4 left-4">
                        <span class="px-3 py-1 rounded-full bg-white/90 backdrop-blur-sm text-xs font-medium text-deep-blue">Gourmet</span>
                    </div>
                    <button onclick="openProductModal(4)" class="absolute bottom-4 left-1/2 -translate-x-1/2 px-6 py-2 bg-white rounded-full text-sm font-medium text-dark-text opacity-0 hover:opacity-100 transition-all duration-300 translate-y-4 hover:translate-y-0 shadow-lg">
                        Lihat Cepat
                    </button>
                </div>
                <div class="p-6">
                    <div class="flex items-center gap-1 mb-2">
                        <i data-lucide="star" class="w-4 h-4 text-yellow-400 fill-yellow-400"></i>
                        <i data-lucide="star" class="w-4 h-4 text-yellow-400 fill-yellow-400"></i>
                        <i data-lucide="star" class="w-4 h-4 text-yellow-400 fill-yellow-400"></i>
                        <i data-lucide="star" class="w-4 h-4 text-yellow-400 fill-yellow-400"></i>
                        <i data-lucide="star" class="w-4 h-4 text-grey-300"></i>
                        <span class="text-sm text-grey-text ml-1">(4.7)</span>
                    </div>
                    <h3 class="text-lg font-bold text-dark-text font-poppins mb-1">Garam Laut Asap</h3>
                    <p class="text-sm text-grey-text mb-3">250g</p>
                    <p class="text-sm text-grey-text line-clamp-2 mb-4">Garam laut yang diasap dingin dengan rasa berasap yang kaya. Sempurna untuk BBQ dan hidangan panggang.</p>
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <span class="text-2xl font-bold text-sea-blue font-poppins">Rp 300.000</span>
                        </div>
                        <button onclick="addToCart(4, 'Garam Laut Asap')" class="w-10 h-10 rounded-full bg-light-blue flex items-center justify-center hover:bg-sea-blue hover:text-white transition-all duration-300 add-to-cart-btn">
                            <i data-lucide="shopping-cart" class="w-5 h-5"></i>
                        </button>
                    </div>
                </div>
            </div>
            
            <div class="product-card product-item opacity-0 translate-y-10">
                <div class="relative h-56 overflow-hidden">
                    <img src="{{ asset('images/sea-salt-wooden-bowl.jpg') }}" alt="Garam Laut Murni" class="w-full h-full object-cover">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/30 to-transparent opacity-0 hover:opacity-100 transition-opacity duration-300"></div>
                    <div class="absolute top-4 left-4">
                        <span class="px-3 py-1 rounded-full bg-white/90 backdrop-blur-sm text-xs font-medium text-deep-blue">Garam Laut</span>
                    </div>
                    <button onclick="openProductModal(5)" class="absolute bottom-4 left-1/2 -translate-x-1/2 px-6 py-2 bg-white rounded-full text-sm font-medium text-dark-text opacity-0 hover:opacity-100 transition-all duration-300 translate-y-4 hover:translate-y-0 shadow-lg">
                        Lihat Cepat
                    </button>
                </div>
                <div class="p-6">
                    <div class="flex items-center gap-1 mb-2">
                        <i data-lucide="star" class="w-4 h-4 text-yellow-400 fill-yellow-400"></i>
                        <i data-lucide="star" class="w-4 h-4 text-yellow-400 fill-yellow-400"></i>
                        <i data-lucide="star" class="w-4 h-4 text-yellow-400 fill-yellow-400"></i>
                        <i data-lucide="star" class="w-4 h-4 text-yellow-400 fill-yellow-400"></i>
                        <i data-lucide="star" class="w-4 h-4 text-yellow-400 fill-yellow-400"></i>
                        <span class="text-sm text-grey-text ml-1">(4.8)</span>
                    </div>
                    <h3 class="text-lg font-bold text-dark-text font-poppins mb-1">Garam Laut Murni</h3>
                    <p class="text-sm text-grey-text mb-3">750g</p>
                    <p class="text-sm text-grey-text line-clamp-2 mb-4">Garam laut murni seratus persen alami yang dipanen dari perairan laut jernih. Tanpa bahan tambahan.</p>
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <span class="text-2xl font-bold text-sea-blue font-poppins">Rp 210.000</span>
                        </div>
                        <button onclick="addToCart(5, 'Garam Laut Murni')" class="w-10 h-10 rounded-full bg-light-blue flex items-center justify-center hover:bg-sea-blue hover:text-white transition-all duration-300 add-to-cart-btn">
                            <i data-lucide="shopping-cart" class="w-5 h-5"></i>
                        </button>
                    </div>
                </div>
            </div>
            
            <div class="product-card product-item opacity-0 translate-y-10">
                <div class="relative h-56 overflow-hidden">
                    <img src="{{ asset('images/sea-salt-coarse.jpg') }}" alt="Garam Kasar Premium" class="w-full h-full object-cover">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/30 to-transparent opacity-0 hover:opacity-100 transition-opacity duration-300"></div>
                    <div class="absolute top-4 left-4">
                        <span class="px-3 py-1 rounded-full bg-white/90 backdrop-blur-sm text-xs font-medium text-deep-blue">Garam Laut</span>
                    </div>
                    <button onclick="openProductModal(6)" class="absolute bottom-4 left-1/2 -translate-x-1/2 px-6 py-2 bg-white rounded-full text-sm font-medium text-dark-text opacity-0 hover:opacity-100 transition-all duration-300 translate-y-4 hover:translate-y-0 shadow-lg">
                        Lihat Cepat
                    </button>
                </div>
                <div class="p-6">
                    <div class="flex items-center gap-1 mb-2">
                        <i data-lucide="star" class="w-4 h-4 text-yellow-400 fill-yellow-400"></i>
                        <i data-lucide="star" class="w-4 h-4 text-yellow-400 fill-yellow-400"></i>
                        <i data-lucide="star" class="w-4 h-4 text-yellow-400 fill-yellow-400"></i>
                        <i data-lucide="star" class="w-4 h-4 text-yellow-400 fill-yellow-400"></i>
                        <i data-lucide="star" class="w-4 h-4 text-grey-300"></i>
                        <span class="text-sm text-grey-text ml-1">(4.6)</span>
                    </div>
                    <h3 class="text-lg font-bold text-dark-text font-poppins mb-1">Garam Kasar Premium</h3>
                    <p class="text-sm text-grey-text mb-3">1 kg</p>
                    <p class="text-sm text-grey-text line-clamp-2 mb-4">Kristal garam ekstra kasar untuk penggiling garam dan proses pengasinan. Rasa yang pekat.</p>
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <span class="text-2xl font-bold text-sea-blue font-poppins">Rp 240.000</span>
                        </div>
                        <button onclick="addToCart(6, 'Garam Kasar Premium')" class="w-10 h-10 rounded-full bg-light-blue flex items-center justify-center hover:bg-sea-blue hover:text-white transition-all duration-300 add-to-cart-btn">
                            <i data-lucide="shopping-cart" class="w-5 h-5"></i>
                        </button>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
</section>