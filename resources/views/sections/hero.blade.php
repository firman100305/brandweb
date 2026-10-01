@php
    $collage = collect($products ?? [])
        ->pluck('image')
        ->filter(fn ($img) => file_exists(public_path($img)))
        ->values();
    // Repeat the photos several times (shuffled each round) so the collage always fills the screen, however large.
    if ($collage->isNotEmpty()) {
        $collage = collect(range(1, 4))->flatMap(fn () => $collage->shuffle())->values();
    }
@endphp
<section class="hero" id="top">
    @if ($collage->isNotEmpty())
        <div class="hero-bg" aria-hidden="true">
            <div class="hero-collage">
                @foreach ($collage as $img)
                    <img src="{{ asset($img) }}" alt="" decoding="async">
                @endforeach
            </div>
        </div>
    @endif

    @include('partials.logo-sketch')
    @include('partials.spider-clock')
    <h1 class="hero-word">Thream</h1>
    <div class="hero-cap">
        <p>Thream, clothing for the quiet hours.</p>
        <a href="#products">View collection</a>
    </div>
</section>
