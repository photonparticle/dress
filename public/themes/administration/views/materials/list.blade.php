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
                                    <i class="fa fa-info-circle"></i>
                                    <span class="caption-subject font-blue-madison bold uppercase">{{$pageTitle}}</span>
                                </div>
                                <div class="actions">
                                    <a href="#" class="btn btn-success add_material" title="{{trans('materials.add')}}">
                                        <i class="fa fa-plus"></i>
                                        {{trans('materials.add')}}
                                    </a>
                                </div>
                            </div>
                            <div class="portlet-body" id="materials_portlet">

                                @if(isset($materials) && is_array($materials))
                                    @foreach($materials as $material)
                                        @include('materials.material_partial', $material)
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

            $('body').on('click', '.add_material', function (e) {
                e.preventDefault();

                $.ajax({
                           type: 'get',
                           url: '/admin/module/materials/show/',
                           async: 'true',
                           headers: {
                               'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                           },
                           success: function (response) {
                               if (response) {
                                   $('#materials_portlet').append(response);
                               }
                           },
                           error: function () {
                               showNotification('error', translate('request_not_completed'), translate('contact_support'));
                           }

                       });
            });

            $('.remove_btn').click(function () {
                var material_id = $(this).attr('data-id');
                var material_title = $(this).attr('data-title');
                var parent = $(this).closest('.portlet');

                if (
                        typeof material_id !== typeof undefined && typeof material_title !== typeof undefined &&
                        material_title.length > 0 && material_title.length > 0
                ) {
                    bootbox.dialog({
                                       message: "<h4>{{trans('materials.remove')}}</h4> <strong>ID:</strong> " + material_id + " <br /><strong>{{trans('materials.title')}}:</strong> " + material_title,
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
                                                              url: '/admin/module/materials/destroy/' + material_id,
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
                                parent = $(this).closest('.portlet'),
                                id = $(this).attr('data-id'),
                                title = parent.find('#title').val(),
                                position = parent.find('#position').val();

                        if(id == 'new') {
                            var url = 'store';
                        } else {
                            var url = 'update/' + id;
                        }

                        // console.log(title);

                        $.ajax({
                                   type: 'post',
                                   url: '/admin/module/materials/' + url,
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
                                           
                                           if ( response['status'] == 'success')
                                           {
                                               
                                               parent.find('.caption span').html(title);
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