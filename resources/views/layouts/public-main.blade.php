<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <meta http-equiv="X-UA-Compatible" content="IE=7">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title')</title>

    <!-- General CSS Files -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    {{--
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css"
        integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
    --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.css"
        integrity="sha512-4wfcoXlib1Aq0mUtsLLM74SZtmB73VHTafZAvxIp/Wk9u1PpIsrfmTvK0+yKetghCL8SHlZbMyEcV8Z21v42UQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- CSS Libraries -->
    @yield('css')
    <!-- Template CSS -->
    <link rel="stylesheet" href="{{ asset('sweetalert2/dist/sweetalert2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
    <link rel="stylesheet" href="{{ asset('css/carousel.css') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;1,100;1,200;1,300;1,400;1,500;1,600;1,700&display=swap"
        rel="stylesheet">
</head>

<body>
    <div class="preloader">
        <div class="loading">
            <img src="{{ asset('img/loader.gif') }}" width="150">
            <p class="text-center">Harap Tunggu</p>
        </div>
    </div>



    @yield('content')

    <!-- General JS Scripts -->
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"
        integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.nicescroll/3.7.6/jquery.nicescroll.min.js">
    </script>
    <script src="https://unpkg.com/infinite-scroll@4/dist/infinite-scroll.pkgd.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
    <script src="{{ asset('js/jquery.mask.min.js') }}"></script>

    <script src="{{ asset('js/stisla.js') }}"></script>

    <!-- JS Libraries -->
    <script src="{{ asset('sweetalert2/dist/sweetalert2.min.js') }}"></script>
    <script src="{{ asset('js/custom.js') }}"></script>
    <!-- Template JS File -->
    <script>
        @auth
            $(function() {
            let url = "{{ route('owner.profile.show', Auth::user()->id) }}"
            let path = " {{ asset('img/avatar/') }}"
            SetupAjax();
            $.ajax({
            url: url,
            dataType: "JSON",
            type: "POST",
            success: function(response) {
            $('.pp').prop('src',path +'/'+ response.avatar)


            },
            });
            })
        @endauth
    </script>
    <script>
        $('.project').on('click', function() {
            let slug = $(this).data('slug')
            window.location.href = baseUrl + `detil/project/${slug}`
        })
        $('.konsultan').on('click', function() {
            let slug = $(this).data('slug')
            window.location.href = baseUrl + `detil/konsultan/${slug}`
        })
        $('.kontraktor').on('click', function() {
            let slug = $(this).data('slug')
            window.location.href = baseUrl + `detil/kontraktor/${slug}`
        })
    </script>
    <!-- Page Specific JS File -->
    @stack('js')

</body>

</html>
