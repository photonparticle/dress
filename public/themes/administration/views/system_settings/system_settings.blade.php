@extends('administration::layout')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <!-- BEGIN PROFILE CONTENT -->
            <div class="profile-content">
                <div class="row">
                    <div class="col-md-12">
                        <div class="portlet light">
                            <div class="portlet-title tabbable-line">
                                <div class="caption caption-lg col-xs-12 col-sm-12 col-md-4 col-lg-8">
                                    <i class="fa fa-archive"></i>
                                    <span class="caption-subject font-blue-madison bold uppercase">{{$pageTitle}}</span>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-8 col-lg-4 text-right no-padding margin-top-5">
                                    <button class="btn green-haze" id="save">
                                        {{trans('global.save')}} </button>

                                </div>
                                <div class="clearfix"></div>
                                <ul class="nav nav-tabs pull-left">
                                    <li class="active">
                                        <a href="#main_info" data-toggle="tab">{{trans('system_settings.main_info')}}</a>
                                    </li>
                                    <li>
                                        <a href="#seo" data-toggle="tab">SEO</a>
                                    </li>
                                    <li>
                                        <a href="#delivery" data-toggle="tab">{{trans('system_settings.delivery')}}</a>
                                    </li>
                                </ul>
                            </div>
                            <div class="portlet-body">
                                <div class="tab-content">

                                    {{--Main info tab--}}
                                    @include('system_settings.system_main_info_tab')

                                    {{--SEO tab--}}
                                    @include('system_settings.system_seo_tab')

                                    {{--Delivery tab--}}
                                    @include('system_settings.system_delivery_tab')

                                </div>

                                <div class="clearfix"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- END PROFILE CONTENT -->
        </div>
    </div>
@endsection

@section('customJS')
    <script type="text/javascript">
        jQuery(document).ready(function () {

            //Init spinner
            $('#quantity').spinner({value: 1, min: 1, max: 30, step: 1.0});
            $('#to_off').spinner({value: 0, min: 0, max: 1000, step: 1.00, numberFormat: "c"});
            $('#to_addr').spinner({value: 0, min: 0, max: 1000, step: 1.00, numberFormat: "c"});
            $('#giveaway').spinner({value: 0, min: 0, max: 1000, step: 1.00, numberFormat: "c"});

            //Settings save
            $('body').on('click', '#save', function () {

                $.ajax({
                           type: 'post',
                           url: '/admin/system/settings/store',
                           data: {
                               'title': $('#title').val(),
                               'email': $('#email').val(),
                               'phone': $('#phone').val(),
                               'quantity': $('#input_quantity').val(),
                               'page_title': $('#page_title').val(),
                               'meta_description': $('#meta_description').val(),
                               'meta_keywords': $('#meta_keywords').val(),
                               'delivery_to_office': $('#input_to_off').val(),
                               'delivery_to_address': $('#input_to_addr').val(),
                               'delivery_free_delivery': $('#input_free_delivery').val()
                           },
                           success: function (response) {
                               if (typeof response == typeof {} && response['status'] && response['message']) {
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

        $.ajaxPrefilter(function (options) {
            if (!options.beforeSend) {
                options.beforeSend = function (xhr) {
                    xhr.setRequestHeader('X-CSRF-Token', $('meta[name="csrf-token"]').attr('content'));
                }
            }
        });
    </script>
@endsection