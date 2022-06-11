@extends('layouts.public-main')
@section('title')
    Project Saya
@endsection
@include('layouts.navbar')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-10 col-md col-sm">
                <div class="my-4">
                    <div class="page mb-3">
                        <h4>Project Saya</h4>
                    </div>
                    <div class="card">
                        <h4 class="px-3 pt-3">{{ $data->project->title }}</h4>
                        <div class="d-flex justify-content-between px-4 py-3">
                            <div>
                                <span class="d-block"><i class="fas fa-wallet me-1"></i>Rp {{ $data->project->harga_desain + $data->project->harga_rab }}</span>
                                <small class="text-muted ms-3 disp">Total Harga</small>
                            </div>
                            <div><span class="d-block">
                                    <i class="fas fa-folder-open me-1"></i>{{ $data->project->gayaDesain }}</span>
                                <small class="text-muted ms-3 disp">Desain Style</small>
                            </div>
                            <div><span class="d-block">
                                    <i class="fas fa-user-tie me-1"></i>{{ $data->project->konsultan->user->name }}</span>
                                <small class="text-muted ms-3 disp">Architect / Designer</small>
                            </div>
                            {{-- <div>
                                <span class="d-block me-2"><i class="fas fa-map-marker-alt me-1"></i>{{ $data->project->konsultan->user->alamat }}</span>
                                <small class="text-muted ms-3 disp">Alamat</small>
                            </div> --}}
                        </div>
                        <div class="divider"></div>
                        <div class="text-capitalized p-3">
                            <b>Deskripsi</b>
                            <div class="text-capitalized h-6">
                                {{ $data->project->description }}
                            </div>
                            
                        </div>
                        <div class="divider"></div>
                        <div class="text-capitalized p-3">
                            <b>Foto Ruangan / Bangunan Anda</b>
                        
                        <div class="images">
                            @foreach ($data->ambil_image as $item)
                            <img src="{{ url('/img/owner/'.$item->image) }}" alt="" width="254px" height="180">
                            @endforeach
                        </div>
                        </div>
                        @if ($data->kontrak->proposal != null)
                            <div class="divider"></div>
                            <div class="p-3">
                                <b>Gambar Inspirasi</b>
                            </div>
                        @endif
                        <div class="divider"></div>
                        <div class="  p-3">
                            <b>File Hasil </b>

                        </div>
                        <div class="divider"></div>
                        <div class="p-3 d-inline">
                            <a href="{{ route('owner.download', $data->kontrak->id) }}"
                                class="btn btn-primary btn-sm">Lihat Kontrak</a>
                            <a href="#" class="btn btn-success btn-sm">Chat Konsultan</a>
                            
                            

                            @if ($data->kontrak->payment != null)
                                @if ($data->rating != null)
                                    <button class="btn btn-warning btn-sm " disabled>Rating</button>

                                @endif
                                <button class="btn btn-warning btn-sm ">Rating</button>
                                <span class="badge bg-success rounded-pill ms-auto">Sudah bayar</span>
                            @else
                            <form action="{{ route('owner.payment') }}" style="display: inline;">
                                {{ csrf_field() }}
                                <input type="hidden" name="projectId" value="{{ $data->id }}">
                                <input type="hidden" name="kontrakKonsultanId" value="{{ $data->kontrak->id }}">
                                <button class="btn btn-warning btn-sm" id="pay-button">
                                    Transaksi
                                </button>
                                {{-- <button id="pay-button">Pay!</button> --}}
                            </form>
                                {{-- <button class="btn btn-warning btn-sm  upload" data-bs-toggle="modal"
                                    data-bs-target="#modalBayar" data-id="{{ $data->kontrak->id }}">Upload
                                    bukti</button> --}}
                                {{-- <button type="submit" class="btn btn-warning btn-sm">Submit</button> --}}
                                <span class="badge bg-info rounded-pill text-end">Belum bayar</span>
                            @endif
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    
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
    {{-- @include('payment/payment') --}}
    @include('layouts.footer')

    @push('js')
    {{-- <button id="pay-button">Pay!</button> --}}
    {{-- <script type="text/javascript"
      src="https://app.sandbox.midtrans.com/snap/snap.js"
      data-client-key="SB-Mid-client-ojEypI047x7sFX1T"></script>
    <!-- Note: replace with src="https://app.midtrans.com/snap/snap.js" for Production environment -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity=" " crossorigin="anonymous"></script>

    <script type="text/javascript">
        // For example trigger on button clicked, or any time you need
        var payButton = document.getElementById('pay-button');
        payButton.addEventListener('click', function () {
          // Trigger snap popup. @TODO: Replace TRANSACTION_TOKEN_HERE with your transaction token
          window.snap.pay('$snap_token', {
            onSuccess: function(result){
              /* You may add your own implementation here */
              console.log(result);
              send_response_to_form(result);
            },
            onPending: function(result){
              /* You may add your own implementation here */
              console.log(result);
              send_response_to_form(result);
            },
            onError: function(result){
              /* You may add your own implementation here */
              console.log(result);
              send_response_to_form(result);
            },
            onClose: function(){
              /* You may add your own implementation here */
              alert('Anda Menutup Halaman tanpa menyelesaikan Transaksi');
            }
          })
        });
  
        function send_response_to_form(result){
          document.getElementById('json_callback').value = JSON.stringify(result);
          $('#submit_form').submit();
        }
      </script> --}}
    

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
