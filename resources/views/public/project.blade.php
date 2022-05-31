@extends('layouts.public-main')
@section('title')
    Project Saya
@endsection
@include('layouts.navbar')

@section('content')
    <div class="container-fluid">

        <div class="row justify-content-center">
            <div class="col-lg-10 col-sm col-md p-4">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('public.landing') }}">Home</a></li>
                        <li class="breadcrumb-item active">Inspirasi</li>
                    </ol>
                </nav>
                <h1><span class="counter">{{ $data->count() }}</span><span class="text"> Inspirasi Desain</span></h1>
                <div class="button-dropdown my-3 d-sm-none d-md-none d-lg-block">
                    <div class="btn-group">
                        <button class="btn btn-warning btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            Sort By
                        </button>
                        <ul class="dropdown-menu">
                            <li><a href="#" class="dropdown-item">Title</a></li>
                            <li><a href="#" class="dropdown-item">Professional</a></li>
                        </ul>
                    </div>
                    <div class="btn-group">
                        <button class="btn btn-warning btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            <span class="">Location</span>
                        </button>
                        <ul class="dropdown-menu">
                            <li><a href="#" class="dropdown-item">Bandung</a></li>
                            <li><a href="#" class="dropdown-item">Indramayu</a></li>
                        </ul>
                    </div>
                    <div class="btn-group">
                        <button class="btn btn-warning btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            <span class="">Gaya Desain</span>
                        </button>
                        <ul class="dropdown-menu">
                            <li><a href="#" class="dropdown-item">Minimalist</a></li>
                            <li><a href="#" class="dropdown-item">Professional</a></li>
                        </ul>
                    </div>
                    <div class="d-inline">Reset</div>
                </div>

                <hr class="my-3">

                <div class="main">
                    <div class="row">
                        @foreach ($data as $item)
                        @php
                        $img = [];
                        @endphp
                            @foreach ($item->images as $val)
                                @php
                                    $img[] = $val->image;
                                @endphp
                            @endforeach
                            <div class="col-lg-3 col-sm col-md-4 mb-3">
                                <div class="card projectCard border-0 project" data-slug="{{ $item->slug }}">
                                    <img src=" {{ asset('img/project/' . $img[0]) }}" class="card-img-top" alt=""
                                        style="max-height: 200px; object-fit: cover">
                                    <div class="small-img-project mt-1 mb-2 text-center">
                                        <img src="{{ asset('img/project/' . $img[1]) }}" class="rounded" alt="">
                                        <img src="{{ asset('img/project/' . $img[2]) }}" class="rounded" alt="">
                                        <img src="{{ asset('img/project/' . $img[3]) }}" class=" rounded" alt="">
                                    </div>
                                    <div class="card-body text-center">
                                        <h5 class="card-title">{{ $item->title }}</h5>
                                        <h6 class="card-subtitle mb-2 text-muted ">{{ $item->konsultan->user->name }}</h6>
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
