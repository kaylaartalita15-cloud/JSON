<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NusantaraNews - Portal Berita Terkini & Terpercaya (NewsAPI)</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Playfair+Display:ital,wght@0,600;0,800;1,600&display=swap" rel="stylesheet">

    <!-- FontAwesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        :root {
            --bg-primary: #0f172a;
            --bg-secondary: #1e293b;
            --bg-card: #1e293b;
            --text-main: #f8fafc;
            --text-muted: #94a3b8;
            --accent-red: #ef4444;
            --accent-blue: #3b82f6;
            --border-color: #334155;
            --glass-bg: rgba(30, 41, 59, 0.85);
        }

        .light-mode {
            --bg-primary: #f8fafc;
            --bg-secondary: #ffffff;
            --bg-card: #ffffff;
            --text-main: #0f172a;
            --text-muted: #64748b;
            --accent-red: #dc2626;
            --accent-blue: #2563eb;
            --border-color: #e2e8f0;
            --glass-bg: rgba(255, 255, 255, 0.9);
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: 'Plus Jakarta Sans', sans-serif;
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        body {
            background-color: var(--bg-primary);
            color: var(--text-main);
            min-height: 100vh;
        }

        /* Glass Header */
        .header-sticky {
            position: sticky;
            top: 0;
            z-index: 50;
            background: var(--glass-bg);
            backdrop-filter: blur(12px);
            border-bottom: 1px solid var(--border-color);
        }

        .container {
            max-width: 1280px;
            margin: 0 auto;
            padding: 0 1.5rem;
        }

        /* Breaking News Ticker */
        .ticker-wrap {
            background: linear-gradient(90deg, #ef4444 0%, #b91c1c 100%);
            color: white;
            padding: 0.5rem 0;
            overflow: hidden;
            font-size: 0.875rem;
            font-weight: 600;
        }
        .ticker {
            display: flex;
            white-space: nowrap;
            animation: ticker 30s linear infinite;
        }
        .ticker:hover {
            animation-play-state: paused;
        }
        .ticker-item {
            padding: 0 2rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        @keyframes ticker {
            0% { transform: translateX(100%); }
            100% { transform: translateX(-100%); }
        }

        /* Navigation Bar */
        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1rem 0;
        }

        .brand-logo {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            font-family: 'Playfair Display', serif;
            font-size: 1.75rem;
            font-weight: 800;
            color: var(--text-main);
            text-decoration: none;
        }
        .brand-badge {
            background: var(--accent-red);
            color: white;
            font-size: 0.75rem;
            padding: 0.2rem 0.5rem;
            border-radius: 6px;
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-weight: 700;
            text-transform: uppercase;
        }

        .nav-actions {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .search-box {
            position: relative;
        }
        .search-input {
            background: var(--bg-secondary);
            border: 1px solid var(--border-color);
            color: var(--text-main);
            padding: 0.6rem 1rem 0.6rem 2.5rem;
            border-radius: 9999px;
            outline: none;
            width: 240px;
            font-size: 0.875rem;
            transition: all 0.3s ease;
        }
        .search-input:focus {
            width: 320px;
            border-color: var(--accent-blue);
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.2);
        }
        .search-icon {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-muted);
        }

        .btn-icon {
            background: var(--bg-secondary);
            border: 1px solid var(--border-color);
            color: var(--text-main);
            width: 42px;
            height: 42px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.2s ease;
        }
        .btn-icon:hover {
            border-color: var(--accent-blue);
            color: var(--accent-blue);
            transform: translateY(-2px);
        }

        /* Category Tabs Bar */
        .categories-bar {
            display: flex;
            gap: 0.5rem;
            padding: 0.75rem 0;
            overflow-x: auto;
            border-top: 1px solid var(--border-color);
            scrollbar-width: none;
        }
        .categories-bar::-webkit-scrollbar {
            display: none;
        }
        .cat-tab {
            background: transparent;
            color: var(--text-muted);
            border: none;
            padding: 0.6rem 1.2rem;
            border-radius: 9999px;
            font-weight: 600;
            font-size: 0.875rem;
            cursor: pointer;
            white-space: nowrap;
            transition: all 0.2s ease;
        }
        .cat-tab:hover {
            color: var(--text-main);
            background: rgba(255, 255, 255, 0.05);
        }
        .cat-tab.active {
            background: var(--accent-red);
            color: white;
            box-shadow: 0 4px 12px rgba(239, 68, 68, 0.3);
        }

        /* Hero Featured Article */
        .hero-section {
            margin: 2rem 0;
        }
        .hero-card {
            position: relative;
            border-radius: 20px;
            overflow: hidden;
            min-height: 420px;
            display: flex;
            align-items: flex-end;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
        }
        .hero-img {
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            filter: brightness(0.7);
            transition: transform 0.5s ease;
        }
        .hero-card:hover .hero-img {
            transform: scale(1.03);
        }
        .hero-overlay {
            position: relative;
            z-index: 10;
            padding: 2.5rem;
            background: linear-gradient(to top, rgba(15, 23, 42, 0.95) 0%, rgba(15, 23, 42, 0.4) 60%, transparent 100%);
            width: 100%;
        }
        .hero-meta {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin-bottom: 0.75rem;
        }
        .hero-title {
            font-family: 'Playfair Display', serif;
            font-size: 2.25rem;
            font-weight: 800;
            color: white;
            line-height: 1.25;
            margin-bottom: 1rem;
        }
        .hero-desc {
            color: #cbd5e1;
            font-size: 1rem;
            max-width: 800px;
            margin-bottom: 1.5rem;
            line-height: 1.6;
        }

        /* News Cards Grid */
        .news-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
            gap: 1.75rem;
            margin-bottom: 4rem;
        }
        .news-card {
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: 16px;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            cursor: pointer;
        }
        .news-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 12px 30px rgba(0, 0, 0, 0.15);
            border-color: var(--accent-blue);
        }
        .card-img-wrap {
            position: relative;
            height: 200px;
            overflow: hidden;
            background: #1e293b;
        }
        .card-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }
        .news-card:hover .card-img {
            transform: scale(1.08);
        }
        .card-body {
            padding: 1.25rem;
            display: flex;
            flex-direction: column;
            flex-grow: 1;
        }
        .card-source {
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
            color: var(--accent-blue);
            margin-bottom: 0.5rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .card-title {
            font-size: 1.1rem;
            font-weight: 700;
            line-height: 1.4;
            color: var(--text-main);
            margin-bottom: 0.75rem;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
        .card-desc {
            font-size: 0.875rem;
            color: var(--text-muted);
            line-height: 1.5;
            margin-bottom: 1.25rem;
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
        .card-footer {
            margin-top: auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 0.75rem;
            color: var(--text-muted);
            border-top: 1px solid var(--border-color);
            padding-top: 0.75rem;
        }

        /* Status Badge for API source */
        .api-status-banner {
            background: rgba(59, 130, 246, 0.1);
            border: 1px solid rgba(59, 130, 246, 0.3);
            border-radius: 12px;
            padding: 0.75rem 1.25rem;
            margin-bottom: 1.5rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 0.875rem;
        }

        /* Buttons */
        .btn-primary {
            background: var(--accent-red);
            color: white;
            border: none;
            padding: 0.6rem 1.25rem;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            transition: all 0.2s ease;
        }
        .btn-primary:hover {
            opacity: 0.9;
            transform: translateY(-1px);
        }

        /* Modal */
        .modal-backdrop {
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.7);
            backdrop-filter: blur(4px);
            z-index: 100;
            display: none;
            align-items: center;
            justify-content: center;
            padding: 1.5rem;
        }
        .modal-backdrop.active {
            display: flex;
        }
        .modal-card {
            background: var(--bg-secondary);
            border: 1px solid var(--border-color);
            border-radius: 20px;
            max-width: 700px;
            width: 100%;
            max-height: 90vh;
            overflow-y: auto;
            padding: 2rem;
            position: relative;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
        }
        .modal-close {
            position: absolute;
            top: 1.25rem;
            right: 1.25rem;
            background: transparent;
            border: none;
            color: var(--text-muted);
            font-size: 1.25rem;
            cursor: pointer;
        }

        /* Footer */
        footer {
            border-top: 1px solid var(--border-color);
            padding: 3rem 0;
            text-align: center;
            color: var(--text-muted);
            font-size: 0.875rem;
        }

        @media (max-width: 768px) {
            .hero-title { font-size: 1.5rem; }
            .hero-card { min-height: 320px; }
            .search-input { width: 160px; }
            .search-input:focus { width: 200px; }
        }
    </style>
</head>
<body>

    <!-- Breaking News Ticker -->
    <div class="ticker-wrap">
        <div class="ticker">
            <div class="ticker-item"><i class="fa-solid fa-bolt"></i> BREAKING NEWS: Inovasi AI Terbaru Berhasil Mengubah Peta Teknologi Nasional</div>
            <div class="ticker-item"><i class="fa-solid fa-chart-line"></i> PASAR SAHAM: Indeks Harga Saham Gabungan Menguat di Awal Pekan Ini</div>
            <div class="ticker-item"><i class="fa-solid fa-trophy"></i> OLAHRAGA: Kemenangan Gemilang Timnas Indonesia di Laga Internasional</div>
        </div>
    </div>

    <!-- Sticky Navigation Header -->
    <header class="header-sticky">
        <div class="container">
            <div class="navbar">
                <a href="/" class="brand-logo">
                    <i class="fa-solid fa-newspaper text-red-500" style="color: var(--accent-red)"></i>
                    Nusantara<span style="color: var(--accent-red)">News</span>
                    <span class="brand-badge">NewsAPI</span>
                </a>

                <div class="nav-actions">
                    <!-- Live Search -->
                    <div class="search-box">
                        <i class="fa-solid fa-magnifying-glass search-icon"></i>
                        <input type="text" id="searchInput" class="search-input" placeholder="Cari berita..." value="{{ $searchQuery }}">
                    </div>

                    <!-- Bookmark View Toggle -->
                    <button class="btn-icon" id="btnBookmarks" title="Berita Tersimpan">
                        <i class="fa-solid fa-bookmark"></i>
                    </button>

                    <!-- API Key Settings Modal Trigger -->
                    <button class="btn-icon" id="btnSettings" title="Pengaturan NewsAPI Key">
                        <i class="fa-solid fa-key"></i>
                    </button>

                    <!-- Dark / Light Theme Toggle -->
                    <button class="btn-icon" id="btnTheme" title="Ganti Tema">
                        <i class="fa-solid fa-moon"></i>
                    </button>
                </div>
            </div>

            <!-- Category Filter Tabs -->
            <div class="categories-bar" id="categoryTabs">
                <button class="cat-tab {{ $selectedCategory === 'general' ? 'active' : '' }}" data-cat="general"><i class="fa-solid fa-fire"></i> Utama</button>
                <button class="cat-tab {{ $selectedCategory === 'business' ? 'active' : '' }}" data-cat="business"><i class="fa-solid fa-briefcase"></i> Bisnis</button>
                <button class="cat-tab {{ $selectedCategory === 'technology' ? 'active' : '' }}" data-cat="technology"><i class="fa-solid fa-microchip"></i> Teknologi</button>
                <button class="cat-tab {{ $selectedCategory === 'sports' ? 'active' : '' }}" data-cat="sports"><i class="fa-solid fa-futbol"></i> Olahraga</button>
                <button class="cat-tab {{ $selectedCategory === 'entertainment' ? 'active' : '' }}" data-cat="entertainment"><i class="fa-solid fa-film"></i> Hiburan</button>
                <button class="cat-tab {{ $selectedCategory === 'health' ? 'active' : '' }}" data-cat="health"><i class="fa-solid fa-heart-pulse"></i> Kesehatan</button>
                <button class="cat-tab {{ $selectedCategory === 'science' ? 'active' : '' }}" data-cat="science"><i class="fa-solid fa-flask"></i> Sains</button>
            </div>
        </div>
    </header>

    <main class="container">
        <!-- API Info Banner -->
        <div style="margin-top: 1.5rem">
            @if($sourceType === 'fallback')
                <div class="api-status-banner">
                    <div>
                        <i class="fa-solid fa-circle-info" style="color: var(--accent-blue)"></i>
                        <strong>Mode Berita Indonesia (Sample Fallback):</strong> Menampilkan curated berita terkini. 
                        <span>Untuk berita real-time langsung dari NewsAPI, klik tombol kunci <i class="fa-solid fa-key"></i> untuk memasukkan API Key Anda.</span>
                    </div>
                    <button class="btn-primary" onclick="openKeyModal()" style="font-size: 0.75rem; padding: 0.4rem 0.8rem">
                        Set API Key
                    </button>
                </div>
            @else
                <div class="api-status-banner" style="background: rgba(16, 185, 129, 0.1); border-color: rgba(16, 185, 129, 0.3);">
                    <div>
                        <i class="fa-solid fa-circle-check" style="color: #10b981"></i>
                        <strong>Terhubung ke NewsAPI.org Live:</strong> Menyajikan {{ $totalResults }} artikel terkini secara real-time.
                    </div>
                </div>
            @endif
        </div>

        <!-- Hero Spotlight Article -->
        @if(!empty($articles) && count($articles) > 0)
            @php $hero = $articles[0]; @endphp
            <section class="hero-section">
                <div class="hero-card" onclick="openArticleModal(0)">
                    <img src="{{ $hero['urlToImage'] ?? 'https://images.unsplash.com/photo-1504711434969-e33886168f5c?auto=format&fit=crop&w=1200&q=80' }}" 
                         alt="{{ $hero['title'] }}" 
                         class="hero-img"
                         onerror="this.src='https://images.unsplash.com/photo-1504711434969-e33886168f5c?auto=format&fit=crop&w=1200&q=80'">
                    <div class="hero-overlay">
                        <div class="hero-meta">
                            <span class="brand-badge"><i class="fa-solid fa-star"></i> Headline Utama</span>
                            <span style="color: #94a3b8; font-size: 0.875rem;">
                                <i class="fa-solid fa-clock"></i> {{ date('d M Y, H:i', strtotime($hero['publishedAt'] ?? 'now')) }}
                            </span>
                        </div>
                        <h1 class="hero-title">{{ $hero['title'] }}</h1>
                        <p class="hero-desc">{{ $hero['description'] ?? 'Klik untuk membaca selengkapnya artikel berita headline utama terkini dari sumber terpercaya.' }}</p>
                        <button class="btn-primary">
                            Baca Selengkapnya <i class="fa-solid fa-arrow-right"></i>
                        </button>
                    </div>
                </div>
            </section>
        @endif

        <!-- Grid Berita -->
        <h2 style="font-family: 'Playfair Display', serif; font-size: 1.75rem; margin-bottom: 1.5rem;" id="sectionTitle">
            Berita Terkini
        </h2>

        <div class="news-grid" id="newsGrid">
            @if(empty($articles))
                <div style="grid-column: 1 / -1; text-align: center; padding: 4rem 0; color: var(--text-muted)">
                    <i class="fa-solid fa-newspaper" style="font-size: 3rem; margin-bottom: 1rem"></i>
                    <p>Tidak ada berita ditemukan untuk pencarian ini.</p>
                </div>
            @else
                @foreach($articles as $index => $article)
                    @if($index > 0 || count($articles) == 1)
                        <div class="news-card" onclick="openArticleModal({{ $index }})">
                            <div class="card-img-wrap">
                                <img src="{{ $article['urlToImage'] ?? 'https://images.unsplash.com/photo-1585829365295-ab7cd400c167?auto=format&fit=crop&w=600&q=80' }}" 
                                     alt="{{ $article['title'] }}" 
                                     class="card-img"
                                     onerror="this.src='https://images.unsplash.com/photo-1585829365295-ab7cd400c167?auto=format&fit=crop&w=600&q=80'">
                            </div>
                            <div class="card-body">
                                <div class="card-source">
                                    <span>{{ $article['source']['name'] ?? 'Berita' }}</span>
                                    <button onclick="event.stopPropagation(); toggleBookmark({{ $index }})" style="background:none; border:none; color:var(--text-muted); cursor:pointer">
                                        <i class="fa-regular fa-bookmark" id="bm-icon-{{ $index }}"></i>
                                    </button>
                                </div>
                                <h3 class="card-title">{{ $article['title'] }}</h3>
                                <p class="card-desc">{{ $article['description'] ?? 'Klik untuk membaca rincian lengkap dari artikel berita terkini ini.' }}</p>
                                <div class="card-footer">
                                    <span><i class="fa-regular fa-user"></i> {{ $article['author'] ?? 'Redaksi' }}</span>
                                    <span><i class="fa-regular fa-clock"></i> {{ date('d M H:i', strtotime($article['publishedAt'] ?? 'now')) }}</span>
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach
            @endif
        </div>
    </main>

    <!-- Modal Article Detail Reader -->
    <div class="modal-backdrop" id="articleModal">
        <div class="modal-card">
            <button class="modal-close" onclick="closeArticleModal()"><i class="fa-solid fa-xmark"></i></button>
            <div id="modalContent">
                <!-- Dynamic Content via JS -->
            </div>
        </div>
    </div>

    <!-- Modal API Key Configuration -->
    <div class="modal-backdrop" id="keyModal">
        <div class="modal-card" style="max-width: 480px">
            <button class="modal-close" onclick="closeKeyModal()"><i class="fa-solid fa-xmark"></i></button>
            <h3 style="font-size: 1.25rem; font-weight: 700; margin-bottom: 1rem">
                <i class="fa-solid fa-key" style="color: var(--accent-red)"></i> NewsAPI.org API Key
            </h3>
            <p style="font-size: 0.875rem; color: var(--text-muted); margin-bottom: 1.5rem">
                Dapatkan API Key gratis di <a href="https://newsapi.org" target="_blank" style="color: var(--accent-blue)">newsapi.org</a> untuk mengakses ribuan sumber berita langsung.
            </p>
            <div style="margin-bottom: 1.5rem">
                <label style="font-size: 0.875rem; font-weight: 600; display: block; margin-bottom: 0.5rem">API Key Anda:</label>
                <input type="text" id="apiKeyInput" class="search-input" style="width: 100%; border-radius: 8px;" placeholder="Contoh: a1b2c3d4e5f67890...">
            </div>
            <div style="display: flex; gap: 0.75rem; justify-content: flex-end">
                <button class="btn-primary" style="background: var(--border-color)" onclick="closeKeyModal()">Batal</button>
                <button class="btn-primary" onclick="saveApiKey()">Simpan Key</button>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer>
        <div class="container">
            <p>© 2026 NusantaraNews Portal — Ditenagai oleh <strong>NewsAPI.org</strong> & Laravel</p>
        </div>
    </footer>

    <!-- Frontend Interactive Script -->
    <script>
        const articlesData = @json($articles);
        let activeCategory = "{{ $selectedCategory }}";

        // Dark / Light Theme Toggle
        const btnTheme = document.getElementById('btnTheme');
        btnTheme.addEventListener('click', () => {
            document.body.classList.toggle('light-mode');
            const isLight = document.body.classList.contains('light-mode');
            btnTheme.innerHTML = isLight ? '<i class="fa-solid fa-sun"></i>' : '<i class="fa-solid fa-moon"></i>';
            localStorage.setItem('theme', isLight ? 'light' : 'dark');
        });

        // Load Saved Theme
        if (localStorage.getItem('theme') === 'light') {
            document.body.classList.add('light-mode');
            btnTheme.innerHTML = '<i class="fa-solid fa-sun"></i>';
        }

        // Search Input Handling
        const searchInput = document.getElementById('searchInput');
        let searchTimeout;
        searchInput.addEventListener('input', (e) => {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(() => {
                const query = e.target.value;
                window.location.href = `/?category=${activeCategory}&q=${encodeURIComponent(query)}`;
            }, 600);
        });

        // Category Tab Switching
        document.querySelectorAll('.cat-tab').forEach(tab => {
            tab.addEventListener('click', function() {
                const cat = this.getAttribute('data-cat');
                window.location.href = `/?category=${cat}`;
            });
        });

        <!-- Modal Functions -->
        function openArticleModal(index) {
            const art = articlesData[index];
            if (!art) return;

            const modalContent = document.getElementById('modalContent');
            modalContent.innerHTML = `
                <span class="brand-badge" style="margin-bottom: 0.75rem; display: inline-block">${art.source.name || 'Berita'}</span>
                <h2 style="font-family: 'Playfair Display', serif; font-size: 1.75rem; line-height: 1.3; margin-bottom: 1rem">${art.title}</h2>
                <div style="font-size: 0.875rem; color: var(--text-muted); margin-bottom: 1.5rem">
                    <span><i class="fa-regular fa-user"></i> ${art.author || 'Redaksi'}</span> • 
                    <span><i class="fa-regular fa-clock"></i> ${new Date(art.publishedAt).toLocaleString('id-ID')}</span>
                </div>
                <img src="${art.urlToImage || 'https://images.unsplash.com/photo-1504711434969-e33886168f5c?auto=format&fit=crop&w=1000&q=80'}" style="width:100%; height:320px; object-fit:cover; border-radius:12px; margin-bottom:1.5rem">
                <p style="font-size: 1.05rem; line-height: 1.7; color: var(--text-main); margin-bottom: 1.5rem">${art.description || ''}</p>
                <p style="font-size: 0.95rem; line-height: 1.6; color: var(--text-muted); margin-bottom: 2rem">${art.content || 'Konten berita disajikan langsung dari penyedia sumber berita resmi.'}</p>
                <div style="display:flex; justify-content:space-between; align-items:center; border-top:1px solid var(--border-color); padding-top:1.25rem">
                    <button class="btn-primary" onclick="closeArticleModal()" style="background:var(--border-color)">Tutup</button>
                    <a href="${art.url}" target="_blank" class="btn-primary">
                        Baca Sumber Asli <i class="fa-solid fa-arrow-up-right-from-square"></i>
                    </a>
                </div>
            `;
            document.getElementById('articleModal').classList.add('active');
        }

        function closeArticleModal() {
            document.getElementById('articleModal').classList.remove('active');
        }

        // API Key Modal
        function openKeyModal() {
            document.getElementById('apiKeyInput').value = localStorage.getItem('news_api_key') || '';
            document.getElementById('keyModal').classList.add('active');
        }
        function closeKeyModal() {
            document.getElementById('keyModal').classList.remove('active');
        }
        document.getElementById('btnSettings').addEventListener('click', openKeyModal);

        function saveApiKey() {
            const key = document.getElementById('apiKeyInput').value.trim();
            if (key) {
                localStorage.setItem('news_api_key', key);
                window.location.href = `/?apiKey=${encodeURIComponent(key)}`;
            } else {
                localStorage.removeItem('news_api_key');
                window.location.href = `/`;
            }
        }

        // Bookmark Handler
        function toggleBookmark(index) {
            const icon = document.getElementById(`bm-icon-${index}`);
            if (icon.classList.contains('fa-regular')) {
                icon.classList.remove('fa-regular');
                icon.classList.add('fa-solid');
                icon.style.color = 'var(--accent-red)';
            } else {
                icon.classList.remove('fa-solid');
                icon.classList.add('fa-regular');
                icon.style.color = 'var(--text-muted)';
            }
        }
    </script>
</body>
</html>
