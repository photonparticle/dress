@extends('dressplace::layout')

@section('content')
    @if(!isset($ajax))
        <div class="container">
            @endif

            @include('dressplace::checkout.cart_partial')


            {{--CALLBACK ACTIONS--}}
            @include('dressplace::partials.render_callback_actions')

            @if(!isset($ajax))
        </div>
    @endif
@endsection

@section('customJS')
    <script type="text/javascript">
        $(document).ready(function () {
            checkout($('.cart-container'));
        });
    </script>
@endsection