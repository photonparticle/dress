@extends('dressplace::layout')

@section('content')
    <div class="container">
        <div class="col-xs-12">
            <div class="section-title text-center">
                <h1 class="no-margin">
                    {{trans('client.order_preview')}}
                </h1>
            </div>
        </div>
        <div class="clearfix"></div>
    </div>
    <div class="container checkout-preview">
        @if(isset($new))
            <div class="col-xs-12 no-padding">
                <div class="order-completed">
                    <i class="fa fa-check" aria-hidden="true"></i>
                    <div class="text">
                        <h2>{{trans('client.order_completed')}}</h2>
                        <h3>{{trans('client.order_completed_tip')}}</h3>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
        @endif

        <div class="col-xs-12">

            <ul class="order-info">
                <li>
                    <h4>{{trans('client.order_number')}}</h4>
                    #{{$order_id or ''}}
                </li>
                <li>
                    <h4>{{trans('client.date_create')}}</h4>
                    {{$date_created or ''}}
                </li>
                <li>
                    <h4>{{trans('client.total_payable')}}</h4>
                    {{$order_total or 0}} {{trans('client.currency')}}
                </li>
                <li>
                    <h4>{{trans('client.delivery_type')}}</h4>
                    {{trans('client.' . $delivery_type . '_long')}}
                </li>
            </ul>

            <table class="table cart-table">
                <tr>
                    <th></th>
                    <th class="cart-item-desc">{{trans('client.product')}}</th>
                    <th class="text-center">{{trans('client.price')}}</th>
                    <th class="text-center">{{trans('client.subtotal')}}</th>
                </tr>
                @foreach($cart as $key => $item)
                    <tr class="cart-header">

                        {{--IMAGE--}}
                        <td style="max-width: 150px">
                            <a href="/{{$products[$item['product_id']]['slug'] or ''}}"
                               title="{{trans('client.view_product_tip')}}"
                               data-toggle="tooltip"
                               data-placement="right"
                               data-product-id="{{$item['product_id']}}"
                            >
                                <img
                                        src="{{$thumbs_path . $item['product_id'] . '/' . $icon_size . '/' .  $products[$item['product_id']]['image']}}"
                                        alt="{{$products[$item['product_id']]['image']}}"
                                        class="img-responsive lazy"
                                />
                            </a>
                        </td>
                        <td class="text-left cart-item-desc">
                            {{--TITLE--}}
                            <h3 class="no-margin"><a href="/{{$products[$item['product_id']]['slug'] or ''}}"
                                                     title="{{trans('client.view_product_tip')}}"
                                                     data-toggle="tooltip"
                                                     data-placement="bottom"
                                                     data-product-id="{{$item['product_id']}}"
                                >{{$products[$item['product_id']]['title'] or ''}}</a>
                            </h3>

                            {{--SIZE--}}
                            <h4 class="margin-top-10">{{trans('client.size')}}</h4>
                            <p class="size no-margin">
                                {{$item['size'] or ''}}
                            </p>
                            <div class="clearfix"></div>

                            {{--QUANTITY--}}
                            @if(isset($cart_preview))
                                <h4 class="margin-top-10">{{trans('client.quantity')}}</h4>
                                <p class="quantity no-margin" style="float: none">
                                    {{$item['quantity'] or 1}}
                                </p>
                                <div class="clearfix"></div>
                            @endif
                        </td>

                        <td class="text-center bigger">
                            <p>
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
                                        title="{{trans('client.savings')}}"
                                        data-toggle="tooltip"
                                        data-placement="bottom"
                                            @endif
                                    ><span>-<span>{{$item['discount'] or ''}}</span>%</span></em>
                                @endif
                            </p>
                        </td>

                        <td class="subtotal text-center bigger">
                            <p>
                                {{$item['subtotal'] or 0}} {{trans('client.currency')}}
                            </p>
                        </td>
                    </tr>
                @endforeach
            </table>
        </div>

        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 information">

            @if(!empty($order['status']))
                <h4>{{trans('client.order_status')}}</h4>
                {{trans('client.' . $order['status'])}}
            @endif

            <h4>{{trans('client.info_order')}}</h4>

            @if(!empty($order['email']))
                {{$order['email'] or ''}}
            @endif

            @if(!empty($order['name']))
                <br/>{{$order['name'] or ''}}
            @endif

            @if(!empty($order['last_name']))
                {{$order['last_name'] or ''}}
            @endif

            @if(!empty($order['phone']))
                <br/>{{$order['phone'] or ''}}
            @endif

            @if(!empty($order['address']))
                <br/>{{$order['address'] or ''}}
            @endif

            @if(!empty($order['city']))
                <br/>{{$order['city'] or ''}}
            @endif

            @if(!empty($order['state']))
                , {{trans('orders.'.$order['state'] . '')}}
            @endif

            @if(!empty($order['post_code']))
                <br/>{{$order['post_code'] or ''}}
            @endif

            @if(!empty($order['comment']))
                <h4>{{trans('client.comment')}}</h4>
                {{$order['comment'] or ''}}
            @endif

        </div>
        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
            <div class="col-xs-12 no-padding values">
                <table class="table pull-right">
                    <tr>
                        <td>
                            <h4 class="margin-top-10">{{trans('client.subtotal')}}</h4>
                        </td>
                        <td>
                            <h4 class="margin-top-10">
                                <span class="subtotal">{{$total}}</span> <span>{{trans('client.currency')}}</span>
                            </h4>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <h4 class="margin-top-10">{{trans('client.delivery_price')}}</h4>
                        </td>
                        <td>
                            @if(!empty($delivery_cost) && $delivery_cost > 0)
                                <div class="delivery_price">
                                    <h4 class="margin-top-10">
                                        <span class="delivery_price">{{$delivery_cost}}</span> <span>{{trans('client.currency')}}</span>
                                    </h4>
                                </div>
                            @else
                                <span class="delivery_price_free">{{trans('client.free')}}<br/>{{trans('client.delivery')}}</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <h4 class="margin-top-10">{{trans('client.total')}}</h4>
                        </td>
                        <td>
                            @if(!empty($order_total))
                                <h4 class="margin-top-10">
                                    <span class="total">{{$order_total}}</span> <span>{{trans('client.currency')}}</span>
                                </h4>
                            @endif
                        </td>
                    </tr>
                </table>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>
@endsection

@section('customJS')
    <script type="text/javascript">
        $(document).ready(function () {
            checkout($('.cart-container'));
        });
    </script>
@endsection