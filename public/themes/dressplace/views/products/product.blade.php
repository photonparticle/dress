@extends('dressplace::layout')

@section('content')
    {{--FLEX SLIDER TOP--}}
    @if(!empty($sliders) && is_array($sliders))
        @foreach($sliders as $key => $slider)
            @if((empty($slider['position']) || intval($slider['position']) < 2))
                @include('dressplace::partials.render_slider', $slider)
            @endif
        @endforeach
    @endif
    {{--FLEX SLIDER TOP--}}

    {{-- CAROUSELS TOP --}}
    @if(!empty($carousels) && is_array($carousels))
        @foreach($carousels as $carousel)
            @if(empty($carousel['position']) || (!empty($carousel['position']) && intval($carousel['position']) < 2))
                @include('dressplace::partials.render_carousel')
            @endif
        @endforeach
    @endif
    {{-- CAROUSELS TOP --}}

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
                                    <li data-thumb="{{$thumbs_path}}/{{$image}}">
                                        <div class="thumb-image">
                                            <img src="{{$md_path}}/{{$image}}" data-zoom-image="{{$images_path}}/{{$image}}" data-imagezoom="true" class="img-responsive product-image"/>
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
                            <div class="col-xs-12 col-md-6">
                                <p>{{trans('client.catalogue_number')}}: {{$product['id']}}</p>
                                <p>{{trans('client.colors')}}: {{$product['related_colors']}}</p>
                                <p>{{trans('client.manufacturer')}}: {{$product['manufacturer']}}</p>
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
                        <div class="wish-list">
                            {{--<ul>--}}
                                {{--<li class="wish"><a href="#"><span class="glyphicon glyphicon-check" aria-hidden="true"></span>Add to Wishlist</a></li>--}}
                                {{--<li class="compare"><a href="#"><span class="glyphicon glyphicon-resize-horizontal" aria-hidden="true"></span>Add to Compare</a></li>--}}
                            {{--</ul>--}}
                        </div>
                        <div class="quantity">
                            <div class="quantity-select">
                                <div class="entry value-minus">&nbsp;</div>
                                <div class="entry value"><span>1</span></div>
                                <div class="entry value-plus active">&nbsp;</div>
                            </div>
                        </div>
                        <!--quantity-->
                        <script>
                            $('.value-plus').on('click', function () {
                                var divUpd = $(this).parent().find('.value'), newVal = parseInt(divUpd.text(), 10) + 1;
                                divUpd.text(newVal);
                            });

                            $('.value-minus').on('click', function () {
                                var divUpd = $(this).parent().find('.value'), newVal = parseInt(divUpd.text(), 10) - 1;
                                if (newVal >= 1) divUpd.text(newVal);
                            });
                        </script>
                        <!--quantity-->

                        <a href="#" class="add-to item_add hvr-skew-backward">{{trans('client.add_to_cart')}}</a>
                        <div class="clearfix"></div>
                    </div>

                </div>
                <div class="clearfix"></div>
                <!---->
                <div class="tab-head">
                    <nav class="nav-sidebar">
                        <ul class="nav tabs">
                            <li class="active"><a href="#tab1" data-toggle="tab">{{trans('client.dimensions_table')}}</a></li>
                            <li class=""><a href="#tab2" data-toggle="tab">{{trans('client.delivery')}}</a></li>
                            <li class=""><a href="#tab3" data-toggle="tab">{{trans('client.returns')}}</a></li>
                        </ul>
                    </nav>
                    <div class="tab-content one">
                        <div class="tab-pane active text-style" id="tab1">
                            {!! $product['dimensions_table'] or '' !!}
                        </div>
                        <div class="tab-pane text-style" id="tab2">
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

    {{--FLEX SLIDER BOTTOM--}}
    @if(!empty($sliders) && is_array($sliders))
        @foreach($sliders as $key => $slider)
            @if((!empty($slider['position']) && intval($slider['position']) > 1))
                @include('dressplace::partials.render_slider', $slider)
            @endif
        @endforeach
    @endif
    {{--FLEX SLIDER BOTTOM--}}

    {{-- CAROUSELS BOTTOM --}}
    @if(!empty($carousels) && is_array($carousels))
        @foreach($carousels as $carousel)
            @if((!empty($carousel['position']) && intval($carousel['position']) > 1))
                @include('dressplace::partials.render_carousel')
            @endif
        @endforeach
    @endif
    {{-- CAROUSELS BOTTOM --}}

    {{--INIT MODULES--}}
    @include('dressplace::partials.init_slider')
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
                                       scrollZoom: true,
                                       imageCrossfade: true,
                                       easing: true,
                                       easingDuration: 500,
                                       responsive: true,
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
                                              productsSliderResize();
                                              $('.products-flexslider .flex-direction-nav').css({visibility: 'hidden'});
                                              var width = $('.thumb-image').width();
                                              $('.product-image').eq(0).addClass('zoom').css('width', width).css('height', 'auto');
                                              $('.zoomWindow').remove();
                                              createImageZoom();
                                          },
                                          after: function (slider) {
                                              productsSliderResize();
                                              $('.product-image').removeClass('zoom');
                                              var width = $('.thumb-image').width();
                                              $('.product-image').eq(slider.animatingTo).addClass('zoom').css('width', width).css('height', 'auto');
                                              $('.zoomWindow').remove();
                                              createImageZoom();
                                          }
                                      });

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

        });

        $(window).on("orientationchange", function () {
            productsSliderResize();
        });

        function productsSliderResize() {
            if (productsSlider.length > 0) {
                productsSlider.data('flexslider').resize();
                var width = $('.thumb-image').width();
                $('.product-image').css('width', width).css('height', 'auto');
                $('.zoomWindow').remove();
                createImageZoom();
            }
        }
    </script>
@endsection