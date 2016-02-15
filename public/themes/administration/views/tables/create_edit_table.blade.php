@extends('administration::layout')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <!-- BEGIN PROFILE CONTENT -->
            <div class="profile-content">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="portlet light">
                            <div class="portlet-title tabbable-line">
                                <div class="caption caption-md">
                                    <i class="fa fa-arrows"></i>
                                    <span class="caption-subject font-blue-madison bold uppercase">{{$pageTitle}}</span>
                                </div>
                                <div class="actions">
                                    <a href="/admin/module/tables" class="btn btn-info margin-top-10" title="{{trans('tables.tables_list')}}">
                                        <i class="fa fa-arrow-left"></i>
                                        {{trans('tables.tables_list')}}
                                    </a>
                                    <a href="#" id="add_col" class="btn btn-success margin-top-10" title="{{trans('tables.add_col')}}">
                                        <i class="fa fa-plus"></i>
                                        {{trans('tables.add_col')}}
                                    </a>
                                    <a href="#" id="add_row" class="btn btn-success margin-top-10" title="{{trans('tables.add_row')}}">
                                        <i class="fa fa-plus"></i>
                                        {{trans('tables.add_row')}}
                                    </a>
                                    <a href="#" id="save" class="btn btn-success margin-top-10" title="{{trans('global.save')}}">
                                        <i class="fa fa-save"></i>
                                        {{trans('global.save')}}
                                    </a>
                                </div>
                            </div>
                            <div class="portlet-body">

                                <div class="form-group form-md-line-input has-success form-md-floating-label col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                    <div class="input-icon right">
                                        <input name="table_title" id="table_title" type="text" class="form-control input-lg" value="{{isset($table['title']) ? $table['title'] : ''}}"/>

                                        <label for="table_title">{{trans('tables.title')}}</label>
                                        <span class="help-block"></span>
                                        <i class="fa fa-font"></i>
                                    </div>
                                </div>

                                <div class="clearfix"></div>

                                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                    <div>
                                        <h3 class="font-blue-soft">{{trans('tables.image')}}</h3>
                                        <strong>{{trans('tables.image_limit')}}</strong> <br />
                                        <strong>{{trans('tables.image_limit_2')}}</strong>
                                    </div>
                                    @if(!empty($table['image']) &&
                                        !empty($images_dir) &&
                                        !empty($public_images_dir) &&
                                        file_exists($images_dir . $table['image'])
                                        )
                                        <div>
                                            <h3 class="font-blue-soft">{{trans('tables.current_image')}}</h3>
                                            <img src="{{$public_images_dir. $table['image']}}" alt="{{$table['title']}}" style="width:128px" />
                                        </div>
                                    @endif
                                </div>
                                <div class="clearfix visible-xs visible-md hidden-md hidden-lg">
                                    <hr class="visible-xs visible-md hidden-md hidden-lg" />
                                </div>

                                {!! Form::open(['url' => route('upload-post'), 'class' => 'dropzone col-xs-12 col-sm-12 col-md-6 col-lg-6', 'files'=>TRUE, 'id'=>'real-dropzone']) !!}
                                <input type="hidden" name="_token" value="{{ csrf_token() }}"/>

                                @if(!empty($product['id']))<input type="hidden" name="target" value="{{ $product['id'] }}">@endif
                                <input type="hidden" name="module" value="tables">
                                <input type="hidden" name="temp_key" value="{{ $table['image'] or $image_name }}">

                                <div class="fallback">
                                    <input name="file" type="file"/>
                                </div>

                                <div class="dropzone-previews" id="dropzonePreview"></div>

                                <h4 style="text-align: center;color:#428bca;">Drop image in this area <span class="glyphicon glyphicon-hand-down"></span></h4>

                                {!! Form::close() !!}

                                <div class="clearfix"></div>

                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                        <h3 class="font-blue-soft">{{trans('tables.cols')}}</h3>
                                        <hr/>
                                        <div id="cols">
                                            @if(isset($table['cols']) && is_array($table['cols']))
                                                @foreach($table['cols'] as $col)
                                                    @include('tables.show_table_cols_partial', ['col' => $col])
                                                @endforeach
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                        <h3 class="font-blue-soft">{{trans('tables.rows')}}</h3>
                                        <hr/>
                                        <div id="rows">
                                            @if(isset($table['rows']) && is_array($table['rows']))
                                                @foreach($table['rows'] as $row)
                                                    @include('tables.show_table_rows_partial', ['row' => $row])
                                                @endforeach
                                            @endif
                                        </div>
                                    </div>

                                    <div class="clearfix"></div>
                                </div>

                                <div class="clearfix"></div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- END PROFILE CONTENT -->
        </div>
    </div>
