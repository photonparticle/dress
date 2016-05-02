@if(empty($cart_checkout))
    <div class="container">
        <div class="col-xs-12">
            <div class="section-title text-center">
                <h1 class="no-margin">
                    {{trans('client.cart')}}
                </h1>
            </div>
        </div>
        <div class="clearfix"></div>
    </div>
@endif

@if(!empty($cart) && is_array($cart))
    <div class="cart-container @if(isset($cart_preview)) no-padding @endif"
         data-delivery-free-delivery="{{$sys['delivery_free_delivery'] or 999999}}"
         data-delivery-to-address="{{$sys['delivery_to_address'] or 0}}"
         data-delivery-to-office="{{$sys['delivery_to_office'] or 0}}"
    >


        @if(!empty($cart_checkout))
            <div class="totals col-xs-12">
                <div class="col-xs-12 no-padding text-right">
                    <h3 class="text-center">
                        {{trans('client.delivery_type')}}
                    </h3>

                    <div class="clearfix"></div>

                    <div class="col-xs-12 margin-top-10 no-padding">
                        <div class="to_office delivery_type @if(isset($cart_locked)) locked @endif @if(!empty($delivery_type) && $delivery_type=='to_office') delivery_type_active active @endif"
                             title="{{trans('client.to_office_tip')}}"
                             data-toggle="tooltip"
                             data-placement="left"
                             data-type="to_office"
                        >
                            <img src="{{Theme::asset('img/econt_icon.png')}}" alt="Econt Express"/>
                            <p>
                                {{trans('client.to_office_long')}}
                            </p>
                        </div>
                        <div class="to_address delivery_type @if(isset($cart_locked)) locked @endif @if(!empty($delivery_type) && $delivery_type=='to_address') delivery_type_active active @endif"
                             title="{{trans('client.to_address_tip')}}"
                             data-toggle="tooltip"
                             data-placement="left"
                             data-type="to_address"
                        >
                            <img src="{{Theme::asset('img/home_icon.png')}}" alt="To home address"/>
                            <p>
                                {{trans('client.to_address_long')}}
                            </p>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="clearfix"></div>
            </div>

            <div class="clearfix"></div>

            <h3 class="text-center">
                {{trans('client.products_in_cart')}}
            </h3>
            <div class="clearfix"></div>
        @else

        @endif


        <div class="bs-example4" data-example-id="simple-responsive-table">
            <div class="table-responsive">
                <table class="table table-striped table-heading text-center cart-holder @if(isset($ajax)) ajax @endif">
                    <tr>
                        <th></th>
                        <th class="cart-item-desc">{{trans('client.product')}}</th>
                        @if(!isset($cart_preview))
                            <th class="text-center">{{trans('client.quantity')}}</th>
                        @endif
                        <th class="text-center">{{trans('client.subtotal')}}</th>
                        @if(!isset($cart_preview))
                            <th class="text-center">{{trans('client.actions')}}</th>
                        @endif
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

                                {{--PRICE--}}
                                <h4 class="margin-top-10">{{trans('client.price')}}</h4>
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
                            @endif
                        </tr>
                    @endforeach

                </table>
            </div>
        </div>

        {{--IF CART PAGE --}}
        <div class="totals col-xs-12">

            @if(empty($cart_checkout))
                <div class="col-xs-12 no-padding text-right">
                    <h3 class="block">{{trans('client.delivery_type')}}</h3>
                    <div class="clearfix"></div>
                    <div class="col-xs-12 margin-top-10 no-padding">
                        <div class="to_office delivery_type pull-right @if(isset($cart_locked)) locked @endif @if(!empty($delivery_type) && $delivery_type=='to_office') delivery_type_active active @endif"
                             title="{{trans('client.to_office_tip')}}"
                             data-toggle="tooltip"
                             data-placement="top"
                             data-type="to_office"
                        >
                            <img src="{{Theme::asset('img/econt_icon.png')}}" alt="Econt Express"/>
                            <p>
                                {{trans('client.to_office_long')}}
                            </p>
                        </div>
                        <div class="to_address delivery_type pull-right @if(isset($cart_locked)) locked @endif @if(!empty($delivery_type) && $delivery_type=='to_address') delivery_type_active active @endif"
                             title="{{trans('client.to_address_tip')}}"
                             data-toggle="tooltip"
                             data-placement="top"
                             data-type="to_address"
                        >
                            <img src="{{Theme::asset('img/home_icon.png')}}" alt="To home address"/>
                            <p>
                                {{trans('client.to_address_long')}}
                            </p>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="clearfix"></div>
            @endif

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
                            <div class="delivery_price">
                                <h4 class="margin-top-10">
                                    <span class="delivery_price">0</span> <span>{{trans('client.currency')}}</span>
                                </h4>
                            </div>
                            <span class="delivery_price_free">{{trans('client.free')}}<br/>{{trans('client.delivery')}}</span>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <h4 class="margin-top-10">{{trans('client.total')}}</h4>
                        </td>
                        <td>
                            @if(!empty($total))
                                <h4 class="margin-top-10">
                                    <span class="total">{{$total}}</span> <span>{{trans('client.currency')}}</span>
                                </h4>
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
                        {{trans('client.create_order')}}
                    </button>
                </div>
            @endif
        </div>

        <div class="clearfix"></div>
    </div>
@else
    <h2 class="text-center margin-top-20">{{trans('client.empty_cart')}}</h2>
@endif