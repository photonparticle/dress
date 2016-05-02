@if(empty($blade_standalone) || (isset($blade_standalone) && $blade_standalone !== TRUE))
        <!DOCTYPE html>
<html class="no-js" lang="">
<head>
    <meta charset="utf-8"/>
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>@if(isset($page_title)){{$page_title}} | @else{{$sys['page_title'] or ''}}@endif | {{$sys['title']}}</title>

    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="shortcut icon" type="image/x-icon" href="favicon.png">
    <!-- BEGIN GLOBAL MANDATORY STYLES -->

    <meta name="description" content="{{$page_meta_description or $sys['meta_description']}}">
    <meta name="keywords" content="{{$page_meta_keywords or $sys['meta_keywords']}}">

    <meta property="og:title" content="@if(isset($page_title)) {{$page_title}} - @endif{{$sys['title'] or ''}}"/>
    <meta property="og:description" content="{{$page_meta_description or $sys['meta_description']}}"/>
    <meta property="og:type" content="website"/>

    <meta name="DC.Publisher" content="{{$sys['title'] or ''}}">
    <meta name="DC.Language" content="{{Lang::locale()}}">
    <meta name="DC.Title" content="@if(isset($page_title)) {{$page_title}} - @endif{{$sys['title'] or ''}}">

    <meta name="googlebot" content="index,follow"/>
    <meta name="robots" content="index,follow"/>
    <meta name="revisit-after" content="1 days"/>
    <meta name="slurp" content="index,follow"/>

    <!-- google fonts -->
    <link href='https://fonts.googleapis.com/css?family=Lato:400,900,700,300' rel='stylesheet' type='text/css'>


    <!-- all css here -->
    <!-- bootstrap v3.3.6 css -->
    <link rel="stylesheet" href="{{ Theme::asset('dressplace::css/bootstrap.min.css') }}">
    <!-- animate css -->
    <link rel="stylesheet" href="{{ Theme::asset('dressplace::css/animate.css') }}">
    <!-- jquery-ui.min css -->
    <link rel="stylesheet" href="{{ Theme::asset('dressplace::css/jquery-ui.min.css') }}">
    <!-- meanmenu css -->
    <link rel="stylesheet" href="{{ Theme::asset('dressplace::css/meanmenu.min.css') }}">
    <!-- RS slider css -->
    <link rel="stylesheet" type="text/css" href="{{ Theme::asset('dressplace::rs-plugin/css/settings.css')}}" media="screen">
    <!-- owl.carousel css -->
    <link rel="stylesheet" href="{{ Theme::asset('dressplace::css/owl.carousel.css') }}">
    <!-- font-awesome css -->
    <link rel="stylesheet" href="{{ Theme::asset('dressplace::css/font-awesome.min.css') }}">
    <!-- style css -->
    <link rel="stylesheet" href="{{ Theme::asset('dressplace::css/style.css') }}">
    <!-- responsive css -->
    <link rel="stylesheet" href="{{ Theme::asset('dressplace::css/responsive.css') }}">
    <link rel="stylesheet" href="{{ Theme::asset('dressplace::css/custom.css') }}">
    <link rel="stylesheet" href="{{ Theme::asset('dressplace::css/flexslider.css') }}" type="text/css" media="all"/>
    <link rel="stylesheet" href="{{ Theme::asset('dressplace::css/colorbox.css') }}" type="text/css" media="all"/>
    <link rel="stylesheet" href="{{ Theme::asset('dressplace::css/jquery.notific8.min.css') }}" type="text/css" media="all"/>

    <!-- modernizr css -->
    <script src="{{ Theme::asset('dressplace::js/vendor/modernizr-2.8.3.min.js') }}"></script>

    <!-- BEGIN PAGE STYLES -->
    @if(!empty($blade_custom_css))
        @foreach($blade_custom_css as $file)
            @if(!empty($file))
                <link href="{{ Theme::asset('dressplace::css/' . $file . '.css') }}" rel="stylesheet" type="text/css"/>
                @endif
                @endforeach
                @endif
                        <!-- END PAGE STYLES -->
