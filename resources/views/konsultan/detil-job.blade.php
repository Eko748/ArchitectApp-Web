@extends('layouts.main')
@section('title')
    Project
@endsection
@section('css')
    <link rel="stylesheet" href="{{ asset('node_modules/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }} ">
    <link rel="stylesheet" href="{{ asset('node_modules/datatables.net-select-bs4/css/select.bootstrap4.min.css') }}">

@endsection
@section('content')
    @include('layouts.topbar')
    @include('layouts.sidebar-konsultan')

    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Detail Job</h1>
            </div>

            <div class="section-body">
                <div class="card">
                    <div class="card-header"></div>
                    <div class="card-body">
                        <div class="row justify-content-between">
                            <div class="col">
                                <div class="card-text" id="pemilik">Pemilik : </div>
                                <hr>
                                <div class="card-text" id="luas">Luas : </div>
                                <hr>
                                <div class=" card-text">Deskripsi</div>
                                <div class=" card-text" id="desc"></div>
                                <hr>
                                <div class="option">

                                </div>



                            </div>
                            <div class="col">
                                <div class="image text-center" id="image"></div>
                            </div>
                        </div>
                        <div class="float-right">
                            <a href="" class="btn btn-primary btn-sm lihat">Lihat Kontrak</a>
                            
                                <button class="btn btn-primary btn-sm upload" data-target="#modalUploadHasil"
                                    data-toggle="modal">Upload Hasil</button>

                         
                        </div>
                    </div>

                </div>

            </div>

        </section>
    </div>


    @push('js')

        <script src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}"></script>
        <script src="{{ asset('node_modules/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
        <script src="{{ asset('node_modules/datatables.net-select-bs4/js/select.bootstrap4.min.js') }}"></script>
        <script>
            $(function() {


                loadJob()
                $('.fileRab').show()
                $('.fileDesain').show()

            });

            function loadJob() {
                let id = {{ Request::segment(4) }};
                $.ajaxSetup({
                    headers: {
                        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').prop("content"),
                    },
                });
                $.ajax({
                    url: "{{ route('konsultan.job.data') }}",
                    dataType: "JSON",
                    type: "POST",
                    data: {
                        id: id
                    },
                    success: function(response) {


                        moment.locale('id')

                        let waktu = moment(response.project_own[0].kontrak.created_at);
                        let badge = `<span class="badge badge-success  badge-pill mr-1">Sudah Bayar</span>`;
                        if (response.project_own[0].kontrak.payment == null) {
                            badge = `<span class="badge badge-danger badge-pill mr-1">Belum Bayar</span>`
                            $('.upload').prop('disabled',true)
                        }
                        $('.card-header').html(`<h4>${response.title}</h4>`)
                        $('#pemilik').append(response.project_own[0].owner.user.name)
                        $('#luas').append(Math.floor(response.project_own[0].kontrak.proposal.lelang.luas) +
                            " m<sup>2</sup>")
                        $('#desc').append(response.description)
                        $('.option').append(
                            `${badge} <span class="badge badge-warning mr-1 badge-pill">${rupiahFormat((response.harga_desain + response.harga_rab))}</span><span class="badge badge-warning badge-pill">${waktu.format('LL')}</span>`
                        )

                        $.each(response.project_own[0].kontrak.proposal.lelang.image, function(key, value) {
                            $('#image').append(
                                `<a href="{{ asset('img/lelang/tkp/${value.image}') }}"><img src="{{ asset('img/lelang/tkp/${value.image}') }}" alt="" width="100" height="100" class="rounded mr-1 displayCard" style="object-fit:cover;"></a>`
                            )

                        })

                        
                        if (response.project_own[0].kontrak.proposal.lelang.RAB == 0) {
                            $('.fileRab').hide()
                        }
                        if (response.project_own[0].kontrak.proposal.lelang.desain == 0) {
                            $('.fileDesain').hide()
                        }
                        $('.upload').attr('data-id', response.project_own[0].id)
                        
                        if (response.project_own[0].hasil != null) {
                            $('.float-right').html(` <a href="" class="btn btn-primary btn-sm lihat">Lihat Kontrak</a> <button class="btn btn-warning btn-sm">Jadikan sebagai project</button> <button class="btn btn-success btn-sm">Menunggu review owner</button>`)
                            
                        }
                        $('.lihat').prop('href',
                            `{{ asset('kontrak/${response.project_own[0].kontrak.kontrakKerja}') }}`)
                    },
                });
            }
        </script>


        <script>
            $(function() {

                $('body').on('click', '.upload', function() {
                    formfile("Pilih file")
                    let id = $(this).data('id')
                    $('input[type=hidden]').val(id)

                });

                $('body').on('submit', '#uploadHasil', function(e) {
                    e.preventDefault()
                    SetupAjax()
                    $.ajax({
                        url: "{{ route('konsultan.upload.job') }}",
                        dataType: "JSON",
                        type: "POST",
                        data: new FormData(this),
                        cache: false,
                        processData: false,
                        contentType: false,
                        success: function(response) {
                            console.log(response)
                            $(this).trigger("reset");
                            $("#modalUploadHasil").modal("hide");
                            alertSuccess("Desain berhasil diupload");
                            $('.badge').empty()
                            loadJob()

                        },
                        error: function(xhr) {
                            var res = xhr.responseJSON;
                            if ($.isEmptyObject(res) == false) {
                                $.each(res.errors, function(key, value) {
                                    $("input#" + key).addClass(
                                        "is-invalid");
                                    $(".invalid-feedback").html(value);
                                });
                            }
                        },
                    });
                    $('input[type=hidden]').empty()

                })
            })
        </script>


        @include('konsultan.js.profileJs')
    @endpush
    <div class="modal fade" id="modalUploadHasil" tabindex="-1" role="dialog" aria-labelledby="modelTitleId"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Upload Proposal</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <form action="" method="post" id="uploadHasil" enctype="multipart/form-data">
                        <input type="hidden" name="projectOwnerId" value="">
                        <div class="form-group fileDesain">
                            <label for="file">Upload Desain</label>
                            <div class="input-group mb-3">
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="softfile" name="softfile[]" multiple
                                        aria-describedby="inputGroupFileAddon01">
                                    <label class="custom-file-label" for="file">Choose file</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group fileRab">
                            <label for="file">Upload RAB</label>
                            <div class="input-group mb-3">
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="rab" name="rab" multiple
                                        aria-describedby="inputGroupFileAddon01">
                                    <label class="custom-file-label" for="file">Choose file</label>
                                </div>
                            </div>

                        </div>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>

                </form>

            </div>
        </div>
    </div>
@endsection
