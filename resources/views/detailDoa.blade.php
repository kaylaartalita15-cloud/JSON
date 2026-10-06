@extends('layouts.app')

@section('title', ($doa['nama'] ?? 'Detail Doa') . ' - Pesat Islami')

@section('content')
<!-- Header Banner -->
<div class="relative bg-gradient-to-b from-teal-700 via-emerald-800 to-slate-900 text-white py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-4xl mx-auto text-center relative z-10">
        <a href="{{ route('doa.index') }}" class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-white/10 hover:bg-white/20 text-teal-100 text-xs font-medium transition-all mb-6">
            <i class="fa-solid fa-arrow-left"></i> Kembali ke Kumpulan Doa
        </a>
        
        <span class="block text-xs font-semibold text-teal-300 uppercase tracking-wider mb-2">
            {{ $doa['grup'] ?? 'Doa Harian' }}
        </span>

        <h1 class="text-3xl sm:text-4xl font-extrabold font-kufi mb-4">
            {{ $doa['nama'] }}
        </h1>

        <!-- Audio Player if available -->
        @if(isset($doa['audioFull']['02']) || isset($doa['audioFull']['01']))
        <div class="mt-6 inline-flex items-center gap-3 bg-white/10 backdrop-blur-md px-4 py-2 rounded-2xl border border-white/15">
            <audio controls src="{{ $doa['audioFull']['02'] ?? $doa['audioFull']['01'] }}" class="h-9"></audio>
        </div>
        @endif
    </div>
</div>

<div class="max-w-4xl mx-auto px-4 sm:px-6 py-10">
    <!-- Card Utama Doa -->
    <div class="bg-white dark:bg-slate-900 rounded-3xl p-6 sm:p-10 shadow-xl border border-teal-100 dark:border-slate-800 mb-8">
        
        <!-- Header Actions -->
        <div class="flex items-center justify-between pb-6 mb-8 border-b border-slate-100 dark:border-slate-800">
            <span class="px-3.5 py-1.5 rounded-xl bg-teal-100 dark:bg-teal-900/60 text-teal-800 dark:text-teal-300 text-xs font-bold">
                {{ $doa['grup'] ?? 'Umum' }}
            </span>
            
            <button onclick="copyDoaDetail()" class="px-4 py-2 rounded-xl bg-slate-100 dark:bg-slate-800 hover:bg-teal-50 dark:hover:bg-slate-700 text-slate-700 dark:text-slate-300 hover:text-teal-600 text-xs font-semibold flex items-center gap-2 transition-colors">
                <i class="fa-regular fa-copy"></i>
                <span>Salin Doa Ini</span>
            </button>
        </div>

        <!-- Teks Arab -->
        <div class="bg-emerald-50/50 dark:bg-slate-950 p-6 sm:p-8 rounded-2xl border border-emerald-100 dark:border-slate-800 mb-8 text-right">
            <p id="arabicText" class="font-arabic text-3xl sm:text-4xl lg:text-5xl text-slate-800 dark:text-slate-100 leading-[2.2] font-normal" dir="rtl">
                {{ $doa['ar'] }}
            </p>
        </div>

        <!-- Transliterasi / Latin -->
        @if(!empty($doa['tr']))
        <div class="mb-6">
            <h4 class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Transliterasi (Latin)</h4>
            <p id="latinText" class="text-base sm:text-lg text-teal-700 dark:text-teal-400 font-medium italic leading-relaxed">
                {{ $doa['tr'] }}
            </p>
        </div>
        @endif

        <!-- Terjemahan Bahasa Indonesia -->
        <div class="mb-8">
            <h4 class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Artinya / Terjemahan</h4>
            <p id="idnText" class="text-base sm:text-lg text-slate-700 dark:text-slate-200 leading-relaxed font-light">
                "{{ $doa['idn'] }}"
            </p>
        </div>

        <!-- Keterangan / Riwayat / Hadits -->
        @if(!empty($doa['tentang']))
        <div class="bg-slate-50 dark:bg-slate-800/60 p-6 rounded-2xl border border-slate-200/60 dark:border-slate-700/50">
            <div class="flex items-center gap-2 text-teal-600 dark:text-teal-400 font-semibold text-sm mb-3">
                <i class="fa-solid fa-circle-info"></i>
                <span>Penjelasan & Riwayat Hadits</span>
            </div>
            <div class="text-xs sm:text-sm text-slate-600 dark:text-slate-300 leading-relaxed whitespace-pre-line">
                {{ $doa['tentang'] }}
            </div>
        </div>
        @endif
    </div>
</div>

@push('scripts')
<script>
    function copyDoaDetail() {
        const title = "{{ addslashes($doa['nama']) }}";
        const arab = document.getElementById('arabicText').innerText;
        const idn = document.getElementById('idnText').innerText;

        const fullText = `${title}\n\n${arab}\n\n${idn}`;
        navigator.clipboard.writeText(fullText).then(() => {
            alert('Doa berhasil disalin ke clipboard!');
        });
    }
</script>
@endpush
@endsection