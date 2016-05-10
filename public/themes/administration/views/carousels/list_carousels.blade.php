@extends('administration::layout')

@section('content')
        <!-- BEGIN EXAMPLE TABLE PORTLET-->
<div class="portlet box blue-madison">
    <div class="portlet-title">
        <div class="caption">
            <i class="fa fa-arrows-h"></i>{{$pageTitle}}
        </div>
        <div class="actions">
            <a href="/admin/module/carousels/create" class="btn green-haze" title="{{trans('carousels.create')}}">
                <i class="fa fa-plus"></i>
                {{trans('carousels.create')}}
            </a>
        </div>
    </div>
    <div class="portlet-body">
        @if(!empty($carousels) && is_array($carousels))
            <table class="table table-striped table-bordered table-hover" id="carousels">
                <thead>
                <tr>
                    <th>
                        ID
                    </th>
                    <th>
                        {{trans('carousels.title')}}
                    </th>
                    <th>
                        {{trans('carousels.type')}}
                    </th>
                    <th>
                        {{trans('carousels.active_from')}}
                    </th>
                    <th>
                        {{trans('carousels.active_to')}}
                    </th>
                    <th>
                        {{trans('carousels.created_at')}}
                    </th>
                    <th>
                        {{trans('carousels.actions')}}
                    </th>
                </tr>
                </thead>
                <tbody>
                @foreach($carousels as $carousel)
                    @if(!empty($carousel))
                        <tr>
                            <td>
                                {{$carousel['id'] or ''}}
                            </td>
                            <td>
                                {{$carousel['title'] or ''}}
                            </td>
                            <td>
                                @if(!empty($carousel['type']))
                                    @if($carousel['type'] == 'homepage')
                                        {{trans('carousels.homepage')}}
                                    @endif
                                    @if($carousel['type'] == 'categories')
                                        {{trans('carousels.categories')}}
                                    @endif
                                    @if($carousel['type'] == 'pages')
                                        {{trans('carousels.pages')}}
                                    @endif
                                @endif
                            </td>
                            <td>
                                {{$carousel['active_from'] or ''}}
                            </td>
                            <td>
                                {{$carousel['active_to'] or ''}}
                            </td>
                            <td>
                                {{$carousel['created_at'] or ''}}
                            </td>
                            <td class="text-center">
                                <a href="/admin/module/carousels/edit/{{$carousel['id']}}"
                                   class="btn btn-icon-only green"
                                   title="{{trans('global.edit')}}"
                                >
                                    <i class="fa fa-pencil"></i>
                                </a>
                                <a href="#"
                                   class="btn btn-icon-only red remove_slider"
                                   title="{{trans('global.remove')}}"
                                   data-id="{{$carousel['id']}}"
                                   data-title="{{$carousel['title']}}"
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

            $('.remove_slider').click(function (e) {
                e.preventDefault();
                var carousel_title = $(this).attr('data-title');
                var carousel_id = $(this).attr('data-id');
                var parent = $(this).closest('tr');

                if (typeof carousel_title !== typeof undefined && carousel_title.length > 0) {
                    bootbox.dialog({
                                       message: "<h4>{{trans('carousels.carousel_remove')}}</h4><strong> " + carousel_title + "</strong>",
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
                                                              url: '/admin/module/carousels/destroy/' + carousel_id,
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

            var carousels = $('#carousels');

            if (carousels.length > 0) {
                carousels.DataTable({
                                     responsive: true,
                                     order: [[0, 'asc']],
                                     stateSave: false,
                                     adaptiveHeight: true,
                                     language: translateData['dataTable']
                                 });
            }

        });
    </script>
@endsection