@extends('layouts.app')

@section('title', 'Jadwal Sholat ' . ($jadwalData['lokasi'] ?? 'Kota') . ' - Pesat Islami')

@section('content')
<!-- Header Banner -->
<div class="relative bg-gradient-to-b from-emerald-800 via-teal-800 to-slate-900 text-white py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-4xl mx-auto text-center relative z-10">
        <a href="{{ route('jadwal.index') }}" class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-white/10 hover:bg-white/20 text-emerald-100 text-xs font-medium transition-all mb-6">
            <i class="fa-solid fa-arrow-left"></i> Pilih Kota Lain
        </a>

        <span class="block text-xs font-semibold text-emerald-300 uppercase tracking-wider mb-2">
            {{ $jadwalData['daerah'] ?? 'Indonesia' }}
        </span>

        <h1 class="text-3xl sm:text-4xl font-extrabold font-kufi mb-2">
            Jadwal Sholat {{ $jadwalData['lokasi'] ?? 'Detail Kota' }}
        </h1>

        <p class="text-emerald-100 text-sm sm:text-base font-light">
            <i class="fa-regular fa-calendar-check mr-1.5"></i> {{ $jadwalData['jadwal']['tanggal'] ?? date('d M Y') }}
        </p>
    </div>
</div>

<div class="max-w-4xl mx-auto px-4 sm:px-6 py-10">
    @if($jadwalData && isset($jadwalData['jadwal']))
    <!-- Big Prayer Cards Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-10">
        @php
            $times = [
                ['name' => 'Imsak', 'key' => 'imsak', 'icon' => 'fa-moon', 'desc' => 'Waktu menahan diri sebelum Subuh'],
                ['name' => 'Subuh', 'key' => 'subuh', 'icon' => 'fa-sun-plant-wilt', 'desc' => 'Sholat Fardhu 2 Rakaat'],
                ['name' => 'Terbit', 'key' => 'terbit', 'icon' => 'fa-sun', 'desc' => 'Batas akhir waktu Subuh'],
                ['name' => 'Dhuha', 'key' => 'dhuha', 'icon' => 'fa-sun', 'desc' => 'Sholat Sunnah Dhuha'],
                ['name' => 'Dzuhur', 'key' => 'dzuhur', 'icon' => 'fa-solid fa-sun', 'desc' => 'Sholat Fardhu 4 Rakaat'],
                ['name' => 'Ashar', 'key' => 'ashar', 'icon' => 'fa-cloud-sun', 'desc' => 'Sholat Fardhu 4 Rakaat'],
                ['name' => 'Maghrib', 'key' => 'maghrib', 'icon' => 'fa-moon', 'desc' => 'Sholat Fardhu 3 Rakaat'],
                ['name' => 'Isya', 'key' => 'isya', 'icon' => 'fa-star-and-crescent', 'desc' => 'Sholat Fardhu 4 Rakaat'],
            ];
        @endphp

        @foreach($times as $t)
        <div class="bg-white dark:bg-slate-900 rounded-3xl p-6 shadow-xl border border-slate-100 dark:border-slate-800 hover:border-emerald-500 dark:hover:border-emerald-500 transition-all duration-300 hover:-translate-y-1">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 rounded-2xl bg-emerald-50 dark:bg-slate-800 text-emerald-600 dark:text-emerald-400 flex items-center justify-center text-xl">
                    <i class="fa-solid {{ $t['icon'] }}"></i>
                </div>
                <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Fardhu / Sunnah</span>
            </div>

            <h3 class="text-lg font-bold text-slate-800 dark:text-slate-100 mb-1">
                {{ $t['name'] }}
            </h3>
            <p class="text-xs text-slate-500 mb-4">{{ $t['desc'] }}</p>

            <div class="text-3xl font-extrabold font-mono text-emerald-600 dark:text-emerald-400 tracking-tight">
                {{ $jadwalData['jadwal'][$t['key']] ?? '--:--' }} <span class="text-xs text-slate-400 font-normal">WIB</span>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Info Box -->
    <div class="bg-slate-50 dark:bg-slate-900 p-6 rounded-2xl border border-slate-200/80 dark:border-slate-800 text-center text-xs sm:text-sm text-slate-500 dark:text-slate-400">
        <i class="fa-solid fa-circle-info text-emerald-600 mr-2"></i>
        Waktu sholat bersumber secara otomatis dari Kementerian Agama (Kemenag RI) melalui API MyQuran.
    </div>

    @else
    <div class="bg-white dark:bg-slate-900 rounded-3xl p-12 text-center border border-slate-200 dark:border-slate-800">
        <h3 class="text-lg font-bold text-slate-700 dark:text-slate-200 mb-2">Jadwal sholat tidak ditemukan</h3>
        <p class="text-xs text-slate-500 mb-6">Silakan pilih kota lain dari daftar kota yang tersedia.</p>
        <a href="{{ route('jadwal.index') }}" class="px-6 py-2.5 rounded-xl bg-emerald-500 text-white font-semibold text-xs shadow-md">
            Kembali ke Daftar Kota
        </a>
    </div>
    @endif
</div>
@endsection