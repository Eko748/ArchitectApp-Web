<footer class="footer-distributed">

    <div class="footer-left">
        <a href="{{ route('public.landing') }}" class="d-flex align-items-center my-2 my-lg-0 me-lg-5 text-dark text-decoration-none">
            <img src="{{ asset('img/logo_proyek.png') }}" alt="logo" width="100"
            class=" mb-0 mt-0">
        </a>
        <p class="footer-links">
            <a href="{{ route('public.landing') }}">Home</a>
            |
            <a href="{{ route('public.project') }}">Project</a>
            |
            <a href="{{ route('public.konsultan') }}">Konsultan</a>
            |
            <a href="{{ route('public.kontraktor') }}">Kontraktor</a>
        </p>

        <p class="footer-company-name">© 2022 Arsitek.co</p>
    </div>

    <div class="footer-center">
        <div>
            <i class="fa fa-map-marker"></i>
              <p>Politeknik Negeri Indramayu</p>
        </div>

        <div>
            <i class="fa fa-phone"></i>
            <p>+62 87712372564</p>
        </div>
        <div>
            <i class="fa fa-envelope"></i>
            <p>arsitek.co.proyek3@gmail.com</p>
        </div>
    </div>
    <div class="footer-right">
        <p class="footer-company-about">
            <span>About the Apps</span>
            Sebagai pusat Konsultasi desain sampai tahap Konstruksi Project interior/eksterior.</p>
        <div class="footer-icons">
            <a href="#"><i class="fab fa-facebook"></i></a>
            <a href="#"><i class="fab fa-twitter"></i></a>
            <a href="#"><i class="fab fa-instagram"></i></a>
            <a href="#"><i class="fab fa-linkedin"></i></a>
            <a href="#"><i class="fab fa-youtube"></i></a>
        </div>
    </div>
</footer>
<style>
    @import url('http://fonts.googleapis.com/css?family=Open+Sans:400,700');

*{
	padding:0;
	margin:0;
}

/* The footer is fixed to the bottom of the page */

footer{
	/* position: fixed; */
	bottom: 0;
}

@media (max-height:800px){
	footer { position: static; }
	header { padding-top:40px; }
}


.footer-distributed{
	background-color: #2c292f;
	box-sizing: border-box;
	width: 100%;
	text-align: left;
	font: bold 16px sans-serif;
	padding: 50px 50px 60px 50px;
	margin-top: 80px;
}

.footer-distributed .footer-left,
.footer-distributed .footer-center,
.footer-distributed .footer-right{
	display: inline-block;
	vertical-align: top;
}

/* Footer left */

.footer-distributed .footer-left{
	width: 30%;
}

.footer-distributed h3{
	color:  #ffffff;
	font: normal 36px 'Cookie', cursive;
	margin: 0;
}

/* The company logo */

.footer-distributed .footer-left img{
	width: 30%;
}

.footer-distributed h3 span{
	color:  #e0ac1c;
}

/* Footer links */

.footer-distributed .footer-links{
	color:  #ffffff;
	margin: 20px 0 12px;
}

.footer-distributed .footer-links a{
	display:inline-block;
	line-height: 1.8;
	text-decoration: none;
	color:  inherit;
}

.footer-distributed .footer-company-name{
	color:  #8f9296;
	font-size: 14px;
	font-weight: normal;
	margin: 0;
}

/* Footer Center */

.footer-distributed .footer-center{
	width: 35%;
}


.footer-distributed .footer-center i{
	background-color:  #33383b;
	color: #ffffff;
	font-size: 25px;
	width: 38px;
	height: 38px;
	border-radius: 50%;
	text-align: center;
	line-height: 42px;
	margin: 10px 15px;
	vertical-align: middle;
}

.footer-distributed .footer-center i.fa-envelope{
	font-size: 17px;
	line-height: 38px;
}

.footer-distributed .footer-center p{
	display: inline-block;
	color: #ffffff;
	vertical-align: middle;
	margin:0;
}

.footer-distributed .footer-center p span{
	display:block;
	font-weight: normal;
	font-size:14px;
	line-height:2;
}

.footer-distributed .footer-center p a{
	color:  #e0ac1c;
	text-decoration: none;;
}


/* Footer Right */

.footer-distributed .footer-right{
	width: 30%;
}

.footer-distributed .footer-company-about{
	line-height: 20px;
	color:  #92999f;
	font-size: 13px;
	font-weight: normal;
	margin: 0;
}

.footer-distributed .footer-company-about span{
	display: block;
	color:  #ffffff;
	font-size: 18px;
	font-weight: bold;
	margin-bottom: 20px;
}

.footer-distributed .footer-icons{
	margin-top: 25px;
}

.footer-distributed .footer-icons a{
	display: inline-block;
	width: 35px;
	height: 35px;
	cursor: pointer;
	background-color:  #33383b;
	border-radius: 2px;

	font-size: 20px;
	color: #ffffff;
	text-align: center;
	line-height: 35px;

	margin-right: 3px;
	margin-bottom: 5px;
}

/* Here is the code for Responsive Footer */
/* You can remove below code if you don't want Footer to be responsive */


@media (max-width: 880px) {

	.footer-distributed .footer-left,
	.footer-distributed .footer-center,
	.footer-distributed .footer-right{
		display: block;
		width: 100%;
		margin-bottom: 40px;
		text-align: center;
	}

	.footer-distributed .footer-center i{
		margin-left: 0;
	}

}
</style>




{{-- <footer class="sticky-bottom">
    <div class="footer-wrapper bg-dark text-white h-50 p-5">
        <div class="container">
            <div class="row">
                <div class="col-12 col-sm-6 col-lg-3 p-2 ">
                    <h6 class="text-uppercase fw-bold"><a href="{{ route('public.landing') }}" class="d-flex align-items-center my-2 my-lg-0 me-lg-5 text-dark text-decoration-none">
                        <img src="{{ asset('img/logo_proyek.png') }}" alt="logo" width="100"
                        class=" mb-0 mt-0">
                    </a></h6>
                    <div class="footer-link">
                        <a href="#" class="text-decoration-none text-white">Product</a>
                        <a href="#" class="text-decoration-none text-white">Professional</a>
                        <a href="#" class="text-decoration-none text-white">Project</a>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-lg-3 p-2">
                    <h6 class="text-uppercase fw-bold">Browse</h6>
                    <div class="footer-link fw-normal">
                        <a href="{{ route('public.landing') }}" class="text-decoration-none text-white">Home</a>
                        <a href="{{ route('public.project') }}" class="text-decoration-none text-white">Project</a>
                        <a href="{{ route('public.konsultan') }}"
                            class="text-decoration-none text-white">Professional</a>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-lg-3 p-2 ">
                    <h6 class="text-uppercase fw-bold">Projects</h6>
                    <div class="footer-link">
                        <a href="#" class="text-decoration-none text-white">Product</a>
                        <a href="#" class="text-decoration-none text-white">Professional</a>
                        <a href="#" class="text-decoration-none text-white">Project</a>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-lg-3 p-2">
                    <h6 class="text-uppercase fw-bold">About Us</h6>
                    <div class="footer-link">
                        <a href="#" class="text-decoration-none text-white">Product</a>
                        <a href="#" class="text-decoration-none text-white">Professional</a>
                        <a href="#" class="text-decoration-none text-white">Project</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer> --}}
