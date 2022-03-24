<div id="myCarousel" class="carousel slide" data-bs-ride="carousel">
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
</div>
