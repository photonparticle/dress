@extends('administration::layout')

@section('content')
        <!-- BEGIN SIDEBAR TOGGLER BUTTON -->
<div class="menu-toggler sidebar-toggler">
</div>
<!-- END SIDEBAR TOGGLER BUTTON -->
<!-- BEGIN LOGO -->
<div class="logo">
    <a href="/">
        <img src="/images/logo.png" alt="" style="width:300px"/>
    </a>
</div>
<!-- END LOGO -->
<!-- BEGIN LOGIN -->
<div class="content">
    <!-- BEGIN LOGIN FORM -->
    <form class="login-form">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <h3 class="form-title">{{trans('users.login')}}</h3>
        <div class="alert alert-danger display-hide">
            <button class="close" data-close="alert"></button>
			<span>
			{{trans('users.login_tip')}} </span>
        </div>
        <div class="form-group">
            <!--ie8, ie9 does not support html5 placeholder, so we just show field title for that-->
            <label class="control-label visible-ie8 visible-ie9">E-mail</label>
            <input class="form-control form-control-solid placeholder-no-fix" type="text" autocomplete="off" placeholder="E-mail" name="email"/>
        </div>
        <div class="form-group">
            <label class="control-label visible-ie8 visible-ie9">{{trans('users.password')}}</label>
            <input class="form-control form-control-solid placeholder-no-fix" type="password" autocomplete="off" placeholder="{{trans('users.password')}}" name="password"/>
        </div>
        <div class="form-actions">
            <button id="doSubmit" type="submit" class="btn btn-success uppercase">{{trans('users.login')}}</button>
            <label class="rememberme check">
                <input type="checkbox" name="remember" value="1"/>{{trans('users.remember_me')}}</label>
            <a href="javascript:;" id="forget-password" class="forget-password">{{trans('users.forgotten_password')}}</a>
        </div>
    </form>
    <!-- END LOGIN FORM -->
    <!-- BEGIN FORGOT PASSWORD FORM -->
    <form class="forget-form" action="index.html" method="post">
        <h3>{{trans('users.forgotten_password')}}</h3>
        <p>
            {{trans('users.forgotten_password_tip')}}
        </p>
        <div class="form-group">
            <input class="form-control placeholder-no-fix" type="text" autocomplete="off" placeholder="Email" name="email"/>
        </div>
        <div class="form-actions">
            <button type="button" id="back-btn" class="btn btn-default">{{trans('global.back')}}</button>
            <button type="submit" class="btn btn-success uppercase pull-right">{{trans('global.submit')}}</button>
        </div>
    </form>
    <!-- END FORGOT PASSWORD FORM -->
</div>
<div class="copyright">
    {{date('Y')}} © DressPlace
</div>
<!-- END LOGIN -->
@endsection

@section('customJS')
    <script type="text/javascript">
        $('body').attr('class', 'page-md login');

        jQuery(document).ready(function () {
            Metronic.init(); // init metronic core components
            Layout.init(); // init current layout
            Login.init();
            Demo.init();
        });
    </script>
@endsection