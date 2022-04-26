@extends('layouts.public-main')
@section('title')
    Landing Page
@endsection
@section('css')
    <style>
        .banner {
            background-image: url("{{ asset('img/project/' . $data->images[1]->image) }}");
            background-position: center;
            background-size: cover;
            background-repeat: no-repeat;
            height: 100%;
            width: 100%;
            object-fit: cover;
        }

    </style>
@endsection
@include('layouts.navbar')
@section('content')
    <main class="bg-light pb-5">
        <div class="bg-white mt-4">
            <div class="container-fluid">
                <div class="d-flex">
                    <img src="{{ asset('img/avatar/' . $data->konsultan->user->avatar) }}" class="pros-logo ms-5" alt="">
                    <div class="pros-detail ms-3">
                        <h3>{{ $data->konsultan->user->name }}</h3>
                        <small
                            class="text-muted fw-light d-block">{{ $data->konsultan->alamat == null ? 'Indonesia' : $data->konsultan->alamat }}</small>
                    </div>

                </div>
                <div class="d-block bg-white mt-3 pb-3">
                    <nav class="nav ms-5">
                        <a class="nav-link text-dark" href="#">Profile</a>
                        <div class="ms-auto d-flex">
                            <a class="nav-link text-secondary" href="#"><i class="fas fa-bookmark"></i></a>
                        </div>
                    </nav>
                </div>
            </div>
        </div>
        <div class="banner"></div>
        <div class="d-flex">

            <div class="detil-project px-4 py-3">
                <h4>{{ $data->title }}</h4>
                <p class="desc" style="font-size:14px;">{{ $data->description }}
                </p>
                <div class="accordion p-0" id="">
                    <div class="accordion-item border-0">
                        <h2 class="accordion-header" id="detilPro-head">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                data-bs-target="#detilPro" aria-expanded="true" aria-controls="detilPro">
                                Project Detail
                            </button>
                        </h2>
                        <div id="detilPro" class="accordion-collapse collapse show" aria-labelledby="detilPro-head">
                            <div class="accordion-body m-0">
                                <table class="table table-borderless">
                                    <tr>
                                        <td class="fw-bold">Architect / Designer</td>
                                        <td>{{ $data->konsultan->user->name }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">Gaya Desain</td>
                                        <td>{{ $data->gayaDesain }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">Harga Desain</td>
                                        <td>Rp{{ number_format($data->harga_desain, 0, ',', '.') }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">Harga RAB</td>
                                        <td>Rp{{ number_format($data->harga_rab, 0, ',', '.') }}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="accordion p-0" id="">
                    <div class="accordion-item border-0">
                        <h2 class="accordion-header" id="detilPro-head">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                data-bs-target="#ratings" aria-expanded="true" aria-controls="ratings">
                                Ratings
                            </button>
                        </h2>
                        <div id="ratings" class="accordion-collapse collapse show" aria-labelledby="ratings-head">
                            <div class="accordion-body m-0">

                            </div>
                        </div>
                    </div>
                </div>
                <hr>
                @auth
                    <div class="d-grid">
                        <button class="btn btn-warning btn-sm" data-bs-target="#ChooseModal" data-bs-toggle="modal"
                            type="button" data-id="{{ $data->id }}" id="chooseButton">Saya tertarik dengan desain
                            ini</button>
                    </div>
                @else
                    <div class="d-grid">
                        <button class="btn btn-warning btn-sm" type="button" data-bs-target="#LoginModal" data-bs-toggle="modal"
                            id="login">Saya tertarik dengan desain ini</button>
                    </div>

                @endauth
            </div>

            <div class="container mt-3">
                <div class="row ">
                    @foreach ($data->images as $item)

                        <div class="col-lg-4 col-sm col-md-6 mb-2">
                            <div class="other-image">
                                <img src="{{ asset('img/project/' . $item->image) }}" alt="" class="rounded">
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </main>
    @push('js')
        <script>
            var loginModal = new bootstrap.Modal($('#LoginModal'));
            var chooseModal = new bootstrap.Modal($('#ChooseModal'));

            $('body').on('click', '#login', function() {
                removeInvalid()
            })
            $('body').on('submit', '#formLogin', function(e) {
                e.preventDefault();
                let form = $(this);
                SetupAjax();
                $.ajax({
                    url: "{{ route('login.ajax') }}",
                    dataType: "JSON",
                    type: "POST",
                    data: form.serialize(),
                    cache: false,
                    success: function(response) {
                        loginModal.hide()
                        window.location.assign(baseUrl + response)
                    },
                    error: function(xhr) {
                        var res = xhr.responseJSON;
                        if ($.isEmptyObject(res) == false) {
                            $.each(res.errors, function(key, val) {
                                $("input[name=" + key + "]").addClass("is-invalid");
                                $("input[name=" + key + "]")
                                    .next()
                                    .html(val);
                            });
                        }
                    },
                });
            })

            function countLuas() {
                let p = $('#panjang').val();
                let l = $('#lebar').val();
                let luas = p * l;
                $('#luas').val(luas);
            }

            $(function() {
                startLoad(chooseModal)
                $('#proId').val('');
                removeInvalid()
                let Crab = $('#rab')
                let Cdesain = $('#desain')
                let Hrab = Crab.data('rab');
                let Hdesain = Cdesain.data('desain')
                let total = 0;
                Crab.on('change', function() {
                    if (this.checked) {
                        total += Hrab
                        $('#total').val(rupiahFormat(total))
                    } else {
                        total -= Hrab
                        $('#total').val(rupiahFormat(total))

                    }

                })
                Cdesain.on('change', function() {
                    if (this.checked) {
                        total += Hdesain
                        $('#total').val(rupiahFormat(total))
                    } else {
                        total -= Hdesain
                        $('#total').val(rupiahFormat(total))

                    }

                })

                $('body').on('submit', '#formChoose', function(e) {
                    e.preventDefault()
                    let id = $('#chooseButton').data('id');
                    $('#proId').val(id);
                    SetupAjax()
                    $.ajax({
                        url: "{{ route('owner.choose.project') }}",
                        dataType: "JSON",
                        type: "POST",
                        data: new FormData(this),
                        cache: false,
                        processData: false,
                        contentType: false,
                        success: function(response) {
                            $(this).trigger("reset");
                            window.location.assign("{{ route('owner.my.project') }}")
                        },
                        error: function(xhr) {
                            var res = xhr.responseJSON;
                            if ($.isEmptyObject(res) == false) {
                                $.each(res.errors, function(key, value) {
                                    $("input[name=" + key + "]").addClass(
                                        "is-invalid");
                                    $("input[name=" + key + "]")
                                        .next().next()
                                        .html(value);

                                });
                            }
                        },
                    })

                })

            })
        </script>
    @endpush
    @include('layouts.footer')

    <div class="modal fade" id="LoginModal" tabindex="-1" aria-labelledby="LoginModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-body">
                    <h5 class="text-center p-2 fs-5">Login to ArchTech</h5>
                    <form action="" method="POST" id="formLogin">
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control form-control-sm" id="email" name="email">
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control form-control-sm" id="password" name="password">
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-secondary btn-sm">Log in</button>
                            <small class="text-center py-2">Buat akun baru? <a href="{{ route('choose.account') }}">klik
                                    disini</a> </small>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
    <div class="modal fade" id="ChooseModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="ChooseModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Form Pilih Desain</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="" method="POST" enctype="multipart/form-data" id="formChoose">
                        <input type="hidden" name="projectId" id="proId">
                        <div class="row mb-3">
                            <div class="col">
                                <label for="panjang" class="form-label form-label-sm">Panjang<span
                                        class="text-danger fw-bolder">*</span></label>
                                <div class="input-group input-group-sm">

                                    <input type="number" class="form-control form-control-sm" name="panjang" id="panjang"
                                        onkeyup="countLuas()" value="0">
                                    <span class="input-group-text">m</span>
                                    <div class="invalid-feedback"></div>
                                </div>
                            </div>
                            <div class="col">
                                <label for="lebar" class="form-label form-label-sm">Lebar<span
                                        class="text-danger fw-bolder">*</span></label>
                                <div class="input-group input-group-sm">
                                    <input type="number" class="form-control form-control-sm" name="lebar" id="lebar"
                                        onkeyup="countLuas()" value="0">
                                    <span class="input-group-text">m</span>
                                    <div class="invalid-feedback"></div>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="luas" class="form-label form-label-sm">Luas</label>

                            <div class="input-group input-group-sm">
                                <input type="text" class="form-control form-control-sm " name="luas" id="luas" value="0"
                                    readonly>
                                <span class="input-group-text">m<sup>2</sup></span>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="image" class="form-label">Foto Ruangan / Bangunan</label>
                            <input class="form-control form-control-sm " id="image" name="image[]" multiple type="file">

                            <div class="invalid-feedback"></div>

                        </div>
                        <div class="mb-3">
                            <label for="desc" class="form-label">Jasa yang dibutuhkan<span
                                    class="text-danger fw-bolder">*</span></label>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="1" id="rab" name="rab"
                                    data-rab="{{ $data->harga_rab }}">
                                <label class="form-check-label" for="rab">
                                    Rencana Anggaran Biaya
                                </label>

                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="1" id="desain" name="desain"
                                    data-desain="{{ $data->harga_desain }}">
                                <label class=" form-check-label" for="desain">
                                    Desain 2D dan 3D
                                </label>

                            </div>
                            <div class="invalid-feedback"></div>

                        </div>
                        <div class="mb-3">
                            <label for="total" class="form-label form-label-sm">Total</label>

                            <div class="input-group input-group-sm">
                                <input type="text" class="form-control form-control-sm " name="total" id="total" value="0"
                                    readonly>
                            </div>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-warning btn-sm">Buat Kontrak</button>
                </div>
                </form>
            </div>
        </div>
    </div>

@endsection


<!-- Modal -->
