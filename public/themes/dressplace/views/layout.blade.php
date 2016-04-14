@if(empty($blade_standalone) || (isset($blade_standalone) && $blade_standalone !== TRUE))
        <!DOCTYPE html>
<!--[if IE 8]>
<html lang="{{Lang::locale()}}" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]>
<html lang="{{Lang::locale()}}" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="{{Lang::locale()}}" class="no-js">
<!--<![endif]-->
<!-- BEGIN HEAD -->
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0"/>
    <title>@if(isset($pageTitle)) {{$pageTitle}} - @endif - {{$sys['title'] or ''}}</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="" name="description"/>
    <meta content="" name="author"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="shortcut icon" href="/favicon.ico"/>
    <!-- BEGIN GLOBAL MANDATORY STYLES -->

    {{--CSS--}}
    <link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" href="{{ Theme::asset('dressplace::css/bootstrap.css') }}" type="text/css" media="all"/>
    <link rel="stylesheet" href="{{ Theme::asset('dressplace::css/animate.css') }}" type="text/css" media="all"/>
    <link rel="stylesheet" href="{{ Theme::asset('dressplace::css/font-awesome.min.css') }}" type="text/css" media="all"/>
    <link rel="stylesheet" href="{{ Theme::asset('dressplace::css/chocolat.css') }}" type="text/css" media="all"/>
    <link rel="stylesheet" href="{{ Theme::asset('dressplace::css/jstarbox.css') }}" type="text/css" media="all"/>
    <link rel="stylesheet" href="{{ Theme::asset('dressplace::css/popuo-box.css') }}" type="text/css" media="all"/>
    <link rel="stylesheet" href="{{ Theme::asset('dressplace::css/jstarbox.css') }}" type="text/css" media="all"/>
    <link rel="stylesheet" href="{{ Theme::asset('dressplace::css/popuo-box.css') }}" type="text/css" media="all"/>
    <link rel="stylesheet" href="{{ Theme::asset('dressplace::css/style.css') }}" type="text/css" media="all"/>
    <link rel="stylesheet" href="{{ Theme::asset('dressplace::css/style4.css') }}" type="text/css" media="all"/>
    <link rel="stylesheet" href="{{ Theme::asset('dressplace::css/custom.css') }}" type="text/css" media="all"/>
    <link rel="stylesheet" href="{{ Theme::asset('dressplace::css/addons/slick.css') }}" type="text/css" media="all"/>
    <link rel="stylesheet" href="{{ Theme::asset('dressplace::css/flexslider.css') }}" type="text/css" media="all"/>
    <link rel="stylesheet" href="{{ Theme::asset('dressplace::css/addons/slick-theme.css') }}" type="text/css" media="all"/>
    <link rel="stylesheet" href="{{ Theme::asset('dressplace::css/addons/colorbox.css') }}" type="text/css" media="all"/>

    {{--Init jQuery--}}
    <script src="{{ Theme::asset('dressplace::js/jquery.min.js') }}" type="text/javascript"></script>

    <!-- BEGIN PAGE STYLES -->
    @if(!empty($blade_custom_css))
        @foreach($blade_custom_css as $file)
            <link href="/themes/dressplace/assets/css/{{$file}}.css" rel="stylesheet" type="text/css"/>
        @endforeach
    @endif
    <!-- END PAGE STYLES -->
</head>
<!-- END HEAD -->
<body class="loading">
<div class="loadingOverlayInit"></div>
    @if(!isset($blade_hide_header))
        @include('dressplace::includes.header')
    @endif
    <div class="clearfix"></div>

    <!-- BEGIN CONTAINER -->
    <div class="container">
        <div class="page-container">
            <!-- BEGIN CONTENT -->
            <div class="page-content-wrapper">
                <div class="page-content">
                    @yield('content')
                </div>
                <!-- END CONTENT -->
            </div>
        </div>
    </div>
<div class="clearfix"></div>
    @if(!isset($blade_hide_footer))
        @include('dressplace::includes.footer')
    @endif

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="{{ Theme::asset('dressplace::js/addons/jquery.lazy.min.js') }}" type="text/javascript"></script>
    <script src="{{ Theme::asset('dressplace::js/bootstrap.min.js') }}" type="text/javascript"></script>
    <script src="{{ Theme::asset('dressplace::js/jquery.chocolat.js') }}" type="text/javascript"></script>
    <script src="{{ Theme::asset('dressplace::js/jquery.magnific-popup.js') }}" type="text/javascript"></script>
    <script src="{{ Theme::asset('dressplace::js/jquery.flexslider-min.js') }}" type="text/javascript"></script>
    <script src="{{ Theme::asset('dressplace::js/addons/slick.min.js') }}" type="text/javascript"></script>
    <script src="{{ Theme::asset('dressplace::js/addons/loadingoverlay.min.js') }}" type="text/javascript"></script>
    <script src="{{ Theme::asset('dressplace::js/addons/jquery.bootpag.min.js') }}" type="text/javascript"></script>
    <script src="{{ Theme::asset('dressplace::js/addons/jquery.colorbox.js') }}" type="text/javascript"></script>

    <!-- MAIN APP JS -->
    <script src="{{ Theme::asset('dressplace::js/app.js') }}" type="text/javascript"></script>

    {{--Load custom libraries--}}
    @if(!empty($blade_custom_js))
        @foreach($blade_custom_js as $file)
            <script src="{{ Theme::asset('dressplace::js/' . $file . '.js')}}" type="text/javascript"></script>
        @endforeach
    @endif

    {{--Custom JS--}}
    @yield('customJS')
<!-- END JAVASCRIPTS -->
</body>
<!-- END BODY -->
</html>
@else
    @yield('content')
@endif