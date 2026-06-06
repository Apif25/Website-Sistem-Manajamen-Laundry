<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelana Laundry</title>
    <link rel="stylesheet" href="{{ asset('templates/frontend/assets/compiled/css/navigasi.css') }}">
    <link rel="stylesheet" href="{{ asset('templates/frontend/assets/compiled/css/beranda.css') }}">
    <link rel="stylesheet" href="{{ asset('templates/frontend/assets/compiled/css/formpopup.css') }}">
    <link rel="stylesheet" href="{{ asset('templates/frontend/assets/compiled/css/footer.css') }}">
    <link rel="stylesheet" href="{{ asset('templates/frontend/assets/compiled/css/Produk&Layanan.css') }}">
    <link rel="stylesheet" href="{{ asset('templates/frontend/assets/compiled/css/Pesanan.css') }}">
    <link rel="stylesheet" href="{{ asset('templates/frontend/assets/compiled/css/tracker.css') }}">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />

@livewireStyles
</head>
<body>
<div id="navigasi">
    @include('frontend.layouts.navigasi')
</div>

<main class="main-content">
    {{ $slot ?? '' }}
    @yield('content')
</main>

@include('frontend.layouts.footer')

@include('livewire.frontend.form.loginpopup')
@include('livewire.frontend.form.orderform')

<script src="{{ asset('templates/frontend/assets/compiled/js/navigasi.js') }}"></script>
<script src="{{ asset('templates/frontend/assets/compiled/js/popup.js') }}"></script>
<script src="{{  asset('templates/frontend/assets/compiled/js/tabel.js') }}"></script>
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
@livewireScripts
</body>
</html>