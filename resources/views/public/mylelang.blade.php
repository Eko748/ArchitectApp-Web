@extends('layouts.public-main')
@section('title')
Project
@endsection
@include('layouts.navbar')

@section('content')
<div class="container-fluid">

    <div class="row justify-content-center">
        <div class="col-lg-10 col-sm col-md p-4">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('public.landing') }}">Home</a></li>
                    <li class="breadcrumb-item active">Lelang Saya</li>
                </ol>
            </nav>
            <h1><span class="counter">{{ $data->count() }}</span><span class="text">Desain Lelang</span></h1>
            <div class="button-dropdown my-3 d-sm-none d-md-none d-lg-block">
                <div class="btn-group">
                    <button class="btn btn-warning btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown"
                        aria-expanded="false">
                        <span class="">Gaya Desain</span>
                    </button>
                    <ul class="dropdown-menu">
                        <li><a href="#" class="dropdown-item">Minimalist</a></li>
                        <li><a href="#" class="dropdown-item">Professional</a></li>
                    </ul>
                </div>
                <div class="d-inline">Reset</div>
            </div>

            <hr class="my-3">

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
                                    <button type="button" class="btn btn-info">view</button>
                                    <button type="button" class="btn btn-warning">Edit</button>
                                    <button type="button" class="btn btn-danger">Hapus</button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
</div>


@include('layouts.footer')

@push('js')

<script>
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
                url: "{{ route('owner.lelang.all') }}",
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
@endpush
@endsection
