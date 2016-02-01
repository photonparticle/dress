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
                                        <a href="#price_and_discount" data-toggle="tab">{{trans('products.price_and_discounts')}}</a>
                                    </li>
                                    <li>
                                        <a href="#sizes" data-toggle="tab">{{trans('products.sizes')}}</a>
                                    </li>
                                    <li>
                                        <a href="#relationships" data-toggle="tab">{{trans('products.relationships')}}</a>
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

                                    {{--Main info tab--}}
                                    @include('products_partials.product_main_info_tab')

                                    {{--Price and Discount tab--}}
                                    @include('products_partials.product_price_and_discounts')

                                    {{--Sizes tab--}}
                                    @include('products_partials.product_sizes_tab')

                                    {{--Relationships tab--}}
                                    @include('products_partials.product_relationships_tab')

                                    {{--Visualisation and positioning tab--}}
                                    @include('products_partials.product_visualisation_and_positioning_tab')

                                    {{--SEO tab--}}
                                    @include('products_partials.product_seo_tab')

                                    {{--Images tab--}}
                                    @include('products_partials.product_images_tab')

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
            $('#position').spinner({value: 0, min: 0, max: 100, step: 1.0});
            $('#quantity').spinner({value: 0, min: 0, max: 100, step: 1.0});

            $('#original_price').spinner({value: 0, min: 0, max: 1000, step: 1.00, numberFormat: "c"});
            $('#price').spinner({value: 0, min: 0, max: 1000, step: 1.00, numberFormat: "c"});
            $('#discount').spinner({value: 0, min: 0, max: 1000, step: 1.00, numberFormat: "c"});

            // Init DateTime_Picker
            $(".discount_start, .discount_end, .created_at").datetimepicker({
                                                   autoclose: true,
                                                   isRTL: Metronic.isRTL(),
                                                   format: "yyyy.mm.dd hh:ii",
                                                   pickerPosition: (Metronic.isRTL() ? "bottom-right" : "bottom-left")
                                               });

            //Switcher
            $('#active').on('switch-change', function () {
                $('#active').bootstrapSwitch('toggleRadioStateAllowUncheck');
            });
            $('#visible').on('switch-change', function () {
                $('#visible').bootstrapSwitch('toggleRadioStateAllowUncheck');
            });

            $('.save_category').click(function (e) {
                e.preventDefault();

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
                               'quantity': $('#input_quantity').val(),
                               'position': $('#input_position').val(),
                               'active': active,
                               'original_price': $('#input_original_price').val(),
                               'price': $('#input_price').val(),
                               'discount_price': $('#input_discount').val(),
                               'discount_start': $('#discount_start').val(),
                               'discount_end': $('#discount_end').val(),
                               'created_at': $('#created_at').val(),
                               'categories': $('#categories').val()
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