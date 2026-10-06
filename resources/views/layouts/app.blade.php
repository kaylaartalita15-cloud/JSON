<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Al-Quran, Doa & Jadwal Sholat Pesat')</title>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Amiri:ital,wght@0,400;0,700;1,400&family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Reem+Kufi:wght@400;600;700&display=swap" rel="stylesheet">
    
    <!-- FontAwesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        .font-arabic {
            font-family: 'Amiri', serif;
        }
        .font-kufi {
            font-family: 'Reem Kufi', sans-serif;
        }
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }
        ::-webkit-scrollbar-track {
            background: rgba(15, 23, 42, 0.05);
        }
        ::-webkit-scrollbar-thumb {
            background: #059669;
            border-radius: 4px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #047857;
        }
    </style>
</head>
<body class="bg-emerald-50/40 text-slate-800 min-h-full flex flex-col transition-colors duration-300">

    <!-- Header / Navigation -->
    <header class="sticky top-0 z-50 backdrop-blur-md bg-white/90 border-b border-emerald-100 shadow-sm transition-colors duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-20 flex items-center justify-between">
            <!-- Brand Logo -->
            <a href="{{ route('quran.index') }}" class="flex items-center gap-3 group">
                <div class="w-12 h-12 rounded-2xl bg-gradient-to-tr from-emerald-600 via-emerald-500 to-teal-400 flex items-center justify-center text-white shadow-lg shadow-emerald-500/20 group-hover:scale-105 transition-all duration-300">
                    <i class="fa-solid fa-kaaba text-xl"></i>
                </div>
                <div>
                    <span class="text-xl font-bold font-kufi tracking-wide bg-gradient-to-r from-emerald-700 via-teal-600 to-emerald-500 bg-clip-text text-transparent">
                        PESAT ISLAMI
                    </span>
                    <span class="block text-xs font-medium text-emerald-600/80">Al-Qur'an, Doa & Sholat</span>
                </div>
            </a>

            <!-- Navigation Links -->
            <nav class="hidden md:flex items-center space-x-1 lg:space-x-2">
                <a href="{{ route('quran.index') }}" 
                   class="px-4 py-2.5 rounded-xl font-medium text-sm transition-all duration-200 flex items-center gap-2 {{ request()->routeIs('quran.*') ? 'bg-emerald-500 text-white shadow-lg shadow-emerald-500/25 font-semibold' : 'text-slate-600 hover:bg-emerald-50 hover:text-emerald-600' }}">
                    <i class="fa-solid fa-book-quran"></i>
                    <span>Al-Qur'an</span>
                </a>

                <a href="{{ route('doa.index') }}" 
                   class="px-4 py-2.5 rounded-xl font-medium text-sm transition-all duration-200 flex items-center gap-2 {{ request()->routeIs('doa.*') ? 'bg-emerald-500 text-white shadow-lg shadow-emerald-500/25 font-semibold' : 'text-slate-600 hover:bg-emerald-50 hover:text-emerald-600' }}">
                    <i class="fa-solid fa-hands-praying"></i>
                    <span>Kumpulan Doa</span>
                </a>

                <a href="{{ route('jadwal.index') }}" 
                   class="px-4 py-2.5 rounded-xl font-medium text-sm transition-all duration-200 flex items-center gap-2 {{ request()->routeIs('jadwal.*') ? 'bg-emerald-500 text-white shadow-lg shadow-emerald-500/25 font-semibold' : 'text-slate-600 hover:bg-emerald-50 hover:text-emerald-600' }}">
                    <i class="fa-solid fa-clock"></i>
                    <span>Jadwal Sholat</span>
                </a>
            </nav>

            <!-- Actions -->
            <div class="flex items-center gap-3">
                <!-- Mobile Menu Button -->
                <button onclick="toggleMobileMenu()" type="button" class="md:hidden w-10 h-10 rounded-xl bg-slate-100 text-slate-600 flex items-center justify-center">
                    <i class="fa-solid fa-bars text-lg"></i>
                </button>
            </div>
        </div>

        <!-- Mobile Navigation Menu -->
        <div id="mobileMenu" class="hidden md:hidden border-t border-slate-100 bg-white/95 px-4 pt-3 pb-4 space-y-2">
            <a href="{{ route('quran.index') }}" class="block px-4 py-3 rounded-xl font-medium text-sm {{ request()->routeIs('quran.*') ? 'bg-emerald-500 text-white' : 'text-slate-700 hover:bg-emerald-50' }}">
                <i class="fa-solid fa-book-quran mr-2"></i> Al-Qur'an
            </a>
            <a href="{{ route('doa.index') }}" class="block px-4 py-3 rounded-xl font-medium text-sm {{ request()->routeIs('doa.*') ? 'bg-emerald-500 text-white' : 'text-slate-700 hover:bg-emerald-50' }}">
                <i class="fa-solid fa-hands-praying mr-2"></i> Kumpulan Doa
            </a>
            <a href="{{ route('jadwal.index') }}" class="block px-4 py-3 rounded-xl font-medium text-sm {{ request()->routeIs('jadwal.*') ? 'bg-emerald-500 text-white' : 'text-slate-700 hover:bg-emerald-50' }}">
                <i class="fa-solid fa-clock mr-2"></i> Jadwal Sholat
            </a>
        </div>
    </header>

    <!-- Main Content -->
    <main class="flex-grow">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-slate-900 text-slate-400 mt-20 border-t border-slate-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div>
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-10 h-10 rounded-xl bg-emerald-500 flex items-center justify-center text-white">
                            <i class="fa-solid fa-kaaba text-lg"></i>
                        </div>
                        <span class="text-lg font-bold font-kufi text-white tracking-wide">PESAT ISLAMI</span>
                    </div>
                    <p class="text-sm text-slate-400 leading-relaxed">
                        Platform Islami modern dengan bacaan Al-Qur'an digital, doa harian lengkap, serta jadwal sholat akurat untuk mempermudah ibadah harian Anda.
                    </p>
                </div>
                <div>
                    <h4 class="text-white font-semibold mb-4 text-sm tracking-wider uppercase">Menu Utama</h4>
                    <ul class="space-y-2 text-sm">
                        <li><a href="{{ route('quran.index') }}" class="hover:text-emerald-400 transition-colors">Al-Qur'an Digital</a></li>
                        <li><a href="{{ route('doa.index') }}" class="hover:text-emerald-400 transition-colors">Kumpulan Doa & Dzikir</a></li>
                        <li><a href="{{ route('jadwal.index') }}" class="hover:text-emerald-400 transition-colors">Jadwal Sholat Seluruh Indonesia</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-white font-semibold mb-4 text-sm tracking-wider uppercase">Sumber Data</h4>
                    <p class="text-sm text-slate-400 leading-relaxed mb-3">
                        Menggunakan API resmi EQuran.id dan Kemenag RI untuk menyajikan informasi Al-Qur'an, Doa, serta Jadwal Sholat yang terpercaya.
                    </p>
                    <span class="inline-flex items-center gap-2 px-3 py-1.5 rounded-lg bg-emerald-950/60 border border-emerald-800/60 text-emerald-400 text-xs font-medium">
                        <i class="fa-solid fa-check-circle"></i> Tanpa Login - Akses Cepat & Gratis
                    </span>
                </div>
            </div>
            <div class="border-t border-slate-800 mt-10 pt-6 text-center text-xs text-slate-500">
                &copy; {{ date('Y') }} Pesat Islami. Didesain dengan penuh khidmat & cinta.
            </div>
        </div>
    </footer>

    <script>
        function toggleMobileMenu() {
            const menu = document.getElementById('mobileMenu');
            if (menu) {
                menu.classList.toggle('hidden');
            }
        }
    </script>
    @stack('scripts')
</body>
</html>
