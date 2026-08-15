<x-layouts.admin title="Manajemen Produk" header="Daftar Produk">
    
    @if(session('success'))
        <div class="mb-4 p-4 bg-green-100 border border-green-200 text-green-700 rounded-xl flex items-center gap-2">
            <i class="fa-solid fa-circle-check"></i> {{ session('success') }}
        </div>
    @endif

    <div class="bg-surface rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-6 border-b border-gray-100 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
            <div>
                <h2 class="text-lg font-semibold text-secondary">Semua Produk</h2>
                <p class="text-xs text-textLight">Daftar katalog produk garam yang terdaftar.</p>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('admin.stock.index') }}" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors flex items-center gap-2 shadow-sm">
                    <i class="fa-solid fa-boxes-stacked"></i> Menu Tambah Stok
                </a>
                <a href="{{ route('admin.products.create') }}" class="bg-primary hover:bg-secondary text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors flex items-center gap-2">
                    <i class="fa-solid fa-plus"></i> Tambah Produk Baru
                </a>
            </div>
        </div>
        
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-background text-textLight text-sm uppercase tracking-wider">
                        <th class="p-4 font-medium">Produk</th>
                        <th class="p-4 font-medium">Harga</th>
                        <th class="p-4 font-medium">Stok</th>
                        <th class="p-4 font-medium">Status</th>
                        <th class="p-4 font-medium text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($products as $item)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="p-4 flex items-center gap-3">
                            @if($item->image)
                                <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->name }}" class="w-12 h-12 rounded-lg object-cover">
                            @else
                                <div class="w-12 h-12 rounded-lg bg-gray-200 flex items-center justify-center text-gray-400">
                                    <i class="fa-solid fa-image"></i>
                                </div>
                            @endif
                            <div>
                                <p class="font-semibold text-textDark">{{ $item->name }}</p>
                                <p class="text-xs text-textLight">{{ $item->weight }} KG</p>
                            </div>
                        </td>
                        <td class="p-4 font-medium text-secondary">Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                        <td class="p-4">{{ $item->stock }}</td>
                        <td class="p-4">
                            @if($item->is_active)
                                <span class="px-3 py-1 bg-green-100 text-green-700 text-xs font-bold rounded-full">Aktif</span>
                            @else
                                <span class="px-3 py-1 bg-gray-100 text-gray-700 text-xs font-bold rounded-full">Draft</span>
                            @endif
                        </td>
                       <td class="p-4 flex items-center justify-end gap-2">
                            <button type="button" onclick="openAddStockModal({{ $item->id }}, '{{ addslashes($item->name) }}', {{ $item->stock }})" class="px-3 py-1.5 rounded-lg bg-green-50 text-green-600 hover:bg-green-600 hover:text-white transition-colors flex items-center gap-1.5 text-xs font-semibold shadow-sm" title="Tambah Stok Produk">
                                <i class="fa-solid fa-plus"></i> Tambah Stok
                            </button>
                            
                            <form action="{{ route('admin.products.destroy', $item->id) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus produk ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="w-8 h-8 rounded-lg bg-red-50 text-red-500 hover:bg-red-500 hover:text-white transition-colors flex items-center justify-center text-xs shadow-sm" title="Hapus Produk">
                                    <i class="fa-solid fa-trash-can"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="p-8 text-center text-textLight">Belum ada data produk.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-4 border-t border-gray-100">
            {{ $products->links() }}
        </div>
    </div>

    <!-- MODAL TAMBAH STOK -->
    <div id="addStockModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 hidden opacity-0 transition-opacity duration-200 p-4">
        <div class="bg-surface rounded-2xl shadow-xl max-w-md w-full p-6 border border-gray-100 transform scale-95 transition-transform duration-200" id="addStockModalBox">
            <div class="flex items-center justify-between border-b border-gray-100 pb-4 mb-4">
                <div class="flex items-center gap-2 text-primary font-bold text-lg">
                    <i class="fa-solid fa-boxes-stacked"></i>
                    <h3>Tambah Stok Produk</h3>
                </div>
                <button type="button" onclick="closeAddStockModal()" class="w-8 h-8 rounded-full bg-gray-100 text-gray-400 hover:bg-red-50 hover:text-red-500 flex items-center justify-center transition-colors">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>

            <form id="addStockForm" method="POST" action="">
                @csrf
                <div class="space-y-4 mb-6">
                    <div>
                        <label class="block text-xs font-semibold text-textLight uppercase tracking-wider mb-1">Nama Produk</label>
                        <p id="modalProductName" class="font-bold text-textDark text-base bg-gray-50 p-3 rounded-xl border border-gray-100">-</p>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div class="bg-blue-50/60 p-3 rounded-xl border border-blue-100">
                            <span class="text-xs text-textLight block">Stok Saat Ini</span>
                            <span id="modalCurrentStock" class="text-xl font-bold text-secondary">0</span>
                        </div>
                        <div class="bg-green-50/60 p-3 rounded-xl border border-green-100">
                            <span class="text-xs text-textLight block">Total Setelah Ditambah</span>
                            <span id="modalNewStockPreview" class="text-xl font-bold text-green-600">0</span>
                        </div>
                    </div>

                    <div>
                        <label for="additional_stock" class="block text-sm font-medium text-textDark mb-1.5">
                            Jumlah Stok Tambahan <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <input type="number" name="additional_stock" id="additional_stock" min="1" required placeholder="Contoh: 50" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-primary focus:border-primary outline-none text-sm font-semibold" oninput="calculateNewStock()">
                            <span class="absolute right-4 top-1/2 -translate-y-1/2 text-xs font-medium text-textLight">Item</span>
                        </div>
                        <p class="text-xs text-textLight mt-1">Masukkan jumlah kuantitas stok yang ingin ditambahkan.</p>
                    </div>
                </div>

                <div class="flex items-center justify-end gap-3 pt-2">
                    <button type="button" onclick="closeAddStockModal()" class="px-5 py-2.5 rounded-xl text-sm font-medium text-textLight hover:bg-gray-100 transition-colors">
                        Batal
                    </button>
                    <button type="submit" class="px-5 py-2.5 rounded-xl text-sm font-medium bg-green-600 hover:bg-green-700 text-white shadow-md shadow-green-600/20 transition-colors flex items-center gap-2">
                        <i class="fa-solid fa-floppy-disk"></i> Simpan Stok
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        let currentProductStock = 0;

        function openAddStockModal(productId, productName, currentStock) {
            const modal = document.getElementById('addStockModal');
            const modalBox = document.getElementById('addStockModalBox');
            const form = document.getElementById('addStockForm');
            const nameEl = document.getElementById('modalProductName');
            const currentStockEl = document.getElementById('modalCurrentStock');
            const previewEl = document.getElementById('modalNewStockPreview');
            const inputStock = document.getElementById('additional_stock');

            currentProductStock = parseInt(currentStock) || 0;
            nameEl.innerText = productName;
            currentStockEl.innerText = currentProductStock;
            previewEl.innerText = currentProductStock;
            inputStock.value = '';
            
            // Set form action route URL
            form.action = `/admin/products/${productId}/add-stock`;

            modal.classList.remove('hidden');
            setTimeout(() => {
                modal.classList.remove('opacity-0');
                modalBox.classList.remove('scale-95');
                modalBox.classList.add('scale-100');
                inputStock.focus();
            }, 10);
        }

        function closeAddStockModal() {
            const modal = document.getElementById('addStockModal');
            const modalBox = document.getElementById('addStockModalBox');

            modal.classList.add('opacity-0');
            modalBox.classList.remove('scale-100');
            modalBox.classList.add('scale-95');
            setTimeout(() => {
                modal.classList.add('hidden');
            }, 200);
        }

        function calculateNewStock() {
            const input = document.getElementById('additional_stock');
            const previewEl = document.getElementById('modalNewStockPreview');
            const addVal = parseInt(input.value) || 0;
            const newTotal = currentProductStock + Math.max(0, addVal);
            previewEl.innerText = newTotal;
        }
    </script>
</x-layouts.admin>