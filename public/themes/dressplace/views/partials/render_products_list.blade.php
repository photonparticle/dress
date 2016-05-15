<?php $shown_products = 0; ?>
@foreach($products_to_render as $product_id)
@if(!empty($products[$product_id]['image']) && !empty($products[$product_id]['slug']) && !empty($products[$product_id]['title']))
<?php $product_id = ! empty($product_id) ? intval($product_id) : FALSE; ?>
@if(!empty($product_id) && !empty($products[$product_id]) && !empty($products[$product_id]['image']) && !empty($products[$product_id]['slug']) && !empty($products[$product_id]['title']))
<?php $shown_products++; ?>
        <!-- single-product start -->
<div class="col-md-12 no-padding">
    <div class="single-product">
        <div class="product-img">
            <a href="/{{$products[$product_id]['slug']}}">
                <img class="primary-img" src="{{$thumbs_path . $product_id . '/' . $icon_size . '/' .  $products[$product_id]['image']}}" alt=""/>

                @if(empty($products[$product_id]['quantity']))
                    <div class="oos_overlay"></div>
                @endif
            </a>

            @if(
            !empty($products[$product_id]['discount']) &&
            !empty($products[$product_id]['discount_price']) &&
            !empty($products[$product_id]['active_discount']))
                <span class="sale">{{trans('client.sale')}}</span>
            @endif

        </div>
        <div class="product-info">
            <h3><a href="/{{$products[$product_id]['slug']}}">{{$products[$product_id]['title'] or ''}}</a></h3>
            <div class="pro-price">
                @if(
                        !empty($products[$product_id]['discount']) &&
                        !empty($products[$product_id]['discount_price']) &&
                        !empty($products[$product_id]['active_discount']))
                    <span class="normal pull-left">{{$products[$product_id]['discount_price']}} {{trans('client.currency')}}</span>
                    <span class="old pull-left">{{$products[$product_id]['price']}} {{trans('client.currency')}}</span>
                @else
                    <span class="normal pull-left">{{$products[$product_id]['price']}} {{trans('client.currency')}}</span>
                @endif
                @if(
                !empty($products[$product_id]['discount']) &&
                !empty($products[$product_id]['discount_price']) &&
                !empty($products[$product_id]['active_discount']))
                    <span class="discount pull-left"
                          @if(
                          !empty($products[$product_id]['discount']) &&
                          !empty($products[$product_id]['discount_price']) &&
                          !empty($products[$product_id]['active_discount']))
                          title="{{trans('client.savings')}}"
                          data-toggle="tooltip"
                          data-placement="top"
                            @endif
                    ><span>-<span>{{$products[$product_id]['discount']}}</span>%</span></span>
                @endif
                <div class="clearfix"></div>
            </div>
            <div class="product-action hidden-xs hidden-sm">
                <div class="pro-button-bottom">
                    <p class="catalogue_number text-left">{{trans('client.catalogue_number')}}: {{$product_id}} </p>
                    <p class="available_sizes text-left">{{trans('client.available_sizes')}}:</p>
                    <p class="text-left">{{$products[$product_id]['available_sizes'] or trans('client.oof')}}</p>
                </div>
                <div class="pro-button-top">
                    <a class="quick_buy_trigger"
                       href="/{{$products[$product_id]['slug']}}"
                       rel="title"
                       data-id="{{$product_id}}"
                    >
                        {{trans('client.quick_buy_tip_lw')}}
                    </a>
                </div>
            </div>
            <div class="product-desc" style="margin-top: 15px">
                <p>
                    {!! $products[$product_id]['description'] or '' !!}
                </p>
            </div>
        </div>
    </div>
</div>
<!-- single-product end -->
@endif
@endif
@endforeach
@if($shown_products == 0)
    <div class="section-title text-center">
        <h2>{{trans('client.no_products_to_show')}}</h2>
    </div>
@endif