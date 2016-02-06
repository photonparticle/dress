@if(!empty($sizes) && is_array($sizes))
    @foreach($sizes as $key => $size)

        <div class="portlet box blue product_sizes">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-arrows-v"></i> {{trans('sizes.size')}} <span class="name">{{$size['name']}}</span>
                </div>
            </div>

            <div class="portlet-body" style="display: block;">

                <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 margin-top-20">
                    <label for="input_quantity_{{$size['name']}}" class="control-label col-xs-12 default no-padding">
                        {{trans('products.quantity')}}
                    </label>

                    <div class="quantity">
                        <div class="input-group" style="width:250px;">
                            <input type="text" name="quantity_{{$size['name']}}" id="input_quantity_{{$size['name']}}" class="spinner-input form-control" value="{{$size['quantity'] or ''}}" />
                            <div class="spinner-buttons input-group-btn">
                                <button type="button" class="btn spinner-up default">
                                    <i class="fa fa-angle-up"></i>
                                </button>
                                <button type="button" class="btn spinner-down default">
                                    <i class="fa fa-angle-down"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 margin-top-20">
                    <label for="input_price_{{$size['name']}}" class="control-label col-xs-12 default no-padding">
                        {{trans('products.price')}}
                    </label>

                    <div class="price">
                        <div class="input-group" style="width:250px;">
                            <input type="text" name="price_{{$size['name']}}" id="input_price_{{$size['name']}}" class="spinner-input form-control" value="{{$size['price'] or ''}}" />
                            <div class="spinner-buttons input-group-btn">
                                <button type="button" class="btn spinner-up default">
                                    <i class="fa fa-angle-up"></i>
                                </button>
                                <button type="button" class="btn spinner-down default">
                                    <i class="fa fa-angle-down"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 margin-top-20">
                    <label for="input_discount_{{$size['name']}}" class="control-label col-xs-12 default no-padding">
                        {{trans('products.discount')}}
                    </label>

                    <div class="discount">
                        <div class="input-group" style="width:250px;">
                            <input type="text" name="discount_{{$size['name']}}" id="input_discount_{{$size['name']}}" class="spinner-input form-control" value="{{$size['discount'] or ''}}" />
                            <div class="spinner-buttons input-group-btn">
                                <button type="button" class="btn spinner-up default">
                                    <i class="fa fa-angle-up"></i>
                                </button>
                                <button type="button" class="btn spinner-down default">
                                    <i class="fa fa-angle-down"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="clearfix"></div>
            </div>
        </div>

        <div class="clearfix"></div>

    @endforeach

    <script type="text/javascript">
        $(document).ready( function () {
            $('.quantity').spinner({value: 0, min: 0, max: 100, step: 1.0});
            $('.price').spinner({value: 0, min: 0, max: 1000, step: 1.00, numberFormat: "c"});
            $('.discount').spinner({value: 0, min: 0, max: 1000, step: 1.00, numberFormat: "c"});
        });
    </script>
@endif