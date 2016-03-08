<!-- DELIVERY TAB -->

<div class="tab-pane" id="delivery">
    <form action="#">

        <input type="hidden" name="_token" value="{{ csrf_token() }}">

            <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 margin-top-20">
                <label for="to_off" class="control-label col-xs-12 default no-padding">
                    {{trans('sys_trans.to_off')}}
                </label>

                <div id="to_off">
                    <div class="input-group" style="width:150px;">
                        <input type="text" name="to_off" id="input_to_off" class="spinner-input form-control" maxlength="3" value="{{isset($product['to_off']) ? $product['to_off'] : ''}}">
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
<!--{{--ADDRESS--}}-->
            <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 margin-top-20">
                <label for="to_addr" class="control-label col-xs-12 default no-padding">
                    {{trans('sys_trans.to_addr')}}
                </label>

                <div id="to_addr">
                    <div class="input-group" style="width:150px;">
                        <input type="text" name="to_addr" id="input_to_addr" class="spinner-input form-control" maxlength="3" value="{{isset($product['to_addr']) ? $product['to_addr'] : ''}}">
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
<!--{{--FREE_SHIPPING--}}-->
            <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 margin-top-20">
                <label for="giveaway" class="control-label col-xs-12 default no-padding">
                    {{trans('sys_trans.giveaway')}}
                </label>

                <div id="giveaway">
                    <div class="input-group" style="width:150px;">
                        <input type="text" name="giveaway" id="input_giveaway" class="spinner-input form-control" maxlength="3" value="{{isset($product['giveaway']) ? $product['giveaway'] : ''}}">
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
<!--{{--#--}}-->
        <div class="clearfix"></div>
    </form>

</div>

<!-- END DELIVERY TAB -->