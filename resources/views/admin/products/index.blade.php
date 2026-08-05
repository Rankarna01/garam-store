<x-layouts.admin title="Manajemen Produk" header="Daftar Produk">
    
    @if(session('success'))
        <div class="mb-4 p-4 bg-green-100 border border-green-200 text-green-700 rounded-xl flex items-center gap-2">
            <i class="fa-solid fa-circle-check"></i> {{ session('success') }}
        </div>
    @endif

    <div class="bg-surface rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-6 border-b border-gray-100 flex justify-between items-center">
            <h2 class="text-lg font-semibold text-secondary">Semua Produk</h2>
            <a href="{{ route('admin.products.create') }}" class="bg-primary hover:bg-secondary text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors">
                <i class="fa-solid fa-plus mr-1"></i> Tambah Produk
            </a>
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
                            <a href="{{ route('admin.products.edit', $item->id) }}" class="w-8 h-8 rounded bg-blue-50 text-blue-500 hover:bg-blue-500 hover:text-white transition-colors flex items-center justify-center" title="Edit Produk">
                                <i class="fa-solid fa-pen"></i>
                            </a>
                            
                            <form action="{{ route('admin.products.destroy', $item->id) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus produk ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="w-8 h-8 rounded bg-red-50 text-red-500 hover:bg-red-500 hover:text-white transition-colors flex items-center justify-center" title="Hapus Produk">
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
</x-layouts.admin>