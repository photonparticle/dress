@extends('dressplace::layout')

@section('content')
    @if(!isset($ajax))
        <div class="container col-xs-12">
            @endif

            <h1 class="text-center">{{trans('client.contact_us')}}</h1>

            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                <form id="contact_form" method="POST" action="/contact">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input name="email" type="email" class="form-control" id="email" placeholder="Email">
                            </div>
                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <div class="form-group">
                                <label for="name">{{trans('client.names')}}</label>
                                <input name="name" type="text" class="form-control" id="name" placeholder="{{trans('client.names')}}">
                            </div>
                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <div class="form-group">
                                <label for="phone">{{trans('client.phone')}}</label>
                                <input name="phone" type="text" class="form-control" id="phone" placeholder="{{trans('client.phone')}}">
                            </div>
                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <div class="form-group">
                                <label for="subject">{{trans('client.subject')}}</label>
                                <input name="subject" type="text" class="form-control" id="subject" placeholder="{{trans('client.subject')}}">
                            </div>
                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <div class="form-group">
                                <label for="message">{{trans('client.message')}}</label>
                                <textarea class="form-control" id="message" name="message" placeholder="{{trans('client.message')}}"></textarea>
                            </div>
                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <button
                                    type="submit"
                                    id="do_contact"
                                    class="btn btn-primary pull-left"
                            >
                                <i class="fa fa-envelope-o" aria-hidden="true"></i>
                                {{trans('client.send_request')}}
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                @if(!empty($sys['work_time']))
                    <h3 class="text-center margin-20">{{trans('client.work_time')}}</h3>
                    <div class="col-xs-12 text-center">
                        {!! $sys['work_time'] !!}
                    </div>
                @endif
                <div class="clearfix"></div>
                @if(!empty($sys['phone']))
                    <h3 class="text-center margin-20">{{trans('client.contact_us_phone')}}</h3>
                    <div class="col-xs-12 call_us text-center">
                        <div>
                            <i class="fa fa-mobile"></i>
                        </div>
                        <div>
                            <span>{{trans('client.calls_work_time')}}</span><br/>
                            <span>{{trans('client.calls_work_time_2')}}</span><br/>
                            <span>{{$sys['phone']}}</span>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                @endif
                <div class="clearfix"></div>
            </div>

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