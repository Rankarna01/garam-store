<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;
use App\Models\User;

class AuthController extends Controller
{
    public function showLoginForm() { return view('auth.login'); }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $remember = $request->has('remember');

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();
            $role = Auth::user()->role;
            
            if ($role === 'admin') return redirect()->intended('/admin/dashboard');
            elseif ($role === 'owner') return redirect()->intended('/owner/dashboard');
            
            return redirect()->intended('/');
        }

        return back()->withErrors(['email' => 'Email atau kata sandi salah.'])->onlyInput('email');
    }

    public function showRegisterForm() { return view('auth.register'); }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'customer',
        ]);

        Auth::login($user);
        return redirect()->intended('/');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }

    // ==========================================
    // LOGIKA LUPA SANDI (EMAIL OTP)
    // ==========================================

    // 1. Kirim OTP ke Email
    public function submitResetRequest(Request $request)
    {
        $request->validate([
            'reset_email' => 'required|email|exists:users,email',
        ], ['reset_email.exists' => 'Email ini tidak terdaftar di sistem kami.']);

        $email = $request->reset_email;
        $otp = rand(100000, 999999); // Generate 6 digit angka acak

        // Simpan OTP ke tabel default Laravel (password_reset_tokens)
        DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $email],
            ['token' => $otp, 'created_at' => Carbon::now()]
        );

        // Kirim Email
        Mail::send('emails.otp', ['otp' => $otp], function($message) use($email) {
            $message->to($email);
            $message->subject('Kode OTP Reset Sandi - SaltPro');
        });

        // Simpan email ke session dan arahkan ke form OTP
        session()->put('reset_email', $email);
        return redirect()->route('password.otp.form')->with('success', 'Kode OTP telah dikirim ke email Anda.');
    }

    // 2. Tampilkan Form Input OTP
    public function showOtpForm()
    {
        if(!session('reset_email')) return redirect()->route('login');
        return view('auth.verify-otp');
    }

    // 3. Verifikasi OTP
    public function verifyOtp(Request $request)
    {
        $request->validate(['otp' => 'required|numeric']);
        $email = session('reset_email');

        $record = DB::table('password_reset_tokens')->where('email', $email)->first();

        if(!$record || $record->token !== $request->otp) {
            return back()->withErrors(['otp' => 'Kode OTP tidak valid atau salah.']);
        }

        // Cek kedaluwarsa (15 Menit)
        if(Carbon::parse($record->created_at)->addMinutes(15)->isPast()) {
            DB::table('password_reset_tokens')->where('email', $email)->delete();
            return back()->withErrors(['otp' => 'Kode OTP sudah kedaluwarsa. Silakan minta ulang.']);
        }

        // Jika Benar, arahkan ke form buat sandi baru
        session()->put('otp_verified', true);
        return redirect()->route('password.reset.form');
    }

    // 4. Tampilkan Form Sandi Baru
    public function showResetPasswordForm()
    {
        if(!session('otp_verified') || !session('reset_email')) return redirect()->route('login');
        return view('auth.reset-password');
    }

    // 5. Simpan Sandi Baru ke Database
    public function updatePassword(Request $request)
    {
        $request->validate(['password' => 'required|string|min:8|confirmed']);
        $email = session('reset_email');

        User::where('email', $email)->update([
            'password' => Hash::make($request->password)
        ]);

        // Hapus token dan bersihkan session
        DB::table('password_reset_tokens')->where('email', $email)->delete();
        session()->forget(['reset_email', 'otp_verified']);

        return redirect()->route('login')->with('login_success', 'Kata sandi berhasil diubah! Silakan masuk dengan sandi baru Anda.');
    }
}