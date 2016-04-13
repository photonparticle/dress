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
                    <div class="span_2_of_a1 simpleCart_shelfItem">
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
                            <div class="col-xs-12 col-md-6 call_us text-right">
                                <div>
                                    <span>{{trans('client.call_us')}}</span><br/>
                                    <span>{{$system['phone']}}</span>
                                </div>
                                <div>
                                    <i class="fa fa-mobile"></i>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                        <div class="price_single">
                            <h5>{{trans('client.price')}}</h5>
                            <p>
                                @if(isset($product['active_discount']) && $product['active_discount'] === TRUE)
                                    <em class="item_old_price">{{$product['discount_price']}} {{trans('client.currency')}}</em>
                                @endif
                                <em class="item_price">{{$product['price']}} {{trans('client.currency')}}</em>
                            </p>
                            <div class="clearfix"></div>
                        </div>
                        <h4 class="quick">{{trans('client.description')}}</h4>
                        <div class="quick_desc">
                            {!! $product['description'] !!}
                        </div>
                        <div class="sizes">
                            @if(!empty($product['sizes']) && is_array($product['sizes']))
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
                            @endif
                        </div>
                        <div class="col-xs-12">
                            <div class="quantity">
                                <h5>{{trans('client.quantity')}}</h5>
                                <div class="quantity-select">
                                    <div class="rem"><i class="fa fa-minus"></i></div>
                                    <div class="val"><span>1</span></div>
                                    <div class="add"><i class="fa fa-plus"></i></div>
                                </div>
                            </div>
                            <!--quantity-->
                            <script>
                                $('.quantity-select .rem').on('click', function () {
                                    var divUpd = $(this).parent().find('.val'),
                                            newVal = parseInt(divUpd.text(), 10) - 1;
                                    if (newVal >= 1) divUpd.text(newVal);
                                });

                                $('.quantity-select .add').on('click', function () {
                                    var divUpd = $(this).parent().find('.val'),
                                            newVal = parseInt(divUpd.text(), 10) + 1;
                                    if (newVal >= 1) divUpd.text(newVal);
                                });
                            </script>
                            <!--quantity-->
                            <div class="clearfix"></div>
                            <a href="javascript:;" class="add-to-cart">
                                <i class="fa fa-cart-arrow-down"></i>
                                {{trans('client.add_to_cart')}}
                            </a>
                        </div>
                        <div class="clearfix"></div>
                    </div>

                </div>
                <div class="clearfix"></div>
                <!---->
                <div class="tab-head">
                    <nav class="nav-sidebar">
                        <ul class="nav tabs">
                            @if(!empty($product['dimensions_table']))
                                <li class="active"><a href="#tab1" data-toggle="tab">{{trans('client.dimensions_table')}}</a></li>
                            @endif
                            <li class="@if(empty($product['dimensions_table'])) active @endif"><a href="#tab2" data-toggle="tab">{{trans('client.delivery')}}</a></li>
                            <li class=""><a href="#tab3" data-toggle="tab">{{trans('client.returns')}}</a></li>
                        </ul>
                    </nav>
                    <div class="tab-content one">
                        @if(!empty($product['dimensions_table']))
                            <div class="tab-pane active text-style" id="tab1">
                                {!! $product['dimensions_table'] or '' !!}
                            </div>
                        @endif
                        <div class="tab-pane text-style @if(empty($product['dimensions_table'])) active @endif" id="tab2">
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

    {{--INIT MODULES--}}
    @include('dressplace::partials.init_carousel')
    @include('dressplace::partials.init_products')
@endsection

@section('customJS')
    <script type="text/javascript">
        var productsSlider = $('.products-flexslider');
        var zoomContainer = $('.zoomContainer');

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

        $(document).ready(function () {

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
    </script>
@endsection