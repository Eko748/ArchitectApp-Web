@extends('layouts.public-main')
@section('title')
    Project
@endsection
@include('layouts.navbar')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-10 col-md col-sm">
                <div class="my-4">
                    <div class="page mb-3">
                        <h4>Proposal</h4>
                    </div>
                    <div class="card">
                       
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>


    @include('layouts.footer')

    @push('js')
        {{-- <script src="js/jquery-3.3.1.min.js"></script> --}}
        <script>
            @auth

                $(function() {
                    let path = "{{asset('img/avatar/')}}"
                    let cvpath = "{{asset('img/tender/konsultan/cv/')}}"
                    let propath = "{{asset('img/project')}}"
                    let image=""
                SetupAjax();
                $.ajax({
                url: baseUrl + "owner/lelang/proposal/" + {{ Request::segment(4) }},
                dataType: "JSON",
                type: "GET",
                success: function(response) {
                console.log(response)
                    
                $.each(response.konsultan.projects.images, function(key, value) {
            
                image += `<img src="${propath}/${value.image}" height="150" loading="lazy" class="d-inline m-2" style="max-height=100px">`
                })
                    
                $('.card').html(` 
                <div class="p-3 d-flex justify-content-between"><h4 class="">${response.konsultan.user.name} - ${response.konsultan.user.email}</h4><img src="${path}/${response.konsultan.user.avatar}" width="100"></div>
                <div class="d-flex justify-content-between px-3 py-3">
                    <div>
                        <span class="d-block me-2"><i class="fas fa-map-marker-alt me-1"></i>${response.konsultan.alamat}</span>
                        <small class="text-muted ms-3 disp">Alamat</small>
                    </div>
                    <div>
                        <span class="d-block"><i class="fa fa-phone fa-rotate-90 me-2" aria-hidden="true"></i>${(response.konsultan.telepon == null ? '-' :response.konsultan.telepon)}</span>
                        <small class="text-muted ms-3 disp">Telepon</small>
                    </div>
                    <div><span class="d-block">
                            <i class="fab fa-instagram me-2"></i>${(response.konsultan.instagram == null ? '-' :response.konsultan.instagram)}</span>
                        <small class="text-muted ms-3 disp">Instagram</small>
                    </div>
                    <div><span class="d-block">
                           <i class="fas fa-hand-holding-usd me-2"></i>
                                 ${rupiahFormat(response.tawaranHargaDesain + response.tawaranHargaRab)}</span>
                                 <small class="text-muted ms-3 disp">Tawaran Harga</small>
                    </div>
                </div>
                <div class="divider"></div>
                <div class="text-capitalized p-3">
                    <h6>Cover Letter</h6>
                    ${response.coverLetter}
                </div>
                <div class="divider"></div>
                <div class="p-3">
                    <h6>Lampiran File</h6>
                    <img src="${cvpath}/${response.cv}" width="100">
                </div>
                <div class="divider"></div>
                <div class="  p-3">
                    <h6>Portofolio Project</h6>
                    ${(response.konsultan.projects.images == null ? 'Belum ada project': image)}

                </div>
                `)
                },
                });
            
                });
            @endauth
        </script>
    @endpush
@endsection
