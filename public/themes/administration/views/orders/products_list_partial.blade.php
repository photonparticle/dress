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
                <a href="javascript:;" id="save_products" class="btn btn-success" title="{{trans('orders.save_products')}}">
                    <i class="fa fa-save"></i>
                    {{trans('orders.save_products')}}
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
                            {{trans('orders.original_price')}}
                        </th>
                        <th>
                            {{trans('orders.price')}}
                        </th>
                        <th>
                            {{trans('orders.discount')}}
                        </th>
                        <th>
                            {{trans('orders.size')}}
                        </th>
                        <th>
                            {{trans('orders.quantity')}}
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
                                <td>

                                </td>
                                <td>

                                </td>
                                <td>

                                </td>
                                <td>

                                </td>
                                <td>

                                </td>
                                <td>

                                </td>
                                <td>

                                </td>
                                <td>

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