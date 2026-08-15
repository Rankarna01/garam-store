<x-layouts.admin title="Tambah & Kelola Stok Produk" header="Tambah & Kelola Stok Produk">

    @if(session('success'))
        <div class="mb-6 p-4 bg-green-100 border border-green-200 text-green-700 rounded-2xl flex items-center gap-3 text-sm">
            <i class="fa-solid fa-circle-check text-lg text-green-600"></i>
            <span class="font-medium">{{ session('success') }}</span>
        </div>
    @endif

    @if(session('error'))
        <div class="mb-6 p-4 bg-red-100 border border-red-200 text-red-700 rounded-2xl flex items-center gap-3 text-sm">
            <i class="fa-solid fa-circle-exclamation text-lg text-red-600"></i>
            <span class="font-medium">{{ session('error') }}</span>
        </div>
    @endif

    @if($errors->any())
        <div class="mb-6 p-4 bg-red-100 border border-red-200 text-red-700 rounded-2xl text-sm">
            <p class="font-bold mb-1"><i class="fa-solid fa-triangle-exclamation"></i> Terjadi kesalahan:</p>
            <ul class="list-disc list-inside space-y-1">
                @foreach($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- 4 KARTU STATISTIK STOK -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
        <div class="bg-surface p-5 rounded-2xl shadow-sm border border-gray-100 flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-primary/10 text-primary flex items-center justify-center text-xl">
                <i class="fa-solid fa-cubes-stacked"></i>
            </div>
            <div>
                <p class="text-xs text-textLight font-medium">Total Unit Stok</p>
                <p class="text-xl font-bold text-textDark font-poppins">{{ number_format($totalStock, 0, ',', '.') }}</p>
            </div>
        </div>

        <div class="bg-surface p-5 rounded-2xl shadow-sm border border-gray-100 flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center text-xl">
                <i class="fa-solid fa-box-archive"></i>
            </div>
            <div>
                <p class="text-xs text-textLight font-medium">Total Produk Aktif</p>
                <p class="text-xl font-bold text-textDark font-poppins">{{ $totalProducts }} Produk</p>
            </div>
        </div>

        <div class="bg-surface p-5 rounded-2xl shadow-sm border border-gray-100 flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center text-xl">
                <i class="fa-solid fa-triangle-exclamation"></i>
            </div>
            <div>
                <p class="text-xs text-textLight font-medium">Stok Menipis (≤50)</p>
                <p class="text-xl font-bold text-amber-600 font-poppins">{{ $lowStockCount }} Produk</p>
            </div>
        </div>

        <div class="bg-surface p-5 rounded-2xl shadow-sm border border-gray-100 flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-red-50 text-red-600 flex items-center justify-center text-xl">
                <i class="fa-solid fa-circle-xmark"></i>
            </div>
            <div>
                <p class="text-xs text-textLight font-medium">Stok Habis (0)</p>
                <p class="text-xl font-bold text-red-600 font-poppins">{{ $outOfStockCount }} Produk</p>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        
        <!-- KOLOM KIRI: FORM TAMBAH STOK -->
        <div class="lg:col-span-5">
            <div class="bg-surface rounded-2xl shadow-sm border border-gray-100 p-6 sticky top-6">
                <div class="flex items-center gap-2 pb-4 mb-6 border-b border-gray-100 text-secondary font-bold text-lg">
                    <i class="fa-solid fa-circle-plus text-green-600"></i>
                    <h2>Form Tambah Stok Produk</h2>
                </div>

                <form action="{{ route('admin.stock.add') }}" method="POST" id="addStockForm">
                    @csrf

                    <div class="space-y-5 mb-6">
                        <!-- PILIH PRODUK -->
                        <div>
                            <label class="block text-xs font-semibold text-textDark uppercase tracking-wider mb-2">
                                Pilih Produk yang Ingin Ditambah <span class="text-red-500">*</span>
                            </label>
                            <select name="product_id" id="stockProductSelect" required onchange="onStockProductSelect()" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-primary focus:border-primary outline-none text-sm font-semibold bg-white">
                                <option value="" disabled selected>-- Pilih Produk Garam --</option>
                                @foreach($products as $prod)
                                    <option value="{{ $prod->id }}" data-stock="{{ $prod->stock }}" data-name="{{ $prod->name }}" {{ old('product_id') == $prod->id ? 'selected' : '' }}>
                                        {{ $prod->name }} (Stok: {{ $prod->stock }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- KALKULASI PREVIEW -->
                        <div class="grid grid-cols-2 gap-3 p-4 rounded-xl bg-gray-50 border border-gray-100">
                            <div>
                                <span class="text-xs text-textLight block mb-0.5">Stok Saat Ini</span>
                                <span id="currentStockDisplay" class="text-lg font-bold text-secondary font-poppins">0</span>
                            </div>
                            <div>
                                <span class="text-xs text-textLight block mb-0.5">Total Stok Baru</span>
                                <span id="newTotalStockDisplay" class="text-lg font-bold text-green-600 font-poppins">0</span>
                            </div>
                        </div>

                        <!-- INPUT KUANTITAS TAMBAHAN -->
                        <div>
                            <label class="block text-xs font-semibold text-textDark uppercase tracking-wider mb-2">
                                Jumlah Tambahan Stok <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <input type="number" name="additional_stock" id="additionalStockInput" min="1" required placeholder="Contoh: 100" value="{{ old('additional_stock') }}" oninput="updateStockCalculation()" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-primary focus:border-primary outline-none text-base font-bold text-textDark">
                                <span class="absolute right-4 top-1/2 -translate-y-1/2 text-xs font-semibold text-textLight">Pcs / Bungkus</span>
                            </div>
                        </div>

                        <!-- TOMBOL CEPAT (PILLS) -->
                        <div>
                            <span class="text-xs text-textLight block mb-2 font-medium">Pilih cepat jumlah tambahan:</span>
                            <div class="flex flex-wrap gap-2">
                                <button type="button" onclick="setQuickAdd(10)" class="px-3 py-1 rounded-lg bg-gray-100 hover:bg-primary/10 hover:text-primary text-xs font-semibold text-textDark transition-colors">+10</button>
                                <button type="button" onclick="setQuickAdd(50)" class="px-3 py-1 rounded-lg bg-gray-100 hover:bg-primary/10 hover:text-primary text-xs font-semibold text-textDark transition-colors">+50</button>
                                <button type="button" onclick="setQuickAdd(100)" class="px-3 py-1 rounded-lg bg-gray-100 hover:bg-primary/10 hover:text-primary text-xs font-semibold text-textDark transition-colors">+100</button>
                                <button type="button" onclick="setQuickAdd(500)" class="px-3 py-1 rounded-lg bg-gray-100 hover:bg-primary/10 hover:text-primary text-xs font-semibold text-textDark transition-colors">+500</button>
                                <button type="button" onclick="setQuickAdd(1000)" class="px-3 py-1 rounded-lg bg-gray-100 hover:bg-primary/10 hover:text-primary text-xs font-semibold text-textDark transition-colors">+1000</button>
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white font-bold py-3.5 rounded-xl shadow-lg shadow-green-600/25 transition-all duration-200 flex items-center justify-center gap-2 text-sm">
                        <i class="fa-solid fa-plus-circle text-base"></i> Tambah Stok Sekarang
                    </button>
                </form>
            </div>
        </div>

        <!-- KOLOM KANAN: TABEL STATUS STOK SEMUA PRODUK -->
        <div class="lg:col-span-7">
            <div class="bg-surface rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="p-6 border-b border-gray-100 flex items-center justify-between">
                    <div>
                        <h3 class="text-base font-bold text-secondary">Status Stok Produk</h3>
                        <p class="text-xs text-textLight">Daftar stok produk terkini secara realtime.</p>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-background text-textLight text-xs uppercase tracking-wider">
                                <th class="p-4 font-medium">Produk</th>
                                <th class="p-4 font-medium text-center">Sisa Stok</th>
                                <th class="p-4 font-medium text-center">Status</th>
                                <th class="p-4 font-medium text-center">Aksi Cepat</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 text-sm">
                            @forelse($products as $prod)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="p-4 flex items-center gap-3">
                                    @if($prod->image)
                                        <img src="{{ asset('storage/' . $prod->image) }}" alt="{{ $prod->name }}" class="w-10 h-10 rounded-lg object-cover border border-gray-100">
                                    @else
                                        <div class="w-10 h-10 rounded-lg bg-gray-100 text-gray-400 flex items-center justify-center">
                                            <i class="fa-solid fa-image text-xs"></i>
                                        </div>
                                    @endif
                                    <div>
                                        <p class="font-bold text-textDark text-sm">{{ $prod->name }}</p>
                                        <span class="text-xs text-textLight">{{ $prod->weight }} KG • Rp {{ number_format($prod->price, 0, ',', '.') }}</span>
                                    </div>
                                </td>
                                
                                <td class="p-4 text-center">
                                    <span class="font-bold text-base font-poppins {{ $prod->stock <= 0 ? 'text-red-500' : ($prod->stock <= 50 ? 'text-amber-600' : 'text-secondary') }}">
                                        {{ number_format($prod->stock, 0, ',', '.') }}
                                    </span>
                                </td>

                                <td class="p-4 text-center">
                                    @if($prod->stock <= 0)
                                        <span class="px-2.5 py-1 bg-red-100 text-red-700 text-xs font-bold rounded-full inline-flex items-center gap-1">
                                            <i class="fa-solid fa-circle-xmark text-[10px]"></i> Habis
                                        </span>
                                    @elseif($prod->stock <= 50)
                                        <span class="px-2.5 py-1 bg-amber-100 text-amber-800 text-xs font-bold rounded-full inline-flex items-center gap-1">
                                            <i class="fa-solid fa-triangle-exclamation text-[10px]"></i> Menipis
                                        </span>
                                    @else
                                        <span class="px-2.5 py-1 bg-green-100 text-green-700 text-xs font-bold rounded-full inline-flex items-center gap-1">
                                            <i class="fa-solid fa-circle-check text-[10px]"></i> Aman
                                        </span>
                                    @endif
                                </td>

                                <td class="p-4 text-center">
                                    <button type="button" onclick="selectProductForStock({{ $prod->id }})" class="px-3 py-1.5 rounded-lg bg-primary/10 hover:bg-primary text-primary hover:text-white transition-colors text-xs font-semibold inline-flex items-center gap-1.5" title="Pilih produk ini untuk tambah stok">
                                        <i class="fa-solid fa-pen-to-square"></i> Pilih
                                    </button>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="p-8 text-center text-textLight">Belum ada data produk.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>

    <script>
        let selectedProductStock = 0;

        function onStockProductSelect() {
            const select = document.getElementById('stockProductSelect');
            const selectedOption = select.options[select.selectedIndex];
            selectedProductStock = parseInt(selectedOption.getAttribute('data-stock')) || 0;
            
            document.getElementById('currentStockDisplay').innerText = selectedProductStock;
            updateStockCalculation();
        }

        function updateStockCalculation() {
            const input = document.getElementById('additionalStockInput');
            const addVal = parseInt(input.value) || 0;
            const newTotal = selectedProductStock + Math.max(0, addVal);
            document.getElementById('newTotalStockDisplay').innerText = newTotal;
        }

        function setQuickAdd(amount) {
            const input = document.getElementById('additionalStockInput');
            input.value = amount;
            updateStockCalculation();
            input.focus();
        }

        function selectProductForStock(productId) {
            const select = document.getElementById('stockProductSelect');
            select.value = productId;
            onStockProductSelect();
            document.getElementById('additionalStockInput').focus();
            window.scrollTo({ top: 0, behavior: 'smooth' });
        }

        document.addEventListener('DOMContentLoaded', function() {
            const select = document.getElementById('stockProductSelect');
            if (select.value) {
                onStockProductSelect();
            }
        });
    </script>
</x-layouts.admin>
