@extends('administration::layout')
@section('content') <!-- BEGIN EXAMPLE TABLE PORTLET-->
<div class="page-content">
    <!-- BEGIN SAMPLE FORM PORTLET-->
    <div class="portlet light">
        <div class="portlet-title">
            <div class="caption font-green-haze">
                <i class="fa fa-user"></i>
                <span class="caption-subject font-blue-madison bold uppercase">{{trans('users.profile_account')}}</span>
            </div>
            <div class="actions">
                <a class="btn btn-circle btn-icon-only btn-default fullscreen" href="#" data-original-title="" title="">
                </a>
            </div>
        </div>
        <div class="portlet-body form">
            <div class="row">
                <div class="col-md-12">
                    <!-- BEGIN PROFILE CONTENT -->
                    <div class="profile-content">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="portlet light">
                                    <div class="portlet-title tabbable-line">
                                        <div class="caption caption-md">
                                            {{isset($email) ? $email : ''}}
                                        </div>
                                        <ul class="nav nav-tabs">
                                            <li class="active">
                                                <a href="#tab_1_1" data-toggle="tab">{{trans('users.personal_info')}}</a>
                                            </li>
                                            <li>
                                                <a href="#tab_1_3" data-toggle="tab">{{trans('users.change_password')}}</a>
                                            </li>
                                            <li>
                                                <a href="#tab_1_4" data-toggle="tab">Privacy Settings</a>
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
                                                            <input name="first_name" type="text"  class="form-control" value="{{isset($firstname) ? $firstname : ''}}"/>
                                                            
                                                            <label for="form_control">{{trans('users.first_name')}}</label>
                                                            <span class="help-block"></span>
                                                            <i class="fa fa-font"></i>
                                                        </div>
                                                    </div>
                                                    
                                                    
                                                    <div class="form-group form-md-line-input has-success form-md-floating-label">
                                                        <div class="input-icon right">
                                                            <input name="last_name" type="text" class="form-control" value="{{isset($lastname) ? $lastname : ''}}"/>
                                                            
                                                            <label for="form_control">{{trans('users.last_name')}}</label>
                                                            <span class="help-block"></span>
                                                            <i class="fa fa-font"></i>
                                                        </div>
                                                    </div>
                                                    
                                                    
                                                    <div class="form-group form-md-line-input has-success form-md-floating-label">
                                                        <div class="input-icon right">
                                                            <input name="phone" type="text"  class="form-control" value="{{isset($firstname) ? $phone : ''}}"/>
                                                            
                                                            <label for="form_control">{{trans('users.phone')}}</label>
                                                            <span class="help-block"></span>
                                                            <i class="fa fa-cog"></i>
                                                        </div>
                                                    </div>
                                                    
                                                    
                                                    <div class="form-group form-md-line-input has-success form-md-floating-label">
                                                        <div class="input-icon right">
                                                            <input name="address" type="text"  class="form-control" value="{{isset($firstname) ? $address : ''}}"/>
                                                            
                                                            <label for="form_control">{{trans('users.address')}}</label>
                                                            <span class="help-block"></span>
                                                            <i class="fa fa-cogs"></i>
                                                        </div>
                                                    </div>
                                                    
                                                    
                                                    <div class="form-group form-md-line-input has-success form-md-floating-label">
                                                        <div class="input-icon right">
                                                            <input name="city" type="text"  class="form-control" value="{{isset($firstname) ? $city : ''}}"/>
                                                            
                                                            <label for="form_control">{{trans('users.city')}}</label>
                                                            <span class="help-block"></span>
                                                            <i class="fa fa-modx"></i>
                                                        </div>
                                                    </div>
                                                    
                                                    
                                                    <div class="form-group form-md-line-input has-success form-md-floating-label">
                                                        <div class="input-icon right">
                                                            <input name="country" type="text"  class="form-control" value="{{isset($firstname) ? $country : ''}}"/>
                                                            
                                                            <label for="form_control">{{trans('users.country')}}</label>
                                                            <span class="help-block"></span>
                                                            <i class="fa fa-hashtag"></i>
                                                        </div>
                                                    </div>
                                                    
                                                    
                                                    
                                                     <!--
                                                    <div class="form-group">
                                                        <label class="control-label">{{trans('users.last_name')}}</label>
                                                        
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="control-label">{{trans('users.phone')}}</label>
                                                        <input name="phone" type="text" placeholder="{{trans('users.phone')}}" class="form-control" value="{{isset($phone) ? $phone : ''}}"/>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="control-label">{{trans('users.address')}}</label>
                                                        <input name="address" type="text" placeholder="{{trans('users.address')}}" class="form-control" value="{{isset($address) ? $address: ''}}"/>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="control-label">{{trans('users.city')}}</label>
                                                        <input name="city" type="text" placeholder="{{trans('users.city')}}" class="form-control" value="{{isset($city) ? $city: ''}}"/>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="control-label">{{trans('users.country')}}</label>
                                                        <input name="country" type="text" placeholder="{{trans('users.country')}}" class="form-control" value="{{isset($country) ? $country: ''}}"/>
                                                    </div> -->
                                                    <div class="margin-top-10">
                                                        <button id="save_personal_info" class="btn green-haze" data-action="personal_info">
                                                            {{trans('users.save_changes')}} </button>
                                                        <button type="reset" class="btn default">
                                                            {{trans('users.cancel')}} </button>
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
                                                            
                                                            <input name="password" type="password" class="form-control"/>
                                                            
                                                            <label for="form_control">{{trans('users.password')}}</label>
                                                            
                                                            <span class="help-block"></span>
                                                            
                                                            <i class="fa fa-hashtag"></i>
                                                            
                                                        </div>
                                                        
                                                    </div>
                                                    
                                                    
                                                    
                                                    
                                                    
                                                    <div class="form-group form-md-line-input has-success form-md-floating-label">
                                                        
                                                        <div class="input-icon right">
                                                            
                                                            <input name="new_password" type="password" class="form-control"/>
                                                            
                                                            <label for="form_control">{{trans('users.new_password')}}</label>
                                                            
                                                            <span class="help-block"></span>
                                                            
                                                            <i class="fa fa-hashtag"></i>
                                                            
                                                        </div>
                                                        
                                                    </div>
                                                    
                                                    
                                                    
                                                    
                                                    
                                                    <div class="form-group form-md-line-input has-success form-md-floating-label">
                                                        
                                                        <div class="input-icon right">
                                                            
                                                            <input name="re_new_password" type="password" class="form-control"/>
                                                            
                                                            <label for="form_control">{{trans('users.re_new_password')}}</label>
                                                            
                                                            <span class="help-block"></span>
                                                            
                                                            <i class="fa fa-hashtag"></i>
                                                            
                                                        </div>
                                                        
                                                    </div>
                                                    
                                                    
                                                    
                                                    <!--
                                                    <div class="form-group">
                                                        <label class="control-label">{{trans('users.password')}}</label>
                                                        <input name="password" type="password" class="form-control"/>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="control-label">{{trans('users.new_password')}}</label>
                                                        <input name="new_password" type="password" class="form-control"/>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="control-label">{{trans('users.re_new_password')}}</label>
                                                        <input name="re_new_password" type="password" class="form-control"/>
                                                    </div> -->
                                                    <div class="margin-top-10">
                                                        <button id="change_password" class="btn green-haze" data-action="change_password">
                                                            {{trans('users.save_password')}} </button>
                                                        <button type="reset" class="btn default">
                                                            {{trans('users.cancel')}} </button>
                                                    </div>
                                                </form>
                                            </div>
                                            <!-- END CHANGE PASSWORD TAB -->
                                            <!-- PRIVACY SETTINGS TAB -->
                                            <div class="tab-pane" id="tab_1_4">
                                                <form id="privacy_settings_form">
                                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                    <table class="table table-light table-hover">
                                                        <tr>
                                                            <td>
                                                                Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus..
                                                            </td>
                                                            <td>
                                                                <label class="uniform-inline">
                                                                    <input type="radio" name="optionsRadios1" value="option1"/>
                                                                    {{trans('users.yes')}} </label>
                                                                <label class="uniform-inline">
                                                                    <input type="radio" name="optionsRadios1" value="option2" checked/>
                                                                    {{trans('users.no')}} </label>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                Enim eiusmod high life accusamus terry richardson ad squid wolf moon
                                                            </td>
                                                            <td>
                                                                <label class="uniform-inline">
                                                                    <input type="checkbox" value=""/> Yes </label>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                Enim eiusmod high life accusamus terry richardson ad squid wolf moon
                                                            </td>
                                                            <td>
                                                                <label class="uniform-inline">
                                                                    <input type="checkbox" value=""/> Yes </label>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                Enim eiusmod high life accusamus terry richardson ad squid wolf moon
                                                            </td>
                                                            <td>
                                                                <label class="uniform-inline">
                                                                    <input type="checkbox" value=""/> Yes </label>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                    <!--end profile-settings-->
                                                    <div class="margin-top-10">
                                                        <button id="save_privacy_settings" class="btn green-haze">
                                                            {{trans('users.save_changes')}} </button>
                                                        <button type="reset" class="btn default">
                                                            {{trans('users.cancel')}} </button>
                                                    </div>
                                                </form>
                                            </div>
                                            <!-- END PRIVACY SETTINGS TAB -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- END PROFILE CONTENT -->
                </div>
            </div>
        </div>
    </div>
</div>
<!-- END PAGE CONTENT-->
@endsection

@section('customJS')
    <script type="text/javascript">
        var user_id = '{{$user_id}}';

        $('#save_personal_info, #change_password').click(function (e) {
            e.preventDefault();
            var action = $(this).attr('data-action');

            if (action == 'personal_info') {
                var form = '#personal_info_form';
            } else if (action == 'change_password') {
                var form = '#change_password_form';
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
                           response = $.parseJSON(response);

                           if (response.status == 'success') {
                               showNotification(response.status, response.message);
                           } else {
                               showNotification(response.status, response.message);
                           }
                       },
                       error: function () {
                           showNotification('error', 'Request could not be completed.', 'Contact us at office@dressplace.net');
                       }

                   });
        });
    </script>
@endsection