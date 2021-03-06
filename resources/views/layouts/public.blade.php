<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <title>Progetto | @yield('title', 'Sito')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <link href="{{asset('css/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{asset('css/themes/css/main.css')}}" rel="stylesheet" />
    <link href="{{asset('css/bootstrap/css/bootstrap-responsive.min.css')}}" rel="stylesheet">
    <link href="{{asset('css/themes/css/bootstrappage.css')}}" rel="stylesheet" />
    <link href="{{asset('css/themes/css/flexslider.css')}}" rel="stylesheet" />
    <script src="{{asset('css/themes/js/jquery-3.6.0.min.js')}}"></script>
    <script src="{{asset('css/bootstrap/js/bootstrap.min.js')}} "></script>
    @yield('scripts')
</head>

<body>
    @include('layouts/header')
    <div id="wrapper" class="container">
        @include('layouts/navbar')
        @yield('content')
        @include('layouts/footer')
    </div>
</body>

</html>
