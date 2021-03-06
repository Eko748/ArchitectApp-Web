@extends('layouts.public-main')
@section('title')
    Kontraktor Page
@endsection
@include('layouts.navbar')
@section('content')
    <main class="bg-light pb-5">
        {{-- <div class="img-pro-header d-flex flex-row justify-content-center"></div> --}}
        <div class="box-pros d-flex bg-white py-5">
            <img src="{{ asset('img/avatar/' . $data->user->avatar) }}" class="pros-logo ms-5" alt="">
            <div class="pros-detail ms-3">
                <h1>{{ $data->user->name }}</h1>
                <small class="text-muted fw-light d-block">{{ $data->alamat }}</small></small>
            </div>
        </div>
        <div class="d-block bg-white">
            <nav class="nav ms-5">
                <a class="nav-link text-dark" href="#">Profile</a>
                <a class="nav-link text-dark" href="#">Project</a>
                {{-- <div class="ms-auto d-flex">
                    <a class="nav-link text-secondary" href="#"><i class="fa fa-plus fa-fw" aria-hidden="true"></i></a>
                    <a class="nav-link text-secondary" href="#"><i class="fa fa-envelope fa-fw" aria-hidden="true"></i></a>
                    <a class="nav-link text-secondary" href="#"><i class="fa fa-share fa-fw" aria-hidden="true"></i></i></a>
                </div> --}}
            </nav>
        </div>
        <div class="d-flex">
            <div class="w-25"></div>
            <div class="about-pros mt-3 ms-5 ps-4">
                <h4 class="text-muted">About Kontraktor</h4>
                <p>{{ $data->about }}</p>
            </div>
        </div>



        <div class="pros-main d-flex mt-3">
            <div class="accordion me-5 ms-5 detil-prof border-0" id="">
                <div class="accordion-item">
                    <h2 class="accordion-header" id="detilPro-head">
                        <button class="accordion-button border-0" type="button" data-bs-toggle="collapse"
                            data-bs-target="#detilPro" aria-expanded="true" aria-controls="detilPro">
                            Detail
                        </button>
                    </h2>
                    <div id="detilPro" class="accordion-collapse collapse show" aria-labelledby="detilPro-head">
                        <div class="accordion-body border-0">
                            <p><i class="fas fa-map-marker-alt text-muted"></i><span
                                    class="ms-1">{{ $data->alamat }}</span></p>
                            <p><i class="fa fa-phone-square text-muted"></i><span class="ms-1">{{ $data->telepon }}</span>
                            </p>
                            <p><i class="fab fa-instagram text-muted"> </i><span
                                    class="ms-1">{{ $data->instagram }}</span>
                            </p>
                            <p> <i class="fas fa-globe text-muted"></i><span class="ms-1">{{ $data->website }}</span></p>
                        </div>
                    </div>
                </div>

            </div>
            <div class="right-pros container">
                <div class="row">
                    <p class="text-muted"><span class="fw-bold">Featured </span>Team</p>
                    @foreach ($data->cabang as $item)
                    @php
                        $img = [];
                    @endphp
                        @foreach ($item->images as $val)
                            @php
                                $img[] = $val->image;
                            @endphp
                        @endforeach
                        <div class="col-lg-4 col-sm col-md-6 mb-2">
                            <div class="card projectCard border-0 bg-light cabang" data-slug="{{ $item->slug }}">
                                <img src="{{ asset('img/cabang/profile/' . $img[0]) }}" class="card-img-top" alt="">
                                <div class="small-img-prof mt-1 text-center">
                                    <img src="{{ asset('img/cabang/profile/' . $img[1]) }}" class="rounded" alt="">
                                    <img src="{{ asset('img/cabang/profile/' . $img[2]) }}" class="rounded" alt="">
                                    <img src="{{ asset('img/cabang/profile/' . $img[3]) }}" class=" rounded" alt="">
                                </div>
                                <div class="card-body text-center">
                                    <h5 class="card-title">{{ $item->nama_tim }}</h5>
                                    <h6 class="card-subtitle mb-2 text-muted">{{ $item->alamat_cabang }}</h6>
                                    {{-- <h6 class="card-subtitle mb-2 text-muted ">Ars</h6> --}}
                                </div>
                            </div>
                        </div>
                    @endforeach
            </div>
        </div>
        </div>

    </main>
    @include('layouts.footer')
@endsection
