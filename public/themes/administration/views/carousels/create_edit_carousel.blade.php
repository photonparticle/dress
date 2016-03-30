@extends('administration::layout')

@section('content')
        <!-- BEGIN PROFILE CONTENT -->
<div class="profile-content">
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <div class="portlet light">
                <div class="portlet-title">
                    <div class="caption caption-lg margin-top-10">
                        <i class="fa fa-arrows"></i>
                        <span class="caption-subject font-blue-madison bold uppercase">{{$pageTitle}}</span>
                    </div>
                    <div class="actions">
                        <a href="/admin/module/carousels" class="btn btn-info margin-top-10" title="{{trans('carousels.carousels_list')}}">
                            <i class="fa fa-arrow-left"></i>
                            {{trans('carousels.carousels_list')}}
                        </a>
                        <a href="#" id="save" class="btn btn-success margin-top-10" title="{{trans('global.save')}}">
                            <i class="fa fa-save"></i>
                            {{trans('global.save')}}
                        </a>
                    </div>
                </div>
                <div class="portlet-body">

                    {{--Title--}}
                    <div class="form-group form-md-line-input has-success form-md-floating-label col-xs-12 col-sm-8 col-md-8 col-lg-10">
                        <div class="input-icon right">
                            <input name="carousel_title" id="carousel_title" type="text" class="form-control input-lg" value="{{isset($carousel['title']) ? $carousel['title'] : ''}}"/>

                            <label for="carousel_title">{{trans('carousels.title')}}</label>
                            <span class="help-block"></span>
                            <i class="fa fa-font"></i>
                        </div>
                    </div>

                    {{--Position--}}
                    <div class="form-group form-md-line-input has-success form-md-floating-label col-xs-12 col-sm-4 col-md-4 col-lg-2">
                        <div class="input-icon right">
                            <input name="carousel_position" id="carousel_position" type="number" class="form-control input-lg" value="{{isset($carousel['position']) ? $carousel['position'] : ''}}"/>

                            <label for="carousel_position">{{trans('carousels.position')}}</label>
                            <span class="help-block"></span>
                            <i class="fa fa-arrows-v"></i>
                        </div>
                    </div>

                    {{--Type--}}
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                        <label for="type" class="control-label col-xs-12 default no-padding">
                            {{trans('carousels.type')}}
                        </label>
                        <select id="type" name="type" class="form-control input-lg">
                            <option value="">{{trans('carousels.choose_module')}}</option>
                            <option value="homepage" @if(!empty($carousel['type']) && $carousel['type'] == 'homepage') selected="selected" @endif>{{trans('carousels.homepage')}}</option>
                            <option value="categories" @if(!empty($carousel['type']) && $carousel['type'] == 'categories') selected="selected" @endif>{{trans('carousels.categories')}}</option>
                            <option value="pages" @if(!empty($carousel['type']) && $carousel['type'] == 'pages') selected="selected" @endif>{{trans('carousels.pages')}}</option>
                        </select>
                    </div>

                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                        {{--Categories--}}
                        <div class="categories_holder hidden">
                            <label for="categories" class="control-label col-xs-12 default no-padding">
                                {{trans('carousels.choose_category')}}
                            </label>
                            <select id="categories" name="categories[]" class="form-control select2me input-lg no-padding" data-placeholder="{{trans('carousels.choose_category')}}">
                                <option value="">{{trans('carousels.all_categories')}}</option>
                                @if(isset($categories) && is_array($categories))
                                    @foreach($categories as $key => $category)
                                        <option value="{{$category['id']}}" @if(!empty($carousel['type']) && $carousel['type'] == 'categories' && !empty($carousel['target']) && $carousel['target'] == $category['id']) selected="selected" @endif>{{$category['title']}}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>

                        {{--Pages--}}
                        <div class="pages_holder hidden">
                            <label for="pages" class="control-label col-xs-12 default no-padding">
                                {{trans('carousels.choose_page')}}
                            </label>
                            <select id="pages" name="pages[]" class="form-control select2me input-lg no-padding" data-placeholder="{{trans('carousels.choose_page')}}">
                                <option value="">{{trans('carousels.all_pages')}}</option>
                                @if(isset($pages) && is_array($pages))
                                    @foreach($pages as $key => $page)
                                        <option value="{{$page['id']}}" @if(!empty($carousel['type']) && $carousel['type'] == 'pages' && !empty($carousel['target']) && $carousel['target'] == $page['id']) selected="selected" @endif>{{$page['title']}}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                    </div>

                    <div class="clearfix"></div>

                    {{--Activation dates--}}

                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 margin-top-20">
                        <label for="active_from" class="control-label col-xs-12 default no-padding">
                            {{trans('carousels.active_from')}}
                        </label>

                        <div class="input-group date" id="datetimepicker_active_from">
                            <input type="text" id="active_from" size="16" readonly class="form-control" value="{{isset($carousel['active_from']) ? $carousel['active_from'] : ''}}">
                            <span class="input-group-btn">
                                <button class="btn default date-set" type="button"><i class="fa fa-calendar"></i></button>
                            </span>
                        </div>
                    </div>

                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 margin-top-20">
                        <label for="active_to" class="control-label col-xs-12 default no-padding">
                            {{trans('carousels.active_to')}}
                        </label>

                        <div class="input-group date" id="datetimepicker_active_to">
                            <input type="text" id="active_to" size="16" readonly class="form-control" value="{{isset($carousel['active_to']) ? $carousel['active_to'] : ''}}">
                            <span class="input-group-btn">
                                <button class="btn default date-set" type="button"><i class="fa fa-calendar"></i></button>
                            </span>
                        </div>
                    </div>

                    {{--slider_type--}}
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 margin-top-20 ">
                        <label for="slider_type" class="control-label col-xs-12 col-sm-12 col-md-12 col-lg-12 default no-padding">
                            {{trans('carousels.slider_type')}}
                        </label>
                        <select id="slider_type" name="slider_type" class="form-control input-lg">
                            <option value="">{{trans('carousels.choose_product')}}</option>
                            <option value="newest" @if(!empty($carousel['slider_type']) && $carousel['slider_type'] == 'newest') selected="selected" @endif>{{trans('carousels.newest')}}</option>
                            <option value="discounted" @if(!empty($carousel['slider_type']) && $carousel['slider_type'] == 'discounted') selected="selected" @endif>{{trans('carousels.discounted')}}</option>
                            <option value="others" @if(!empty($carousel['slider_type']) && $carousel['slider_type'] == 'others') selected="selected" @endif>{{trans('carousels.others')}}</option>
                        </select>
                    </div>

                    <div class="form-group col-xs-12 col-sm-12 col-md-6 col-lg-6 margin-top-20 products-holder hidden">
                        <label for="products" class="control-label col-xs-12 col-sm-12 col-md-12 col-lg-12 default no-padding">
                            {{trans('carousels.products')}}
                        </label>
                        <select id="products"
                                name="products[]"
                                class="form-control select2me input-lg no-padding"
                                multiple="multiple"
                                data-placeholder="{{trans('carousels.products')}}">
                            @if(isset($products) && is_array($products))
                                @foreach($products as $key => $product)
                                    <option value="{{$product['id']}}" @if(!empty($carousel['products']) && is_array($carousel['products']) && in_array($product['id'], $carousel['products'])) selected="selected" @endif>{{$product['id']}} - {{$product['title']}}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>


                    {{--max-products--}}
                    <div class="form-group col-xs-12 col-sm-12 col-md-6 col-lg-6 margin-top-20 max-products-holder hidden">
                        <label for="max_products" class="control-label col-xs-12 col-sm-12 col-md-12 col-lg-12 default no-padding">{{trans('carousels.max_products')}}</label>
                        <input name="max_products"
                               id="max_products"
                               type="number"
                               class="form-control input-lg"
                               value="{{isset($carousel['max_products']) ? $carousel['max_products'] : '1'}}"
                               min="1"
                        />

                    </div>


                    <div class="clearfix"></div>


                </div>
            </div>
        </div>
    </div>
