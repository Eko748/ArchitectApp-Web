@extends('layouts.main')
@section('title')
Project Owner Archived
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
            <h1>Project Owner Archived</h1>
        </div>
        <div class="section-body">
            <div class="card">
                <div class="card-header">
                    <h4>Riwayat Project</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive-sm">
                        <table class="table table-hover" id="table-project">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Nama Owner</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Project</th>
                                    <th scope="col">Luas Ruangan</th>
                                    <th scope="col">Kontrak</th>
                                    <th scope="col">Tanggal</th>
                                    {{-- <th scope="col">Gambar</th> --}}
                                    {{-- <th scope="col">Aksi</th> --}}
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                </tr>
                            </tbody>

                        </table>
                    </div>
                </div>
            </div>

        </div>
    </section>
</div>


<div class="modal fade" id="modalHasil" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Project</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="" method="post" id="formTambahHasil">
                    @csrf
                    <div class="form-group">
                        <label for="softfile">File Desain</label>
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" multiple name="softfile[]">
                            <label class="custom-file-label" for="softfile">Choose file</label>
                        </div>
                        <small>Desain Terbaik 2D / 3D Anda</small>
                    </div>

                    <div class="form-group">
                        <label for="hasil_rab">File Desain</label>
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" name="hasil_rab">
                            <label class="custom-file-label" for="hasil_rab">Choose file</label>
                        </div>
                        <small>RAB Terbaik Anda</small>
                    </div>
                    
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
{{-- <div class="modal fade" id="modalAddProp" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Upload File Hasil</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="" id="addProp">
                <div class="modal-body">
                    <input type="hidden" name="projectOwnerId">
                
                    <div class="form-group mb-3">
                        <label class="" for="softfile">File Desain</label>
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="softfile" name="softfile">
                            <label class="custom-file-label" for="softfile">Choose file</label>
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>
                
                    <div class="form-group mb-3">
                        <label class="" for="rab">File RAB</label>
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="rab" name="rab">
                            <label class="custom-file-label" for="rab">Choose file</label>
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
</div> --}}
{{-- 
<div class="modal fade" id="modalViewUser" tabindex="-1" role="dialog" aria-labelledby="modelTitleId"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detail Project</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                 <div class="form-group">
                        <label for="name">Nama Owner</label>
                        <input type="text" name="name" id="name" class="form-control" disabled>
                        
                    </div>
                    <div class="form-group">
                        <label for="konsName">RAB</label>
                        <input type="text" name="konsName" id="konsName" class="form-control" disabled>
                    </div>
                    <div class="form-group">
                        <label for="date">Tanggal</label>
                        <input type="text" name="date" id="date" class="form-control" disabled>
                    </div>
                    <div class="form-group">
                        <label for="desain">Desain</label>
                        <input type="text" name="desain" id="desain" class="form-control" disabled>
                    </div>
            </div>
            
            <div class="modal-footer">
                <form action="" method="POST" id="formVerify">
                    @csrf
                    @method("PUT")
                     <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>

                     <button type="submit" class="btn btn-primary" >Verifikasi</button>
                 </form>
            </div>
           

        </div>
    </div>
</div> --}}

@push('js')

{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script> --}}
<script>
    // $(function() {
    //     showLelang()
      

    //     $('#submit-prop').on('click', function() {
    //         formfile("upload CV anda")
    //         blankInput();

    //         removeInvalid();
    //         $('input[name=projectOwnerId]').empty();
    //     })
        
        
    //     $('body').on('submit','#addProp', function(e) {
    //             $('input[name=projectOwnerId]').val({{ Request::segment(3) }})
    //             e.preventDefault();
    //             SetupAjax();
    //             $.ajax({
    //                 url: "{{ route('konsultan.upload.job') }}",
    //                 dataType: "JSON",
    //                 type: "POST",
    //                 data: new FormData(this),
    //                 cache: false,
    //                 processData: false,
    //                 contentType: false,
    //                 success: function(response) {
    //                     $(this).trigger("reset");
    //                     $("#modalAddProp").modal("hide");
    //                     alertSuccess("File Project anda berhasil diupload");
    //                     $('.badge-jasa').empty()
    //                     showLelang()
    //                 },
    //                 error: function(xhr) {
    //                     var res = xhr.responseJSON;
    //                     if ($.isEmptyObject(res) == false) {
    //                         $.each(res.errors, function(key, value) {
    //                             $("textarea[name=" + key + "]").addClass(
    //                                 "is-invalid");
    //                             $("textarea[name=" + key + "]")
    //                                 .next()
    //                                 .html(value);
    //                         });
    //                     }
    //                 },
    //             });
    //         })
    // })

    
</script>

<script src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}"></script>
        <script src="{{ asset('node_modules/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
        <script src="{{ asset('node_modules/datatables.net-select-bs4/js/select.bootstrap4.min.js') }}"></script>
        <script>
            $(function() {
                let table = $('#table-project').DataTable({
                    processing: true,
                    serverSide: true,
                    autoWidth: false,
                    ajax: "{{ route('konsultan.archived.job') }}",
                    columns: [

                        {
                            data: 'DT_RowIndex',
                            name: 'DT_RowIndex'
                        },
                        {
                            data: 'owner.user.name',
                            name: 'name'
                        },
                        {
                            data: 'status',
                            name: 'status'
                        },
                        {
                            data: 'project',
                            name: 'project'
                        },
                        {
                            data: 'luas',
                            name: 'luas'
                        },
                        {
                            data: 'kontrak.kontrakKerja',
                            name: 'kontrak'
                        },
                        {
                            data: 'tanggal',
                            name: 'tanggal'
                        },
                        // {
                        //     data: 'gambar',
                        //     name: 'gambar'
                        // },
                        {
                            data: 'Aksi',
                            name: 'Aksi',
                            orderable: false,
                            searchable: false
                        },
                    ],
                });

                $('body').on('click','#viewUser',function () {
                    let id = $(this).data('id');
                    let url = baseUrl + "project/" +id
                     $.ajax({
                url: url,
                dataType: "JSON",
                type: "GET",
                success: function(response) {
                    console.log(response)
                    $("#name").val(response.owner.user.name);
                    $("#ownerName").val(response.lelang.owner.user.name);
                    $("#date").val(moment(response.created_at).format('d MMMM Y'));
                    $("#desain").val(rupiahFormat(response.tawaranDesain));
                    

                },
            });  
                })
                $('body').on('submit','#formVerify',function (e) {
                   e.preventDefault()
                   
                })

            });
        </script>
@include('konsultan.js.hasil-js')
@endpush
@endsection

