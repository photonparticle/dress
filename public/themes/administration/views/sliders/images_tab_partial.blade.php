<!-- DROPZONE TAB -->
<div class="tab-pane" id="images_tab">

    {!! Form::open(['url' => route('upload-post'), 'class' => 'dropzone', 'files'=>TRUE, 'id'=>'real-dropzone']) !!}
    <input type="hidden" name="_token" value="{{ csrf_token() }}"/>

    @if(!empty($slider['id']))<input type="hidden" name="target" value="{{ $slider['id'] }}">@endif
    <input type="hidden" name="module" value="sliders">
    <input type="hidden" name="temp_key" value="{{ $slider_dir or $slider['dir'] }}">

    <div class="fallback">
        <input name="file" type="file" multiple/>
    </div>

    <div class="dropzone-previews" id="dropzonePreview"></div>

    <h4 style="text-align: center;color:#428bca;">Drop images in this area <span class="glyphicon glyphicon-hand-down"></span></h4>

    {!! Form::close() !!}

    <div class="clearfix"></div>

    <a href="javascript:;"
       class="btn green pull-right margin-top-20 padding-10"
       title="{{trans('sliders.sync_images')}}"
       data-scan-target="{{$slider_dir or $slider['dir']}}"
       id="sync_images"
    >
        <i class="fa fa-refresh"></i>
        {{trans('sliders.sync_images')}}
    </a>

    <div class="clearfix"></div>

    <div id="slider-images"></div>

    <div class="clearfix"></div>
</div>
<!-- END DROPZONE TAB -->