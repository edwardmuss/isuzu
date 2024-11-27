<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'ISUZU EA') }}</title>

    <!-- Styles -->
    <link href="{{ asset('frontend/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('frontend/css/bootstrap-reset.css') }}" rel="stylesheet">
    <link href="{{ asset('frontend/assets/font-awesome/css/font-awesome.css') }}" rel="stylesheet">

    <link href="{{ asset('frontend/css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('frontend/css/style-responsive.css') }}" rel="stylesheet">
</head>
<body class="login-">
<header class="header white-bg" style="background-color: red">
    <!--logo start-->
    <a href="{{url('/')}}" class="logo">
        <img src="{{asset('frontend/img/logo_isuzu.png')}}">
    </a>
    <!--logo end-->
</header>

@yield('content')


<!-- js placed at the end of the document so the pages load faster -->
<script src="{{ asset('frontend/js/jquery.js') }}"></script>
<script src="{{ asset('frontend/js/bootstrap.min.js') }}"></script>

</body>
</html>
