<div class="col-md-6 col-sm-12">
    <div class="portlet blue-hoki box">
        <div class="portlet-title">
            <div class="caption">
                <i class="fa fa-user"></i>{{trans('orders.customer_info')}}
            </div>
        </div>
        <div class="portlet-body">

            {{--LOCKED FORM--}}
            @if(empty($method) || !empty($method) && $method == 'locked')
                <div class="locked-form-details">
                    <div class="row static-info">
                        <div class="col-md-5 name">
                            {{trans('orders.name')}}:
                        </div>
                        <div class="col-md-7 value">
                            Jhon Doe
                        </div>
                    </div>
                    <div class="row static-info">
                        <div class="col-md-5 name">
                            {{trans('orders.email')}}:
                        </div>
                        <div class="col-md-7 value">
                            jhon@doe.com
                        </div>
                    </div>
                    <div class="row static-info">
                        <div class="col-md-5 name">
                            {{trans('orders.phone')}}:
                        </div>
                        <div class="col-md-7 value">
                            12234389
                        </div>
                    </div>
                </div>
            @endif

            {{--UNLOCKED FORM--}}
            @if(!empty($method) && $method == 'unlocked')
                <div class="edit-form-details ">


                    <div class="form-group form-md-line-input has-info form-md-floating-label">

                        <div class="input-icon right">
                            <input name="name" id="name" type="text" class="form-control input-lg" value="{{isset($order['name']) ? $order['name'] : ''}}"/>

                            <label for="name">{{trans('orders.name')}}</label>
                            <span class="help-block"></span>
                            <i class="fa fa-user"></i>
                        </div>
                    </div>


                    <div class="form-group form-md-line-input has-info form-md-floating-label">
                        <div class="input-icon right">
                            <input name="last_name" id="last_name" type="text" class="form-control input-lg" value="{{isset($order['last_name']) ? $order['last_name'] : ''}}"/>

                            <label for="last_name">{{trans('orders.last_name')}}</label>
                            <span class="help-block"></span>
                            <i class="fa fa-user-plus"></i>
                        </div>
                    </div>


                    <div class="form-group form-md-line-input has-info form-md-floating-label">
                        <div class="input-icon right">
                            <input name="email" id="email" type="text" class="form-control input-lg" value="{{isset($order['email']) ? $order['email'] : ''}}"/>

                            <label for="email">{{trans('orders.email')}}</label>
                            <span class="help-block"></span>
                            <i class="fa fa-at"></i>
                        </div>
                    </div>


                    <div class="form-group form-md-line-input has-info form-md-floating-label">
                        <div class="input-icon right">
                            <input name="phone" id="phone" type="text" class="form-control input-lg" value="{{isset($order['phone']) ? $order['phone'] : ''}}"/>

                            <label for="phone">{{trans('orders.phone')}}</label>
                            <span class="help-block"></span>
                            <i class="fa fa-phone"></i>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>