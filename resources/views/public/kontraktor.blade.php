@extends('layouts.public-main')
@section('title')
    Project
@endsection
@include('layouts.navbar')

@section('content')
    <div class="container-fluid">

        <div class="row justify-content-center">
            <div class="col-lg-10 col-sm col-md p-4">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb me-auto">
                        <li class="breadcrumb-item"><a href="{{ route('public.landing') }}">Home</a></li>
                        <li class="breadcrumb-item active">Kontraktor</li>
                    </ol>
                </nav>
                <h1><span class="counter">{{ $data->count() }}</span><span class="text"> Kontraktor Project</span></h1>
                <div class="button-dropdown my-3 d-sm-none d-md-none d-lg-block">
                    <div class="dropdown d-inline mr-2">
                        <button class="btn btn-warning btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            <span class="pe-5 ps-3">Sort By</span>
                        </button>
                        <ul class="dropdown-menu">
                            <li>1</li>
                            <li>2</li>
                            <li>3</li>
                        </ul>
                    </div>
                    <div class="dropdown d-inline mr-2 ">
                        <button class="btn btn-warning btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            <span class="pe-5 ps-3">Location</span>
                        </button>
                        <ul class="dropdown-menu">
                            <li>1</li>
                            <li>2</li>
                            <li>3</li>
                        </ul>
                    </div>
                    <div class="dropdown d-inline mr-2">
                        <button class="btn btn-warning btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            <span class="pe-5 ps-3">Category</span>
                        </button>
                        <ul class="dropdown-menu">
                            <li>1</li>
                            <li>2</li>
                            <li>3</li>
                        </ul>
                    </div>
                    <div class="d-inline">Reset</div>
                </div>

                <div class="main">
                    <div class="row">
                        @foreach ($data as $item)
                            <div class="col-lg-3 col-sm col-md-4 mb-3">
                                <div class="card projectCard border-0 kontraktor" data-slug="{{ $item->kontraktor->slug }}">
                                    <img src=" {{ asset('img/avatar/' . $item->avatar) }} " class="card-img-top"
                                        style="max-height: 350; object-fit: cover">
                                    <div class="position-absolute logo-kons">
                                        {{-- <img src="{{ asset('img/avatar/' . $item->avatar) }}" class="rounded-circle"
                                            width="50" height="50"> --}}
                                    </div>
                                    <div class="card-body text-center mt-3">
                                        <h5 class="card-title">{{ $item->name }}</h5>
                                        <h6 class="card-subtitle mb-2 text-muted ">
                                            {{ $item->alamat == null ? 'Indonesia' : $item->alamat }}</h6>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('layouts.footer')

@endsection
