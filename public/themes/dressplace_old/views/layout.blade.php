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
    <title>@if(isset($page_title)){{$page_title}} - @endif{{$sys['title'] or ''}}</title>

    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="shortcut icon" href="/favicon.ico"/>
    <!-- BEGIN GLOBAL MANDATORY STYLES -->

    <meta name="description" content="{{$page_meta_description or $sys['meta_description']}}">
    <meta name="keywords" content="{{$page_meta_keywords or $sys['meta_keywords']}}">

    <meta property="og:title" content="@if(isset($page_title)) {{$page_title}} - @endif{{$sys['title'] or ''}}"/>
    <meta property="og:description" content="{{$page_meta_description or $sys['meta_description']}}" />
    <meta property="og:type" content="website"/>

    <meta name="DC.Publisher" content="{{$sys['title'] or ''}}">
    <meta name="DC.Language" content="{{Lang::locale()}}">
    <meta name="DC.Title" content="@if(isset($page_title)) {{$page_title}} - @endif{{$sys['title'] or ''}}">

    <meta name="googlebot" content="index,follow" />
    <meta name="robots" content="index,follow" />
    <meta name="revisit-after" content="1 days" />
    <meta name="slurp" content="index,follow" />

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
    <link rel="stylesheet" href="{{ Theme::asset('dressplace::js/addons/jquery-notific8/jquery.notific8.min.css') }}" type="text/css" media="all"/>

    {{--Init jQuery--}}
    <script src="{{ Theme::asset('dressplace::js/jquery.min.js') }}" type="text/javascript"></script>

    <!-- BEGIN PAGE STYLES -->
    @if(!empty($blade_custom_css))
        @foreach($blade_custom_css as $file)
            @if(!empty($file))
                <link href="/themes/dressplace/assets/css/{{$file}}.css" rel="stylesheet" type="text/css"/>
            @endif
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


{{--Added to cart Modal--}}

<div class="modal fade" tabindex="-1" role="dialog" id="item-to-cart">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="{{trans('client.close')}}"><span aria-hidden="true"><i class="fa fa-remove"></i></span></button>
                <h4 class="modal-title">{{trans('client.product_added_to_cart')}}</h4>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">{{trans('client.continue_shopping')}}</button>
                <a href="/checkout" class="btn btn-primary">{{trans('client.create_order')}}</a>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

{{--Added to cart Modal--}}

{{--Cart Modal--}}

<div class="modal fade" tabindex="-1" role="dialog" id="cart">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="{{trans('client.close')}}"><span aria-hidden="true"><i class="fa fa-remove"></i></span></button>
                <h4 class="modal-title">{{trans('client.cart')}}</h4>
            </div>
            <div class="modal-body">
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

{{--Cart Modal--}}

{{--If user - profile and orders modals--}}
@if(!empty($current_user))
    <div class="modal fade" tabindex="-1" role="dialog" id="my-profile">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="{{trans('client.close')}}"><span aria-hidden="true"><i class="fa fa-remove"></i></span></button>
                    <h4 class="modal-title">{{trans('client.my-profile')}}</h4>
                </div>
                <div class="modal-body">
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

    <div class="modal fade" tabindex="-1" role="dialog" id="my-orders">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="{{trans('client.close')}}"><span aria-hidden="true"><i class="fa fa-remove"></i></span></button>
                    <h4 class="modal-title">{{trans('client.my-orders')}}</h4>
                </div>
                <div class="modal-body">
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

    <div class="modal fade" tabindex="-1" role="dialog" id="my-order">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="{{trans('client.close')}}"><span aria-hidden="true"><i class="fa fa-remove"></i></span></button>
                    <h4 class="modal-title">{{trans('client.my-orders')}}</h4>
                </div>
                <div class="modal-body">
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
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
    <script src="{{ Theme::asset('dressplace::js/addons/jquery.elevateZoom-3.0.8.min.js') }}" type="text/javascript"></script>
    <script src="{{ Theme::asset('dressplace::js/addons/jquery-notific8/jquery.notific8.min.js') }}" type="text/javascript"></script>
    <script src="{{ Theme::asset('dressplace::js/translations/translations.js') }}" type="text/javascript"></script>

    {{--Load custom libraries--}}
    @if(!empty($blade_custom_js))
        @foreach($blade_custom_js as $file)
            <script src="{{ Theme::asset('dressplace::js/' . $file . '.js')}}" type="text/javascript"></script>
            @endforeach
            @endif

            {{--Custom JS--}}
            @yield('customJS')

                    <!-- MAIN APP JS -->
            <script src="{{ Theme::asset('dressplace::js/checkout.js') }}" type="text/javascript"></script>
            <script src="{{ Theme::asset('dressplace::js/app.js') }}" type="text/javascript"></script>
            <!-- END JAVASCRIPTS -->
</body>
<!-- END BODY -->
</html>
@else
    @yield('content')
@endif