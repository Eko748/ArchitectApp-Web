@extends('layouts.main')
@section('title')
  Verifikasi
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
                <h1>Data Tender</h1>
            </div>
            <div class="section-body">
                <div class="card">
                    <div class="card-header">
                        <h4>Data Tender Terpilih</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive-sm">
                            <table class="table table-hover" id="table-tender">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Title</th>
                                        <th scope="col">Konsultan</th>
                                        <th scope="col">Owner</th>
                                        <th scope="col">Tanggal</th>
                                        <th scope="col">Aksi</th>
                                    </tr>
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
                    <h5 class="modal-title">Detail Tender</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                     <div class="form-group">
                            <label for="ownerName">Nama Owner</label>
                            <input type="text" name="ownerName" id="ownerName" class="form-control" disabled>
                            
                        </div>
                        <div class="form-group">
                            <label for="konsName">Nama Konsultan</label>
                            <input type="text" name="konsName" id="konsName" class="form-control" disabled>
                        </div>
                        <div class="form-group">
                            <label for="date">Tanggal</label>
                            <input type="text" name="date" id="date" class="form-control" disabled>
                        </div>
                        <div class="form-group">
                            <label for="harga">Harga</label>
                            <input type="text" name="harga" id="harga" class="form-control" disabled>
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
    </div>


    @push('js')
        <script src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}"></script>
        <script src="{{ asset('node_modules/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
        <script src="{{ asset('node_modules/datatables.net-select-bs4/js/select.bootstrap4.min.js') }}"></script>
        <script>
            $(function() {
                let table = $('#table-tender').DataTable({
                    processing: true,
                    serverSide: true,
                    autoWidth: false,
                    ajax: "{{ route('tender.all') }}",
                    columns: [

                        {
                            data: 'DT_RowIndex',
                            name: 'DT_RowIndex'
                        },
                        {
                            data: 'lelang.title',
                            name: 'title'
                        },
                        {
                            data: 'konsultan.user.name',
                            name: 'konsultan'
                        },
                        {
                            data: 'lelang.owner.user.name',
                            name: 'owner'
                        },
                        {
                            data: 'tanggal',
                            name: 'tanggal'
                        },
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
                    let url = baseUrl + "tender/" +id
                     $.ajax({
                url: url,
                dataType: "JSON",
                type: "GET",
                success: function(response) {
                    console.log(response)
                    $("#konsName").val(response.konsultan.user.name);
                    $("#ownerName").val(response.lelang.owner.user.name);
                    $("#date").val(moment(response.created_at).format('d MMMM Y'));
                    $("#harga").val(rupiahFormat(response.tawaranHarga));
                    

                },
            });  
                })
                $('body').on('submit','#formVerify',function (e) {
                   e.preventDefault()
                   
                })

            });
        </script>
           @include('admin.js.profileJs')
    @endpush
@endsection
