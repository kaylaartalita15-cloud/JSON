<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class NewsController extends Controller
{
    /**
     * Render the main news web portal interface.
     */
    public function index(Request $request)
    {
        $category = $request->query('category', 'general');
        $search = $request->query('q', '');
        $apiKey = $request->query('apiKey') ?? config('services.newsapi.key') ?? env('NEWS_API_KEY');

        $newsData = $this->getArticles($category, $search, $apiKey);

        return view('news.index', [
            'articles' => $newsData['articles'],
            'totalResults' => $newsData['totalResults'],
            'selectedCategory' => $category,
            'searchQuery' => $search,
            'hasApiKey' => ! empty($apiKey),
            'sourceType' => $newsData['source'],
        ]);
    }

    /**
     * JSON API Endpoint for dynamic AJAX updates (categories, search, pagination).
     */
    public function fetchNews(Request $request)
    {
        $category = $request->query('category', 'general');
        $search = $request->query('q', '');
        $apiKey = $request->header('X-News-Api-Key') ?? $request->query('apiKey') ?? config('services.newsapi.key') ?? env('NEWS_API_KEY');

        $newsData = $this->getArticles($category, $search, $apiKey);

        return response()->json($newsData);
    }

    /**
     * Core helper to fetch articles from NewsAPI or return fallback data.
     */
    private function getArticles(string $category = 'general', string $search = '', ?string $apiKey = null): array
    {
        $cacheKey = 'news_cache_'.md5("{$category}_{$search}_{$apiKey}");

        return Cache::remember($cacheKey, 600, function () use ($category, $search, $apiKey) {
            if (! empty($apiKey)) {
                try {
                    $url = 'https://newsapi.org/v2/top-headlines';
                    $params = [
                        'apiKey' => $apiKey,
                        'pageSize' => 20,
                    ];

                    if (! empty($search)) {
                        $url = 'https://newsapi.org/v2/everything';
                        $params['q'] = $search;
                        $params['sortBy'] = 'publishedAt';
                        $params['language'] = 'id';
                    } else {
                        $params['country'] = 'id';
                        if ($category !== 'general') {
                            $params['category'] = $category;
                        }
                    }

                    $response = Http::timeout(6)->get($url, $params);

                    if ($response->successful()) {
                        $data = $response->json();
                        $articles = array_filter($data['articles'] ?? [], function ($article) {
                            return ! empty($article['title']) && $article['title'] !== '[Removed]';
                        });

                        if (! empty($articles)) {
                            return [
                                'status' => 'ok',
                                'totalResults' => count($articles),
                                'articles' => array_values($articles),
                                'source' => 'live_api',
                            ];
                        }
                    }
                } catch (\Throwable $e) {
                    Log::warning('NewsAPI call failed: '.$e->getMessage());
                }
            }

            // Fallback to high quality Indonesian news dataset if API key is missing or failed
            return [
                'status' => 'ok',
                'totalResults' => 12,
                'articles' => $this->getFallbackArticles($category, $search),
                'source' => 'fallback',
            ];
        });
    }

    /**
     * High quality Indonesian news fallback dataset.
     */
    private function getFallbackArticles(string $category = 'general', string $search = ''): array
    {
        $allArticles = [
            [
                'source' => ['name' => 'Tech Nusantara'],
                'author' => 'Budi Santoso',
                'title' => 'Inovasi AI Terbaru Mampu Prediksi Cuaca Ekstrem di Indonesia dengan Akurasi 98%',
                'description' => 'Para ilmuwan dan pakar teknologi nasional meluncurkan sistem kecerdasan buatan teranyar yang dapat memprediksi pola hujan dan potensi bencana alam secara real-time.',
                'url' => 'https://example.com/news/1',
                'urlToImage' => 'https://images.unsplash.com/photo-1618005182384-a83a8bd57fbe?auto=format&fit=crop&w=1000&q=80',
                'publishedAt' => date('c', strtotime('-2 hours')),
                'content' => 'Perkembangan kecerdasan buatan di Nusantara semakin pesat dengan hadirnya model prediksi iklim berbasis deep learning...',
                'category' => 'technology',
            ],
            [
                'source' => ['name' => 'Ekonomi & Bisnis Hari Ini'],
                'author' => 'Siti Rahma',
                'title' => 'Pertumbuhan Ekonomi Digital Indonesia Diperkirakan Tembus Rp 1.500 Triliun pada Tahun 2026',
                'description' => 'Sektor e-commerce, fintech, dan teknologi hijau menjadi pendorong utama melesatnya transaksi perekonomian digital di tanah air.',
                'url' => 'https://example.com/news/2',
                'urlToImage' => 'https://images.unsplash.com/photo-1590283603385-17ffb3a7f29f?auto=format&fit=crop&w=1000&q=80',
                'publishedAt' => date('c', strtotime('-4 hours')),
                'content' => 'Laporan ekonomi kuartal terbaru menunjukkan tren positif pertumbuhan Usaha Mikro Kecil dan Menengah yang makin terdigitalisasi...',
                'category' => 'business',
            ],
            [
                'source' => ['name' => 'Warta Olahraga'],
                'author' => 'Andi Wijaya',
                'title' => 'Timnas Indonesia Raih Kemenangan Spektakuler dalam Laga Kualifikasi Internasional',
                'description' => 'Performa gemilang lini serang dan pertahanan kokoh membawa skuad Garuda mengamankan tiket menuju putaran berikutnya dengan skor 3-1.',
                'url' => 'https://example.com/news/3',
                'urlToImage' => 'https://images.unsplash.com/photo-1508098682722-e99c43a406b2?auto=format&fit=crop&w=1000&q=80',
                'publishedAt' => date('c', strtotime('-5 hours')),
                'content' => 'Dukungan penuh puluhan ribu suporter di stadion membakar semangat para pemain sejak peluit pertama dibunyikan...',
                'category' => 'sports',
            ],
            [
                'source' => ['name' => 'Media Kesehatan'],
                'author' => 'Dr. Maya Putri',
                'title' => 'Studi Terbaru: Pola Tidur Teratur dan Jalan Kaki 15 Menit Tingkatkan Produktivitas Kerja',
                'description' => 'Penelitian terkini mengungkapkan rahasia menjaga konsentrasi dan kebugaran tubuh di tengah padatnya jam kerja perkotaan.',
                'url' => 'https://example.com/news/4',
                'urlToImage' => 'https://images.unsplash.com/photo-1506126613408-eca07ce68773?auto=format&fit=crop&w=1000&q=80',
                'publishedAt' => date('c', strtotime('-7 hours')),
                'content' => 'Menjaga ritme sirkadian dan asupan nutrisi seimbang terbukti mengurangi tingkat stres secara signifikan...',
                'category' => 'health',
            ],
            [
                'source' => ['name' => 'Hiburan Kita'],
                'author' => 'Rian Ardiansyah',
                'title' => 'Film Karya Sutradara Muda Indonesia Berhasil Meraih Penghargaan Internasional',
                'description' => 'Karya sinematik berlatar kebudayaan lokal sukses mencuri perhatian para kritikus film dunia di festival film ternama.',
                'url' => 'https://example.com/news/5',
                'urlToImage' => 'https://images.unsplash.com/photo-1489599849927-2ee91cede3ba?auto=format&fit=crop&w=1000&q=80',
                'publishedAt' => date('c', strtotime('-9 hours')),
                'content' => 'Visualisasi memukau dan tata musik khas menjadi nilai tambah yang mendapat sambutan tepuk tangan meriah dari penonton...',
                'category' => 'entertainment',
            ],
            [
                'source' => ['name' => 'Sains & Alam'],
                'author' => 'Prof. Haryanto',
                'title' => 'Penemuan Spesies Tumbuhan Baru di Hutan Hujan Kalimantan Menarik Perhatian Dunia Science',
                'description' => 'Keanekaragaman hayati Indonesia kembali terbukti dengan ditemukannya flora langka yang memiliki khasiat medis alami.',
                'url' => 'https://example.com/news/6',
                'urlToImage' => 'https://images.unsplash.com/photo-1511497584788-8767611136f6?auto=format&fit=crop&w=1000&q=80',
                'publishedAt' => date('c', strtotime('-11 hours')),
                'content' => 'Tim peneliti lintas negara telah melakukan eksplorasi mendalam selama lebih dari enam bulan di kawasan konservasi...',
                'category' => 'science',
            ],
            [
                'source' => ['name' => 'Gadget & Tech Review'],
                'author' => 'Kevin Tan',
                'title' => 'Peluncuran Smartphone Berlayar Lipat Terbaru Hadirkan Fitur Kamera Berbasis AI',
                'description' => 'Teknologi pemrosesan citra tingkat tinggi memungkinkan pengambilan gambar jernih dalam kondisi minim cahaya secara otomatis.',
                'url' => 'https://example.com/news/7',
                'urlToImage' => 'https://images.unsplash.com/photo-1511707171634-5f897ff02aa9?auto=format&fit=crop&w=1000&q=80',
                'publishedAt' => date('c', strtotime('-14 hours')),
                'content' => 'Baterai berkapasitas besar dengan teknologi pengisian daya ultra cepat menjadi salah satu nilai jual utama perangkat ini...',
                'category' => 'technology',
            ],
            [
                'source' => ['name' => 'Finansial Ku'],
                'author' => 'Dewi Lestari',
                'title' => 'Tips Mengelola Keuangan Investasi Bagi Generasi Muda di Tahun 2026',
                'description' => 'Diversifikasi portofolio dan pemahaman risiko menjadi kunci utama membangun ketahanan finansial jangka panjang.',
                'url' => 'https://example.com/news/8',
                'urlToImage' => 'https://images.unsplash.com/photo-1559526324-4b87b5e36e44?auto=format&fit=crop&w=1000&q=80',
                'publishedAt' => date('c', strtotime('-18 hours')),
                'content' => 'Pentingnya memiliki dana darurat sebelum memulai investasi instrumen pasar modal maupun aset alternatif...',
                'category' => 'business',
            ],
        ];

        // Filter by category if not general
        if ($category !== 'general') {
            $filtered = array_values(array_filter($allArticles, function ($art) use ($category) {
                return $art['category'] === $category;
            }));
            if (! empty($filtered)) {
                $allArticles = $filtered;
            }
        }

        // Filter by search query if set
        if (! empty($search)) {
            $searchLower = strtolower($search);
            $searched = array_values(array_filter($allArticles, function ($art) use ($searchLower) {
                return str_contains(strtolower($art['title']), $searchLower) || str_contains(strtolower($art['description']), $searchLower);
            }));
            if (! empty($searched)) {
                $allArticles = $searched;
            }
        }

        return $allArticles;
    }
}
