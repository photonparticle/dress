@if(!empty($carousel['products']) && is_array($carousel['products']))
        <!-- Carousel start -->
<div class="new-product-area pad-bottom">
    <div class="col-lg-12">
        <div class="section-title text-center">
            <h2>{{$carousel['title'] or ''}}</h2>
        </div>
    </div>
</div>
<div class="row">
    <div class="product-carousel">

        <!-- single-product start -->
        @foreach($carousel['products'] as $key => $product_id)
            <?php $product_id = ! empty($product_id) ? intval($product_id) : FALSE; ?>
            @if(!empty($product_id) && !empty($products[$product_id]) && !empty($products[$product_id]['image']) && !empty($products[$product_id]['slug']) && !empty($products[$product_id]['title']))
                <div class="col-lg-12 padding-5">
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

                            <div class="product-action hidden-xs hidden-sm">
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
                @endforeach
                        <!-- single-product end -->

    </div>
    <!-- single-product end -->
</div>
@endif