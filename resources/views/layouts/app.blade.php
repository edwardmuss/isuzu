<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Isuzu') }}</title>

    <!-- Styles -->
    <link href="{{ asset('frontend/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('frontend/css/bootstrap-reset.css') }}" rel="stylesheet">
    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">    
    <link href="{{ asset('frontend/css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('frontend/css/style-responsive.css') }}" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.css" />
    @yield('css')

    <script type="text/javascript">
        var BASE_URL = {!! json_encode(url('/')) !!}
    </script>
</head>
<body style="color: black">
<div id="app">
    <!--header start-->
    <header class="header white-bg" style="background-color: #FF0000">
        <div class="sidebar-toggle-box" style="margin-top: 20px;">
            <div class="fa fa-bars tooltips" data-placement="right" data-original-title="Toggle Navigation"></div>
        </div>
        <!--logo start-->
        <a href="{{url('/')}}" class="logo">
            <img src="{{asset('frontend/img/logo_isuzu.png')}}">
        </a>
        <!--logo end-->

        <div class="top-nav ">
            <!--search & user info start-->
            <ul class="nav pull-right top-menu">

                <!-- user login dropdown start-->
                <li class="dropdown">
                    <a data-toggle="dropdown" href="changepas.php?lang=en" class="glyphicons logout lock"><span
                                class="hidden-phone text"></span><i></i>
                        <img alt="" src="frontend/img/user-avatar-main-picture.png" height="28" width="28">
                        <b class="caret"></b>
                    </a>
                    <ul class="dropdown-menu extended logout">
                        <div class="log-arrow-up"></div>

                        <li>
                            <a class="dropdown-item" href="{{ route('logout') }}"
                               onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                Logout
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </li>
                    </ul>
                </li>
                <!-- user login dropdown end -->
            </ul>
            <!--search & user info end-->
        </div>
    </header>
    <!--header end-->
    <!--sidebar start-->
    <aside style="padding-top: 10px;">
        <div id="sidebar" class="nav-collapse ">
            <!-- sidebar menu start-->
            <ul class="sidebar-menu" id="nav-accordion">
                <li>
                    <a class="{{ isset($index) ? 'active':null }}" href="{{url('/')}}">
                        <i class="fa fa-dashboard"></i>
                        <span>DASHBOARD</span>
                    </a>
                </li>
                <li>
                    <a class="{{ isset($ussd_users) ? 'active':null }}" href="{{route('ussd-users.index')}}">
                        <i class="fa fa-users"></i>
                        <span>USSD USERS</span>
                    </a>
                </li>
                <li>
                    <a class="{{ request()->routeIs('vehicle-series*') ? 'active':null }}" href="{{route('vehicle-series.index')}}">
                        <i class="fa fa-truck"></i>
                        <span>VEHICLE SERIES</span>
                    </a>
                </li>
                <li>
                    <a class="{{ isset($vehicle_sales) ? 'active':null }}" href="{{route('vehicle-sales.index')}}">
                        <i class="fa fa-truck"></i>
                        <span>VEHICLE SALES</span>
                    </a>
                </li>
                <li>
                    <a class="{{ isset($service) ? 'active':null }}" href="{{route('service.index')}}">
                        <i class="fa fa-wrench"></i>
                        <span>SERVICE</span>
                    </a>
                </li>

                <li>
                    <a class="{{ isset($parts) ? 'active':null }}" href="{{route('parts.index')}}">
                        <i class="fa fa-sliders"></i>
                        <span>PARTS</span>
                    </a>
                </li>
                <li>
                    <a class="{{ isset($test_drives) ? 'active':null }}" href="{{route('test-drives.index')}}">
                        <i class="fa fa-car"></i>
                        <span>TEST DRIVES</span>
                    </a>
                </li>
                <li class="sub-menu">
                    <a href="javascript:;" >
                        <i class="fa fa-building-o"></i>
                        <span>CONTACT REQUESTS</span>
                    </a>
                    <ul class="sub">
                        <li style="padding-left: 0px">
                            <a  style="margin-top: 0px;text-align: center" class="{{ isset($locate_dealer) ? 'active':null }}" href="{{route('contact-request.index')}}">
                                <i class="fa fa-comments"></i> CONTACT REQUESTS
                            </a>
                        </li>
                        <li style="padding-left: 0px">
                            <a  style="margin-top: 0px;text-align: center" class="{{ isset($locate_dealer) ? 'active':null }}" href="{{route('locate-dealer.index')}}">
                                <i class="fa fa-map-marker"></i> LOCATE A DEALER
                            </a>
                        </li>
                        <li style="padding-left: 0px">
                            <a  style="margin-top: 0px;text-align: center" class="{{ isset($tech_assistance) ? 'active':null }}" href="{{route('technical-assistance.index')}}">
                                <i class="fa fa-cogs"></i> TECHNICAL ASSISTANCE
                            </a>
                        </li>
                    </ul>
                </li>

                <li>
                    <a class="{{ isset($brochure) ? 'active':null }}" href="{{route('brochure.index')}}">
                        <i class="fa fa-file-pdf-o"></i>
                        <span>BROCHURE REQUESTS</span>
                    </a>
                </li>

                <li>
                    <a class="{{ isset($psv_awards) ? 'active':null }}" href="{{route('psv-awards.index')}}">
                        <i class="fa fa-trophy"></i>
                        <span>PSV AWARDS</span>
                    </a>
                </li>
                <li>
                    <a class="{{ isset($offers) ? 'active':null }}" href="{{route('offers.index')}}">
                        <i class="fa fa-gift"></i>
                        <span>OFFERS</span>
                    </a>
                </li>


            </ul>
            <!-- sidebar menu end-->
        </div>
    </aside>
    <!--sidebar end-->
    <!--main content start-->
    <section id="main-content">
        <section class="wrapper">
            @if (session('status'))
                <div class="alert alert-success">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <strong>Success!</strong> <br>
                    {{ session('status') }}
                </div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <strong>Warning!</strong> <br>
                    {{ session('error') }}
                </div>
            @endif
            @if (count($errors) > 0)
                <div class="alert alert-danger">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
                <div class="col-md-12" style="margin-top: 10px">
                    @yield('content')
                </div>
        </section>
        <!--footer start-->
        <footer class="site-footer" style="background-color: #F30000; padding-left: 10px;padding-right: 10px;margin-top: 0px">
            <div class="">
               <b> &copy; Isuzu East Africa | {{date('Y')}}.</b>
                <b class="pull-right">Launched in February, 2016</b>
            </div>
        </footer>
        <!--footer end-->

    </section>
    <!--main content end-->
</div>

<!-- Scripts -->
<script type="text/javascript" language="javascript" src="{{ asset('frontend/assets/advanced-datatable/media/js/jquery.js') }}"></script>
<script src="{{ asset('frontend/js/bootstrap.min.js') }}"></script>
<script class="include" src="{{ asset('frontend/js/jquery.dcjqaccordion.2.7.js') }}"></script>
<script src="{{ asset('frontend/js/jquery.scrollTo.min.js') }}"></script>
<script src="{{ asset('frontend/js/jquery.nicescroll.js') }}"></script>

<script src="{{ asset('frontend/js/respond.min.js') }}"></script>
<script src="{{ asset('frontend/js/common-scripts.js') }}"></script>
<script type="text/javascript" src="//cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.js"></script>
@yield('js')

</body>
</html>
