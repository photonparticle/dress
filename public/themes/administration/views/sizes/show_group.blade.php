@extends('administration::layout')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <!-- BEGIN PROFILE CONTENT -->
            <div class="profile-content">
                <div class="row">
                    <div class="col-md-12">
                        <div class="portlet light">
                            <div class="portlet-title tabbable-line">
                                <div class="caption caption-md">
                                    <i class="fa fa-arrows"></i>
                                    <span class="caption-subject font-blue-madison bold uppercase">{{$pageTitle}}</span>
                                </div>
                                <div class="actions">
                                    <a href="/admin/module/sizes" class="btn btn-info" title="{{trans('sizes.group_list')}}">
                                        <i class="fa fa-arrow-left"></i>
                                        {{trans('sizes.group_list')}}
                                    </a>
                                    <a href="/admin/module/sizes/create" class="btn btn-success" title="{{trans('sizes.add')}}">
                                        <i class="fa fa-plus"></i>
                                        {{trans('sizes.add')}}
                                    </a>
                                </div>
                            </div>
                            <div class="portlet-body" id="sizes_portlet">

                                <div class="form-group form-md-line-input has-success form-md-floating-label col-xs-8 col-sm-9 col-md-10 col-lg-10">
                                    <div class="input-icon right">
                                        <input name="group" id="group" type="text" class="form-control input-md" value="{{isset($group) ? $group : ''}}"/>

                                        <label for="group">{{trans('sizes.name_group')}}</label>
                                        <span class="help-block"></span>
                                        <i class="fa fa-font"></i>
                                    </div>
                                </div>

                                <div class="col-xs-4 col-sm-3 col-md-2 col-lg-2 text-right" style="padding-top: 20px;">
                                    <a href="#"
                                       class="btn btn-icon-only blue add_size"
                                       title="{{trans('global.add')}}"
                                    >
                                        <i class="fa fa-plus"></i>
                                    </a>
                                    <a href="#"
                                       class="btn btn-icon-only green save_sizes"
                                       title="{{trans('global.save')}}"
                                    >
                                        <i class="fa fa-save"></i>
                                    </a>
                                </div>

                                <div class="clearfix"></div>

                                @if(isset($sizes) && is_array($sizes))
                                    @foreach($sizes as $size)
                                        @include('sizes.show_size_partial', $size)
                                    @endforeach
                                @endif

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


            //Global variables
            var group = '{{isset($group) ? $group : ''}}',
                    new_group_name = '';

            $('body').on('change', '#group', function () {
                new_group_name = $(this).val();
            });

            $('body').on('click', '.add_size', function (e) {
                console.log('Add size');
                e.preventDefault();

                $.ajax({
                           type: 'get',
                           url: '/admin/module/sizes/edit/',
                           async: 'true',
                           headers: {
                               'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                           },
                           success: function (response) {
                               if (response) {
                                   $('#sizes_portlet').append(response);
                               }
                           },
                           error: function () {
                               showNotification('error', translate('request_not_completed'), translate('contact_support'));
                           }

                       });
            });

            $('.remove_size').click(function () {
                var size_id = $(this).attr('data-id');
                var size_name = $(this).attr('data-name');
                var parent = $(this).closest('.portlet');

                if (
                        typeof size_id !== typeof undefined && typeof size_name !== typeof undefined &&
                        size_id.length > 0 && size_name.length > 0
                ) {
                    bootbox.dialog({
                                       message: "<h4>{{trans('sizes.size_remove')}}</h4> <strong>ID:</strong> " + size_id + " <br /><strong>{{trans('sizes.name')}}:</strong> " + size_name,
                                       title: "{{trans('global.confirm_action')}}",
                                       buttons: {
                                           cancel: {
                                               label: "{{trans('global.no')}}",
                                               className: "btn-danger"
                                           },
                                           confirm: {
                                               label: "{{trans('global.yes')}}",
                                               className: "btn-success",
                                               callback: function () {
                                                   $.ajax({
                                                              type: 'post',
                                                              url: '/admin/module/sizes/destroy/' + size_id,
                                                              headers: {
                                                                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                                              },
                                                              success: function (response) {
                                                                  if (typeof response == typeof {} && response['status'] && response['message']) {
                                                                      showNotification(response['status'], response['title'], response['message']);
                                                                      if (response['status'] == 'success') {
                                                                          parent.remove();
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
                                           }
                                       }
                                   });
                }
            });

            $('.save_sizes').click(
                    function (e) {
                        e.preventDefault();
                        var data = {
                                    'group': group,
                                    'sizes': {}
                                },
                                new_sizes = [];

                        if (new_group_name && new_group_name != group) {
                            data['new_group_name'] = new_group_name;
                        }

                        var box_target = $('.size_box');

                        if (box_target.length > 0) {
                            box_target.each(function () {
                                var id = $(this).attr('data-id'),
                                        name = $(this).find('.input-name').val(),
                                        position = $(this).find('.input-position').val();


                                if(!position || position.length == 0) {
                                    position = 0;
                                }

                                var size = {
                                    'id': id,
                                    'name': name,
                                    'group': group,
                                    'position': position
                                };

                                if (name) {
                                    if (id == 'new') {
                                        new_sizes.push(size);
                                    } else {
                                        data['sizes'][id] = size;
                                    }
                                }

                            });
                        }

                        data['new_sizes'] = new_sizes;

                        $.ajax({
                                   type: 'post',
                                   url: '/admin/module/sizes/update',
                                   data: data,
                                   headers: {
                                       'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                   },
                                   success: function (response) {
                                       if (typeof response == typeof {} && response['status'] && response['message']) {
                                           showNotification(response['status'], response['message']);
                                           if (new_group_name) {
                                               window.location.replace("/admin/module/sizes/show/" + new_group_name);
                                           } else {
                                               location.reload();
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
    </script>
@endsection