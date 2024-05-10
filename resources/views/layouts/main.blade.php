<!DOCTYPE html>
<html lang="en" data-bs-theme="light">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <script src="{{ asset('files/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('files/color-modes.js') }}"></script>

    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Course">
    <meta name="generator" content="Hugo 0.122.0">
    <title>{{ env('APP_NAME') }}</title>
    <link rel="canonical" href="#">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
            crossorigin="anonymous"></script>

    <!-- Favicons -->
    <link rel="apple-touch-icon" href="https://getbootstrap.com/docs/5.3/assets/img/favicons/apple-touch-icon.png"
          sizes="180x180">
    <link rel="icon" href="https://getbootstrap.com/docs/5.3/assets/img/favicons/favicon-32x32.png" sizes="32x32"
          type="image/png">
    <link rel="icon" href="https://getbootstrap.com/docs/5.3/assets/img/favicons/favicon-16x16.png" sizes="16x16"
          type="image/png">
    <link rel="manifest" href="https://getbootstrap.com/docs/5.3/assets/img/favicons/manifest.json">
    <link rel="mask-icon" href="https://getbootstrap.com/docs/5.3/assets/img/favicons/safari-pinned-tab.svg"
          color="#712cf9">
    <link rel="icon" href="https://getbootstrap.com/docs/5.3/assets/img/favicons/favicon.ico">
    <meta name="theme-color" content="#712cf9">

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet"/>

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Progress Bar-->
    <!-- Normalize CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">
    <!-- Bootstrap 4 CSS -->
    <link rel='stylesheet'
          href='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-beta.2/css/bootstrap.css'>
    <!-- Telephone Input CSS -->
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/12.1.2/css/intlTelInput.css'>
    <!-- Icons CSS -->
    <link rel='stylesheet' href='https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css'>
    <!-- Nice Select CSS -->
    <link rel='stylesheet'
          href='https://cdnjs.cloudflare.com/ajax/libs/jquery-nice-select/1.1.0/css/nice-select.min.css'>

    <!-- jQuery -->
    <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js'></script>
    <!-- Bootstrap JS -->
    <script src='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-beta/js/bootstrap.min.js'></script>
    <!-- jQuery Easing JS -->
    <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.3/jquery.easing.min.js'></script>
    <!-- Telephone Input JS -->
    <script src='https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/12.1.2/js/intlTelInput.js'></script>
    <!-- Popper JS -->
    <script src='https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js'></script>
    <!-- jQuery Nice Select JS -->
    <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery-nice-select/1.1.0/js/jquery.nice-select.min.js'></script>

    <!-- End of Progress Bar-->
    <style>
        @import url("https://fonts.googleapis.com/css?family=Roboto:300i,400,400i,500,700,900");

        a.login-btn.btn-primary:hover {
            background-color: white;
            color: blue;
        }

        #progressbar {
            margin-bottom: 30px;
            overflow: hidden;
        }

        #progressbar li {
            list-style-type: none;
            color: #99a2a8;
            font-size: 9px;
            width: calc(100% / 4);
            float: left;
            position: relative;
            font: 500 13px/1 "Roboto", sans-serif;
        }

        #progressbar li:nth-child(2):before {
            content: "";
        }

        #progressbar li:nth-child(3):before {
            content: "";
        }

        #progressbar li:before {
            content: "";
            font: normal normal normal 30px/50px Ionicons;
            width: 50px;
            height: 50px;
            line-height: 50px;
            display: block;
            background: #eaf0f4;
            border-radius: 50%;
            margin: 0 auto 10px auto;
        }

        #progressbar li:after {
            content: '';
            width: 100%;
            height: 10px;
            background: #eaf0f4;
            position: absolute;
            left: -50%;
            top: 21px;
            z-index: -1;
        }

        #progressbar li:last-child:after {
            width: 150%;
        }

        #progressbar li.active {
            color: #5cb85c;
        }

        #progressbar li.active:before, #progressbar li.active:after {
            background: #5cb85c;
            color: white;
        }
    </style>

</head>
<body data-new-gr-c-s-check-loaded="14.1167.0" data-gr-ext-installed="">

<div class="container py-3">

    @include('components.header')

    <main>
        <div class="row row-cols-1 row-cols-md-3 mb-3 text-center">
            @yield('content')
        </div>
    </main>

</div>
</body>
</html>
