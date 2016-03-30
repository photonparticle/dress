@if(!empty($images) && is_array($images))
    @foreach($images as $image => $position)
        <div class="slider-image-holder margin-top-20 padding-20 col-xs-12 col-sm-12 col-md-12 col-lg-12" data-image="{{isset($image) ? $image : ''}}">
            <div class="portlet light col-xs-12">
                <div class="portlet-title">
                    <div class="caption caption-md col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <i class="fa fa-picture-o"></i>
                        {{trans('sliders.slide')}}

                        {{--DELETE BUTTON--}}
                        <a href="javascript:;"
                           class="btn btn-icon-only red remove_slide"
                           title="{{trans('global.remove')}}"
                           data-image="{{isset($image) ? $image : ''}}"
                           style="position: absolute;top:0;right: 0;"
                        >
                            <i class="fa fa-remove"></i>
                        </a>
                    </div>

                    <div class="clearfix"></div>
                </div>
                <div class="portlet-body">
                    {{--IMAGE--}}
                    <div class="col-xs-6 col-sm-4 col-md-3 col-lg-2">
                        <img src="{{$thumbs_path . '/' . $image}}" alt="{{$image}}" class="img-responsive margin-top-15" />
                    </div>

                    {{--FORM--}}
                    <div class="col-xs-6 col-sm-8 col-md-9 col-lg-10">

                        {{--Slider_CLASS_PARENT--}}
                        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                            
                            {{--Slider_Title--}}
                            <div class="caption col-xs-12 margin-top-10">
                                <div class="form-group form-md-line-input has-success form-md-floating-label col-xs-12 no-margin">
                                    <div class="input-icon right margin-10">
                                        <input id="title-{{$image}}" type="text" class="form-control input-sm input-title edited" value="{{isset($image_data[$image]['title']) ? $image_data[$image]['title'] : ''}}"/>

                                        <label for="title-{{$image}}">{{trans('sliders.title')}}</label>
                                        <span class="help-block"></span>
                                        <i class="fa fa fa-font"></i>
                                    </div>
                                </div>
                            </div>
                            
                            {{--Slider_Text--}}
                            <div class="caption col-xs-12 margin-top-10">
                                <div class="form-group form-md-line-input has-success form-md-floating-label col-xs-12 no-margin">
                                    <div class="input-icon right margin-10">
                                        <input id="text-{{$image}}" type="text" class="form-control input-sm input-text edited" value="{{isset($image_data[$image]['text']) ? $image_data[$image]['text'] : ''}}"/>

                                        <label for="text-{{$image}}">{{trans('sliders.text')}}</label>
                                        <span class="help-block"></span>
                                        <i class="fa fa fa-font"></i>
                                    </div>
                                </div>
                            </div>
                            
                            {{--Position--}}
                            <div class="caption col-xs-12 margin-top-10">
                                <div class="form-group form-md-line-input has-success form-md-floating-label col-xs-12 no-margin">
                                    <div class="input-icon right margin-10">
                                        <input id="position-{{$image}}" type="number" class="form-control input-sm input-position edited" value="{{isset($position) ? $position : '0'}}"/>

                                        <label for="position-{{$image}}">{{trans('sliders.position')}}</label>
                                        <span class="help-block"></span>
                                        <i class="fa fa-arrows-v"></i>
                                    </div>
                                </div>
                            </div>
                            
                        </div>
                                                
                        {{--Buttons_CLASS--}}
                        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                            
                            {{--Button--}}
                            <div class="caption col-xs-12 margin-top-10">
                                <div class="form-group form-md-line-input has-success form-md-floating-label col-xs-12 no-margin">
                                    <div class="input-icon right margin-10">
                                        <input id="buttonText-{{$image}}" type="text" class="form-control input-sm input-buttonText edited" value="{{isset($image_data[$image]['buttonText']) ? $image_data[$image]['buttonText'] : ''}}"/>

                                        <label for="buttonText-{{$image}}">{{trans('sliders.buttonText')}}</label>
                                        <span class="help-block"></span>
                                        <i class="fa fa-font"></i>
                                    </div>
                                </div>
                            </div>
                            
                            {{--Button_URL--}}
                            <div class="caption col-xs-12 margin-top-10">
                                <div class="form-group form-md-line-input has-success form-md-floating-label col-xs-12 no-margin">
                                    <div class="input-icon right margin-10">
                                        <input id="buttonURL-{{$image}}" type="buttonURL" class="form-control input-sm input-buttonURL edited" value="{{isset($image_data[$image]['buttonURL']) ? $image_data[$image]['buttonURL'] : ''}}"/>

                                        <label for="buttonURL-{{$image}}">{{trans('sliders.buttonURL')}}</label>
                                        <span class="help-block"></span>
                                        <i class="fa fa-link"></i>
                                    </div>
                                </div>
                            </div>
                            
                        </div>
                        
                        {{--Text_color--}}

                        <div class="caption col-xs-12 col-sm-12 col-md-6 col-lg-6 margin-top-10">
                            <div class="form-group">
                                <label class="col-md-3 control-label">Hue (default)</label>
                                <div class="col-md-5">
                                    <input type="text" id="text_color" class="form-control input-text-color" data-control="hue" value="#ffffff">
                                </div>
                            </div>
                        </div>

                        {{--btn_text_color--}}

                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
    @endforeach
@endif