@if(!empty($cart) && is_array($cart))
    @foreach($cart as $key => $item)
        <li>
            <div class="cart-img">
                <a href="/{{$products[$item['product_id']]['slug']}}">
                    <img src="{{$thumbs_path . $item['product_id'] . '/' . $icon_size . '/' .  $products[$item['product_id']]['image']}}" alt=""/>
                </a>
                <span>{{$item['quantity']}}</span>
            </div>
            <div class="cart-info">
                <h4 class="no-margin">
                    <a href="/{{$products[$item['product_id']]['slug']}}">
                        {{$products[$item['product_id']]['title']}}
                    </a>
                </h4>
                <span>
                        @if(
                                                    !empty($item['discount']) &&
                                                    !empty($item['discount_price']) &&
                                                    !empty($item['active_discount']))
                        <em class="normal item_price">{{$item['discount_price'] or ''}} {{trans('client.currency')}}</em>
                        <em class="old item_old_price">{{$item['price'] or ''}} {{trans('client.currency')}}</em>
                    @else
                        <em class="normal item_price">{{$item['price'] or ''}} {{trans('client.currency')}}</em>
                    @endif

                    @if(
                    !empty($item['discount']) &&
                    !empty($item['discount_price']) &&
                    !empty($item['active_discount']))
                        <em class="discount no-float item_discount"
                        @if(
                        !empty($item['discount']) &&
                        !empty($item['discount_price']) &&
                        !empty($item['active_discount']))
                                @endif
                        ><span>-<span>{{$item['discount'] or ''}}</span>%</span></em>
                    @endif
                </span>
                <span class="more-info">{{trans('client.size')}} {{$item['size']}}, {{trans('client.quantity')}} {{$item['quantity']}}</span>
            </div>
        </li>
    @endforeach
    <li>
        <div class="subtotal-text">{{trans('client.total')}}</div>
        <div class="subtotal-price">{{$total or ''}} {{trans('client.currency')}}</div>
        <div class="clearfix"></div>
        <a href="/cart" class="btn">
            {{trans('client.create_order')}}
        </a>
    </li>
@else
    <h4>{{trans('client.cart_empty')}}</h4>
@endif