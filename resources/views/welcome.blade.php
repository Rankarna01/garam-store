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