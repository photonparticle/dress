@extends('dressplace::layout')

@section('content')
    @if(!isset($ajax))
        <div class="container col-xs-12">
            @endif

            <h1 class="text-center">{{trans('client.my-account')}}</h1>

            <div class="tab-head">
                <nav class="nav-sidebar">
                    <ul class="nav tabs">
                        <li class="active"><a href="#personal_information" data-toggle="tab">{{trans('client.personal_information')}}</a></li>
                        <li class=""><a href="#change_password" data-toggle="tab">{{trans('client.change_password')}}</a></li>
                    </ul>
                </nav>
                <div class="tab-content one">
                    <div class="tab-pane text-style active" id="personal_information">
                        <form id="personal_info_form" method="POST" action="/my-profile">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                    <div class="form-group">
                                        <label for="first_name">{{trans('users.first_name')}}</label>
                                        <input type="text" name="first_name" id="first_name" class="form-control" placeholder="{{trans('users.first_name')}}" value="{{$current_user['first_name'] or ''}}">
                                    </div>
                                </div>

                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                    <div class="form-group">
                                        <label for="last_name">{{trans('users.last_name')}}</label>
                                        <input type="text" name="last_name" id="last_name" class="form-control" placeholder="{{trans('users.last_name')}}" value="{{$current_user['last_name'] or ''}}">
                                    </div>
                                </div>

                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                    <div class="form-group">
                                        <label for="phone">{{trans('users.phone')}}</label>
                                        <input type="text" name="phone" id="phone" class="form-control" placeholder="{{trans('users.phone')}}" value="{{$current_user['phone'] or ''}}">
                                    </div>
                                </div>

                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                    <div class="form-group">
                                        <label for="address">{{trans('users.address')}}</label>
                                        <input type="text" name="address" id="address" class="form-control" placeholder="{{trans('users.address')}}" value="{{$current_user['address'] or ''}}">
                                    </div>
                                </div>

                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                    <div class="form-group">
                                        <label for="city">{{trans('users.city')}}</label>
                                        <input type="text" name="city" id="city" class="form-control" placeholder="{{trans('users.city')}}" value="{{$current_user['city'] or ''}}">
                                    </div>
                                </div>

                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                    <div class="form-group">
                                        <label for="country">{{trans('users.country')}}</label>
                                        <input type="text" name="country" id="country" class="form-control" placeholder="{{trans('users.country')}}" value="{{$current_user['country'] or trans('client.Bulgaria')}}">
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
                                        <i class="fa fa-refresh"></i>
                                        {{trans('client.update')}}
                                    </button>
                                </div>
                            </div>
                        </form>
                        <div class="clearfix"></div>
                    </div>

                    <div class="tab-pane text-style" id="change_password">
                        <form id="change_password_form" method="POST" action="/my-profile">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                    <div class="form-group">
                                        <label for="password">{{trans('client.password')}}</label>
                                        <input name="password" type="password" class="form-control" id="password" placeholder="{{trans('client.password')}}">
                                    </div>
                                </div>

                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                    <div class="form-group">
                                        <label for="new_password">{{trans('users.new_password')}}</label>
                                        <input name="new_password" type="password" class="form-control" id="new_password" placeholder="{{trans('users.new_password')}}">
                                    </div>
                                </div>

                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                    <div class="form-group">
                                        <label for="re_new_password">{{trans('users.re_new_password')}}</label>
                                        <input name="re_new_password" type="password" class="form-control" id="re_new_password" placeholder="{{trans('users.re_new_password')}}">
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
                                        <i class="fa fa-key"></i>
                                        {{trans('client.change_password')}}
                                    </button>
                                </div>
                            </div>
                        </form>
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