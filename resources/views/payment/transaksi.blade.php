@extends('layouts.public-main')
@section('title')
    Transaksi
@endsection
@include('layouts.navbar')
@section('content')
<div class="container">
  <div class="row justify-content-center">
      <div class="col-10 col-md col-sm">
        <div class="my-4">
          <div class="page mb-3">
              <h4>Transaksi</h4>
          </div>
          <div class="card">
            <h4 class="px-3 pt-3">Information</h4>
          <p class="px-3 pt-3">
            Semua jenis transaksi diawasi oleh pihak ketiga
          </p>
          <br>
          </div>
              
            <html>
              <head>
                {{-- <meta name="viewport" content="width=device-width, initial-scale=1"> --}}
                {{-- <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700" rel="stylesheet"> --}}
                <!-- @TODO: replace SET_YOUR_CLIENT_KEY_HERE with your client key -->
                <script type="text/javascript"
                  src="https://app.sandbox.midtrans.com/snap/snap.js"
                  data-client-key="SB-Mid-client-ojEypI047x7sFX1T"></script>
                <!-- Note: replace with src="https://app.midtrans.com/snap/snap.js" for Production environment -->
                <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity=" " crossorigin="anonymous"></script>
              </head>
            <body>
              <form action="" id="submit_form" method="POST">
                  @csrf
                  <input type="hidden" name="json" id="json_callback">
              </form>
              <button style="display: inline; border-radius: 5px;" class="btn btn-warning btn-sm center px-3" id="pay-button"><i class="fa fa-shopping-cart"></i> Checkout!</button>
              <br>
              <br>
              <br>
              <script type="text/javascript">
                // For example trigger on button clicked, or any time you need
                var payButton = document.getElementById('pay-button');
                payButton.addEventListener('click', function () {
                  // Trigger snap popup. @TODO: Replace TRANSACTION_TOKEN_HERE with your transaction token
                  window.snap.pay('{{$snap_token}}', {
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
              </script>
            </body>
            </html>
</div>
</div>
</div>
</div>

@include('layouts.footer')
@endsection