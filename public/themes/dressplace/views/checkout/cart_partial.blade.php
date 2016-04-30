@if(!empty($cart) && is_array($cart))
    <div class="cart-container @if(isset($cart_preview)) no-padding @endif"
         data-delivery-free-delivery="{{$sys['delivery_free_delivery'] or 999999}}"
         data-delivery-to-address="{{$sys['delivery_to_address'] or 0}}"
         data-delivery-to-office="{{$sys['delivery_to_office'] or 0}}"
    >
        <div class="bs-example4" data-example-id="simple-responsive-table">
            <div class="table-responsive">
                <table class="table table-striped table-heading text-center cart-holder @if(isset($ajax)) ajax @endif">
                    <tr>
                        <th></th>
                        <th>{{trans('client.product')}}</th>
                        @if(!isset($cart_preview))
                            <th>{{trans('client.quantity')}}</th>
                        @endif
                        <th>{{trans('client.subtotal')}}</th>
                        @if(!isset($cart_preview))
                            <th>{{trans('client.actions')}}</th>
                        @endif
                    </tr>
                    @foreach($cart as $key => $item)
                        <tr class="cart-header">

                            {{--IMAGE--}}
                            <td>
                                <a href="/{{$products[$item['product_id']]['slug'] or ''}}"
                                   title="{{trans('client.view_product_tip')}}"
                                   data-toggle="tooltip"
                                   data-placement="right"
                                   data-product-id="{{$item['product_id']}}"
                                   class="quick_buy_trigger">
                                    <img
                                            @if(!isset($ajax))
                                            src=""
                                            data-src="{{$thumbs_path . $item['product_id'] . '/' . $icon_size . '/' .  $products[$item['product_id']]['image']}}"
                                            @else
                                            src="{{$thumbs_path . $item['product_id'] . '/' . $icon_size . '/' .  $products[$item['product_id']]['image']}}"
                                            @endif
                                            alt="{{$products[$item['product_id']]['image']}}"
                                            class="img-responsive lazy"
                                    />
                                </a>
                            </td>
                            <td>
                                {{--TITLE--}}
                                <h3><a href="/{{$products[$item['product_id']]['slug'] or ''}}"
                                       title="{{trans('client.view_product_tip')}}"
                                       data-toggle="tooltip"
                                       data-placement="bottom"
                                       data-product-id="{{$item['product_id']}}"
                                       class="quick_buy_trigger"
                                    >{{$products[$item['product_id']]['title'] or ''}}</a>
                                </h3>

                                {{--PRICE--}}
                                <h4 class="margin-top-10">{{trans('client.price')}}</h4>
                                <p>
                                    @if(
                                                                !empty($item['discount']) &&
                                                                !empty($item['discount_price']) &&
                                                                !empty($item['active_discount']))
                                        <em class="item_old_price">{{$item['price'] or ''}} {{trans('client.currency')}}</em>
                                        <em class="item_price">{{$item['discount_price'] or ''}} {{trans('client.currency')}}</em>
                                    @else
                                        <em class="item_price">{{$item['price'] or ''}} {{trans('client.currency')}}</em>
                                    @endif

                                    @if(
                                    !empty($item['discount']) &&
                                    !empty($item['discount_price']) &&
                                    !empty($item['active_discount']))
                                        <em class="item_discount"
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

                                {{--SIZE--}}
                                <h4 class="margin-top-10">{{trans('client.size')}}</h4>
                                <p class="size">
                                    {{$item['size'] or ''}}
                                </p>
                                <div class="clearfix"></div>

                                {{--QUANTITY--}}
                                @if(isset($cart_preview))
                                    <h4 class="margin-top-10">{{trans('client.quantity')}}</h4>
                                    <p class="quantity" style="float: none">
                                        {{$item['quantity'] or 1}}
                                    </p>
                                    <div class="clearfix"></div>
                                @endif
                            </td>

                            @if(!isset($cart_preview))
                                {{--QUANTITY--}}
                                <td>
                                    <div class="quantity">
                                        <div class="quantity-select">
                                            <div class="rem"
                                                 title="{{trans('client.available_sizes')}} {{$item['available_quantity'] or 0}}"
                                                 data-toggle="tooltip"
                                                 data-placement="bottom"
                                                 data-quantity="{{$item['available_quantity']}}"
                                            ><i class="fa fa-minus"></i></div>

                                            <div class="val"><span>{{$item['quantity'] or 1}}</span></div>

                                            <div class="add"
                                                 title="{{trans('client.available_sizes')}} {{$item['available_quantity'] or 0}}"
                                                 data-toggle="tooltip"
                                                 data-placement="bottom"
                                                 data-quantity="{{$item['available_quantity'] or 0}}"
                                            ><i class="fa fa-plus"></i></div>
                                        </div>
                                    </div>
                                </td>
                            @endif

                            <td class="subtotal">
                                <p>
                                    {{$item['subtotal'] or 0}} {{trans('client.currency')}}
                                </p>
                            </td>

                            @if(!isset($cart_preview))
                                <td class="action-bttns">
                                    <button
                                            class="action-bttn update_quantity"
                                            data-key="{{$key}}"
                                            title="{{trans('client.update_quantities')}}"
                                            data-toggle="tooltip"
                                            data-placement="bottom"
                                    >
                                        <i class="fa fa-refresh"></i>
                                    </button>
                                    <button
                                            class="action-bttn remove_item"
                                            data-key="{{$key}}"
                                            title="{{trans('client.remove')}}"
                                            data-toggle="tooltip"
                                            data-placement="left"
                                    >
                                        <i class="fa fa-remove"></i>
                                    </button>
                                </td>
                        </tr>
                        @endif
                    @endforeach

                </table>
            </div>
        </div>

        <div class="totals col-xs-12">
            <div class="col-xs-12 no-padding">
                <h3 class="block">{{trans('client.delivery_type')}}</h3>
                <div class="clearfix"></div>
                <div class="col-xs-12 margin-top-10 no-padding">
                    <button type="button"
                            value="to_office"
                            title="{{trans('client.to_office_tip')}}"
                            data-toggle="tooltip"
                            data-placement="top"
                            class="delivery_type pull-right @if(isset($cart_locked)) locked @endif @if(!empty($delivery_type) && $delivery_type=='to_office') delivery_type_active active @endif"
                    >{{trans('client.to_office')}}</button>
                    <button type="button"
                            value="to_address"
                            title="{{trans('client.to_address_tip')}}"
                            data-toggle="tooltip"
                            data-placement="top"
                            class="delivery_type pull-right @if(isset($cart_locked)) locked @endif @if(!empty($delivery_type) && $delivery_type=='to_address') delivery_type_active active @endif"
                    >{{trans('client.to_address')}}</button>
                    <div class="clearfix"></div>
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="clearfix"></div>

            <div class="col-xs-12 no-padding values">
                <table>
                    <tr>
                        <td>
                            <h3 class="margin-top-10">{{trans('client.subtotal')}}</h3>
                        </td>
                        <td>
                            <span class="subtotal">{{$total}}</span> <span>{{trans('client.currency')}}</span>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <h3 class="margin-top-10">{{trans('client.delivery_price')}}</h3>
                        </td>
                        <td>
                            <div class="delivery_price">
                                <span class="delivery_price">0</span> <span>{{trans('client.currency')}}</span>
                            </div>
                            <span class="delivery_price_free">{{trans('client.free')}}<br/>{{trans('client.delivery')}}</span>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <h3 class="margin-top-10">{{trans('client.total')}}</h3>
                        </td>
                        <td>
                            @if(!empty($total))
                                <span class="total">{{$total}}</span> <span>{{trans('client.currency')}}</span>
                            @endif
                        </td>
                    </tr>
                </table>
                <div class="clearfix"></div>
            </div>
            <div class="clearfix"></div>

            @if(!isset($cart_locked))
                <div class="col-xs-12 no-padding">
                    <button type="button"
                            class="create-order disabled pull-right @if(isset($cart_preview)) submit @endif"
                            title="{{trans('client.choose_delivery_type')}}"
                            data-toggle="tooltip"
                            data-placement="top"
                    >
                        <i class="fa fa-cart-arrow-down"></i>
                        {{trans('client.create_order')}}
                    </button>
                    @if(isset($ajax))
                        <button
                                type="button"
                                class="btn btn-default pull-right"
                                data-dismiss="modal"
                        >
                            <i class="fa fa-shopping-cart"></i>
                            {{trans('client.continue_shopping')}}
                        </button>
                    @endif
                </div>
            @endif
        </div>
        <div class="clearfix"></div>
    </div>
@else
    <h2 class="text-center margin-top-20">{{trans('client.empty_cart')}}</h2>
@endif