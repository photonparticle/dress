<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
    <a href="javascript:;" id="select_product" class="btn btn-success pull-left">
        <i class="fa fa-upload"></i>
        {{trans('orders.add_product_action')}}
    </a>
    <div class="clearfix"></div>
</div>
<div class="modal-body">
    <div class="col-xs-12 margin-top-20">
        @if(!empty($sizes) && is_array($sizes))

            <label for="size" class="control-label col-xs-12 default no-padding">
                {{trans('orders.order_status')}}
            </label>
            <select id="size" name="size" class="form-control input-lg">
                <option value="">{{trans('orders.ch_status')}}</option>
                @foreach($sizes as $name => $size)
                    @if($size['quantity'] > 0)
                        <option id="{{$name}}"
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
        @endif
    </div>

    <div class="clearfix"></div>

    <div class="col-xs-12 margin-top-20 quantity_holder">
        <label for="quantity" class="control-label col-xs-12 default no-padding">
            {{trans('orders.quantity')}}
        </label>
        <input type="number" min="1" max="" name="quantity" id="quantity" class="form-control"/>
    </div>
    <div class="clearfix"></div>
</div>