@extends('layouts.main')
@section('title')
Verifikasi Pembayaran
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
            <h1>Verifikasi Pembayaran</h1>
        </div>

        <div class="section-body">
            <div class="card">
                <div class="card-header">
                    <h4>Data Pembayaran</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive-sm">
                        <table class="table table-hover" id="table-payment">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Asal</th>
                                    <th scope="col">Tujuan</th>
                                    <th scope="col">Jumlah</th>
                                    <th scope="col">Tanggal</th>
                                    <th scope="col">Bukti</th>
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

<div class="modal fade" id="modalView" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detail Bukti</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

            </div>

            <div class="modal-footer">

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
                let table = $('#table-payment').DataTable({
                    processing: true,
                    serverSide: true,
                    autoWidth: false,
                    ajax: "{{ route('payment.all') }}",
                    columns: [

                        {
                            data: 'DT_RowIndex',
                            name: 'DT_RowIndex'
                        },
                        {
                            data: 'kontrak.proposal.lelang.owner.user.name',
                            name: 'asal'
                        },
                        {
                            data: 'kontrak.project_owner.project.konsultan.user.name',
                            name: 'tujuan'
                        },
                        {
                            data: 'jumlah',
                            name: 'jumlah'
                        },
                        {
                            data: "tanggal",
                            name: 'tanggal',
                            orderable: false,
                            searchable: false
                        },
                        {
                            data: 'bukti',
                            name: 'bukti',
                            orderable: false,
                            searchable: false
                        },
                        {
                            data: 'Aksi',
                            name: 'Aksi',
                            orderable: false,
                            searchable: false
                        },
                    ],
                });

                $('body').on('click','#imgBukti',function () {
                    let img = $(this).data('img');
                    $('.modal-body').append(`<img src="{{asset('img/payment/konsultan/${img}')}}" alt="" width="100%">`)
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
                            url: "{{route('payment.verify')}}",
                            method: "POST",
                            data: { id: id },
                            dataType: "JSON",
                            success: function () {
                                alertSuccess("Berhasil memverifikasi");
                                $('#table-payment').DataTable().ajax().reload()
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
