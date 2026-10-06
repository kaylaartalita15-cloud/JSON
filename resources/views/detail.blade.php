@extends('layouts.app')

@section('title', 'Surah ' . $quran['namaLatin'] . ' - Pesat Islami')

@section('content')
<!-- Header Banner -->
<div class="relative bg-gradient-to-b from-emerald-700 via-emerald-800 to-slate-900 text-white py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-4xl mx-auto text-center relative z-10">
        <a href="{{ route('quran.index') }}" class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-white/10 hover:bg-white/20 text-emerald-100 text-xs font-medium transition-all mb-6">
            <i class="fa-solid fa-arrow-left"></i> Kembali ke Daftar Surah
        </a>
        
        <div class="flex items-center justify-center gap-3 mb-2">
            <span class="w-8 h-8 rounded-lg bg-emerald-500/30 border border-emerald-400/40 text-emerald-200 flex items-center justify-center font-bold text-xs">
                {{ $quran['nomor'] }}
            </span>
            <h1 class="text-3xl sm:text-4xl font-extrabold font-kufi">
                Surah {{ $quran['namaLatin'] }}
            </h1>
        </div>

        <p class="font-arabic text-4xl sm:text-5xl text-emerald-300 font-bold my-4">
            {{ $quran['nama'] }}
        </p>

        <p class="text-emerald-100/90 text-sm sm:text-base font-light max-w-xl mx-auto">
            {{ $quran['arti'] ?? 'Arti' }} • <span class="capitalize">{{ $quran['tempatTurun'] ?? 'Makkiyah' }}</span> • {{ $quran['jumlahAyat'] ?? count($quran['ayat']) }} Ayat
        </p>

        <!-- Full Audio Player -->
        @if(isset($quran['audioFull']['02']) || isset($quran['audioFull']['01']))
        <div class="mt-8 max-w-lg mx-auto bg-white/10 backdrop-blur-md border border-white/15 p-4 rounded-2xl flex items-center gap-4 text-left">
            <button id="fullAudioBtn" onclick="toggleFullAudio()" class="w-12 h-12 rounded-xl bg-emerald-500 hover:bg-emerald-400 text-white flex items-center justify-center shadow-lg transition-transform active:scale-95 flex-shrink-0">
                <i id="fullAudioIcon" class="fa-solid fa-play text-lg ml-0.5"></i>
            </button>
            <div class="flex-grow min-w-0">
                <div class="text-xs font-semibold text-emerald-200 uppercase tracking-wider mb-1">Murottal Full Surah</div>
                <div id="fullAudioTitle" class="text-sm font-medium text-white truncate">Syeikh Mishary Rashid Al-Afasy</div>
                <!-- Progress bar -->
                <div class="w-full bg-white/20 h-1.5 rounded-full mt-2 overflow-hidden">
                    <div id="fullAudioProgress" class="bg-emerald-400 h-full w-0 transition-all duration-200"></div>
                </div>
            </div>
            <audio id="fullAudioPlayer" src="{{ $quran['audioFull']['02'] ?? $quran['audioFull']['01'] }}"></audio>
        </div>
        @endif
    </div>
</div>

<!-- Bismillah Banner -->
@if($quran['nomor'] != 9 && $quran['nomor'] != 1)
<div class="max-w-4xl mx-auto px-4 mt-8 text-center">
    <div class="py-6 px-4 bg-emerald-50/50 dark:bg-slate-900/50 rounded-2xl border border-emerald-100/80 dark:border-slate-800">
        <span class="font-arabic text-3xl sm:text-4xl text-emerald-800 dark:text-emerald-300">
            بِسْمِ اللَّهِ الرَّحْمَٰنِ الرَّحِيمِ
        </span>
    </div>
</div>
@endif