@endsection

@section('customJS')
    <script type="text/javascript">
        jQuery(document).ready(function () {

            $('body').on('click', '#add_col', function (e) {
                e.preventDefault();

                $.ajax({
                           type: 'get',
                           url: '/admin/module/tables/show/col',
                           async: 'true',
                           headers: {
                               'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                           },
                           success: function (response) {
                               if (response) {
                                   $('#cols').append(response);
                               }
                           },
                           error: function () {
                               showNotification('error', translate('request_not_completed'), translate('contact_support'));
                           }

                       });
            });

            $('body').on('click', '#add_row', function (e) {
                e.preventDefault();

                $.ajax({
                           type: 'get',
                           url: '/admin/module/tables/show/row',
                           async: 'true',
                           headers: {
                               'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                           },
                           success: function (response) {
                               if (response) {
                                   $('#rows').append(response);
                               }
                           },
                           error: function () {
                               showNotification('error', translate('request_not_completed'), translate('contact_support'));
                           }

                       });
            });

            $('body').on('click', '.remove', function () {
                $(this).closest('.holder').remove();
            });

            $('#save').click(
                    function (e) {
                        e.preventDefault();

                        if ($('#table_title').val().length == 0) {
                            showNotification('error', translate('title_required'));
                            return;
                        }

                        var title = $('#title').val(),
                                cols = [],
                                rows = [],
                                cols_holder = $('#cols .holder'),
                                rows_holder = $('#rows .holder');

                        if (cols_holder.length > 0) {
                            cols_holder.each(function () {
                                var title = $(this).find('#title').val();

                                if (title.length > 0) {
                                    cols.push(title);
                                }
                            });
                        }
                        if (rows_holder.length > 0) {
                            rows_holder.each(function () {
                                var title = $(this).find('#title').val();

                                if (title.length > 0) {
                                    rows.push(title);
                                }
                            });
                        }

                        $.ajax({
                                   type: 'post',
                                   url: '/admin/module/tables/store',
                                   data: {
                                       'title': $('#table_title').val(),
                                       'cols': cols,
                                       'rows': rows,
                                       'image_name': '{{$image_name . '.png' or ''}}',
                                       'id': '{{$table['id'] or ''}}'
                                   },
                                   headers: {
                                       'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                   },
                                   success: function (response) {
                                       if (typeof response == typeof {} && response['status'] && response['message']) {
                                           showNotification(response['status'], response['message']);
                                           if (response['status'] == 'success' && response['id']) {
                                               window.location.replace("/admin/module/tables/edit/" + response['id']);
                                           }
                                       } else {
                                           showNotification('error', translate('request_not_completed'), translate('contact_support'));
                                       }
                                   },
                                   error: function () {
                                       showNotification('error', translate('request_not_completed'), translate('contact_support'));
                                   }

                               });
                    }
            );
        });

        $.ajaxPrefilter(function (options) {
            if (!options.beforeSend) {
                options.beforeSend = function (xhr) {
                    xhr.setRequestHeader('X-CSRF-Token', $('meta[name="csrf-token"]').attr('content'));
                }
            }
        });
    </script>
@endsection