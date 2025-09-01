<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>
        Threads Management|Blog
    </title>

    <!-- Bootstrap (https://github.com/twbs/bootstrap) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link  rel="stylesheet"  href="{{ asset( '/css/style.css') }}?v={{time()}}" rel="stylesheet ">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
    <link  rel="stylesheet"  href="{{ asset( '/css/select2.min.css') }}?v={{time()}}" rel="stylesheet ">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Feather icons (https://github.com/feathericons/feather) -->
    <script src="https://cdn.jsdelivr.net/npm/feather-icons/dist/feather.min.js"></script>
    <script src="{{ asset('js/sweetalert.min.js') }}"></script>
    

    <!-- Vue (https://github.com/vuejs/vue) -->
    @if (config('app.debug'))
        <script src="https://cdn.jsdelivr.net/npm/vue@2.6.14/dist/vue.js"></script>
    @else
        <script src="https://cdn.jsdelivr.net/npm/vue@2.6.14"></script>
    @endif

    <!-- Axios (https://github.com/axios/axios) -->
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>

    

    <!-- Sortable (https://github.com/SortableJS/Sortable) -->
    <script src="//cdn.jsdelivr.net/npm/sortablejs@1.10.1/Sortable.min.js"></script>
    <!-- Vue.Draggable (https://github.com/SortableJS/Vue.Draggable) -->
    <script src="//cdnjs.cloudflare.com/ajax/libs/Vue.Draggable/2.23.2/vuedraggable.umd.min.js"></script>
    <!-- CSRF Token -->


    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.8/jquery.min.js"></script>
<script src="https://code.jquery.com/ui/1.10.0/jquery-ui.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.min.js"></script>
<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>

<script src="{{ URL::asset('/js/select2.min.js') }}" type="text/javascript"></script>

@yield('css_section')
    
    
</head>
<body>
    
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container" style="padding: 0em;">
                <div class="container-fluid" id="dshbrd_blog_cont">
                        
                            <a class="navbar-brand" id="nav_link_forum" href="{{ url('/') }}">
                                <img src="{{asset('/images/User_logo.svg')}}" width="200" height="80" />
                            </a>
                        
                        
                            <a class="navbar-brand" id="nav_link_forum" href="{{ url('/') }}">
                                Home
                            </a>
                        
                        
                            <a class="navbar-brand" id="nav_link_forum" href="{{ url('/forum') }}">
                            The Forum
                            </a>
                        
                        
                            <a class="navbar-brand" id="nav_link_forum" href="{{ url('/') }}">
                            Classifies
                            </a>
                        
                        
                            <a class="navbar-brand" id="nav_link_forum" href="{{ url('/') }}">
                            Advertise
                            </a> 
                           
                        
                            <a class="navbar-brand" id="nav_link_forum" href="{{ url('/') }}">
                            Contact
                            </a>
                            @if(Auth::check() && Auth::user()->role_id == \App\Models\User::admin)

                                <div class="dropdown">
                                    <button class="dropbtn">Manage</button>
                                    <div class="dropdown-content">
                                        <a id="nav_link_forum" href="{{ url('/manage/blog') }}">
                                            Manage News
                                        </a>
                                        <a id="nav_link_forum" href="{{ url('/manage/users') }}">
                                            Manage Users
                                        </a>
                                    </div>
                                </div>

                                
                            @endif
                        
                </div>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav me-auto" id="mobiledevice">
                        
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">
                        <!-- Authentication Links -->

                        



                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                            @endif

                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                        
                            <li class="nav-item dropdown">
                                

                                    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    <!-- {{ Auth::user()->name }} -->
                                    {{ Auth::user()->name }}<span id="first_n_l">{{ substr(Auth::user()->name, 0, 1) }}</span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                
                                    
                                
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>
        <!-- @yield('dashboard_header_master') -->
        @include('vendor.forum.dashboardmaster')
        <main class="py-0">
            @yield('content')
        </main>
    </div>
    @yield('js_section')
        
</body>
</html>
