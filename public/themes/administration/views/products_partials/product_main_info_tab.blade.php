<!-- MAIN INFO TAB -->
<div class="tab-pane active" id="main_info">
    <form action="#">

        <input type="hidden" name="_token" value="{{ csrf_token() }}">

        <div class="form-group form-md-line-input has-success form-md-floating-label">
            <div class="input-icon right">
                <input name="title" id="title" type="text" class="form-control input-lg"  value="{{isset($product['title']) ? $product['title'] : ''}}"/>

                <label for="title">{{trans('products.title')}}</label>
                <span class="help-block"></span>
                <i class="fa fa-font"></i>
            </div>
        </div>

        <div class="form-group">
            <label for="description" class="control-label col-xs-12 default no-padding">
                {{trans('products.description')}}
            </label>
            <div class="col-xs-12 no-padding">
                <div id="description">
                    {!!isset($product['description']) ? $product['description'] : ''!!}
                </div>
            </div>
            <div class="clearfix"></div>
        </div>
        
        <div class="clearfix"></div>

        <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 margin-top-20">
            <label for="quantity" class="control-label col-xs-12 default no-padding">
                {{trans('products.quantity')}}
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
        

        <div class="form-group form-md-line-input has-success form-md-floating-label">
            <div class="input-icon right">
                <input name="tags" id="tags" type="text" class="form-control input-lg"  value="{{isset($product['tags']) ? $product['tags'] : ''}}"/>

                <label for="tags">{{trans('products.tags')}}</label>
                <span class="help-block">{{trans('products.tags_help')}}</span>
                <i class="fa fa-font"></i>
            </div>
        </div>
         
        
        <div class="clearfix"></div>

        

    </form>

</div>
<!-- END MAIN INFO TAB -->