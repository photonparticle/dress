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
                            <input name="title" id="title" type="text" class="form-control input-lg" value="{{isset($product['title']) ? $product['title'] : ''}}"/>

                            <label for="title">{{trans('orders.name')}}</label>
                            <span class="help-block"></span>
                            <i class="fa fa-user"></i>
                        </div>
                    </div>


                    <div class="form-group form-md-line-input has-info form-md-floating-label">
                        <div class="input-icon right">
                            <input name="title" id="title" type="text" class="form-control input-lg" value="{{isset($product['title']) ? $product['title'] : ''}}"/>

                            <label for="title">{{trans('orders.lastname')}}</label>
                            <span class="help-block"></span>
                            <i class="fa fa-user-plus"></i>
                        </div>
                    </div>


                    <div class="form-group form-md-line-input has-info form-md-floating-label">
                        <div class="input-icon right">
                            <input name="title" id="title" type="text" class="form-control input-lg" value="{{isset($product['title']) ? $product['title'] : ''}}"/>

                            <label for="title">{{trans('orders.email')}}</label>
                            <span class="help-block"></span>
                            <i class="fa fa-at"></i>
                        </div>
                    </div>


                    <div class="form-group form-md-line-input has-info form-md-floating-label">
                        <div class="input-icon right">
                            <input name="title" id="title" type="text" class="form-control input-lg" value="{{isset($product['title']) ? $product['title'] : ''}}"/>

                            <label for="title">{{trans('orders.phone')}}</label>
                            <span class="help-block"></span>
                            <i class="fa fa-phone"></i>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>