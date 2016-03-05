<div class="col-md-6 col-sm-12">
    <div class="portlet box green">
        <div class="portlet-title">
            <div class="caption">
                <i class="fa fa-truck"></i>{{trans('orders.shipping_addr')}}
            </div>
        </div>
        <div class="portlet-body">

            {{--LOCKED FORM--}}
            @if(empty($method) || !empty($method) && $method == 'locked')
                <div class="locked-form-details">
                    <div class="row static-info">
                        <div class="col-md-12 value">
                            Jhon Done<br>
                            #24 Park Avenue Str<br>
                            New York<br>
                            Connecticut, 23456 New York<br>
                            United States<br>
                            T: 123123232<br>
                            F: 231231232<br>
                        </div>
                    </div>
                </div>
            @endif

            {{--UNLOCKED FORM--}}
            @if(!empty($method) && $method == 'unlocked')
                <div class="edit-form-details ">

                    <div class="form-group form-md-line-input has-success form-md-floating-label">
                        <div class="input-icon right ">
                            <input name="address" id="address" type="text" class="form-control input-lg" value="{{isset($order['address']) ? $order['address'] : ''}}"/>

                            <label for="address">{{trans('orders.address')}}</label>
                            <span class="help-block"></span>
                            <i class="fa fa-building"></i>
                        </div>
                    </div>

                    <div class="form-group form-md-line-input has-success form-md-floating-label">
                        <div class="input-icon right">
                            <input name="title" id="title" type="text" class="form-control input-lg" value="{{isset($order['title']) ? $order['title'] : ''}}"/>

                            <label for="title">{{trans('orders.city')}}</label>
                            <span class="help-block"></span>
                            <i class="fa fa-building-o"></i>
                        </div>
                    </div>

                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 no-padding">
                        <label for="state" class="control-label col-xs-12 default no-padding">
                            {{trans('orders.state')}}
                        </label>
                        <select id="state" name="state" class="form-control select2me input-lg no-padding" data-placeholder="{{trans('orders.select_state')}}">
                            <option value="">{{trans('orders.select_state')}}</option>
                            @if(isset($states) && is_array($states))
                                @foreach($states as $key => $state)
                                    <option value="{{$key}}" @if(!empty($order['state']) && $key == $order['state']) selected="selected" @endif>{{$state}}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>

                    <div class="clearfix"></div>

                    <div class="form-group form-md-line-input has-success form-md-floating-label">
                        <div class="input-icon right">
                            <input name="title" id="title" type="text" class="form-control input-lg" value="{{isset($order['title']) ? $order['title'] : ''}}"/>

                            <label for="title">{{trans('orders.post_code')}}</label>
                            <span class="help-block"></span>
                            <i class="fa fa-envelope-o"></i>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>