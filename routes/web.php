<?php

use App\Http\Controllers\DoaController;
use App\Http\Controllers\JadwalController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\QouteController;
use App\Http\Controllers\QuranController;
use Illuminate\Support\Facades\Route;

// NEWSAPI PORTAL ROUTES
Route::get('/', [NewsController::class, 'index'])->name('news.index');
Route::get('/api/news', [NewsController::class, 'fetchNews'])->name('news.fetch');

Route::get('/produk', function () {
    return response()->json([
        ['id' => 2,
            'nama' => 'buku lima sekawan',
            'harga' => 50000,
            'stok' => 10,
        ],
        ['id' => 3,
            'nama' => 'baju kemeja',
            'kategori' => 'pakaian',
            'tersedia' => 15,
        ],

        ['id' => 4,
            'nama' => 'celana jeans',
            'kategori' => 'pakaian',
            'tersedia' => 20,
        ],

        ['id' => 5,
            'nama' => 'topi',
            'kategori' => 'aksesoris',
            'tersedia' => 25,
        ],

        ['id' => 6,
            'nama' => 'sepatu',
            'kategori' => 'aksesoris',
            'tersedia' => 30,
        ],

        ['id' => 7,
            'nama' => 'tas',
            'kategori' => 'aksesoris',
            'tersedia' => 35,
        ],
    ]);
});

Route::get('/api/berita', function () {

    $response = Http::get('https://newsapi.org/v2/top-headlines', [
        'country' => 'id',
        'apiKey' => env('NEWS_API_KEY'),
    ]);

    return $response->json();
});

// HALAMAN WEBSITE BERITA
Route::get('/qoutes', function () {

    $response = Http::get('http://localhost:8000/api/berita');

    $articles = $response->json()['articles'] ?? [];

    return view('qoutes', compact('articles'));
});

Route::get('/produk/{id}', function ($id) {
    $produk = [
        [
            'id' => 1,
            'nama' => 'buku lima sekawan',
            'harga' => 50000,
            'stok' => 10,
        ],
        [
            'id' => 2,
            'nama' => 'baju kemeja',
            'kategori' => 'pakaian',
            'tersedia' => 15,
        ],
        [
            'id' => 3,
            'nama' => 'celana jeans',
            'kategori' => 'pakaian',
            'tersedia' => 20,
        ],
        [
            'id' => 4,
            'nama' => 'topi',
            'kategori' => 'aksesoris',
            'tersedia' => 25,
        ],
        [
            'id' => 5,
            'nama' => 'sepatu',
            'kategori' => 'aksesoris',
            'tersedia' => 30,
        ],
        [
            'id' => 6,
            'nama' => 'tas',
            'kategori' => 'aksesoris',
            'tersedia' => 35,
        ],
    ];

    $produk = collect($produk)->firstWhere('id', $id);

    if (! $produk) {
        return response()->json(['message' => 'Produk tidak ditemukan'], 404);
    }

    return response()->json($produk);
});

Route::get('/qoutes', [QouteController::class, 'index']);

Route::resource('quran', QuranController::class);

Route::resource('doa', DoaController::class);

Route::resource('jadwal', JadwalController::class);
