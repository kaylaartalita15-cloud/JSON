<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;

class JadwalController extends Controller
{
    /**
     * Display a listing of provinces and today's schedule for Jakarta.
     */
    public function index()
    {
        // 1. Ambil daftar kota/kabupaten lengkap dari MyQuran API (stabil & cepat)
        $responseKota = Http::get('https://api.myquran.com/v2/sholat/kota/semua');
        $kotaList = $responseKota->json()['data'] ?? [];

        // 2. Default jadwal sholat hari ini untuk Kota Jakarta (ID: 1301)
        $today = date('Y/m/d');
        $responseJadwal = Http::get("https://api.myquran.com/v2/sholat/jadwal/1301/{$today}");
        $defaultJadwal = $responseJadwal->json()['data'] ?? null;

        return view('jadwal', [
            'kotaList' => $kotaList,
            'defaultJadwal' => $defaultJadwal,
        ]);
    }

    /**
     * Display the specified schedule for a city.
     */
    public function show(string $idKota)
    {
        $today = date('Y/m/d');
        $responseJadwal = Http::get("https://api.myquran.com/v2/sholat/jadwal/{$idKota}/{$today}");
        $jadwalData = $responseJadwal->json()['data'] ?? null;

        return view('detailJadwal', [
            'jadwalData' => $jadwalData,
            'idKota' => $idKota,
        ]);
    }
}
