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
            //SEO URL vars
            var
                    timer,
                    timeout,
                    $slug = $('#friendly_url'),
                    url_from_name = true,
                    current_slug = '{{$seo['friendly_url'] or ''}}',
                    url_invalid = true;

            //Init WYSIWYG
            $('#description').summernote({height: 300});
            $('#dimensions_table').summernote({height: 300});

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

            $('.save_product').click(function (e) {
                e.preventDefault();

                var slug = $slug.val();

                //Check URL
                if (slug.length > 0) {
                    if ((current_slug.length > 0 && current_slug != slug) || (current_slug.length == 0)) {
                        if (url_invalid === true) {
                            showNotification('error', '{{trans('global.warning')}}', '{{trans('products.url_exists')}}');

                            return;
                        }
                    }
                } else {
                    showNotification('error', '{{trans('global.warning')}}', '{{trans('products.url_required')}}');

                    return;
                }

                if ($('#active').is(':checked')) {
                    var active = 1;
                } else {
                    var active = 0;
                }

                //Sizes
                var sizes = {};
                var total_quantity = 0;
                if ($('.product_sizes').length > 0) {

                    $('.product_sizes').each(function () {
                        var
                                size_name = $(this).find('span.name').html(),
                                size_quantity = $(this).find('.quantity input').val(),
                                size_price = $(this).find('.price input').val(),
                                size_discount = $(this).find('.discount input').val();

                        if (size_name) {
                            total_quantity = parseInt(total_quantity) + parseInt(size_quantity);
                            sizes[size_name] = {
                                'name': size_name,
                                'quantity': size_quantity,
                                'price': size_price,
                                'discount': size_discount
                            }
                        }
                    });
                }

                $.ajax({
                           type: 'post',
                           url: '/admin/products/update/{{$product['id']}}',
                           data: {
                               'title': $('#title').val(),
                               'description': $('#description').code(),
                               'quantity': total_quantity,
                               'position': $('#input_position').val(),
                               'active': active,
                               'original_price': $('#input_original_price').val(),
                               'price': $('#input_price').val(),
                               'discount_price': $('#input_discount').val(),
                               'discount_start': $('#discount_start').val(),
                               'discount_end': $('#discount_end').val(),
                               'created_at': $('#created_at').val(),
                               'friendly_url': slug,
                               'page_title': $('#page_title').val(),
                               'meta_description': $('#meta_description').val(),
                               'meta_keywords': $('#meta_keywords').val(),
                               'related_products': $('#related_products').val(),
                               'categories': $('#categories').val(),
                               'main_category': $('#main_category').val(),
                               'sizes': sizes,
                               'tags': $('#tags').val(),
                               'manufacturer': $('#manufacturer').val(),
                               'colors': $('#colors').val(),
                               'material': $('#material').val(),
                               'dimensions_table': $('#dimensions_table').code(),
                           },
                           headers: {
                               'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                           },
                           success: function (response) {
                               if (typeof response == typeof {} && response['status'] && response['message']) {
                                   showNotification(response['status'], response['message']);

                                   if (response['status'] == 'success') {
                                       current_slug = slug;
                                   }
                               } else {
                                   showNotification('error', translate('request_not_completed'), translate('contact_support'));
                               }
                           },
                           error: function () {
                               showNotification('error', translate('request_not_completed'), translate('contact_support'));
                           }

                       });
            });

            //Sizes group change
            $('body').on('change', '#sizes_group', function () {
                var
                        group = $(this).val(),
                        holder = $('#sizes_holder');

                if (group) {
                    $.ajax({
                               type: 'get',
                               url: '/admin/products/show/sizes/' + group,
                               headers: {
                                   'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                               },
                               success: function (response) {
                                   if (response) {
                                       if (holder.length > 0) {
                                           holder.html(response);
                                       }
                                   }
                               },
                               error: function () {
                                   showNotification('error', translate('request_not_completed'), translate('contact_support'));
                               }

                           });
                }
            });

            //Dimensions table change
            $('body').on('change', '#load_table_template', function () {
                var id = $(this).val(),
                        holder = $('#dimensions_table');

                if (id) {
                    $.ajax({
                               type: 'get',
                               url: '/admin/products/show/render_table/' + id,
                               headers: {
                                   'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                               },
                               success: function (response) {
                                   if (response) {
                                       if (holder.length > 0) {
                                           console.log('Set response');
                                           holder.code(response);
                                       }
                                   }
                               },
                               error: function () {
                                   showNotification('error', translate('request_not_completed'), translate('contact_support'));
                               }

                           });
                }
            });

            //Seo URL

            if ($slug.val().length > 0) {
                url_from_name = false;
            } else {
                url_from_name = true;
            }

            function checkURL(url) {
                clearTimeout(timer);
                $.ajax({
                           type: 'get',
                           url: '/admin/products/show/check_url/' + url,
                           headers: {
                               'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                           },
                           success: function (response) {
                               if (typeof response == typeof {} && response['status'] && response['message']) {
                                   showNotification(response['status'], response['title'], response['message']);
                                   url_invalid = true;
                               } else {
                                   url_invalid = false;
                               }
                           },
                           error: function () {
                               showNotification('error', translate('request_not_completed'), translate('contact_support'));
                           }

                       });
            }

            function slugify(string) {
                if (string) {
                    var slug = $.slugify(string);
                    if ($slug.length > 0) {
                        $slug.addClass('edited');
                        $slug.val(slug);
                        checkURL(slug);
                    }

                    return slug;
                } else {
                    return '';
                }
            }

            if ($('#title').length > 0) {
                $('#title').on('keyup', function () {
                    if (url_from_name === true) {
                        clearTimeout(timeout);
                        var title = $(this).val();

                        timeout = setTimeout(function () {
                            slugify(title);
                        }, 500);
                    }
                });
            }

            if ($slug.length > 0) {
                $slug.on('keyup', function () {
                    clearTimeout(timer);
                    var url = $(this).val();

                    if (typeof url === typeof undefined || url === null || url.length == 0 || url == '') {
                        url_from_name = true;
                        $slug.removeClass('edited');
                    }

                    if (url) {
                        if ((current_slug.length > 0 && current_slug != url) || current_slug.length == 0) {
                            timer = setTimeout(function () {
                                url = slugify(url);
                                checkURL(url);
                                url_from_name = false;
                            }, 500);
                        }
                    }
                });
            }

            //Images grid
            imagesGrid();

            //Images save
            $('body').on('click', 'a.save_btn', function () {
                var images = getImages();

                $.ajax({
                           type: 'post',
                           url: '/admin/products/update/{{$product['id']}}',
                           data: {
                               'images': images,
                               'image_sync': true
                           },
                           headers: {
                               'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                           },
                           success: function (response) {
                               if (typeof response == typeof {} && response['status'] && response['message']) {
                                   showNotification(response['status'], response['message']);

                                   if (response['status'] == 'success') {
                                       window.location.replace('/admin/products/edit/{{$product['id']}}#images');
                                       location.reload();
                                   }
                               } else {
                                   showNotification('error', translate('request_not_completed'), translate('contact_support'));
                               }
                           },
                           error: function () {
                               showNotification('error', translate('request_not_completed'), translate('contact_support'));
                           }

                       });
            });

            //Image delete
            $('body').on('click', '.product-images a.remove_btn', function () {
                var images = getImages(),
                        remove_image = $(this).attr('data-image'),
                        parent = $(this).closest('.product-image-holder');

                //If images found remove
                $.ajax({
                           type: 'post',
                           url: '/admin/products/update/{{$product['id']}}',
                           data: {
                               'images': images,
                               'image_sync': true,
                               'remove_image': remove_image
                           },
                           headers: {
                               'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                           },
                           success: function (response) {
                               if (typeof response == typeof {} && response['status'] && response['message']) {
                                   showNotification(response['status'], response['message']);
                                   if (response['status'] == 'success') {
                                       parent.remove();
                                       imagesGrid();
                                   }
                               } else {
                                   showNotification('error', translate('request_not_completed'), translate('contact_support'));
                               }
                           },
                           error: function () {
                               showNotification('error', translate('request_not_completed'), translate('contact_support'));
                           }

                       });
            });

            function getImages() {
                var image_holder = $('.product-image-holder');

                if (image_holder.length > 0) {
                    var images = {};
                    //Loop trough images, get position, populate array
                    image_holder.each(function () {
                        var
                                position = $(this).find('.input-position').val(),
                                image = $(this).attr('data-image');

                        if (image) {
                            if (!position) {
                                position = 0;
                            }

                            images[image] = position;
                        }

                    });
                }

                if (images) {
                    return JSON.stringify(images);
                } else {
                    return false;
                }
            }

            $('body').on('click', '.save_material', function (e) {
                e.preventDefault();

                var
                        title = $('#add_material').val(),
                        position = 0,
                        url = 'store';

                $.ajax({
                           type: 'post',
                           url: '/admin/module/materials/' + url,
                           data: {
                               'title': title,
                               'position': position
                           },
                           headers: {
                               'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                           },
                           success: function (response) {
                               if (typeof response == typeof {} && response['status'] && response['message']) {
                                   showNotification(response['status'], response['message']);
                                   if (response['id']) {
                                       $('#material').append('<option value="' + response['id'] + '">' + title + '</option>');
                                       $('#material').val(response['id']).change();
                                   }
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

        $(window).resize(function () {
            imagesGrid();
        });

        $(window).on('orientationchange', function () {
            imagesGrid();
        });

        //Images grid
        function imagesGrid() {
            var image_holder = $('.product-image-holder'),
                    images_container = $('.product-images');
            if (images_container.length > 0) {
                //Clear last grid
                images_container.find('.clearfix').each(function () {
                });
                images_container.find('.clearfix').each(function () {
                    $(this).remove();
                });
                images_container.find('hr').each(function () {
                    $(this).remove();
                });
            }
            if (image_holder.length > 0) {
                var images_count = 0,
                        w_width = $(window).width(),
                        per_line = 1;

                //Mobile sizes
                if (w_width >= 768) {
                    per_line = 2
                }
                if (w_width >= 992) {
                    per_line = 3;
                }
                if (w_width >= 1200) {
                    per_line = 4;
                }

                $(image_holder).each(function () {
                    images_count++;

                    if (images_count == per_line) {
                        $(this).after('<div class="clearfix"></div> <hr />');
                        images_count = 0;
                    }
                });
            }
        }

    </script>
@endsection