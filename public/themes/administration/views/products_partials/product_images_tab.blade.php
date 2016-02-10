<!-- DROPZONE TAB -->
<div class="tab-pane" id="images">

        {{--<form action="/upload" class="dropzone dz-clickable" id="my-dropzone">--}}
            {{--<input type="hidden" name="_token" value="{{ Session::token() }}">--}}
            {{--<input type="hidden" name="dir" value="{{ $temp_name }}">--}}
            {{--<div class="dz-default dz-message">--}}
                {{--<!-- BEGIN ERROR MESSAGE -->--}}
                {{--<span>Drop files here to upload</span>--}}
                {{--<!-- END ERROR MESSAGE -->--}}
            {{--</div>--}}
        {{--</form>--}}

    {!! Form::open(['url' => route('upload-post'), 'class' => 'dropzone', 'files'=>true, 'id'=>'real-dropzone']) !!}
    <input type="hidden" name="_token" value="{{ csrf_token() }}"/>

    <input type="hidden" name="temp_key" value="{{ $images_dir or $product['id'] }}">

    <div class="fallback">
        <input name="file" type="file" multiple />
    </div>

    <div class="dropzone-previews" id="dropzonePreview"></div>

    <h4 style="text-align: center;color:#428bca;">Drop images in this area  <span class="glyphicon glyphicon-hand-down"></span></h4>

    {!! Form::close() !!}

        <div class="clearfix"></div>

        <div class="margin-top-20">
            <button class="btn green-haze save_product">
                {{trans('global.save')}} </button>
            <a href="/admin/products" class="btn default">
                {{trans('global.cancel')}} </a>
        </div>



</div>
<!-- END DROPZONE TAB -->