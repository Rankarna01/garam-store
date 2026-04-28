<x-layouts.admin title="Permintaan Reset Sandi" header="Reset Kata Sandi Pelanggan">
    
    @if(session('success'))
        <div class="mb-4 p-4 bg-green-100 border border-green-200 text-green-700 rounded-xl flex items-center gap-2">
            <i class="fa-solid fa-circle-check"></i> {{ session('success') }}
        </div>
    @endif

    <div class="bg-surface rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-6 border-b border-gray-100">
            <h2 class="text-lg font-semibold text-secondary">Daftar Permintaan Lupa Sandi</h2>
        </div>
        
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-background text-textLight text-sm uppercase tracking-wider">
                        <th class="p-4 font-medium">Email Pelanggan</th>
                        <th class="p-4 font-medium">Waktu Permintaan</th>
                        <th class="p-4 font-medium">Status</th>
                        <th class="p-4 font-medium text-right">Aksi Admin (Ganti Sandi)</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($requests as $req)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="p-4 font-semibold text-textDark">{{ $req->email }}</td>
                        <td class="p-4 text-sm text-textLight">{{ $req->created_at->diffForHumans() }}</td>
                        <td class="p-4">
                            @if($req->status === 'pending')
                                <span class="px-3 py-1 bg-orange-100 text-orange-700 text-xs font-bold rounded-full">Menunggu</span>
                            @else
                                <span class="px-3 py-1 bg-green-100 text-green-700 text-xs font-bold rounded-full">Selesai</span>
                            @endif
                        </td>
                        <td class="p-4 text-right">
                            @if($req->status === 'pending')
                                <form action="{{ route('admin.password-resets.update', $req->id) }}" method="POST" class="flex items-center justify-end gap-2">
                                    @csrf @method('PUT')
                                    <input type="text" name="new_password" required placeholder="Ketik sandi baru..." class="px-3 py-1.5 border border-gray-200 rounded-lg text-sm w-40 focus:border-primary outline-none">
                                    <button type="submit" class="bg-primary hover:bg-secondary text-white px-3 py-1.5 rounded-lg text-sm font-medium transition-colors" title="Simpan Sandi Baru">
                                        <i class="fa-solid fa-check"></i>
                                    </button>
                                </form>
                            @else
                                <form action="{{ route('admin.password-resets.destroy', $req->id) }}" method="POST" onsubmit="return confirm('Hapus riwayat ini?');">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="text-sm text-red-500 hover:underline"><i class="fa-solid fa-trash-can"></i> Hapus</button>
                                </form>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="4" class="p-8 text-center text-textLight">Belum ada permintaan reset sandi.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-4 border-t border-gray-100">{{ $requests->links() }}</div>
    </div>
</x-layouts.admin>