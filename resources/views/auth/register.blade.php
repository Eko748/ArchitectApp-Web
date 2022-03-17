@extends('layouts.public-main')
@section('title', 'Daftar sebagai owner')
@section('css')
    <link rel="stylesheet" href="{{ asset('node_modules/selectric/public/selectric.css') }}">

@endsection
@include('layouts.navbar')
@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-sm col-md col-lg-4">
                <div class="mt-3 mb-4 text-center">
                    <h5><span class="font-weight-bold">Daftar</span> <span class="font-weight-normal">sebagai
                            Owner</span> </h5>
                </div>
                <form method="POST" action="{{ route('daftar.owner') }}">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label" for="name">Nama Lengkap<span class="text-danger">*</span></label>
                        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name"
                            autofocus>
                        @error('name')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="username">Username<span class="text-danger">*</span></label>
                        <input id="username" type="text" class="form-control  @error('username') is-invalid @enderror"
                            name="username">
                        @error('username')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="email">Email<span class="text-danger">*</span></label>
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                            name="email">
                        @error('email')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="password" class="d-block">Password<span class="text-danger">*</span></label>
                        <input id="password" type="password" class="form-control  @error('password') is-invalid @enderror"
                            name="password">
                        @error('password')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror

                    </div>



                    <div class="mb-3">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" name="agree" class="custom-control-input" id="agree">
                            <label class="form-label" class="custom-control-label" for="agree">I agree with the terms and
                                conditions</label>
                        </div>
                    </div>

                    <div class="d-grid gap-2">

                        <button type="submit" class="btn btn-warning btn-sm btn-block">
                            Daftar
                        </button>
                    </div>


                    <div class="mt-5 text-center">
                        Already have an account? <a href="{{ route('login') }}">Login</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @include('layouts.footer')
@endsection
