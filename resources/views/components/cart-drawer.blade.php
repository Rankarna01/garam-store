<div id="cart-drawer-overlay" class="fixed inset-0 bg-black/50 z-[60] hidden opacity-0 transition-opacity duration-300" onclick="toggleCartDrawer()"></div>

<div id="cart-drawer" class="fixed top-0 right-0 h-full w-full max-w-md bg-white shadow-2xl z-[70] transform translate-x-full transition-transform duration-300 ease-in-out flex flex-col">
    <div class="p-6 border-b border-gray-100 flex items-center justify-between">
        <h2 class="text-xl font-bold font-poppins text-dark-text flex items-center gap-2">
            <i data-lucide="shopping-bag" class="text-sea-blue"></i> Keranjang Belanja
        </h2>
        <button onclick="toggleCartDrawer()" class="p-2 text-gray-400 hover:text-red-500 hover:bg-red-50 rounded-full transition-colors">
            <i data-lucide="x" class="w-5 h-5"></i>
        </button>
    </div>

    <div id="cart-items-container" class="flex-1 overflow-y-auto p-6 space-y-4">
        <div class="flex flex-col items-center justify-center h-full text-gray-400 hidden" id="empty-cart-msg">
            <i data-lucide="shopping-cart" class="w-16 h-16 mb-4 opacity-50"></i>
            <p>Keranjang Anda masih kosong</p>
        </div>
    </div>

    <div class="p-6 border-t border-gray-100 bg-light-blue/30">
        <div class="flex justify-between items-center mb-6">
            <span class="font-medium text-gray-600">Total Pembayaran</span>
            <span id="cart-total-amount" class="text-2xl font-bold font-poppins text-sea-blue">Rp 0</span>
        </div>
        <a href="{{ route('checkout.index') }}" id="checkout-btn" class="w-full btn-primary justify-center text-center opacity-50 pointer-events-none">
            Lanjut ke Pembayaran <i data-lucide="arrow-right" class="w-5 h-5 ml-2"></i>
        </a>
    </div>
</div>