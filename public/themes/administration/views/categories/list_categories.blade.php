@extends('administration::layout')

@section('content')
        <!-- BEGIN EXAMPLE TABLE PORTLET-->
<div class="portlet box blue-madison">
    <div class="portlet-title">
        <div class="caption">
            <i class="fa fa-user"></i>{{$pageTitle}}
        </div>
    </div>
    <div class="portlet-body">
        @if(!empty($categories) && is_array($categories))
            <table class="table table-striped table-bordered table-hover" id="categories_list">
                <thead>
                <tr>
                    <th>
                        ID
                    </th>
                    <th>
                        {{trans('categories.title')}}
                    </th>
                    <th>
                        {{trans('categories.level')}}
                    </th>
                    <th>
                        {{trans('categories.active')}}
                    </th>
                    <th>
                        {{trans('categories.visibility')}}
                    </th>
                    <th>
                        {{trans('global.actions')}}
                    </th>
                </tr>
                </thead>
                <tbody>
                @foreach($categories as $category)
                    <tr>
                        <td>{{isset($category['id']) ? $category['id'] : 'n/a'}}</td>
                        <td>{{isset($category['title']) ? $category['title'] : 'n/a'}}</td>
                        <td>{{isset($category['level']) ? trans('categories.level_'.$category['level']) : 'n/a'}}</td>
                        <td>
                            @if(isset($category['active']))
                                @if($category['active'] == 1)
                                    {{trans('categories.activated')}}
                                @else
                                    {{trans('categories.not_activated')}}
                                @endif
                            @endif
                        </td>
                        <td>
                            @if(isset($category['menu_visibility']))
                                @if($category['menu_visibility'] == 1)
                                    {{trans('categories.visible')}}
                                @else
                                    {{trans('categories.invisible')}}
                                @endif
                            @endif
                        </td>
                        <td class="text-center">
                            <a href="/admin/categories/edit/{{isset($category['id']) ? $category['id'] : 'n/a'}}"
                               class="btn btn-icon-only green"
                               title="{{trans('global.edit')}}"
                            >
                                <i class="fa fa-pencil"></i>
                            </a>
                            <a href="#"
                               class="btn btn-icon-only red remove_category"
                               title="{{trans('global.remove')}}"
                               data-id="{{isset($category['id']) ? $category['id'] : ''}}"
                               data-title="{{isset($category['title']) ? $category['title'] : ''}}"
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
                var category_id = $(this).attr('data-id');
                var category_title = $(this).attr('data-title');
                var parent = $(this).closest('tr');

                if (
                        typeof category_id !== typeof undefined && typeof category_title !== typeof undefined &&
                        category_id.length > 0 && category_title.length > 0
                ) {
                    bootbox.dialog({
                                       message: "<h4>{{trans('categories.category_remove')}}</h4> <strong>ID:</strong> " + category_id + " <br /><strong>{{trans('categories.title')}}:</strong> " + category_title,
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
                                                              url: '/admin/categories/destroy/' + category_id,
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

            $('#categories_list').DataTable({
                                           responsive: true,
                                           order: [[0, 'asc']],
                                           stateSave: true,
                                           adaptiveHeight: true,
                                           language: translateData['dataTable']
                                       });

            Metronic.init(); // init metronic core components
            Layout.init(); // init current layout
            Demo.init(); // init demo features

        });
    </script>
@endsection