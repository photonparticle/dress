@extends('administration::layout')

@section('content')
        <!-- BEGIN EXAMPLE TABLE PORTLET-->
<div class="page-content">
    <!-- BEGIN SAMPLE FORM PORTLET-->
    <div class="portlet light">
        <div class="portlet-title">
            <div class="caption font-green-haze">
                <i class="fa fa-user-plus"></i>
                <span class="caption-subject bold uppercase"> {{$pageTitle}}</span>
            </div>
            <div class="actions">
                <a class="btn btn-circle btn-icon-only btn-default fullscreen" href="#" data-original-title="" title="">
                </a>
            </div>
        </div>
        <div class="portlet-body form">
            <div class="col-lg-12">
                @if(isset($error))
                    <div class="alert alert-danger">
                        {{$error}}
                    </div>
                @endif
            </div>
            <form id="register_form" class="form-horizontal">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <div class="form-group form-md-line-input">
                    <label class="col-md-2 control-label" for="form_control_1">Email</label>
                    <div class="col-md-10">
                        <input type="text" class="form-control" id="email" name="email" placeholder="Email">
                        <div class="form-control-focus">
                        </div>
                        <span class="help-block">example@mail.com</span>
                    </div>
                </div>
                <div class="form-group form-md-line-input">
                    <label class="col-md-2 control-label" for="form_control_1">{{trans('users.password')}}</label>
                    <div class="col-md-10">
                        <input type="password" class="form-control" id="password" name="password" placeholder="{{trans('users.password')}}">
                        <div class="form-control-focus">
                        </div>
                        <span class="help-block">{{trans('users.minsymb')}}</span>
                    </div>
                </div>

                <div class="form-actions">
                    <div class="row">
                        <div class="col-md-offset-2 col-md-10">
                            <button type="button" class="btn default">{{trans('users.cancel')}}</button>
                            <button id="register" type="button" class="btn green">{{trans('users.register')}}</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>

    </div>
</div>
<!-- END EXAMPLE TABLE PORTLET-->
@endsection

@section('customJS')
    <script type="text/javascript">
        jQuery(document).ready(function () {
            Metronic.init(); // init metronic core components
            Layout.init(); // init current layout
            Demo.init(); // init demo features

            $('#register').click(function (e) {
                e.preventDefault();

                $.ajax({
                   type: 'post',
                   url: '/admin/users/store',
                   data: $('#register_form').serialize(),
                   headers: {
                       'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                   },
                   success: function (response) {
                       if(typeof response == typeof {} && response['status'] && response['message']) {
                           showNotification(response['status'], response['message']);
                       } else {
                           showNotification('error', translate('request_not_completed'), translate('contact_support'));
                       }
                   },
                   error: function () {
                       showNotification('error', translate('request_not_completed'), translate('contact_support'));
                   }

               });
           });
        });
    </script>
@endsection