<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
    <h4>{{trans('orders.add_product')}}</h4>
</div>
<div class="modal-body">
    <strong>{{trans('orders.add_product_tip')}}</strong>
    <hr />
    <div class="col-xs-12 margin-top-20 no-padding no-margin size_holder">
        <label for="products" class="control-label col-xs-12 default no-padding">
            {{trans('orders.products')}}
        </label>
        <select id="products"
                name="products"
                class="form-control select2me input-lg no-padding"
                data-placeholder="{{trans('orders.products')}}"
        >
            <option value="">{{trans('orders.select_product')}}</option>
            @if(isset($products) && is_array($products))
                @foreach($products as $key => $product)
                    <option value="{{$product['id']}}" @if(!empty($related_products) && in_array($product['id'], $related_products)) selected="selected" @endif>{{$product['id']}} - {{$product['title']}}</option>
                @endforeach
            @endif
        </select>
    </div>

    <div class="clearfix"></div>

    <a href="javascript:;" id="select_product" class="btn btn-success margin-top-20">
        <i class="fa fa-arrow-circle-right"></i>
        {{trans('orders.select')}}
    </a>
</div>