<!-- DROPZONE TAB -->
<div class="tab-pane" id="images_tab">

    {!! Form::open(['url' => route('upload-post'), 'class' => 'dropzone', 'files'=>TRUE, 'id'=>'real-dropzone']) !!}
    <input type="hidden" name="_token" value="{{ csrf_token() }}"/>

    @if(!empty($slider['id']))<input type="hidden" name="target" value="{{ $slider['id'] }}">@endif
    <input type="hidden" name="module" value="sliders">
    <input type="hidden" name="temp_key" value="{{ $images_dir or $slider['id'] }}">

    <div class="fallback">
        <input name="file" type="file" multiple/>
    </div>

    <div class="dropzone-previews" id="dropzonePreview"></div>

    <h4 style="text-align: center;color:#428bca;">Drop images in this area <span class="glyphicon glyphicon-hand-down"></span></h4>

    {!! Form::close() !!}

    <div class="clearfix"></div>

    <a href="javascript:;"
       class="btn green save_btn pull-right margin-top-20 padding-10"
       title="{{trans('global.save')}}"
    >
        <i class="fa fa-refresh"></i>
        {{trans('sliders.sync_images')}}
    </a>

    <div class="clearfix"></div>

    <div class="slider-images">
        @if(!empty($slider['images']) && is_array($slider['images']))
            @foreach($slider['images'] as $image => $position)
                @if($image)
                    <div class="slider-image-holder margin-top-20 padding-20 col-xs-12 col-sm-6 col-md-4 col-lg-3" data-image="{{isset($image) ? $image : ''}}">
                        <div class="portlet light col-xs-12">
                            <div class="portlet-title">
                                <div class="caption col-xs-12 col-sm-12 col-md-8 col-lg-8 text-center">
                                    <i class="fa fa-picture-o"></i>
                                    <div class="form-group form-md-line-input has-success form-md-floating-label col-xs-8 no-margin">
                                        <div class="input-icon right margin-10">
                                            <input id="position-{{$image}}" type="number" class="form-control input-sm input-position edited" value="{{isset($position) ? $position : '0'}}"/>

                                            <label for="position-{{$image}}">{{trans('sliders.position')}}</label>
                                            <span class="help-block"></span>
                                            <i class="fa fa-arrows-v"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="actions col-xs-12 col-sm-12 col-md-4 col-lg-4 text-center no-margin no-padding">
                                    <a href="javascript:;"
                                       class="btn btn-icon-only red remove_btn"
                                       title="{{trans('global.remove')}}"
                                       data-image="{{isset($image) ? $image : ''}}"
                                    >
                                        <i class="fa fa-remove"></i>
                                    </a>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                            <div class="portlet-body">
                                <img src="{{$thumbs_path . $image}}" alt="{{$image}}" class="img-responsive" />
                                <div class="clearfix"></div>
                            </div>
                        </div>
                    </div>
                @endif
            @endforeach
        @endif
        <div class="clearfix"></div>
    </div>

    <div class="clearfix"></div>
</div>
<!-- END DROPZONE TAB -->