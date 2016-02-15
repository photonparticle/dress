@extends('administration::layout')

@section('content')
        <!-- BEGIN EXAMPLE TABLE PORTLET-->
<div class="portlet box blue-madison">
    <div class="portlet-title">
        <div class="caption">
            <i class="fa fa-tags"></i>{{$pageTitle}}
        </div>
    </div>
    <div class="portlet-body">
        @if(!empty($tags) && is_array($tags))
            <table class="table table-striped table-bordered table-hover" id="tags_list">
                <thead>
                <tr>
                    <th>
                        ID
                    </th>
                    <th>
                        {{trans('tags.title')}}
                    </th>
                    <th>
                        {{trans('global.actions')}}
                    </th>
                </tr>
                </thead>
                <tbody>
                @foreach($tags as $tag)
                    <tr>
                        <td>{{isset($tag['id']) ? $tag['id'] : 'n/a'}}</td>
                        <td>{{isset($tag['title']) ? $tag['title'] : 'n/a'}}</td>
                        <td class="text-center">
                            <a href="#"
                               class="btn btn-icon-only red remove_category"
                               title="{{trans('global.remove')}}"
                               data-id="{{isset($tag['id']) ? $tag['id'] : ''}}"
                               data-title="{{isset($tag['title']) ? $tag['title'] : ''}}"
                            >
                                <i class="fa fa-trash"></i>
                            </a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @endif
    </div>
</div>
<!-- END EXAMPLE TABLE PORTLET-->
@endsection

@section('customJS')
    <script type="text/javascript">
        jQuery(document).ready(function () {

            $('.remove_category').click(function () {
                var tag_id = $(this).attr('data-id');
                var tag_title = $(this).attr('data-title');
                var parent = $(this).closest('tr');

                if (
                        typeof tag_id !== typeof undefined && typeof tag_title !== typeof undefined &&
                        tag_id.length > 0 && tag_title.length > 0
                ) {
                    bootbox.dialog({
                                       message: "<h4>{{trans('tags.tag_remove')}}</h4> <strong>ID:</strong> " + tag_id + " <br /><strong>{{trans('tags.title')}}:</strong> " + tag_title,
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
                                                              url: '/admin/module/tags/destroy/' + tag_id,
                                                              headers: {
                                                                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                                              },
                                                              success: function (response) {
                                                                  if (typeof response == typeof {} && response['status'] && response['message']) {
                                                                      showNotification(response['status'], response['title'], response['message']);
                                                                      if(response['status'] == 'success') {
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

            $('#tags_list').DataTable({
                                           responsive: true,
                                           order: [[0, 'asc']],
                                           stateSave: true,
                                           adaptiveHeight: true,
                                           language: translateData['dataTable']
                                       });

            

        });
    </script>
@endsection