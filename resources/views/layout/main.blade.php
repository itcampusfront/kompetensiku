<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="description" content="@yield('meta_description')">
    <meta name="keywords" content="{{ setting('site.keywords') }}">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('assets/images/icon/' . setting('site.icon')) }}">
    <title>@yield('title') {{ setting('site.name') }} &#8211; {{ setting('site.tagline') }}</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"
        integrity="sha512-iBBXm8fW90+nuLcSKlbmrPcLa0OT92xO1BIsZ+ywDWZCvqsWgccV3gFoRBv0z+8dLJgyAHIhR35VZc2oM/gI1w=="
        crossorigin="anonymous" />
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/style-kom.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style_new.css') }}">

    @yield('css-extra')
</head>

<body>
    
    <div class="wrapper">

        <!-- Navbar -->
        @include('layout.navbar')
        {{-- end navbar --}}
        <div class="content-wrap">
            @yield('content')
        </div>

        @include('layout.footer')
    </div>


    <script src="https://code.jquery.com/jquery-3.6.0.min.js"
        integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    @yield('js-extra')
</body>

</html>
