@extends('administration::layout')

@section('content')
<!-- BEGIN EXAMPLE TABLE PORTLET-->
<div class="portlet box blue-madison">
    <div class="portlet-title">
        <div class="caption">
            <i class="fa fa-table"></i>{{$pageTitle}}
        </div>
        <div class="actions">
            <a href="/admin/module/tables/create" class="btn btn-success" title="{{trans('tables.create_table')}}">
                <i class="fa fa-plus"></i>
                {{trans('tables.create_table')}}
            </a>
        </div>
    </div>
    <div class="portlet-body">
        @if(!empty($tables) && is_array($tables))
            <table class="table table-striped table-bordered table-hover" id="tables">
                <thead>
                <tr>
                    <th>
                        {{trans('tables.image')}}
                    </th>
                    <th>
                        {{trans('tables.title')}}
                    </th>
                    <th>
                        {{trans('tables.actions')}}
                    </th>
                </tr>
                </thead>
                <tbody>
                @foreach($tables as $table)
                    @if(!empty($table))
                        <tr>
                            <td style="width: 128px">
                                @if(!empty($table['image']) &&
                                !empty($images_dir) &&
                                !empty($public_images_dir) &&
                                file_exists($images_dir . $table['image'])
                                )
                                    <img src="{{$public_images_dir. $table['image']}}" alt="{{$table['title']}}" class="img-responsive"/>
                                @endif
                            </td>
                            <td>
                                {{$table['title']}}
                            </td>
                            <td class="text-center">
                                <a href="/admin/module/tables/edit/{{$table['id']}}"
                                   class="btn btn-icon-only green"
                                   title="{{trans('global.edit')}}"
                                >
                                    <i class="fa fa-pencil"></i>
                                </a>
                                <a href="#"
                                   class="btn btn-icon-only red remove_table"
                                   title="{{trans('global.remove')}}"
                                   data-id="{{$table['id']}}"
                                   data-title="{{$table['title']}}"
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

            $('.remove_table').click(function (e) {
                e.preventDefault();
                var table_title = $(this).attr('data-title');
                var table_id = $(this).attr('data-id');
                var parent = $(this).closest('tr');

                if (typeof table_title !== typeof undefined && table_title.length > 0) {
                    bootbox.dialog({
                                       message: "<h4>{{trans('tables.table_remove')}}</h4><strong> " + table_title + "</strong>",
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
                                                              url: '/admin/module/tables/destroy/' + table_id,
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

            var tables = $('#tables');

            if (tables.length > 0) {
                tables.DataTable({
                                     responsive: true,
                                     order: [[1, 'asc']],
                                     stateSave: false,
                                     adaptiveHeight: true,
                                     language: translateData['dataTable']
                                 });
            }

        });
    </script>
@endsection