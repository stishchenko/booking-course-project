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
