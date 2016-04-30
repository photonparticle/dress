@extends('dressplace::layout')

@section('content')
    @if(!isset($ajax))
        <div class="container">
            @endif

            @include('dressplace::checkout.cart_partial')

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