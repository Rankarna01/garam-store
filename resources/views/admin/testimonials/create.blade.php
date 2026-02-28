<x-layouts.admin title="Tambah Testimoni" header="Tambah Ulasan Baru">
    
    <div class="bg-surface rounded-xl shadow-sm border border-gray-100 overflow-hidden max-w-3xl">
        <form action="{{ route('admin.testimonials.store') }}" method="POST" enctype="multipart/form-data" class="p-6 md:p-8">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label class="block text-sm font-medium text-textDark mb-2">Nama Pelanggan <span class="text-red-500">*</span></label>
                    <input type="text" name="name" required class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary outline-none text-sm" placeholder="Contoh: Siti Aminah">
                </div>

                <div>
                    <label class="block text-sm font-medium text-textDark mb-2">Profesi / Label</label>
                    <input type="text" name="profession" class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary outline-none text-sm" placeholder="Contoh: Pemilik Restoran">
                </div>

                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-textDark mb-2">Penilaian (Bintang) <span class="text-red-500">*</span></label>
                    <select name="rating" required class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary outline-none text-sm text-accent font-bold">
                        <option value="5">⭐⭐⭐⭐⭐ (5 Bintang)</option>
                        <option value="4">⭐⭐⭐⭐ (4 Bintang)</option>
                        <option value="3">⭐⭐⭐ (3 Bintang)</option>
                        <option value="2">⭐⭐ (2 Bintang)</option>
                        <option value="1">⭐ (1 Bintang)</option>
                    </select>
                </div>

                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-textDark mb-2">Isi Testimoni <span class="text-red-500">*</span></label>
                    <textarea name="message" required rows="4" class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary outline-none text-sm" placeholder="Tuliskan ulasan pelanggan di sini..."></textarea>
                </div>

                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-textDark mb-2">Foto Profil (Opsional)</label>
                    <input type="file" name="avatar" accept="image/*" class="w-full text-sm text-textLight file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-primary/10 file:text-primary hover:file:bg-primary/20 transition-colors cursor-pointer border border-gray-200 rounded-lg p-2">
                </div>

                <div class="md:col-span-2 flex items-center mt-2">
                    <input type="checkbox" name="is_active" id="is_active" checked class="w-4 h-4 text-primary border-gray-300 rounded focus:ring-primary cursor-pointer">
                    <label for="is_active" class="ml-2 text-sm text-gray-700 cursor-pointer">Tampilkan testimoni ini di Landing Page</label>
                </div>
            </div>

            <div class="flex items-center gap-4 pt-4 border-t border-gray-100">
                <button type="submit" class="bg-primary hover:bg-secondary text-white px-6 py-2 rounded-lg text-sm font-medium transition-colors">
                    Simpan Testimoni
                </button>
                <a href="{{ route('admin.testimonials.index') }}" class="text-textLight hover:text-textDark text-sm font-medium transition-colors">Batal</a>
            </div>
        </form>
    </div>

</x-layouts.admin>