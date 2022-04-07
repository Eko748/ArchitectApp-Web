<head>
    <meta charset="utf-8" data-color-mode="light">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="{{ asset('css/tema.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>


<header>

    <div class="px-3 py-2 text-white border-bottom">
        
        <div class="container">
            <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
                <a href="{{ route('public.landing') }}" class="d-flex align-items-center my-2 my-lg-0 me-lg-5 text-dark text-decoration-none">
                    <img src="{{ asset('img/logo_proyek.png') }}" alt="logo" width="80"
                    class=" mb-0 mt-0">
                </a>
                

                @guest
                    <div class="ms-auto">
                        <a href="{{ route('login') }}" class="btn btn-light text-dark me-2 btn-sm">Login</a>
                        <a href="{{ route('choose.account') }}" class="btn btn-warning btn-sm">Sign Up</a>
                        <button onclick="myFunction()" class="btnChangeTheme btn btn-outline-dark btn-sm border-0 ml-3 shadow-none">
                            <i class="far fa-moon"></i>
                        </button>
                    </div>

                @endguest
                @auth
                    <div class="flex-shrink-0 dropdown ms-auto">
                        <a href="#" class="d-block link-dark text-decoration-none dropdown-toggle" id="dropdownUser2"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            <img src="" alt="image" width="32" height="32" class="rounded-circle pp">
                        </a>
                        <ul class="dropdown-menu text-small shadow" aria-labelledby="dropdownUser2">
                            <li><a class="dropdown-item" href="{{ route('owner.my.project') }}">My Project</a></li>
                            <li><a class="dropdown-item" href="{{ route('owner.my.lelang') }}">My Lelang</a></li>
                            <li><a class="dropdown-item" href="#">Profile</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item logout" href="#">Sign out</a></li>
                        </ul>
                    </div>
                @endauth
            </div>
        </div>
    </div>
    <div class="px-3 border-bottom bg-white">
        <div class="container d-flex flex-wrap justify-content-center ">
            <a class="nav-link text-dark" href="{{ route('public.landing') }}">Home</a>
            <a class="nav-link text-dark" href="{{ route('public.project') }}">Project</a>
            <a class="nav-link text-dark" href="{{ route('public.konsultan') }}">Professional</a>
            @auth
                <a class="nav-link text-dark" href="{{ route('owner.lelang') }}">Lelang</a>
                <a class="nav-link text-dark" href="{{ route('owner.my.lelang') }}">My Lelang</a>
                <a class="nav-link text-dark" href="{{ route('owner.my.project') }}">My Project</a>
            @endauth
        </div>
        <br>
    </div>
    <form method="POST" action="{{ route('logout') }}" id="formLogout" class="d-none">
    @csrf
    </form>
</header>
<script src="{{ asset('js/tema.js') }}"></script>
    <script src="{{ asset('vendor/jquery/jquery.js') }}"></script>
    <script src="{{ asset('js/jquery/jquery.1.3.js') }}"></script>
    <script src="{{ asset('vendor/bootstrap/js/bootstrap.min.js') }}"></script>
