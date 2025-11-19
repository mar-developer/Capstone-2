<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>
        @yield('title')
    </title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="{{ asset('js/script.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/styles.css') }}" rel="stylesheet">
    <link rel="shortcut icon" href="{{ asset('paradox_logo.ico') }}">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css?family=Kaushan+Script" rel="stylesheet">


</head>
<body>
    <!-- Loading Overlay -->
    <div id="loadingOverlay" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.7); z-index: 9999; justify-content: center; align-items: center;">
        <div style="text-align: center; color: white;">
            <div class="spinner-border" role="status" style="width: 4rem; height: 4rem;">
                <span class="sr-only">Loading...</span>
            </div>
            <p class="mt-3" style="font-size: 1.2rem;">Loading...</p>
        </div>
    </div>

    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light navbar-laravel">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/home') }}">
                    <img class="img-fluid" src="{{ asset('images/icons/paradox_logo.png') }}" height="auto" width="50px">
                    <img class="img-fluid" src="{{ asset('images/icons/paradox.png') }}" height="auto" width="150px">
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                        <li class="nav-item">
                            <a class="nav-link" id="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                        </li>
                        @if (Route::has('register'))
                        <li class="nav-item">
                            <a class="nav-link" id="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                        </li>
                        @endif
                        @else


                        @if (Auth::user()->access == 'admin' || Auth::user()->access == 'super_admin')
                        <li class="nav-item">
                            <a class="nav-link" id="nav-link" href="{{ route('user') }}">Users</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="nav-link" href="{{ route('items') }}">Games</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="nav-link" href="{{ route('requests') }}">Requests</a>
                        </li>
                        @endif


                        @if (Auth::user()->access == 'user')
                        <li class="nav-item">
                            <a class="nav-link" id="nav-link" href="{{ route('catalog') }}">Catalog</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="nav-link" href="/cart/{{ Auth::user()->id }}">Cart <span class="badge badge-primary">
                                {{  $count = \App\item_user::where('user_id', Auth::user()->id)->count() }}
                            </span></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="nav-link" href="/transactions/{{ Auth::user()->id }}">Transactions</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="nav-link" href="{{ route('logs') }}">History</a>
                        </li>
                        @endif


                        <li class="nav-item dropdown" id="nav-link">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" id="nav-link" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                <img class="img-fluid" src=" {{ url('images/profile/'.Auth::user()->img_path) }}" style="width:40px; height:40px; border-radius:50%"> {{ Auth::user()->first_name }} <span class="caret"></span>
                            </a>



                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="/UserAccount/{{ Auth::user()->id }}">
                                    My Account
                                </a>


                                <a class="dropdown-item" href="{{ route('logout') }}"
                                onclick="event.preventDefault();
                                document.getElementById('logout-form').submit();">
                                {{ __('Logout') }}
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </div>
                    </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>

    <main class="py-4">
        @yield('content')
    </main>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const loadingOverlay = document.getElementById('loadingOverlay');

    // Show loading on all link clicks (except # links)
    document.addEventListener('click', function(e) {
        const target = e.target.closest('a');
        if (target && target.href && !target.href.includes('#') && !target.hasAttribute('data-toggle')) {
            loadingOverlay.style.display = 'flex';
        }
    });

    // Show loading on form submissions
    document.addEventListener('submit', function(e) {
        if (e.target.classList.contains('page-link-form') || !e.target.hasAttribute('data-no-loading')) {
            loadingOverlay.style.display = 'flex';
        }
    });

    // Show loading on button clicks with specific class
    document.querySelectorAll('.add-to-cart').forEach(function(button) {
        button.addEventListener('click', function(e) {
            if (!this.disabled) {
                setTimeout(function() {
                    loadingOverlay.style.display = 'flex';
                }, 100);
            }
        });
    });

    // Hide loading when page is fully loaded
    window.addEventListener('pageshow', function() {
        loadingOverlay.style.display = 'none';
    });

    // Hide loading if navigation is cancelled
    window.addEventListener('beforeunload', function() {
        setTimeout(function() {
            loadingOverlay.style.display = 'none';
        }, 3000);
    });

    // Initialize tooltips
    if (typeof $ !== 'undefined' && $.fn.tooltip) {
        $('[data-toggle="tooltip"]').tooltip();
    }
});
</script>
</body>
</html>
