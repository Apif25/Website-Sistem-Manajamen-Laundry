<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="X-Frame-Options" content="DENY">

    <title>{{ $title ?? 'Login' }}</title>

    {{-- CSS MAZER --}}
    <link rel="stylesheet" href="{{ asset('templates/backend/assets/compiled/css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('templates/backend/assets/compiled/css/app-dark.css') }}">
    <link rel="stylesheet" href="{{ asset('templates/backend/assets/compiled/css/auth.css') }}">

    {{-- RECAPTCHA --}}
    <script src="https://www.google.com/recaptcha/api.js?onload=onRecaptchaLoad&render=explicit" async defer></script>

    {{-- LIVEWIRE --}}
    @livewireStyles

    {{-- STACK TAMBAHAN --}}
    @stack('head')
</head>

<body>
    <script src="{{ asset('templates/backend/assets/static/js/initTheme.js') }}"></script>

    {{-- CONTENT LIVEWIRE --}}
    {{ $slot }}

    {{-- LIVEWIRE --}}
    @livewireScripts

    {{-- STACK SCRIPT --}}
    @stack('scripts')
</body>

</html>