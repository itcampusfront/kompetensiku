<!DOCTYPE HTML>
<html lang="en">
  <head>
    @include('template._head')
    @yield('css-extra')
	<title>@yield('title') {{ setting('site.name') }} &#8211; {{ setting('site.tagline') }}</title>
</head>

<body>
    <!--[if lte IE 9]>
            <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="https://browsehappy.com/">upgrade your browser</a> to improve your experience and security.</p>
        <![endif]-->

    @include('template._header')

    @yield('content')

    @include('template._footer')

    @include('template._js')

    @yield('js-extra')
</body>

</html>