<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'LuxeBoard') }} | Premium Board Game Shop</title>
    
    <!-- Meta SEO -->
    <meta name="description" content="Welcome to LuxeBoard, the ultimate curation of premium luxury board games, expansions, and accessories. Experience tabletop games in their finest editorial aesthetic.">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&family=Playfair+Display:ital,wght@0,400;0,600;0,700;1,400&display=swap" rel="stylesheet">

    <!-- FontAwesome (Icons) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Styles & Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="bg-moss-deep text-gray-100 min-h-screen flex flex-col justify-between selection:bg-gold-burnished selection:text-moss-deep">

    <!-- Global Split-Tier Navbar -->
    <livewire:navbar />

    <!-- Main Content Area -->
    <main class="flex-grow pt-24">
        {{ $slot }}
    </main>

    <!-- Global Cinematic Auth Modal -->
    <livewire:auth-modal />

    <!-- Global Footer -->
    <footer class="bg-moss-deep border-t border-moss-slate mt-20">
        <div class="max-w-7xl mx-auto px-6 py-16 grid grid-cols-1 md:grid-cols-4 gap-12">
            <!-- Column 1: Store Emblem & Bio -->
            <div class="space-y-6">
                <a href="/" class="flex items-center space-x-3">
                    <span class="text-2xl font-serif tracking-wider text-gradient-gold font-bold">LUXEBOARD</span>
                </a>
                <p class="text-sm text-gray-400 leading-relaxed font-light">
                    Kurasi board game paling mewah dan eksklusif di dunia. Kami menghadirkan seni permainan di atas meja Anda dengan kualitas komponen terbaik dan keaslian yang terjamin.
                </p>
                <div class="text-xs text-gray-500 space-y-1">
                    <p class="flex items-center"><i class="fa-solid fa-map-marker-alt text-gold-burnished mr-2 w-4"></i> Sovereign Suite 40B, Jakarta</p>
                </div>
                <!-- Social Icons -->
                <div class="flex space-x-4 pt-2">
                    <a href="https://tiktok.com" target="_blank" class="text-gray-400 hover:text-gold-burnished transition-colors duration-300"><i class="fa-brands fa-tiktok text-lg"></i></a>
                    <a href="https://instagram.com" target="_blank" class="text-gray-400 hover:text-gold-burnished transition-colors duration-300"><i class="fa-brands fa-instagram text-lg"></i></a>
                    <a href="https://facebook.com" target="_blank" class="text-gray-400 hover:text-gold-burnished transition-colors duration-300"><i class="fa-brands fa-facebook-f text-lg"></i></a>
                    <a href="https://youtube.com" target="_blank" class="text-gray-400 hover:text-gold-burnished transition-colors duration-300"><i class="fa-brands fa-youtube text-lg"></i></a>
                    <a href="https://x.com" target="_blank" class="text-gray-400 hover:text-gold-burnished transition-colors duration-300"><i class="fa-brands fa-x-twitter text-lg"></i></a>
                </div>
            </div>

            <!-- Column 2: Navigation Links -->
            <div class="space-y-4">
                <h4 class="text-xs uppercase tracking-widest text-gold-burnished font-semibold">Tautan Navigasi</h4>
                <ul class="space-y-2 text-sm font-light text-gray-300">
                    <li><a href="/catalog" class="hover:text-gold-burnished transition-colors duration-300">Katalog Produk</a></li>
                    <li><a href="/about-us" class="hover:text-gold-burnished transition-colors duration-300">Tentang Kami</a></li>
                    <li><a href="/contact-us" class="hover:text-gold-burnished transition-colors duration-300">Hubungi Kami</a></li>
                    <li><a href="/about-us#location" class="hover:text-gold-burnished transition-colors duration-300">Lokasi Butik</a></li>
                    <li><a href="/contact-us#faq" class="hover:text-gold-burnished transition-colors duration-300">Pertanyaan Umum (FAQ)</a></li>
                </ul>
            </div>

            <!-- Column 3: Customer Care -->
            <div class="space-y-4">
                <h4 class="text-xs uppercase tracking-widest text-gold-burnished font-semibold">Layanan Pelanggan</h4>
                <ul class="space-y-3 text-sm font-light text-gray-300">
                    <li class="flex items-start">
                        <i class="fa-solid fa-phone text-gold-burnished mt-1 mr-2 w-4"></i>
                        <div>
                            <p class="font-medium text-gray-200">Guild Hotline</p>
                            <p class="text-xs text-gray-400">+62 811-987-654</p>
                        </div>
                    </li>
                    <li class="flex items-start">
                        <i class="fa-solid fa-clock text-gold-burnished mt-1 mr-2 w-4"></i>
                        <div>
                            <p class="font-medium text-gray-200">Jam Operasional</p>
                            <p class="text-xs text-gray-400">Senin - Sabtu: 10:00 - 21:00 WIB</p>
                        </div>
                    </li>
                </ul>
            </div>

            <!-- Column 4: Legal & Payments -->
            <div class="space-y-6">
                <div class="space-y-2">
                    <h4 class="text-xs uppercase tracking-widest text-gold-burnished font-semibold">Kebijakan Hukum</h4>
                    <ul class="space-y-1 text-sm font-light text-gray-400">
                        <li><a href="#" class="hover:text-gold-burnished transition-colors">Syarat & Ketentuan</a></li>
                        <li><a href="#" class="hover:text-gold-burnished transition-colors">Kebijakan Privasi</a></li>
                    </ul>
                </div>
                <div class="space-y-3">
                    <h4 class="text-xs uppercase tracking-widest text-gold-burnished font-semibold">Pembayaran Terverifikasi</h4>
                    <div class="flex flex-wrap gap-2 opacity-50 hover:opacity-100 transition-opacity duration-300">
                        <span class="bg-moss-slate text-[10px] text-gray-300 px-2 py-1 rounded border border-moss-emerald uppercase font-semibold">QRIS</span>
                        <span class="bg-moss-slate text-[10px] text-gray-300 px-2 py-1 rounded border border-moss-emerald uppercase font-semibold">Debit</span>
                        <span class="bg-moss-slate text-[10px] text-gray-300 px-2 py-1 rounded border border-moss-emerald uppercase font-semibold">Transfer</span>
                        <span class="bg-moss-slate text-[10px] text-gray-300 px-2 py-1 rounded border border-moss-emerald uppercase font-semibold">COD</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="border-t border-moss-slate py-6">
            <div class="max-w-7xl mx-auto px-6 flex flex-col md:flex-row items-center justify-between text-xs text-gray-500 font-light">
                <p>&copy; 2026 LUXEBOARD Shop. All Rights Reserved. Crafted for Elite Tacticians.</p>
                <p>Designed with Moss Green & Burnished Gold Editorial Aesthetic.</p>
            </div>
        </div>
    </footer>

    @livewireScripts
</body>
</html>
