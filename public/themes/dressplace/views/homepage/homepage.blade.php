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

    {{--CALLBACK ACTIONS--}}
    @include('dressplace::partials.render_callback_actions')

    {{--CAROUSELS--}}
    @if(!empty($carousels) && is_array($carousels))
        @foreach($carousels as $carousel)
            @if(!empty($carousel['products']))
                {{--@include('dressplace::
                partials.render_carousel')--}}
            @endif
        @endforeach
    @endif

    {{--INIT MODULES--}}
{{--    @include('dressplace::partials.init_slider')--}}
{{--    @include('dressplace::partials.init_carousel')--}}
@endsection