<section id="testimonials" class="relative py-20 lg:py-32 overflow-hidden bg-gradient-to-b from-[#f8fdff] to-light-blue">
    <div class="absolute top-0 right-0 w-[500px] h-[500px] rounded-full bg-sea-blue/10 blur-3xl"></div>
    <div class="absolute bottom-0 left-0 w-[500px] h-[500px] rounded-full bg-white/50 blur-3xl"></div>
    
    <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 opacity-5 pointer-events-none">
        <i data-lucide="quote" class="w-96 h-96 text-deep-blue"></i>
    </div>
    
    <div class="relative z-10 w-full px-4 sm:px-6 lg:px-8 xl:px-16 2xl:px-24">
        <div class="text-center mb-16">
            <div class="animate-testimonial-header inline-flex items-center gap-2 px-4 py-2 rounded-full bg-white mb-4 opacity-0 translate-y-5 shadow-sm">
                <span class="w-2 h-2 rounded-full bg-sea-blue"></span>
                <span class="text-sm font-medium text-deep-blue">Testimoni</span>
            </div>
            
            <h2 class="animate-testimonial-header text-3xl sm:text-4xl lg:text-5xl font-bold font-poppins text-dark-text mb-4 opacity-0 translate-y-5">
                Apa Kata <span class="text-gradient">Pelanggan Kami</span>
            </h2>
            
            <p class="animate-testimonial-header text-grey-text text-lg max-w-2xl mx-auto opacity-0 translate-y-5">
                Jangan hanya percaya pada kata-kata kami. Berikut adalah tanggapan pelanggan tentang pengalaman luar biasa mereka menggunakan produk SaltPro.
            </p>
        </div>
        
        <div id="testimonial-carousel" class="max-w-4xl mx-auto opacity-0 translate-y-10">
            <div class="relative">
                <div class="bg-white rounded-3xl shadow-xl p-8 lg:p-12 transition-all duration-500" id="testimonial-card">
                    <div class="grid lg:grid-cols-[200px_1fr] gap-8 items-center">
                        <div class="flex flex-col items-center">
                            <div class="relative">
                                <div class="w-32 h-32 lg:w-40 lg:h-40 rounded-full overflow-hidden border-4 border-light-blue shadow-lg">
                                    <img id="testimonial-image" src="{{ asset('images/testimonial-1.jpg') }}" alt="Foto Pelanggan" class="w-full h-full object-cover transition-opacity duration-300">
                                </div>
                                <div class="absolute -bottom-2 -right-2 w-10 h-10 rounded-full bg-gradient-to-br from-sea-blue to-deep-blue flex items-center justify-center shadow-md">
                                    <i data-lucide="quote" class="w-5 h-5 text-white fill-white"></i>
                                </div>
                            </div>
                            
                            <div class="flex items-center gap-1 mt-4">
                                <i data-lucide="star" class="w-5 h-5 text-yellow-400 fill-yellow-400"></i>
                                <i data-lucide="star" class="w-5 h-5 text-yellow-400 fill-yellow-400"></i>
                                <i data-lucide="star" class="w-5 h-5 text-yellow-400 fill-yellow-400"></i>
                                <i data-lucide="star" class="w-5 h-5 text-yellow-400 fill-yellow-400"></i>
                                <i data-lucide="star" class="w-5 h-5 text-yellow-400 fill-yellow-400"></i>
                            </div>
                        </div>
                        
                        <div class="text-center lg:text-left">
                            <i data-lucide="quote" class="w-10 h-10 text-sea-blue/30 mb-4 hidden lg:block fill-sea-blue/30"></i>
                            
                            <p id="testimonial-content" class="text-lg lg:text-xl text-grey-text leading-relaxed mb-6 italic transition-opacity duration-300">
                                "Kemurnian produk SaltPro benar-benar tak tertandingi. Saya telah menggunakan garam merah muda Himalaya mereka di restoran saya selama bertahun-tahun, dan pelanggan selalu menyadari perbedaannya. Produk ini mengangkat cita rasa setiap hidangan ke level yang baru."
                            </p>
                            
                            <div>
                                <h4 id="testimonial-name" class="text-xl font-bold text-dark-text font-poppins transition-opacity duration-300">Sarah Mitchell</h4>
                                <p id="testimonial-role" class="text-sea-blue font-medium transition-opacity duration-300">Koki Eksekutif</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="flex justify-center items-center gap-6 mt-8">
                    <button onclick="prevTestimonial()" class="w-12 h-12 rounded-full bg-white shadow-md flex items-center justify-center hover:bg-sea-blue hover:text-white hover:shadow-lg hover:-translate-x-1 transition-all duration-300">
                        <i data-lucide="chevron-left" class="w-6 h-6"></i>
                    </button>
                    
                    <div id="testimonial-dots" class="flex items-center gap-3">
                        <button onclick="goToTestimonial(0)" class="dot-btn w-8 h-3 rounded-full bg-gradient-to-r from-sea-blue to-deep-blue transition-all duration-300"></button>
                        <button onclick="goToTestimonial(1)" class="dot-btn w-3 h-3 rounded-full bg-sea-blue/30 hover:bg-sea-blue/50 transition-all duration-300"></button>
                        <button onclick="goToTestimonial(2)" class="dot-btn w-3 h-3 rounded-full bg-sea-blue/30 hover:bg-sea-blue/50 transition-all duration-300"></button>
                    </div>
                    
                    <button onclick="nextTestimonial()" class="w-12 h-12 rounded-full bg-white shadow-md flex items-center justify-center hover:bg-sea-blue hover:text-white hover:shadow-lg hover:translate-x-1 transition-all duration-300">
                        <i data-lucide="chevron-right" class="w-6 h-6"></i>
                    </button>
                </div>
            </div>
            
            <div class="flex justify-center gap-4 mt-8">
                <button onclick="goToTestimonial(0)" class="testimonial-thumb w-16 h-16 rounded-full overflow-hidden ring-4 ring-sea-blue ring-offset-2 scale-110 transition-all duration-300">
                    <img src="{{ asset('images/testimonial-1.jpg') }}" alt="Sarah Mitchell" class="w-full h-full object-cover">
                </button>
                <button onclick="goToTestimonial(1)" class="testimonial-thumb w-16 h-16 rounded-full overflow-hidden opacity-50 hover:opacity-80 transition-all duration-300">
                    <img src="{{ asset('images/testimonial-2.jpg') }}" alt="Budi Santoso" class="w-full h-full object-cover">
                </button>
                <button onclick="goToTestimonial(2)" class="testimonial-thumb w-16 h-16 rounded-full overflow-hidden opacity-50 hover:opacity-80 transition-all duration-300">
                    <img src="{{ asset('images/testimonial-3.jpg') }}" alt="Amelia Rizki" class="w-full h-full object-cover">
                </button>
            </div>
        </div>
    </div>
</section>