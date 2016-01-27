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
                                <div class="caption caption-md">
                                    <i class="fa fa-archive"></i>
                                    <span class="caption-subject font-blue-madison bold uppercase">{{$pageTitle}}</span>
                                </div>
                                <ul class="nav nav-tabs">
                                    <li class="active">
                                        <a href="#main_info" data-toggle="tab">{{trans('products.main_info')}}</a>
                                    </li>
                                    <li>
                                        <a href="#discounts" data-toggle="tab">{{trans('products.price_and_discounts')}}</a>
                                    </li>
                                    {{--<li>--}}
                                        {{--<a href="#relationships" data-toggle="tab">{{trans('products.relationships')}}</a>--}}
                                    {{--</li>--}}
                                    <li>
                                        <a href="#sizes" data-toggle="tab">{{trans('products.sizes')}}</a>
                                    </li>
                                    <li>
                                        <a href="#visualisation_and_positioning" data-toggle="tab">{{trans('products.visualisation_and_positioning')}}</a>
                                    </li>
                                    <li>
                                        <a href="#seo" data-toggle="tab">SEO</a>
                                    </li>
                                    <li>
                                        <a href="#images" data-toggle="tab">{{trans('products.images')}}</a>
                                    </li>
                                </ul>
                            </div>
                            <div class="portlet-body">
                                <div class="tab-content">
                                    <!-- MAIN INFO TAB -->
                                    <div class="tab-pane active" id="main_info">
                                        <form action="#">

                                            <input type="hidden" name="_token" value="{{ csrf_token() }}">

                                            <div class="form-group form-md-line-input has-success form-md-floating-label">
                                                <div class="input-icon right">
                                                    <input name="title" id="title" type="text" class="form-control input-lg"/>

                                                    <label for="title">{{trans('products.title')}}</label>
                                                    <span class="help-block"></span>
                                                    <i class="fa fa-font"></i>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="description" class="control-label col-xs-12 default no-padding">
                                                    {{trans('products.description')}}
                                                </label>
                                                <div class="col-xs-12 no-padding">
                                                    <div id="description">
                                                    </div>
                                                </div>
                                                <div class="clearfix"></div>
                                            </div>

                                            <div class="margin-top-10">
                                                <button class="btn green-haze save_category">
                                                    {{trans('global.save')}} </button>
                                                <a href="/admin/products" class="btn default">
                                                    {{trans('global.cancel')}} </a>
                                            </div>

                                        </form>

                                    </div>
                                    <!-- END MAIN INFO TAB -->
                                    <!-- Visualisation and Positioning TAB -->
                                    <div class="tab-pane" id="visualisation_and_positioning">
                                        <form action="#">

                                            <div class="col-xs-12 margin-top-20 categores-container">
                                                <label for="categories" class="control-label col-xs-12 default no-padding">
                                                    {{trans('products.parent_category')}}
                                                </label>
                                                <select id="categories" name="categories[]" class="form-control select2me input-lg no-padding" multiple="multiple" data-placeholder="{{trans('products.select_catagories')}}">
                                                    @if(isset($categories) && is_array($categories))
                                                        @foreach($categories as $key => $category)
                                                            <option value="{{$category['id']}}" data-level="{{$category['level']}}">{{$category['title']}}</option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                            </div>
                                            <div class="clearfix"></div>

                                            <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 margin-top-20">
                                                <label for="position" class="control-label col-xs-12 default no-padding">
                                                    {{trans('products.position')}}
                                                </label>

                                                <div id="position">
                                                    <div class="input-group" style="width:150px;">
                                                        <input type="text" name="position" id="position" class="spinner-input form-control" maxlength="2" readonly="">
                                                        <div class="spinner-buttons input-group-btn">
                                                            <button type="button" class="btn spinner-up default">
                                                                <i class="fa fa-angle-up"></i>
                                                            </button>
                                                            <button type="button" class="btn spinner-down default">
                                                                <i class="fa fa-angle-down"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 margin-top-20">
                                                <label for="active" class="control-label col-xs-12 default no-padding">
                                                    {{trans('products.active')}}
                                                </label>
                                                <div class="col-xs-12 no-padding">
                                                    <input id="active" name="active" type="checkbox" class="make-switch" data-on-text="&nbsp;{{trans('products.activated')}}&nbsp;" data-off-text="&nbsp;{{trans('products.not_activated')}}&nbsp;">
                                                </div>
                                            </div>

                                            <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 margin-top-20">
                                                <label for="visible" class="control-label col-xs-12 default no-padding">
                                                    {{trans('products.visibility')}}
                                                </label>
                                                <div class="col-xs-12 no-padding">
                                                    <input id="visible" name="visible" type="checkbox" class="make-switch" data-on-text="&nbsp;{{trans('products.visible')}}&nbsp;" data-off-text="&nbsp;{{trans('products.invisible')}}&nbsp;">
                                                </div>
                                            </div>

                                            <div class="clearfix"></div>

                                            <div class="margin-top-20">
                                                <button class="btn green-haze save_category">
                                                    {{trans('global.save')}} </button>
                                                <a href="/admin/products" class="btn default">
                                                    {{trans('global.cancel')}} </a>
                                            </div>
                                        </form>
                                    </div>
                                    <!-- END Visualisation and Positioning TAB -->

                                    <!-- Relationships TAB -->
                                    <div class="tab-pane" id="relationships">
                                        <form action="#">

                                            <div class="col-xs-12 margin-top-20 categores-container">
                                                <label for="categories" class="control-label col-xs-12 default no-padding">
                                                    {{trans('products.parent_category')}}
                                                </label>
                                                <select id="categories" name="categories[]" class="form-control select2me input-lg no-padding" multiple="multiple" data-placeholder="{{trans('products.select_catagories')}}">
                                                    @if(isset($categories) && is_array($categories))
                                                        @foreach($categories as $key => $category)
                                                            <option value="{{$category['id']}}" data-level="{{$category['level']}}">{{$category['title']}}</option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                            </div>
                                            <div class="clearfix"></div>

                                            <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 margin-top-20">
                                                <label for="position" class="control-label col-xs-12 default no-padding">
                                                    {{trans('products.position')}}
                                                </label>

                                                <div id="position">
                                                    <div class="input-group" style="width:150px;">
                                                        <input type="text" name="position" id="position" class="spinner-input form-control" maxlength="2" readonly="">
                                                        <div class="spinner-buttons input-group-btn">
                                                            <button type="button" class="btn spinner-up default">
                                                                <i class="fa fa-angle-up"></i>
                                                            </button>
                                                            <button type="button" class="btn spinner-down default">
                                                                <i class="fa fa-angle-down"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 margin-top-20">
                                                <label for="visible" class="control-label col-xs-12 default no-padding">
                                                    {{trans('products.visibility')}}
                                                </label>
                                                <div class="col-xs-12 no-padding">
                                                    <input id="visible" name="visible" type="checkbox" class="make-switch" data-on-text="&nbsp;{{trans('products.visible')}}&nbsp;" data-off-text="&nbsp;{{trans('products.invisible')}}&nbsp;">
                                                </div>
                                            </div>

                                            <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 margin-top-20">
                                                <label for="active" class="control-label col-xs-12 default no-padding">
                                                    {{trans('products.active')}}
                                                </label>
                                                <div class="col-xs-12 no-padding">
                                                    <input id="active" name="active" type="checkbox" class="make-switch" data-on-text="&nbsp;{{trans('products.activated')}}&nbsp;" data-off-text="&nbsp;{{trans('products.not_activated')}}&nbsp;">
                                                </div>
                                            </div>

                                            <div class="clearfix"></div>

                                            <div class="margin-top-20">
                                                <button class="btn green-haze save_category">
                                                    {{trans('global.save')}} </button>
                                                <a href="/admin/products" class="btn default">
                                                    {{trans('global.cancel')}} </a>
                                            </div>
                                        </form>
                                    </div>
                                    <!-- END Relationships TAB -->

                                    <!-- Relationships TAB -->
                                    <div class="tab-pane" id="sizes">
                                        <form action="#">

                                            <div class="col-xs-12 margin-top-20 categores-container">
                                                <label for="categories" class="control-label col-xs-12 default no-padding">
                                                    {{trans('products.parent_category')}}
                                                </label>
                                                <select id="categories" name="categories[]" class="form-control select2me input-lg no-padding" multiple="multiple" data-placeholder="{{trans('products.select_catagories')}}">
                                                    @if(isset($categories) && is_array($categories))
                                                        @foreach($categories as $key => $category)
                                                            <option value="{{$category['id']}}" data-level="{{$category['level']}}">{{$category['title']}}</option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                            </div>
                                            <div class="clearfix"></div>

                                            <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 margin-top-20">
                                                <label for="position" class="control-label col-xs-12 default no-padding">
                                                    {{trans('products.position')}}
                                                </label>

                                                <div id="position">
                                                    <div class="input-group" style="width:150px;">
                                                        <input type="text" name="position" id="position" class="spinner-input form-control" maxlength="2" readonly="">
                                                        <div class="spinner-buttons input-group-btn">
                                                            <button type="button" class="btn spinner-up default">
                                                                <i class="fa fa-angle-up"></i>
                                                            </button>
                                                            <button type="button" class="btn spinner-down default">
                                                                <i class="fa fa-angle-down"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 margin-top-20">
                                                <label for="visible" class="control-label col-xs-12 default no-padding">
                                                    {{trans('products.visibility')}}
                                                </label>
                                                <div class="col-xs-12 no-padding">
                                                    <input id="visible" name="visible" type="checkbox" class="make-switch" data-on-text="&nbsp;{{trans('products.visible')}}&nbsp;" data-off-text="&nbsp;{{trans('products.invisible')}}&nbsp;">
                                                </div>
                                            </div>

                                            <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 margin-top-20">
                                                <label for="active" class="control-label col-xs-12 default no-padding">
                                                    {{trans('products.active')}}
                                                </label>
                                                <div class="col-xs-12 no-padding">
                                                    <input id="active" name="active" type="checkbox" class="make-switch" data-on-text="&nbsp;{{trans('products.activated')}}&nbsp;" data-off-text="&nbsp;{{trans('products.not_activated')}}&nbsp;">
                                                </div>
                                            </div>

                                            <div class="clearfix"></div>

                                            <div class="margin-top-20">
                                                <button class="btn green-haze save_category">
                                                    {{trans('global.save')}} </button>
                                                <a href="/admin/products" class="btn default">
                                                    {{trans('global.cancel')}} </a>
                                            </div>
                                        </form>
                                    </div>
                                    <!-- END Relationships TAB -->

                                </div>
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
            Metronic.init(); // init metronic core components
            Layout.init(); // init current layout
            Demo.init(); // init demo features

            //Init WYSIWYG
            $('#description').summernote({height: 300});

            //Init spinner
            $('#position').spinner({value: 0, min: 0, max: 100});

            //Switcher
            $('#active').on('switch-change', function () {
                $('#active').bootstrapSwitch('toggleRadioStateAllowUncheck');
            });
            $('#visible').on('switch-change', function () {
                $('#visible').bootstrapSwitch('toggleRadioStateAllowUncheck');
            });

            $('.save_category').click(function (e) {
                e.preventDefault();

                if ($('#visible').is(':checked')) {
                    var visible = 1;
                } else {
                    var visible = 0;
                }
                if ($('#active').is(':checked')) {
                    var active = 1;
                } else {
                    var active = 0;
                }

                $.ajax({
                           type: 'post',
                           url: '/admin/products/store',
                           data: {
                               'title': $('#title').val(),
                               'description': $('#description').code(),
                               'level': $('#level').val(),
                               'parent': $('#parent').val(),
                               'position': $('#position').val(),
                               'visible': visible,
                               'active': active,
                           },
                           headers: {
                               'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
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
    </script>
@endsection