<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="X-Frame-Options" content="DENY">

    <title>{{ $title ?? 'Login' }}</title>

    <link rel="stylesheet" href="{{ asset('templates/frontend/assets/compiled/css/login.css') }}">
    <link rel="stylesheet" href="{{ asset('templates/frontend/assets/compiled/css/register.css') }}">
    <link rel="icon" type="image/png" href="{{ asset('img/icon/Favicon.jpeg') }}">
        
    {{-- RECAPTCHA --}}
    <script src="https://www.google.com/recaptcha/api.js?onload=onRecaptchaLoad&render=explicit" async defer></script>


    {{-- LIVEWIRE --}}
    @livewireStyles

    {{-- STACK TAMBAHAN --}}
    @stack('head')
</head>

<body>
    <script src="{{ asset('templates/backend/assets/static/js/initTheme.js') }}"></script>

    <div class="auth-container" style="display: flex; justify-content: center; align-items: center; min-height: 100vh; background-color: #f4f7f6;">
        
        {{-- CONTENT LIVEWIRE & BLADE --}}
        @if(isset($slot))
            {{ $slot }}
        @else
            @yield('Login')
        @endif

    </div>

    {{-- LIVEWIRE --}}
    @livewireScripts

    {{-- STACK SCRIPT --}}
    @stack('scripts')
</body>

</html>