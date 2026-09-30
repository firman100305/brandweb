<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Voltage Riot — Streetwear Pop, Rock, Metal</title>
    <meta name="description" content="Streetwear dengan suara keras: koleksi pop, rock, dan metal.">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Anton&family=Archivo:wght@400;600;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <header class="bar">
        <a class="logo" href="/">VOLTAGE RIOT</a>
        <nav id="nav" class="nav" aria-label="Utama">
            <a href="#koleksi">Koleksi</a>
            <a href="#drop">Drop terbaru</a>
            <a href="#kabar">Kabar</a>
        </nav>
        <button class="cart" type="button" aria-label="Keranjang">Keranjang <span id="cart-count">0</span></button>
        <button class="burger" type="button" aria-controls="nav" aria-expanded="false" aria-label="Buka menu">Menu</button>
    </header>

    <main>
        <section class="hero">
            <h1 class="hero-title" aria-label="Pakai volumenya">
                <span>Pakai</span>
                <span class="outline">volume</span>
                <span>nya.</span>
            </h1>
            <p class="hero-copy">Streetwear untuk yang dengar musik terlalu keras. Cetak tebal, bahan berat, produksi terbatas.</p>
            <a class="btn" href="#drop">Lihat drop terbaru</a>
        </section>

        <div class="ticker" aria-hidden="true">
            <div class="ticker-track">
                @for ($i = 0; $i < 4; $i++)
                    <span>POP</span><span>ROCK</span><span>METAL</span><span>STREET</span>
                @endfor
            </div>
        </div>

        <section id="koleksi" class="section">
            <h2>Empat koleksi, satu panggung</h2>
            <ul class="lineup">
                @foreach ($collections as $c)
                    <li>
                        <a href="#drop" data-filter="{{ strtolower($c['name']) }}">
                            <strong>{{ $c['name'] }}</strong>
                            <span class="lineup-desc">{{ $c['desc'] }}</span>
                            <span class="lineup-price">mulai Rp{{ number_format($c['from'], 0, ',', '.') }}</span>
                        </a>
                    </li>
                @endforeach
            </ul>
        </section>

        <section id="drop" class="section">
            <div class="section-head">
                <h2>Drop terbaru</h2>
                <div class="filters" role="group" aria-label="Filter genre">
                    <button type="button" data-filter="all" aria-pressed="true">Semua</button>
                    <button type="button" data-filter="pop" aria-pressed="false">Pop</button>
                    <button type="button" data-filter="rock" aria-pressed="false">Rock</button>
                    <button type="button" data-filter="metal" aria-pressed="false">Metal</button>
                    <button type="button" data-filter="street" aria-pressed="false">Street</button>
                </div>
            </div>

            <div class="grid" id="grid">
                @foreach ($products as $p)
                    <article class="card" data-genre="{{ $p['genre'] }}">
                        <div class="shot" style="--tee: {{ $p['color'] }}; --ink: {{ $p['ink'] }}">
                            <svg viewBox="0 0 200 200" role="img" aria-label="{{ $p['name'] }}">
                                <path d="M70 20 L20 45 L38 85 L58 76 L58 180 L142 180 L142 76 L162 85 L180 45 L130 20 Q100 40 70 20Z" fill="var(--tee)" stroke="#efe8da44" stroke-width="2"/>
                                <text x="100" y="118" text-anchor="middle" font-family="Anton, sans-serif" font-size="30" fill="var(--ink)">{{ $p['mark'] }}</text>
                            </svg>
                        </div>
                        <div class="meta">
                            <h3>{{ $p['name'] }}</h3>
                            <p>{{ ucfirst($p['genre']) }} · Rp{{ number_format($p['price'], 0, ',', '.') }}</p>
                        </div>
                        <button class="add" type="button">Tambah ke keranjang</button>
                    </article>
                @endforeach
            </div>
        </section>

        <section id="kabar" class="section news">
            <h2>Dapat kabar sebelum stok habis</h2>
            <p>Setiap drop cuma dibuat sekali. Masukkan email, kami kirim tanggal rilisnya.</p>
            <form class="signup" action="#" method="post" onsubmit="return false">
                <label for="email" class="sr">Email</label>
                <input id="email" type="email" placeholder="email@kamu.com" required>
                <button class="btn" type="submit">Kirim kabar drop</button>
            </form>
        </section>
    </main>

    <footer class="foot">
        <span>© {{ date('Y') }} Voltage Riot</span>
        <a href="#">Instagram</a>
        <a href="#">TikTok</a>
        <a href="#">Kontak</a>
    </footer>
</body>
</html>
