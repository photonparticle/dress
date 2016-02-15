@extends('administration::layout')

@section('content')
        <!-- BEGIN PROFILE CONTENT -->
<div class="profile-content">
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <div class="portlet light">
                <div class="portlet-title tabbable-line">
                    <div class="caption caption-lg margin-top-10">
                        <i class="fa fa-arrows"></i>
                        <span class="caption-subject font-blue-madison bold uppercase">{{$pageTitle}}</span>
                    </div>
                    <div class="actions">
                        <a href="/admin/module/sliders" class="btn btn-info margin-top-10" title="{{trans('sliders.sliders_list')}}">
                            <i class="fa fa-arrow-left"></i>
                            {{trans('sliders.sliders_list')}}
                        </a>
                        <a href="#" id="add_slide" class="btn btn-success margin-top-10" title="{{trans('sliders.add')}}">
                            <i class="fa fa-plus"></i>
                            {{trans('sliders.add')}}
                        </a>
                        <a href="#" id="save" class="btn btn-success margin-top-10" title="{{trans('sliders.save')}}">
                            <i class="fa fa-save"></i>
                            {{trans('sliders.save')}}
                        </a>
                    </div>
                    <div class="clearfix"></div>

                    <ul class="nav nav-tabs pull-left">
                        <li class="active">
                            <a href="#main_info_tab" data-toggle="tab">{{trans('sliders.main_info')}}</a>
                        </li>
                        <li>
                            <a href="#images_tab" data-toggle="tab">{{trans('sliders.images')}}</a>
                        </li>
                    </ul>
                </div>
                <div class="portlet-body">

                    <div class="tab-content">

                        {{--Main info tab--}}
                        @include('sliders.main_info_tab_partial')

                        {{--Images tab--}}
                        @include('sliders.images_tab_partial')

                    </div>

                    <div class="clearfix"></div>


                </div>
            </div>
        </div>
    </div>
</div>
<!-- END PROFILE CONTENT -->
@endsection

@section('customJS')
    <script type="text/javascript">
        jQuery(document).ready(function () {

            $('body').on('click', '#add_col', function (e) {
                e.preventDefault();

                $.ajax({
                           type: 'get',
                           url: '/admin/module/sliders/show/col',
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
                           url: '/admin/module/sliders/show/row',
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

                        if ($('#slider_title').val().length == 0) {
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
                                   url: '/admin/module/sliders/store',
                                   data: {
                                       'title': $('#slider_title').val(),
                                       'cols': cols,
                                       'rows': rows,
                                       'image_name': '@if(!empty($image_name)){{$image_name . ".png"}}@endif',
                                       'id': '{{$slider['id'] or ''}}'
                                   },
                                   headers: {
                                       'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                   },
                                   success: function (response) {
                                       if (typeof response == typeof {} && response['status'] && response['message']) {
                                           showNotification(response['status'], response['message']);
                                           if (response['status'] == 'success' && response['id']) {
                                               window.location.replace("/admin/module/sliders/edit/" + response['id']);
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