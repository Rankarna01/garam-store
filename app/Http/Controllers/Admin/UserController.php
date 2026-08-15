<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        // Menampilkan pengguna terbaru, batasi 10 per halaman
        $users = User::latest()->paginate(10);
        return view('admin.users.index', compact('users'));
    }

    public function updateRole(Request $request, User $user)
    {
        $request->validate(['role' => 'required|in:admin,customer,owner']);
        
        // Mencegah admin menghapus akses admin dirinya sendiri
        if($user->id === auth()->id() && $request->role !== 'admin') {
            return back()->with('error', 'Anda tidak bisa mengubah role akun Anda sendiri!');
        }

        $user->update(['role' => $request->role]);
        return back()->with('success', 'Role pengguna berhasil diperbarui!');
    }

    public function destroy(User $user)
    {
        if($user->id === auth()->id()) {
            return back()->with('error', 'Anda tidak bisa menghapus akun sendiri!');
        }
        
        $user->delete();
        return back()->with('success', 'Pengguna berhasil dihapus!');
    }
}