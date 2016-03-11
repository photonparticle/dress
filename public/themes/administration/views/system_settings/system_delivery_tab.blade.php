<!-- DELIVERY TAB -->

<div class="tab-pane" id="delivery">
    <form action="#">

        <input type="hidden" name="_token" value="{{ csrf_token() }}">

            <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 margin-top-20">
                <label for="input_to_off" class="control-label col-xs-12 default no-padding">
                    {{trans('system_settings.to_off')}}
                </label>

                <div id="to_off">
                    <div class="input-group" style="width:200px;">
                        <input type="text" name="to_off" id="input_to_off" class="spinner-input form-control" maxlength="3" value="{{isset($system_settings['delivery_to_office']) ? $system_settings['delivery_to_office'] : ''}}">
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
                <label for="input_to_addr" class="control-label col-xs-12 default no-padding">
                    {{trans('system_settings.to_addr')}}
                </label>

                <div id="to_addr">
                    <div class="input-group" style="width:200px;">
                        <input type="text" name="to_addr" id="input_to_addr" class="spinner-input form-control" maxlength="3" value="{{isset($system_settings['delivery_to_address']) ? $system_settings['delivery_to_address'] : ''}}">
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
                <label for="input_free_delivery" class="control-label col-xs-12 default no-padding">
                    {{trans('system_settings.free_delivery')}}
                </label>

                <div id="giveaway">
                    <div class="input-group" style="width:200px;">
                        <input type="text" name="free_delivery" id="input_free_delivery" class="spinner-input form-control" maxlength="3" value="{{isset($system_settings['delivery_free_delivery']) ? $system_settings['delivery_free_delivery'] : ''}}">
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