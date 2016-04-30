@extends('dressplace::layout')

@section('content')
    @if(!isset($ajax))
        <div class="container col-xs-12 col-sm-12 col-md-8 col-md-offset-2 col-lg-6 col-lg-offset-3">
            @endif

            <h1 class="text-center">{{trans('client.register')}}</h1>

            <form id="register_form" method="POST" action="/register">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input name="email" type="email" class="form-control" id="email" placeholder="Email">
                        </div>
                    </div>

                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="form-group">
                            <label for="password">{{trans('client.password')}}</label>
                            <input name="password" type="password" class="form-control" id="password" placeholder="{{trans('client.password')}}">
                        </div>
                    </div>


                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <button
                                type="submit"
                                id="do_register"
                                class="btn btn-primary pull-left"
                        >
                            <i class="fa fa-key"></i>
                            {{trans('client.register')}}
                        </button>
                        <a
                                class="btn btn-default pull-right"
                                href="/login"
                        >
                            <i class="fa fa-key"></i>
                            {{trans('client.login')}}
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
            $('#do_register').on('click', function (e) {
                e.preventDefault();
                e.stopPropagation();
                e.stopImmediatePropagation();

                $.ajax({
                           type: 'post',
                           url: $('#register_form').attr('action'),
                           data: $('#register_form').serialize(),
                           success: function (data) {
                               var response = jQuery.parseJSON(data);

                               if (typeof response == typeof {} && response['status'] && response['message']) {
                                   if (response['status'] == 'success') {
                                       $('#do_register').attr('disabled', 'disabled');
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