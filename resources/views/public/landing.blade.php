@extends('layouts.public-main')
@section('title')
Landing Page
@endsection
@include('layouts.navbar')
@section('content')

@include('layouts.caroussell')
<main>

    <div class="text-center slogan container mt-0 p-0">

        <h2>Konsultan Desain Rumah dan Interior</h2>
        <p>Merupakan orang yang bertanggungjawab dalam merencanakan serta mengarahkan proyek pembangunan dan atau
            renovasi sebuah rumah.
            Keahlian mereka dalam menentukan warna, bahan, dan furnitur yang sesuai, akan memperindah suasana rumah.
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
            @php
                $img = [];
            @endphp
            @foreach ($item->images as $val)
            @php
            $img[] = $val->image;
            @endphp
            @endforeach
            <div class="col-lg-3 col-sm col-md-4 mb-3">
                <div class="card displayCard border-0 project" data-slug="{{ $item->slug }}">
                    <img src="{{ asset('img/project/' . $img[0]) }}" class="card-img-top" alt=""
                        style="max-height: 300px; object-fit: cover">
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
        {{-- <div class="title text-center mb-4">
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
                        <img src="{{ asset('img/avatar/' . $item->user->avatar) }}" class="rounded-circle" width="70"
                            height="70">
                    </div>
                    <div class="card-body text-center mt-3">
                        <h5 class="card-title">{{ $item->user->name }}</h5>
                        <h6 class="card-subtitle mb-2 text-muted ">
                            {{ $item->alamat == null ? 'Indonesia' : $item->alamat }}</h6>
                    </div>
                </div>
            </div>
            @endforeach

        </div> --}}
        <div id="history" class="container-fluid mb-5">
            <div class="row">
                <div class="col text-center mb-2">
                    <h3><span class="fw-bold">Featured</span> <span class="fw-lighter text-muted">Professional</span></h3>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <div class="card shadow" style="border-radius: 30px;">
                    <div class="card-body">
                        <div class="row">
                        <div class="col-md my-3">
                            <h5 class="text-center mb-3 fw-bold">Konsultan</h5>
                            <div class="row mx-2">
                                
                                @foreach ($konsultan as $item)
                                <div class="col-lg-6 col-sm col-md-4 mb-3">
                                    <div class="card displayCard border-0 konsultan" data-slug="{{ $item->slug }}">
                                        <img src="{{ asset('img/avatar/' . $item->user->avatar) }}" class="card-img-top"
                                            style="max-height: 350px; object-fit: cover">
                                        <div class="card-body text-center mt-3">
                                            <h5 class="card-title">{{ $item->user->name }}</h5>
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
                </div>
                        {{-- <div class="vertikal"></div> --}}
                        <div class="col">
                            <div class="card shadow" style="border-radius: 30px;">
                            <div class="card-body">
                                <div class="row">
                        <div class="col-md my-3">
                            <h5 class="text-center mb-3 fw-bold">Kontraktor</h5>
                            <div class="row mx-2">
                                @foreach ($kontraktor as $item)
                                <div class="col-lg-6 col-sm col-md-4 mb-3">
                                    <div class="card displayCard border-0 kontraktor" data-slug="{{ $item->slug }}">
                                        <img src="{{ asset('img/avatar/' . $item->user->avatar) }}" class="card-img-top"
                                            style="max-height: 350; object-fit: cover">
                                        <div class="card-body text-center mt-3">
                                            <h5 class="card-title">{{ $item->user->name }}</h5>
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
                </div>
            </div>
        </div>
</main>
@push('css')
<style>
:root {
    
    --background-secondary: #141432;
    --theme-primary: #3E55E9;
}

.vertikal{
border-left: 1px black solid;
height: 170px;
width: 0px;
}

.card {
    background-color: var(--background-secondary);
}

    ul.timeline {
    content: '';
    background: var(--theme-primary);
    display: inline-block;
    position: absolute;
    left: 29px;
    width: 2px;
    height: 100%;
}

ul.timeline li:before {
    content: '';
    background: var(--theme-primary);
    display: inline-block;
    position: absolute;
    border-radius: 50%;
    left: 22px;
    width: 15px;
    height: 15px;
}
</style>
@endpush


@include('layouts.footer')
@endsection
