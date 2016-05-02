@extends('dressplace::layout')

@section('content')

    @if(!isset($ajax))
        <div class="container">
            @endif
            <div class="col-xs-12">
                <div class="section-title text-center">
                    <h1 class="no-margin">
                        {{trans('client.my-account')}}
                    </h1>
                </div>
            </div>
            <div class="clearfix"></div>
            @if(!isset($ajax))
        </div>
    @endif


    @if(!isset($ajax))
        <div class="container">
            @endif

            <div class="col-xs-12 col-sm-12 col-md-8 col-md-offset-2 col-lg-6 col-lg-offset-3">
                <div class="tab-head">
                    <nav class="nav-sidebar">
                        <ul class="pro-details-tab" role="tablist">
                            <li role="presentation" class="active">
                                <a href="#personal_information" data-toggle="tab">
                                    {{trans('client.personal_information')}}
                                </a>
                            </li>
                            <li role="presentation" class="">
                                <a href="#change_password" data-toggle="tab">
                                    {{trans('client.change_password')}}
                                </a>
                            </li>
                        </ul>
                    </nav>
                    <div class="tab-content one">
                        <div role="tabpanel" class="tab-pane text-style active" id="personal_information">
                            <div class="product-tab-desc">
                                <form id="personal_info_form" method="POST" action="/my-profile">
                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                            <div class="form-group">
                                                <label for="first_name">{{trans('users.first_name')}}</label>
                                                <input type="text" name="first_name" id="first_name" class="form-control cForm" placeholder="{{trans('users.first_name')}}" value="{{$current_user['first_name'] or ''}}">
                                            </div>
                                        </div>

                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                            <div class="form-group">
                                                <label for="last_name">{{trans('users.last_name')}}</label>
                                                <input type="text" name="last_name" id="last_name" class="form-control cForm" placeholder="{{trans('users.last_name')}}" value="{{$current_user['last_name'] or ''}}">
                                            </div>
                                        </div>

                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                            <div class="form-group">
                                                <label for="phone">{{trans('users.phone')}}</label>
                                                <input type="text" name="phone" id="phone" class="form-control cForm" placeholder="{{trans('users.phone')}}" value="{{$current_user['phone'] or ''}}">
                                            </div>
                                        </div>

                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                            <div class="form-group">
                                                <label for="address">{{trans('users.address')}}</label>
                                                <input type="text" name="address" id="address" class="form-control cForm" placeholder="{{trans('users.address')}}" value="{{$current_user['address'] or ''}}">
                                            </div>
                                        </div>

                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                            <div class="form-group">
                                                <label for="city">{{trans('users.city')}}</label>
                                                <input type="text" name="city" id="city" class="form-control cForm" placeholder="{{trans('users.city')}}" value="{{$current_user['city'] or ''}}">
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

                                        {{--<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">--}}
                                        {{--<div class="form-group">--}}
                                        {{--<label for="country">{{trans('users.country')}}</label>--}}
                                        {{--<input type="text" name="country" id="country" class="form-control cForm" placeholder="{{trans('users.country')}}" value="{{$current_user['country'] or trans('client.Bulgaria')}}">--}}
                                        {{--</div>--}}
                                        {{--</div>--}}

                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 padding-15 no-padding-bottom">
                                            <div class="form-group">
                                                <label for="postcode">{{trans('client.postcode')}}</label>
                                                <input type="text" class="form-control cForm" id="postcode" name="postcode" placeholder="{{trans('client.postcode')}}" value="{{$current_user['post_code'] or ''}}">
                                            </div>
                                        </div>

                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                            <button
                                                    type="submit"
                                                    id="save_personal_info"
                                                    class="btn btn-primary pull-left"
                                                    data-action="personal_info"
                                                    data-user-id="{{$current_user['id'] or ''}}"
                                            >
                                                {{--<i class="fa fa-refresh"></i>--}}
                                                {{trans('client.update')}}
                                            </button>
                                        </div>
                                    </div>
                                </form>
                                <div class="clearfix"></div>
                            </div>
                        </div>

                        <div role="tabpanel" class="tab-pane text-style" id="change_password">
                            <div class="product-tab-desc">
                                <form id="change_password_form" method="POST" action="/my-profile">
                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                            <div class="form-group">
                                                <label for="password">{{trans('client.password')}}</label>
                                                <input name="password" type="password" class="form-control cForm" id="password" placeholder="{{trans('client.password')}}">
                                            </div>
                                        </div>

                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                            <div class="form-group">
                                                <label for="new_password">{{trans('users.new_password')}}</label>
                                                <input name="new_password" type="password" class="form-control cForm" id="new_password" placeholder="{{trans('users.new_password')}}">
                                            </div>
                                        </div>

                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                            <div class="form-group">
                                                <label for="re_new_password">{{trans('users.re_new_password')}}</label>
                                                <input name="re_new_password" type="password" class="form-control cForm" id="re_new_password" placeholder="{{trans('users.re_new_password')}}">
                                            </div>
                                        </div>

                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                            <button
                                                    type="submit"
                                                    id="save_new_password"
                                                    class="btn btn-primary pull-left"
                                                    data-action="change_password"
                                                    data-user-id="{{$current_user['id'] or ''}}"
                                            >
                                                {{trans('client.change_password')}}
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            @if(!isset($ajax))
        </div>
    @endif
@endsection

@section('customJS')
    <script type="text/javascript">
        jQuery(document).ready(function () {
            $('#save_personal_info, #save_new_password').on('click', function (e) {
                var user_id = $(this).attr('data-user-id');
                e.preventDefault();
                e.stopPropagation();
                e.stopImmediatePropagation();

                var action = $(this).attr('data-action');

                if (action == 'personal_info') {
                    var form = '#personal_info_form';
                } else if (action == 'change_password') {
                    var form = '#change_password_form';
                } else {
                    form = [];
                }

                if (form && user_id && action) {
                    $.ajax({
                               type: 'post',
                               url: '/my-profile/' + user_id + '/' + action,
                               data: $(form).serialize(),
                               success: function (response) {
                                   response = $.parseJSON(response);

                                   if (typeof response === typeof {} && response['status'] && response['message']) {
                                       showNotification(response['status'], response['message']);
                                   } else {
                                       showNotification('error', translate('request_not_completed'), translate('contact_support'));
                                   }
                               },
                               error: function () {
                                   showNotification('error', translate('request_not_completed'), translate('contact_support'));
                               }

                           });
                }
            });
        });
    </script>
@endsection