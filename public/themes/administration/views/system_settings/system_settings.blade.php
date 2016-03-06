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
                                    <button class="btn green-haze save_product">
                                        {{trans('global.save')}} </button>

                                </div>
                                <div class="clearfix"></div>
                                <ul class="nav nav-tabs pull-left">
                                    <li class="active">
                                        <a href="#main_info" data-toggle="tab">{{trans('sys_trans.main_info')}}</a>
                                    </li>
                                    <li>
                                        <a href="#seo" data-toggle="tab">SEO</a>
                                    </li>
                                    <li>
                                        <a href="#delivery" data-toggle="tab">{{trans('sys_trans.delivery')}}</a>
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

                                <div class="col-xs-12 text-right margin-top-20">
                                    <button class="btn green-haze save_product">
                                        {{trans('global.save')}} </button>
                                    <a href="/admin/products" class="btn default">
                                        {{trans('global.cancel')}} </a>

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
            $('#quantity').spinner({value: 1, min: 1, max: 50, step: 1.0});
            $('#to_off').spinner({value: 1, min: 1, max: 50, step: 1.0});
            $('#to_addr').spinner({value: 1, min: 1, max: 50, step: 1.0});
            $('#giveaway').spinner({value: 1, min: 1, max: 9999, step: 0.1});
            
        });
    </script>
@endsection