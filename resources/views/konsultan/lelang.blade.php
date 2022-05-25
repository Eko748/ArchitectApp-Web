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
                        <table class="table table-hover" id="table-project">
                        <ul class="list-group">
                            
                        </ul>
                        </table>
                        <div class="row justify-content-center none-lelang" style="display: none">
                            <div class="col-lg-6 col-md col-sm text-center" style="height: 100px">
                                <p class="">Owner belum ada yang membuat lelang</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
                        
@endsection

@push('js')

        <script>
            $(document).ajaxStart(function() {
                $('.preloader').show()
            })

            @auth
                $(function() {
                $('.list-group').on('click', '.mylelang', function() {
                let id = $(this).data('id');
                window.location.href = baseUrl + 'konsultan/lelang/' + id
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
                let image ="";
                let path = "{{ asset('img/lelang/ruangan/') }}"

                
                $.each(response.image, function(key, value) {
            
                image += `<img src="${path}/${value.image}" height="150" loading="lazy" class="d-inline m-1 rounded" >`
                })

            
            
            
                $('.list-group').prepend(`<li class="list-group-item list-group-item-action mylelang" data-id="${value.id}">
                    <div class="d-flex w-100 justify-content-between">
                        <h3 class="mb-1 title">${value.title}</h3>
                        <small class="date">${selisih}</small>
                    </div>
                    <small><span class="me-2">Est. Biaya: ${rupiahFormat(value.budgetFrom)} - ${rupiahFormat(value.budgetTo)}</span> <br>
                        <span class="me-2 text-capitalize "> Style Desain: ${value.gayaDesain} </span><span><i
                                class="fas fa-map-marker-alt"></i> ${value.owner.alamat}</span></small>
                                <hr>
                    <h6><b>Deskripsi</b></h6>
                    <p class="mb-1 my-2 desc d-inline ">${value.description}</p>
                    <div class="images p-3">
    
                    ${image}
                    </div>
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
