@extends('layouts.public-main')
@section('title')
    Project
@endsection
@include('layouts.navbar')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-10 col-md col-sm">
                <div class="my-4">
                    <div class="page mb-3">
                        <h4>{{ $data->title }}</h4>
                    </div>
                    <div class="card">
                        <h4 class="px-3 pt-3">{{ $data->project->title }}</h4>
                        <div class="d-flex justify-content-between px-4 py-3">
                            <div>
                                <span class="d-block me-2"><i class="fas fa-map-marker-alt me-1"></i>Lokasi</span>
                                <small class="text-muted ms-3 disp">Lokasi</small>
                            </div>
                            <div>
                                <span class="d-block"><i class="fas fa-wallet me-1"></i>Total Harga</span>
                                <small class="text-muted ms-3 disp">Total Harga</small>
                            </div>
                            <div><span class="d-block">
                                    <i class="fas fa-folder-open me-1"></i>gayaDesain</span>
                                <small class="text-muted ms-3 disp">Desain Style</small>
                            </div>
                            <div><span class="d-block">
                                    <i class="fas fa-user-tie me-1"></i>Architect / Designer</span>
                                <small class="text-muted ms-3 disp">Architect / Designer</small>
                            </div>
                        </div>
                        <div class="divider"></div>
                        <div class="text-capitalized p-3">
                            Deskripsi
                        </div>
                        <div class="divider"></div>
                        <div class="images p-3">
                            <h6>Foto Ruangan / Bangunan </h6>
                            @foreach ($data->chooseProject->imageOwner as $item)

                            @endforeach
                        </div>
                        @if ($data->kontrak->proposal != null)
                            <div class="divider"></div>
                            <div class="p-3">
                                <h6>Gambar Inspirasi</h6>
                            </div>
                        @endif
                        <div class="divider"></div>
                        <div class="  p-3">
                            <h6>File Hasil </h6>

                        </div>
                        <div class="divider"></div>
                        <div class="p-3 d-inline">
                            <a href="{{ route('owner.download', $data->kontrak->id) }}"
                                class="btn btn-primary btn-sm">Lihat Kontrak</a>
                            <a href="#" class="btn btn-success btn-sm">Chat Konsultan</a>
                            @if ($data->kontrak->payment != null)
                                @if ($data->rating != null)
                                    <button class="btn btn-warning btn-sm " disabled>Rating</button>

                                @endif
                                <button class="btn btn-warning btn-sm ">Rating</button>
                                <span class="badge bg-success rounded-pill ms-auto">Sudah bayar</span>
                            @else
                                <button class="btn btn-warning btn-sm  upload" data-bs-toggle="modal"
                                    data-bs-target="#modalBayar" data-id="{{ $data->kontrak->id }}">Upload
                                    bukti</button>
                                <span class="badge bg-info rounded-pill text-end">Belum bayar</span>
                            @endif
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>


    @include('layouts.footer')

    @push('js')

        <script>

        </script>
    @endpush
@endsection
