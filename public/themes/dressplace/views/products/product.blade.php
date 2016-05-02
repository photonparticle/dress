@extends('dressplace::layout')

@section('content')

    @if(!empty($frame) && $frame === TRUE)
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="{{trans('client.close')}}"><span aria-hidden="true"><i class="fa fa-remove"></i></span></button>
            <h4 class="modal-title">{{trans('client.quick_buy_tip_lw')}}</h4>
        </div>
    @endif

    @if(empty($frame))
        <div class="container">
            @endif
            <div class="col-xs-12">
                <div class="section-title text-center">
                    <h1 class="no-margin">
                        <a href="/{{$product['slug']}}">
                            {{$product['title'] or ''}}
                        </a>
                    </h1>
                </div>
            </div>
            <div class="clearfix"></div>
            @if(empty($frame))
        </div>
    @endif

    <div class="product-container">
        <div class="single-product-area single no-padding"
             data-price="{{$product['price'] or 0}}"
             data-active-discount="{{$product['active_discount'] or  'false'}}"
             data-discount-price="{{$product['discount_price'] or 0}}"
             data-discount-percentage="{{$product['discount'] or 0}}"
             data-product-id="{{$product['id'] or 0}}"
        >
            @if(empty($frame))
                <div class="container">
                    <div class="row">
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

                        <div class="@if(!empty($frame) && $frame === TRUE) col-xs-12 @else col-lg-9 col-md-9 @endif">
                            <div class="row">
                                <div class="col-md-5 col-sm-5 col-xs-12">
                                    <div class="single-pro-tab-content">
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
                                </div>
                                <div class="col-md-7 col-sm-7 col-xs-12 shop-list">
                                    <div class="product-info">
                                        <div class="col-xs-12 col-md-5 no-padding">
                                            <div class="pro-price price_single">
                                                <h4>{{trans('client.price')}}</h4>
                                                @if(
                                               !empty($product['discount']) &&
                                               !empty($product['discount_price']) &&
                                               !empty($product['active_discount']))
                                                    <em class="normal item_price biggest"><span>{{$product['discount_price']}}</span> {{trans('client.currency')}}</em>
                                                    <em class="old item_old_price bigger"><span>{{$product['price']}}</span> {{trans('client.currency')}}</em>
                                                @else
                                                    <em class="normal item_price biggest"><span>{{$product['price']}}</span> {{trans('client.currency')}}</em>
                                                @endif

                                                @if(
                                    !empty($product['discount']) &&
                                    !empty($product['discount_price']) &&
                                    !empty($product['active_discount']))
                                                    <span class="discount no-float"
                                                          @if(
                                                          !empty($product['discount']) &&
                                                          !empty($product['discount_price']) &&
                                                          !empty($product['active_discount']))
                                                          title="{{trans('client.savings')}}"
                                                          data-toggle="tooltip"
                                                          data-placement="top"
                                                            @endif
                                                    ><span>-<span>{{$product['discount']}}</span>%</span></span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-md-7 call_us no-padding no-margin">
                                            <a href="tel:{{$sys['phone']}}" title="{{trans('client.call_us')}}">
                                                <div>
                                                    <i class="fa fa-phone"></i>
                                                </div>
                                                <div>
                                                    <span>{{trans('client.call_us')}}</span><br/>
                                                    <span>{{$sys['phone']}}</span>
                                                </div>
                                                <div class="clearfix"></div>
                                            </a>
                                        </div>

                                        <div class="col-xs-12 col-md-12 no-margin in-para no-padding">
                                            <div class="col-xs-12 product-main-info no-padding no-margin">
                                                <h4>{{trans('client.catalogue_number')}}: <strong>{{$product['id']}}</strong></h4>
                                                @if(!empty($product['related_colors']))
                                                    <p class="no-margin">
                                                        <strong>{{trans('client.colors')}}</strong><br/> {{$product['related_colors']}}
                                                    </p>
                                                @endif
                                                @if(!empty($product['manufacturer']))
                                                    <p class="no-margin">
                                                        <strong>{{trans('client.manufacturer')}}</strong><br/> {{$product['manufacturer']}}
                                                    </p>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="clearfix"></div>

                                        <div class="product-desc">
                                            {!! $product['description'] !!}
                                        </div>
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
                                            <div class="col-xs-12 buy-item-holder no-padding" data-title-disable="{{trans('client.choose_size')}}">
                                                <div class="quantity">
                                                    <h5>{{trans('client.quantity')}}</h5>
                                                    <div class="quantity-select">
                                                        <div class="rem"
                                                             title=""
                                                             data-toggle="tooltip"
                                                             data-placement="right"
                                                        ><i class="fa fa-minus"></i></div>

                                                        <div class="val"><span>1</span></div>

                                                        <div class="add"
                                                             title=""
                                                             data-toggle="tooltip"
                                                             data-placement="left"
                                                        ><i class="fa fa-plus"></i></div>
                                                    </div>
                                                </div>
                                                <!--quantity-->
                                                <div class="clearfix"></div>
                                                <a href="javascript:;"
                                                   class="add-to-cart"
                                                   title=""
                                                   data-toggle="tooltip"
                                                   data-placement="top"
                                                   data-title-disabled="{{trans('client.choose_size')}}"
                                                >
                                                    {{--<i class="fa fa-cart-arrow-down"></i>--}}
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
                            </div>

                            @if(empty($frame))
                                <div class="row">
                                    <div class="col-md-12 col-sm-12">
                                        <div class="product-tabs">
                                            <div>
                                                <!-- Nav tabs -->
                                                <ul class="pro-details-tab" role="tablist">
                                                    @if(!empty(trim($product['dimensions_table'])))
                                                        <li role="presentation" class="active">
                                                            <a href="#tab-table" aria-controls="tab-table" role="tab" data-toggle="tab">
                                                                {{trans('client.dimensions_table')}}
                                                            </a>
                                                        </li>
                                                    @endif
                                                    <li role="presentation" @if(empty(trim($product['dimensions_table']))) class="active" @endif>
                                                        <a href="#tab-delivery" aria-controls="tab-delivery" role="tab" data-toggle="tab">
                                                            {{trans('client.delivery_type')}}
                                                        </a>
                                                    </li>
                                                    <li role="presentation">
                                                        <a href="#tab-returns" aria-controls="tab-returns" role="tab" data-toggle="tab">
                                                            {{trans('client.returns')}}
                                                        </a>
                                                    </li>
                                                </ul>

                                                <!-- Tab panes -->
                                                <div class="tab-content">
                                                    @if(!empty(trim($product['dimensions_table'])))
                                                        <div role="tabpanel" class="tab-pane active" id="tab-table">
                                                            <div class="product-tab-desc">
                                                                {!! $product['dimensions_table'] or '' !!}
                                                            </div>
                                                        </div>
                                                    @endif
                                                    <div role="tabpanel" class="tab-pane @if(empty(trim($product['dimensions_table']))) active @endif" id="tab-delivery">
                                                        <div class="product-tab-desc">
                                                            <p>
                                                                {{trans('client.pr_delivery_tab_1')}}
                                                            </p>
                                                            <ul>
                                                                <li>{{trans('client.to_address_long')}} - {{$sys['delivery_to_address'] or '0'}} {{trans('client.currency')}}</li>
                                                                <li>{{trans('client.to_office_long')}} - {{$sys['delivery_to_office'] or '0'}} {{trans('client.currency')}}</li>
                                                            </ul>
                                                            <p>
                                                                {{trans('client.pr_delivery_tab_2')}}
                                                            </p>
                                                        </div>
                                                    </div>
                                                    <div role="tabpanel" class="tab-pane" id="tab-returns">
                                                        <div class="product-tab-desc">
                                                            {{trans('client.pr_returns_tab')}}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif


                        </div>
                        @if(empty($frame))
                                <!-- right-sidebar start -->
                        <div class="col-lg-3 col-md-3">

                            @if(!empty($recent) && is_array($recent))
                                    <!-- recent start -->
                            <aside class="widget widget-categories">
                                <h3 class="sidebar-title">{{trans('client.recent')}}</h3>
                                <div class="widget-curosel">
                                    <?php $products_to_render = $recent; $products_large = TRUE; ?>
                                    @include('dressplace::partials.render_products')
                                </div>
                            </aside>
                            <!-- recent end -->
                            @endif

                            @if(!empty($product['tags']) && is_array($product['tags']))
                                    <!-- widget-tags start -->
                            <aside class="widget widget-tags">
                                <h3 class="sidebar-title">{{trans('client.tags')}}</h3>
                                <ul>
                                    @foreach($product['tags'] as $tag)
                                        <li><a href="/search/tag/{{$tag}}">{{$tag}}</a></li>
                                    @endforeach
                                </ul>
                            </aside>
                            <!-- widget-tags end -->
                            @endif

                                    <!-- widget-recent start -->
                            <aside class="widget top-product-widget hidden-sm">
                                <h3 class="sidebar-title">{{$upcoming['title'] or ''}}</h3>
                                <div class="banner-curosel">
                                    <div class="banner">
                                        <a href="{{$products[$upcoming['product_id']]['slug']}}">
                                            <img
                                                    src="{{$thumbs_path . $upcoming['product_id'] . '/' . $icon_size . '/' .  $products[$upcoming['product_id']]['image']}}"
                                                    alt="{{$products[$upcoming['product_id']]['title']}}"
                                            />
                                        </a>
                                        <div class="upcoming-pro">
                                            <div data-countdown="{{$upcoming['date'] or ''}}"></div>
                                        </div>
                                    </div>
                                </div>
                            </aside>
                            <!-- widget-recent end -->
                        </div>
                        <!-- right-sidebar end -->
                        @endif

                        @if(empty($frame))
                    </div>
                </div>
            @endif
        </div>
    </div>
    <!-- single-product-area end -->
    <div class="clearfix"></div>

    @if(empty($frame))
        {{--CALLBACK ACTIONS--}}
        @include('dressplace::partials.render_callback_actions')
    @endif

    @if(empty($frame))
        <div class="container">
            <div class="row">
                {{-- RELATED PRODUCTS --}}
                @if(!empty($carousel) && is_array($carousel))
                    @include('dressplace::partials.render_carousel')
                @endif
                {{-- RELATED PRODUCTS --}}
            </div>
        </div>
    @endif

@endsection

@section('customJS')
    <script type="text/javascript">

        $(document).ready(function () {

            //Init image slider
            initProductSlider($('.products-flexslider'));
            validateAddToCart($('.product-container'));

            //Breadcrumbs
            initBreadCrumbs();
        });


    </script>
@endsection