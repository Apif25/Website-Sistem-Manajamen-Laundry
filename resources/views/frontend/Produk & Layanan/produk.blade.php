@extends('frontend.layouts.app')

@section('content')
<div class="top-container">
    <img src="{{ asset('img/produk & layanan/Produk.png') }}" alt="Produk" class="bg-hero-image">
    <div class="top-container-text">
        <H1>PRODUK KAMI</H1>
    </div>
</div>
<div class="prd-grid">
    <div class="prd-card">
        <a>
            <img src="{{ asset('img/produk/contoh.png') }}">
            <p class="prd-title">nama produk</p>
        </a>
    </div>
</div>
@endsection