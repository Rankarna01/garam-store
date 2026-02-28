<header id="header" class="fixed top-0 left-0 right-0 z-50 transition-all duration-500 py-5 bg-transparent">
    <div class="w-full px-4 sm:px-6 lg:px-8 xl:px-16 2xl:px-24">
        <div class="flex items-center justify-between">
            
            <a href="{{ route('home') }}" class="flex items-center gap-3 group">
                <img src="{{ asset('images/logo.png') }}" alt="Logo CV Merisa Jaya" class="h-10 sm:h-12 w-auto object-contain transition-transform duration-300 group-hover:scale-105">
                
                <span class="text-xl font-bold font-poppins text-dark-text">
                    CV MERISA<span class="text-sea-blue">JAYA</span>
                </span>
            </a>
            
            <nav class="hidden lg:flex items-center gap-8">
                <a href="{{ route('home') }}" class="nav-link text-sm font-medium font-poppins text-grey-text hover:text-sea-blue transition-colors">Beranda</a>
                <a href="{{ route('home') }}#about" class="nav-link text-sm font-medium font-poppins text-grey-text hover:text-sea-blue transition-colors">Tentang</a>
                <a href="{{ route('home') }}#products" class="nav-link text-sm font-medium font-poppins text-grey-text hover:text-sea-blue transition-colors">Produk</a>
                <a href="{{ route('home') }}#testimonials" class="nav-link text-sm font-medium font-poppins text-grey-text hover:text-sea-blue transition-colors">Testimoni</a>
            </nav>
            
            <div class="hidden lg:flex items-center gap-4">
                @auth
                    <a href="{{ route('my-orders') }}" class="text-sm font-medium font-poppins text-dark-text hover:text-sea-blue flex items-center gap-2 transition-colors">
                        <i data-lucide="clipboard-list" class="w-4 h-4 text-sea-blue"></i> Pesananku
                    </a>
                    <div class="w-px h-4 bg-gray-300"></div> 
                    
                    <div class="flex items-center gap-2 group cursor-pointer relative pb-2 pt-2">
                        <div class="w-8 h-8 rounded-full bg-light-blue text-sea-blue flex items-center justify-center font-bold text-xs uppercase border border-sea-blue/20">
                            {{ substr(auth()->user()->name, 0, 2) }}
                        </div>
                        <span class="text-sm font-medium text-dark-text">{{ explode(' ', auth()->user()->name)[0] }}</span>
                        
                        <div class="absolute top-[100%] right-0 mt-0 w-40 bg-white rounded-xl shadow-lg border border-gray-100 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 z-50 overflow-hidden">
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="w-full text-left px-4 py-3 text-sm text-red-500 hover:bg-red-50 transition-colors flex items-center gap-2 font-medium">
                                    <i data-lucide="log-out" class="w-4 h-4"></i> Keluar
                                </button>
                            </form>
                        </div>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="text-sm font-medium font-poppins text-dark-text hover:text-sea-blue transition-colors">Masuk</a>
                    <a href="{{ route('register') }}" class="btn-primary text-sm px-6 py-2">Daftar</a>
                @endauth
            </div>
            
            <button id="mobile-menu-btn" class="lg:hidden p-2 rounded-lg hover:bg-light-blue transition-colors">
                <i data-lucide="menu" class="w-6 h-6 text-dark-text" id="menu-icon"></i>
            </button>
        </div>
        
        <div id="mobile-menu" class="mobile-menu lg:hidden mt-4">
            <nav class="flex flex-col gap-2 bg-white/95 backdrop-blur-lg rounded-2xl p-4 shadow-lg border border-white/50">
                <a href="{{ route('home') }}" class="text-grey-text hover:text-sea-blue hover:bg-light-blue px-4 py-3 rounded-xl transition-all font-medium font-poppins">Beranda</a>
                <a href="{{ route('home') }}#products" class="text-grey-text hover:text-sea-blue hover:bg-light-blue px-4 py-3 rounded-xl transition-all font-medium font-poppins">Produk</a>
                
                <div class="border-t border-gray-100 my-2"></div>
                
                @auth
                    <a href="{{ route('my-orders') }}" class="text-sea-blue bg-light-blue px-4 py-3 rounded-xl transition-all font-medium font-poppins flex items-center gap-2">
                        <i data-lucide="clipboard-list" class="w-5 h-5"></i> Riwayat Pesanan
                    </a>
                    <form action="{{ route('logout') }}" method="POST" class="w-full">
                        @csrf
                        <button type="submit" class="w-full text-left text-red-500 hover:bg-red-50 px-4 py-3 rounded-xl transition-all font-medium font-poppins flex items-center gap-2">
                            <i data-lucide="log-out" class="w-5 h-5"></i> Keluar Akun
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="text-dark-text hover:text-sea-blue hover:bg-light-blue px-4 py-3 rounded-xl transition-all font-medium font-poppins flex items-center gap-2">
                        <i data-lucide="log-in" class="w-5 h-5"></i> Masuk
                    </a>
                    <a href="{{ route('register') }}" class="btn-primary text-sm mt-2 justify-center py-3">
                        Daftar Akun Baru
                    </a>
                @endauth
            </nav>
        </div>
    </div>
</header>