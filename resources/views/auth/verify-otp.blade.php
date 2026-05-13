<!DOCTYPE html>
<html lang="id">
<head>
    <title>Verifikasi OTP</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center p-4">
    <div class="bg-white p-8 rounded-2xl shadow-lg max-w-md w-full text-center">
        <h2 class="text-2xl font-bold mb-2 text-gray-800">Cek Email Anda</h2>
        <p class="text-sm text-gray-500 mb-6">Kami telah mengirimkan 6-digit kode OTP ke <b>{{ session('reset_email') }}</b></p>
        
        @if ($errors->any())
            <div class="mb-4 text-red-500 text-sm font-semibold">{{ $errors->first() }}</div>
        @endif

        <form action="{{ route('password.otp.verify') }}" method="POST">
            @csrf
            <input type="text" name="otp" required maxlength="6" class="w-full text-center text-3xl tracking-[10px] font-bold py-3 border border-gray-300 rounded-xl mb-6 focus:border-blue-500 outline-none" placeholder="------">
            <button type="submit" class="w-full py-3 bg-blue-500 text-white rounded-xl font-bold hover:bg-blue-600">Verifikasi Kode</button>
        </form>
    </div>
</body>
</html>