<!-- Ayat List -->
<div class="max-w-4xl mx-auto px-4 sm:px-6 py-8 space-y-6">
    @foreach ($quran['ayat'] as $ayat)
    <div id="ayat-{{ $ayat['nomorAyat'] }}" class="bg-white dark:bg-slate-900 rounded-2xl p-6 sm:p-8 shadow-sm hover:shadow-md transition-shadow border border-slate-100 dark:border-slate-800 group">
        <!-- Top Metadata & Action Bar -->
        <div class="flex items-center justify-between pb-4 mb-6 border-b border-slate-100 dark:border-slate-800">
            <div class="flex items-center gap-2">
                <span class="w-10 h-10 rounded-xl bg-emerald-500/10 dark:bg-emerald-500/20 text-emerald-600 dark:text-emerald-400 font-bold flex items-center justify-center text-sm border border-emerald-500/20">
                    {{ $quran['nomor'] }}:{{ $ayat['nomorAyat'] }}
                </span>
            </div>

            <!-- Audio & Actions -->
            <div class="flex items-center gap-2">
                @if(isset($ayat['audio']['02']) || isset($ayat['audio']['01']))
                <button onclick="playAyatAudio('{{ $ayat['audio']['02'] ?? $ayat['audio']['01'] }}', {{ $ayat['nomorAyat'] }})" 
                        id="ayatAudioBtn-{{ $ayat['nomorAyat'] }}"
                        class="px-3 py-1.5 rounded-xl bg-slate-100 dark:bg-slate-800 hover:bg-emerald-50 dark:hover:bg-slate-700 text-slate-600 dark:text-slate-300 hover:text-emerald-600 dark:hover:text-emerald-400 text-xs font-semibold flex items-center gap-2 transition-colors">
                    <i class="fa-solid fa-play text-xs"></i>
                    <span>Putar Audio</span>
                </button>
                @endif

                <button onclick="copyAyat('{{ $ayat['teksArab'] }}', '{{ addslashes($ayat['teksIndonesia'] ?? $ayat['teksLatin']) }}')" class="w-9 h-9 rounded-xl bg-slate-100 dark:bg-slate-800 hover:bg-emerald-50 dark:hover:bg-slate-700 text-slate-500 dark:text-slate-400 hover:text-emerald-600 flex items-center justify-center transition-colors">
                    <i class="fa-regular fa-copy text-sm"></i>
                </button>
            </div>
        </div>

        <!-- Teks Arab -->
        <div class="text-right my-6">
            <p class="font-arabic text-3xl sm:text-4xl lg:text-5xl text-slate-800 dark:text-slate-100 leading-[2.2] sm:leading-[2.4] font-normal tracking-wide" dir="rtl">
                {{ $ayat['teksArab'] }}
            </p>
        </div>

        <!-- Teks Latin -->
        <div class="mt-6 mb-3 text-sm sm:text-base text-emerald-700 dark:text-emerald-400 font-medium italic leading-relaxed">
            {{ $ayat['teksLatin'] }}
        </div>

        <!-- Terjemahan Bahasa Indonesia -->
        <div class="text-sm sm:text-base text-slate-600 dark:text-slate-300 leading-relaxed">
            {{ $ayat['teksIndonesia'] ?? $ayat['idn'] ?? 'Terjemahan tidak tersedia.' }}
        </div>
    </div>
    @endforeach
</div>

@push('scripts')
<script>
    let currentAyatAudio = null;
    let currentAyatBtn = null;

    function playAyatAudio(src, nomorAyat) {
        if (currentAyatAudio) {
            currentAyatAudio.pause();
            if (currentAyatBtn) {
                currentAyatBtn.innerHTML = '<i class="fa-solid fa-play text-xs"></i><span>Putar Audio</span>';
            }
        }

        const btn = document.getElementById(`ayatAudioBtn-${nomorAyat}`);

        if (currentAyatAudio && currentAyatAudio.src === src && !currentAyatAudio.paused) {
            return;
        }

        const audio = new Audio(src);
        currentAyatAudio = audio;
        currentAyatBtn = btn;

        btn.innerHTML = '<i class="fa-solid fa-pause text-xs text-emerald-600"></i><span>Memutar...</span>';
        
        audio.play();
        audio.onended = () => {
            btn.innerHTML = '<i class="fa-solid fa-play text-xs"></i><span>Putar Audio</span>';
        };
    }

    function toggleFullAudio() {
        const audio = document.getElementById('fullAudioPlayer');
        const icon = document.getElementById('fullAudioIcon');
        const progress = document.getElementById('fullAudioProgress');

        if (audio.paused) {
            if (currentAyatAudio) {
                currentAyatAudio.pause();
            }
            audio.play();
            icon.className = 'fa-solid fa-pause text-lg ml-0.5';
        } else {
            audio.pause();
            icon.className = 'fa-solid fa-play text-lg ml-0.5';
        }

        audio.ontimeupdate = () => {
            const percentage = (audio.currentTime / audio.duration) * 100;
            progress.style.width = `${percentage}%`;
        };

        audio.onended = () => {
            icon.className = 'fa-solid fa-play text-lg ml-0.5';
            progress.style.width = '0%';
        };
    }

    function copyAyat(arab, terjemahan) {
        const text = `${arab}\n\n"${terjemahan}"`;
        navigator.clipboard.writeText(text).then(() => {
            alert('Teks ayat berhasil disalin!');
        });
    }
</script>
@endpush
@endsection