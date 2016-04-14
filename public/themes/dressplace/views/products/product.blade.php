@extends('dressplace::layout')

@section('content')
    @if(!empty($breadcrumbs) && is_array($breadcrumbs))
        <ol class="breadcrumb product">
            {{--Home page--}}
            <li>
                <a href="/"
                   title="{{trans('client.home')}}"
                   data-toggle="tooltip"
                   data-placement="bottom"
                >
                    <i class="fa fa-home"></i>
                </a>
            </li>

            @foreach($breadcrumbs as $breadcrumb)
                @if(!empty($all_categories[$breadcrumb]['slug']) && !empty($all_categories[$breadcrumb]['title']))
                    <li>
                        <a href="{{$all_categories[$breadcrumb]['slug']}}"
                           title="{{$all_categories[$breadcrumb]['title']}}"
                           data-toggle="tooltip"
                           data-placement="bottom"
                        >
                            {{$all_categories[$breadcrumb]['title']}}
                        </a>
                    </li>
                @endif
            @endforeach

            <li>
                <a href="/{{$product['slug']}}"
                   title="{{$product['title']}}"
                   data-toggle="tooltip"
                   data-placement="bottom"
                >
                    {{$product['title']}}
                </a>
            </li>
        </ol>
        <div class="clearfix"></div>
    @endif

    <div class="single">

        <div class="container">
            <div class="col-md-12">
                <div class="col-xs-12 col-md-5 products-slider-holder">
                    <div class="products-flexslider">
                        <ul class="slides">
                            @if(!empty($product['images']) && is_array($product['images']))
                                @foreach($product['images'] as $image => $position)
                                    <li data-thumb="{{$product_thumbs_path}}/{{$image}}">
                                        <div class="thumb-image">
                                            <img src="{{$md_path}}/{{$image}}"
                                                 data-zoom-image="{{$images_path}}/{{$image}}"
                                                 data-imagezoom="true"
                                                 class="img-responsive product-image"
                                            />
                                            <div class="clearfix"></div>
                                            <a href="{{$images_path}}/{{$image}}" class="product-image-zoom">
                                                <i class="fa fa-search"></i>
                                                {{trans('client.zoom')}}
                                            </a>
                                        </div>
                                    </li>
                                @endforeach
                            @endif
                        </ul>
                    </div>
                </div>
                <div class="col-xs-12 col-md-7 single-top-in">
                    <div class="span_2_of_a1">
                        <h1>{{$product['title'] or ''}}</h1>
                        <div class="col-xs-12 col-md-12 in-para no-padding">
                            <div class="col-xs-12 col-md-6 product-main-info">
                                <p class="product-id">
                                    {{trans('client.catalogue_number')}}: {{$product['id']}}
                                </p>
                                @if(!empty($product['related_colors']))
                                    <p>
                                        {{trans('client.colors')}}: {{$product['related_colors']}}
                                    </p>
                                @endif
                                @if(!empty($product['manufacturer']))
                                    <p>
                                        {{trans('client.manufacturer')}}: {{$product['manufacturer']}}
                                    </p>
                                @endif
                            </div>
                            <div class="col-xs-12 col-md-6 call_us">
                                <div>
                                    <i class="fa fa-mobile"></i>
                                </div>
                                <div>
                                    <span>{{trans('client.call_us')}}</span><br/>
                                    <span>{{$sys['phone']}}</span>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                        @if(!empty($product['price']))
                            <div class="price_single">
                                <h5>{{trans('client.price')}}</h5>
                                <p>
                                    @if(isset($product['active_discount']) && $product['active_discount'] === TRUE)
                                        <em class="item_old_price"><span>{{$product['price']}}</span> {{trans('client.currency')}}</em>
                                        <em class="item_price"><span>{{$product['discount_price']}}</span> {{trans('client.currency')}}</em>
                                    @else
                                        <em class="item_price"><span>{{$product['price']}}</span> {{trans('client.currency')}}</em>
                                    @endif
                                    @if(isset($product['active_discount']) && $product['active_discount'] === TRUE)
                                        <em class="item_discount">{{trans('client.savings')}} <span><span>{{$product['discount']}}</span>%</span></em>
                                    @endif
                                </p>
                                <div class="clearfix"></div>
                            </div>
                        @endif
                        @if(!empty(trim($product['description'])))
                            <h4 class="quick">{{trans('client.description')}}</h4>
                            <div class="quick_desc">
                                {!! $product['description'] !!}
                            </div>
                        @endif
                        @if(!empty($product['sizes']) && is_array($product['sizes']))
                            <div class="sizes">
                                <h5>{{trans('client.available_sizes')}}</h5>
                                @foreach($product['sizes'] as $size)
                                    <button type="button"
                                            value="{{$size['name']}}"
                                            data-quantity="{{$size['quantity']}}"
                                            data-price="{{$size['price']}}"
                                            data-discount="{{$size['discount']}}"
                                            title="{{trans('client.available_quantities')}}: {{$size['quantity'] or 0}}"
                                            data-toggle="tooltip"
                                            data-placement="bottom"
                                    >{{$size['name']}}</button>
                                @endforeach
                            </div>
                        @endif
                        @if(!empty($product['sizes']) && is_array($product['sizes']))
                            <div class="col-xs-12 form-holder">
                                <div class="quantity">
                                    <h5>{{trans('client.quantity')}}</h5>
                                    <div class="quantity-select">
                                        <div class="rem"
                                             title=""
                                             data-toggle="tooltip"
                                             data-placement="bottom"
                                        ><i class="fa fa-minus"></i></div>

                                        <div class="val"><span>1</span></div>

                                        <div class="add"
                                             title=""
                                             data-toggle="tooltip"
                                             data-placement="bottom"
                                        ><i class="fa fa-plus"></i></div>
                                    </div>
                                </div>
                                <!--quantity-->
                                <div class="clearfix"></div>
                                <a href="javascript:;"
                                   class="add-to-cart"
                                   title=""
                                   data-toggle="tooltip"
                                   data-placement="bottom"
                                >
                                    <i class="fa fa-cart-arrow-down"></i>
                                    {{trans('client.add_to_cart')}}
                                </a>
                            </div>
                        @else
                            <div class="out_of_stock">
                                <h5>{{trans('client.out_of_stock')}}</h5>
                                <h6>{{trans('client.out_of_stock_2')}}</h6>
                            </div>
                        @endif
                        <div class="clearfix"></div>
                    </div>

                </div>
                <div class="clearfix"></div>
                <!---->
                <div class="tab-head">
                    <nav class="nav-sidebar">
                        <ul class="nav tabs">
                            @if(!empty(trim($product['dimensions_table'])))
                                <li class="active"><a href="#tab1" data-toggle="tab">{{trans('client.dimensions_table')}}</a></li>
                            @endif
                            <li class="@if(empty(trim($product['dimensions_table']))) active @endif"><a href="#tab2" data-toggle="tab">{{trans('client.delivery')}}</a></li>
                            <li class=""><a href="#tab3" data-toggle="tab">{{trans('client.returns')}}</a></li>
                        </ul>
                    </nav>
                    <div class="tab-content one">
                        @if(!empty(trim($product['dimensions_table'])))
                            <div class="tab-pane active text-style" id="tab1">
                                {!! $product['dimensions_table'] or '' !!}
                            </div>
                        @endif
                        <div class="tab-pane text-style @if(empty(trim($product['dimensions_table']))) active @endif" id="tab2">
                            <p>
                                Екипът на DressPlace.net изпраща всяка една заявена от Вас поръчка само с куриерска фирма Еконт Експрес. Обработката,потвърждаването и изпращането на Вашата пратка се осъществява в рамкита на 24 часа. Изключение правят само неделните дни и дните,които са обявени за национални празници. Съобразно тарифния план на куриерската фирма,при покупка на стойност до 50лв. цената на доставката е както следва:<br/>
                            </p>
                            <ul>
                                <li>до адрес на клиента - 7 лв.</li>
                                <li>до офис на Еконт Експрес - 4 лв.</li>
                            </ul>
                            <p>
                                При покупка на стойност над 50 лв. получавате бонус - БЕЗПЛАТНА ДОСТАВКА до всяка точка на България.
                            </p>
                        </div>
                        <div class="tab-pane text-style" id="tab3">

                            <p>
                                Всяка една от пратките,които изпращаме с куриерска фирма Еконт е с опция да се отвори,прегледа и тества преди да се заплати.При взето от Ваша страна решение да Не задържите продукта-откажете пратката на куриера.Ако все пак сте приели пратката,но по-късно решите да я върнете,молим това да стане в 7 дневен срок,съобразно ЗЗП.Единственото условие е продуктът да бъде в запазен търговски вид. Ако се окаже, че поръчаният размер не е Вашия, ние Ви гарантираме, че ще извършим замяна за друг размер/артикул или ще върнем сумата, която сте заплатили. Ако продуктът,който получите е дефектен или сгрешен,веднага се свържете с нас на посочените в сайта имейл или телефон.
                            </p>

                        </div>

                    </div>
                    <div class="clearfix"></div>
                </div>
                <!---->
            </div>
            <div class="clearfix"></div>
        </div>
    </div>

    <div class="clearfix"></div>

    {{-- RELATED PRODUCTS --}}
    @if(!empty($carousel) && is_array($carousel))
        @include('dressplace::partials.render_carousel')
    @endif
    {{-- RELATED PRODUCTS --}}

    {{--Added to cart Modal--}}

    <div class="modal fade" tabindex="-1" role="dialog" id="item-to-cart">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Modal title</h4>
                </div>
                <div class="modal-body">
                    <p>One fine body&hellip;</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

    {{--Added to cart Modal--}}

    {{--INIT MODULES--}}
    @include('dressplace::partials.init_carousel')
    @include('dressplace::partials.init_products')
