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
                            <strong>{{trans('orders.address')}}</strong><br />
                            {{$order['address'] or ''}}<br>
                            <hr />
                            <strong>{{trans('orders.city')}}</strong><br />
                            {{$order['city'] or ''}}<br>
                            <hr />
                            <strong>{{trans('orders.state')}}</strong><br />
                            {{$states[$order['state']] or ''}}
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
                            <input name="city" id="city" type="text" class="form-control input-lg" value="{{isset($order['city']) ? $order['city'] : ''}}"/>

                            <label for="city">{{trans('orders.city')}}</label>
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

                    <div class="form-group form-md-line-input has-success form-md-floating-label margin-top-20">
                        <div class="input-icon right">
                            <input name="post_code" id="post_code" type="text" class="form-control input-lg" value="{{isset($order['post_code']) ? $order['post_code'] : ''}}"/>

                            <label for="post_code">{{trans('orders.post_code')}}</label>
                            <span class="help-block"></span>
                            <i class="fa fa-envelope-o"></i>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>