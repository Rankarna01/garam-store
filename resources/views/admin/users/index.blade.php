<x-layouts.admin title="Manajemen Pengguna" header="Daftar Pengguna Akun">
    
    @if(session('success'))
        <div class="mb-4 p-4 bg-green-100 text-green-700 rounded-xl flex items-center gap-2"><i class="fa-solid fa-check"></i> {{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="mb-4 p-4 bg-red-100 text-red-700 rounded-xl flex items-center gap-2"><i class="fa-solid fa-triangle-exclamation"></i> {{ session('error') }}</div>
    @endif

    <div class="bg-surface rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-background text-textLight text-sm uppercase tracking-wider">
                        <th class="p-4 font-medium">Nama & Email</th>
                        <th class="p-4 font-medium">Bergabung Pada</th>
                        <th class="p-4 font-medium">Hak Akses (Role)</th>
                        <th class="p-4 font-medium text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach($users as $user)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="p-4 flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full bg-primary/10 text-primary flex items-center justify-center font-bold">
                                {{ substr($user->name, 0, 1) }}
                            </div>
                            <div>
                                <p class="font-semibold text-textDark">{{ $user->name }}</p>
                                <p class="text-xs text-textLight">{{ $user->email }}</p>
                            </div>
                        </td>
                        <td class="p-4 text-sm text-textLight">{{ $user->created_at->format('d M Y') }}</td>
                        <td class="p-4">
                            <form action="{{ route('admin.users.updateRole', $user->id) }}" method="POST" class="flex items-center gap-2">
                                @csrf @method('PUT')
                                <select name="role" onchange="this.form.submit()" class="px-3 py-1 rounded-lg text-sm border border-gray-200 outline-none {{ $user->role === 'admin' ? 'bg-primary/10 text-primary font-bold' : 'bg-gray-100' }}">
                                    <option value="customer" {{ $user->role == 'customer' ? 'selected' : '' }}>Pelanggan</option>
                                    <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
                                </select>
                            </form>
                        </td>
                        <td class="p-4 text-right">
                            <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="inline" onsubmit="return confirm('Hapus pengguna ini secara permanen?');">
                                @csrf @method('DELETE')
                                <button type="submit" class="w-8 h-8 rounded bg-red-50 text-red-500 hover:bg-red-500 hover:text-white transition-colors flex items-center justify-center">
                                    <i class="fa-solid fa-trash-can"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="p-4 border-t border-gray-100">{{ $users->links() }}</div>
    </div>
</x-layouts.admin>