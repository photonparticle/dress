@if(empty($blade_standalone) || (isset($blade_standalone) && $blade_standalone !== TRUE))
<!DOCTYPE html>
<!--[if IE 8]> <html lang="{{Lang::locale()}}" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="{{Lang::locale()}}" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="{{Lang::locale()}}" class="no-js">
<!--<![endif]-->
<!-- BEGIN HEAD -->
<head>
    <meta charset="utf-8"/>
    <title>@if(isset($pageTitle)) {{$pageTitle}} - @endif {{trans('global.administration')}} - DressPlace</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1" name="viewport"/>
    <meta content="" name="description"/>
    <meta content="" name="author"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" href="{{Theme::asset('global/css/font-awesome.min.css')}}">
    <link href="/themes/administration/assets/global/plugins/simple-line-icons/simple-line-icons.min.css" rel="stylesheet" type="text/css"/>
    <link href="/themes/administration/assets/global/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
    <link href="/themes/administration/assets/global/plugins/uniform/css/uniform.default.css" rel="stylesheet" type="text/css"/>
    <link href="/themes/administration/assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css" rel="stylesheet" type="text/css"/>
    <link href="/themes/administration/assets/global/plugins/jquery-notific8/jquery.notific8.min.css" rel="stylesheet" type="text/css"/>
    <!-- END GLOBAL MANDATORY STYLES -->
    <!-- BEGIN PAGE LEVEL PLUGIN STYLES -->
    <link href="/themes/administration/assets/global/plugins/bootstrap-daterangepicker/daterangepicker-bs3.css" rel="stylesheet" type="text/css"/>
    <link href="/themes/administration/assets/global/plugins/fullcalendar/fullcalendar.min.css" rel="stylesheet" type="text/css"/>
    <link href="/themes/administration/assets/global/plugins/jqvmap/jqvmap/jqvmap.css" rel="stylesheet" type="text/css"/>
    <!-- END PAGE LEVEL PLUGIN STYLES -->
    <!-- BEGIN PAGE STYLES -->
    @if(!empty($blade_custom_css))
        @foreach($blade_custom_css as $file)
            <link href="/themes/administration/assets/{{$file}}.css" rel="stylesheet" type="text/css"/>
        @endforeach
    @endif
    <!-- END PAGE STYLES -->
    <!-- BEGIN THEME STYLES -->
    <!-- DOC: To use 'rounded corners' style just load 'components-rounded.css' stylesheet instead of 'components.css' in the below style tag -->
    <link href="/themes/administration/assets/global/css/components-md.css" id="style_components" rel="stylesheet" type="text/css"/>
    <link href="/themes/administration/assets/global/css/plugins-md.css" rel="stylesheet" type="text/css"/>
    <link href="/themes/administration/assets/admin/layout2/css/layout.css" rel="stylesheet" type="text/css"/>
    <link href="/themes/administration/assets/admin/layout2/css/themes/grey.css" rel="stylesheet" type="text/css" id="style_color"/>
    <link href="/themes/administration/assets/admin/layout2/css/themes/grey.css" rel="stylesheet" type="text/css" id="style_color"/>
    <link href="/themes/administration/assets/custom/css/custom.css" rel="stylesheet" type="text/css"/>

    {{--Ajax loader--}}
    <link href="/themes/administration/assets/global/plugins/pace/themes/pace-theme-flash.css" rel="stylesheet" type="text/css"/>
    <script src="/themes/administration/assets/global/plugins/pace/pace.min.js" type="text/javascript"></script>
    <script src="/themes/administration/assets/global/plugins/jquery.min.js" type="text/javascript"></script>
    <script src="/themes/administration/assets/global/plugins/jquery-migrate.min.js" type="text/javascript"></script>

            <!-- END THEME STYLES -->
    <link rel="shortcut icon" href="/favicon.ico"/>
</head>
<!-- END HEAD -->
<body class="page-md page-boxed page-sidebar-closed-hide-logo page-header-fixed page-container-bg-solid">
@if(!isset($blade_clean_render))
    @if(!isset($blade_hide_header))
    @include('administration::includes.header')
    @endif
    <div class="clearfix"></div>

    <!-- BEGIN CONTAINER -->
    <div class="container">
        <div class="page-container">

            @if(!isset($blade_hide_sidebar))
                @include('administration::includes.sidebar')
            @endif

            <!-- BEGIN CONTENT -->
            <div class="page-content-wrapper">
                <div class="page-content">
                    @yield('content')
                </div>

                @if(!isset($blade_hide_quicksidebar))
{{--                    @include('administration::includes.quicksidebar');--}}
                @endif
            <!-- END CONTENT -->
            </div>

    @if(!isset($blade_hide_footer))
    @include('administration::includes.footer')
    @endif
@else
    @yield('content')
@endif
        <!-- BEGIN JAVASCRIPTS(Load javascripts at bottom, this will reduce page load time) -->
