@if(empty($no_product))
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="{{trans('client.close')}}"><span aria-hidden="true"><i class="fa fa-remove"></i></span></button>
        <h4 class="modal-title text-center"><strong>{{trans('client.product_added_to_cart')}}</strong></h4>
    </div>
    <div class="col-xs-12 item_added_to_cart">
        <div class="col-xs-12 col-sm-6">
            <img src="{{$thumbs_path . $product_id . '/' . $icon_size . '/' .  $product[$product_id]['image']}}" class="img-responsive img-thumbnail"/>
            <div class="clearfix"></div>

            <h4 class="margin-top-10">{{$product[$product_id]['title']}}</h4><br/>

            <strong>{{trans('client.size')}}: </strong> {{$cart[$cart_id]['size']}}<br/>
            <strong>{{trans('client.quantity')}}: </strong> {{$cart[$cart_id]['quantity']}}<br/>
            <strong>{{trans('client.total')}}: </strong> {{$cart[$cart_id]['subtotal']}} {{trans('client.currency')}}<br/>
        </div>
        <div class="col-xs-12 col-sm-6 summary">
            <h4>{{trans('client.cart_total_items_1') . ' ' . $cart_items . ' ' . trans('client.cart_total_items_2')}}</h4>

            <strong>{{trans('client.subtotal')}}: </strong>
            {{$total . ' ' . trans('client.currency')}}<br/>
            <strong>{{trans('client.delivery')}}: </strong>
            {{$delivery_cost . ' ' . trans('client.currency')}}<br/>
            <strong>{{trans('client.total')}}: </strong>
            {{$cart_total . ' ' . trans('client.currency')}}<br/>

            <div class="buttons">
                <a href="javascript:;" data-dismiss="modal" aria-label="{{trans('client.close')}}">
                    <i class="fa fa-angle-left" aria-hidden="true"></i>
                    {{trans('client.continue_shopping')}}
                </a>
                <a href="/cart">
                    {{trans('client.make_checkout')}}
                    <i class="fa fa-angle-right" aria-hidden="true"></i>
                </a>
            </div>
        </div>
        <div class="clearfix"></div>
    </div>
    <div class="clearfix"></div>
@endif