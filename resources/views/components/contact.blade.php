<section id="contact" class="relative py-20 lg:py-32 overflow-hidden bg-white">
    <div class="absolute top-0 left-0 w-[600px] h-[600px] rounded-full bg-light-blue blur-3xl opacity-50 -translate-x-1/2"></div>
    
    <div class="relative z-10 w-full px-4 sm:px-6 lg:px-8 xl:px-16 2xl:px-24">
        <div class="text-center mb-16">
            <div class="animate-contact-header inline-flex items-center gap-2 px-4 py-2 rounded-full bg-light-blue mb-4 opacity-0 translate-y-5">
                <span class="w-2 h-2 rounded-full bg-sea-blue"></span>
                <span class="text-sm font-medium text-deep-blue">Hubungi Kami</span>
            </div>
            
            <h2 class="animate-contact-header text-3xl sm:text-4xl lg:text-5xl font-bold font-poppins text-dark-text mb-4 opacity-0 translate-y-5">
                Kirim <span class="text-gradient">Pesan</span>
            </h2>
            
            <p class="animate-contact-header text-grey-text text-lg max-w-2xl mx-auto opacity-0 translate-y-5">
                Punya pertanyaan tentang produk kami? Kami sangat senang mendengarnya. Kirimkan pesan dan tim kami akan segera menghubungi Anda kembali.
            </p>
        </div>
        
        <div class="grid lg:grid-cols-2 gap-10 lg:gap-16">
            <form id="contact-form" class="bg-white rounded-3xl shadow-xl p-6 sm:p-8 lg:p-10 border border-light-blue opacity-0 translate-x-[-20px]">
                <h3 class="text-2xl font-bold text-dark-text font-poppins mb-6">
                    Kirimkan Pesan
                </h3>
                
                <div id="form-success" class="hidden flex flex-col items-center justify-center py-12 text-center">
                    <div class="w-20 h-20 rounded-full bg-green-100 flex items-center justify-center mb-4">
                        <i data-lucide="check-circle" class="w-10 h-10 text-green-500"></i>
                    </div>
                    <h4 class="text-xl font-bold text-dark-text mb-2">Pesan Terkirim!</h4>
                    <p class="text-grey-text">Kami akan segera merespons pesan Anda.</p>
                </div>
                
                <div id="form-fields" class="space-y-6">
                    <div>
                        <label class="block text-sm font-medium text-dark-text mb-2">Nama Anda</label>
                        <input type="text" id="form-name" required class="form-input w-full px-4 py-3 rounded-xl border border-light-blue transition-all duration-300" placeholder="Budi Santoso">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-dark-text mb-2">Alamat Email</label>
                        <input type="email" id="form-email" required class="form-input w-full px-4 py-3 rounded-xl border border-light-blue transition-all duration-300" placeholder="budi@email.com">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-dark-text mb-2">Pesan Anda</label>
                        <textarea id="form-message" required rows="4" class="form-input w-full px-4 py-3 rounded-xl border border-light-blue transition-all duration-300 resize-none" placeholder="Beri tahu kami apa yang Anda butuhkan..."></textarea>
                    </div>
                    
                    <button type="submit" id="submit-btn" class="btn-primary w-full justify-center">
                        <i data-lucide="send" class="w-5 h-5"></i>
                        Kirim Pesan
                    </button>
                </div>
            </form>
            
            <div id="contact-info">
                <div class="grid sm:grid-cols-2 gap-4 mb-8">
                    <div class="contact-info-item bg-white rounded-2xl p-5 shadow-lg hover:shadow-xl transition-all duration-300 group opacity-0 translate-y-5">
                        <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-sea-blue to-[#1a8bc4] flex items-center justify-center mb-3 transition-transform duration-300 group-hover:scale-110">
                            <i data-lucide="map-pin" class="w-6 h-6 text-white"></i>
                        </div>
                        <h4 class="font-bold text-dark-text font-poppins mb-1">Kunjungi Kami</h4>
                        <p class="text-sm text-grey-text">Jl. Tulang Bawang No.31, Yosorejo, Kec. Metro Tim., Kota Metro, Lampung 34124</p>
                    </div>
                    
                    <div class="contact-info-item bg-white rounded-2xl p-5 shadow-lg hover:shadow-xl transition-all duration-300 group opacity-0 translate-y-5">
                        <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-deep-blue to-[#1a2a52] flex items-center justify-center mb-3 transition-transform duration-300 group-hover:scale-110">
                            <i data-lucide="phone" class="w-6 h-6 text-white"></i>
                        </div>
                        <h4 class="font-bold text-dark-text font-poppins mb-1">Telepon Kami</h4>
                        <p class="text-sm text-grey-text">+62 812-3456-7890</p>
                    </div>
                    
                    <div class="contact-info-item bg-white rounded-2xl p-5 shadow-lg hover:shadow-xl transition-all duration-300 group opacity-0 translate-y-5">
                        <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-sea-blue to-deep-blue flex items-center justify-center mb-3 transition-transform duration-300 group-hover:scale-110">
                            <i data-lucide="mail" class="w-6 h-6 text-white"></i>
                        </div>
                        <h4 class="font-bold text-dark-text font-poppins mb-1">Email Kami</h4>
                        <p class="text-sm text-grey-text">halo@saltpro.com</p>
                    </div>
                    
                    <div class="contact-info-item bg-white rounded-2xl p-5 shadow-lg hover:shadow-xl transition-all duration-300 group opacity-0 translate-y-5">
                        <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-[#1a8bc4] to-deep-blue flex items-center justify-center mb-3 transition-transform duration-300 group-hover:scale-110">
                            <i data-lucide="clock" class="w-6 h-6 text-white"></i>
                        </div>
                        <h4 class="font-bold text-dark-text font-poppins mb-1">Jam Operasional</h4>
                        <p class="text-sm text-grey-text">Sen - Jum: 09:00 - 18:00</p>
                    </div>
                </div>
                
                <div class="contact-map-item rounded-3xl overflow-hidden shadow-xl h-[300px] sm:h-[400px] relative opacity-0 translate-y-5">
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3974.1575451870353!2d105.33536187453154!3d-5.07820065152693!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e40bb383b95d279%3A0x82910a5b6f4d4bb0!2sCV.MERISA%20JAYA!5e0!3m2!1sid!2sid!4v1771507418475!5m2!1sid!2sid" class="w-full h-full" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                    <div class="absolute bottom-4 left-4 bg-white rounded-xl p-3 shadow-lg">
                        <div class="flex items-center gap-2">
                            <div class="w-3 h-3 rounded-full bg-green-500 animate-pulse"></div>
                            <span class="text-sm font-medium text-dark-text">Buka Sekarang</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>