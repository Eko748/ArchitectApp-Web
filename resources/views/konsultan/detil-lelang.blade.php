@extends('layouts.main')
@section('title')
    Project
@endsection
@section('css')

@endsection
@section('content')
    @include('layouts.topbar')
    @include('layouts.sidebar-konsultan')

    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Detail Lelang</h1>
            </div>

            <div class="section-body">
                <div class="card">
                    <div class="card-header">
                        <h4 id="title"></h4>
                        
                    </div>
                    <div class="card-body">
                        <img src="" id="image">
                        <div id="desc"></div>
                        <p class="d-inline mr-2">Estimasi Biaya : <span class="text-muted" id="budget"></span></p>
                        <p class="d-inline">Lokasi : <span id="loc"></span></p>
                        <p>Jasa yang dibutuhkan</p>
                        <div class="badge-jasa"></div>
                    </div>
                    <div class="card-footer text-right">
                        <a type="button" class="btn btn-secondary" href="{{ route('konsultan.job') }}">Back</a>
                        <button type="button" class="btn btn-primary" id="submit-prop" data-target="#modalAddProp"
                            data-toggle="modal" >Submit
                            Proposal</button>
                    </div>

            </div>
    </div>
    </section>
    </div>
    <div class="modal fade" id="modalAddProp" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Upload Proposal</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="" id="addProp">
                    <div class="modal-body">
                        <input type="hidden" name="lelangId">
                       
                        <div class="form-group">
                            <label for="coverletter">Cover letter</label>
                            <textarea class="form-control h-100" id="coverletter" aria-describedby="clhelp"
                                rows="5" name="coverLetter"></textarea>
                                <div class="invalid-feedback"></div>
                                <small id="clhelp" class="form-text text-muted">Cover letter minimal 50 karakter.</small>
                        </div>
                       
                        <div class="form-group mb-3">
                            <label class="" for="cv">CV</label>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="cv" name="cv">
                                <label class="custom-file-label" for="cv">Choose file</label>
                                <div class="invalid-feedback"></div>
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
    @push('js')
        <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
        <script>
            $(function() {
                showLelang()
              

                $('#submit-prop').on('click', function() {
                    formfile("upload CV anda")
                    blankInput();

                    removeInvalid();
                    $('input[name=lelangId]').empty();
                })
                
                
                $('body').on('submit','#addProp', function(e) {
                        $('input[name=lelangId]').val({{ Request::segment(3) }})
                        e.preventDefault();
                        SetupAjax();
                        $.ajax({
                            url: "{{ route('konsultan.proposal.add') }}",
                            dataType: "JSON",
                            type: "POST",
                            data: new FormData(this),
                            cache: false,
                            processData: false,
                            contentType: false,
                            success: function(response) {
                                $(this).trigger("reset");
                                $("#modalAddProp").modal("hide");
                                alertSuccess("Proposal anda berhasil diupload");
                                $('.badge-jasa').empty()
                                showLelang()
                            },
                            error: function(xhr) {
                                var res = xhr.responseJSON;
                                if ($.isEmptyObject(res) == false) {
                                    $.each(res.errors, function(key, value) {
                                        $("textarea[name=" + key + "]").addClass(
                                            "is-invalid");
                                        $("textarea[name=" + key + "]")
                                            .next()
                                            .html(value);
                                    });
                                }
                            },
                        });
                    })
            })

            function showLelang() {
                SetupAjax();
                $.ajax({
                    url: baseUrl + 'konsultan/getlelang/' + {{ Request::segment(3) }},
                    dataType: "JSON",
                    type: "GET",
                    success: function(response) {
                        console.log("{{Auth::user()->id}}")
                        console.log(response)
                        let selisih = selisihWaktu(response.created_at)
                let image ="";
                let path = "{{ asset('img/lelang/ruangan/') }}"
                $.each(response.image, function(key, value) {
            
            image += `<img src="${path}/${value.image}" height="150" loading="lazy" class="d-inline m-1 rounded" >`
            })
                        $.each(response.proposal,function (key,value) {
                            if (value.konsultan.userId == "{{Auth::user()->id}}" && response.id == value.lelangOwnerId) {
                                $('#submit-prop').prop('disabled',true)
                            }
                            
                        })
                        $('#title').html(response.title);
                        $('#image').html(response.image);
                        $('#desc').html(response.description);
                        $('#budget').html(`${rupiahFormat(response.budgetFrom)} - ${rupiahFormat(response.budgetTo)} `);
                        $('#loc').html(response.owner.alamat);
                        if (response.RAB == 1) {
                            $('.badge-jasa').append(`<span class="badge badge-warning badge-pill text-dark ml-2">Rancangan Anggaran Biaya</span>`)
                            $('.modal-body').prepend(`<div class="form-group"> <label for="tawaran">Tawaran Harga RAB</label>
                                 <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Rp</span>
                                </div>
                                <input type="text" class="form-control" name="hargaRab" id="hargaRab">
                                </div>
                                <div class="invalid-feedback"></div>
                                <small id="tawarHelp" class="form-text text-muted">Berapa tawaran anda untuk RAB yang akan anda buat.</small></div>`)
                            }
                            if (response.desain == 1) {
                            $('.badge-jasa').append(`<span class="badge badge-warning badge-pill text-dark">Desain 2D dan 3D</span>`)
                            $('#desain').prop('checked', true);
                                 $('.modal-body').prepend(`<div class="form-group"> <label for="tawaran">Tawaran Harga Desain</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Rp</span>
                                </div>
                                <input type="text" class="form-control" name="hargaDesain" id="hargaDesain">
                                </div>
                                <div class="invalid-feedback"></div>
                                <small id="tawarHelp" class="form-text text-muted">Berapa tawaran anda untuk desain yang akan anda buat.</small></div>`)
                        } 
                          maskingInput('#hargaDesain')
                         maskingInput('#hargaRab')
                       
                    },
                });
            }
        </script>
         @include('konsultan.js.profileJs')

    @endpush
@endsection
