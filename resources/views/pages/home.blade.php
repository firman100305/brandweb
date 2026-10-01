@extends('layouts.app')

@section('content')
    @include('sections.hero')
    @include('sections.products', ['products' => $products])
    @include('sections.about')
    @include('sections.gallery')
    @include('sections.contact')
@endsection

@push('modals')
    @include('partials.product-dialog')
@endpush
