<!-- Price and Discounts TAB -->
<div class="tab-pane" id="price_and_discount">
    <form action="#">

        <input type="hidden" name="_token" value="{{ csrf_token() }}">

        <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 margin-top-20">
            <label for="input_original_price" class="control-label col-xs-12 default no-padding">
                {{trans('products.original_price')}}
            </label>

            <div id="original_price">
                <div class="input-group" style="width:250px;">
                    <input type="text" name="original_price" id="input_original_price" class="spinner-input form-control" value="{{isset($product['original_price']) ? $product['original_price'] : ''}}"/>
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
            <label for="input_price" class="control-label col-xs-12 default no-padding">
                {{trans('products.price')}}
            </label>

            <div id="price">
                <div class="input-group" style="width:250px;">
                    <input type="text" name="price" id="input_price" class="spinner-input form-control" value="{{isset($product['price']) ? $product['price'] : ''}}"/>
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

        <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 margin-top-20">
            <label for="input_discount" class="control-label col-xs-12 default no-padding">
                {{trans('products.discount')}}
            </label>

            <div id="discount">
                <div class="input-group" style="width:250px;">
                    <input type="text" name="discount" id="input_discount" class="spinner-input form-control" value="{{isset($product['discount_price']) ? $product['discount_price'] : ''}}"/>
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
            <label for="discount_start" class="control-label col-xs-12 default no-padding">
                {{trans('products.discount_start')}}
            </label>

            <div class="input-group date discount_start">
                <input type="text" id="discount_start" size="16" readonly class="form-control" value="{{isset($product['discount_start']) ? $product['discount_start'] : ''}}">
                <span class="input-group-btn">
                    <button class="btn default date-set" type="button"><i class="fa fa-calendar"></i></button>
                </span>
            </div>
        </div>

        <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 margin-top-20">
            <label for="discount_end" class="control-label col-xs-12 default no-padding">
                {{trans('products.discount_end')}}
            </label>

            <div class="input-group date discount_end">
                <input type="text" id="discount_end" size="16" readonly class="form-control" value="{{isset($product['discount_end']) ? $product['discount_end'] : ''}}">
                <span class="input-group-btn">
                    <button class="btn default date-set" type="button"><i class="fa fa-calendar"></i></button>
                </span>
            </div>
        </div>

        <div class="clearfix"></div>

        

    </form>

</div>
<!-- END Price and Discounts TAB -->