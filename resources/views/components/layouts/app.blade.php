<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Toko Garam Premium' }}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Lato:wght@300;400;700&display=swap" rel="stylesheet">
    
    <script src="https://cdn.tailwindcss.com"></script>
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/ScrollTrigger.min.js"></script>
    
    <script src="https://unpkg.com/lucide@latest"></script>
    
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'sea-blue': '#2face0',
                        'deep-blue': '#253b70',
                        'light-blue': '#e8f7fc',
                        'dark-text': '#0e181d',
                        'grey-text': '#5e5e5e',
                    },
                    fontFamily: {
                        'poppins': ['Poppins', 'sans-serif'],
                        'lato': ['Lato', 'sans-serif'],
                    }
                }
            }
        }
    </script>
    
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Lato', sans-serif; overflow-x: hidden; }
        h1, h2, h3, h4, h5, h6 { font-family: 'Poppins', sans-serif; }
        
        .text-gradient {
            background: linear-gradient(135deg, #2face0 0%, #253b70 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        
        .btn-primary {
            background: linear-gradient(135deg, #2face0 0%, #253b70 100%);
            color: white; padding: 12px 32px; border-radius: 9999px;
            font-weight: 500; transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(47, 172, 224, 0.3);
            display: inline-flex; align-items: center; gap: 8px;
            border: none; cursor: pointer;
        }
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(47, 172, 224, 0.4);
        }
        
        .btn-secondary {
            border: 2px solid #2face0; color: #2face0;
            padding: 12px 32px; border-radius: 9999px;
            font-weight: 500; transition: all 0.3s ease;
            display: inline-flex; align-items: center; gap: 8px;
            background: transparent; cursor: pointer;
        }
        .btn-secondary:hover { background: #2face0; color: white; transform: translateY(-2px); }
        
        .card-hover { transition: all 0.5s ease; }
        .card-hover:hover { transform: translateY(-10px); box-shadow: 0 20px 40px rgba(47, 172, 224, 0.15); }
        
        @keyframes floating { 0%, 100% { transform: translateY(0px); } 50% { transform: translateY(-15px); } }
        .floating { animation: floating 3s ease-in-out infinite; }
        .floating-delayed { animation: floating 3s ease-in-out infinite; animation-delay: 1.5s; }
        
        @keyframes pulse-ring { 0% { transform: scale(1); opacity: 1; } 100% { transform: scale(1.5); opacity: 0; } }
        .pulse-ring { animation: pulse-ring 2s ease-out infinite; }
        
        ::-webkit-scrollbar { width: 8px; }
        ::-webkit-scrollbar-track { background: #e8f7fc; }
        ::-webkit-scrollbar-thumb { background: #2face0; border-radius: 4px; }
        ::-webkit-scrollbar-thumb:hover { background: #253b70; }
        ::selection { background: #2face0; color: white; }
        
        .nav-link { position: relative; }
        .nav-link::after {
            content: ''; position: absolute; bottom: -4px; left: 0; width: 0; height: 2px;
            background: linear-gradient(135deg, #2face0 0%, #253b70 100%); transition: width 0.3s ease;
        }
        .nav-link:hover::after { width: 100%; }
        
        .product-card { background: white; border-radius: 24px; overflow: hidden; box-shadow: 0 10px 30px rgba(0,0,0,0.1); transition: all 0.5s ease; }
        .product-card:hover { transform: translateY(-10px); box-shadow: 0 20px 40px rgba(47, 172, 224, 0.15); }
        .product-card img { transition: transform 0.7s ease; }
        .product-card:hover img { transform: scale(1.1); }
        
        .testimonial-card { transition: all 0.5s ease; }
        .form-input:focus { border-color: #2face0; box-shadow: 0 0 0 3px rgba(47, 172, 224, 0.2); outline: none; }
        
        .mobile-menu { max-height: 0; overflow: hidden; transition: max-height 0.5s ease; }
        .mobile-menu.open { max-height: 400px; }
        
        .particle { position: absolute; width: 8px; height: 8px; border-radius: 50%; background: rgba(47, 172, 224, 0.3); pointer-events: none; }
        
        @media (prefers-reduced-motion: reduce) {
            *, *::before, *::after { animation-duration: 0.01ms !important; animation-iteration-count: 1 !important; transition-duration: 0.01ms !important; }
        }
    </style>
</head>
<body class="bg-light-blue text-dark-text antialiased">
    
    <main>
        {{ $slot }}
    </main>

    <script>
        lucide.createIcons();
    </script>
</body>
</html>