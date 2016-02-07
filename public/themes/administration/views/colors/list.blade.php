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
                                    <a href="#" class="btn btn-success add_color" title="{{trans('colors.add')}}">
                                        <i class="fa fa-plus"></i>
                                        {{trans('colors.add')}}
                                    </a>
                                </div>
                            </div>
                            <div class="portlet-body" id="colors_portlet">

                                @if(isset($colors) && is_array($colors))
                                    @foreach($colors as $color)
                                        @include('colors.color_partial', $color)
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

            $('body').on('click', '.add_color', function (e) {
                e.preventDefault();

                $.ajax({
                           type: 'get',
                           url: '/admin/module/colors/show/',
                           async: 'true',
                           headers: {
                               'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                           },
                           success: function (response) {
                               if (response) {
                                   $('#colors_portlet').append(response);
                               }
                           },
                           error: function () {
                               showNotification('error', translate('request_not_completed'), translate('contact_support'));
                           }

                       });
            });

            $('.remove_btn').click(function () {
                var color_id = $(this).attr('data-id');
                var color_title = $(this).attr('data-title');
                var parent = $(this).closest('.portlet');

                if (
                        typeof color_id !== typeof undefined && typeof color_title !== typeof undefined &&
                        color_title.length > 0 && color_title.length > 0
                ) {
                    bootbox.dialog({
                                       message: "<h4>{{trans('colors.remove')}}</h4> <strong>ID:</strong> " + color_id + " <br /><strong>{{trans('colors.title')}}:</strong> " + color_title,
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
                                                              url: '/admin/module/colors/destroy/' + color_id,
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

            $('body').on( 'click', '.save_btn',
                    function (e) {
                        e.preventDefault();

                        var
                                id = $(this).attr('data-id'),
                                title = $(this).closest('.portlet').find('#title').val(),
                                position = $(this).closest('.portlet').find('#position').val();

                        if(id == 'new') {
                            var url = 'store';
                        } else {
                            var url = 'update/' + id;
                        }

                        console.log(title);

                        $.ajax({
                                   type: 'post',
                                   url: '/admin/module/colors/' + url,
                                   data: {
                                       'id': id,
                                       'title': title,
                                       'position': position
                                   },
                                   headers: {
                                       'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                   },
                                   success: function (response) {
                                       if (typeof response == typeof {} && response['status'] && response['message']) {
                                           showNotification(response['status'], response['message']);
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