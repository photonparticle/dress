<div class="col-md-6 col-sm-12">
    <div class="portlet red-sunglo box">
        <div class="portlet-title">
            <div class="caption">
                <i class="fa fa-info-circle"></i>{{trans('orders.order_details')}}
            </div>
        </div>
        <div class="portlet-body">

            {{--LOCKED FORM--}}
            @if(empty($method) || !empty($method) && $method == 'locked')
            <div class="locked-form-details">
                <div class="row static-info">
                    <div class="col-md-5 name">
                        {{trans('orders.order_n')}}:
                    </div>
                    <div class="col-md-7 value">
                        12313232 <span class="label label-info label-sm">
                                                                        Email confirmation was sent </span>
                    </div>
                </div>
                <div class="row static-info">
                    <div class="col-md-5 name">
                        {{trans('orders.order_d_t')}}:
                    </div>
                    <div class="col-md-7 value">
                        Dec 27, 2013 7:16:25 PM
                    </div>
                </div>
                <div class="row static-info">
                    <div class="col-md-5 name">
                        {{trans('orders.order_status')}}:
                    </div>
                    <div class="col-md-7 value">
                                                                        <span class="label label-success">
                                                                        Closed </span>
                    </div>
                </div>
                <div class="row static-info">
                    <div class="col-md-5 name">
                        {{trans('orders.grand_total')}}:
                    </div>
                    <div class="col-md-7 value">
                        $175.25
                    </div>
                </div>
            </div>
            @endif

            {{--UNLOCKED FORM--}}
            @if(!empty($method) && $method == 'unlocked')
            <div class="edit-form-details ">

                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 no-padding margin-top-10">
                    <label for="created_at" class="control-label col-xs-12 default no-padding">
                        {{trans('orders.created_at')}}
                    </label>

                    <div class="input-group date created_at">
                        <input type="text" id="created_at" size="16" readonly class="form-control" value="{{isset($product['created_at']) ? $product['created_at'] : ''}}">
                                                                        <span class="input-group-btn">
                                                                            <button class="btn default date-set" type="button"><i class="fa fa-calendar"></i></button>
                                                                        </span>
                    </div>
                </div>

                <div class="clearfix"></div>

                <!-- START -->

                {{--STATUS--}}

                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 no-padding margin-top-20">
                    <label for="type" class="control-label col-xs-12 default no-padding">
                        {{trans('orders.order_status')}}
                    </label>
                    <select id="type" name="type" class="form-control input-lg">
                        <option value="">{{trans('orders.ch_status')}}</option>
                        <option value="requested" @if(!empty($orders['status']) && $order['status'] == 'requested') selected="selected" @endif>{{trans('orders.requested')}}</option>
                        <option value="sended" @if(!empty($order['status']) && $order['status'] == 'sended') selected="selected" @endif>{{trans('orders.sended')}}</option>
                        <option value="completed" @if(!empty($order['status']) && $order['status'] == 'completed') selected="selected" @endif>{{trans('orders.completed')}}</option>
                        <option value="canceled" @if(!empty($order['status']) && $order['status'] == 'canceled') selected="selected" @endif>{{trans('orders.canceled')}}</option>
                    </select>
                </div>

                <div class="clearfix"></div>

                <!-- END -->

                <!-- START -->

                {{--DELIVERY_TYPE--}}

                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 no-padding margin-top-20">
                    <label for="type" class="control-label col-xs-12 default no-padding">
                        {{trans('orders.delivery_type')}}
                    </label>
                    <select id="type" name="type" class="form-control input-lg">
                        <option value="">{{trans('orders.ch_delivery')}}</option>
                        <option value="to_office" @if(!empty($orders['status']) && $order['status'] == 'requested') selected="selected" @endif>{{trans('orders.to_office')}}</option>
                        <option value="to_address" @if(!empty($order['status']) && $order['status'] == 'sended') selected="selected" @endif>{{trans('orders.to_address')}}</option>
                    </select>
                </div>

                <div class="clearfix"></div>

                <!-- END -->
            </div>

            @endif
        </div>
    </div>
</div>