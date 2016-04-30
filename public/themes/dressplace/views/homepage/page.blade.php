@extends('dressplace::layout')

@section('content')
    @if(!isset($ajax))
        <div class="container col-xs-12">
            @endif

            <h1 class="text-center">{{$title or ''}}</h1>

            <div class="line"></div>
            <div class="col-xs-12 margin-20">
                {!!$content or ''!!}
            </div>

            @if(!isset($ajax))
        </div>
    @endif
@endsection