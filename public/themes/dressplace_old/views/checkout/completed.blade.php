@extends('dressplace::layout')

@section('content')
    <div class="container checkout-preview">

        @if(isset($new))
            <div class="col-xs-12 no-padding">
                <div class="order-completed">
                    <i class="fa fa-check" aria-hidden="true"></i>
                    <div class="text">
                        <h1>{{trans('client.order_completed')}}</h1>
                        <h3>{{trans('client.order_completed_tip')}}</h3>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
        @else
            <h1 class="text-center margin-20">{{trans('client.order_preview')}} &#8470; {{$order['id']}}</h1>
        @endif

        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 information">

            @if(!empty($order['status']))
                <h4>{{trans('client.order_status')}}</h4>
                {{trans('client.' . $order['status'])}}
            @endif

            @if(!empty($order['email']))
                <h4>Email</h4>
                {{$order['email'] or ''}}
            @endif

            @if(!empty($order['name']))
                <h4>{{trans('client.name')}}</h4>
                {{$order['name'] or ''}}
            @endif

            @if(!empty($order['last_name']))
                <h4>{{trans('client.last_name')}}</h4>
                {{$order['last_name'] or ''}}
            @endif

            @if(!empty($order['phone']))
                <h4>{{trans('client.phone')}}</h4>
                {{$order['phone'] or ''}}
            @endif

            @if(!empty($order['address']))
                <h4>{{trans('client.address')}}</h4>
                {{$order['address'] or ''}}
            @endif

            @if(!empty($order['city']))
                <h4>{{trans('client.city')}}</h4>
                {{$order['city'] or ''}}
            @endif

            @if(!empty($order['orders']))
                <h4>{{trans('client.state')}}</h4>
                {{trans('orders.'.$order['state'] . '')}}
            @endif

            @if(!empty($order['postcode']))
                <h4>{{trans('client.postcode')}}</h4>
                {{$order['postcode'] or ''}}
            @endif

            @if(!empty($order['comment']))
                <h4>{{trans('client.comment')}}</h4>
                {{$order['comment'] or ''}}
            @endif

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