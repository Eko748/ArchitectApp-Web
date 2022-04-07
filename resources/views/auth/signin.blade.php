<script>
    const hero = document.querySelector(".hero-section");
hero.style.height = window.innerHeight + "px";
 
window.addEventListener("resize", function () {
  hero.style.height = this.innerHeight + "px";
});
</script>
<link rel="stylesheet" href="{{ asset('css/login.css') }}">

@extends('layouts.auth-main')
@section('title', 'Login')
@section('css')
@section('js')
<link rel="stylesheet" href="{{ asset('node_modules/bootstrap-social/bootstrap-social.css') }}">

@endsection
@section('content')
<section class="section" style="font-size: 15px;">
    <div class="d-flex flex-wrap align-items-stretch">
        <div class="col-lg-4 col-md-6 col-12 order-lg-1 min-vh-100 order-2 bg-white">
            <div class="p-4 m-3">
                <div class="div">
                    <a href="/"><i class="fa-solid fa-arrow-left"></i>Back to home.</a>
                </div>
                
                <h4 class="text-dark font-weight-normal mt-2">Welcome to <img src="{{ asset('img/logo_proyek.png') }}" alt="logo" width="115"
                    class=" mb-5 mt-2">
                </h4>
                @if ($errors->any())
                <div class="alert alert-danger">
                    @foreach ($errors->all() as $item)
                    <li class="list-unstyled">{{ $item }}</li>
                    @endforeach
                </div>
                @endif
                <form method="POST" action="{{ url('login') }}">
                    @csrf
                    <div class="form-group">
                        <label for="email" style="font-size: 15px;">Email</label>
                        <input style="font-size: 15px;" id="email" type="email" class="form-control" name="email" tabindex="1"
                            value="{{ old('email') }}" autofocus>
                    </div>

                    <div class="form-group">
                        <div class="d-block" style="font-size: 15px;">
                            <label style="font-size: 15px;" for="password" class="control-label">Password</label>
                        </div>
                        <input id="password" type="password" class="form-control" name="password" tabindex="2">

                    </div>

                    <div class="form-group">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" name="remember" class="custom-control-input" tabindex="3"
                                id="remember-me">
                            <label class="custom-control-label" for="remember-me">Remember Me</label>
                        </div>
                    </div>

                    <div class="form-group text-right">
                        <a href="auth-forgot-password.html" class="float-left mt-3">
                            Lupa Password?
                        </a>
                        <button type="submit" class="btn btn-primary btn-lg btn-icon icon-right" tabindex="4">
                            Login
                        </button>
                    </div>

                    <div class="mt-5 text-center">
                        Belum Punya Akun? <a href="{{ route('choose.account') }}">Register</a>
                    </div>
                </form>

                <div class="text-center mt-5 text-small">
                    Copyright &copy; Polindra. Made with 💙 by Arsitek.co
                    <div class="mt-2">
                        <a href="#">Privacy Policy</a>
                        <div class="bullet"></div>
                        <a href="#">Terms of Service</a>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-lg-8 col-14 order-lg-2 order-1 min-vh-100 background-walk-y position-relative overlay-gradient-bottom"
            data-background="{{ asset('mp4/rumah.mp4') }}">
            
            
            <section class="hero-section position-relative">
                <video class="col-lg-25 col-13 order-lg-2 order-1 min-vh-100 background-walk-y position-relative overlay-gradient-bottom" src="./mp4/rumah.mp4" autoplay loop muted playsinline></video>
              <div class="overlay position-absolute d-flex align-items-center justify-content-center font-weight-bold text-white h2 mb-0">
              </div>
              <svg class="position-absolute w-100">
                <use xlink:href="#one"></use>
              </svg>
            </section>
            
            <div class="absolute-bottom-left index-2">
                <div class="text-light p-5 pb-2">
                    <div class="mb-5 pb-3">
                        <?php
                        date_default_timezone_set('Asia/Jakarta');
                        $tanggal = date("H:i:s");
                        // dd($tanggal);
                        $status = '';
                        if ($tanggal >= 00 && $tanggal <= 10) {
                            $status = "Selamat Pagi";
                        } else if ($tanggal >= 11 && $tanggal <= 15) {
                            $status = "Selamat Siang";
                        } else if ($tanggal >= 16 && $tanggal <= 19) {
                            $status = "Selamat Sore";
                        } else if ($tanggal >= 20 && $tanggal <= 24) {
                            $status = "Selamat Malam";
                        }
                        ?>
                        <h1 class="mb-2 display-4 font-weight-bold">
                            {{ $status }}
                        </h1>
                        <h5 class="font-weight-normal text-muted-transparent">Indramayu, Indonesia</h5>
                    </div>
                </div>
            </div>
        </div>
        
    </div>
    
</section>
<svg style="display:none;">
    <symbol id="one" viewBox="0 0 1440 320" preserveAspectRatio="none">
        <path fill="blue" d="M0,96L1440,320L1440,320L0,320Z"></path>
      </symbol>
      <symbol id="two" viewBox="0 0 1440 320" preserveAspectRatio="none">
        <path fill="white" d="M0,32L48,37.3C96,43,192,53,288,90.7C384,128,480,192,576,197.3C672,203,768,149,864,138.7C960,128,1056,160,1152,160C1248,160,1344,128,1392,112L1440,96L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path>
      </symbol>
        
      <!-- more symbols here -->
</svg>

@endsection
@push('js')

@endpush
