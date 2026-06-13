<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Toko Garam Premium' }}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Lato:wght@300;400;700&display=swap" rel="stylesheet">
    
    <script src="https://cdn.tailwindcss.com"></script>
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/ScrollTrigger.min.js"></script>
    
    <script src="https://unpkg.com/lucide@latest"></script>
    
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'sea-blue': '#2face0',
                        'deep-blue': '#253b70',
                        'light-blue': '#e8f7fc',
                        'dark-text': '#0e181d',
                        'grey-text': '#5e5e5e',
                    },
                    fontFamily: {
                        'poppins': ['Poppins', 'sans-serif'],
                        'lato': ['Lato', 'sans-serif'],
                    }
                }
            }
        }
    </script>
    
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Lato', sans-serif; overflow-x: hidden; }
        h1, h2, h3, h4, h5, h6 { font-family: 'Poppins', sans-serif; }
        
        .text-gradient {
            background: linear-gradient(135deg, #2face0 0%, #253b70 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        
        .btn-primary {
            background: linear-gradient(135deg, #2face0 0%, #253b70 100%);
            color: white; padding: 12px 32px; border-radius: 9999px;
            font-weight: 500; transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(47, 172, 224, 0.3);
            display: inline-flex; align-items: center; gap: 8px;
            border: none; cursor: pointer;
        }
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(47, 172, 224, 0.4);
        }
        
        .btn-secondary {
            border: 2px solid #2face0; color: #2face0;
            padding: 12px 32px; border-radius: 9999px;
            font-weight: 500; transition: all 0.3s ease;
            display: inline-flex; align-items: center; gap: 8px;
            background: transparent; cursor: pointer;
        }
        .btn-secondary:hover { background: #2face0; color: white; transform: translateY(-2px); }
        
        .card-hover { transition: all 0.5s ease; }
        .card-hover:hover { transform: translateY(-10px); box-shadow: 0 20px 40px rgba(47, 172, 224, 0.15); }
        
        @keyframes floating { 0%, 100% { transform: translateY(0px); } 50% { transform: translateY(-15px); } }
        .floating { animation: floating 3s ease-in-out infinite; }
        .floating-delayed { animation: floating 3s ease-in-out infinite; animation-delay: 1.5s; }
        
        @keyframes pulse-ring { 0% { transform: scale(1); opacity: 1; } 100% { transform: scale(1.5); opacity: 0; } }
        .pulse-ring { animation: pulse-ring 2s ease-out infinite; }
        
        ::-webkit-scrollbar { width: 8px; }
        ::-webkit-scrollbar-track { background: #e8f7fc; }
        ::-webkit-scrollbar-thumb { background: #2face0; border-radius: 4px; }
        ::-webkit-scrollbar-thumb:hover { background: #253b70; }
        ::selection { background: #2face0; color: white; }
        
        .nav-link { position: relative; }
        .nav-link::after {
            content: ''; position: absolute; bottom: -4px; left: 0; width: 0; height: 2px;
            background: linear-gradient(135deg, #2face0 0%, #253b70 100%); transition: width 0.3s ease;
        }
        .nav-link:hover::after { width: 100%; }
        
        .product-card { background: white; border-radius: 24px; overflow: hidden; box-shadow: 0 10px 30px rgba(0,0,0,0.1); transition: all 0.5s ease; }
        .product-card:hover { transform: translateY(-10px); box-shadow: 0 20px 40px rgba(47, 172, 224, 0.15); }
        .product-card img { transition: transform 0.7s ease; }
        .product-card:hover img { transform: scale(1.1); }
        
        .testimonial-card { transition: all 0.5s ease; }
        .form-input:focus { border-color: #2face0; box-shadow: 0 0 0 3px rgba(47, 172, 224, 0.2); outline: none; }
        
        .mobile-menu { max-height: 0; overflow: hidden; transition: max-height 0.5s ease; }
        .mobile-menu.open { max-height: 400px; }
        
        .particle { position: absolute; width: 8px; height: 8px; border-radius: 50%; background: rgba(47, 172, 224, 0.3); pointer-events: none; }
        
        @media (prefers-reduced-motion: reduce) {
            *, *::before, *::after { animation-duration: 0.01ms !important; animation-iteration-count: 1 !important; transition-duration: 0.01ms !important; }
        }
    </style>
</head>
<body class="bg-light-blue text-dark-text antialiased">
    
    <main>
        {{ $slot }}
    </main>

    <script>
        // Inisialisasi Icon Lucide
        lucide.createIcons();

        // ==========================================
        // LOGIKA KERANJANG BELANJA (CART DRAWER AJAX)
        // ==========================================
        document.addEventListener('DOMContentLoaded', function() {
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

            // 1. Buka/Tutup Drawer Keranjang
            window.toggleCartDrawer = function() {
                const drawer = document.getElementById('cart-drawer');
                const overlay = document.getElementById('cart-drawer-overlay');
                
                if (drawer && overlay) {
                    if (drawer.classList.contains('translate-x-full')) {
                        overlay.classList.remove('hidden');
                        setTimeout(() => overlay.classList.remove('opacity-0'), 10);
                        drawer.classList.remove('translate-x-full');
                        
                        // Ambil data terbaru dari database setiap kali drawer dibuka
                        fetchCartData();
                    } else {
                        overlay.classList.add('opacity-0');
                        drawer.classList.add('translate-x-full');
                        setTimeout(() => overlay.classList.add('hidden'), 300);
                    }
                }
            };

            // 2. Ambil Data Keranjang & Render HTML
            window.fetchCartData = function() {
                // Pastikan route ini ada di web.php
                fetch("{{ route('cart.data') }}", {
                    headers: { 'Accept': 'application/json' }
                })
                .then(response => response.json())
                .then(data => {
                    const container = document.getElementById('cart-items-container');
                    const emptyMsg = document.getElementById('empty-cart-msg');
                    const checkoutBtn = document.getElementById('checkout-btn');
                    const totalAmountEl = document.getElementById('cart-total-amount');

                    if(!container) return; // Mencegah error jika elemen tidak ada di halaman

                    let html = '';

                    // Jika Keranjang Kosong
                    if (!data.cartData || Object.keys(data.cartData).length === 0) {
                        if(emptyMsg) emptyMsg.classList.remove('hidden');
                        if(checkoutBtn) checkoutBtn.classList.add('opacity-50', 'pointer-events-none');
                        if(totalAmountEl) totalAmountEl.innerText = 'Rp 0';
                        
                        // Bersihkan container dari item lama
                        Array.from(container.children).forEach(child => {
                            if (child.id !== 'empty-cart-msg') child.remove();
                        });
                    } else {
                        // Jika Keranjang Ada Isinya
                        if(emptyMsg) emptyMsg.classList.add('hidden');
                        if(checkoutBtn) checkoutBtn.classList.remove('opacity-50', 'pointer-events-none');
                        
                        // Looping item keranjang
                        for (const [id, details] of Object.entries(data.cartData)) {
                            let imageUrl = details.image ? `/storage/${details.image}` : `https://ui-avatars.com/api/?name=${encodeURIComponent(details.name)}&background=f3f4f6&color=gray`;
                            
                            html += `
                                <div class="flex items-center gap-4 bg-white p-4 rounded-2xl border border-gray-100 shadow-sm relative">
                                    <img src="${imageUrl}" alt="${details.name}" class="w-16 h-16 rounded-xl object-cover border border-gray-50">
                                    
                                    <div class="flex-1">
                                        <h4 class="font-semibold text-dark-text text-sm mb-1">${details.name}</h4>
                                        <p class="text-sea-blue font-bold text-sm">Rp ${new Intl.NumberFormat('id-ID').format(details.price)}</p>
                                    </div>
                                    
                                    <div class="flex items-center">
                                        <input type="number" min="1" value="${details.quantity}" onchange="updateQuantity(${id}, parseInt(this.value) || 1)" class="w-16 px-2 py-1.5 text-center text-sm font-semibold bg-[#f8fdff] border border-light-blue rounded-lg focus:outline-none focus:border-sea-blue transition-colors">
                                    </div>

                                    <button onclick="removeItem(${id})" class="absolute -top-2 -right-2 w-7 h-7 bg-white text-red-500 rounded-full flex items-center justify-center hover:bg-red-500 hover:text-white transition-colors shadow-md border border-gray-100 cursor-pointer">
                                        <i data-lucide="x" class="w-4 h-4"></i>
                                    </button>
                                </div>
                            `;
                        }
                        
                        // Timpa isi container (tapi pertahankan div empty-cart-msg agar tidak error saat dikosongkan lagi)
                        container.innerHTML = `<div class="flex flex-col items-center justify-center h-full text-gray-400 hidden" id="empty-cart-msg"><i data-lucide="shopping-cart" class="w-16 h-16 mb-4 opacity-50"></i><p>Keranjang Anda masih kosong</p></div>` + html;
                        
                        if(totalAmountEl) totalAmountEl.innerText = `Rp ${new Intl.NumberFormat('id-ID').format(data.totalAmount)}`;
                        
                        // Render ulang icon x setelah elemen baru dimasukkan ke DOM
                        lucide.createIcons();
                    }
                })
                .catch(error => console.error('Error fetching cart:', error));
            };

            // 3. Tambah Item ke Keranjang
            window.addToCart = function(productId, productName) {
                fetch("{{ route('cart.add') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ product_id: productId })
                })
                .then(response => response.json())
                .then(data => {
                    if(data.success) {
                        // Buka laci setelah berhasil masuk keranjang
                        toggleCartDrawer();
                    }
                })
                .catch(error => console.error('Error adding to cart:', error));
            };

            // 4. Ubah Kuantitas
            window.updateQuantity = function(productId, newQuantity) {
                if(newQuantity < 1) {
                    removeItem(productId);
                    return;
                }

                fetch("{{ route('cart.update') }}", {
                    method: 'PATCH',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ id: productId, quantity: newQuantity })
                })
                .then(response => response.json())
                .then(data => {
                    if(data.success) fetchCartData(); // Render ulang jika sukses
                })
                .catch(error => console.error('Error updating cart:', error));
            };

            // 5. Hapus Item
            window.removeItem = function(productId) {
                fetch("{{ route('cart.remove') }}", {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ id: productId })
                })
                .then(response => response.json())
                .then(data => {
                    if(data.success) fetchCartData(); // Render ulang jika sukses
                })
                .catch(error => console.error('Error removing from cart:', error));
            };

            // Jika ada icon keranjang di navbar, update angkanya saat pertama kali load
            // setTimeout(() => fetchCartData(), 500); // Opsional
        });
    </script>
</body>
</html>