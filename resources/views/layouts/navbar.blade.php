<header class="sticky-top">
    <div class="px-3 py-2 bg-white text-white border-bottom">
        <div class="container">
            <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
                <a href="{{ route('public.landing') }}" class="d-flex align-items-center my-2 my-lg-0 me-lg-5 text-dark text-decoration-none">
                    Logo
                </a>
              
                @guest
                    <div class="ms-auto">
                        <a href="{{ route('login') }}" class="btn btn-light text-dark me-2 btn-sm">Login</a>
                        <a href="{{ route('choose.account') }}" class="btn btn-warning btn-sm">Sign Up</a>
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
    </div>
    <form method="POST" action="{{ route('logout') }}" id="formLogout" class="d-none">
    @csrf
    </form>
</header>
