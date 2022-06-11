@extends('layouts.main')
@section('title')
    Archived Project
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
                <h1>My Archived Job</h1>
            </div>

            <div class="section-body">
                <div class="row myjob">

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


            });

            function loadJob() {
                $.ajaxSetup({
                    headers: {
                        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').prop("content"),
                    },
                });
                $.ajax({
                    url: "{{ route('konsultan.archived.job') }}",
                    dataType: "JSON",
                    type: "GET",
                    success: function(response) {
                        // console.log(response)
                        $.each(response, function(key, value) {
                            let path = "{{ asset('img/project/') }}"

                            let img = ""
                            let arr = new Array()
                            $.each(value.project_own, function(key, value) {
                                $.each(value.hasil, function(key, value) {
                                    arr = value
                                })

                            })
                            console.log(arr)
                            img += `<img src="${path}/${arr.softfile}" class="card-img-top" >`
                            $('.myjob').append(`
                             <div class="col-4">
                            <div class="card projectCard">
                                ${img}
                                <div class="card-body">
                                    <h5 class="card-title">${value.title}</h5>
                                    <div class="card-text desc">${value.description}</div>
                                    <div class="d-inline mt-2">
                                        <span class="card-text d-inline mr-3">Rating</span>
                                        <span class="fa fa-star text-warning"></span>
                                        <span class="fa fa-star text-warning"></span>
                                        <span class="fa fa-star text-warning"></span>
                                        <span class="fa fa-star"></span>
                                        <span class="fa fa-star"></span>
                                        </div>
                                </div>
                            </div>
                        </div>
                            `)
                        })

                    },
                });
            }
        </script>

        @include('konsultan.js.profileJs')
    @endpush
@endsection