</head>
<!-- END HEAD -->
<body>
@if(!isset($blade_hide_header))
    @include('dressplace::includes.header')
@endif
<div class="clearfix"></div>

@yield('content')

<div class="clearfix"></div>
@if(!isset($blade_hide_footer))
    @include('dressplace::includes.footer')
@endif

{{--QUICK BUY MODAL--}}
<div class="modal fade bs-example-modal-lg" id="quick_buy_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
{{--QUICK BUY MODAL--}}

{{--ADDED TO CART MODAL--}}
<div class="modal fade bs-example-modal-lg" id="item_to_cart" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
{{--ADDED TO CART MODAL--}}

        <!-- all js here -->
<!-- jquery latest version -->
<script type="text/javascript" src="{{ Theme::asset('dressplace::js/vendor/jquery-1.12.0.min.js') }}"></script>
<!-- bootstrap js -->
<script type="text/javascript" src="{{ Theme::asset('dressplace::js/bootstrap.min.js') }}"></script>
<!-- owl.carousel js -->
<script type="text/javascript" src="{{ Theme::asset('dressplace::js/owl.carousel.min.js') }}"></script>
<!-- jquery-ui js -->
<script type="text/javascript" src="{{ Theme::asset('dressplace::js/jquery-ui.min.js') }}"></script>
<!-- RS-Plugin JS -->
<script type="text/javascript" src="{{ Theme::asset('dressplace::rs-plugin/js/jquery.themepunch.tools.min.js') }}"></script>
<script type="text/javascript" src="{{ Theme::asset('dressplace::rs-plugin/js/jquery.themepunch.revolution.min.js') }}"></script>
<script type="text/javascript" src="{{ Theme::asset('dressplace::rs-plugin/rs.home.js') }}"></script>
<!-- meanmenu js -->
<script type="text/javascript" src="{{ Theme::asset('dressplace::js/jquery.meanmenu.js') }}"></script>
<!-- bootpag js -->
<script type="text/javascript" src="{{ Theme::asset('dressplace::js/jquery.bootpag.min.js') }}"></script>
<!-- wow js -->
<script type="text/javascript" src="{{ Theme::asset('dressplace::js/wow.min.js') }}"></script>
<!-- plugins js -->
<script type="text/javascript" src="{{ Theme::asset('dressplace::js/plugins.js') }}"></script>

<script src="{{ Theme::asset('dressplace::js/translations/translations.js') }}" type="text/javascript"></script>
<script src="{{ Theme::asset('dressplace::js/jquery.notific8.min.js') }}" type="text/javascript"></script>
<script src="{{ Theme::asset('dressplace::js/jquery.flexslider-min.js') }}" type="text/javascript"></script>
<script src="{{ Theme::asset('dressplace::js/jquery.colorbox.js') }}" type="text/javascript"></script>
<script src="{{ Theme::asset('dressplace::js/jquery.elevateZoom-3.0.8.min.js') }}" type="text/javascript"></script>

<!-- main js -->
<script type="text/javascript" src="{{ Theme::asset('dressplace::js/main.js') }}"></script>
<!-- app js -->
<script src="{{ Theme::asset('dressplace::js/checkout.js') }}" type="text/javascript"></script>
<script type="text/javascript" src="{{ Theme::asset('dressplace::js/app.js') }}"></script>

{{--Load custom libraries--}}
@if(!empty($blade_custom_js))
    @foreach($blade_custom_js as $file)
        <script src="{{ Theme::asset('dressplace::js/' . $file . '.js')}}" type="text/javascript"></script>
    @endforeach
@endif

{{--Custom JS--}}
@yield('customJS')


</body>
</html>
@else
    @yield('content')
@endif