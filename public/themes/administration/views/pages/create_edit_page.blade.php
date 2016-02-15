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
                                <div class="col-xs-12 col-sm-12 col-md-8 col-lg-4 text-right margin-top-5 no-padding">
                                    <button class="btn green-haze save_product">
                                        {{trans('global.save')}} </button>
                                    <a href="/admin/products" class="btn default">
                                        {{trans('global.cancel')}} </a>

                                </div>
                                <div class="clearfix"></div>
                                <ul class="nav nav-tabs pull-left">
                                    <li class="active pull-left">
                                        <a href="#main_info" data-toggle="tab">{{trans('products.main_info')}}</a>
                                    </li>
                                    <li>
                                        <a href="#pages_tab" data-toggle="tab">SEO</a>
                                    </li>
                                </ul>
                            </div>
                            <div class="portlet-body">
                                <div class="tab-content">

                                    {{--Main info tab--}}
                                    @include('pages_partials.pages_main_info_tab')

                                    {{--Price and Discount tab--}}
                                    @include('pages_partials.pages_tab')

                                </div>

                                <div class="clearfix" ></div>

                                <div class="col-xs-12 text-right">
                                    <button class="btn green-haze save_product">
                                        {{trans('global.save')}} </button>
                                    <a href="/admin/products" class="btn default">
                                        {{trans('global.cancel')}} </a>

                                </div>

                                <div class="clearfix" ></div>
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
            //Init WYSIWYG
            $('#content').summernote({height: 300});
            });
    </script>
@endsection
            