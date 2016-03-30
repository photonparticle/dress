@extends('dressplace::layout')

@section('content')
    {{--FLEX SLIDER--}}
    <div class="slider-holder">
        <div class="flexslider">
            <ul class="slides">
                <li class="top-left">
                    <img src="images/banner-1.jpg"/>
                    <div class="captions">
                        <div class="captions-holder">
                            <p class="flex-caption">Мъжки тениски</p>
                            <div class="clearfix"></div>
                            <p class="flex-sub-caption">Тотална разпродажба</p>
                            <div class="clearfix"></div>
                            <a href="#" class="action-btn">
                                Виж всички
                            </a>
                        </div>
                    </div>
                </li>
                <li class="top-right">
                    <img src="images/banner-2.jpg"/>
                    <div class="captions">
                        <div class="captions-holder">
                            <p class="flex-caption">Дамски туники</p>
                            <div class="clearfix"></div>
                            <p class="flex-sub-caption">Стилни, удобни и качествени</p>
                            <div class="clearfix"></div>
                            <a href="#" class="action-btn">
                                Виж всички
                            </a>
                        </div>
                    </div>
                </li>
                <li class="bottom-left">
                    <img src="images/banner-3.jpg"/>
                    <div class="captions">
                        <div class="captions-holder">
                            <p class="flex-caption">Къси мъжки дънки</p>
                            <div class="clearfix"></div>
                            <p class="flex-sub-caption">Страхотни модели на ниски цени</p>
                            <div class="clearfix"></div>
                            <a href="#" class="action-btn">
                                Разгледай
                            </a>
                        </div>
                    </div>
                </li>
                <li class="bottom-right">
                    <img src="images/banner-4.jpg"/>
                    <div class="captions">
                        <div class="captions-holder">
                            <p class="flex-caption">Мъжки якета</p>
                            <div class="clearfix"></div>
                            <p class="flex-sub-caption">Високо качество на много ниски цени</p>
                            <div class="clearfix"></div>
                            <a href="#" class="action-btn">
                                Виж оше
                            </a>
                        </div>
                    </div>
                </li>
                <li class="top-left">
                    <img src="images/banner-5.jpg"/>
                    <div class="captions">
                        <div class="captions-holder">
                            <p class="flex-caption" style="color: #000000 !important;">Дамски тениски</p>
                            <div class="clearfix"></div>
                            <p class="flex-sub-caption" style="color: #ff0000 !important;">Свобода и прохлада през лятото</p>
                            <div class="clearfix"></div>
                            <a href="#" class="action-btn">
                                Виж нашите предложения
                            </a>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </div>

    {{--CAROUSELS--}}
    @if(!empty($carousels) && is_array($carousels))
    @foreach($carousels as $carousel)
    @if(!empty($carousel['products']))
            <!--Carousel-->
    <div class="content-mid margin-top-50">
        <h3>{{$carousel['title']}}</h3>
        <label class="line"></label>
        <div class="mid-popular carousel">

            @foreach($carousel['products'] as $product_id)
                <div class="item-grid simpleCart_shelfItem">
                    <div class=" mid-pop">
                        <div class="pro-img">
                            <img src="" data-lazy="{{$thumbs_path . $product_id . '/' . $icon_size . '/' .  $products[$product_id]['image']}}" alt="{{$products[$product_id]['image']}}" class="img-responsive lazy"/>
                            <div class="zoom-icon ">
                                <a class="picture b-link-stripe b-animate-go  thickbox" href="images/pc.jpg" rel="title">
                                    <i class="fa fa-cart-plus icon" title="{{trans('client.quick_buy_tip')}}" data-toggle="tooltip" data-placement="top"></i>
                                </a>
                                <a href="single.html">
                                    <i class="fa fa-search icon" data-toggle="tooltip" data-placement="top" title="{{trans('client.view_product_tip')}}"></i>
                                </a>
                            </div>
                        </div>
                        <div class="mid-1">
                            <h6>
                                <a href="single.html" data-toggle="tooltip" data-placement="bottom" title="{{trans('client.view_product_tip')}}">
                                    {{$products[$product_id]['title'] or ''}}
                                </a>
                            </h6>
                            <div class="clearfix"></div>
                            <div class="mid-2">
                                <p>
                                    @if(!empty($products[$product_id]['discount_price']))
                                        <em class="item_old_price">{{$products[$product_id]['discount_price']}} {{trans('client.currency')}}</em>
                                    @endif
                                    <em class="item_price">{{$products[$product_id]['price']}} {{trans('client.currency')}}</em>
                                </p>
                                <div class="img item_add">
                                    <a class="quick_buy b-link-stripe b-animate-go  thickbox" href="images/pc.jpg" rel="title" title="{{trans('client.quick_buy_tip')}}" data-toggle="tooltip" data-placement="top">
                                        <i class="fa fa-cart-plus icon"></i>
                                    </a>
                                </div>
                                <div class="clearfix"></div>
                            </div>

                        </div>
                    </div>
                </div>
            @endforeach

        </div>
    </div>
    <!--//Carousel-->
    @endif
    @endforeach
    @endif
@endsection

@section('customJS')
    <script type="text/javascript">
        var flexSlider = $('.flexslider');
        var $flexSlider;

        $(document).ready(function () {

            //Init all tooltips
            $('[data-toggle="tooltip"]').tooltip();

            //Init Slider
            flexSlider.flexslider({
                                      animation: "slide",
                                      easing: 'swing',
                                      animationSpeed: 1000,
                                      touch: true,
                                      keyboard: true,
                                      animationLoop: true,
                                      slideshow: true,
                                      slideshowSpeed: 7000,
                                      initDelay: 0,
                                      pauseOnHover: true,
                                      mousewheel: true,
                                  });

            //Init all carousels
            $('.carousel').slick({
                                     centerMode: false,
                                     cssEase: 'ease-in-out',
                                     fade: false,
                                     slidesToShow: 4,
                                     slidesToScroll: 4,
                                     arrows: true,
                                     autoplay: true,
                                     autoplaySpeed: 3000,
                                     lazyLoad: 'progressive',
                                     dots: true,
                                     infinite: true,
                                     pauseOnHover: true,
                                     speed: 500,
                                     responsive: [
                                         {
                                             breakpoint: 1024,
                                             settings: {
                                                 arrows: false,
                                                 dots: true,
                                                 slidesToShow: 3,
                                                 slidesToScroll: 3
                                             }
                                         },
                                         {
                                             breakpoint: 768,
                                             settings: {
                                                 arrows: false,
                                                 dots: false,
                                                 slidesToShow: 2,
                                                 slidesToScroll: 2
                                             }
                                         },
                                         {
                                             breakpoint: 480,
                                             settings: {
                                                 arrows: false,
                                                 dots: false,
                                                 slidesToShow: 1,
                                                 slidesToScroll: 1
                                             }
                                         }
                                     ]
                                 });
            var resizeEnd;
            $(window).on('resize', function () {
                clearTimeout(resizeEnd);
                resizeEnd = setTimeout(function () {
                    flexsliderResize();
                }, 250);
            });
        });

        $(window).on("orientationchange", function () {
            flexsliderResize();
        });

        function flexsliderResize() {
            if (flexSlider.length > 0) {
                flexSlider.data('flexslider').resize();
            }
        }
    </script>
@endsection