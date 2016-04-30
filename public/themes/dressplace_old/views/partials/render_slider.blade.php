@if(!empty($slider['slides']) && is_array($slider['slides']) && !empty($slider['slides_positions']) && is_array($slider['slides_positions']))
    <div class="slider-holder hidden">
        <div class="flexslider">
            <ul class="slides">
                @foreach($slider['slides_positions'] as $image => $position)
                    @if(!empty($image))
                        <li class="{{$slider['slides'][$image]['place'] or 'top-left'}}">
                            <img src="{{$sliders_path}}{{$slider['dir']}}/{{$image}}"/>
                            <div class="captions">
                                <div class="captions-holder">
                                    @if(!empty($slider['slides'][$image]['title']))
                                        <p class="flex-caption" @if(!empty($slider['slides'][$image]['textColor'])) style="color:{{$slider['slides'][$image]['textColor']}} !important;"@endif>{{$slider['slides'][$image]['title']}}</p>
                                        <div class="clearfix"></div>
                                    @endif

                                    @if(!empty($slider['slides'][$image]['text']))
                                        <p class="flex-sub-caption" @if(!empty($slider['slides'][$image]['textColor'])) style="color:{{$slider['slides'][$image]['textColor']}} !important;"@endif>{{$slider['slides'][$image]['text']}}</p>
                                        <div class="clearfix"></div>
                                    @endif

                                    @if(!empty($slider['slides'][$image]['buttonText']) && !empty($slider['slides'][$image]['buttonURL']))
                                        <a href="{{$slider['slides'][$image]['buttonURL']}}" class="action-btn" @if(!empty($slider['slides'][$image]['buttonColor'])) style="color:{{$slider['slides'][$image]['buttonColor']}} !important; border-color: {{$slider['slides'][$image]['buttonColor']}} !important;"@endif>
                                            {{$slider['slides'][$image]['buttonText']}}
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </li>
                    @endif
                @endforeach
            </ul>
        </div>
    </div>
<div class="clearfix"></div>
@endif