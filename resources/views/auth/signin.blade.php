@extends('layouts.auth-main')
@section('title', 'Login')
@section('css')
@section('js')
<link rel="stylesheet" href="{{ asset('node_modules/bootstrap-social/bootstrap-social.css') }}">

@endsection
@section('content')
<section class="section">
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
                        <label for="email">Email</label>
                        <input id="email" type="email" class="form-control" name="email" tabindex="1"
                            value="{{ old('email') }}" autofocus>
                    </div>

                    <div class="form-group">
                        <div class="d-block">
                            <label for="password" class="control-label">Password</label>
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
        <div class="col-lg-8 col-12 order-lg-2 order-1 min-vh-100 background-walk-y position-relative overlay-gradient-bottom"
            data-background="{{ asset('img/rumah.jpg') }}">
            
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
@endsection
@push('js')

@endpush
