@extends('administration::layout')

@section('content')
    <!-- BEGIN EXAMPLE TABLE PORTLET-->
    <div class="portlet box blue-madison">
        <div class="portlet-title">
            <div class="caption">
                <i class="fa fa-tasks"></i>{{$pageTitle}}
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
                    @foreach($main_categories as $category_id)
                        @include('administration::categories.list_categories_partial')

                        @if(!empty($second_level_categories[$category_id]) && is_array($second_level_categories[$category_id]))
                            @foreach($second_level_categories[$category_id] as $category_id)
                                @include('administration::categories.list_categories_partial')
                            @endforeach
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

            $('#categories_list').DataTable({
                                                responsive: true,
                                                order: [],
                                                stateSave: false,
                                                adaptiveHeight: true,
                                                language: translateData['dataTable']
                                            });

        });
    </script>
@endsection