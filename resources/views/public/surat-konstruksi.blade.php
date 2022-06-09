<!DOCTYPE html>
<html>
<head>
    <title>{{$filename}}</title>
     <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
   <style>
  

   </style>
</head>
<body>
    <h5 class="text-center">SURAT PERJANJIAN KONTRAK KERJA</h5>
    <br><br>
    <p>Pada hari ini, {{$date}} yang bertanda tangan di bawah ini:</p>
      <br><br>
    <P>Nama <span>:</span>{{$ownName}}</p>
    <P>Telepon <span>:</span> {{$ownTelp}}</p>
    <P>Alamat <span>:</span> {{$ownAlm}}</p>
     bertindak sebagai pemilik pekerjaan yang dalam hal ini disebut sebagai PIHAK PERTAMA
    
          <br><br>

    <P>Nama <span>:</span> {{$kontraktorName}}</p>
    <P>Telepon <span>:</span> {{$kontraktorTelp}}</p>
    <p>Alamat <span>:</span> {{$kontraktorAlm}}</p>
    bertindak sebagai kontraktor yang dalam hal ini disebut sebagai PIHAK KEDUA
    
     <br><br><br>

     Dengan ini kedua belah pihak menyatakan setuju untuk mengadakan perjanjian kerja pembuatan {{$title}} dengan jumlah pembayaran {{$harga}} 
        <br><br><br>

        {{-- <br><br>
        <span>  <p class="text-left">{{$ownName}}</p></span><span> <p class="text-right">{{$konsName}}</p></span> --}}

    
{{-- <span class="text-left mr-auto"></span><span class="ml-auto">Pihak Kedua</span> --}}
<table>
    <thead>
        <th>Pihak Pertama</th>
        
        <th >Pihak Kedua</th>
    </thead>
</table>
    

</body>

</html>