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
</head>
<body>
<div id="navigasi">
    @include('frontend.layouts.navigasi')
</div>

<main class="main-content">
    @yield('content')
</main>

@include('frontend.layouts.footer')

@include('livewire.pelanggan.form.loginpopup')
@include('livewire.pelanggan.form.orderform')

<script src="{{ asset('templates/frontend/assets/compiled/js/navigasi.js') }}"></script>
<script src="{{ asset('templates/frontend/assets/compiled/js/popup.js') }}"></script>
<script src="{{ asset('templates/frontend/assets/compiled/js/beranda.js') }}"></script>
</body>
</html>