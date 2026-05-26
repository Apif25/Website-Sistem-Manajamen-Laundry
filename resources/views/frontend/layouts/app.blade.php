<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelana Laundry</title>
    <link rel="stylesheet" href="{{ asset('templates/frontend/assets/compiled/css/navigasi.css') }}">
    <link rel="stylesheet" href="{{ asset('templates/frontend/assets/compiled/css/beranda.css') }}">
    <link rel="stylesheet" href="{{ asset('templates/frontend/assets/compiled/css/formpopup.css') }}">
</head>
<body>
<div id="navigasi">
    @include('frontend.layouts.navigasi')
</div>

<main class="main-content">
    @yield('content')
</main>

@include('livewire.pelanggan.form.loginpopup')

<script src="{{ asset('templates/frontend/assets/compiled/js/navigasi.js') }}"></script>
<script src="{{ asset('templates/frontend/assets/compiled/js/popup.js') }}"></script>
</body>
</html>