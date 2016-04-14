@extends('dressplace::layout')

@section('content')
    <div class="container">
        <div class="check-out">
            <div class="bs-example4" data-example-id="simple-responsive-table">
                @if(!empty($cart) && is_array($cart))
                    <div class="table-responsive">
                        <table class="table table-striped table-heading text-center cart-holder">
                            <tr>
                                <th class="table-grid">{{trans('client.product')}}</th>
                                <th>{{trans('client.price')}}</th>
                                <th>{{trans('client.size')}}</th>
                                <th>{{trans('client.quantity')}}</th>
                                <th>{{trans('client.subtotal')}}</th>
                                <th>{{trans('client.actions')}}</th>
                            </tr>
                            @foreach($cart as $key => $item)
                                <tr class="cart-header">

                                    {{--IMAGE--}}
                                    <td class="ring-in">
                                        <a href="{{$products[$item['product_id']]['slug'] or ''}}" class="at-in"
                                           title="{{trans('client.view_product_tip')}}"
                                           data-toggle="tooltip"
                                           data-placement="right">
                                            <img src="" data-src="{{$thumbs_path . $item['product_id'] . '/' . $icon_size . '/' .  $products[$item['product_id']]['image']}}" alt="{{$products[$item['product_id']]['image']}}" class="img-responsive lazy"/>
                                        </a>
                                        <div class="sed">
                                            <h5><a href="{{$products[$item['product_id']]['slug'] or ''}}"
                                                   title="{{trans('client.view_product_tip')}}"
                                                   data-toggle="tooltip"
                                                   data-placement="bottom">{{$products[$item['product_id']]['title'] or ''}}</a></h5>
                                            <p>{{$products[$item['product_id']]['description'] or ''}}</p>

                                        </div>
                                        <div class="clearfix"></div>
                                    </td>

                                    {{--PRICE--}}
                                    <td>
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
                                    </td>

                                    {{--SIZE--}}
                                    <td>
                                        {{$item['size'] or ''}}
                                    </td>

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
                                    <td class="subtotal">
                                        {{$item['subtotal'] or 0}} {{trans('client.currency')}}
                                    </td>
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
                            @endforeach

                        </table>
                    </div>

                    <div class="totals">
                        @if(!empty($total))
                            <h3>{{trans('client.total')}}</h3>
                            {{$total}} {{trans('client.currency')}}
                        @endif
                    </div>
                @else
                    <h2 class="text-center">{{trans('client.empty_cart')}}</h2>
                @endif
            </div>
        </div>
    </div>
@endsection

@section('customJS')
    <script type="text/javascript">
        $(document).ready(function () {
            var form_q_rem = $('.quantity-select .rem');
            var form_q_add = $('.quantity-select .add');

            //Quantity remove
            $(form_q_rem).on('click', function () {
                var form_q_val = $(this).closest('tr').find('.quantity-select .val span');
                var quantity = $(this).attr('data-quantity');
                if (!$(this).hasClass('disabled')) {
                    var divUpd = $(form_q_val),
                            newVal = parseInt(divUpd.text(), 10) - 1;
                    if (newVal >= 1) divUpd.text(newVal);
                }
            });

            //Quantity add
            $(form_q_add).on('click', function () {
                var form_q_val = $(this).closest('tr').find('.quantity-select .val span');
                var quantity = $(this).attr('data-quantity');
                if (!$(this).hasClass('disabled')) {
                    var divUpd = $(form_q_val),
                            newVal = parseInt(divUpd.text(), 10) + 1;
                    if (quantity > 0) {
                        if (newVal <= quantity) divUpd.text(newVal);
                    } else {
                        if (newVal = 0) divUpd.text(newVal);
                    }
                }
            });

            $('.update_quantity').on('click', function () {
                var key = $(this).attr('data-key');
                var quantity = $(this).closest('tr').find('.quantity-select .val span').text();
            });

            $('.remove_item').on('click', function () {
                var key = $(this).attr('data-key');
                var this_btn = $(this);

                if (key) {
                    $.ajax({
                               type: 'post',
                               url: '/cart/remove',
                               data: {
                                   key: key
                               },
                               success: function (response) {
                                   if (typeof response == typeof {} && response['success'] == true) {
                                       this_btn.closest('tr').remove();
//                                       if($())
                                   }
                               }
                           });
                }
            });
        });

        $.ajaxPrefilter(function (options) {
            if (!options.beforeSend) {
                options.beforeSend = function (xhr) {
                    xhr.setRequestHeader('X-CSRF-Token', $('meta[name="csrf-token"]').attr('content'));
                }
            }
        });
    </script>
@endsection