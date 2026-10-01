@php
    // Photos live in public/img (1.jpeg to 6.jpeg). Missing ones are skipped.
    $photos = collect(range(1, 6))
        ->map(fn ($n) => "img/$n.jpeg")
        ->filter(fn ($p) => file_exists(public_path($p)))
        ->values();

    // Each row: photos are repeated and shuffled, then every frame gets a random tilt.
    // The data is built once, then rendered twice (track duplicated) so the loop is seamless.
    $makeRow = fn () => collect(range(1, 3))
        ->flatMap(fn () => $photos->shuffle())
        ->map(fn ($img) => [
            'img' => $img,
            'h'   => 1,                           // all frames the same size
            'r'   => mt_rand(-10, 10) / 10,       // slight tilt (deg)
            'y'   => 0,                           // aligned, no vertical offset
            'm'   => 1.2,                         // fixed gap to the next frame (rem)
        ])
        ->values();
    $rows = ['a' => $makeRow(), 'b' => $makeRow()];
@endphp
@if ($photos->isNotEmpty())
<style>
/* Gallery styles (standalone): override the old gallery block in app.css without touching the CSS file */
.gallery { padding: clamp(.75rem, 2vw, 1.5rem) 0; overflow: hidden; }
.gallery .strips { display: flex; flex-direction: column; gap: 0; }
.gallery .strip { overflow: hidden; padding: .6rem 0; background: none; border-radius: 0; box-shadow: none; }
.gallery .strip-track { display: flex; align-items: center; width: max-content; animation: gallery-left var(--dur, 70s) linear infinite; will-change: transform; }
.gallery .strip-b .strip-track { --dur: 85s; animation-direction: reverse; }
.gallery .strip-track:has(.frame:hover) { animation-play-state: paused; }
.gallery .frame { flex: none; margin: 0 var(--m, 1.2rem) 0 0; padding: .2rem; background: #1a1a1a; border: 1px solid #333; box-shadow: 0 .5rem 1.2rem rgb(0 0 0 / .6); transform: translateY(var(--y, 0)) rotate(var(--r, 0deg)); transition: transform .5s cubic-bezier(.22, 1, .36, 1); }
.gallery .frame:hover { position: relative; z-index: 1; transform: translateY(var(--y, 0)) rotate(0deg) scale(1.04); }
.gallery .frame img { display: block; --fh: clamp(10rem, 24vw, 16rem); height: var(--fh); width: calc(var(--fh) * .8); max-width: none; aspect-ratio: 4 / 5; object-fit: cover; margin: 0; }
@keyframes gallery-left { to { transform: translateX(-50%); } }
@media (prefers-reduced-motion: reduce) { .gallery .strip { overflow-x: auto; } .gallery .strip-track { animation: none; } .gallery .frame { transition: none; } }
</style>
<section id="gallery" class="section gallery" aria-label="Gallery">
    <div class="strips">
        @foreach ($rows as $key => $row)
            <div class="strip strip-{{ $key }}">
                <div class="strip-track">
                    @foreach ([0, 1] as $copy)
                        @foreach ($row as $f)
                            <figure class="frame" style="--h:{{ $f['h'] }};--r:{{ $f['r'] }}deg;--y:{{ $f['y'] }}rem;--m:{{ $f['m'] }}rem"
                                    @if ($copy === 1) aria-hidden="true" @endif>
                                <img src="{{ asset($f['img']) }}"
                                     alt="{{ $copy === 0 ? 'Thream gallery photo' : '' }}"
                                     decoding="async">
                            </figure>
                        @endforeach
                    @endforeach
                </div>
            </div>
        @endforeach
    </div>
</section>
@endif
