<section id="about" class="relative py-20 lg:py-32 overflow-hidden bg-white">
    <div class="absolute top-0 left-0 w-96 h-96 rounded-full bg-light-blue blur-3xl opacity-50 -translate-x-1/2 -translate-y-1/2"></div>
    <div class="absolute bottom-0 right-0 w-96 h-96 rounded-full bg-sea-blue/10 blur-3xl opacity-50 translate-x-1/2 translate-y-1/2"></div>
    
    <div class="relative z-10 w-full px-4 sm:px-6 lg:px-8 xl:px-16 2xl:px-24">
        <div class="grid lg:grid-cols-2 gap-12 lg:gap-20 items-center">
            <div id="about-image" class="relative opacity-0 translate-y-10">
                <div class="relative rounded-3xl overflow-hidden shadow-2xl">
                    <img src="{{ asset('images/about-salt.jpg') }}" alt="Garam laut di mangkuk kayu" class="w-full h-[400px] lg:h-[500px] object-cover">
                    <div class="absolute inset-0 bg-gradient-to-t from-deep-blue/30 to-transparent"></div>
                </div>
                
                <div class="absolute -bottom-6 -right-6 lg:bottom-10 lg:-right-10 bg-white rounded-2xl shadow-xl p-6 floating">
                    <div class="flex items-center gap-4">
                        <div class="w-14 h-14 rounded-full bg-gradient-to-br from-sea-blue to-deep-blue flex items-center justify-center">
                            <i data-lucide="award" class="w-7 h-7 text-white"></i>
                        </div>
                        <div>
                            <div class="text-2xl font-bold text-dark-text font-poppins">15+</div>
                            <div class="text-sm text-grey-text">Tahun Keunggulan</div>
                        </div>
                    </div>
                </div>
                
                <div class="absolute -top-6 -left-6 w-24 h-24 rounded-full border-4 border-sea-blue/20"></div>
            </div>
            
            <div id="about-content">
                <div class="animate-item inline-flex items-center gap-2 px-4 py-2 rounded-full bg-light-blue mb-4 opacity-0">
                    <span class="w-2 h-2 rounded-full bg-sea-blue"></span>
                    <span class="text-sm font-medium text-deep-blue">Tentang Kami</span>
                </div>
                
                <h2 class="animate-item text-3xl sm:text-4xl lg:text-5xl font-bold font-poppins text-dark-text mb-6 leading-tight opacity-0">
                    Menghadirkan Anugerah <span class="text-gradient">Termurni Alam</span> ke Meja Anda
                </h2>
                
                <p class="animate-item text-grey-text text-lg leading-relaxed mb-6 opacity-0">
                    Kami berdedikasi tinggi untuk menghadirkan garam dengan kualitas terbaik, yang bersumber langsung dari dataran garam alami. Komitmen kami adalah pada kemurnian dan keberlanjutan, memastikan setiap butiran yang Anda terima bebas dari proses buatan.
                </p>
                
                <p class="animate-item text-grey-text leading-relaxed mb-8 opacity-0">
                    Dari ladang garam yang disinari matahari hingga ke dapur Anda, kami mempertahankan standar kontrol kualitas tertinggi. Garam kami dipanen menggunakan metode tradisional yang menjaga kandungan mineral alami dan profil rasa yang unik.
                </p>
                
                <div class="animate-item space-y-4 mb-8 opacity-0">
                    <div class="flex items-center gap-3">
                        <div class="w-6 h-6 rounded-full bg-sea-blue/10 flex items-center justify-center flex-shrink-0">
                            <i data-lucide="check" class="w-4 h-4 text-sea-blue"></i>
                        </div>
                        <span class="text-dark-text font-medium">Kualitas Premium Terjamin</span>
                    </div>
                    <div class="flex items-center gap-3">
                        <div class="w-6 h-6 rounded-full bg-sea-blue/10 flex items-center justify-center flex-shrink-0">
                            <i data-lucide="check" class="w-4 h-4 text-sea-blue"></i>
                        </div>
                        <span class="text-dark-text font-medium">100% Alami & Organik</span>
                    </div>
                    <div class="flex items-center gap-3">
                        <div class="w-6 h-6 rounded-full bg-sea-blue/10 flex items-center justify-center flex-shrink-0">
                            <i data-lucide="check" class="w-4 h-4 text-sea-blue"></i>
                        </div>
                        <span class="text-dark-text font-medium">Teruji Lab & Bersertifikat</span>
                    </div>
                </div>
                
                <a href="#products" class="animate-item btn-secondary group opacity-0 inline-flex">
                    Jelajahi Produk Kami
                    <i data-lucide="arrow-right" class="w-5 h-5 transition-transform duration-300 group-hover:translate-x-1"></i>
                </a>
            </div>
        </div>
    </div>
</section>