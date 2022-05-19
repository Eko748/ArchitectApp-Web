@extends('layouts.public-main')
@section('title')
Project
@endsection
@include('layouts.navbar')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg col-md col-sm">
            <div class="my-4">
                <div class="page mb-3">
                    <h4>My Project</h4>
                    <hr>
                </div>
                @if (count($data) != 0)
                <div class="row" id="projectData">
                    @include('ajax.data')
                </div>
                @else
                <div class="row justify-content-center">
                    <div class="col-lg-6 col-md col-sm text-center" style="height: 200px">
                        <p class="">Anda belum memiliki project</p>
                        <a href="{{ route('owner.lelang') }}" class="btn btn-warning btn-sm">Buat Lelang</a>
                    </div>
                </div>
                @endif
            </div>
        </div>
        <div class="ajax-load text-center" style="display: none">
            <img src="{{ asset('img/loader.gif') }}" width="300">
        </div>
    </div>
</div>
</div>
</div>

<div class="mt-auto">
    @include('layouts.footer')
    
</div>

@push('js')

<script>
    let myModal = new bootstrap.Modal(document.getElementById("modalBayar"))
    startLoad(myModal)
    
    function loadMoreData(page) {
        SetupAjax()
        $.ajax({
            url: '?page=' + page,
            type: 'get',
            beforeSend: function() {
                $(".ajax-load").show();
            }
        })
        .done(function(data) {
            
            if (data.html == "") {
                $('.ajax-load').html("");
                // $(".ajax-load").hide();
                
                return;
            }
            $('.ajax-load').hide();
            $("#projectData").append(data.html);
        })
        // Call back function
        .fail(function(jqXHR, ajaxOptions, thrownError) {
            
            alert("Server not responding.....");
        });
        
    }
    //function for Scroll Event
    var page = 1;
    $(window).scroll(function() {
        if ($(window).scrollTop() + $(window).height() >= $(document).height()) {
            page++;
            loadMoreData(page);
        }
    });
    
    
    $(function() {
        
        
        $('body').on('click', '.upload', function() {
            let id = $(this).data('id')
            $('#buktiBayar').val('');
            $('#kontrakId').val(id)
            $('#buktiBayar').on('change', function() {
                $('button[type=submit]').prop('disabled', false)
            })
        })
        $('body').on('submit', '#bayarForm', function(e) {
            e.preventDefault()
            SetupAjax()
            $.ajax({
                url: "{{ route('owner.pay') }}",
                dataType: "JSON",
                type: "POST",
                data: new FormData(this),
                cache: false,
                processData: false,
                contentType: false,
                success: function(response) {
                    alertSuccess("Mohon tunggu verifikasi admin");
                    $('#projectData').html('')
                    loadMoreData(1);
                    $('#kontrakId').val('')
                },
            });
            
        })
    })
</script>
@endpush

@endsection
<div class="modal fade" id="modalBayar" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
aria-labelledby="exampleModalLabel" aria-hidden="true">
<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Upload Bukti Pembayaran</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <form action="" method="POST" id="bayarForm" enctype="multipart/form-data">
                <input type="hidden" name="kontrakId" id="kontrakId">
                
                <div class="input-group mb-3">
                    <input type="file" class="form-control" id="buktiBayar" name="bukti">
                </div>
                
                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary" disabled>Upload</button>
            </div>
        </form>
    </div>
</div>
</div>
