<div class="col-md-12 col-sm-12">
    <div class="portlet grey-cascade box">
        <div class="portlet-title">
            <div class="caption">
                <i class="fa fa-shopping-cart"></i>{{trans('orders.products')}}
            </div>
            @if(!empty($method) && $method == 'unlocked')
                <div class="actions">
                    <a href="/admin/orders/show/false/add_product" data-toggle="modal" id="add_product" class="btn btn-info" title="{{trans('orders.add_product')}}">
                        <i class="fa fa-plus"></i>
                        {{trans('orders.add_product')}}
                    </a>
                </div>
            @endif
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
                            {{trans('orders.product_title')}}
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
                        @if(!empty($method) && $method == 'unlocked')
                            <th>
                                {{trans('orders.actions')}}
                            </th>
                        @endif
                    </tr>
                    </thead>
                    <tbody>
                    @if(!empty($products) && is_array($products))
                        @foreach($products as $product)
                            <tr>
                                <td class="text-center">
                                    <h4 class="no-margin font-blue-steel"></h4>
                                    {{$product['product_id'] or ''}}
                                </td>
                                <td class="text-center">
                                    @if(!empty($product['image']))
                                        <img src="{{$thumbs_path . $product['product_id'] . '/' . $icon_size . '/' . $product['image']}}" class="img-responsive thumbnail" style="max-width:150px; margin: auto"/>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <h5 class="no-margin"><strong>{{$product['title'] or ''}}</strong></h5>
                                </td>
                                <td class="text-center">
                                    <h4 class="no-margin font-blue-steel">{{$product['size'] or ''}}</h4>
                                </td>
                                <td class="text-center">
                                    <h4 class="no-margin font-red-thunderbird">{{$product['quantity'] or ''}}</h4>
                                </td>
                                <td class="text-center">
                                    <h4 class="no-margin font-blue-steel">{{$product['original_price'] or ''}} {{trans('orders.currency')}}</h4>
                                </td>
                                <td class="text-center">
                                    <h4 class="no-margin">
                                        @if(empty($product['discount']))<span class="font-red-thunderbird">@endif
                                            {{$product['price'] or ''}} {{trans('orders.currency')}}
                                            @if(empty($product['discount']))</span>@endif
                                    </h4>
                                </td>
                                <td class="text-center">
                                    @if(!empty($product['discount']))
                                        <h4 class="no-margin font-red-thunderbird">{{$product['discount'] or ''}} {{trans('orders.currency')}}</h4>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <h4 class="no-margin font-blue-steel"><span class="total_val">{{$product['total'] or ''}}</span> {{trans('orders.currency')}}</h4>
                                </td>
                                @if(!empty($method) && $method == 'unlocked')
                                    <td class="text-center">
                                        <a href="javascript:;"
                                           class="btn btn-danger btn-icon-only remove_product"
                                           title="{{trans('orders.remove')}}"
                                           data-id="{{$product['product_id'] or ''}}"
                                           data-title="{{$product['title'] or ''}}"
                                           data-record="{{$product['id'] or ''}}"
                                        >
                                            <i class="fa fa-trash"></i>
                                        </a>
                                    </td>
                                @endif
                            </tr>
                        @endforeach
                    @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>