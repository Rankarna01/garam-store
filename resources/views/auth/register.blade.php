<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Akun - SaltPro</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: { extend: { colors: { primary: '#2face0', secondary: '#253b70', surface: '#ffffff', background: '#f3f4f6', }, fontFamily: { poppins: ['Poppins', 'sans-serif'] } } }
        }
    </script>
    <style>body { font-family: 'Poppins', sans-serif; }</style>
</head>
<body class="bg-background min-h-screen flex items-center justify-center p-4">

    <div class="bg-surface w-full max-w-md rounded-2xl shadow-xl overflow-hidden border border-gray-100 my-8">
        <div class="bg-gradient-to-br from-secondary to-primary p-8 text-center">
            <h2 class="text-2xl font-bold text-white mb-1">Bergabung dengan SaltPro</h2>
            <p class="text-white/80 text-sm">Daftar untuk mulai berbelanja produk kami</p>
        </div>

        <div class="p-8">
            @if ($errors->any())
                <div class="mb-6 p-3 rounded-lg bg-red-100 text-red-700 text-sm border border-red-200">
                    {{ $errors->first() }}
                </div>
            @endif

            <form action="{{ route('register.post') }}" method="POST" class="space-y-5">
                @csrf 
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
                    <input type="text" name="name" value="{{ old('name') }}" required class="w-full px-4 py-2 border border-gray-200 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary outline-none" placeholder="Budi Santoso">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Alamat Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" required class="w-full px-4 py-2 border border-gray-200 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary outline-none" placeholder="budi@email.com">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Kata Sandi</label>
                    <input type="password" name="password" required class="w-full px-4 py-2 border border-gray-200 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary outline-none" placeholder="Minimal 8 karakter">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Konfirmasi Kata Sandi</label>
                    <input type="password" name="password_confirmation" required class="w-full px-4 py-2 border border-gray-200 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary outline-none" placeholder="Ketik ulang kata sandi">
                </div>

                <button type="submit" class="w-full py-3 bg-gradient-to-r from-primary to-secondary text-white rounded-xl font-semibold hover:shadow-lg transition-all mt-4">
                    Daftar Sekarang
                </button>

                <p class="text-center text-sm text-gray-600 mt-4">
                    Sudah punya akun? <a href="{{ route('login') }}" class="text-primary font-bold hover:underline">Masuk di sini</a>
                </p>
            </form>
        </div>
    </div>
</body>
</html>