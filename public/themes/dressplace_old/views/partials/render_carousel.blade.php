@if(!empty($carousel['products']))
    <div class="content-mid carousel-holder">
        <h3>{{$carousel['title']}}</h3>
        <div class="line"></div>
        <div class="mid-popular carousel">

            @if(!empty($carousel['products']) && is_array($carousel['products']))
                @foreach($carousel['products'] as $product_id)
                    @if(!empty($products[$product_id]['image']) && !empty($products[$product_id]['slug']) && !empty($products[$product_id]['title']))
                        <div class="item-grid simpleCart_shelfItem">
                            <div class=" mid-pop">
                                <div class="pro-img">
                                    <img src="" data-lazy="{{$thumbs_path . $product_id . '/' . $icon_size . '/' .  $products[$product_id]['image']}}" alt="{{$products[$product_id]['image']}}" class="img-responsive lazy"/>
                                    <div class="zoom-icon ">
                                        <a class="quick_buy_trigger" href="/{{$products[$product_id]['slug']}}" rel="title" data-id="{{$product_id}}">
                                            <i class="fa fa-cart-plus icon" title="{{trans('client.quick_buy_tip')}}" data-toggle="tooltip" data-placement="top"></i>
                                        </a>
                                        <a href="{{$products[$product_id]['slug']}}">
                                            <i class="fa fa-search icon" data-toggle="tooltip" data-placement="top" title="{{trans('client.view_product_tip')}}"></i>
                                        </a>
                                    </div>
                                </div>
                                <div class="mid-1">
                                    <h6 class="product-title">
                                        <a href="{{$products[$product_id]['slug']}}" data-toggle="tooltip" data-placement="bottom" title="{{trans('client.view_product_tip')}}">
                                            {{$products[$product_id]['title'] or ''}}
                                        </a>
                                    </h6>
                                    <div class="clearfix"></div>
                                    <div class="mid-2">
                                        <p>
                                            @if(
                                            !empty($products[$product_id]['discount']) &&
                                            !empty($products[$product_id]['discount_price']) &&
                                            !empty($products[$product_id]['active_discount']))
                                                <em class="item_old_price">{{$products[$product_id]['discount_price']}} {{trans('client.currency')}}</em>
                                            @endif

                                            <em class="item_price">{{$products[$product_id]['price']}} {{trans('client.currency')}}</em>

                                            @if(
                                            !empty($products[$product_id]['discount']) &&
                                            !empty($products[$product_id]['discount_price']) &&
                                            !empty($products[$product_id]['active_discount']))
                                                <em class="item_discount"
                                                    @if(
                                                    !empty($products[$product_id]['discount']) &&
                                                    !empty($products[$product_id]['discount_price']) &&
                                                    !empty($products[$product_id]['active_discount']))
                                                    title="{{trans('client.savings')}}"
                                                    data-toggle="tooltip"
                                                    data-placement="top"
                                                        @endif
                                                ><span>-<span>{{$products[$product_id]['discount']}}</span>%</span></em>
                                            @endif
                                        </p>
                                        <div class="img item_add">
                                            <a class="quick_buy quick_buy_trigger" href="/{{$products[$product_id]['slug']}}" rel="title" data-id="{{$product_id}}" title="{{trans('client.quick_buy_tip')}}" data-toggle="tooltip" data-placement="top">
                                                <i class="fa fa-cart-plus icon"></i>
                                            </a>
                                        </div>
                                        <div class="clearfix"></div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach
            @endif

        </div>
    </div>
    <div class="clearfix"></div>
@endif