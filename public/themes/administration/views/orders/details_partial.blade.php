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
                            {{$order['id'] or ''}}
                        </div>
                    </div>
                    <div class="row static-info">
                        <div class="col-md-5 name">
                            {{trans('orders.order_d_t')}}:
                        </div>
                        <div class="col-md-7 value">
                            {{$order['created_at'] or ''}}
                        </div>
                    </div>
                    <div class="row static-info">
                        <div class="col-md-5 name">
                            {{trans('orders.order_status')}}:
                        </div>
                        <div class="col-md-7 value">
                            <span class="label label-sm text-center {{$order['status_color'] or ''}}">
                                {{trans('orders.' . $order['status'])}}
                            </span>
                        </div>
                    </div>
                    <div class="row static-info summary-total">
                        <div class="col-md-5 name">
                            {{trans('orders.grand_total')}}:
                        </div>
                        <div class="col-md-7 value">

                        </div>
                    </div>
                </div>
            @endif

            {{--UNLOCKED FORM--}}
            @if(!empty($method) && $method == 'unlocked')
                <div class="edit-form-details ">

                    {{--Created at--}}
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 no-padding margin-top-10">
                        <label for="created_at" class="control-label col-xs-12 default no-padding">
                            {{trans('orders.created_at')}}
                        </label>

                        <div class="input-group date created_at">
                            <input type="text" id="created_at" size="16" readonly class="form-control" value="{{isset($order['created_at']) ? $order['created_at'] : $current_time}}">
                                                                        <span class="input-group-btn">
                                                                            <button class="btn default date-set" type="button"><i class="fa fa-calendar"></i></button>
                                                                        </span>
                        </div>
                    </div>

                    <div class="clearfix"></div>

                    <!-- START -->

                    {{--STATUS--}}

                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 no-padding margin-top-20">
                        <label for="status" class="control-label col-xs-12 default no-padding">
                            {{trans('orders.order_status')}}
                        </label>
                        <select id="status" name="status" class="form-control input-lg">
                            <option value="">{{trans('orders.ch_status')}}</option>
                            <option value="pending" @if(!empty($order['status']) && $order['status'] == 'pending') selected="selected" @endif>{{trans('orders.pending')}}</option>
                            <option value="confirmed" @if(!empty($order['status']) && $order['status'] == 'confirmed') selected="selected" @endif>{{trans('orders.confirmed')}}</option>
                            <option value="completed" @if(!empty($order['status']) && $order['status'] == 'completed') selected="selected" @endif>{{trans('orders.completed')}}</option>
                            <option value="canceled" @if(!empty($order['status']) && $order['status'] == 'canceled') selected="selected" @endif>{{trans('orders.canceled')}}</option>
                        </select>
                    </div>

                    <div class="clearfix"></div>

                    <!-- END -->

                    <!-- START -->

                    {{--DELIVERY_TYPE--}}

                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 no-padding margin-top-20">
                        <label for="delivery_type" class="control-label col-xs-12 default no-padding">
                            {{trans('orders.delivery_type')}}
                        </label>
                        <select id="delivery_type" name="delivery_type" class="form-control input-lg">
                            <option value="">{{trans('orders.ch_delivery')}}</option>
                            <option value="to_office" @if(!empty($order['delivery_type']) && $order['delivery_type'] == 'to_office') selected="selected" @endif>{{trans('orders.to_office')}}</option>
                            <option value="to_address" @if(!empty($order['delivery_type']) && $order['delivery_type'] == 'to_address') selected="selected" @endif>{{trans('orders.to_address')}}</option>
                        </select>
                    </div>

                    <div class="clearfix"></div>

                    <!-- END -->
                </div>

            @endif
        </div>
    </div>
</div>