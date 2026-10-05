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

    @include('partials.spider-clock')

    <div class="hero-lockup">
        @include('partials.logo-sketch')
        <h1 class="hero-word" aria-label="Thream">
            <svg class="word-sketch" viewBox="0 0 900 150" aria-hidden="true" xmlns="http://www.w3.org/2000/svg">
                <text class="wd-line" x="450" y="112" text-anchor="middle"><tspan style="--i:0">T</tspan><tspan style="--i:1">H</tspan><tspan style="--i:2">R</tspan><tspan style="--i:3">E</tspan><tspan style="--i:4">A</tspan><tspan style="--i:5">M</tspan></text>
                <text class="wd-fill" x="450" y="112" text-anchor="middle"><tspan>T</tspan><tspan>H</tspan><tspan>R</tspan><tspan>E</tspan><tspan>A</tspan><tspan>M</tspan></text>
            </svg>
        </h1>
        <p class="hero-tagline">
            <span class="sr-only">Break the routine.</span>
            <span class="tg-row" aria-hidden="true">
                @foreach (mb_str_split('BREAK THE ROUTINE.') as $i => $ch)
                    @if ($ch === ' ')
                        <span class="tg-sp"></span>
                    @else
                        <span class="tg-l" style="--i:{{ $i }}">{{ $ch }}</span>
                    @endif
                @endforeach
            </span>
        </p>
    </div>

    <div class="hero-cap">
        <p>Thream, clothing for the quiet hours.</p>
        <a href="#products">View collection</a>
    </div>
</section>
