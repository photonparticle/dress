@extends('dressplace::layout')

@section('content')

    @if(!isset($ajax))
        <div class="container">
            @endif
            <div class="col-xs-12">
                <div class="section-title text-center">
                    <h1 class="no-margin">
                        {{trans('client.contact_us')}}
                    </h1>
                </div>
            </div>
            <div class="clearfix"></div>
            @if(!isset($ajax))
        </div>
    @endif

    @if(!isset($ajax))
        <div class="container col-xs-12">
        @endif

        <!-- contact-area start -->
            <div class="contact-area">
                <div class="container">
                    <div class="row">
                        <div class="col-md-6 col-sm-12 col-xs-12">
                            <div class="contact-form">
                                <h3><i class="fa fa-envelope-o"></i> {{trans('client.pm_us')}}</h3>
                                <div class="row">
                                    <form id="contact_form" action="/contact" method="POST">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <input name="name" type="text" placeholder="{{trans('client.names')}}"/>
                                        </div>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <input name="email" type="email" placeholder="Email"/>
                                        </div>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <input name="phone" type="text" placeholder="{{trans('client.phone')}}"/>
                                        </div>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <input name="subject" type="text" placeholder="{{trans('client.subject')}}"/>
                                        </div>
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <textarea name="message" id="message" cols="30" rows="10" placeholder="{{trans('client.message')}}"></textarea>
                                            <input id="contact_submit" type="submit" value="{{trans('client.send_request')}}"/>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <!-- contact-info start -->
                        <div class="col-md-6 col-sm-12 col-xs-12">
                            <div class="contact-info">
                                <h3>{{trans('client.contact_info')}}</h3>
                                <ul>
                                    @if(!empty($sys['phone']))
                                        <li>
                                            <i class="fa fa-mobile fa-envelope"></i> <strong>{{trans('client.phone')}}</strong>
                                            {{$sys['phone']}}
                                        </li>
                                    @endif
                                    @if(!empty($sys['email']))
                                        <li>
                                            <i class="fa fa-envelope"></i> <strong>Email:</strong>
                                            <a href="#">{{$sys['email']}}</a>
                                        </li>
                                    @endif
                                    <li>
                                        <i class="fa fa-clock-o"></i> <strong>{{trans('client.work_time')}}</strong>
                                        <div class="work_time">
                                            {!! $sys['work_time'] !!}
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <!-- contact-info end -->
                    </div>
                </div>
            </div>
            <!-- contact-area end -->

            @if(!isset($ajax))
        </div>
    @endif
@endsection

@section('customJS')
    <script type="text/javascript">
        jQuery(document).ready(function () {
            $('#contact_form').submit(function (e) {
                e.preventDefault();
                e.stopPropagation();
                e.stopImmediatePropagation();

                $.ajax({
                           type: 'post',
                           url: $('#contact_form').attr('action'),
                           data: $('#contact_form').serialize(),
                           success: function (response) {
                               if (typeof response == typeof {} && typeof response['status'] !== typeof undefined && typeof response['message'] !== typeof undefined) {
                                   if (response['status'] == 'success') {
                                       $('#contact_submit').attr('disabled', 'disabled');
                                       setTimeout(function () {
                                           window.location.href = "/contact";
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