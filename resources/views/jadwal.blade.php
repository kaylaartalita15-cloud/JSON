@extends('layouts.app')

@section('title', 'Jadwal Sholat Seluruh Indonesia - Pesat Islami')

@section('content')
<!-- Hero Header (Soft Seamless Emerald Mint Palette) -->
<div class="relative overflow-hidden bg-gradient-to-b from-emerald-700 via-emerald-600 to-emerald-50 text-white pt-14 pb-24 px-4 sm:px-6 lg:px-8">
    <div class="relative max-w-4xl mx-auto text-center">
        <!-- Tag Badge -->
        <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-white/20 border border-white/30 text-white text-xs font-semibold tracking-wider uppercase mb-6 backdrop-blur-md">
            <i class="fa-solid fa-clock"></i>
            <span>Waktu Sholat Akurat Seluruh Indonesia</span>
        </div>

        <h1 class="text-4xl sm:text-6xl font-extrabold tracking-tight text-white mb-4 font-kufi drop-shadow-sm">
            Jadwal <span class="text-emerald-100">Sholat</span> Indonesia
        </h1>
        
        <p class="text-emerald-50 text-sm sm:text-base max-w-xl mx-auto font-light leading-relaxed mb-10">
            Pantau waktu Subuh, Dzuhur, Ashar, Maghrib, dan Isya secara presisi berdasarkan lokasi kota Anda.
        </p>

        <!-- Search Bar Kota Form -->
        <form id="searchKotaForm" action="javascript:void(0)" onsubmit="handleKotaSubmit(event)" class="max-w-2xl mx-auto relative group">
            <div class="relative flex items-center bg-white rounded-2xl border border-emerald-200 shadow-xl p-2">
                <div class="pl-4 pr-2 text-emerald-600 text-lg">
                    <i class="fa-solid fa-location-dot"></i>
                </div>
                <input type="text" 
                       id="searchKota" 
                       placeholder="Cari Kota / Kabupaten (contoh: Jakarta, Bandung, Surabaya)..." 
                       class="w-full bg-transparent py-3 px-2 text-slate-800 placeholder-slate-400 text-sm font-medium focus:outline-none">
                <button type="submit" class="hidden sm:inline-flex items-center gap-1.5 px-5 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs transition-all shadow-md cursor-pointer">
                    Cari Kota
                </button>
            </div>
        </form>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 -mt-10 relative z-10">
    
    <!-- Highlight Widget: Default Hari Ini (Jakarta / Selected) -->
    @if($defaultJadwal)
    <div class="bg-gradient-to-br from-emerald-600 to-teal-700 text-white rounded-3xl p-6 sm:p-8 shadow-xl shadow-emerald-950/10 mb-10 border border-emerald-500/20 relative overflow-hidden">
        <div class="absolute -right-10 -bottom-10 opacity-10 text-9xl">
            <i class="fa-solid fa-kaaba"></i>
        </div>

        <div class="relative z-10">
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 pb-6 border-b border-white/15">
                <div>
                    <span class="text-xs font-semibold uppercase tracking-wider text-emerald-200">Jadwal Sholat Hari Ini</span>
                    <h2 class="text-2xl sm:text-3xl font-extrabold font-kufi mt-1">
                        {{ $defaultJadwal['lokasi'] }} ({{ $defaultJadwal['daerah'] ?? 'Indonesia' }})
                    </h2>
                </div>
                <div class="text-left md:text-right">
                    <div class="text-sm font-medium text-emerald-100">
                        <i class="fa-regular fa-calendar-check mr-1.5"></i> {{ $defaultJadwal['jadwal']['tanggal'] ?? date('d M Y') }}
                    </div>
                </div>
            </div>

            <!-- Prayer Times Grid -->
            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-4 mt-6">
                @php
                    $times = [
                        ['name' => 'Subuh', 'key' => 'subuh', 'icon' => 'fa-sun-plant-wilt'],
                        ['name' => 'Terbit', 'key' => 'terbit', 'icon' => 'fa-sun'],
                        ['name' => 'Dzuhur', 'key' => 'dzuhur', 'icon' => 'fa-solid fa-sun'],
                        ['name' => 'Ashar', 'key' => 'ashar', 'icon' => 'fa-cloud-sun'],
                        ['name' => 'Maghrib', 'key' => 'maghrib', 'icon' => 'fa-moon'],
                        ['name' => 'Isya', 'key' => 'isya', 'icon' => 'fa-star-and-crescent'],
                    ];
                @endphp

                @foreach($times as $t)
                <div class="bg-white/10 backdrop-blur-md rounded-2xl p-4 border border-white/15 text-center hover:bg-white/20 transition-all">
                    <div class="text-emerald-200 mb-1 text-lg">
                        <i class="fa-solid {{ $t['icon'] }}"></i>
                    </div>
                    <div class="text-xs font-semibold text-emerald-100 uppercase tracking-wider mb-1">{{ $t['name'] }}</div>
                    <div class="text-xl sm:text-2xl font-extrabold font-mono tracking-tight text-white">
                        {{ $defaultJadwal['jadwal'][$t['key']] ?? '--:--' }}
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    @endif

    <!-- Daftar Semua Kota/Kabupaten -->
    <div class="bg-white rounded-3xl p-6 sm:p-8 shadow-xl shadow-emerald-950/5 border border-emerald-100">
        <div class="flex items-center justify-between pb-6 mb-6 border-b border-emerald-100">
            <h3 class="text-lg font-bold text-slate-800 flex items-center gap-2">
                <i class="fa-solid fa-city text-emerald-600"></i>
                <span>Pilih Kota / Kabupaten</span>
            </h3>
            <span id="kotaCount" class="text-xs font-bold text-slate-500">Total {{ count($kotaList) }} Kota</span>
        </div>

        <!-- City Cards Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4" id="kotaGrid">
            @foreach ($kotaList as $kota)
            <div class="kota-card group bg-emerald-50/30 hover:bg-emerald-50/70 border border-emerald-100/80 hover:border-emerald-400 rounded-2xl p-4 transition-all duration-300 hover:shadow-lg shadow-sm"
                 data-lokasi="{{ strtolower($kota['lokasi']) }}">
                <a href="{{ route('jadwal.show', $kota['id']) }}" class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-emerald-600 text-white font-bold flex items-center justify-center text-sm shadow-md shadow-emerald-600/20 transition-colors">
                            <i class="fa-solid fa-location-dot"></i>
                        </div>
                        <span class="text-sm font-semibold text-slate-800 group-hover:text-emerald-700 transition-colors">
                            {{ $kota['lokasi'] }}
                        </span>
                    </div>
                    <i class="fa-solid fa-chevron-right text-xs text-slate-400 group-hover:text-emerald-600 group-hover:translate-x-1 transition-all"></i>
                </a>
            </div>
            @endforeach
        </div>

        <div id="noKotaResult" class="hidden text-center py-16">
            <div class="w-16 h-16 rounded-full bg-emerald-50 text-emerald-600 flex items-center justify-center mx-auto mb-4 text-2xl">
                <i class="fa-solid fa-city"></i>
            </div>
            <h4 class="text-slate-800 font-bold mb-1">Kota tidak ditemukan</h4>
            <p class="text-xs text-slate-500">Pastikan nama kota yang dicari sudah benar.</p>
        </div>
    </div>
