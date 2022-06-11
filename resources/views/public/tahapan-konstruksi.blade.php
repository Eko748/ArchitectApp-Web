@extends('layouts.public-main')
@section('title')
    Tahapan Konstruksi
@endsection
@include('layouts.navbar')

@section('content')
<br>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-10 col-md col-sm card shadow mb-5" style="border-radius: 30px;">
            <div class="my-4">
                <div class="page mb-3">
                    <h4>Tahapan Perencanaan Project Konstruksi</h4>
                    <hr>
                </div>
                
                            <h5>
                                1. Perencanaan (planning)
                            </h5>
                            <div class="px-3">
                                <p style="text-align: justify;">
                                    Sebagian besar proyek yang bergerak di bidang konstruksi diawali dari rencana atau gagasan yang didasari kebutuhan. Beberapa gagasan biasanya akan dituangkan oleh pemilik proyek sebagai pihak yang terlibat.
                                </p>
                            </div>
                            <h5>
                                2. Studi kelayakan (feasibility study)
                            </h5>
                            <div class="px-3">
                                <p style="text-align: justify;">
                                    Selanjutnya, Anda harus meyakinkan pemilik proyek bahwa proyek yang bersangkutan sudah layak dilaksanakan. Adapun kegiatan yang dilakukan dalam tahapan perencanaan proyek konstruksi ini mencakup penyusunan rencana kasar sesuai estimasi biaya, prediksi manfaat, analisis kelayakan hingga dampaknya.
                                </p>
                            </div>
                            <h5>
                                3. Pemaparan (briefing)
                            </h5>
                            <div class="px-3">
                                <p style="text-align: justify;">
                                    Pemilik proyek akan menjelaskan fungsi proyek hingga biaya yang nantinya akan ditafsirkan pihak konsultan perencana. Sejumlah kegiatan yang akan dilakukan pada tahap ini meliputi penyusunan rencana bersama tenaga ahli, pertimbangan kebutuhan dan lokasi, persiapan ruang lingkup kerja, hingga pembuatan sketsa.
                                </p>
                            </div>
                            <h5>
                                4. Perancangan (desain & RAB)
                            </h5>
                            <div class="px-3">
                                <p style="text-align: justify;">
                                    Kemudian, pada tahap ini Anda akan merancang desain secara mendetail sesuai keinginan pemilik proyek. Nantinya Anda bersama tim diharapkan mampu mengembangkan ikhtisar proyek sampai akhir, memeriksa masalah teknis, hingga mengajukan persetujuan akhir pada pemilik proyek. Dalam tahapan perencanaan proyek konstruksi ini, Anda diminta menyiapkan rancangan mendetail, gambar kerja (jadwal dan spesifikasi), daftar kuantitas, serta taksiran bujet akhir.
                                </p>
                            </div>
                            <h5>
                                5. Pengadaan atau pelelangan (procurement atau tender)
                            </h5>
                            <div class="px-3">
                                <p style="text-align: justify;">
                                    Pelaksanaan tahap ini bertujuan untuk memperoleh kontraktor yang bersedia mengerjakan proyek konstruksi. Kadang Anda juga harus mencari sub-kontraktor bila dibutuhkan. Kegiatan yang ada pada tahap ini meliputi prakualifikasi dan menyiapkan dokumen kontrak.
                                </p>
                            </div>
                            <h5>
                                6. Pelaksanaan (construction)
                            </h5>
                            <div class="px-3">
                                <p style="text-align: justify;">
                                    Sesuai namanya, tahap ini merupakan proses mendirikan bangunan yang dibutuhkan pemilik proyek sesuai bujet dan waktu yang disepakati dan disusun konsultan. Tahap ini melibatkan perencanaan dan pengendalian hingga koordinasi yang berkaitan dengan kegiatan yang berlangsung di lapangan. Pihak-pihak yang berada dalam tahapan perencanaan proyek konstruksi ini mencakup konsultan pengawas dan/atau konsultan MK, kontraktor dan sub-kontraktor, supplier, serta instansi terkait.
                                </p>
                            </div>
                            <h5>
                                7. Pemeliharaan dan persiapan pemakaian (maintenance & start up)
                            </h5>
                            <div class="px-3">
                                <p style="text-align: justify;">
                                    Pada tahap terakhir, Anda dan tim akan memastikan bangunan selesai tepat waktu dan sesuai dengan kontrak. Pemeriksaan mencakup mengecek kelengkapan fasilitas. Kemudian, ada tahap pemeriksaan dara pelaksanaan (data hingga gambaran pelaksanaan), penelitian bangunan, perbaikan kerusakan, hingga pelatihan pada staf yang akan melakukan pemeliharaan.
                                </p>
                            </div>
            </div>
        </div>
    </div>
</div>

@include('layouts.footer')
@push('js')
@endpush
@endsection