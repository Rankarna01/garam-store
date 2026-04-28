<?php

// app/Http/Controllers/AuthController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // Menampilkan halaman login
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // Memproses data login
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $remember = $request->has('remember');

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();

            // CEK ROLE LALU ARAHKAN KE HALAMAN YANG SESUAI
            $role = Auth::user()->role;
            
            if ($role === 'admin') {
                return redirect()->intended('/admin/dashboard');
            } elseif ($role === 'owner') {
                return redirect()->intended('/owner/dashboard');
            }

            // Jika customer, arahkan ke beranda
            return redirect()->intended('/');
        }

        return back()->withErrors([
            'email' => 'Email atau kata sandi yang Anda masukkan salah.',
        ])->onlyInput('email');
    }


    // Menampilkan halaman Register
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    // Memproses Pendaftaran
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = \App\Models\User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => \Illuminate\Support\Facades\Hash::make($request->password),
            'role' => 'customer', // Default role pelanggan
        ]);

        // Langsung login setelah daftar
        Auth::login($user);

        return redirect()->intended('/');
    }

    // Memproses logout
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }

    // Memproses Permintaan Lupa Sandi dari Customer
    public function submitResetRequest(Request $request)
    {
        $request->validate([
            'reset_email' => 'required|email|exists:users,email',
        ], [
            'reset_email.exists' => 'Email ini tidak terdaftar di sistem kami.'
        ]);

        // Simpan permintaan ke tabel
        \App\Models\PasswordResetRequest::create([
            'email' => $request->reset_email,
            'status' => 'pending'
        ]);

        return back()->with('reset_success', 'Permintaan ganti sandi berhasil dikirim! Silakan hubungi Admin atau tunggu konfirmasi sandi baru Anda.');
    }
}