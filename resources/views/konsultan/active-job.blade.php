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
                <h1>My Active Job</h1>
            </div>

            <div class="section-body">

                <div class="row myjob">

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


            });

            function loadJob() {
                $.ajaxSetup({
                    headers: {
                        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').prop("content"),
                    },
                });
                $.ajax({
                    url: "{{ route('konsultan.job') }}",
                    dataType: "JSON",
                    type: "GET",
                    success: function(response) {
                        
                        $.each(response, function(key, value) {
                          
                           

                            $('.myjob').prepend(`
                             <div class="col-4">
                            <div class="card card-warning projectCard" data-id="${value.project.id}">
                                <div class="card-body">
                                    <h5 class="card-title">${value.project.title}</h5>
                                    <p class="card-text desc">${value.project.description}</p>
                                    <p>Harga : ${rupiahFormat((value.kontrak.proposal.tawaranHargaDesain + value.kontrak.proposal.tawaranHargaRab))}</p>
                                  
                                </div>
                            </div>
                        </div>
                            `)

                        
                        })

                    },
                });
            }
        </script>

        <script>
            $(function() {
                $('body').on('click', '.card', function() {

                    window.location.href = baseUrl + "konsultan/myjob/detil/" + $(this).data('id')


                })
            })
        </script>

        @include('konsultan.js.profileJs')
    @endpush
@endsection

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
            <form action="" id="FormUploadHasil">
                <div class="modal-body">


                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>

        </div>
    </div>
</div>
