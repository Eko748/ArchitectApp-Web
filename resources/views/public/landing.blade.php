@extends('layouts.public-main')
@section('title')
    Landing Page
@endsection
@include('layouts.navbar')
@section('content')

    @include('layouts.caroussell')
    <main>

        <div class="text-center slogan container mt-0 p-0">

            <h2>Konsultan Lorem ipsum dolor sit amet consectetur adipisicing elit.</h2>
            <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Cum illum possimus consequatur nulla odio atque.
            </p>
        </div>
        <div class="container-fluid ">
            <div class="title text-center my-5">
                <h4><span class="fw-bold">Featured</span> <span class="fw-normal text-secondary">Projects</span></h4>
                <p><a href="{{ route('public.project') }}" class="text-decoration-none text-muted fw-bold"
                        style="font-size: 14px">View all
                        projects</a></p>
            </div>

            <div class="row mb-3 mx-5 {{ $project->count() == 0 ? 'd-none' : '' }}">
                @foreach ($project as $item)
                    @foreach ($item->images as $val)
                        @php
                            $img[] = $val->image;
                        @endphp
                    @endforeach
                    <div class="col-lg-3 col-sm col-md-4 mb-3">
                        <div class="card displayCard border-0 project" data-slug="{{ $item->slug }}">
                            <img src="{{ asset('img/project/' . $img[0]) }}" class="card-img-top" alt=""
                                style="max-height: 200px; object-fit: cover">
                            <div class="small-img mt-1 mb-2 text-center">
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
            <div class="title text-center mb-4">
                <h3><span class="fw-bold">Featured</span> <span class="fw-lighter text-muted">Professional</span></h3>
                <p><a href="{{ route('public.konsultan') }}" class="text-decoration-none text-muted fw-bold"
                        style="font-size: 14px">View all
                        professional</a></p>
            </div>
            <div class="row mx-5">
                @foreach ($konsultan as $item)

                    <div class="col-lg-3 col-sm col-md-4 mb-3">
                        <div class="card displayCard border-0 konsultan" data-slug="{{ $item->slug }}">
                            <img src="{{ asset('img/avatar/' . $item->user->avatar) }}" class="card-img-top"
                                style="max-height: 200; object-fit: cover">
                            <div class="position-absolute logo-kons">
                                <img src="{{ asset('img/avatar/' . $item->user->avatar) }}" class="rounded-circle"
                                    width="70" height="70">
                            </div>
                            <div class="card-body text-center mt-3">
                                <h5 class="card-title">{{ $item->user->name }}</h5>
                                <h6 class="card-subtitle mb-2 text-muted ">
                                    {{ $item->alamat == null ? 'Indonesia' : $item->alamat }}</h6>
                            </div>
                        </div>
                    </div>
                @endforeach

            </div>
    </main>
    @push('js')

    @endpush


    @include('layouts.footer')
@endsection
