<div class="col-md-12 col-sm-12">
    <div class="portlet grey-cascade box">
        <div class="portlet-title">
            <div class="caption">
                <i class="fa fa-shopping-cart"></i>{{trans('orders.products')}}
            </div>
            <div class="actions">
                <a href="/admin/orders/show/false/add_product" data-toggle="modal" id="add_product" class="btn btn-info" title="{{trans('orders.add_product')}}">
                    <i class="fa fa-plus"></i>
                    {{trans('orders.add_product')}}
                </a>
            </div>
        </div>
        <div class="portlet-body">
            <div class="table-responsive">
                <table class="table table-hover table-bordered table-striped">
                    <thead>
                    <tr>
                        <th>
                            ID
                        </th>
                        <th>
                            {{trans('orders.image')}}
                        </th>
                        <th>
                            {{trans('orders.size')}}
                        </th>
                        <th>
                            {{trans('orders.quantity')}}
                        </th>
                        <th>
                            {{trans('orders.original_price')}}
                        </th>
                        <th>
                            {{trans('orders.price')}}
                        </th>
                        <th>
                            {{trans('orders.discount')}}
                        </th>
                        <th>
                            {{trans('orders.total')}}
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    @if(!empty($products) && is_array($products))
                        @foreach($products as $product)
                            <tr>
                                <td class="text-center">
                                    <h4 class="no-margin font-red-thunderbird"></h4>
                                    {{$product['product_id'] or ''}}
                                </td>
                                <td class="text-center">
                                    @if($product['image'])
                                        <img src="{{$thumbs_path . $product['product_id'] . '/' . $icon_size . '/' . $product['image']}}" class="img-responsive thumbnail" style="max-width:150px; margin: auto"/>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <h4 class="no-margin font-blue-steel">{{$product['size']}}</h4>
                                </td>
                                <td class="text-center">
                                    <h4 class="no-margin font-red-thunderbird">{{$product['quantity']}}</h4>
                                </td>
                                <td class="text-center">
                                    <h4 class="no-margin font-blue-steel">{{$product['original_price']}} {{trans('orders.currency')}}</h4>
                                </td>
                                <td class="text-center">
                                    <h4 class="no-margin">
                                        @if(empty($product['discount']))<span class="font-red-thunderbird">@endif
                                            {{$product['price']}} {{trans('orders.currency')}}
                                            @if(empty($product['discount']))</span>@endif
                                    </h4>
                                </td>
                                <td class="text-center">
                                    @if(!empty($product['discount']))
                                        <h4 class="no-margin font-red-thunderbird">{{$product['discount']}} {{trans('orders.currency')}}</h4>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <h4 class="no-margin font-blue-steel"><span class="total_val">{{$product['total']}}</span> {{trans('orders.currency')}}</h4>
                                </td>
                            </tr>
                        @endforeach
                    @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>