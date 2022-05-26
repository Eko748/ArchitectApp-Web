@extends('layouts.public-main')
@section('title')
    Lelang Saya
@endsection
@include('layouts.navbar')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-10 col-md col-sm">
                <div class="my-4">
                    <div class="page mb-3">
                        <h4>Lelang Saya</h4>
                        <hr>
                    </div>
                    <ul class="list-group"></ul>
                    <div class="row justify-content-center none-lelang" style="display: none">
                        <div class="col-lg-6 col-md col-sm text-center" style="height: 200px">
                            <p class="">Anda belum membuat lelang</p>
                            <a href="{{ route('owner.lelang') }}" class="btn btn-warning btn-sm">Buat Lelang</a>
                        </div>
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
                </li><br>`)
                });
                },
                });
                });
            @endauth
        </script>
    @endpush
@endsection