</div>

<script>
    window.filterKota = function() {
        var searchKota = document.getElementById('searchKota');
        var kotaCards = document.querySelectorAll('.kota-card');
        var noKotaResult = document.getElementById('noKotaResult');
        var kotaCount = document.getElementById('kotaCount');

        var query = searchKota ? searchKota.value.toLowerCase().trim() : '';
        var visible = 0;

        kotaCards.forEach(function(card) {
            var lokasi = card.getAttribute('data-lokasi') || '';
            if (lokasi.indexOf(query) !== -1) {
                card.style.display = 'block';
                visible++;
            } else {
                card.style.display = 'none';
            }
        });

        if (noKotaResult) {
            if (visible === 0) {
                noKotaResult.classList.remove('hidden');
            } else {
                noKotaResult.classList.add('hidden');
            }
        }

        if (kotaCount) {
            kotaCount.textContent = 'Menampilkan ' + visible + ' Kota';
        }
    };

    window.handleKotaSubmit = function(e) {
        if (e && e.preventDefault) e.preventDefault();
        window.filterKota();
    };

    document.addEventListener('DOMContentLoaded', function() {
        var searchKota = document.getElementById('searchKota');
        if (searchKota) {
            searchKota.addEventListener('input', window.filterKota);
        }
    });
</script>
@endsection