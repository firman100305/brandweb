@php $categories = collect($products)->pluck('category')->unique()->values(); @endphp
<section id="products" class="section">
    <div class="section-head">
        <h2>Collection</h2>
        @if ($categories->count() > 1)
            <div class="tabs" role="group" aria-label="Filter by category">
                @foreach ($categories->prepend('All') as $i => $t)
                    <button type="button" data-filter="{{ $t }}" aria-pressed="{{ $i === 0 ? 'true' : 'false' }}">{{ $t }}</button>
                @endforeach
            </div>
        @endif
    </div>

    <div class="grid">
        @foreach ($products as $p)
            @php $img = file_exists(public_path($p['image'])) ? asset($p['image']) : null; @endphp
            <button class="card" type="button" data-category="{{ $p['category'] }}" data-product="{{ json_encode($p) }}">
                <span class="shot{{ $img ? '' : ' empty' }}">
                    @if ($img)
                        <img src="{{ $img }}" alt="{{ $p['name'] }}" loading="lazy">
                    @else
                        <img class="ph" src="{{ asset('logo/logo1.png') }}" alt="">
                    @endif
                </span>
                <span class="name">{{ $p['name'] }}</span>
                <span class="cat">{{ $p['category'] }}</span>
            </button>
        @endforeach
    </div>
</section>
