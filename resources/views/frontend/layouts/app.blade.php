<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelana Laundry</title>
    <link rel="stylesheet" href="{{ asset('templates/frontend/assets/compiled/css/navigasi.css') }}">
    <link rel="stylesheet" href="{{ asset('templates/frontend/assets/compiled/css/beranda.css') }}">
    <link rel="stylesheet" href="{{ asset('templates/frontend/assets/compiled/css/orderpopup.css') }}">
    <link rel="stylesheet" href="{{ asset('templates/frontend/assets/compiled/css/footer.css') }}">
    <link rel="stylesheet" href="{{ asset('templates/frontend/assets/compiled/css/produk-layanan.css') }}">
    <link rel="stylesheet" href="{{ asset('templates/frontend/assets/compiled/css/pesanan.css') }}">
    <link rel="stylesheet" href="{{ asset('templates/frontend/assets/compiled/css/login.css') }}">
    <link rel="stylesheet" href="{{ asset('templates/frontend/assets/compiled/css/tracker.css') }}">

    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />

    <link rel="icon" type="image/png" href="{{ asset('img/icon/Favicon.jpeg') }}">

@livewireStyles
</head>
<body>

<livewire:frontend.navbar />

<main class="main-content">
    {{ $slot ?? '' }}
    @yield('content')
</main>

@livewire('frontend.pemesanan.create-pemesanan-modal')
@include('frontend.layouts.footer')

<script src="{{ asset('templates/frontend/assets/compiled/js/navigasi.js') }}"></script>
<script src="{{ asset('templates/frontend/assets/compiled/js/popup.js') }}"></script>
<script src="{{  asset('templates/frontend/assets/compiled/js/tabel.js') }}"></script>
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
@livewireScripts
</body>
</html>