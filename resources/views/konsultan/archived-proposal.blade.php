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
                <h1>My Proposal</h1>
            </div>

            <div class="section-body">
                <div class="card">
                    <div class="card-header">
                        <h4>My Archived Proposal</h4>
                    </div>
                    <div class="card-body">
                        <ul class="list-group list-group-flush">

                        </ul>

                    </div>
                    <div class="card-footer"></div>
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
                loadProposal()
            });

            function loadProposal() {
                SetupAjax();
                $.ajax({
                    url: "{{ route('konsultan.proposal.data.archived') }}",
                    dataType: "JSON",
                    type: "GET",
                    success: function(response) {

                        $.each(response, function(key, value) {
                            
                            let selisih = selisihWaktu(value.created_at);
                            let status ="";
                           
                            if (value.lelang.status == 0) {
                                status="Lelang masih terbuka"
                            }
                            else if (value.lelang.status == 1) {
                                 status ="Lelang sudah ditutup"
                            }
                            $('.list-group').prepend(
                                `<li class="list-group-item d-flex  justify-content-between"><span class="d-block">Dikirim pada ${moment().format("D MMMM YYYY")} <br><span>${selisih}</span></span>  <span class="font-weight-bold"><a href="" class="font-weight-bold">${value.lelang.title}</a></span> <span>${status}</span></li>`
                                )
                        });
                    },
                });
            }
        </script>
        @include('konsultan.js.project-js')
         @include('konsultan.js.profileJs')
    @endpush
@endsection