</div>
<!-- END PROFILE CONTENT -->
@endsection

@section('customJS')
    <script type="text/javascript">
        jQuery(document).ready(function () {

            // Init DateTime_Picker
            var time_pickers = $("#datetimepicker_active_from, #datetimepicker_active_to");
            time_pickers.datetimepicker({
                                            autoclose: true,
                                            isRTL: Metronic.isRTL(),
                                            format: "yyyy.mm.dd hh:ii",
                                            pickerPosition: (Metronic.isRTL() ? "bottom-right" : "bottom-left")
                                        });

            $('body').on('change', '#type', function () {
                showHideTarget();
            });

            //Show/hide activate targets
            function showHideTarget() {
                var type = $('#type').val();

                if (type == 'categories') {
                    $('.categories_holder').removeClass('hidden');
                } else {
                    $('.categories_holder').addClass('hidden');
                }
                if (type == 'pages') {
                    $('.pages_holder').removeClass('hidden');
                } else {
                    $('.pages_holder').addClass('hidden');
                }
            }

            showHideTarget();

            $('body').on('change', '#slider_type', function () {
                showHideSliderType();
            });

            //Show/hide slider type
            function showHideSliderType() {
                var type = $('#slider_type').val();

                if (type == 'newest' || type == 'discounted') {
                    $('.max-products-holder').removeClass('hidden');
                } else {
                    $('.max-products-holder').addClass('hidden');
                }
                if (type == 'others') {

                    $('.products-holder').removeClass('hidden');
                } else {
                    $('.products-holder').addClass('hidden');
                }
            }

            showHideSliderType();

            //Save slider
            function saveSlider() {
                var
                        title = $('#carousel_title').val(),
                        position = $('#carousel_position').val(),
                        type = $('#type').val(),
                        categories = $('#categories').val(),
                        pages = $('#pages').val(),
                        active_from = $('#active_from').val(),
                        active_to = $('#active_to').val(),
                        target = '',
                        slider_type = $('#slider_type').val(),
                        products = $('#products').val(),
                        max_products = $('#max_products').val();

                if (type == 'categories') {
                    target = categories;
                }
                if (type == 'pages') {
                    target = pages;
                }

                if (slider_type == 'newest') {
                    products = slider_type;
                }
                if (slider_type == 'discounted') {
                    products = slider_type;
                }

                $.ajax({
                           type: 'post',
                           url: '/admin/module/carousels/store',
                           data: {
                               'title': title,
                               'position': position,
                               'type': type,
                               'target': target,
                               'active_from': active_from,
                               'products': products,
                               'max_products': max_products,
                               'active_to': active_to,
                               'id': '{{$carousel['id'] or ''}}'
                           },
                           success: function (response) {
                               if (typeof response == typeof {} && response['status'] && response['message']) {
                                   showNotification(response['status'], response['message']);

                                   if (response['status'] == 'success' && response['redirect']) {
                                       setTimeout(function () {
                                           window.location.href = "/admin/module/carousels/edit/" + response['id'];
                                       }, 2000);
                                   }
                               } else {
                                   showNotification('error', translate('request_not_completed'), translate('contact_support'));
                               }
                           },
                           error: function () {
                               showNotification('error', translate('request_not_completed'), translate('contact_support'));
                           }

                       });
            }

            $('#save').click(function (e) {
                e.preventDefault();

                //Save the slider
                saveSlider();
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