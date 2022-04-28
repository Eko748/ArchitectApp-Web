@extends('layouts.main')
@section('title')
    Lelang Owner
@endsection
@section('css')

@endsection
@section('content')
    @include('layouts.topbar')
    @include('layouts.sidebar-konsultan')

    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Lelang Owner</h1>
            </div>

            <div class="section-body">
                <div class="card">
                    <div class="card-header">
                        <h4>List Lelang</h4>
                    </div>
                    <div class="card-body">
                        <div class="main">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">Title</th>
                                            <th scope="col">Gaya Desain</th>
                                            <th scope="col">Opsi View Desain</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($data as $view)
                                        <tr>
                                            <th scope="row">{{ $loop->iteration }}</th>
                                            <td>{{ $view->title }}</td>
                                            <td>{{ $view->gayaDesain }}</td>
                                            <td>
                                                
                                                <button class="btn btn-info" onclick="viewlelang({{ $view->id }})"
                                                    data-toggle="modal" data-target="#exampleModal">view</button>
                                                
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                    </div>
                </div>

                <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">All View My Lelang</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div id="view-image"></div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
    </div>
    </section>
    </div>
    @push('js')
        <script>
        function viewlelang(id) {
        $.ajax({
                url : "{{ url('/konsultan/lelang/owner-detail') }}/"+id,
                type : 'GET',
                success : function(data) {
                    console.log(id);
                    $("#view-image").html(data);
                    return true;
                }   
                });
            }

            $(document).ajaxStart(function() {
                $('.preloader').show()
            })
            @auth
                $(function() {
                $('.list-group').on('click', '.mylelang', function() {
                let id = $(this).data('id');
                window.location.href = baseUrl + 'owner/mylelang/' + id
                });



                SetupAjax();
                $.ajax({
                url: "{{ route('konsultan.lelang.all') }}",
                dataType: "JSON",
                type: "GET",
                success: function(response) {
                if (response.length == 0) {
                $('.none-lelang').show()
                }
                console.log(response)
                $.each(response, function(key, value) {


                let selisih = selisihWaktu(value.created_at);
                let badge = "";




                $('.list-group').prepend(`<li class="list-group-item list-group-item-action mylelang" data-id="${value.id}">
                    <div class="d-flex w-100 justify-content-between">
                        <h5 class="mb-1 title">${value.title}</h5>
                        <small class="date">${selisih}</small>
                    </div>
                    <small><span class="me-2">Est. Biaya: ${rupiahFormat(value.budgetFrom)} - ${rupiahFormat(value.budgetTo)}</span>
                        <span class="me-2 text-capitalize "> Style Desain: ${value.gayaDesain} </span><span><i
                                class="fas fa-map-marker-alt"></i> ${value.owner.alamat}</span></small>
                    <p class="mb-1 my-2 desc d-inline ">${value.description}</p>
                    <div class="text-decoration-none my-3">
                        ${badge}
                    </div>
                    <small><span>Proposal: ${value.proposal_count}</span> <span class="ms-2 ">Status: `+ (value.status == 0 ?
                            '<span class="text-success fw-bolder">aktif</span>' : '<span class="text-danger fw-bolder">tutup</span>')
                            +`</span></small>
                </li>`)
                });
                },
                });
                });
            @endauth
        </script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
        @include('konsultan.js.lelang-js')
        @include('konsultan.js.profileJs')

    @endpush
@endsection
