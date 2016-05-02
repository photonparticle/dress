@extends('dressplace::layout')

@section('content')

    @if(!isset($ajax))
        <div class="container">
            @endif
            <div class="col-xs-12">
                <div class="section-title text-center">
                    <h1 class="no-margin">
                        {{$title or ''}}
                    </h1>
                </div>
            </div>
            <div class="clearfix"></div>
            @if(!isset($ajax))
        </div>
    @endif

    @if(!isset($ajax))
        <div class="container col-xs-12">
            @endif

            <div class="col-xs-12">
                {!!$content or ''!!}
            </div>

            @if(!isset($ajax))
        </div>
    @endif
@endsection