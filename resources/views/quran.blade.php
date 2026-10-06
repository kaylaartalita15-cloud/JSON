@extends('layouts.app')

@section('title', 'Al-Qur\'an Digital - Pesat Islami')

@section('content')
<!-- Hero Header (Soft Seamless Emerald Mint Palette) -->
<div class="relative overflow-hidden bg-gradient-to-b from-emerald-700 via-emerald-600 to-emerald-50 text-white pt-14 pb-24 px-4 sm:px-6 lg:px-8">
    <div class="relative max-w-4xl mx-auto text-center">
        <!-- Tag Badge -->
        <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-white/20 border border-white/30 text-white text-xs font-semibold tracking-wider uppercase mb-6 backdrop-blur-md">
            <i class="fa-solid fa-sparkles"></i>
            <span>Al-Qur'anul Karim 30 Juz</span>
        </div>

        <!-- Main Title -->
        <h1 class="text-4xl sm:text-6xl font-extrabold tracking-tight text-white mb-4 font-kufi drop-shadow-sm">
            Baca <span class="text-emerald-100">Al-Qur'an</span> Digital
        </h1>
        
        <p class="text-emerald-50 text-sm sm:text-base max-w-xl mx-auto font-light leading-relaxed mb-10">
            Kemudahan membaca, mendengarkan murottal merdu, dan memahami 114 surah dengan tampilan yang selaras & nyaman.
        </p>

        <!-- Search Bar Form -->
        <form id="searchForm" action="javascript:void(0)" onsubmit="handleSearchSubmit(event)" class="max-w-2xl mx-auto relative group">
            <div class="relative flex items-center bg-white rounded-2xl border border-emerald-200 shadow-xl p-2">
                <div class="pl-4 pr-2 text-emerald-600 text-lg">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </div>
                <input type="text" 
                       id="searchInput" 
                       placeholder="Cari nama surah atau nomor (contoh: Yasin, Al-Fatihah, 36)..." 
                       class="w-full bg-transparent py-3 px-2 text-slate-800 placeholder-slate-400 text-sm font-medium focus:outline-none">
                <button type="submit" class="hidden sm:inline-flex items-center gap-1.5 px-5 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs transition-all shadow-md cursor-pointer">
                    Cari Surah
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Surah Cards Grid Container -->
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 -mt-10 relative z-10">
    <div class="bg-white rounded-3xl p-6 sm:p-8 shadow-xl shadow-emerald-950/5 border border-emerald-100">
        
        <!-- Filter Tabs & Stats -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-6 mb-8 border-b border-emerald-100">
            <div class="flex items-center gap-2 text-xs sm:text-sm text-slate-500 font-medium">
                <i class="fa-solid fa-book-quran text-emerald-600"></i>
                <span id="surahCount" class="text-slate-800 font-bold">Menampilkan 114 Surah</span>
            </div>
            
            <div class="flex items-center gap-2 overflow-x-auto pb-1 sm:pb-0">
                <button onclick="filterSurah('all')" id="btn-all" type="button" class="px-4 py-2 rounded-xl text-xs font-bold transition-all bg-emerald-600 text-white shadow-md shadow-emerald-600/20 cursor-pointer">Semua Surah</button>
                <button onclick="filterSurah('makkiyah')" id="btn-makkiyah" type="button" class="px-4 py-2 rounded-xl text-xs font-bold transition-all bg-emerald-50 text-emerald-700 hover:bg-emerald-100 cursor-pointer">Makkiyah</button>
                <button onclick="filterSurah('madaniyah')" id="btn-madaniyah" type="button" class="px-4 py-2 rounded-xl text-xs font-bold transition-all bg-emerald-50 text-emerald-700 hover:bg-emerald-100 cursor-pointer">Madaniyah</button>
            </div>
        </div>

        <!-- Surah Cards Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-5" id="surahGrid">
            @foreach ($quran as $surat)
            @php
                // Normalize tempatTurun text for accurate matching
                $tempat = strtolower($surat['tempatTurun'] ?? '');
                $placeTag = (str_contains($tempat, 'madani') || str_contains($tempat, 'madinah')) ? 'madaniyah' : 'makkiyah';
            @endphp
            <div class="surah-card group relative bg-emerald-50/30 hover:bg-emerald-50/70 border border-emerald-100/80 hover:border-emerald-400 rounded-2xl p-5 transition-all duration-300 hover:-translate-y-1 hover:shadow-lg shadow-sm"
                 data-name="{{ strtolower($surat['namaLatin']) }}" 
                 data-nomor="{{ $surat['nomor'] }}"
                 data-place="{{ $placeTag }}">
                
                <a href="{{ route('quran.show', $surat['nomor']) }}" class="block">
                    <div class="flex items-center justify-between">
                        <!-- Left: Number & Surah Info -->
                        <div class="flex items-center gap-4">
                            <!-- Number Badge -->
                            <div class="w-11 h-11 rounded-xl bg-emerald-600 text-white flex items-center justify-center font-bold shadow-md shadow-emerald-600/20 transition-all duration-300 text-sm">
                                {{ $surat['nomor'] }}
                            </div>

                            <div>
                                <h3 class="font-bold text-slate-800 group-hover:text-emerald-700 text-base transition-colors">
                                    {{ $surat['namaLatin'] }}
                                </h3>
                                <p class="text-xs text-slate-500 mt-0.5 font-medium">
                                    {{ $surat['arti'] ?? 'Arti Surah' }} • <span class="capitalize">{{ $surat['jumlahAyat'] ?? '-' }} Ayat</span>
                                </p>
                            </div>
                        </div>

                        <!-- Right: Arabic Name -->
                        <div class="text-right">
                            <span class="font-arabic text-2xl font-bold text-emerald-800 group-hover:scale-105 block transition-transform">
                                {{ $surat['nama'] }}
                            </span>
                            <span class="text-[10px] font-bold uppercase tracking-wider text-emerald-600/80 mt-0.5 block">
                                {{ $surat['tempatTurun'] ?? 'Makkiyah' }}
                            </span>
                        </div>
                    </div>
                </a>
            </div>
            @endforeach
        </div>

        <div id="noResult" class="hidden text-center py-16">
            <div class="w-16 h-16 rounded-full bg-emerald-50 text-emerald-600 flex items-center justify-center mx-auto mb-4 text-2xl">
                <i class="fa-solid fa-magnifying-glass"></i>
            </div>
            <h4 class="text-slate-800 font-bold mb-1">Surah tidak ditemukan</h4>
            <p class="text-xs text-slate-500">Coba kata kunci pencarian yang lain atau ubah filter surah.</p>
        </div>
    </div>
