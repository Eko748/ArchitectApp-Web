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
                        Kontraktor</span> </h5>
            </div>
            <form method="POST" action="{{ route('daftar.kontraktor') }}" enctype="multipart/form-data">
                @csrf

                <div class="mb-3">
                    <label class="form-label" for="name">Nama Lengkap<span class="text-danger">*</span></label>
                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name"
                        autofocus value="{{old('name')}}">
                    @error('name')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label class="form-label" for="username">Username<span class="text-danger">*</span></label>
                    <input id="username" type="text" class="form-control  @error('username') is-invalid @enderror"
                        name="username" value="{{old('username')}}">
                    @error('username')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label class="form-label" for="email">Email<span class="text-danger">*</span></label>
                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                        name="email" value="{{old('email')}}">
                    @error('email')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label class="form-label" for="password" class="d-block">Password<span
                            class="text-danger">*</span></label>
                    <input id="password" type="password" class="form-control  @error('password') is-invalid @enderror"
                        name="password">
                    @error('password')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror

                </div>
                <div class="mb-3">
                    <label for="file" class="form-label">File</label>
                    <input class="form-control form-control-sm @error('file') is-invalid @enderror" id="file"
                        name="file" type="file">
                    @error('file')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" name="agree" class="custom-control-input" id="agree">
                        <label class="form-label" class="custom-control-label" for="agree">Saya setuju dengan syarat dan
                            ketentuan</label>
                    </div>
                </div>

                <div class="d-grid gap-2">

                    <button type="submit" class="btn btn-warning btn-sm btn-block">
                        Daftar
                    </button>
                </div>


                <div class="mt-5 text-center">
                    Sudah punya akun? <a href="{{ route('login') }}">Login</a>
                </div>
            </form>
        </div>
    </div>
</div>

@include('layouts.footer')
<div aria-live="polite" aria-atomic="true" class="bg-dark position-relative bd-example-toasts">
    <div class="toast-container position-absolute bottom-0 end-0 p-3" id="toastPlacement">
        <div class="toast">
            <div class="toast-header">
                <img src="" class="rounded me-2" alt="">
                <strong class="me-auto">Bootstrap</strong>
                <small>11 mins ago</small>
            </div>
            <div class="toast-body">
                Hello, world! This is a toast message.
            </div>
        </div>
    </div>
</div>
@endsection
