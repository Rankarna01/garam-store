<x-layouts.admin title="Manajemen Testimoni" header="Ulasan Pelanggan">
    
    @if(session('success'))
        <div class="mb-4 p-4 bg-green-100 border border-green-200 text-green-700 rounded-xl flex items-center gap-2">
            <i class="fa-solid fa-circle-check"></i> {{ session('success') }}
        </div>
    @endif

    <div class="bg-surface rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-6 border-b border-gray-100 flex justify-between items-center">
            <h2 class="text-lg font-semibold text-secondary">Semua Testimoni</h2>
            <a href="{{ route('admin.testimonials.create') }}" class="bg-primary hover:bg-secondary text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors">
                <i class="fa-solid fa-plus mr-1"></i> Tambah Baru
            </a>
        </div>
        
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-background text-textLight text-sm uppercase tracking-wider">
                        <th class="p-4 font-medium">Pelanggan</th>
                        <th class="p-4 font-medium">Ulasan & Rating</th>
                        <th class="p-4 font-medium">Status</th>
                        <th class="p-4 font-medium text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($testimonials as $item)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="p-4 flex items-center gap-3">
                            @if($item->avatar)
                                <img src="{{ asset('storage/' . $item->avatar) }}" alt="{{ $item->name }}" class="w-10 h-10 rounded-full object-cover border-2 border-primary/20">
                            @else
                                <div class="w-10 h-10 rounded-full bg-light-blue text-primary flex items-center justify-center font-bold bg-primary/10">
                                    {{ substr($item->name, 0, 1) }}
                                </div>
                            @endif
                            <div>
                                <p class="font-semibold text-textDark">{{ $item->name }}</p>
                                <p class="text-xs text-textLight">{{ $item->profession ?? 'Pelanggan' }}</p>
                            </div>
                        </td>
                        <td class="p-4 max-w-md">
                            <div class="flex text-accent text-xs mb-1">
                                @for($i = 0; $i < $item->rating; $i++) <i class="fa-solid fa-star"></i> @endfor
                            </div>
                            <p class="text-sm text-textLight line-clamp-2">"{{ $item->message }}"</p>
                        </td>
                        <td class="p-4">
                            @if($item->is_active)
                                <span class="px-3 py-1 bg-green-100 text-green-700 text-xs font-bold rounded-full">Tampil</span>
                            @else
                                <span class="px-3 py-1 bg-gray-100 text-gray-700 text-xs font-bold rounded-full">Sembunyi</span>
                            @endif
                        </td>
                        <td class="p-4 text-right">
                            <form action="{{ route('admin.testimonials.destroy', $item->id) }}" method="POST" class="inline" onsubmit="return confirm('Hapus testimoni ini?');">
                                @csrf @method('DELETE')
                                <button type="submit" class="w-8 h-8 rounded bg-red-50 text-red-500 hover:bg-red-500 hover:text-white transition-colors flex items-center justify-center">
                                    <i class="fa-solid fa-trash-can"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="4" class="p-8 text-center text-textLight">Belum ada data testimoni.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-4 border-t border-gray-100">{{ $testimonials->links() }}</div>
    </div>
</x-layouts.admin>