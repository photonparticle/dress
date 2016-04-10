@if(!empty($carousel['products']))
<div class="content-mid margin-top-50">
    <h3>{{$carousel['title']}}</h3>
    <div class="line"></div>
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
                        <h6 class="product-title">
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
<div class="clearfix"></div>
@endif