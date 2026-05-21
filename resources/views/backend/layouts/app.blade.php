<!DOCTYPE html>
<html lang="en" x-data="themeHandler()" x-init="init()">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Happy Laundry - Admin Dashboard</title>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="shortcut icon" href="{{ asset('templates/backend/assets/compiled/svg/favicon.svg') }}" type="image/x-icon">
    <link rel="shortcut icon" href="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACEAAAAiCAYAAADRcLDBAAAEs2lUWHRYTUw6Y29tLmFkb2JlLnhtcAAAAAAAPD94cGFja2V0IGJlZ2luPSLvu78iIGlkPSJXNU0wTXBDZWhpSHpyZVN6TlRjemtjOWQiPz4K..." type="image/png">
    <link rel="stylesheet" href="{{ asset('templates/backend/assets/compiled/css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('templates/backend/assets/compiled/css/app-dark.css') }}">
    <link rel="stylesheet" href="{{ asset('templates/backend/assets/compiled/css/iconly.css') }}">
    <style>
        .bg-pink {
            background-color: #ff69b4 !important;
            color: white !important;
        }
    </style>

    @livewireStyles
</head>

<body>


    <div id="app">

        <div id="sidebar">
            @include('backend.layouts.sidebar')
        </div>

        <div id="main">
            <header class="mb-3">
                <a href="#" class="burger-btn d-block d-xl-none">
                    <i class="bi bi-justify fs-3"></i>
                </a>
            </header>

            <div class="page-heading d-flex justify-content-between align-items-center">
                <h3>@yield('title', 'Dashboard')</h3>

            </div>

            <div class="page-content">
                {{ $slot }}
            </div>

            <footer>
                <div class="footer clearfix mb-0 text-muted">
                    <div class="float-start">
                        <p>2026 &copy; Happy Laundry</p>
                    </div>
                </div>
            </footer>
        </div>
    </div>

    <script src="{{ asset('templates/backend/assets/extensions/perfect-scrollbar/perfect-scrollbar.min.js') }}"></script>
    <script src="{{ asset('templates/backend/assets/compiled/js/app.js') }}"></script>
    <script src="{{ asset('templates/backend/assets/extensions/apexcharts/apexcharts.min.js') }}"></script>
    <script src="{{ asset('templates/backend/assets/static/js/pages/dashboard.js') }}"></script>

    <!-- Alpine Theme Handler -->
    <script>
        function themeHandler() {
            return {
                darkMode: false,

                init() {
                    this.darkMode = localStorage.getItem('theme') === 'dark';

                    this.applyTheme();

                    document.addEventListener('livewire:navigated', () => {
                        this.applyTheme();
                    });
                },

                toggleTheme() {
                    localStorage.setItem(
                        'theme',
                        this.darkMode ? 'dark' : 'light'
                    );

                    this.applyTheme();
                },

                applyTheme() {
                    document.documentElement.setAttribute(
                        'data-bs-theme',
                        this.darkMode ? 'dark' : 'light'
                    );
                }
            }
        }

        function confirmLogout() {
            Swal.fire({
                title: 'Logout?',
                text: 'Yakin ingin keluar?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, logout',
                cancelButtonText: 'Batal',
                reverseButtons: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6c757d'
            }).then((result) => {

                if (result.isConfirmed) {
                    document.getElementById('logout-form').submit();
                }

            });
        }

        function confirmAction({
            title = 'Yakin?',
            text = '',
            icon = 'warning',
            confirmText = 'Ya',
            cancelText = 'Batal',
            confirmColor = '#d33',
            cancelColor = '#6c757d',
            emit = null,
            emitData = {},
            callback = null
        }) {

            Swal.fire({
                title: title,
                text: text,
                icon: icon,
                showCancelButton: true,
                confirmButtonText: confirmText,
                cancelButtonText: cancelText,
                confirmButtonColor: confirmColor,
                cancelButtonColor: cancelColor,
                reverseButtons: true
            }).then((result) => {

                if (!result.isConfirmed) return;
                if (emit) {
                    Livewire.dispatch(emit, emitData);
                }
                if (callback) {
                    callback();
                }
            });
        }
    </script>
    @livewireScripts
</body>

</html>