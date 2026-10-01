@php
    $hasGallery = collect(range(1, 6))->contains(fn ($n) => file_exists(public_path("img/$n.jpeg")));
@endphp
<button class="fab" type="button" aria-controls="side" aria-expanded="false" aria-label="Open menu">
    <svg viewBox="0 0 24 24" aria-hidden="true"><path class="i-menu" d="M4 7h16M4 12h16M4 17h16"/><path class="i-x" d="M6 6l12 12M18 6L6 18"/></svg>
</button>
<div class="scrim" aria-hidden="true"></div>

<aside id="side" class="side" aria-label="Main navigation" style="--mark: url('{{ asset('logo/logo1.png') }}')">
    <a class="side-brand" href="{{ route('home') }}#top" aria-label="Thream 3AM, back to top">
        <img src="{{ asset('logo/logo1.png') }}" alt="">
        <span class="side-label">Thream</span>
    </a>

    <nav class="side-nav">
        <a class="side-link" href="{{ route('home') }}#top" data-spy="top">
            <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M4 11l8-7 8 7v9h-5v-6H9v6H4z"/></svg>
            <span class="side-label">Home</span>
        </a>
        <a class="side-link" href="{{ route('home') }}#products" data-spy="products">
            <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M8 4L3 7l2 4 3-1v10h8V10l3 1 2-4-5-3q-4 3-8 0z"/></svg>
            <span class="side-label">Collection</span>
        </a>
        <a class="side-link" href="{{ route('home') }}#about" data-spy="about">
            <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M20 14A8 8 0 1 1 10 4a6.5 6.5 0 0 0 10 10z"/></svg>
            <span class="side-label">About</span>
        </a>
        @if ($hasGallery)
        <a class="side-link" href="{{ route('home') }}#gallery" data-spy="gallery">
            <svg viewBox="0 0 24 24" aria-hidden="true"><rect x="3" y="4" width="18" height="16" rx="2"/><circle cx="9" cy="10" r="1.6"/><path d="M21 16l-5-5-8 9"/></svg>
            <span class="side-label">Gallery</span>
        </a>
        @endif
        <a class="side-link" href="{{ route('home') }}#contact" data-spy="contact">
            <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M4 6h16v12H4zM4 7l8 6 8-6"/></svg>
            <span class="side-label">Contact</span>
        </a>
    </nav>
</aside>
