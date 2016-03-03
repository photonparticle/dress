@extends('administration::layout')

@section('content')
<!-- BEGIN EXAMPLE TABLE PORTLET-->
<div class="portlet box blue-madison">
    <div class="portlet-title">
        <div class="caption">
            <i class="fa fa-table"></i>{{$pageTitle}}
        </div>
        <div class="actions">
            <a href="/admin/pages/create" class="btn btn-success" title="{{trans('pages.create_page')}}">
                <i class="fa fa-plus"></i>
                {{trans('pages.create_page')}}
            </a>
        </div>
    </div>
    <div class="portlet-body">
        @if(!empty($pages) && is_array($pages))
            <table class="table table-striped table-bordered table-hover" id="pages">
                <thead>
                <tr>
                    <th>
                        {{trans('tables.title')}}
                    </th>
                    <th>
                        {{trans('tables.actions')}}
                    </th>
                </tr>
                </thead>
                <tbody>
                @foreach($pages as $page)
                    @if(!empty($page))
                        <tr>
                            <td>
                                {{$page['title']}}
                            </td>
                            <td class="text-center">
                                <a href="/admin/pages/edit/{{$page['id']}}"
                                   class="btn btn-icon-only green"
                                   title="{{trans('global.edit')}}"
                                >
                                    <i class="fa fa-pencil"></i>
                                </a>
                                <a href="#"
                                   class="btn btn-icon-only red remove_page"
                                   title="{{trans('global.remove')}}"
                                   data-id="{{$page['id']}}"
                                   data-title="{{$page['title']}}"
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

            $('.remove_page').click(function (e) {
                e.preventDefault();
                var page_title = $(this).attr('data-title');
                var page_id = $(this).attr('data-id');
                var parent = $(this).closest('tr');

                if (typeof page_title !== typeof undefined && page_title.length > 0) {
                    bootbox.dialog({
                                       message: "<h4>{{trans('pages.page_remove')}}</h4><strong> " + page_title + "</strong>",
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
                                                              url: '/admin/pages/destroy/' + page_id,
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

            var pages = $('#pages');

            if (pages.length > 0) {
                pages.DataTable({
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