@endsection

@section('customJS')
    <script type="text/javascript">

        var productsSlider = $('.products-flexslider');
        var zoomContainer = $('.zoomContainer');
        var price = 0;
        var main_price = '{{$product['price'] or 0}}';
        var quantity = 0;
        var size = '';
        var main_discounted_price = '{{$product['discount_price'] or 0}}';
        var main_discount = '{{$product['discount'] or 0}}';
        var discounted_price = 0;
        var discount = 0;
        var active_discount = '{{$product['active_discount'] or 'false'}}';
        var form_holder = $('.form-holder'),
                form_discount_price_item = '.price_single .item_old_price span',
                form_discount_item = '.price_single .item_discount span span',
                form_price_item = '.price_single .item_price span',
                form_sizes_btn = '.sizes button',
                form_sizes_active = '.sizes button.active',
                form_sizes_btn_disabled = '.sizes button.disabled',
                form_confirm = 'a.add-to-cart',
                form_q_rem = '.quantity div.rem',
                form_q_add = '.quantity div.add',
                form_q_val = '.quantity div.val span',
                form_title_disabled = '{{trans('client.choose_size')}}';

        //Form

        var form_disabled = function () {
            $(form_confirm).addClass('disabled').attr('title', form_title_disabled);
            $(form_q_rem).addClass('disabled').attr('title', form_title_disabled);
            $(form_q_add).addClass('disabled').attr('title', form_title_disabled);
        };
        var form_enabled = function () {
            $(form_confirm).removeClass('disabled').attr('title', '').attr('data-original-title', '');
            $(form_q_rem).removeClass('disabled').attr('title', '').attr('data-original-title', '');
            $(form_q_add).removeClass('disabled').attr('title', '').attr('data-original-title', '');
        };

        $(form_sizes_btn).click(function () {
            if ($(this).hasClass('active')) {
                $(form_sizes_btn).addClass('disabled').removeClass('active');
                $(this).removeClass('active').addClass('disabled').blur();
            } else {
                $(form_sizes_btn).addClass('disabled').removeClass('active');
                $(this).removeClass('disabled').addClass('active');
            }

            //If no size
            if ($(form_sizes_btn_disabled).length == $(form_sizes_btn).length) {
                $(form_sizes_btn).removeClass('disabled');
                discount = main_discount;
                price = main_price;
                discounted_price = main_discounted_price;

                form_disabled();
            } else {
                //If size
                size = $(form_sizes_active).attr('value');
                price = $(form_sizes_active).attr('data-price');
                if (active_discount == 'true' || active_discount == 1) {
                    discounted_price = $(form_sizes_active).attr('data-discount');
                    quantity = $(form_sizes_active).attr('data-quantity');
                }
                if (price > 0) {
                    if (isInt(price)) {
                        price = parseInt(price);
                    } else {
                        price = parseFloat(price).toFixed(2);
                    }
                } else {
                    price = 0;
                }

                if (active_discount == 'true' || active_discount == 1) {
                    if (discounted_price > 0) {
                        if (isInt(discounted_price)) {
                            discounted_price = parseInt(discounted_price);
                        } else {
                            discounted_price = parseFloat(discounted_price).toFixed(2);
                        }
                    } else {
                        discounted_price = 0;
                    }

                    if (price > 0 && discounted_price > 0) {
                        discount = parseFloat((price - discounted_price) / price * 100).toFixed();
                    } else {
                        discount = 0;
                    }
                }

                form_enabled();
            }

            //Visual
            if (price > 0) {
                $(form_price_item).html(price);
            } else {
                price = main_price;
            }

            if (active_discount == 'true' || active_discount == 1) {
                $(form_price_item).html(discounted_price);
                $(form_discount_price_item).html(price);
                $(form_discount_item).html(discount);
            }
        });

        //Quantity remove
        $(form_q_rem).on('click', function () {
            if (!$(this).hasClass('disabled')) {
                var divUpd = $(form_q_val),
                        newVal = parseInt(divUpd.text(), 10) - 1;
                if (newVal >= 1) divUpd.text(newVal);
            }
        });

        //Quantity add
        $(form_q_add).on('click', function () {
            if (!$(this).hasClass('disabled')) {
                var divUpd = $(form_q_val),
                        newVal = parseInt(divUpd.text(), 10) + 1;
                if (quantity > 0) {
                    if (newVal <= quantity) divUpd.text(newVal);
                } else {
                    if (newVal = 0) divUpd.text(newVal);
                }
            }
        });

        //Add to cart button
        $(form_confirm).click(function () {
            if (!$(this).hasClass('disabled')) {
                var data = {};
                data['product_id'] = '{{$product['id']}}';
                data['size'] = size;
                data['price'] = price;
                data['quantity'] = $(form_q_val).text();

                if (active_discount == 'true' || active_discount == 1) {
                    data['active_discount'] = 'true';
                    data['discount_price'] = discounted_price;
                    data['discount'] = discount;
                }

                if (data) {
                    $.ajax({
                               type: 'post',
                               url: '/cart/add',
                               data: data,
                               success: function (response) {
                                   if (typeof response == typeof {} && response['success'] == true) {
                                       $('#item-to-cart').modal('toggle');
                                   }
                               }
                           });
                }
            }
        });

        //Disable form on load
        form_disabled();

        function isInt(n) {
            return n % 1 === 0;
        }

        $(document).ready(function () {

            /* Modals */

            // CENTERED MODALS
            // phase one - store every dialog's height
            $('.modal').each(function () {
                var t = $(this),
                        d = t.find('.modal-dialog'),
                        fadeClass = (t.is('.fade') ? 'fade' : '');
                // render dialog
                t.removeClass('fade')
                        .addClass('invisible')
                        .css('display', 'block');
                // read and store dialog height
                d.data('height', d.height());
                // hide dialog again
                t.css('display', '')
                        .removeClass('invisible')
                        .addClass(fadeClass);
            });

            // phase two - set margin-top on every dialog show
            $('.modal').on('show.bs.modal', function () {
                var t = $(this),
                        d = t.find('.modal-dialog'),
                        dh = d.data('height'),
                        w = $(window).width(),
                        h = $(window).height();
                // if it is desktop & dialog is lower than viewport
                // (set your own values)
                if (w > 380 && (dh + 60) < h) {
                    d.css('margin-top', Math.round(0.96 * (h - dh) / 2));
                } else {
                    d.css('margin-top', '');
                }
            });

            //Zoom
            function createImageZoom() {
                $('.zoom').elevateZoom({
                                           zoomType: "inner",
                                           cursor: 'crosshair',
//                                       scrollZoom: true,
                                           imageCrossfade: true,
                                           easing: true,
                                           easingDuration: 500,
                                           responsive: true,
//                                       zoomWindowOffsety: -1
                                       });
            }

//Product image slider
            productsSlider.flexslider({
                                          animation: "slide",
                                          controlNav: "thumbnails",
                                          easing: 'swing',
                                          animationSpeed: 1000,
                                          touch: true,
                                          arrows: false,
                                          keyboard: false,
                                          animationLoop: false,
                                          slideshow: false,
                                          initDelay: 0,
                                          mousewheel: false,
                                          smoothHeight: true,
                                          start: function () {
                                              $('.products-flexslider .flex-direction-nav').css({visibility: 'hidden'});
                                              var window_width = $(window).width();
                                              var width = $('.thumb-image').width();
                                              $('.product-image').eq(0).addClass('zoom').css('width', width).css('height', 'auto');
                                              colorbox();

                                              setTimeout(function () {
                                                  productsSliderResize();
                                                  if (window_width >= 768) {
                                                      $('.zoomContainer').each(function () {
                                                          $(this).remove();
                                                      });
                                                      createImageZoom();
                                                  }
                                              }, 500);
                                          },
                                          before: function (slider) {
                                              var window_width = $(window).width();
                                              if (window_width >= 768) {
                                                  $('.zoomContainer').each(function () {
                                                      $(this).remove();
                                                  });
                                              }
                                          },
                                          after: function (slider) {
                                              var window_width = $(window).width();
                                              var width = $('.thumb-image').width();
                                              $('.product-image').removeClass('zoom');
                                              $('.product-image').eq(slider.animatingTo).addClass('zoom').css('width', width).css('height', 'auto');
                                              colorbox(slider.animatingTo);

                                              setTimeout(function () {
                                                  productsSliderResize();

                                                  if (window_width >= 768) {
                                                      $('.zoomContainer').each(function () {
                                                          $(this).remove();
                                                      });
                                                      createImageZoom();

                                                  }
                                              }, 500);
                                          }
                                      })
            ;

            var resizeEnd;

            $(window).on('resize', function () {
                clearTimeout(resizeEnd);
                resizeEnd = setTimeout(function () {
                    productsSliderResize();
                }, 250);
            });

//End slider

//Breadcrumbs
            if ($('ol.breadcrumb').length > 0) {
                $('ol.breadcrumb li:last-child').addClass('active');
            }

            function colorbox(el) {
                if (!el) {
                    el = 0;
                } else {
                    $.colorbox.remove();
                }
                $(".product-image-zoom").eq(el).colorbox({
                                                             rel: '{{$product['title'] or ''}}',
                                                             transition: 'elastic',
                                                             speed: 1000,
                                                             scrolling: false,
                                                             opacity: 0.9,
                                                             fadeOut: 500,
                                                             maxWidth: '100%',
                                                             maxHeight: '100%'
                                                         });
            }

        })
        ;

        $(window).on("orientationchange", function () {
            productsSliderResize();
        });

        function productsSliderResize() {
            if (productsSlider.length > 0) {
                productsSlider.data('flexslider').resize()
            }
        }

        $.ajaxPrefilter(function (options) {
            if (!options.beforeSend) {
                options.beforeSend = function (xhr) {
                    xhr.setRequestHeader('X-CSRF-Token', $('meta[name="csrf-token"]').attr('content'));
                }
            }
        });
    </script>
@endsection