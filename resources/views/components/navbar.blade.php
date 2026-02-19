<header id="header" class="fixed top-0 left-0 right-0 z-50 transition-all duration-500 py-5 bg-transparent">
    <div class="w-full px-4 sm:px-6 lg:px-8 xl:px-16 2xl:px-24">
        <div class="flex items-center justify-between">
            <a href="#hero" class="flex items-center gap-2 group">
                <div class="relative">
                    <div class="w-10 h-10 rounded-full bg-gradient-to-br from-sea-blue to-deep-blue flex items-center justify-center transition-transform duration-300 group-hover:scale-110">
                        <i data-lucide="droplets" class="w-5 h-5 text-white"></i>
                    </div>
                    <div class="absolute inset-0 rounded-full bg-sea-blue pulse-ring opacity-50"></div>
                </div>
                <span class="text-xl font-bold font-poppins text-dark-text">
                    Salt<span class="text-sea-blue">Pro</span>
                </span>
            </a>
            
            <nav class="hidden lg:flex items-center gap-8">
                <a href="#hero" class="nav-link text-sm font-medium font-poppins text-grey-text hover:text-sea-blue transition-colors">Beranda</a>
                <a href="#about" class="nav-link text-sm font-medium font-poppins text-grey-text hover:text-sea-blue transition-colors">Tentang</a>
                <a href="#products" class="nav-link text-sm font-medium font-poppins text-grey-text hover:text-sea-blue transition-colors">Produk</a>
                <a href="#testimonials" class="nav-link text-sm font-medium font-poppins text-grey-text hover:text-sea-blue transition-colors">Testimoni</a>
                <a href="#contact" class="nav-link text-sm font-medium font-poppins text-grey-text hover:text-sea-blue transition-colors">Kontak</a>
            </nav>
            
            <div class="hidden lg:block">
                <a href="#contact" class="btn-primary text-sm">Hubungi Kami</a>
            </div>
            
            <button id="mobile-menu-btn" class="lg:hidden p-2 rounded-lg hover:bg-light-blue transition-colors">
                <i data-lucide="menu" class="w-6 h-6 text-dark-text" id="menu-icon"></i>
            </button>
        </div>
        
        <div id="mobile-menu" class="mobile-menu lg:hidden mt-4">
            <nav class="flex flex-col gap-2 bg-white/95 backdrop-blur-lg rounded-2xl p-4 shadow-lg">
                <a href="#hero" class="text-grey-text hover:text-sea-blue hover:bg-light-blue px-4 py-3 rounded-xl transition-all font-medium font-poppins">Beranda</a>
                <a href="#about" class="text-grey-text hover:text-sea-blue hover:bg-light-blue px-4 py-3 rounded-xl transition-all font-medium font-poppins">Tentang</a>
                <a href="#products" class="text-grey-text hover:text-sea-blue hover:bg-light-blue px-4 py-3 rounded-xl transition-all font-medium font-poppins">Produk</a>
                <a href="#testimonials" class="text-grey-text hover:text-sea-blue hover:bg-light-blue px-4 py-3 rounded-xl transition-all font-medium font-poppins">Testimoni</a>
                <a href="#contact" class="text-grey-text hover:text-sea-blue hover:bg-light-blue px-4 py-3 rounded-xl transition-all font-medium font-poppins">Kontak</a>
                <a href="#contact" class="btn-primary text-sm mt-2 justify-center">Hubungi Kami</a>
            </nav>
        </div>
    </div>
</header>