<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk - SaltPro</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#2face0',
                        secondary: '#253b70',
                        surface: '#ffffff',
                        background: '#f3f4f6',
                    },
                    fontFamily: {
                        poppins: ['Poppins', 'sans-serif']
                    }
                }
            }
        }
    </script>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
    </style>
</head>

<body class="bg-background min-h-screen flex items-center justify-center p-4">

    <div class="bg-surface w-full max-w-md rounded-2xl shadow-xl overflow-hidden border border-gray-100">
        
        <div class="bg-gradient-to-br from-secondary to-primary p-8 text-center relative overflow-hidden">
            <div class="absolute top-0 right-0 w-32 h-32 bg-white/10 rounded-full blur-2xl -translate-y-1/2 translate-x-1/2"></div>
            <div class="absolute bottom-0 left-0 w-24 h-24 bg-white/10 rounded-full blur-xl translate-y-1/2 -translate-x-1/2"></div>

            <div class="relative z-10">
                <div class="w-16 h-16 rounded-full bg-white/20 flex items-center justify-center mx-auto mb-4 backdrop-blur-sm border border-white/30 shadow-lg p-2">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo CV Merisa Jaya" class="w-full h-full object-contain drop-shadow-md">
                </div>
                <h2 class="text-2xl font-bold text-white mb-1">Selamat Datang!</h2>
                <p class="text-white/80 text-sm">Masuk ke akun SaltPro Anda</p>
            </div>
        </div>

        <div class="p-8">
            @if ($errors->any() && !$errors->has('reset_email'))
                <div class="mb-6 p-3 rounded-lg bg-red-100 text-red-700 text-sm border border-red-200 flex items-center gap-2">
                    <i class="fa-solid fa-circle-exclamation"></i>
                    {{ $errors->first() }}
                </div>
            @endif

            <form action="{{ route('login.post') }}" method="POST" class="space-y-6">
                @csrf

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Alamat Email</label>
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none transition-colors group-focus-within:text-primary">
                            <i class="fa-regular fa-envelope text-gray-400 group-focus-within:text-primary transition-colors"></i>
                        </div>
                        <input type="email" name="email" value="{{ old('email') }}" required
                            class="w-full pl-10 pr-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all outline-none text-sm bg-gray-50 focus:bg-white"
                            placeholder="nama@email.com">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Kata Sandi</label>
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fa-solid fa-lock text-gray-400 group-focus-within:text-primary transition-colors"></i>
                        </div>
                        <input type="password" name="password" required
                            class="w-full pl-10 pr-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all outline-none text-sm bg-gray-50 focus:bg-white"
                            placeholder="••••••••">
                    </div>
                </div>

                <div class="flex items-center justify-end">
                    <button type="button" onclick="document.getElementById('resetModal').classList.remove('hidden')" class="text-sm text-primary font-medium hover:text-secondary transition-colors outline-none">
                        Lupa Sandi?
                    </button>
                </div>

                <button type="submit"
                    class="w-full py-3 bg-gradient-to-r from-primary to-secondary text-white rounded-xl font-semibold shadow-lg shadow-primary/30 hover:shadow-primary/50 transition-all transform hover:-translate-y-0.5 flex items-center justify-center gap-2">
                    Masuk Sekarang <i class="fa-solid fa-arrow-right text-sm"></i>
                </button>
            </form>

            <div class="mt-8 pt-6 border-t border-gray-100 text-center">
                <p class="text-sm text-gray-600">
                    Belum punya akun?
                    <a href="{{ route('register') }}"
                        class="text-primary font-bold hover:text-secondary hover:underline transition-colors ml-1">
                        Daftar di sini
                    </a>
                </p>
            </div>
        </div>
    </div>

    <div id="resetModal" class="fixed inset-0 bg-black/60 z-50 hidden flex items-center justify-center p-4 backdrop-blur-sm transition-opacity">
        <div class="bg-white rounded-2xl w-full max-w-md p-6 shadow-2xl transform transition-all relative">
            
            <button type="button" onclick="document.getElementById('resetModal').classList.add('hidden')" class="absolute top-4 right-4 text-gray-400 hover:text-red-500 transition-colors outline-none">
                <i class="fa-solid fa-xmark text-xl"></i>
            </button>

            <div class="text-center mb-6 mt-2">
                <div class="w-16 h-16 bg-blue-50 rounded-full flex items-center justify-center mx-auto mb-4 text-primary">
                    <i class="fa-solid fa-headset text-3xl"></i>
                </div>
                <h3 class="text-xl font-bold text-dark-text font-poppins">Lupa Kata Sandi?</h3>
                <p class="text-sm text-gray-500 mt-2">Masukkan email Anda. Permintaan reset sandi akan dikirim ke Admin kami untuk diproses secara manual.</p>
            </div>

            @if(session('reset_success'))
                <div class="mb-5 p-3 bg-green-100 text-green-700 rounded-xl text-sm text-center font-medium border border-green-200">
                    <i class="fa-solid fa-circle-check mr-1"></i> {{ session('reset_success') }}
                </div>
                <script>
                    // Otomatis buka modal jika ada pesan sukses
                    document.getElementById('resetModal').classList.remove('hidden');
                </script>
            @endif

            <form action="{{ route('password.request.submit') }}" method="POST">
                @csrf
                <div class="mb-5">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Email Terdaftar</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fa-regular fa-envelope text-gray-400"></i>
                        </div>
                        <input type="email" name="reset_email" required 
                            class="w-full pl-10 pr-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all outline-none text-sm bg-gray-50 focus:bg-white" 
                            placeholder="nama@email.com">
                    </div>
                    
                    @error('reset_email')
                        <span class="text-xs text-red-500 mt-2 block font-medium"><i class="fa-solid fa-circle-exclamation"></i> {{ $message }}</span>
                        <script>
                            // Otomatis buka modal jika validasi email gagal
                            document.getElementById('resetModal').classList.remove('hidden');
                        </script>
                    @enderror
                </div>

                <button type="submit" class="w-full py-3 bg-primary text-white rounded-xl font-semibold shadow-lg hover:bg-secondary transition-colors">
                    Kirim Permintaan ke Admin
                </button>
            </form>
        </div>
    </div>

</body>

</html>