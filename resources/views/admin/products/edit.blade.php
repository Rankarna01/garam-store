<x-layouts.admin title="Edit Produk" header="Edit Data Produk">
    
    <div class="bg-surface rounded-xl shadow-sm border border-gray-100 overflow-hidden max-w-4xl">
        
        <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data" class="p-6 md:p-8">
            @csrf
            @method('PUT') <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-textDark mb-2">Nama Produk <span class="text-red-500">*</span></label>
                    <input type="text" name="name" value="{{ old('name', $product->name) }}" required class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary outline-none text-sm">
                </div>

                <div>
                    <label class="block text-sm font-medium text-textDark mb-2">Harga Jual (Rp) <span class="text-red-500">*</span></label>
                    <input type="number" name="price" value="{{ old('price', $product->price) }}" required class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary outline-none text-sm">
                </div>
                <div>
                    <label class="block text-sm font-medium text-textDark mb-2">Harga Coret / Diskon (Rp)</label>
                    <input type="number" name="original_price" value="{{ old('original_price', $product->original_price) }}" class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary outline-none text-sm" placeholder="Opsional">
                </div>

                <div>
                    <label class="block text-sm font-medium text-textDark mb-2">Stok Tersedia <span class="text-red-500">*</span></label>
                    <input type="number" name="stock" value="{{ old('stock', $product->stock) }}" required class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary outline-none text-sm">
                </div>
                <div>
                    <label class="block text-sm font-medium text-textDark mb-2">Berat (KG) <span class="text-red-500">*</span></label>
                    <input type="number" name="weight" value="{{ old('weight', $product->weight) }}" required class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary outline-none text-sm">
                </div>

                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-textDark mb-2">Deskripsi Produk</label>
                    <textarea name="description" rows="4" class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary outline-none text-sm">{{ old('description', $product->description) }}</textarea>
                </div>

                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-textDark mb-2">Foto Produk (Biarkan kosong jika tidak ingin mengubah)</label>
                    
                    @if($product->image)
                        <div class="mb-3">
                            <img src="{{ asset('storage/' . $product->image) }}" alt="Foto Lama" class="w-24 h-24 object-cover rounded-lg border border-gray-200">
                        </div>
                    @endif
                    
                    <input type="file" name="image" accept="image/*" class="w-full text-sm text-textLight file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-primary/10 file:text-primary hover:file:bg-primary/20 transition-colors cursor-pointer border border-gray-200 rounded-lg p-2">
                </div>

                <div class="md:col-span-2 flex items-center mt-2">
                    <input type="checkbox" name="is_active" id="is_active" class="w-4 h-4 text-primary border-gray-300 rounded focus:ring-primary cursor-pointer" {{ $product->is_active ? 'checked' : '' }}>
                    <label for="is_active" class="ml-2 text-sm text-gray-700 cursor-pointer">Tampilkan produk ini di halaman utama</label>
                </div>
            </div>

            <div class="flex items-center gap-4 pt-4 border-t border-gray-100">
                <button type="submit" class="bg-primary hover:bg-secondary text-white px-6 py-2 rounded-lg text-sm font-medium transition-colors">
                    Perbarui Produk
                </button>
                <a href="{{ route('admin.products.index') }}" class="text-textLight hover:text-textDark text-sm font-medium transition-colors">Batal</a>
            </div>
        </form>
    </div>

</x-layouts.admin>