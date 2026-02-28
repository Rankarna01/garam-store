<x-layouts.app title="Pembayaran - GaramPro">
    
    <div class="bg-white shadow-sm">
        <x-navbar />
    </div>

    <main class="pt-32 pb-24 bg-[#f8fdff] min-h-screen flex items-center justify-center">
        <div class="w-full max-w-lg mx-auto px-4">
            
            <div class="bg-white rounded-3xl shadow-xl p-8 border border-light-blue text-center">
                <div class="w-20 h-20 bg-light-blue rounded-full flex items-center justify-center mx-auto mb-6">
                    <i data-lucide="wallet" class="text-sea-blue w-10 h-10"></i>
                </div>
                
                <h2 class="text-2xl font-bold font-poppins text-dark-text mb-2">Selesaikan Pembayaran</h2>
                <p class="text-grey-text mb-6">Invoice: <span class="font-semibold text-dark-text">{{ $order->invoice_number }}</span></p>
                
                <div class="bg-[#f8fdff] rounded-xl p-6 mb-8 border border-gray-100">
                    <p class="text-sm text-grey-text mb-1">Total Tagihan</p>
                    <h1 class="text-4xl font-bold text-sea-blue font-poppins mb-4">Rp {{ number_format($order->total_price, 0, ',', '.') }}</h1>
                    
                    <div class="text-left space-y-2 text-sm border-t border-gray-100 pt-4 mt-4">
                        <div class="flex justify-between">
                            <span class="text-grey-text">Nama Pelanggan</span>
                            <span class="font-medium text-dark-text">{{ $order->customer_name }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-grey-text">Status</span>
                            <span class="font-medium text-accent">Menunggu Pembayaran</span>
                        </div>
                    </div>
                </div>

                <button id="pay-button" class="w-full btn-primary justify-center text-lg py-4 shadow-xl shadow-sea-blue/20 flex items-center gap-2 transition-transform hover:-translate-y-1">
                    <i data-lucide="credit-card" class="w-5 h-5"></i> Bayar Sekarang
                </button>
            </div>
            
        </div>
    </main>

    <x-footer />

    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>
    
    <script>
        document.getElementById('pay-button').onclick = function () {
            
            // Ubah tombol jadi loading
            const btn = document.getElementById('pay-button');
            const originalText = btn.innerHTML;
            btn.innerHTML = '<i data-lucide="loader" class="w-5 h-5 animate-spin"></i> Memproses...';
            lucide.createIcons();

            snap.pay('{{ $order->snap_token }}', {
                // Callback jika pembayaran sukses
                onSuccess: function(result) {
                    // Tembak rute backend kita sendiri pakai Fetch API untuk ubah status ke Paid
                    fetch(`{{ route('checkout.success_local', $order->invoice_number) }}`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify(result)
                    })
                    .then(response => response.json())
                    .then(data => {
                        // Redirect langsung ke halaman Lacak Pesanan
                        window.location.href = "{{ route('order.track', $order->invoice_number) }}";
                    })
                    .catch(error => {
                        // Jika fetch gagal, tetap lempar ke halaman pelacakan
                        window.location.href = "{{ route('order.track', $order->invoice_number) }}";
                    });
                },
                
                // Callback jika pembayaran pending (misal: bayar pakai VA / Indomaret yang butuh kode bayar)
                onPending: function(result) {
                    alert("Menunggu pembayaran Anda diselesaikan.");
                    // Redirect ke halaman pelacakan agar user bisa simpan link-nya
                    window.location.href = "{{ route('order.track', $order->invoice_number) }}";
                },
                
                // Callback jika gagal
                onError: function(result) {
                    alert("Pembayaran gagal! Silakan coba lagi.");
                    btn.innerHTML = originalText;
                    lucide.createIcons(); // render ulang icon
                },
                
                // Callback jika user menutup popup tanpa bayar
                onClose: function() {
                    alert('Anda menutup jendela pembayaran sebelum menyelesaikannya.');
                    btn.innerHTML = originalText;
                    lucide.createIcons(); // render ulang icon
                }
            });
        };
    </script>
</x-layouts.app>