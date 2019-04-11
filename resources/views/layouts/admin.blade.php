<!DOCTYPE html>
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
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <style>
        body {
            font-family: "Lato", sans-serif;
        }

        @media only screen and (max-width: 900px) {
            .sidenav {
                height: 100%;
                width: 0px;
                position: fixed;
                z-index: 1;
                top: 64px;
                left: 0;
                background-color: #344050;
                overflow-x: hidden;
                transition: 0.3s;
                padding-top: 0px;
            }
        }
        @media only screen and (min-width: 900px) {
            .sidenav {
                height: 100%;
                width: 220px;
                position: fixed;
                z-index: 1;
                top: 64px;
                left: 0;
                background-color: #344050;
                overflow-x: hidden;
                transition: 0.3s;
                padding-top: 0px;
            }
        }

        .sidenav a {
            padding: 8px 8px 8px 32px;
            text-decoration: none;
            font-size: 23px;
            color: #f1f1f1;
            display: block;
            transition: 0.3s;
        }

        .sidenav a:hover {
            color: #818181;
        }

        .sidenav .closebtn {
            position: absolute;
            top: 0;
            left: 0px;
            font-size: 30px;
        }

        @media screen and (max-height: 450px) {
            .sidenav {padding-top: 15px;}
            .sidenav a {font-size: 18px;}
        }
    </style>
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light navbar-laravel">
            <span style="font-size:30px" onclick="openNav()">&#9776;</span>
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

            </div>
        </nav>

        <main class="py-4">
            <div>
                <meta name="viewport" content="width=device-width, initial-scale=1">
                <div id="mySidenav" class="sidenav">
                    <a href="/home">|Dashboard</a>
                    <a href="/admin/empresa">|Empresa</a>
                    <a href="/admin/produtos">|Produtos</a>
                    <a href="/admin">|Pedidos</a>
                    <a href="/admin">|Clientes</a>


                        <!-- Left Side Of Navbar -->
                        <ul class="navbar-nav mr-auto">

                        </ul>

                        <!-- Right Side Of Navbar -->
                        <ul class="navbar-nav ml-auto">
                            <!-- Authentication Links -->
                            @guest
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                                @if (Route::has('register'))
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                    </li>
                                @endif
                            @else
                                <li class="nav-item dropdown">
                                    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                        {{ Auth::user()->name }} <span class="caret"></span>
                                    </a>

                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                        <a class="dropdown-item" href="{{ route('logout') }}"
                                           onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                            {{ __('Logout') }}
                                        </a>

                                        <a class="dropdown-item" href="/{{ Auth::user()->profile }}">Dashboard</a>

                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            @csrf
                                        </form>
                                    </div>
                                </li>
                            @endguest
                        </ul>

                </div>
            </div>
            @yield('content')
        </main>
    </div>
</body>

<script>
    function openNav() {
        var width = document.getElementById('mySidenav').getBoundingClientRect().width;
        console.log(width);
        if(width==0){
            document.getElementById("mySidenav").style.width = "220px";
        }else{
            document.getElementById("mySidenav").style.width = "0px";
        }
    }
</script>
</html>
