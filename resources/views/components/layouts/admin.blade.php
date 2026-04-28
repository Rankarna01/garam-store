<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Admin Dashboard - SaltPro' }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <script src="https://cdn.tailwindcss.com"></script>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#2face0', // Biru laut (utama)
                        secondary: '#253b70', // Biru gelap
                        accent: '#f59e0b', // Kuning/Amber untuk notifikasi/warning
                        surface: '#ffffff', // Putih bersih untuk card
                        background: '#f3f4f6', // Abu-abu sangat terang untuk latar belakang
                        textDark: '#1f2937', // Teks utama
                        textLight: '#6b7280', // Teks sekunder
                    },
                    fontFamily: {
                        poppins: ['Poppins', 'sans-serif'],
                    }
                }
            }
        }
    </script>

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f3f4f6;
        }

        .sidebar-link {
            transition: all 0.3s ease;
        }

        .sidebar-link:hover,
        .sidebar-link.active {
            background-color: rgba(47, 172, 224, 0.1);
            color: #2face0;
            border-right: 4px solid #2face0;
        }

        /* Custom Scrollbar untuk Admin */
        ::-webkit-scrollbar {
            width: 6px;
        }

        ::-webkit-scrollbar-track {
            background: transparent;
        }

        ::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }
    </style>
</head>

<body class="text-textDark antialiased flex h-screen overflow-hidden">

    <aside class="w-64 bg-surface shadow-md flex flex-col h-full z-20">
        <div class="h-16 flex items-center px-6 border-b border-gray-100">
            <a href="{{ route('home') }}" class="flex items-center gap-3 group" title="Kembali ke Halaman Utama">
                <img src="{{ asset('images/logo.png') }}" alt="Logo CV Merisa Jaya" class="h-8 sm:h-9 w-auto object-contain transition-transform duration-300 group-hover:scale-105">
                
                <span class="text-lg font-bold font-poppins text-secondary tracking-tight whitespace-nowrap">
                    CV MERISA<span class="text-primary">JAYA</span>
                </span>
            </a>
        </div>

        <nav class="flex-1 overflow-y-auto py-4">
            <ul class="space-y-1">
                <li>
                    <a href="{{ route('admin.dashboard') }}" class="sidebar-link flex items-center px-6 py-3 text-sm font-medium text-textLight">
                        <i class="fa-solid fa-chart-pie w-6"></i> Dasbor
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.orders.index') }}" class="sidebar-link flex items-center px-6 py-3 text-sm font-medium text-textLight">
                        <i class="fa-solid fa-cart-shopping w-6"></i> Pesanan
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.products.index') }}" class="sidebar-link flex items-center px-6 py-3 text-sm font-medium text-textLight">
                        <i class="fa-solid fa-box-open w-6"></i> Produk
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.users.index') }}" class="sidebar-link flex items-center px-6 py-3 text-sm font-medium text-textLight">
                        <i class="fa-solid fa-users w-6"></i> Pengguna
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.password-resets.index') }}" class="sidebar-link flex items-center px-6 py-3 text-sm font-medium text-textLight">
                        <i class="fa-solid fa-key w-6"></i> Lupa Sandi
                        @php $pendingResets = \App\Models\PasswordResetRequest::where('status', 'pending')->count(); @endphp
                        @if($pendingResets > 0)
                            <span class="ml-auto bg-accent text-white text-[10px] font-bold px-2 py-0.5 rounded-full">{{ $pendingResets }}</span>
                        @endif
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.reports.index') }}" class="sidebar-link flex items-center px-6 py-3 text-sm font-medium text-textLight">
                        <i class="fa-solid fa-file-invoice-dollar w-6"></i> Laporan
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.testimonials.index') }}" class="sidebar-link flex items-center px-6 py-3 text-sm font-medium text-textLight">
                        <i class="fa-solid fa-comments w-6"></i> Testimoni
                    </a>
                </li>
            </ul>
        </nav>

        <div class="p-4 border-t border-gray-100 mt-auto bg-gray-50/50">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit"
                    class="flex items-center w-full gap-3 px-4 py-3 text-sm font-medium text-red-500 hover:bg-red-50 hover:text-red-600 rounded-xl transition-colors text-left shadow-sm border border-transparent hover:border-red-100">
                    <i class="fa-solid fa-right-from-bracket w-5 text-center"></i> Keluar Akun
                </button>
            </form>
        </div>
    </aside>

    <div class="flex-1 flex flex-col h-full overflow-hidden">

        <header class="h-16 bg-surface shadow-sm flex items-center justify-between px-8 z-10">
            <h1 class="text-xl font-semibold">{{ $header ?? 'Dasbor' }}</h1>

            <div class="flex items-center gap-6">
                <button class="relative text-textLight hover:text-primary transition-colors">
                    <i class="fa-regular fa-bell text-xl"></i>
                    <span
                        class="absolute -top-1 -right-1 w-4 h-4 rounded-full bg-accent text-[10px] text-white flex items-center justify-center font-bold border-2 border-surface">3</span>
                </button>

                <div class="flex items-center gap-3 border-l border-gray-200 pl-6">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name ?? 'Admin') }}&background=2face0&color=fff" alt="Admin"
                        class="w-9 h-9 rounded-full object-cover">
                    <div class="hidden md:block">
                        <p class="text-sm font-semibold leading-tight">{{ explode(' ', auth()->user()->name ?? 'Admin Utama')[0] }}</p>
                        <p class="text-xs text-textLight">Administrator</p>
                    </div>
                </div>
            </div>
        </header>

        <main class="flex-1 overflow-y-auto p-8 bg-background">
            {{ $slot }}
        </main>

    </div>

</body>

</html>