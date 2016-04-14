@extends('dressplace::layout')

@section('content')

    @if(!empty($frame) && $frame === true)
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="{{trans('client.close')}}"><span aria-hidden="true"><i class="fa fa-remove"></i></span></button>
            <h4 class="modal-title">{{trans('client.quick_buy_tip_lw')}}</h4>
        </div>
    @endif

    @if(!empty($breadcrumbs) && is_array($breadcrumbs) && empty($frame))
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

    <div class="single"
         data-price="{{$product['price'] or 0}}"
         data-active-discount="{{$product['active_discount'] or  'false'}}"
         data-discount-price="{{$product['discount_price'] or 0}}"
         data-discount-percentage="{{$product['discount'] or 0}}"
         data-product-id="{{$product['id'] or 0}}"
    >

        @if(empty($frame))
            <div class="container">
                @endif
                <div class="col-md-12">
                    <div class="col-xs-12 col-md-5 products-slider-holder">
                        <div class="@if(empty($frame)) products-flexslider @else products-flexslider-box @endif">
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
                                <div class="col-xs-12 buy-item-holder" data-title-disable="{{trans('client.choose_size')}}">
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
                @if(empty($frame))
            </div>
        @endif
    </div>

    <div class="clearfix"></div>

    @if(empty($frame))
        {{-- RELATED PRODUCTS --}}
        @if(!empty($carousel) && is_array($carousel))
            @include('dressplace::partials.render_carousel')
        @endif
        {{-- RELATED PRODUCTS --}}
    @endif

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
    @if(empty($frame))
        @include('dressplace::partials.init_carousel')
    @endif
@endsection

@section('customJS')
    <script type="text/javascript">

        $(document).ready(function () {

            //Init image slider
            initProductSlider($('.products-flexslider'));
            validateAddToCart($('.page-content-wrapper'));

            //Breadcrumbs
            initBreadCrumbs();
        });


    </script>
@endsection