<!-- MAIN INFO TAB -->

<div class="tab-pane active" id="main_info">
    <form action="#">

        <input type="hidden" name="_token" value="{{ csrf_token() }}">

        <div class="form-group form-md-line-input has-info form-md-floating-label">

            <div class="input-icon right">
                <input name="title" id="title" type="text" class="form-control input-lg" value="{{isset($product['title']) ? $product['title'] : ''}}"/>
                
                <label for="title">{{trans('sys_trans.shop_name')}}</label>
                <span class="help-block"></span>
                <i class="fa fa-user"></i>
            </div>
        </div>


        <div class="form-group form-md-line-input has-info form-md-floating-label">
            <div class="input-icon right">
                <input name="title" id="title" type="text" class="form-control input-lg" value="{{isset($product['title']) ? $product['title'] : ''}}"/>

                <label for="title">{{trans('sys_trans.email')}}</label>
                <span class="help-block"></span>
                <i class="fa fa-at"></i>
            </div>
        </div>


        <div class="form-group form-md-line-input has-info form-md-floating-label">
            <div class="input-icon right">
                <input name="title" id="title" type="text" class="form-control input-lg" value="{{isset($product['title']) ? $product['title'] : ''}}"/>

                <label for="title">{{trans('sys_trans.phone')}}</label>
                <span class="help-block"></span>
                <i class="fa fa-phone"></i>
            </div>
        </div>
        
        <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 margin-top-20">
            <label for="quantity" class="control-label col-xs-12 default no-padding">
                {{trans('sys_trans.quantity')}}
            </label>

            <div id="quantity">
                <div class="input-group" style="width:150px;">
                    <input type="text" name="quantity" id="input_quantity" class="spinner-input form-control" maxlength="3" value="{{isset($product['quantity']) ? $product['quantity'] : ''}}">
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
    </form>

</div>

<!-- END MAIN INFO TAB -->