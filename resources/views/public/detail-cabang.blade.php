@extends('layouts.public-main')
@section('title')
    Detail Cabang
@endsection
@section('css')
    <style>
        .banner {
            background-image: url("{{ asset('img/cabang/profile/' . $data->images[0]->image) }}");
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
                    <img src="{{ asset('img/avatar/' . $data->kontraktor->user->avatar) }}" class="pros-logo ms-5" alt="">
                    <div class="pros-detail ms-3">
                        <h3>{{ $data->kontraktor->user->name }}</h3>
                        <small
                            class="text-muted fw-light d-block">{{ $data->kontraktor->alamat == null ? 'Indonesia' : $data->kontraktor->alamat }}</small>
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
 
            <div class="detil-project px-5 py-5">
                <h4>{{ $data->nama_tim }}</h4>
                <p class="desc" style="font-size:14px;">{{ $data->description }}
                </p>
                <div class="accordion p-0" id="">
                    <div class="accordion-item border-0">
                        <h2 class="accordion-header" id="detilPro-head">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                data-bs-target="#detilPro" aria-expanded="true" aria-controls="detilPro">
                                Teamwork Detail
                            </button>
                        </h2>
                        <div id="detilPro" class="accordion-collapse collapse show" aria-labelledby="detilPro-head">
                            <div class="accordion-body m-0">
                                <table class="table table-borderless">
                                    <tr>
                                        <td class="fw-bold">Kontraktor</td>
                                        <td class="fw-bold">:</td>
                                        <td>{{ $data->kontraktor->user->name }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">Jumlah Tim</td>
                                        <td class="fw-bold">:</td>
                                        <td>{{ $data->jumlah_tim }} orang</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">Alamat Cabang</td>
                                        <td class="fw-bold">:</td>
                                        <td>{{ $data->alamat_cabang }} </td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">Harga Perjanjian Awal</td>
                                        <td class="fw-bold">:</td>
                                        <td>Rp{{ number_format($data->harga_kontrak, 0, ',', '.') }}</td>
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
                                Note Kesepakatan
                            </button>
                        </h2>
                        <div id="ratings" class="accordion-collapse collapse show" aria-labelledby="ratings-head">
                            <div class="accordion-body m-0">
                                <table class="table table-borderless">
                                    <tr>
                                        <td class="fw-bold">Kesepakatan harga akhir dilakukan secara langsung tanpa perantara</td>
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
                                data-bs-target="#warning" aria-expanded="true" aria-controls="warning">
                                Pemberitahuan
                            </button>
                        </h2>
                        <div id="warning" class="accordion-collapse collapse show" aria-labelledby="warning-head">
                            <div class="accordion-body m-0">
                                <table class="table table-borderless">
                                    <tr>
                                        <td class="fw-bold">Sebelum Tahap Konstruksi Pastikan Anda telah memiliki:</td>                                       
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">
                                            <li>Blueprint / Desain Project</li>
                                            <li>Rancangan Anggaran Biaya / RAB</li>
                                            <li>Konsultan Project Anda (Opsional)</li>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">Baca <a href="">Persyaratan dan Ketentuan </a></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <hr>
                @auth
                    <div class="d-grid">
                        <button class="btn btn-warning btn-sm" data-bs-target="#ChooseModal" data-bs-toggle="modal"
                            type="button" data-id="{{ $data->id }}" id="chooseButton">Saya tertarik dengan teamwork
                            ini</button>
                    </div>
                @else
                    <div class="d-grid">
                        <button class="btn btn-warning btn-sm" type="button" data-bs-target="#LoginModal" data-bs-toggle="modal"
                            id="login">Saya tertarik dengan teamwork ini</button>
                    </div>

                @endauth
            </div>

            <div class="container mt-4">
                <div class="row ">
                    @foreach ($data->images as $item)
                        <div class="col-lg-4 col-sm col-md-6 mb-2">
                            <div class="other-image">
                                <img src="{{ asset('img/cabang/profile/' . $item->image) }}" alt="" class="rounded">
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

            $(function() {
                startLoad(chooseModal)
                $('#proId').val('');
                removeInvalid()
                let Ckontrak = $('#status')
                let Hkontrak = Ckontrak.data('status');
                let total = 0;
                Ckontrak.on('change', function() {
                    if (this.checked) {
                        total += Hkontrak
                        $('#total').val(rupiahFormat(total))
                    } else {
                        total -= Hkontrak
                        $('#total').val(rupiahFormat(total))
                    }
                })


                $('body').on('submit', '#formChoose', function(e) {
                    e.preventDefault()
                    let id = $('#chooseButton').data('id');
                    $('#proId').val(id);
                    SetupAjax()
                    $.ajax({
                        url: "{{ route('owner.choose.konstruksi') }}",
                        dataType: "JSON",
                        type: "POST",
                        data: new FormData(this),
                        cache: false,
                        processData: false,
                        contentType: false,
                        success: function(response) {
                            $(this).trigger("reset");
                            window.location.assign("{{ route('owner.my.konstruksi') }}")
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
                    <h5 class="text-center p-2 fs-5">Login to Arsitek.co</h5>
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
                    <h5 class="modal-title" id="exampleModalLabel">Formulir Kesepakatan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="" id="formChoose" method="POST" enctype="multipart/form-data">
                        {{-- {{ url('/cobaya') }} --}}
                        {{ csrf_field() }}

                        <input type="hidden" name="konstruksiId" value="{{ $data->id }}">
                        
                        <label for="desc" class="form-label">Alamat Lengkap<span class="text-danger fw-bolder">*</span></label>
                        <div class="row mb-3">
                            <div class="col">
                                <label for="kota" class="form-label form-label-sm">Kota/Kabupaten<span
                                        class="text-danger fw-bolder">*</span></label>
                                <div class="input-group input-group-sm">
                                    <input type="text" class="form-control form-control-sm" name="kota" id="kota">
                                    <div class="invalid-feedback"></div>
                                </div>
                            </div>
                            <div class="col">
                                <label for="kecamatan" class="form-label form-label-sm">Kecamatan<span
                                        class="text-danger fw-bolder">*</span></label>
                                <div class="input-group input-group-sm">
                                    <input type="text" class="form-control form-control-sm" name="kecamatan" id="kecamatan">                                    
                                    <div class="invalid-feedback"></div>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col">
                                <label for="desa" class="form-label form-label-sm">Desa/Kelurahan<span
                                        class="text-danger fw-bolder">*</span></label>
                                <div class="input-group input-group-sm">
                                    <input type="text" class="form-control form-control-sm" name="desa" id="desa">                                    
                                    <div class="invalid-feedback"></div>
                                </div>
                            </div>
                            <div class="col">
                                <label for="jalan" class="form-label form-label-sm">Jalan<span
                                        class="text-danger fw-bolder">*</span></label>
                                <div class="input-group input-group-sm">
                                    <input type="text" class="form-control form-control-sm" name="jalan" id="jalan">                                    
                                    <div class="invalid-feedback"></div>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                                <label for="mulaiKonstruksi" class="form-label form-label-sm">Mulai Konstruksi<span
                                        class="text-danger fw-bolder">*</span></label>
                                <div class="input-group input-group-sm">
                                    <input type="date" class="form-control form-control-sm" name="mulaiKonstruksi" id="mulaiKonstruksi">
                                    <div class="invalid-feedback"></div>
                                </div>
                        </div>
                        
                            
                        <div class="mb-3">
                            <label for="desain" class="form-label">File Blueprint / Desain Project Anda<span
                                class="text-danger fw-bolder">*</span></label>
                            <input class="form-control form-control-sm " id="desain" name="desain" multiple type="file">
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="mb-3">
                            <label for="rab" class="form-label">RAB Project Anda<span
                                class="text-danger fw-bolder">*</span></label>
                            <input class="form-control form-control-sm " id="rab" name="rab" multiple type="file">
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="1" id="status" name="status"
                                    data-status="{{ $data->harga_kontrak }}">
                                <label class="form-check-label" for="status">
                                    Menyetujui Persyaratan dan Ketentuan
                                    <span class="text-danger fw-bolder">*</span></label>
                                </label>
                            </div>
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="mb-3">
                            <label for="total" class="form-label form-label-sm">Harga Perjanjian Awal</label>
                            <div class="input-group input-group-sm">
                                <input type="text" class="form-control form-control-sm " name="total" id="total" value="0" readonly>
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
