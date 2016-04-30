@extends('dressplace::layout')

@section('content')
    <div class="container check-out">
        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" name="email" id="email" placeholder="Email">
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="form-group">
                    <label for="name">{{trans('client.name')}}</label>
                    <input type="text" class="form-control" id="name" name="name" placeholder="{{trans('client.name')}}">
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="form-group">
                    <label for="last_name">{{trans('client.last_name')}}</label>
                    <input type="text" class="form-control" id="last_name" name="last_name" placeholder="{{trans('client.last_name')}}">
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="form-group">
                    <label for="phone">{{trans('client.phone')}}</label>
                    <input type="text" class="form-control" id="phone" name="phone" placeholder="{{trans('client.phone')}}">
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="form-group">
                    <label for="address">{{trans('client.address')}}</label>
                    <input type="text" class="form-control" id="address" name="address" placeholder="{{trans('client.address')}}">
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="form-group">
                    <label for="city">{{trans('client.city')}}</label>
                    <input type="text" class="form-control" id="city" name="city" placeholder="{{trans('client.city')}}">
                </div>
            </div>

            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <label for="state" class="control-label default">
                    {{trans('orders.state')}}
                </label>
                <select id="state" name="state" class="form-control input-md" data-placeholder="{{trans('orders.select_state')}}">
                    <option value="">{{trans('orders.select_state')}}</option>
                    @if(isset($states) && is_array($states))
                        @foreach($states as $key => $state)
                            <option value="{{$key}}" @if(!empty($order['state']) && $key == $order['state']) selected="selected" @endif>{{$state}}</option>
                        @endforeach
                    @endif
                </select>
            </div>

            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 padding-15 no-padding-bottom">
                <div class="form-group">
                    <label for="postcode">{{trans('client.postcode')}}</label>
                    <input type="text" class="form-control" id="postcode" name="postcode" placeholder="{{trans('client.postcode')}}">
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="form-group">
                    <label for="comment">{{trans('client.comment')}}</label>
                    <textarea class="form-control" id="comment" name="comment" placeholder="{{trans('client.comment')}}"></textarea>
                </div>
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
            @include('dressplace::checkout.cart_partial')
        </div>
    </div>
@endsection

@section('customJS')
    <script type="text/javascript">
        $(document).ready(function () {
            checkout($('.cart-container'));
        });
    </script>
@endsection