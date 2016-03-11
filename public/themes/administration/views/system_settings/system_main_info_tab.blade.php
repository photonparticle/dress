<!-- MAIN INFO TAB -->

<div class="tab-pane active" id="main_info">
        <div class="form-group form-md-line-input has-info form-md-floating-label">

            <div class="input-icon right">
                <input name="title" id="title" type="text" class="form-control input-lg" value="{{isset($system_settings['title']) ? $system_settings['title'] : ''}}"/>

                <label for="title">{{trans('system_settings.shop_name')}}</label>
                <span class="help-block"></span>
                <i class="fa fa-home"></i>
            </div>
        </div>


        <div class="form-group form-md-line-input has-info form-md-floating-label">
            <div class="input-icon right">
                <input name="email" id="email" type="email" class="form-control input-lg" value="{{isset($system_settings['email']) ? $system_settings['email'] : ''}}"/>

                <label for="email">{{trans('system_settings.email')}}</label>
                <span class="help-block"></span>
                <i class="fa fa-at"></i>
            </div>
        </div>


        <div class="form-group form-md-line-input has-info form-md-floating-label">
            <div class="input-icon right">
                <input name="phone" id="phone" type="tel" class="form-control input-lg" value="{{isset($system_settings['phone']) ? $system_settings['phone'] : ''}}"/>

                <label for="phone">{{trans('system_settings.phone')}}</label>
                <span class="help-block"></span>
                <i class="fa fa-phone"></i>
            </div>
        </div>

        <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 margin-top-20 no-padding">
            <label for="input_quantity" class="control-label col-xs-12 default no-padding">
                {{trans('system_settings.quantity')}}
            </label>

            <div id="quantity">
                <div class="input-group" style="width:150px;">
                    <input type="text" name="quantity" id="input_quantity" class="spinner-input form-control" maxlength="3" value="{{isset($system_settings['quantity']) ? $system_settings['quantity'] : ''}}">
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

<!-- END MAIN INFO TAB -->