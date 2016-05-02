<?php $shown_products = 0; ?>
@foreach($products_to_render as $product_id)
    @if(!empty($products[$product_id]['image']) && !empty($products[$product_id]['slug']) && !empty($products[$product_id]['title']))
        <?php $product_id = ! empty($product_id) ? intval($product_id) : FALSE; ?>
        @if(!empty($product_id) && !empty($products[$product_id]) && !empty($products[$product_id]['image']) && !empty($products[$product_id]['slug']) && !empty($products[$product_id]['title']))
            <?php $shown_products++; ?>
            <div class="col-xs-12 @if(empty($products_large)) col-sm-4 col-md-4 col-lg-4 @endif padding-5">
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

                        @if(empty($products_large))
                            <div class="product-action">
                                <div class="pro-button-top">
                                    <a class="quick_buy_trigger"
                                       href="/{{$products[$product_id]['slug']}}"
                                       rel="title"
                                       data-id="{{$product_id}}"
                                    >
                                        {{trans('client.quick_buy_tip_lw')}}
                                    </a>
                                </div>
                                <div class="pro-button-bottom">
                                    <p class="catalogue_number">{{trans('client.catalogue_number')}}: {{$product_id}} </p>
                                    <p class="available_sizes">{{trans('client.available_sizes')}}:</p>
                                    <p>{{$products[$product_id]['available_sizes'] or trans('client.oof')}}</p>
                                </div>
                            </div>
                        @endif
                    </div>
                    <div class="product-info">
                        <h3>
                            <a href="/{{$products[$product_id]['slug']}}">
                                {{$products[$product_id]['title'] or ''}}
                            </a>
                        </h3>
                        <div class="pro-price">
                            @if(
                                    !empty($products[$product_id]['discount']) &&
                                    !empty($products[$product_id]['discount_price']) &&
                                    !empty($products[$product_id]['active_discount']))
                                <span class="normal">{{$products[$product_id]['discount_price']}} {{trans('client.currency')}}</span>
                                <span class="old">{{$products[$product_id]['price']}} {{trans('client.currency')}}</span>
                            @else
                                <span class="normal">{{$products[$product_id]['price']}} {{trans('client.currency')}}</span>
                            @endif
                        </div>

                        @if(
                        !empty($products[$product_id]['discount']) &&
                        !empty($products[$product_id]['discount_price']) &&
                        !empty($products[$product_id]['active_discount']))
                            <span class="discount"
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
                    </div>
                </div>
            </div>
        @endif
    @endif
@endforeach

@if($shown_products == 0)
    <div class="section-title text-center">
        <h2>{{trans('client.no_products_to_show')}}</h2>
    </div>
@endif