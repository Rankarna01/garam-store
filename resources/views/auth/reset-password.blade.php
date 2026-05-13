<!DOCTYPE html>
<html lang="id">
<head>
    <title>Buat Sandi Baru</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center p-4">
    <div class="bg-white p-8 rounded-2xl shadow-lg max-w-md w-full">
        <h2 class="text-2xl font-bold mb-6 text-gray-800 text-center">Buat Sandi Baru</h2>
        
        @error('password')
            <div class="mb-4 text-red-500 text-sm font-semibold">{{ $message }}</div>
        @enderror

        <form action="{{ route('password.reset.update') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label class="block text-sm font-medium mb-1">Sandi Baru</label>
                <input type="password" name="password" required class="w-full p-3 border rounded-xl outline-none focus:border-blue-500" placeholder="Minimal 8 karakter">
            </div>
            <div class="mb-6">
                <label class="block text-sm font-medium mb-1">Konfirmasi Sandi Baru</label>
                <input type="password" name="password_confirmation" required class="w-full p-3 border rounded-xl outline-none focus:border-blue-500" placeholder="Ulangi sandi">
            </div>
            <button type="submit" class="w-full py-3 bg-green-500 text-white rounded-xl font-bold hover:bg-green-600">Simpan Sandi & Masuk</button>
        </form>
    </div>
</body>
</html>