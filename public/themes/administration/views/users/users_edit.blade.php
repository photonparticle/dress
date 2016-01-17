@extends('administration::layout')
@section('content') <!-- BEGIN EXAMPLE TABLE PORTLET-->
<div class="page-content">
    <div class="row">
        <div class="col-md-12">
            <!-- BEGIN PROFILE CONTENT -->
            <div class="profile-content">
                <div class="row">
                    <div class="col-md-12">
                        <div class="portlet light">
                            <div class="portlet-title tabbable-line">
                                <div class="caption caption-md">
                                    <i class="fa fa-user"></i>
                                    <span class="caption-subject font-blue-madison bold uppercase">{{trans('users.profile_account')}}</span>
                                </div>
                                <ul class="nav nav-tabs">
                                    <li class="active">
                                        <a href="#tab_1_1" data-toggle="tab">{{trans('users.personal_info')}}</a>
                                    </li>
                                    <li>
                                        <a href="#tab_1_3" data-toggle="tab">{{trans('users.change_password')}}</a>
                                    </li>
                                    <li>
                                        <a href="#tab_1_4" data-toggle="tab">{{trans('users.user_group')}}</a>
                                    </li>
                                </ul>
                            </div>
                            <div class="portlet-body">
                                <div class="tab-content">
                                    <!-- PERSONAL INFO TAB -->
                                    <div class="tab-pane active" id="tab_1_1">
                                        <form action="#" id="personal_info_form">


                                            <input type="hidden" name="_token" value="{{ csrf_token() }}">


                                            <div class="form-group form-md-line-input has-success form-md-floating-label">
                                                <div class="input-icon right">
                                                    <input name="first_name" type="text" class="form-control input-lg" value="{{isset($first_name) ? $first_name : ''}}"/>

                                                    <label for="first_name">{{trans('users.first_name')}}</label>
                                                    <span class="help-block"></span>
                                                    <i class="fa fa-font"></i>
                                                </div>
                                            </div>


                                            <div class="form-group form-md-line-input has-success form-md-floating-label">
                                                <div class="input-icon right">
                                                    <input name="last_name" type="text" class="form-control input-lg" value="{{isset($last_name) ? $last_name : ''}}"/>

                                                    <label for="last_name">{{trans('users.last_name')}}</label>
                                                    <span class="help-block"></span>
                                                    <i class="fa fa-font"></i>
                                                </div>
                                            </div>


                                            <div class="form-group form-md-line-input has-success form-md-floating-label">
                                                <div class="input-icon right">
                                                    <input name="phone" type="text" class="form-control input-lg" value="{{isset($phone) ? $phone : ''}}"/>

                                                    <label for="phone">{{trans('users.phone')}}</label>
                                                    <span class="help-block"></span>
                                                    <i class="fa fa-mobile"></i>
                                                </div>
                                            </div>


                                            <div class="form-group form-md-line-input has-success form-md-floating-label">
                                                <div class="input-icon right">
                                                    <input name="address" type="text" class="form-control input-lg" value="{{isset($address) ? $address : ''}}"/>

                                                    <label for="address">{{trans('users.address')}}</label>
                                                    <span class="help-block"></span>
                                                    <i class="fa fa-home"></i>
                                                </div>
                                            </div>


                                            <div class="form-group form-md-line-input has-success form-md-floating-label">
                                                <div class="input-icon right">
                                                    <input name="city" type="text" class="form-control input-lg" value="{{isset($city) ? $city : ''}}"/>

                                                    <label for="city">{{trans('users.city')}}</label>
                                                    <span class="help-block"></span>
                                                    <i class="fa fa-map-marker"></i>
                                                </div>
                                            </div>


                                            <div class="form-group form-md-line-input has-success form-md-floating-label">
                                                <div class="input-icon right">
                                                    <input name="country" type="text" class="form-control input-lg" value="{{isset($country) ? $country : ''}}"/>

                                                    <label for="country">{{trans('users.country')}}</label>
                                                    <span class="help-block"></span>
                                                    <i class="fa fa-map-marker"></i>
                                                </div>
                                            </div>

                                            <div class="margin-top-10">
                                                <button id="save_personal_info" class="btn green-haze" data-action="personal_info">
                                                    {{trans('users.save_changes')}} </button>
                                                <a href="/admin/users" class="btn default">
                                                    {{trans('users.cancel')}} </a>
                                            </div>

                                        </form>

                                    </div>
                                    <!-- END PERSONAL INFO TAB -->
                                    <!-- CHANGE PASSWORD TAB -->
                                    <div class="tab-pane" id="tab_1_3">
                                        <form id="change_password_form">
                                            <input type="hidden" name="_token" value="{{ csrf_token() }}">


                                            <div class="form-group form-md-line-input has-success form-md-floating-label">

                                                <div class="input-icon right">

                                                    <input name="password" type="password" class="form-control input-lg"/>

                                                    <label for="password">{{trans('users.password')}}</label>

                                                    <span class="help-block"></span>

                                                    <i class="fa fa-hashtag"></i>

                                                </div>

                                            </div>


                                            <div class="form-group form-md-line-input has-success form-md-floating-label">

                                                <div class="input-icon right">

                                                    <input name="new_password" type="password" class="form-control input-lg"/>

                                                    <label for="new_password">{{trans('users.new_password')}}</label>

                                                    <span class="help-block"></span>

                                                    <i class="fa fa-hashtag"></i>

                                                </div>

                                            </div>


                                            <div class="form-group form-md-line-input has-success form-md-floating-label">

                                                <div class="input-icon right">

                                                    <input name="re_new_password" type="password" class="form-control"/>

                                                    <label for="re_new_password">{{trans('users.re_new_password')}}</label>

                                                    <span class="help-block"></span>

                                                    <i class="fa fa-hashtag"></i>

                                                </div>

                                            </div>

                                            <div class="margin-top-10">
                                                <button id="change_password" class="btn green-haze" data-action="change_password">
                                                    {{trans('users.save_password')}} </button>
                                                <a href="/admin/users" class="btn default">
                                                    {{trans('users.cancel')}} </a>
                                            </div>
                                        </form>
                                    </div>
                                    <!-- END CHANGE PASSWORD TAB -->

                                    <!-- PERMISSIONS TAB -->
                                    <div class="tab-pane" id="tab_1_4">
                                        <form id="user_group">
                                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                            <div class="col-xs-12">
                                                <h4>
                                                    {{trans('users.user_group')}}
                                                </h4>
                                                <select id="user_group" name="user_group" class="form-control select2me input-lg">
                                                    <option value="1" @if(isset($is_admin) && $is_admin == 1) selected @endif>{{trans('users.administrators')}}</option>
                                                    <option value="0" @if(isset($is_admin) && $is_admin == 0) selected @endif>{{trans('users.users')}}</option>
                                                </select>
                                            </div>
                                            <div class="clearfix"></div>
                                            <!--end profile-settings-->
                                            <div class="margin-top-20">
                                                <button id="save_user_group" class="btn green-haze" data-action="user_group">
                                                    {{trans('users.save_changes')}} </button>
                                                <a href="/admin/users" class="btn default">
                                                    {{trans('users.cancel')}} </a>
                                            </div>
                                        </form>
                                    </div>
                                    <!-- END PERMISSIONS TAB -->

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- END PROFILE CONTENT -->
        </div>
    </div>
    <!-- END PAGE CONTENT-->
    @endsection

    @section('customJS')
        <script type="text/javascript">
            var user_id = '{{$user_id}}';

            $('#save_personal_info, #change_password, #save_user_group').click(function (e) {
                e.preventDefault();
                var action = $(this).attr('data-action');

                if (action == 'personal_info') {
                    var form = '#personal_info_form';
                } else if (action == 'change_password') {
                    var form = '#change_password_form';
                } else if(action == 'user_group') {
                    var form = '#user_group';
                } else {
                    form = [];
                }

                $.ajax({
                           type: 'post',
                           url: '/admin/users/update/' + user_id + '/' + action,
                           data: $(form).serialize(),
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
            jQuery(document).ready(function () {
                Metronic.init(); // init metronic core components
                Layout.init(); // init current layout
                Demo.init(); // init demo features
                ComponentsDropdowns.init();
            });
        </script>
@endsection