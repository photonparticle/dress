@extends('dressplace::layout')

@section('content')

    @if(!isset($ajax))
        <div class="container">
            @endif
            <div class="col-xs-12">
                <div class="section-title text-center">
                    <h1 class="no-margin">
                        {{trans('client.login')}}
                    </h1>
                </div>
            </div>
            <div class="clearfix"></div>
            @if(!isset($ajax))
        </div>
    @endif

    @if(!isset($ajax))
        <div class="container col-xs-12 col-sm-12 col-md-8 col-md-offset-2 col-lg-6 col-lg-offset-3">
            @endif

            <form id="login_form" method="POST" action="/login">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input name="email" type="email" class="form-control cForm" id="email" placeholder="Email">
                        </div>
                    </div>

                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="form-group">
                            <label for="password">{{trans('client.password')}}</label>
                            <input name="password" type="password" class="form-control cForm" id="password" placeholder="{{trans('client.password')}}">
                        </div>
                    </div>

                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" name="remember_me" id="remember_me">
                                {{trans('client.remember_me')}}
                            </label>
                        </div>
                    </div>


                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <button
                                type="submit"
                                id="do_login"
                                class="btn btn-primary pull-left"
                        >
                            <i class="fa fa-key"></i>
                            {{trans('client.login')}}
                        </button>
                        <a
                                class="btn btn-default pull-right"
                                href="/register"
                        >
                            {{trans('client.register')}}
                        </a>
                    </div>
                </div>
            </form>

            @if(!isset($ajax))
        </div>
    @endif
@endsection

@section('customJS')
    <script type="text/javascript">
        jQuery(document).ready(function () {
            $('#do_login').on('click', function (e) {
                e.preventDefault();
                e.stopPropagation();
                e.stopImmediatePropagation();

                $.ajax({
                           type: 'post',
                           url: $('#login_form').attr('action'),
                           data: $('#login_form').serialize(),
                           success: function (data) {
                               var response = jQuery.parseJSON(data);

                               if (typeof response == typeof {} && response['status'] && response['message'] && response['title']) {
                                   if (response['status'] == 'success') {
                                       $('#do_login').attr('disabled', 'disabled');
                                       setTimeout(function () {
                                           window.location.href = "/";
                                       }, 3000);
                                   }

                                   showNotification(response['status'], response['title'], response['message']);
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