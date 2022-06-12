@extends('layouts.main')
@section('title')
Project Owner
@endsection
@section('css')

@endsection
@section('content')
@include('layouts.topbar')
@include('layouts.sidebar-konsultan')


{{-- <div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>My Active Project</h1>
        </div>
        
        <div class="section-body">
            <div class="card">
                <div class="card-header">
                    <h4>Data Project Active</h4>
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
</div> --}}
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Project Owner Active</h1>
        </div>
        <div class="section-body">
            <div class="card">
                <div class="card-header">
                    <h4>Data Project</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive-sm">
                        <table class="table table-hover" id="table-project">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Nama Owner</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Project</th>
                                    <th scope="col">Luas Ruangan</th>
                                    <th scope="col">Kontrak</th>
                                    <th scope="col">Tanggal</th>
                                    <th scope="col">Gambar</th>
                                    <th scope="col">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                </tr>
                            </tbody>

                        </table>
                    </div>
                </div>
            </div>

        </div>
    </section>
</div>

<div class="modal fade" id="modalViewUser" tabindex="-1" role="dialog" aria-labelledby="modelTitleId"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detail Tender</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                 <div class="form-group">
                        <label for="ownerName">Nama Owner</label>
                        <input type="text" name="ownerName" id="ownerName" class="form-control" disabled>
                        
                    </div>
                    <div class="form-group">
                        <label for="konsName">RAB</label>
                        <input type="text" name="konsName" id="konsName" class="form-control" disabled>
                    </div>
                    <div class="form-group">
                        <label for="date">Tanggal</label>
                        <input type="text" name="date" id="date" class="form-control" disabled>
                    </div>
                    <div class="form-group">
                        <label for="desain">Desain</label>
                        <input type="text" name="desain" id="desain" class="form-control" disabled>
                    </div>
            </div>
            
            <div class="modal-footer">
                <form action="" method="POST" id="formVerify">
                    @csrf
                    @method("PUT")
                     <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>

                     <button type="submit" class="btn btn-primary" >Verifikasi</button>
                 </form>
            </div>
           

        </div>
    </div>
</div>

@push('js')

{{-- <script>
    $(document).ajaxStart(function() {
        $('.preloader').show()
    })
    
    @auth
    $(function() {
        $('.list-group').on('click', '.mylelang', function() {
            let id = $(this).data('id');
            window.location.href = baseUrl + 'konsultan/myjob/active-job' + id
        });
        
        
        
        SetupAjax();
        $.ajax({
            url: "{{ route('konsultan.job') }}",
            dataType: "JSON",
            type: "GET",
            success: function(response) {
                console.log(response);
                if (response.length == 0) {
                    $('.none-lelang').show()
                }
                console.log(response)
                $.each(response, function(key, value) {
                    
                    
                    $('.list-group').prepend(`<li class="list-group-item list-group-item-action mylelang" data-id="${value.id}">
                        <div class="d-flex w-100 justify-content-between">
                            <h3 class="mb-1 title">${value.title}</h3>
                            <small class="date">${selisih}</small>
                        </div>
                    </li>`)
                });
            },
        });
    });
    @endauth
</script> --}}
{{-- <script>
    $(document).ajaxStart(function() {
        $('.preloader').show()
    })

    @auth
        $(function() {
        $('.list-group').on('click', '.mylelang', function() {
        let id = $(this).data('id');
        window.location.href = baseUrl + 'konsultan/myjob/active-job' + id
        });
    
        SetupAjax();
        $.ajax({
        url: "{{ route('konsultan.job') }}",
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
        let path = "{{ asset('img/owner/') }}"
        
        $.each(response.image, function(key, value) {
    
        image += `<img src="${path}/${value.image}" height="150" loading="lazy" class="d-inline m-1 rounded" >`
        })
    
        $('.list-group').prepend(`<li class="list-group-item list-group-item-action mylelang" data-id="${value.id}">
            <div class="d-flex w-100 justify-content-between">
                <h3 class="mb-1 title">${value.desain}</h3>
                <small class="date">${selisih}</small>
            </div>
            // <small><span class="me-2">Est. Biaya: ${rupiahFormat(value.budgetFrom)} - ${rupiahFormat(value.budgetTo)}</span> <br>
            //     <span class="me-2 text-capitalize "> Style Desain: ${value.panjang} </span><span><i
            //             class="fas fa-map-marker-alt"></i> ${value.owner.alamat}</span></small>
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
</script> --}}
<script src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}"></script>
        <script src="{{ asset('node_modules/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
        <script src="{{ asset('node_modules/datatables.net-select-bs4/js/select.bootstrap4.min.js') }}"></script>
        <script>
            $(function() {
                let table = $('#table-project').DataTable({
                    processing: true,
                    serverSide: true,
                    autoWidth: false,
                    ajax: "{{ route('konsultan.job') }}",
                    columns: [

                        {
                            data: 'DT_RowIndex',
                            name: 'DT_RowIndex'
                        },
                        {
                            data: 'owner.user.name',
                            name: 'name'
                        },
                        {
                            data: 'order',
                            name: 'order'
                        },
                        {
                            data: 'project',
                            name: 'project'
                        },
                        {
                            data: 'luas',
                            name: 'luas'
                        },
                        {
                            data: 'kontrak.kontrakKerja',
                            name: 'kontrak'
                        },
                        {
                            data: 'tanggal',
                            name: 'tanggal'
                        },
                        // {
                        //     data: 'gambar',
                        //     name: 'gambar'
                        // },
                        {
                            data: 'Aksi',
                            name: 'Aksi',
                            orderable: false,
                            searchable: false
                        },
                    ],
                });

                $('body').on('click','#viewUser',function () {
                    let id = $(this).data('id');
                    let url = baseUrl + "tender/" +id
                     $.ajax({
                url: url,
                dataType: "JSON",
                type: "GET",
                success: function(response) {
                    console.log(response)
                    $("#konsName").val(response.konsultan.user.name);
                    $("#ownerName").val(response.lelang.owner.user.name);
                    $("#date").val(moment(response.created_at).format('d MMMM Y'));
                    $("#desain").val(rupiahFormat(response.tawaranDesain));
                    

                },
            });  
                })
                $('body').on('submit','#formVerify',function (e) {
                   e.preventDefault()
                   
                })

            });
        </script>
@endpush
@endsection

