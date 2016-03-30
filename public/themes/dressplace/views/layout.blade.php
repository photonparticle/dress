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
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@if(isset($pageTitle)) {{$pageTitle}} - @endif - DressPlace</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1" name="viewport"/>
    <meta content="" name="description"/>
    <meta content="" name="author"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- BEGIN GLOBAL MANDATORY STYLES -->

    {{--CSS--}}
    <link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" href="{{ Theme::asset('dressplace::css/bootstrap.css') }}" type="text/css" media="all"/>
    <link rel="stylesheet" href="{{ Theme::asset('dressplace::css/animate.css') }}" type="text/css" media="all"/>
    <link rel="stylesheet" href="{{ Theme::asset('dressplace::css/font-awesome.min.css') }}" type="text/css" media="all"/>
    <link rel="stylesheet" href="{{ Theme::asset('dressplace::css/chocolat.css') }}" type="text/css" media="all"/>
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

    <!-- BEGIN PAGE STYLES -->
    @if(!empty($blade_custom_css))
        @foreach($blade_custom_css as $file)
            <link href="/themes/dressplace/assets/css/{{$file}}.css" rel="stylesheet" type="text/css"/>
            @endforeach
            @endif
                    <!-- END PAGE STYLES -->

            <script src="{{ Theme::asset('dressplace::js/jquery.min.js') }}" type="text/javascript"></script>
            <script src="{{ Theme::asset('dressplace::js/jstarbox.js') }}" type="text/javascript"></script>
            <script src="{{ Theme::asset('dressplace::js/jquery.magnific-popup.js') }}" type="text/javascript"></script>

            <!--- start-rate---->
            <script type="text/javascript">
                jQuery(function () {
                    jQuery('.starbox').each(function () {
                        var starbox = jQuery(this);
                        starbox.starbox({
                                            average: starbox.attr('data-start-value'),
                                            changeable: starbox.hasClass('unchangeable') ? false : starbox.hasClass('clickonce') ? 'once' : true,
                                            ghosting: starbox.hasClass('ghosting'),
                                            autoUpdateAverage: starbox.hasClass('autoupdate'),
                                            buttons: starbox.hasClass('smooth') ? false : starbox.attr('data-button-count') || 5,
                                            stars: starbox.attr('data-star-count') || 5
                                        }).bind('starbox-value-changed', function (event, value) {
                            if (starbox.hasClass('random')) {
                                var val = Math.random();
                                starbox.next().text(' ' + val);
                                return val;
                            }
                        })
                    });
                });
            </script>
            <script type="application/x-javascript"> addEventListener("load", function () { setTimeout(hideURLbar, 0); }, false);
                function hideURLbar() { window.scrollTo(0, 1); } </script>
            <link rel="shortcut icon" href="/favicon.ico"/>
</head>
<!-- END HEAD -->
<body class="page-md page-boxed page-sidebar-closed-hide-logo page-header-fixed page-container-bg-solid">
@if(!isset($blade_clean_render))
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

            @if(!isset($blade_hide_footer))
            {{--    @include('dressplace::includes.footer')--}}
            @endif
                    <!--light-box-files -->
            <script type="text/javascript" charset="utf-8">
                $(function () {
                    $('a.picture').Chocolat();

                    $('.popup-with-zoom-anim').magnificPopup({
                                                                 type: 'inline',
                                                                 fixedContentPos: false,
                                                                 fixedBgPos: true,
                                                                 overflowY: 'auto',
                                                                 closeBtnInside: true,
                                                                 preloader: false,
                                                                 midClick: true,
                                                                 removalDelay: 300,
                                                                 mainClass: 'my-mfp-zoom-in'
                                                             });

                });
            </script>
            @else
                @yield('content')
            @endif

            @if(!empty($blade_custom_js))
                @foreach($blade_custom_js as $file)
                    <script src="{{ Theme::asset('dressplace::js/' . $file . '.js')}}" type="text/javascript"></script>
                    @endforeach
                    @endif


                            <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
                    <script src="{{ Theme::asset('dressplace::js/addons/loadingoverlay.min.js') }}" type="text/javascript"></script>
                    <script src="{{ Theme::asset('dressplace::js/addons/jquery.lazy.min.js') }}" type="text/javascript"></script>
                    <script src="{{ Theme::asset('dressplace::js/simpleCart.min.js') }}" type="text/javascript"></script>
                    <script src="{{ Theme::asset('dressplace::js/bootstrap.min.js') }}" type="text/javascript"></script>
                    <script src="{{ Theme::asset('dressplace::js/jquery.chocolat.js') }}" type="text/javascript"></script>
                    <script src="{{ Theme::asset('dressplace::js/jquery.magnific-popup.js') }}" type="text/javascript"></script>
                    <script src="{{ Theme::asset('dressplace::js/jquery.flexslider-min.js') }}" type="text/javascript"></script>
                    <script src="{{ Theme::asset('dressplace::js/addons/slick.min.js') }}" type="text/javascript"></script>
                    <!-- END PAGE LEVEL SCRIPTS -->

                    <script type="text/javascript">
                        $.LoadingOverlaySetup({
                                                  color: "rgba(255, 255, 255, 1.0)",
                                                  image: "{{Theme::asset('dressplace::images/loading.gif')}}",
                                                  maxSize: "80px",
                                                  minSize: "20px",
                                                  resizeInterval: 0,
                                                  size: "50%"
                                              });
                        $(window).load(function () {
//                            $.LoadingOverlay("show");
                        });

                        $(document).ready(function () {
                            // Hide it after 1 seconds
//                            setTimeout(function(){
//                                $.LoadingOverlay("hide");
//                            }, 1000);

                            $('.lazy').Lazy({
                                                threshold: 200,
                                                effect : "fadeIn",
                                                visibleOnly: true,
                                                onError: function(element) {
                                                    console.log('error loading ' + element.data('src'));
                                                }
                                            });
                        });

                        $(document).ajaxStart(function () {
                            $.LoadingOverlay("show");
                        });
                        $(document).ajaxStop(function () {
                            $.LoadingOverlay("hide");
                        });
                    </script>
                    @yield('customJS')
                            <!-- END JAVASCRIPTS -->
        </div>
    </div>
</body>
<!-- END BODY -->
</html>
@else
    @yield('content')
@endif