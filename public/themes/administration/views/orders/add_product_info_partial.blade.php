<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
    @if(!empty($sizes) && is_array($sizes))
        <a href="javascript:;" id="save_product" class="btn btn-success pull-left" data-id="{{$product_id or ''}}">
            <i class="fa fa-upload"></i>
            {{trans('orders.add_product_action')}}
        </a>
    @else
        <h4>{{trans('orders.no_available_sizes')}}</h4>
    @endif
    <div class="clearfix"></div>
</div>
<div class="modal-body">
    @if(!empty($sizes) && is_array($sizes))
        <div class="col-xs-12">

            <label for="size" class="control-label col-xs-12 default no-padding">
                {{trans('orders.available_sizes')}}
            </label>
            <select id="size" name="size" class="form-control input-lg">
                <option value="">{{trans('orders.choose_size')}}</option>
                @foreach($sizes as $name => $size)
                    @if($size['quantity'] > 0)
                        <option data-size="{{$name}}"
                                data-quantity="{{$size['quantity'] or ''}}"
                                data-price="{{$size['price'] or ''}}"
                                data-original-price="{{$size['original_price'] or ''}}"
                                data-discount="{{$size['discount'] or ''}}"
                        >
                            {{$name}}
                        </option>
                    @endif
                @endforeach
            </select>
        </div>

        <div class="clearfix"></div>

        <div class="col-xs-12 margin-top-20 quantity_holder">
            <label for="quantity" class="control-label col-xs-12 default no-padding">
                {{trans('orders.quantity')}}
            </label>
            <input type="number" min="1" max="1" name="quantity" id="quantity" class="form-control" />
        </div>
    @else
        <strong>{{trans('orders.no_available_sizes_tip')}}</strong>
    @endif
    <div class="clearfix"></div>
</div>