@extends('layouts.app')

@section('title', 'Kumpulan Doa Harian - Pesat Islami')

@section('content')
<!-- Hero Header (Soft Seamless Emerald Mint Palette) -->
<div class="relative overflow-hidden bg-gradient-to-b from-emerald-700 via-emerald-600 to-emerald-50 text-white pt-14 pb-24 px-4 sm:px-6 lg:px-8">
    <div class="relative max-w-4xl mx-auto text-center">
        <!-- Tag Badge -->
        <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-white/20 border border-white/30 text-white text-xs font-semibold tracking-wider uppercase mb-6 backdrop-blur-md">
            <i class="fa-solid fa-hands-praying"></i>
            <span>Doa & Dzikir Shahih Pilihan</span>
        </div>

        <!-- Title -->
        <h1 class="text-4xl sm:text-6xl font-extrabold tracking-tight text-white mb-4 font-kufi drop-shadow-sm">
            Kumpulan <span class="text-emerald-100">Doa Harian</span>
        </h1>
        
        <p class="text-emerald-50 text-sm sm:text-base max-w-xl mx-auto font-light leading-relaxed mb-10">
            Lengkapi ibadah dan aktivitas harian dengan kumpulan doa-doa shahih sesuai sunnah Rasulullah SAW.
        </p>

        <!-- Search Bar Form -->
        <form id="searchDoaForm" action="javascript:void(0)" onsubmit="handleDoaSubmit(event)" class="max-w-2xl mx-auto relative group">
            <div class="relative flex items-center bg-white rounded-2xl border border-emerald-200 shadow-xl p-2">
                <div class="pl-4 pr-2 text-emerald-600 text-lg">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </div>
                <input type="text" 
                       id="searchDoa" 
                       placeholder="Cari doa harian (contoh: sebelum tidur, makan, shalat)..." 
                       class="w-full bg-transparent py-3 px-2 text-slate-800 placeholder-slate-400 text-sm font-medium focus:outline-none">
                <button type="submit" class="hidden sm:inline-flex items-center gap-1.5 px-5 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs transition-all shadow-md cursor-pointer">
                    Cari Doa
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Main Container -->
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 -mt-10 relative z-10">
    <div class="bg-white rounded-3xl p-6 sm:p-8 shadow-xl shadow-emerald-950/5 border border-emerald-100">
        
        <!-- Header Info & Category Filter -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 pb-6 mb-8 border-b border-emerald-100">
            <div class="flex items-center gap-2 text-xs sm:text-sm text-slate-500 font-medium">
                <i class="fa-solid fa-layer-group text-emerald-600"></i>
                <span id="doaCount" class="text-slate-800 font-bold">Menampilkan {{ count($doa) }} Doa</span>
            </div>

            <!-- Group Filter dropdown -->
            <div class="flex items-center gap-3">
                <label for="groupSelect" class="text-xs font-bold text-slate-500 uppercase tracking-wider hidden sm:block">Kategori:</label>
                <select id="groupSelect" onchange="filterCategory()" class="px-4 py-2 rounded-xl text-xs font-bold bg-emerald-50 text-emerald-800 border border-emerald-200 focus:outline-none focus:ring-2 focus:ring-emerald-500">
                    <option value="all">Semua Kategori Doa</option>
                    @php
                        $groups = array_unique(array_filter(array_column($doa, 'grup')));
                    @endphp
                    @foreach($groups as $grup)
                        <option value="{{ $grup }}">{{ $grup }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <!-- Doa Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6" id="doaGrid">
            @foreach ($doa as $d)
            <div class="doa-card bg-emerald-50/30 hover:bg-emerald-50/70 border border-emerald-100/80 hover:border-emerald-400 rounded-2xl p-6 transition-all duration-300 hover:shadow-lg shadow-sm flex flex-col justify-between"
                 data-nama="{{ strtolower($d['nama'] ?? '') }}"
                 data-idn="{{ strtolower($d['idn'] ?? '') }}"
                 data-grup="{{ $d['grup'] ?? '' }}">
                
                <div>
                    <!-- Badge & Title -->
                    <div class="flex items-start justify-between gap-3 mb-4">
                        <span class="px-3 py-1 rounded-lg bg-emerald-100 text-emerald-800 text-xs font-bold border border-emerald-200/60">
                            {{ $d['grup'] ?? 'Umum' }}
                        </span>
                        <span class="text-xs font-bold text-slate-400">#{{ $d['id'] }}</span>
                    </div>

                    <h3 class="text-lg font-bold text-slate-800 mb-4 group-hover:text-emerald-700 transition-colors">
                        {{ $d['nama'] }}
                    </h3>

                    <!-- Teks Arab -->
                    <div class="bg-emerald-50/80 p-4 rounded-xl border border-emerald-100 mb-4 text-right">
                        <p class="font-arabic text-2xl sm:text-3xl text-slate-800 leading-relaxed" dir="rtl">
                            {{ $d['ar'] }}
                        </p>
                    </div>

                    <!-- Teks Transliterasi/Latin -->
                    @if(!empty($d['tr']))
                    <p class="text-xs sm:text-sm text-emerald-700 font-medium italic mb-2">
                        {{ $d['tr'] }}
                    </p>
                    @endif

                    <!-- Arti / Terjemahan -->
                    <p class="text-xs sm:text-sm text-slate-600 leading-relaxed line-clamp-3">
                        "{{ $d['idn'] }}"
                    </p>
                </div>

                <!-- Footer Action Button -->
                <div class="pt-6 mt-6 border-t border-emerald-100 flex items-center justify-between">
                    <button onclick="copyDoa('{{ addslashes($d['nama']) }}', '{{ addslashes($d['ar']) }}', '{{ addslashes($d['idn']) }}')" class="text-xs font-semibold text-slate-500 hover:text-emerald-700 flex items-center gap-1.5 transition-colors">
                        <i class="fa-regular fa-copy"></i> Salin Doa
                    </button>

                    <a href="{{ route('doa.index') }}/{{ $d['id'] }}" class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold shadow-md shadow-emerald-600/20 transition-all">
                        <span>Detail Lengkap</span>
                        <i class="fa-solid fa-arrow-right text-[10px]"></i>
                    </a>
                </div>
            </div>
            @endforeach
        </div>

        <!-- No Results Found -->
        <div id="noDoaResult" class="hidden text-center py-16">
            <div class="w-16 h-16 rounded-full bg-emerald-50 text-emerald-600 flex items-center justify-center mx-auto mb-4 text-2xl">
                <i class="fa-solid fa-hands-praying"></i>
            </div>
            <h4 class="text-slate-800 font-bold mb-1">Doa tidak ditemukan</h4>
            <p class="text-xs text-slate-500">Coba cari dengan kata kunci lain seperti "tidur", "makan", atau "shalat".</p>
        </div>
    </div>
</div>

<script>
    window.filterDoa = function() {
        var searchDoa = document.getElementById('searchDoa');
        var groupSelect = document.getElementById('groupSelect');
        var doaCards = document.querySelectorAll('.doa-card');
        var noDoaResult = document.getElementById('noDoaResult');
        var doaCount = document.getElementById('doaCount');

        var query = searchDoa ? searchDoa.value.toLowerCase().trim() : '';
        var selectedGroup = groupSelect ? groupSelect.value : 'all';
        var visible = 0;

        doaCards.forEach(function(card) {
            var nama = card.getAttribute('data-nama') || '';
            var idn = card.getAttribute('data-idn') || '';
            var grup = card.getAttribute('data-grup') || '';

            var matchesSearch = nama.indexOf(query) !== -1 || idn.indexOf(query) !== -1;
            var matchesGroup = selectedGroup === 'all' || grup === selectedGroup;

            if (matchesSearch && matchesGroup) {
                card.style.display = 'flex';
                visible++;
            } else {
                card.style.display = 'none';
            }
        });

        if (noDoaResult) {
            if (visible === 0) {
                noDoaResult.classList.remove('hidden');
            } else {
                noDoaResult.classList.add('hidden');
            }
        }

        if (doaCount) {
            doaCount.textContent = 'Menampilkan ' + visible + ' Doa';
        }
    };

    window.handleDoaSubmit = function(e) {
        if (e && e.preventDefault) e.preventDefault();
        window.filterDoa();
    };

    window.filterCategory = function() {
        window.filterDoa();
    };

    document.addEventListener('DOMContentLoaded', function() {
        var searchDoa = document.getElementById('searchDoa');
        if (searchDoa) {
            searchDoa.addEventListener('input', window.filterDoa);
        }
    });
</script>
@endsection