</div>

<script>
    window.filterSurah = function(type) {
        var searchInput = document.getElementById('searchInput');
        var surahCards = document.querySelectorAll('.surah-card');
        var noResult = document.getElementById('noResult');
        var surahCount = document.getElementById('surahCount');
        
        var query = searchInput ? searchInput.value.toLowerCase().trim() : '';
        var visibleCount = 0;

        surahCards.forEach(function(card) {
            var name = card.getAttribute('data-name') || '';
            var nomor = card.getAttribute('data-nomor') || '';
            var place = card.getAttribute('data-place') || '';

            var matchesSearch = name.indexOf(query) !== -1 || nomor.indexOf(query) !== -1;
            var matchesFilter = (type === 'all') || (place === type);

            if (matchesSearch && matchesFilter) {
                card.style.display = 'block';
                visibleCount++;
            } else {
                card.style.display = 'none';
            }
        });

        if (noResult) {
            if (visibleCount === 0) {
                noResult.classList.remove('hidden');
            } else {
                noResult.classList.add('hidden');
            }
        }

        var labelMap = {
            'all': 'Surah',
            'makkiyah': 'Surah Makkiyah',
            'madaniyah': 'Surah Madaniyah'
        };

        if (surahCount) {
            surahCount.textContent = 'Menampilkan ' + visibleCount + ' ' + (labelMap[type] || 'Surah');
        }

        ['all', 'makkiyah', 'madaniyah'].forEach(function(t) {
            var btn = document.getElementById('btn-' + t);
            if (btn) {
                if (t === type) {
                    btn.className = 'px-4 py-2 rounded-xl text-xs font-bold transition-all bg-emerald-600 text-white shadow-md shadow-emerald-600/20 cursor-pointer';
                } else {
                    btn.className = 'px-4 py-2 rounded-xl text-xs font-bold transition-all bg-emerald-50 text-emerald-700 hover:bg-emerald-100 cursor-pointer';
                }
            }
        });
    };

    window.handleSearchSubmit = function(e) {
        if (e && e.preventDefault) e.preventDefault();
        var currentActiveBtn = document.querySelector('[id^="btn-"].bg-emerald-600');
        var type = currentActiveBtn ? currentActiveBtn.id.replace('btn-', '') : 'all';
        window.filterSurah(type);
    };

    document.addEventListener('DOMContentLoaded', function() {
        var searchInput = document.getElementById('searchInput');
        if (searchInput) {
            searchInput.addEventListener('input', function() {
                var currentActiveBtn = document.querySelector('[id^="btn-"].bg-emerald-600');
                var type = currentActiveBtn ? currentActiveBtn.id.replace('btn-', '') : 'all';
                window.filterSurah(type);
            });
        }
    });
</script>
@endsection