@extends('layouts.main')
@section('title')
    Project
@endsection
@section('css')

@endsection
@section('content')
    @include('layouts.topbar')
    @include('layouts.sidebar-kontraktor')

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
                        <div id="desc"></div>
                        <p class="d-inline mr-2">Estimasi Biaya : <span class="text-muted" id="budget"></span></p>
                        <p class="d-inline">Lokasi : <span id="loc"></span></p>
                        <p>Jasa yang dibutuhkan</p>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="rab" disabled>
                            <label class="form-check-label" for="rab">Rancangan Anggaran Biaya</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="desain" disabled>
                            <label class="form-check-label" for="desain">Desain 2D atau 3D</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="kontraktor" disabled>
                            <label class="form-check-label" for="kontraktor">Kontraktor</label>
                        </div>
                    </div>
                    <div class="card-footer text-right">
                        <button type="submit" class="btn btn-secondary">Back</button>
                        <button type="submit" class="btn btn-primary" id="submit-prop" data-target="#modalAddProp"
                            data-toggle="modal">Submit
                            Proposal</button>
                    </div>
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
                            <textarea class="form-control form-control-lg" id="coverletter" aria-describedby="clhelp"
                                rows="3" name="coverLetter"></textarea>
                                <div class="invalid-feedback"></div>
                                <small id="clhelp" class="form-text text-muted">Cover letter minimal 50 karakter.</small>
                        </div>
                        <div class="input-group mb-3">
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
                    $('input[name=lelangId]').val({{ Request::segment(3) }})

                    $('#addProp').on('submit', function(e) {
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
            })

            function showLelang() {
                SetupAjax();
                $.ajax({
                    url: baseUrl + 'konsultan/getlelang/' + {{ Request::segment(3) }},
                    dataType: "JSON",
                    type: "GET",
                    success: function(response) {
                        $('#title').html(response.title);
                        $('#desc').html(response.description);
                        $('#budget').html(response.budget);
                        $('#loc').html(response.owner.alamat);
                        if (response.RAB == 1) {
                            $('#rab').prop('checked', true);
                        } else {
                            $('#rab').prop('checked', false);

                        }
                        if (response.desain == 1) {
                            $('#desain').prop('checked', true);
                        } else {
                            $('#desain').prop('checked', false);

                        }
                        if (response.kontraktor == 1) {
                            $('#kontraktor').prop('checked', true);
                        } else {
                            $('#kontraktor').prop('checked', false);

                        }
                    },
                });
            }
        </script>
         @include('konsultan.js.profileJs')

    @endpush
@endsection
