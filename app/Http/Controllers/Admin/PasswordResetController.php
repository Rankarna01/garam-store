<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PasswordResetRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PasswordResetController extends Controller
{
    public function index()
    {
        // Tampilkan semua permintaan yang statusnya 'pending' di atas
        $requests = PasswordResetRequest::orderBy('status', 'desc')->latest()->paginate(10);
        return view('admin.password-resets.index', compact('requests'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'new_password' => 'required|string|min:8',
        ]);

        $resetRequest = PasswordResetRequest::findOrFail($id);
        
        // Cari user berdasarkan email dari request
        $user = User::where('email', $resetRequest->email)->first();
        
        if($user) {
            // Ubah password user tersebut
            $user->update([
                'password' => Hash::make($request->new_password)
            ]);
            
            // Tandai permintaan selesai
            $resetRequest->update(['status' => 'completed']);
            
            return back()->with('success', 'Sandi untuk '.$user->email.' berhasil diubah!');
        }

        return back()->with('error', 'User dengan email tersebut tidak ditemukan.');
    }

    public function destroy($id)
    {
        PasswordResetRequest::findOrFail($id)->delete();
        return back()->with('success', 'Permintaan berhasil dihapus.');
    }
}