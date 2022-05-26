<head>
    <meta charset="utf-8" data-color-mode="light">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    {{-- <link rel="stylesheet" href="{{ asset('css/tema.css') }}"> --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>


<header>
    <div class="px-3 py-2 text-white border-bottom">
        <div class="container">
            <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
                <a href="{{ route('public.landing') }}" class="d-flex align-items-center my-2 my-lg-0 me-lg-5 text-dark text-decoration-none">
                    <img src="{{ asset('img/logo_proyek.png') }}" alt="logo" width="100"
                    class=" mb-0 mt-0">
                </a>
                

                @guest
                    <div class="ms-auto">
                        <a href="{{ route('login') }}" style="font-size: 18px;"  class="btn btn-light btnChangeTheme btn btn-outline-dark btn-sm border-0 ml-3 shadow-none">Login</a>
                        <a href="{{ route('choose.account') }}" style="font-size: 18px;" class="btn btn-warning btnChangeTheme btn btn-outline-dark btn-sm border-0 ml-3 shadow-none">Sign Up</a>
                        <button onclick="myFunction()" style="font-size: 30px;" class="btnChangeTheme btn btn-outline-dark btn-sm border-0 ml-3 shadow-none">
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
                            <li><a class="dropdown-item " href="{{ route('owner.my.project') }}">My Project</a></li>
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
    <div class="px-1 border-bottom bg-white">
        <div class="container d-flex flex-wrap justify-content-center " style="font-size: 18px;">
            <a class="nav-link text-dark" href="{{ route('public.landing') }}">Home</a>
            <a class="nav-link text-dark" href="{{ route('public.project') }}">Project</a>
            <div class="dropdown tema">
                <span>Jasa</span>
                <div class="dropdown-content">
                <a class="nav-link text-dark dropdown-item" href="{{ route('public.konsultan') }}">Konsultan</a>
                <a class="nav-link text-dark dropdown-item" href="{{ route('public.konsultan') }}">Kontraktor</a>
                </div>
            </div>
            @auth
            <a class="nav-link text-dark" href="{{ route('owner.lelang') }}">Lelang</a>
            <a class="nav-link text-dark" href="{{ route('owner.my.lelang') }}">Lelang Saya</a>
            <div class="dropdown tema">
                <span>Project Saya</span>
                <div class="dropdown-content">
                <a class="nav-link text-dark dropdown-item" href="{{ route('owner.my.project') }}">Desain</a>
                <a class="nav-link text-dark dropdown-item" href="{{ route('owner.my.project') }}">Kontruksi</a>
                </div>
            </div>
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
    <style>
        .dropdown {
          position: relative;
          display: inline-block;
          padding: 8px 16px;
        }
        
        .dropdown-content {
          display: none;
          position: absolute;
          background-color: #f9f9f9;
          min-width: 160px;
          box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
          padding: 20px 16px;
          z-index: 1;
        }
        
        .dropdown:hover .dropdown-content {
          display: block;
        }

        :root {
    --background: #F3F5F8;
    --background-secondary: #ffffff;
    --text-primary: #28292e;
    --text-secondary: #55565b;
    --hover-text-secondary: rgba(233, 233, 233, 0.5);
    --nav-link: #3E55E9;
    /* --tema: rgb(255, 213, 0); */
    --tema: #3E55E9;
    --theme-primary: #3E55E9;
    --theme-secondary: #7790FC;
    --hover-theme-secondary: rgba(119, 144, 252, .5);
    --navbar: rgba(255,255,255,0.5);
}

        a.nav-link {
            color: var(--text-primary) !important;
            transition: 0.3s;
        }

        a.nav-link::after {
            transition: .3s;
        }

        a.nav-link:hover {
            color: var(--nav-link) !important;
        }

        .tema {
            color: var(--text-primary) !important;
            transition: 0.3s;
        }

        .tema::after {
            transition: .3s;
        }

        .tema:hover {
            color: var(--tema) !important;
        }

        .navbar-toggler:focus, .goTop:focus {
            outline: none;
        }
        
@media (min-width: 992px) {
    .navbarLinks {
        padding-left: 140px;
    }

    a.nav-link::after {
        content: "";
        display: block;
        border-bottom: 3px solid var(--nav-link);
        margin-top: 16px;
        margin-bottom: -18px;
        transition: opacity .3s ease;
        opacity: 0;
    }

    a.nav-link:hover::after {
        opacity: 1;
    }
}

@media (min-width: 360px) {
    .navbarLinks {
        padding-left: 140px;
    }

    a.nav-link::after {
        content: "";
        display: block;
        border-bottom: 3px solid var(--nav-link);
        margin-top: 16px;
        margin-bottom: -18px;
        transition: opacity .3s ease;
        opacity: 0;
    }

    a.nav-link:hover::after {
        opacity: 1;
    }
}


        </style>
