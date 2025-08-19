<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield("title", "E-Commerce")</title>
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet">
    @yield("style")
  </head>
  <body>
    @include("includes.header")
    @yield("content")
    @include("includes.footer")
    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
    @yield("script")
  </body>
</html