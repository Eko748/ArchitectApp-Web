@extends('layouts.main')
@section('title')
Admin Page
@endsection
@section('css')
<link rel="stylesheet" href="{{ asset('node_modules/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }} ">
<link rel="stylesheet" href="{{ asset('node_modules/datatables.net-select-bs4/css/select.bootstrap4.min.css') }}">

@endsection
@section('content')
@include('layouts.topbar')
@include('layouts.sidebar')

<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Kontraktor Page</h1>
        </div>

        <div class="section-body">
            <div class="card">
                <div class="card-header">
                    <h4>Data Kontraktor</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive-sm">
                        <table class="table table-hover" id="table-user">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Nama</th>
                                    <th scope="col">Username</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Accept</th>
                                    <th scope="col">Aksi</th>
                                </tr>
                                @php
                                $no = 0
                                @endphp
                                @foreach($adminpage as $a)
                                <tr>
                                    <td>{{++$no}}.</td>
                                    <td>{{$a->name}}</td>
                                    <td>{{$a->username}}</td>
                                    <td>{{$a->email}}</td>
                                    {{-- <td>{{$k->alamat}}</td> --}}
                                    <td>
                                        @if ($a->final == 1)
                                        <div class="badge badge-success">Sudah disetujui</div>
                                        @else
                                        <div class="badge badge-danger">Belum disetujui</div>
                                        @endif
                                    </td>
                                    <td>
                                        <form method="POST" action="{{ url ('/kontraktor/'.$a->id) }}" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button onclick="return confirm('Yakin ? Ingin Menghapus Data Ini ?')" type="submit" class=" btn-danger btn-sm">
                                                Hapus
                                            </button>
                                        </form>
                                        <button type="button" class="btn btn-warning">Edit</button>
                                    </td>
                                </tr>
                                @endforeach
                            </thead>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </section>
</div>

<div class="modal fade" id="modalViewUser" tabindex="-1" role="dialog" aria-labelledby="modelTitleId"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detail Kontraktor</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="d-flex flex-row">
                    <img src="" class="pp align-self-start" width="140">
                    <div class=" ml-4">

                        <div class="row mb-3">
                            <label for="name" class="col-sm-3 col-form-label">Name</label>
                            <div class="col-sm">
                                <input type="text" class="form-control form-control-sm readonly td-name">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="uname" class="col-sm-3 col-form-label">Username</label>
                            <div class="col-sm">
                                <input type="text" class="form-control form-control-sm readonly td-uname">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="email" class="col-sm-3 col-form-label">Email</label>
                            <div class="col-sm">
                                <input type="email" class="form-control form-control-sm readonly td-email">
                            </div>
                        </div>

                    </div>
                </div>


            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">Tutup</button>

            </div>

        </div>
    </div>
</div>


@push('js')
<script src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('node_modules/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('node_modules/datatables.net-select-bs4/js/select.bootstrap4.min.js') }}"></script>
<script>
    $(function() {
                let table = $('#table-user').DataTable({
                    processing: true,
                    serverSide: true,
                    autoWidth: false,
                    ajax: "{{ route('kontraktor.all') }}",
                    columns: [

                        {
                            data: 'DT_RowIndex',
                            name: 'DT_RowIndex'
                        },
                        {
                            data: 'name',
                            name: 'name'
                        },
                        {
                            data: 'username',
                            name: 'username'
                        },
                        {
                            data: 'email',
                            name: 'email'
                        },
                        {
                            data: 'Aksi',
                            name: 'Aksi',
                            orderable: false,
                            searchable: false
                        },
                    ],
                });

 $('body').on('click','#verify',function () {
                    let id = $(this).data('id');
                   Swal.fire({
                    title: "Yakin?",
                    text: "Anda akan memverifikasi konsultan ini ",
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
                            url: "{{route('verify.pro')}}",
                            method: "POST",
                            data: { id : id },
                            dataType: "JSON",
                            success: function () {
                                alertSuccess("Berhasil memverifikasi");
                                 $('#table-user').DataTable().ajax.reload()
                            },
                        });
                    }
                });


                })


            });
</script>
@include('admin.js.profileJs')
@endpush
@endsection
