<!-- Visualisation and Positioning TAB -->
<div class="tab-pane" id="visualisation_and_positioning">
    <form action="#">

        <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 margin-top-20">
            <label for="position" class="control-label col-xs-12 default no-padding">
                {{trans('products.position')}}
            </label>

            <div id="position">
                <div class="input-group" style="width:150px;">
                    <input type="text" name="position" id="input_position" class="spinner-input form-control" maxlength="3" readonly="" value="{{isset($product['position']) ? $product['position'] : ''}}">
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
            <label for="active" class="control-label col-xs-12 default no-padding">
                {{trans('products.active')}}
            </label>
            <div class="col-xs-12 no-padding">
                <input id="active" name="active" type="checkbox" class="make-switch" data-on-text="&nbsp;{{trans('products.activated')}}&nbsp;" data-off-text="&nbsp;{{trans('products.not_activated')}}&nbsp;" @if(!isset($product['active']) or (isset($product['active']) && $product['active'] == '1')) checked @endif>
            </div>
        </div>

        <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 margin-top-20">
            <label for="created_at" class="control-label col-xs-12 default no-padding">
                {{trans('products.created_at')}}
            </label>

            <div class="input-group date created_at">
                <input type="text" id="created_at" size="16" readonly class="form-control" value="{{isset($product['created_at']) ? $product['created_at'] : ''}}">
                <span class="input-group-btn">
                    <button class="btn default date-set" type="button"><i class="fa fa-calendar"></i></button>
                </span>
            </div>
        </div>

        <div class="clearfix"></div>
        
    </form>
</div>
<!-- END Visualisation and Positioning TAB -->