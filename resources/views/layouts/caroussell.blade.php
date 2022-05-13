<script>
    const hero = document.querySelector(".hero-section");
hero.style.height = window.innerHeight + "px";
 
window.addEventListener("resize", function () {
  hero.style.height = this.innerHeight + "px";
});
</script>

<link rel="stylesheet" href="{{ asset('css/landing.css') }}">

<svg style="display:none;">
    <symbol id="one" viewBox="0 0 1440 320" preserveAspectRatio="none">
        <path fill="white" d="M0,96L1440,320L1440,320L0,320Z"></path>
      </symbol>
      <symbol id="two" viewBox="0 0 1440 320" preserveAspectRatio="none">
        <path fill="white" d="M0,32L48,37.3C96,43,192,53,288,90.7C384,128,480,192,576,197.3C672,203,768,149,864,138.7C960,128,1056,160,1152,160C1248,160,1344,128,1392,112L1440,96L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path>
      </symbol>
        
      <!-- more symbols here -->
</svg>

<section class="hero-section position-relative">
    <video src="./mp4/rumah.mp4" autoplay loop muted playsinline></video>
  <div class="overlay position-absolute d-flex align-items-center justify-content-center font-weight-bold text-white h2 mb-0">
    <blockquote class="p-4 mb-0">
      <p>Interior Rumah Ideal</p>
      <footer class="blockquote-footer text-white text-right">Segera daftarkan</footer>
    </blockquote>
  </div>
  <svg class="position-absolute w-100">
    <use xlink:href="#one"></use>
  </svg>
</section>

{{-- <section class="photos-section py-5 d-flex justify-content-center">...</section>
<section class="cover-section position-relative">...</section> --}}


{{-- <div id="myCarousel" class="carousel slide" data-bs-ride="carousel">
    <div class="carousel-indicators">
        <button type="button" data-bs-target="#myCarousel" data-bs-slide-to="0" class="active" aria-current="true"
            aria-label="Slide 1"></button>
        <button type="button" data-bs-target="#myCarousel" data-bs-slide-to="1" aria-label="Slide 2"></button>
        <button type="button" data-bs-target="#myCarousel" data-bs-slide-to="2" aria-label="Slide 3"></button>
    </div>
    <div class="carousel-inner">
        <div class="carousel-item active">
            <img src="https://source.unsplash.com/oGmf8o53LeE/800x600" alt="">
            <div class="container">
                <div class="carousel-caption text-start">
                    <h1>Mencari Desain Rumah?</h1>
                    <p>Buat akun segera agar bisa konsultasi dengan tenaga profesional dibidang desain.</p>
                    <p><a class="btn btn-lg btn-primary" href="{{ route('choose.account') }}">Sign up today</a></p>
                </div>
            </div>
        </div>
        <div class="carousel-item">
            <img src="https://source.unsplash.com/rEJxpBskj3Q/800x600" alt="">
            <div class="container">
                <div class="carousel-caption">
                    <h1>Desain Project</h1>
                    <p>Ingin Melihat beberapa desain? Cek disini.</p>
                    <p><a class="btn btn-lg btn-primary" href="{{ route('public.project') }}">Project</a></p>
                </div>
            </div>
        </div>
        <div class="carousel-item">
            <img src="https://source.unsplash.com/T6d96Qrb5MY/800x600" alt="">
            <div class="container">
                <div class="carousel-caption text-end">
                    <h1>Professional</h1>
                    <p>Mencari konsultan desain profesional? Silahkan klik.</p>
                    <p><a class="btn btn-lg btn-primary" href="{{ route('public.konsultan') }}">Professional</a></p>
                </div>
            </div>
        </div>
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#myCarousel" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#myCarousel" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
    </button>
</div> --}}

{{-- <section class="cover-section position-relative">
    <div class="cover" style="background-image: url(./img/rumah/peakpx.jpg);">
      <img src="{{ asset('img/rumah/peakpx.jpg') }}" class="img-fluid invisible" alt="" style="padding:5px" />
    </div>
    <div class="caption position-absolute h4 mb-0">
    </div>
    <svg class="position-absolute w-10">
      <use xlink:href="#six"></use>
    </svg>
  </section> --}}
