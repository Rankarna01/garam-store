<x-layouts.app title="GaramPro - Garam Laut Premium">
    
    <x-navbar />
    <x-hero />
    <x-about />
    <x-products :products="$products" />
    <x-testimonials :testimonials="$testimonials" />
    <x-contact />
    <x-footer />

    <x-cart-drawer />

    <script>

        // Setup CSRF token untuk AJAX
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

        // --- FUNGSI DRAWER KERANJANG ---
        function toggleCartDrawer() {
            const drawer = document.getElementById('cart-drawer');
            const overlay = document.getElementById('cart-drawer-overlay');
            
            if (drawer.classList.contains('translate-x-full')) {
                // Buka
                overlay.classList.remove('hidden');
                setTimeout(() => overlay.classList.remove('opacity-0'), 10);
                drawer.classList.remove('translate-x-full');
                fetchCartData(); // Ambil data terbaru saat dibuka
            } else {
                // Tutup
                overlay.classList.add('opacity-0');
                drawer.classList.add('translate-x-full');
                setTimeout(() => overlay.classList.add('hidden'), 300);
            }
        }

        // Buka drawer saat indikator keranjang kecil diklik
        document.getElementById('cart-indicator').addEventListener('click', toggleCartDrawer);

        // --- AJAX KERANJANG BELANJA ---
        
        // 1. Tambah Produk
        function addToCart(productId, productName) {
            // (Catatan: Karena ini statis, asumsikan ID 1-6 ada di DB. Nanti ganti tombol di x-products agar dinamis dari database).
            
            // Simulasi data untuk testing UI jika belum ada DB (HAPUS INI JIKA SUDAH PAKAI DATABASE)
            // fetch('/cart/add', { ... }) 

            // Untuk sementara kita gunakan script UI saja agar animasinya terlihat
            let currentCount = parseInt(document.getElementById('cart-count').innerText) || 0;
            currentCount++;
            document.getElementById('cart-indicator').classList.remove('hidden');
            document.getElementById('cart-count').innerText = `${currentCount} item`;
            gsap.fromTo('#cart-indicator', { scale: 0.8 }, { scale: 1, duration: 0.3, ease: "back.out(1.7)" });
            
            // Tampilkan alert kecil
            alert(`${productName} ditambahkan ke keranjang!`);
            toggleCartDrawer(); // Otomatis buka keranjang
        }

        // 2. Render Data Keranjang di UI
        function fetchCartData() {
            // (Nanti panggil fetch('/cart/data') ke backend)
            // Untuk sementara kita render UI dummy di dalam Drawer
            const container = document.getElementById('cart-items-container');
            const checkoutBtn = document.getElementById('checkout-btn');
            
            // Dummy Data
            container.innerHTML = `
                <div class="flex items-center gap-4 bg-white p-3 rounded-xl border border-gray-100 shadow-sm">
                    <img src="/images/fine-table-salt.jpg" alt="Garam" class="w-16 h-16 rounded-lg object-cover">
                    <div class="flex-1">
                        <h4 class="font-semibold text-dark-text text-sm">Garam Meja Halus</h4>
                        <p class="text-primary font-bold text-sm">Rp 180.000</p>
                    </div>
                    <div class="flex items-center gap-2 bg-light-blue px-2 py-1 rounded-lg">
                        <button class="w-6 h-6 flex items-center justify-center text-sea-blue hover:bg-white rounded">-</button>
                        <span class="text-sm font-medium w-4 text-center">1</span>
                        <button class="w-6 h-6 flex items-center justify-center text-sea-blue hover:bg-white rounded">+</button>
                    </div>
                </div>
            `;
            
            document.getElementById('cart-total-amount').innerText = 'Rp 180.000';
            checkoutBtn.classList.remove('opacity-50', 'pointer-events-none');
            lucide.createIcons();
        }
        // --- LOGIKA KERANJANG (Di luar DOMContentLoaded agar bisa dipanggil oleh onclick di HTML) ---
        let cartItems = 0;
        
        function addToCart(productId, productName) {
            cartItems++;
            const cartIndicator = document.getElementById('cart-indicator');
            const cartCount = document.getElementById('cart-count');
            
            // Tampilkan indikator jika disembunyikan
            cartIndicator.classList.remove('hidden');
            
            // Update teks
            cartCount.innerText = `${cartItems} item di keranjang`;
            
            // Animasi pop sederhana pada indikator keranjang
            gsap.fromTo(cartIndicator, 
                { scale: 0.8 }, 
                { scale: 1, duration: 0.3, ease: "back.out(1.7)" }
            );
        }

        function openProductModal(productId) {
            console.log("Membuka detail produk ID:", productId);
            alert("Fitur Lihat Cepat untuk produk ID " + productId + " akan segera hadir!");
        }

        // --- SEMUA LOGIKA DOM & ANIMASI GSAP ---
        document.addEventListener('DOMContentLoaded', () => {
            
            // PENTING: Register ScrollTrigger agar animasi scroll berfungsi!
            gsap.registerPlugin(ScrollTrigger);

            // 1. Mobile Menu Toggle
            const btn = document.getElementById('mobile-menu-btn');
            const menu = document.getElementById('mobile-menu');
            
            btn.addEventListener('click', () => {
                menu.classList.toggle('open');
            });

            // 2. Navbar Scroll Effect
            window.addEventListener('scroll', () => {
                const header = document.getElementById('header');
                if (window.scrollY > 50) {
                    header.classList.add('bg-white/80', 'backdrop-blur-md', 'shadow-sm');
                    header.classList.remove('bg-transparent');
                } else {
                    header.classList.remove('bg-white/80', 'backdrop-blur-md', 'shadow-sm');
                    header.classList.add('bg-transparent');
                }
            });

            // 3. GSAP Animations untuk Hero Section (Tanpa ScrollTrigger, animasi saat loading)
            gsap.to("#hero-circle", {
                scale: 1, duration: 1.5, ease: "power3.out"
            });

            gsap.to("#hero-badge", {
                opacity: 1, y: 0, duration: 1, delay: 0.5, ease: "power2.out"
            });

            gsap.fromTo(".word", 
                { opacity: 0, y: 50 },
                { opacity: 1, y: 0, duration: 0.8, stagger: 0.1, delay: 0.7, ease: "back.out(1.7)" }
            );

            gsap.to("#hero-subtitle", {
                opacity: 1, y: 0, duration: 1, delay: 1.5, ease: "power2.out"
            });

            gsap.to("#hero-cta", {
                opacity: 1, y: 0, duration: 1, delay: 1.8, ease: "power2.out"
            });

            gsap.to("#hero-stats", {
                opacity: 1, y: 0, duration: 1, delay: 2.1, ease: "power2.out"
            });

            // 4. Particle Generator sederhana untuk Hero
            const particlesContainer = document.getElementById('particles');
            if (particlesContainer) {
                for (let i = 0; i < 20; i++) {
                    const particle = document.createElement('div');
                    particle.classList.add('particle');
                    particle.style.left = Math.random() * 100 + 'vw';
                    particle.style.top = Math.random() * 100 + 'vh';
                    particle.style.animationDuration = (Math.random() * 3 + 2) + 's';
                    particlesContainer.appendChild(particle);
                }
            }

            // 5. ANIMASI ABOUT SECTION (Dengan ScrollTrigger)
            gsap.to("#about-image", {
                scrollTrigger: {
                    trigger: "#about",
                    start: "top 75%", // Animasi mulai saat bagian atas section about mencapai 75% viewport
                },
                opacity: 1,
                y: 0,
                duration: 1,
                ease: "power3.out"
            });

            gsap.to(".animate-item", {
                scrollTrigger: {
                    trigger: "#about-content",
                    start: "top 80%",
                },
                opacity: 1,
                y: 0,
                duration: 0.8,
                stagger: 0.15, // Efek muncul berurutan
                ease: "power2.out"
            });

            // 6. ANIMASI PRODUCTS SECTION (Dengan ScrollTrigger)
            // Animasi untuk judul dan teks deskripsi di bagian atas Produk
            gsap.to(".animate-product-header", {
                scrollTrigger: {
                    trigger: "#products",
                    start: "top 80%",
                },
                opacity: 1,
                y: 0,
                duration: 0.8,
                stagger: 0.2,
                ease: "power2.out"
            });

            // Animasi untuk setiap kartu produk
            gsap.to(".product-item", {
                scrollTrigger: {
                    trigger: ".grid", // Memicu animasi saat container grid terlihat
                    start: "top 75%",
                },
                opacity: 1,
                y: 0,
                duration: 0.8,
                stagger: 0.15, // Kartu muncul berurutan dengan jeda 0.15 detik
                ease: "power3.out"
            });
            

            // 7. ANIMASI TESTIMONIAL SECTION
            gsap.to(".animate-testimonial-header", {
                scrollTrigger: { trigger: "#testimonials", start: "top 80%" },
                opacity: 1, y: 0, duration: 0.8, stagger: 0.2, ease: "power2.out"
            });
            gsap.to("#testimonial-carousel", {
                scrollTrigger: { trigger: "#testimonial-carousel", start: "top 85%" },
                opacity: 1, y: 0, duration: 1, ease: "power3.out"
            });

            // --- ANIMASI CONTACT SECTION ---
            
            // Animasi Judul Contact
            gsap.to(".animate-contact-header", {
                scrollTrigger: { trigger: "#contact", start: "top 80%" },
                opacity: 1, y: 0, duration: 0.8, stagger: 0.15, ease: "power2.out"
            });

            // Animasi Form Contact masuk dari kiri
            gsap.to("#contact-form", {
                scrollTrigger: { trigger: "#contact", start: "top 70%" },
                opacity: 1, x: 0, duration: 1, ease: "power3.out"
            });

            // Animasi Kartu Info Contact masuk berurutan
            gsap.to(".contact-info-item", {
                scrollTrigger: { trigger: "#contact-info", start: "top 75%" },
                opacity: 1, y: 0, duration: 0.6, stagger: 0.15, ease: "power2.out"
            });

            // Animasi Map Contact
            gsap.to(".contact-map-item", {
                scrollTrigger: { trigger: "#contact-info", start: "top 60%" },
                opacity: 1, y: 0, duration: 0.8, ease: "power3.out"
            });

            // --- FUNGSI SUBMIT FORMULIR ---
            const contactForm = document.getElementById('contact-form');
            if (contactForm) {
                contactForm.addEventListener('submit', function(e) {
                    e.preventDefault(); // Mencegah halaman refresh
                    
                    const formFields = document.getElementById('form-fields');
                    const formSuccess = document.getElementById('form-success');
                    const submitBtn = document.getElementById('submit-btn');
                    
                    // Efek loading di tombol
                    const originalBtnText = submitBtn.innerHTML;
                    submitBtn.innerHTML = '<i data-lucide="loader" class="w-5 h-5 animate-spin"></i> Mengirim...';
                    lucide.createIcons();
                    
                    // Simulasi delay pengiriman pesan (misal: memanggil API Backend nanti)
                    setTimeout(() => {
                        // Sembunyikan form input dan tampilkan pesan sukses dengan animasi GSAP
                        gsap.to(formFields, {
                            opacity: 0, height: 0, duration: 0.3, onComplete: () => {
                                formFields.classList.add('hidden');
                                formSuccess.classList.remove('hidden');
                                gsap.fromTo(formSuccess, 
                                    { opacity: 0, scale: 0.8 }, 
                                    { opacity: 1, scale: 1, duration: 0.5, ease: "back.out(1.5)" }
                                );
                            }
                        });
                    }, 1500); // Delay 1.5 detik
                });
            }
        });
    </script>
</x-layouts.app>