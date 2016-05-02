@extends('dressplace::layout')

@section('content')
    <div class="container">
        <div class="col-xs-12">
            <div class="section-title text-center no-margin-bottom">
                <h1 class="no-margin">
                    {{trans('client.order')}}
                </h1>
            </div>
        </div>
        <div class="clearfix"></div>
    </div>

    @if(empty($current_user))
        <div class="container margin-top-20">
            <div class="col-xs-12 no-padding">
                <h4>{{trans('client.checkout_login_tip_1')}}</h4>
                <p>
                    {{trans('client.checkout_login_tip_2')}}
                </p>

                <form id="login_form" method="POST" action="/login">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 no-padding">
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input name="email" type="email" class="form-control cForm" id="email" placeholder="Email">
                            </div>
                        </div>

                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
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
                                    class="btn btn-primary"
                            >
                                {{trans('client.login')}}
                            </button>
                            <a
                                    class="btn btn-default"
                                    href="/register"
                            >
                                {{trans('client.register')}}
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    @endif

    <div class="container check-out">
        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
            <h3 class="text-center">
                {{trans('client.info_order')}}
            </h3>
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" class="form-control cForm" name="email" id="email" placeholder="Email" value="{{$current_user['email'] or ''}}">
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="form-group">
                    <label for="name">{{trans('client.name')}}</label>
                    <input type="text" class="form-control cForm" id="name" name="name" placeholder="{{trans('client.name')}}" value="{{$current_user['first_name'] or ''}}">
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="form-group">
                    <label for="last_name">{{trans('client.last_name')}}</label>
                    <input type="text" class="form-control cForm" id="last_name" name="last_name" placeholder="{{trans('client.last_name')}}" value="{{$current_user['last_name'] or ''}}">
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="form-group">
                    <label for="phone">{{trans('client.phone')}}</label>
                    <input type="text" class="form-control cForm" id="phone" name="phone" placeholder="{{trans('client.phone')}}" value="{{$current_user['phone'] or ''}}">
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="form-group">
                    <label for="address">{{trans('client.address')}}</label>
                    <input type="text" class="form-control cForm" id="address" name="address" placeholder="{{trans('client.address')}}" value="{{$current_user['address'] or ''}}">
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="form-group">
                    <label for="city">{{trans('client.city')}}</label>
                    <input type="text" class="form-control cForm" id="city" name="city" placeholder="{{trans('client.city')}}" value="{{$current_user['city'] or ''}}">
                </div>
            </div>

            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <label for="state" class="control-label default">
                    {{trans('orders.state')}}
                </label>
                <select id="state" name="state" class="form-control cForm input-md" data-placeholder="{{trans('orders.select_state')}}">
                    <option value="">{{trans('orders.select_state')}}</option>
                    @if(isset($states) && is_array($states))
                        @foreach($states as $key => $state)
                            <option value="{{$key}}" @if(!empty($current_user['state']) && $key == $current_user['state']) selected="selected" @endif>{{$state}}</option>
                        @endforeach
                    @endif
                </select>
            </div>

            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 padding-15 no-padding-bottom">
                <div class="form-group">
                    <label for="postcode">{{trans('client.postcode')}}</label>
                    <input type="text" class="form-control cForm" id="postcode" name="postcode" placeholder="{{trans('client.postcode')}}" value="{{$current_user['post_code'] or ''}}">
                </div>
            </div>

            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="form-group">
                    <label for="comment">{{trans('client.comment')}}</label>
                    <textarea class="form-control cForm" rows="6" id="comment" name="comment" placeholder="{{trans('client.comment')}}"></textarea>
                </div>
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
            <?php $cart_checkout = TRUE; ?>
            @include('dressplace::checkout.cart_partial')
        </div>
    </div>
@endsection

@section('customJS')
    <script type="text/javascript">
        $(document).ready(function () {
            checkout($('.cart-container'));

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
                                           window.location.href = "/checkout";
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