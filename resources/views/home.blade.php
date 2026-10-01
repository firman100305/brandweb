<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Thream 3AM — Pakaian untuk jam-jam sepi</title>
    <meta name="description" content="Thream (3AM) adalah brand pakaian hitam-putih yang dibuat untuk jam-jam ketika kota sudah sepi.">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Archivo:wght@400;500;700&family=Permanent+Marker&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <p class="notice">Website perkenalan brand dan produk. Belum ada penjualan online.</p>

    <header class="bar">
        <button class="burger" type="button" aria-controls="nav" aria-expanded="false">Menu</button>
        <nav id="nav" class="nav" aria-label="Utama">
            <a href="#produk">Produk</a>
            <a href="#tentang">Tentang</a>
            <a href="#kontak">Kontak</a>
        </nav>
        <a class="logo" href="#atas" aria-label="Thream 3AM, kembali ke atas">3AM</a>
        <a class="ig" href="https://instagram.com/" rel="noopener">Instagram</a>
    </header>

    <main id="atas">
        <section class="hero">
            <h1 class="hero-mark" aria-label="3AM oleh Thream">3AM</h1>
            <div class="hero-cap">
                <p>Thream, pakaian untuk jam-jam sepi.</p>
                <a href="#produk">Lihat produk</a>
            </div>
        </section>

        <section id="produk" class="section">
            <div class="section-head">
                <h2>Produk</h2>
                <div class="tabs" role="group" aria-label="Filter kategori">
                    <button type="button" data-filter="Semua" aria-pressed="true">Semua</button>
                    <button type="button" data-filter="Kaos" aria-pressed="false">Kaos</button>
                    <button type="button" data-filter="Hoodie" aria-pressed="false">Hoodie</button>
                    <button type="button" data-filter="Aksesori" aria-pressed="false">Aksesori</button>
                </div>
            </div>

            <div class="grid">
                @foreach ($products as $p)
                    <button class="card" type="button" data-category="{{ $p['category'] }}" data-product="{{ json_encode($p) }}">
                        <span class="shot" style="--tee: {{ $p['tone'] === 'black' ? '#000' : '#fff' }}; --ink: {{ $p['tone'] === 'black' ? '#fff' : '#000' }}; --edge: {{ $p['tone'] === 'black' ? '#000' : '#111' }}">
                            <svg viewBox="0 0 200 200" role="img" aria-label="{{ $p['name'] }}">
                                @if ($p['type'] === 'hoodie')
                                    <path d="M78 18 Q100 34 122 18 L150 30 L184 120 L160 130 L146 92 L146 182 L54 182 L54 92 L40 130 L16 120 L50 30Z" fill="var(--tee)" stroke="var(--edge)" stroke-width="1.5"/>
                                    <path d="M78 18 Q100 62 122 18" fill="none" stroke="#8a8a8a" stroke-width="1.5"/>
                                @elseif ($p['type'] === 'cap')
                                    <path d="M32 130 Q32 58 100 58 Q168 58 168 130Z" fill="var(--tee)" stroke="var(--edge)" stroke-width="1.5"/>
                                    <path d="M32 130 L188 130 Q194 146 170 150 L42 150Z" fill="var(--tee)" stroke="var(--edge)" stroke-width="1.5"/>
                                @else
                                    <path d="M70 20 L20 45 L38 85 L58 76 L58 180 L142 180 L142 76 L162 85 L180 45 L130 20 Q100 40 70 20Z" fill="var(--tee)" stroke="var(--edge)" stroke-width="1.5"/>
                                @endif
                                <text x="100" y="{{ $p['type'] === 'cap' ? 108 : 114 }}" text-anchor="middle" font-family="'Permanent Marker', cursive" font-size="{{ $p['type'] === 'cap' ? 22 : 26 }}" fill="var(--ink)">3AM</text>
                            </svg>
                        </span>
                        <span class="name">{{ $p['name'] }}</span>
                        <span class="cat">{{ $p['category'] }}</span>
                    </button>
                @endforeach
            </div>
        </section>

        <section id="tentang" class="section about">
            <h2>Tentang</h2>
            <div class="about-text">
                <p>Thream lahir dari kebiasaan begadang. Jam 3 pagi adalah waktu paling jujur: tidak ada yang menonton dan tidak ada yang perlu dibuktikan.</p>
                <p>Kami membuat pakaian yang terasa seperti itu. Hitam, putih, dan tanpa banyak bicara.</p>
            </div>
        </section>
    </main>

    <footer id="kontak" class="foot">
        <div class="cols">
            <div>
                <h3>Thream</h3>
                <a href="#produk">Produk</a>
                <a href="#tentang">Tentang</a>
            </div>
            <div>
                <h3>Ikuti</h3>
                <a href="https://instagram.com/" rel="noopener">Instagram</a>
                <a href="https://tiktok.com/" rel="noopener">TikTok</a>
            </div>
            <div>
                <h3>Kontak</h3>
                <a href="mailto:hello@example.com">hello@example.com</a>
            </div>
        </div>
        <p class="copy">© {{ date('Y') }} Thream</p>
    </footer>

    <dialog id="detail" aria-labelledby="d-name">
        <form method="dialog"><button class="close" type="submit">Tutup</button></form>
        <div class="d-grid">
            <div class="d-shot" id="d-shot"></div>
            <div class="d-body">
                <p id="d-cat" class="cat"></p>
                <h3 id="d-name"></h3>
                <p id="d-desc"></p>
                <dl>
                    <dt>Bahan</dt><dd id="d-material"></dd>
                    <dt>Warna</dt><dd id="d-colors"></dd>
                    <dt>Ukuran</dt><dd id="d-sizes"></dd>
                </dl>
            </div>
        </div>
    </dialog>
</body>
</html>
