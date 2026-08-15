<x-layouts.admin title="Input Transaksi Manual / Cash" header="Input Transaksi Langsung (Kasir / Cash)">

    @if(session('error'))
        <div class="mb-6 p-4 bg-red-100 border border-red-200 text-red-700 rounded-xl flex items-center gap-3">
            <i class="fa-solid fa-circle-exclamation text-lg"></i>
            <span>{{ session('error') }}</span>
        </div>
    @endif

    @if($errors->any())
        <div class="mb-6 p-4 bg-red-100 border border-red-200 text-red-700 rounded-xl">
            <p class="font-bold mb-1 flex items-center gap-2">
                <i class="fa-solid fa-triangle-exclamation"></i> Terdapat kesalahan pengisian:
            </p>
            <ul class="list-disc list-inside text-sm space-y-1">
                @foreach($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="flex items-center gap-4 mb-6">
        <a href="{{ route('admin.orders.index') }}" class="text-textLight hover:text-primary transition-colors flex items-center gap-2 text-sm font-medium">
            <i class="fa-solid fa-arrow-left"></i> Kembali ke Daftar Pesanan
        </a>
    </div>

    <form action="{{ route('admin.orders.storeManual') }}" method="POST" id="manualOrderForm">
        @csrf

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
            
            <!-- KOLOM KIRI: Data Pelanggan & Daftar Barang -->
            <div class="lg:col-span-8 space-y-6">
                
                <!-- Card Data Pelanggan -->
                <div class="bg-surface rounded-2xl shadow-sm border border-gray-100 p-6">
                    <h3 class="text-base font-bold text-secondary mb-4 flex items-center gap-2 pb-3 border-b border-gray-100">
                        <i class="fa-solid fa-user-tag text-primary"></i> Informasi Pelanggan Langsung (Offline)
                    </h3>
                    
                    <div class="grid md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-semibold text-textDark mb-1.5">
                                Nama Pelanggan <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="customer_name" required value="{{ old('customer_name') }}" placeholder="Contoh: Pak Joko / Bu Susi" class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:ring-2 focus:ring-primary focus:border-primary outline-none text-sm">
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-textDark mb-1.5">
                                No. WhatsApp / HP <span class="text-textLight font-normal">(Opsional)</span>
                            </label>
                            <input type="tel" name="customer_phone" value="{{ old('customer_phone') }}" placeholder="081234567890" class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:ring-2 focus:ring-primary focus:border-primary outline-none text-sm">
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-textDark mb-1.5">
                                Email Pelanggan <span class="text-textLight font-normal">(Opsional)</span>
                            </label>
                            <input type="email" name="customer_email" value="{{ old('customer_email') }}" placeholder="pelanggan@email.com" class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:ring-2 focus:ring-primary focus:border-primary outline-none text-sm">
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-textDark mb-1.5">
                                Alamat / Keterangan Toko <span class="text-textLight font-normal">(Opsional)</span>
                            </label>
                            <input type="text" name="customer_address" value="{{ old('customer_address', 'Pembelian Langsung di Toko (Offline/Cash)') }}" placeholder="Alamat atau nama toko pembeli" class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:ring-2 focus:ring-primary focus:border-primary outline-none text-sm">
                        </div>
                    </div>
                </div>

                <!-- Card Pilihan Produk / Item Belanja -->
                <div class="bg-surface rounded-2xl shadow-sm border border-gray-100 p-6">
                    <div class="flex items-center justify-between mb-4 pb-3 border-b border-gray-100">
                        <h3 class="text-base font-bold text-secondary flex items-center gap-2">
                            <i class="fa-solid fa-cart-flatbed text-primary"></i> Produk yang Dibeli
                        </h3>
                        <button type="button" onclick="addProductRow()" class="px-3.5 py-1.5 bg-primary/10 hover:bg-primary text-primary hover:text-white rounded-lg text-xs font-bold transition-colors flex items-center gap-1.5">
                            <i class="fa-solid fa-plus"></i> Tambah Baris Produk
                        </button>
                    </div>

                    <div id="productRowsContainer" class="space-y-4">
                        <!-- Baris Produk akan di-render di sini via JS -->
                    </div>

                    <div class="mt-4 pt-4 border-t border-gray-100 flex justify-between items-center text-sm font-semibold">
                        <span class="text-textLight">Total Item Dipilih: <span id="totalItemsCount" class="text-textDark font-bold">0</span> item</span>
                        <button type="button" onclick="addProductRow()" class="text-primary hover:underline text-xs flex items-center gap-1">
                            <i class="fa-solid fa-circle-plus"></i> Tambah Produk Lain
                        </button>
                    </div>
                </div>

                <!-- Card Catatan Transaksi -->
                <div class="bg-surface rounded-2xl shadow-sm border border-gray-100 p-6">
                    <label class="block text-xs font-semibold text-textDark mb-2">
                        <i class="fa-solid fa-note-sticky text-primary mr-1"></i> Catatan Transaksi <span class="text-textLight font-normal">(Opsional)</span>
                    </label>
                    <textarea name="notes" rows="2" placeholder="Tuliskan catatan khusus untuk transaksi ini (misal: Diskon khusus, no meja, dll)..." class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:ring-2 focus:ring-primary focus:border-primary outline-none text-sm resize-none">{{ old('notes') }}</textarea>
                </div>

            </div>

            <!-- KOLOM KANAN: Kalkulator Kasir & Konfirmasi Pembayaran -->
            <div class="lg:col-span-4 space-y-6">
                
                <div class="bg-surface rounded-2xl shadow-sm border border-gray-100 p-6 sticky top-6">
                    <h3 class="text-base font-bold text-secondary mb-4 pb-3 border-b border-gray-100 flex items-center gap-2">
                        <i class="fa-solid fa-cash-register text-primary"></i> Ringkasan Pembayaran
                    </h3>

                    <div class="space-y-4 mb-6">
                        <div>
                            <label class="block text-xs font-semibold text-textDark mb-1.5">Tanggal Transaksi</label>
                            <input type="datetime-local" name="order_date" value="{{ date('Y-m-d\TH:i') }}" class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:ring-2 focus:ring-primary focus:border-primary outline-none text-sm bg-gray-50 font-medium">
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-textDark mb-1.5">Metode Pembayaran</label>
                            <div class="px-4 py-2.5 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 font-bold text-sm flex items-center gap-2">
                                <i class="fa-solid fa-money-bill-wave text-emerald-600"></i> Cash / Tunai di Tempat
                            </div>
                            <input type="hidden" name="payment_method" value="cash">
                        </div>

                        <!-- TOTAL HARGA -->
                        <div class="p-4 rounded-xl bg-blue-50/70 border border-blue-100 text-center">
                            <span class="text-xs font-medium text-textLight uppercase tracking-wider block mb-1">Total Tagihan</span>
                            <span id="grandTotalDisplay" class="text-2xl sm:text-3xl font-extrabold text-secondary font-poppins">Rp 0</span>
                        </div>

                        <!-- KALKULATOR KEMBALIAN -->
                        <div class="space-y-3 pt-2">
                            <div>
                                <label class="block text-xs font-semibold text-textDark mb-1">Uang Diterima / Cash (Rp)</label>
                                <input type="number" id="cashReceivedInput" placeholder="0" min="0" oninput="calculateChange()" class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:ring-2 focus:ring-primary focus:border-primary outline-none text-sm font-bold text-textDark">
                            </div>

                            <div class="flex justify-between items-center px-4 py-3 rounded-xl bg-gray-50 border border-gray-100">
                                <span class="text-xs font-semibold text-textLight">Kembalian:</span>
                                <span id="changeDisplay" class="text-base font-bold text-green-600 font-poppins">Rp 0</span>
                            </div>
                        </div>
                    </div>

                    <button type="submit" id="submitOrderBtn" class="w-full bg-green-600 hover:bg-green-700 text-white font-bold py-3.5 rounded-xl shadow-lg shadow-green-600/25 transition-all duration-200 flex items-center justify-center gap-2 text-sm">
                        <i class="fa-solid fa-circle-check text-base"></i> Simpan Transaksi Cash
                    </button>
                    <p class="text-[11px] text-textLight text-center mt-2.5">
                        *Stok produk akan otomatis terpotong dan tercatat di laporan penjualan.
                    </p>
                </div>

            </div>

        </div>
    </form>

    <!-- DATA PRODUK UNTUK JAVASCRIPT -->
    <script>
        const availableProducts = @json($products);
        let rowCounter = 0;

        function addProductRow() {
            rowCounter++;
            const container = document.getElementById('productRowsContainer');
            
            const row = document.createElement('div');
            row.id = `product-row-${rowCounter}`;
            row.className = 'p-4 rounded-xl border border-gray-100 bg-gray-50/50 hover:bg-gray-50 transition-colors space-y-3';
            
            let optionsHtml = '<option value="" disabled selected>-- Pilih Produk Garam --</option>';
            availableProducts.forEach(p => {
                const stockLabel = p.stock > 0 ? `(Stok: ${p.stock})` : `(STOK HABIS)`;
                const disabled = p.stock <= 0 ? 'disabled' : '';
                optionsHtml += `<option value="${p.id}" data-price="${p.price}" data-stock="${p.stock}" ${disabled}>${p.name} - Rp ${new Intl.NumberFormat('id-ID').format(p.price)} ${stockLabel}</option>`;
            });

            row.innerHTML = `
                <div class="grid grid-cols-1 md:grid-cols-12 gap-3 items-end">
                    <div class="md:col-span-5">
                        <label class="block text-[11px] font-semibold text-textLight uppercase tracking-wider mb-1">Produk</label>
                        <select name="items[${rowCounter}][product_id]" required onchange="onProductSelect(${rowCounter})" id="product-select-${rowCounter}" class="w-full px-3 py-2 rounded-lg border border-gray-200 focus:ring-2 focus:ring-primary focus:border-primary outline-none text-xs font-semibold bg-white">
                            ${optionsHtml}
                        </select>
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-[11px] font-semibold text-textLight uppercase tracking-wider mb-1">Harga Satuan</label>
                        <input type="number" name="items[${rowCounter}][price]" id="product-price-${rowCounter}" min="0" oninput="calculateSubtotal(${rowCounter})" class="w-full px-3 py-2 rounded-lg border border-gray-200 focus:ring-2 focus:ring-primary focus:border-primary outline-none text-xs font-semibold bg-white" placeholder="0">
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-[11px] font-semibold text-textLight uppercase tracking-wider mb-1">
                            Jumlah <span id="stock-info-${rowCounter}" class="text-[10px] text-primary font-normal"></span>
                        </label>
                        <input type="number" name="items[${rowCounter}][quantity]" id="product-qty-${rowCounter}" min="1" value="1" required oninput="validateRowQty(${rowCounter})" class="w-full px-3 py-2 rounded-lg border border-gray-200 focus:ring-2 focus:ring-primary focus:border-primary outline-none text-xs font-semibold bg-white text-center">
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-[11px] font-semibold text-textLight uppercase tracking-wider mb-1">Subtotal</label>
                        <div class="px-3 py-2 rounded-lg bg-gray-100 text-textDark text-xs font-bold font-poppins" id="product-subtotal-${rowCounter}">
                            Rp 0
                        </div>
                    </div>

                    <div class="md:col-span-1 flex justify-center">
                        <button type="button" onclick="removeProductRow(${rowCounter})" class="w-8 h-8 rounded-lg bg-red-50 text-red-500 hover:bg-red-500 hover:text-white transition-colors flex items-center justify-center text-xs" title="Hapus Item">
                            <i class="fa-solid fa-trash-can"></i>
                        </button>
                    </div>
                </div>
            `;

            container.appendChild(row);
            calculateGrandTotal();
        }

        function removeProductRow(id) {
            const row = document.getElementById(`product-row-${id}`);
            if (row) {
                row.remove();
                calculateGrandTotal();
            }
        }

        function onProductSelect(rowId) {
            const select = document.getElementById(`product-select-${rowId}`);
            const selectedOption = select.options[select.selectedIndex];
            const price = selectedOption.getAttribute('data-price') || 0;
            const stock = parseInt(selectedOption.getAttribute('data-stock')) || 0;

            const priceInput = document.getElementById(`product-price-${rowId}`);
            const qtyInput = document.getElementById(`product-qty-${rowId}`);
            const stockInfo = document.getElementById(`stock-info-${rowId}`);

            priceInput.value = price;
            qtyInput.max = stock;
            stockInfo.innerText = `(Maks: ${stock})`;

            if (parseInt(qtyInput.value) > stock) {
                qtyInput.value = stock;
            }

            calculateSubtotal(rowId);
        }

        function validateRowQty(rowId) {
            const qtyInput = document.getElementById(`product-qty-${rowId}`);
            const max = parseInt(qtyInput.max) || 999999;
            let val = parseInt(qtyInput.value) || 0;

            if (val > max) {
                alert(`Kuantitas melebihi stok yang tersedia (${max})`);
                qtyInput.value = max;
            } else if (val < 1 && qtyInput.value !== '') {
                qtyInput.value = 1;
            }

            calculateSubtotal(rowId);
        }

        function calculateSubtotal(rowId) {
            const priceInput = document.getElementById(`product-price-${rowId}`);
            const qtyInput = document.getElementById(`product-qty-${rowId}`);
            const subtotalDisplay = document.getElementById(`product-subtotal-${rowId}`);

            const price = parseFloat(priceInput.value) || 0;
            const qty = parseInt(qtyInput.value) || 0;
            const subtotal = price * qty;

            if (subtotalDisplay) {
                subtotalDisplay.innerText = 'Rp ' + new Intl.NumberFormat('id-ID').format(subtotal);
            }

            calculateGrandTotal();
        }

        function calculateGrandTotal() {
            let total = 0;
            let totalQty = 0;

            const rows = document.querySelectorAll('#productRowsContainer > div');
            rows.forEach(r => {
                const id = r.id.replace('product-row-', '');
                const priceInput = document.getElementById(`product-price-${id}`);
                const qtyInput = document.getElementById(`product-qty-${id}`);

                if (priceInput && qtyInput) {
                    const p = parseFloat(priceInput.value) || 0;
                    const q = parseInt(qtyInput.value) || 0;
                    total += (p * q);
                    totalQty += q;
                }
            });

            document.getElementById('grandTotalDisplay').innerText = 'Rp ' + new Intl.NumberFormat('id-ID').format(total);
            document.getElementById('totalItemsCount').innerText = totalQty;

            calculateChange();
        }

        function calculateChange() {
            const grandTotalText = document.getElementById('grandTotalDisplay').innerText.replace(/[^0-9]/g, '');
            const grandTotal = parseFloat(grandTotalText) || 0;
            const cashReceived = parseFloat(document.getElementById('cashReceivedInput').value) || 0;
            const changeDisplay = document.getElementById('changeDisplay');

            if (cashReceived >= grandTotal && grandTotal > 0) {
                const change = cashReceived - grandTotal;
                changeDisplay.innerText = 'Rp ' + new Intl.NumberFormat('id-ID').format(change);
                changeDisplay.className = 'text-base font-bold text-green-600 font-poppins';
            } else if (cashReceived > 0 && cashReceived < grandTotal) {
                const shortage = grandTotal - cashReceived;
                changeDisplay.innerText = 'Kurang Rp ' + new Intl.NumberFormat('id-ID').format(shortage);
                changeDisplay.className = 'text-base font-bold text-red-500 font-poppins';
            } else {
                changeDisplay.innerText = 'Rp 0';
                changeDisplay.className = 'text-base font-bold text-gray-500 font-poppins';
            }
        }

        // Jalankan saat pertama kali dibuka: tambahkan 1 baris pertama secara otomatis
        document.addEventListener('DOMContentLoaded', function() {
            addProductRow();
        });
    </script>
</x-layouts.admin>
