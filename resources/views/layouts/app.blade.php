<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <!-- <link href="{{ asset('css/app.css') }}" rel="stylesheet"> -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <style>
        .datepicker-modal,
        .timepicker-modal {
            height: fit-content !important;
        }
    </style>

<body>
    <div id="app">
        <div class="navbar-fixed ">
            <nav>
                <div class="nav-wrapper blue-grey lighten-1">
                    <a href="{{ url('/') }}" class="brand-logo">
                        <img src="/logo.png" style="width:4rem;" class="left hide-on-small-only responsive-img">
                        {{ config('app.name', 'Laravel') }}
                    </a>
                    <a href="#" data-target="mobile-demo" class="sidenav-trigger"><i class="material-icons">menu</i></a>
                    <ul class="right hide-on-med-and-down">
                        @guest
                        @if (Route::has('login'))
                        <li>
                            <a href="{{ route('login') }}">{{ __('Login') }}</a>
                        </li>
                        @endif

                        @if (Route::has('register'))
                        <li>
                            <a href="{{ route('register') }}">{{ __('Register') }}</a>
                        </li>
                        @endif
                        @else
                        <li>
                            <a href="{{ route('home') }}">{{ __('Dashboard') }}</a>
                        </li>
                        <li>
                            <a class='dropdown-trigger valign-wrapper' href='#' data-target='dropdownnav'>
                                @if(file_exists(public_path('storage/'.Auth::user()->id)))
                                <img class="circle left " src="{{asset('storage/'.Auth::user()->id)}}" style="width: 3rem; border:1px solid black;" alt="" srcset="">
                                @if(Auth::user()->email_verified_at)
                                <i class="material-icons" style="color:#3df900;position: relative;right: 16px;font-size: 20px;bottom: -17px;text-shadow: 0 0 5px #444;">verified_user</i>
                                @endif
                                @else
                                <i class="material-icons left">account_circle</i>
                                @if(Auth::user()->email_verified_at)
                                <i class="material-icons" style="color:#3df900;position: relative;right: 16px;font-size: 20px;bottom: -17px;text-shadow: 0 0 5px #444;">verified_user</i>
                                @endif
                                @endif
                                {{ Auth::user()->name }}
                            </a>
                            <ul class='dropdown-content right' id="dropdownnav">
                                <li>
                                    <a href="/account">
                                        <i class="material-icons">person</i>{{ __('Account') }}
                                    </a>
                                </li>
                                <li>
                                    <a href="/bin">
                                        <i class="material-icons">delete</i>{{ __('Bin') }}
                                    </a>
                                </li>
                                <li>
                                    <a class="" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        <i class="material-icons">logout</i>{{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </li>
                            </ul>

                        </li>
                        @endguest
                        <!-- <li><a href="sass.html">Sass</a></li>
                        <li><a href="badges.html">Components</a></li> -->
                    </ul>
                </div>
            </nav>

        </div>
        <ul class="sidenav" id="mobile-demo">
            @guest
            @if (Route::has('login'))
            <li>
                <a href="{{ route('login') }}">{{ __('Login') }}</a>
            </li>
            @endif

            @if (Route::has('register'))
            <li>
                <a href="{{ route('register') }}">{{ __('Register') }}</a>
            </li>
            @endif
            @else

            <li>
                <div class="nav-wrapper">
                    <form action="/" method="Post">
                        @csrf
                        <div class="input-field">
                            <input name='search' id="search" type="search" required placeholder="Search for Task">
                            <label class="label-icon left" for="search">
                                <i class="material-icons">search</i>
                            </label>
                            <i class="material-icons right">close</i>
                        </div>
                    </form>
                </div>

            </li>
            <li class="center-align">
                @if(file_exists(public_path('storage/'.Auth::user()->id)))
                <img class="circle" src="{{asset('storage/'.Auth::user()->id)}}" style="width: 10rem; border:1px solid black;" alt="" srcset="">
                @else
                <i class="material-icons large">account_circle</i>
                @endif
                @if(Auth::user()->email_verified_at)
                <div class="center-align green-text">
                    <i class="material-icons" style="vertical-align: sub;">verified_user</i> Verified
                </div>
                @else
                <div class="center-align">
                    <a class="blue-grey-text lighten-1" href="/email/verify">
                        <i class="material-icons" style="vertical-align: sub;">offline_pin</i> Verify this Account
                    </a>

                </div>
                @endif
            </li>
            <li>
                <a>Welcome {{ Auth::user()->name }}</a>
            </li>
            <li>
                <a href="{{ route('home') }}">{{ __('Dashboard') }}</a>
            </li>
            <li>
                <a class="dropdown-item sidenav-close" href="/#todo">
                    {{ __('Todo') }}
                </a>
            </li>
            <li>
                <a class="dropdown-item sidenav-close" href="/#inprogress">
                    {{ __('In Progress') }}
                </a>
            </li>
            <li>
                <a class="dropdown-item sidenav-close" href="/#completed">
                    {{ __('Completed') }}
                </a>
            </li>
            <li>
                <a class="dropdown-item" href="/bin">
                    {{ __('Bin') }}
                </a>
            </li>
            <li>
                <a class="dropdown-item" href="/account">
                    {{ __('Account') }}
                </a>
            </li>
            <li>
                <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                    {{ __('Logout') }}
                </a>

                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </li>
            @endguest
        </ul>

        <main class="py-4">
            @yield('content')
        </main>
    </div>
</body>

</html>