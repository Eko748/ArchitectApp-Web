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
                        <h4>My Lelang</h4>
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

        <script>

            @auth
                $(function() {
           
            
            
            loadLelang()
                
                $('body').on('click','.choose',function () {
                    let id = $(this).data('id');
                    let lelangId = $(this).data('lelang');
                    let Chooseurl = baseUrl + "owner/proposal/choose/" + id  
                Swal.fire({
                title: "Yakin?",
                text: "Anda akan memilih konsultan ini",
                icon: "question",
                showCancelButton: true,
                confirmButtonColor: "#ffc107",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yakin",
                cancelButtonText: "Batal",
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
                url: Chooseurl,
                method: "PUT",
                data: { id: id,lelangId:lelangId },
                dataType: "JSON",
                success: function () {
                alertSuccess("Kontrak kerja telah dibuat");
               loadLelang()
                },
                });
                }
                });
                })
            
            });
            
            function loadLelang() {
                    SetupAjax();
                $.ajax({
                url: baseUrl + "owner/showlelang/" + {{ Request::segment(3) }},
                dataType: "JSON",
                type: "GET",
                success: function(response) {
                console.log(response)
            
                let selisih = selisihWaktu(response.created_at)
                let badge ="";
                let image ="";
                let proposal =""
                let path = "{{ asset('img/lelang/tkp/') }}"
                let propUrl = baseUrl + "owner/mylelang/proposal/"
            
                if (response.desain == 1) {
                badge += `<span class="badge rounded-pill bg-warning text-dark me-1">Desain 2D dan 3D</span>`
                }
                if (response.RAB == 1) {
                badge += `<span class="badge rounded-pill bg-warning text-dark me-1">Rancangan Anggaran Biaya</span>`
            
                }
            
                $.each(response.image, function(key, value) {
            
                image += `<img src="${path}/${value.image}" height="150" loading="lazy" class="d-inline m-1 rounded" >`
                })
                $.each(response.proposal, function(key, value) {
                let upload = selisihWaktu(value.created_at)
                 let button = "";
                 if (value.status == 0) {
                    button += `<button class="btn btn-warning btn-sm  ms-auto choose" data-id="${value.id}" data-lelang="${response.id}">Pilih</button>`
                }
                else if (value.status == 1 || value.status == 2) {
                button +=  '<span class="badge bg-success rounded-pill  ms-auto" >Terpilih</span>'
                }else{
                button += '<span class="badge bg-danger rounded-pill  ms-auto" >Ditolak</span>'
                }


                proposal += `<ul class="list-group p-2">
                    <li class="list-group-item  proposal" data-id="${value.id}">
                        <div class="d-flex w-100 justify-content-between">
                            <h5 class="mb-1"> <a href="${propUrl}${value.id}"
                                    class="text-decoration-none text-dark propkons">${value.konsultan.user.name}</a></h5>
                            <small class="text-muted d-block"> ${upload} </small>
                        </div>
                        <div class="d-flex w-100 justify-content-between">
                            <small class="text-muted"><span class="me-2"><i class="fas fa-map-marker-alt me-1"></i>
                                    ${value.konsultan.alamat}</span><span class=""><i class="fas fa-hand-holding-usd me-1"></i>
                                    ${rupiahFormat(value.tawaranHargaDesain + value.tawaranHargaRab)}</span></small>
                                    ${button}
                        </div>
                    </li>
                </ul>`
                })
            
            
                $('.card').html(` <h4 class="px-3 pt-3">${response.title}</h4>
                <small class="px-3 "> ${selisih}</small>
                <div class="p-3 ">
                    ${badge}
                </div>
                <div class="d-flex justify-content-between px-4 py-3">
                    <div>
                        <span class="d-block me-2"><i class="fas fa-map-marker-alt me-1"></i>${response.owner.alamat}</span>
                        <small class="text-muted ms-3 disp">Lokasi</small>
                    </div>
                    <div>
                        <span class="d-block"><i class="fas fa-wallet me-1"></i>${rupiahFormat(response.budgetFrom)} -
                            ${rupiahFormat(response.budgetTo)}</span>
                        <small class="text-muted ms-3 disp">Estimasi Biaya</small>
                    </div>
                    <div><span class="d-block">
                            <i class="fas fa-folder-open me-1"></i>${response.gayaDesain}</span>
                        <small class="text-muted ms-3 disp">Desain Style</small>
                    </div>
                </div>
                <div class="divider"></div>
                <div class="text-capitalized p-3">
                    ${response.description}
                </div>
                <div class="divider"></div>
                <div class="images p-3">
                    <h6>Image </h6>
                    ${image}
                </div>
                <div class="divider"></div>
                <div class="  p-3">
                    <h6>Proposal </h6>`+
                    (response.proposal_count == 0 ? 'Belum ada yang mengajukan proposal' : proposal)
                    +`
                </div>`)
                },
                });
            
            }
            @endauth
        </script>
    @endpush
@endsection