<!-- BEGIN CORE PLUGINS -->
<!--[if lt IE 9]>
<script src="/themes/administration/assets/global/plugins/respond.min.js"></script>
<script src="/themes/administration/assets/global/plugins/excanvas.min.js"></script>
<![endif]-->
<!-- IMPORTANT! Load jquery-ui.min.js before bootstrap.min.js to fix bootstrap tooltip conflict with jquery ui tooltip -->
<script src="/themes/administration/assets/global/plugins/jquery-ui/jquery-ui.min.js" type="text/javascript"></script>
<script src="/themes/administration/assets/global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
<script src="/themes/administration/assets/global/plugins/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js" type="text/javascript"></script>
<script src="/themes/administration/assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>
<script src="/themes/administration/assets/global/plugins/jquery.blockui.min.js" type="text/javascript"></script>
<script src="/themes/administration/assets/global/plugins/jquery.cokie.min.js" type="text/javascript"></script>
<script src="/themes/administration/assets/global/plugins/uniform/jquery.uniform.min.js" type="text/javascript"></script>
<script src="/themes/administration/assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js" type="text/javascript"></script>
<!-- END CORE PLUGINS -->
<!-- BEGIN PAGE LEVEL PLUGINS -->
<script src="/themes/administration/assets/global/plugins/jqvmap/jqvmap/jquery.vmap.js" type="text/javascript"></script>
<script src="/themes/administration/assets/global/plugins/jqvmap/jqvmap/maps/jquery.vmap.russia.js" type="text/javascript"></script>
<script src="/themes/administration/assets/global/plugins/jqvmap/jqvmap/maps/jquery.vmap.world.js" type="text/javascript"></script>
<script src="/themes/administration/assets/global/plugins/jqvmap/jqvmap/maps/jquery.vmap.europe.js" type="text/javascript"></script>
<script src="/themes/administration/assets/global/plugins/jqvmap/jqvmap/maps/jquery.vmap.germany.js" type="text/javascript"></script>
<script src="/themes/administration/assets/global/plugins/jqvmap/jqvmap/maps/jquery.vmap.usa.js" type="text/javascript"></script>
<script src="/themes/administration/assets/global/plugins/jqvmap/jqvmap/data/jquery.vmap.sampledata.js" type="text/javascript"></script>
<script src="/themes/administration/assets/global/plugins/flot/jquery.flot.min.js" type="text/javascript"></script>
<script src="/themes/administration/assets/global/plugins/flot/jquery.flot.resize.min.js" type="text/javascript"></script>
<script src="/themes/administration/assets/global/plugins/flot/jquery.flot.categories.min.js" type="text/javascript"></script>
<script src="/themes/administration/assets/global/plugins/jquery.pulsate.min.js" type="text/javascript"></script>
<script src="/themes/administration/assets/global/plugins/bootstrap-daterangepicker/moment.min.js" type="text/javascript"></script>
<script src="/themes/administration/assets/global/plugins/bootstrap-daterangepicker/daterangepicker.js" type="text/javascript"></script>
<script src="/themes/administration/assets/global/plugins/jquery-cookie/jquery-cookie.js" type="text/javascript"></script>
<!-- IMPORTANT! fullcalendar depends on jquery-ui.min.js for drag & drop support -->
<script src="/themes/administration/assets/global/plugins/fullcalendar/fullcalendar.min.js" type="text/javascript"></script>
<script src="/themes/administration/assets/global/plugins/jquery-easypiechart/jquery.easypiechart.min.js" type="text/javascript"></script>
<script src="/themes/administration/assets/global/plugins/jquery.sparkline.min.js" type="text/javascript"></script>
<!-- END PAGE LEVEL PLUGINS -->
<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="/themes/administration/assets/global/scripts/metronic.js" type="text/javascript"></script>
<script src="/themes/administration/assets/global/plugins/jquery-notific8/jquery.notific8.min.js" type="text/javascript"></script>
<script src="/themes/administration/assets/admin/layout2/scripts/layout.js" type="text/javascript"></script>
<script src="/themes/administration/assets/admin/pages/scripts/ui-notific8.js" type="text/javascript"></script>
<script src="/themes/administration/assets/admin/layout2/scripts/demo.js" type="text/javascript"></script>
<script src="/themes/administration/assets/custom/js/translations/translations.js" type="text/javascript"></script>
<script src="/themes/administration/assets/custom/js/translations/{{Lang::locale()}}.js" type="text/javascript"></script>
{{--<script src="/themes/administration/assets/custom/js/main.js" type="text/javascript"></script>--}}

    @if(!empty($blade_custom_js))
        @foreach($blade_custom_js as $file)
            <script src="/themes/administration/assets/{{$file}}.js" type="text/javascript"></script>
        @endforeach
    @endif

@if(!isset($blade_hide_quicksidebar))
    {{--<script src="/themes/administration/assets/admin/layout2/scripts/quick-sidebar.js" type="text/javascript"></script>--}}
@endif
<!-- END PAGE LEVEL SCRIPTS -->

<script type="text/javascript">
    jQuery(document).ready(function () {
        Metronic.init(); // init metronic core components
        Layout.init(); // init current layout
        Demo.init(); // init demo features

        //Tabs hash change and auto scroll to top
        var hash = window.location.hash;
        hash && $('ul.nav a[href="' + hash + '"]').tab('show');

        $('.nav-tabs a').click(function (e) {
            $(this).tab('show');
            var scrollmem = $('body').scrollTop();
            window.location.hash = this.hash;
            $('html,body').scrollTop(scrollmem);
        });
    });

    $('a.btn.green-haze').on('click', function (e) {
        var btn = $('.btn');
        if(btn.hasClass('disabled')) {
            e.preventDefault();
            e.stopPropagation();
            e.stopImmediatePropagation();
        } else {
            btn.addClass('disabled');
        }

        setTimeout(function () {
            btn.removeClass('disabled');
        }, 5000);

    });

    $( document ).ajaxStart(function() {
        $('button').prop('disabled', true);

        setTimeout(function() {
            $('button').prop('disabled', false);
        }, 5000);
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