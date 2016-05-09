@extends('administration::layout')

@section('content')
        <!-- BEGIN EXAMPLE TABLE PORTLET-->
<div class="portlet box blue-madison">
    <div class="portlet-title">
        <div class="caption">
            <i class="fa fa-arrows"></i>{{$pageTitle}}
        </div>

        <div class="actions">
            <a href="/admin/module/sizes/create" class="btn green-haze" title="{{trans('sizes.add')}}">
                <i class="fa fa-plus"></i>
                {{trans('sizes.add')}}
            </a>
        </div>
    </div>
    <div class="portlet-body">
        @if(!empty($groups) && is_array($groups))
            <table class="table table-striped table-bordered table-hover" id="groups">
                <thead>
                <tr>
                    <th>
                        {{trans('sizes.group')}}
                    </th>
                    <th>
                        {{trans('sizes.actions')}}
                    </th>
                </tr>
                </thead>
                <tbody>
                @foreach($groups as $group)
                    @if(!empty($group))
                        <tr>
                            <td>{{$group}}</td>
                            <td class="text-center">
                                <a href="/admin/module/sizes/show/{{$group}}"
                                   class="btn btn-icon-only green"
                                   title="{{trans('global.edit')}}"
                                >
                                    <i class="fa fa-pencil"></i>
                                </a>
                                <a href="#"
                                   class="btn btn-icon-only red remove_group"
                                   title="{{trans('global.remove')}}"
                                   data-name="{{$group}}"
                                >
                                    <i class="fa fa-trash"></i>
                                </a>
                            </td>
                        </tr>
                    @endif
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

            $('.remove_group').click(function (e) {
                e.preventDefault();
                var group_name = $(this).attr('data-name');
                var parent = $(this).closest('tr');

                if (typeof group_name !== typeof undefined && group_name.length > 0) {
                    bootbox.dialog({
                                       message: "<h4>{{trans('sizes.group_remove')}}</h4><strong> " + group_name + "</strong>",
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
                                                              url: '/admin/module/sizes/destroy/false/' + group_name,
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

            var groups = $('#groups');

            if (groups.length > 0) {
                groups.DataTable({
                                     responsive: true,
                                     order: [[0, 'asc']],
                                     stateSave: true,
                                     adaptiveHeight: true,
                                     language: translateData['dataTable']
                                 });
            }


        });
    </script>
@endsection