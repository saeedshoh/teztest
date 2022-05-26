<!doctype html>
<html lang="en">

    <head>
        <meta charset="utf-8" />
        <title> @yield('title') </title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta content="Tcell" name="description" />
        <meta content="Tcell" name="author" />
        <link rel="shortcut icon" href="{{ URL::asset('assets/images/favicon.png')}}">
        @include('layouts.head')
  </head>

    @yield('body')
    <div id="preloader">
        <div id="status">
            <div class="spinner-chase">
                <div class="chase-dot"></div>
                <div class="chase-dot"></div>
                <div class="chase-dot"></div>
                <div class="chase-dot"></div>
                <div class="chase-dot"></div>
                <div class="chase-dot"></div>
            </div>
        </div>
    </div>
    @yield('content')

    @include('flash::message')
    @include('layouts.footer-script')

    </body>
</html>
