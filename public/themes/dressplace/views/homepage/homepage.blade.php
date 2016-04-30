@extends('dressplace::layout')

@section('content')
    {{--SLIDER--}}
    @if(!empty($sliders) && is_array($sliders))
        @foreach($sliders as $key => $slider)
            @if(!empty($slider['slides']) && is_array($slider['slides']) && !empty($slider['slides_positions']) && is_array($slider['slides_positions']))
                @include('dressplace::partials.render_slider', $slider)
            @endif
        @endforeach
    @endif

<div class="container banner-actions">
    <div class="row">
        <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 ">
            <div class="box free-delivery">
            <div class="icon pull-right">
            </div>
                <h3>Free UK shipping!</h3>
                <h5>This is a snappy sub-title</h5>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Neque beatae tempore porro officiis!</p>
            </div>
        </div>

        <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
            <div class="box returns">
            <div class="icon pull-right">
            </div>
                <h3>We're now global!</h3>
                <h5>This is a snappy sub-title</h5>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Neque beatae tempore porro officiis!</p>
            </div>
        </div>

        <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 ">
            <div class="box call-us">
            <div class="icon pull-right">
            </div>
                <h3>Lowest price guarantee!</h3>
                <h5>This is a snappy sub-title</h5>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Neque beatae tempore porro officiis!</p>
            </div>
        </div>
    </div>
</div>

    {{--CAROUSELS--}}
    @if(!empty($carousels) && is_array($carousels))
        @foreach($carousels as $carousel)
            @if(!empty($carousel['products']))
                {{--@include('dressplace::partials.render_carousel')--}}
            @endif
        @endforeach
    @endif

    {{--INIT MODULES--}}
{{--    @include('dressplace::partials.init_slider')--}}
{{--    @include('dressplace::partials.init_carousel')--}}
@endsection