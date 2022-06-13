@extends('layouts.main')
@section('title')
Pengajuan Owner
@endsection
@section('css')
<link rel="stylesheet" href="{{ asset('node_modules/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }} ">
<link rel="stylesheet" href="{{ asset('node_modules/datatables.net-select-bs4/css/select.bootstrap4.min.css') }}">
@endsection
@section('content')
@include('layouts.topbar')
@include('layouts.sidebar-kontraktor')

<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Verifikasi Project</h1>
        </div>
        <div class="section-body">
            <div class="card">
                <div class="card-header">
                    <h4>Data Owner</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive-sm">
                        <table class="table table-hover" id="table-project">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Nama Owner</th>
                                    
                                    <th scope="col">Alamat Owner</th>
                                    <th scope="col">Status</th>
                                    {{-- <th scope="col">Nama Cabang</th> --}}
                                    {{-- <th scope="col">Data Desain</th>
                                    <th scope="col">Data RAB</th> --}}
                                    {{-- <th scope="col">Kontrak</th> --}}
                                    <th scope="col">Tanggal Mulai Project</th>
                                    {{-- <th scope="col">Gambar</th> --}}
                                    <th scope="col">Aksi</th>
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


{{-- <div class="modal fade" id="modalHasil" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Kirim File</h5>
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
                        <label for="hasil_rab">File RAB</label>
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
</div> --}}



@push('js')

<script src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}"></script>
        <script src="{{ asset('node_modules/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
        <script src="{{ asset('node_modules/datatables.net-select-bs4/js/select.bootstrap4.min.js') }}"></script>
        <script>
            $(function() {
                let table = $('#table-project').DataTable({
                    processing: true,
                    serverSide: true,
                    autoWidth: false,
                    ajax: "{{ route('kontraktor.job.verify') }}",
                    columns: [

                        {
                            data: 'DT_RowIndex',
                            name: 'DT_RowIndex'
                        },
                        {
                            data: 'konstruksi_owner.user.name',
                            name: 'name'
                        },
                        {
                            data: 'alamat',
                            name: 'alamat'
                        },
                        {
                            data: 'siap',
                            name: 'siap'
                        },
                        // {
                        //     data: 'cabang.nama_tim',
                        //     name: 'nama_tim'
                        // },
                        // {
                        //     data: 'RAB',
                        //     name: 'RAB'
                        // },
                        // {
                        //     data: 'desain',
                        //     name: 'desain'
                        // },
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

                $('body').on('click','#unverify',function () {
                    let id = $(this).data('id');
                   Swal.fire({
                    title: "Yakin?",
                    text: "Anda akan menolak project ini ",
                    icon: "question",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Reject",
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajaxSetup({
                            headers: {
                                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                                    "content"
                                ),
                            },
                        });
                        $.ajax({
                            url: "{{route('project.un-verify')}}",
                            method: "POST",
                            data: { id: id },
                            dataType: "JSON",
                            success: function () {
                                alertSuccess("Berhasil Menolak Project");
                                $('#table-project').DataTable().ajax().reload()
                            },
                        });
                    }
                });


                })

                $('body').on('click','#verify',function () {
                    let id = $(this).data('id');
                   Swal.fire({
                    title: "Yakin?",
                    text: "Anda akan memverifikasi data ini ",
                    icon: "question",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Verifikasi",
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajaxSetup({
                            headers: {
                                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                                    "content"
                                ),
                            },
                        });
                        $.ajax({
                            url: "{{route('project.verify')}}",
                            method: "POST",
                            data: { id: id },
                            dataType: "JSON",
                            success: function () {
                                alertSuccess("Berhasil memverifikasi");
                                $('#table-project').DataTable().ajax().reload()
                            },
                        });
                    }
                });


                })


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
        @include('kontraktor.js.profileJs')
{{-- @include('konsultan.js.hasil-js') --}}
@endpush
@endsection

