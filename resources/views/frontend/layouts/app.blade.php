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

    <link rel="icon" type="image/png" href="{{ asset('img/icon/Favicon.jpeg') }}">

@livewireStyles
</head>

<body x-data="{ openLogin: {{ session()->has('open_login_modal') ? 'true' : 'false' }} }"
      @login-success.window="openLogin = false">

<div id="navigasi">
    @include('frontend.layouts.navigasi')
</div>

<main class="main-content">
    {{ $slot ?? '' }}
    @yield('content')
</main>

@include('frontend.layouts.footer')
@include('livewire.frontend.form.orderform')

<script src="{{ asset('templates/frontend/assets/compiled/js/navigasi.js') }}"></script>
<script src="{{ asset('templates/frontend/assets/compiled/js/popup.js') }}"></script>
<script src="{{  asset('templates/frontend/assets/compiled/js/tabel.js') }}"></script>
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
@livewireScripts
</body>
</html>