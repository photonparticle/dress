@if(!empty($slider['slides']) && is_array($slider['slides']) && !empty($slider['slides_positions']) && is_array($slider['slides_positions']))
    <div class="slider-wrap">
        <div class="fullwidthbanner-container">
            <div class="fullwidthbanner">
                <ul>
                    @foreach($slider['slides_positions'] as $image => $position)
                        <li data-transition="fade" data-slotamount="7" data-masterspeed="300" data-saveperformance="on">
                            <!--MAIN IMAGE-->
                            <img src="{{$sliders_path}}{{$slider['dir']}}/{{$image}}" alt="" data-bgposition="center top" data-duration="" data-ease="Power0.easeInOut" data-bgfit="cover" data-bgrepeat="no-repeat"/>

                            @if(!empty($slider['slides'][$image]['title']))
                                    <!-- Slide Caption -->
                            <div class="tp-caption skewfromrightshort skewtorightshort tp-resizeme"
                                 data-x="center" data-hoffset="0"
                                 data-y="center " data-voffset="-100"
                                 data-speed="500"
                                 data-start="500"
                                 data-easing="Power4.easeOut"
                                 data-splitin="none"
                                 data-splitout="none"
                                 data-elementdelay="0.01"
                                 data-endelementdelay="0.1"
                                 data-endspeed="500"
                                 data-endeasing="Power4.easeIn"
                                 style="z-index: 5; color:{{$slider['slides'][$image]['textColor'] or '#fff'}}; text-align:left !important; line-height:100%; font-size:50px; letter-spacing:6px; text-transform:uppercase; font-weight:900;">
                                {{$slider['slides'][$image]['title']}}
                            </div>
                            @endif

                            @if(!empty($slider['slides'][$image]['text']))
                                    <!-- Slide Text -->
                            <div class="tp-caption skewfromrightshort skewtorightshort tp-resizeme splitted"
                                 data-x="center" data-hoffset="0"
                                 data-y="center" data-voffset="-30"
                                 data-speed="100"
                                 data-start="1300"
                                 data-easing="Power4.easeInOut"
                                 data-splitin="chars"
                                 data-splitout="none"
                                 data-elementdelay="0.1"
                                 data-endelementdelay="0.1"
                                 data-endspeed="500"
                                 style="z-index: 4; font-size:35px;line-height:30px; text-transform:none; font-weight: 400; letter-spacing:4px; color:{{$slider['slides'][$image]['textColor'] or '#fff'}}; text-align:right !important; max-width: auto; max-height: auto; white-space: nowrap;">
                                {{$slider['slides'][$image]['text']}}
                            </div>
                            @endif

                            @if(!empty($slider['slides'][$image]['buttonText']) && !empty($slider['slides'][$image]['buttonURL']))
                                    <!-- Slide Action Button -->
                            <div class="tp-caption tp-fade fadeout tp-resizeme"
                                 data-x="center" data-hoffset="0"
                                 data-y="center" data-voffset="45"
                                 data-customin="x:0;y:0;z:0;rotationX:0;rotationY:0;rotationZ:0;scaleX:0;scaleY:0;skewX:0;skewY:0;opacity:0;transformPerspective:600;transformOrigin:50% 50%;"
                                 data-speed="500"
                                 data-start="1500"
                                 data-easing="Power3.easeInOut"
                                 data-splitin="none"
                                 data-splitout="none"
                                 data-elementdelay="0.05"
                                 data-endelementdelay="0.1"
                                 data-endspeed="500"
                                 style="z-index: 7;">
                                <a class="btn btn-default btn-icon"
                                   style="font-size:15px; text-align:left !important; padding: 12px 22px;font-weight:bold; color:#313131; text-transform:uppercase; line-height:24px;"
                                   href="{{$slider['slides'][$image]['buttonURL']}}"
                                >{{$slider['slides'][$image]['buttonText']}}
                                </a>
                            </div>
                            @endif
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
    <div class="clearfix"></div>
@endif