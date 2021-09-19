<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <link rel="icon" type="image/png" href="../../../img/pokeball_menu/logo.png"/>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>PokExpert</title>

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <!-- Scripts -->
        <script src="{{ asset('js/app.js') }}" defer></script>

        <!-- Fonts -->
        <link rel="dns-prefetch" href="//fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

        <!-- ICON -->
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">

        <!-- Styles -->
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        
        <!-- TypeAhead -->
        <script src="https://www.kryogenix.org/code/browser/sorttable/sorttable.js"></script>
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.1/bootstrap3-typeahead.min.js"></script>
    </head>
    <body>
        <div id="app">
            <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm" style="font-size: 16px">
                <div class="container">
                    <a class="navbar-brand" href="{{ url('/') }}"> PokExpert <img src="../../../img/pokeball_menu/Poke_Ball.png" alt="pokeball"></a>
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <!-- Left Side Of Navbar -->
                        <ul class="navbar-nav mr-auto">
                            <li class="nav-item">
                                <a class="nav-link" href="/pokedex">Pokedex<img src="../../../img/pokeball_menu/Super_Ball.png" alt="pokeball"></a>
                            </li>
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="/list">List<img src="../../../img/pokeball_menu/Hyper_Ball.png" alt="pokeball"></a>
                                </li>
                            @endif
                            @else
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        List<img src="../../../img/pokeball_menu/Hyper_Ball.png" alt="pokeball">
                                    </a>
                                    <div class="dropdown-menu" aria-labelledby="navbarDopdown">
                                    
                                        <a class="dropdown-item" href="/my_list">My list <img src="../../../img/pokeball_menu/Honor_Ball.png" alt="pokeball"></a>
                                        <a class="dropdown-item" href="/list">All the list <img src="../../../img/pokeball_menu/Hyper_Ball.png" alt="pokeball"></a>
                                        <div class="dropdown-divider"> </div>
                                        <a class="dropdown-item" href="/create-list">Create a list <img src="../../../img/pokeball_menu/Reve_Ball.png" alt="pokeball"></a>
                                    </div>
                                </li>
                        @endguest

                        @auth
                            @if (Auth::user()->rang =='admin')
                                <li class="nav-item">
                                    <a class="nav-link" href="/create">Create a Pokemon<img src="../../../img/pokeball_menu/Master_Ball.png" alt="pokeball"></a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="/admin">ADMIN<img src="../../../img/pokeball_menu/Memoire_Ball.png" alt="pokeball"></a>
                                </li>
                            @endif
                        @endauth
                        </ul>

                        <!-- Right Side Of Navbar -->
                        <ul class="navbar-nav ml-auto">
                            <!-- Authentication Links -->
                            @guest
                                <li class="nav-item">
                                    <a style="font-weight: bold" class="nav-link" href="{{ route('login') }}">{{ __('Login') }}
                                    </a> 
                                </li>
                            @endguest

                            @auth
                                <li class="nav-item dropdown">
                                    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                        <strong>{{strtoupper(Auth::user()->name)}}</strong>
                                        @if (Auth::user()->Sprite)
                                            <img src="../../../img/Sprite_Trainer/{{ Auth::user()->Sprite }}" style="width: 100px">
                                        @endif
                                    </a>

                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                        <a style="color: green" class="dropdown-item" href="/profile">Profile
                                            <img src="../../../img/pokeball_menu/Safari_Ball.png" alt="pokeball">
                                        </a>
                                            
                                        <a style="color: blue" class="nav-link" href="/statistics">Statistics
                                            <img src="../../../img/pokeball_menu/Ultra_Ball.png" alt="pokeball">
                                        </a>
                                    
                                        <a style="color: palevioletred" class="dropdown-item" href="{{ route('logout') }}"
                                        onclick="event.preventDefault();
                                                        document.getElementById('logout-form').submit();">
                                            {{ __('Logout') }}
                                            <img src="../../../img/pokeball_menu/Love_Ball.png" alt="pokeball">
                                        </a>

                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                            @csrf
                                        </form>
                                    </div>
                                </li>
                            @endauth
                        </ul>
                    </div>
                </div>
            </nav>
            <main class="py-4">
                @yield('content')
            </main>
        </div>
    </body>
</html>
