@extends('administration::layout')

@section('content')
        <!-- BEGIN EXAMPLE TABLE PORTLET-->
<div class="portlet box blue-madison">
    <div class="portlet-title">
        <div class="caption">
            <i class="fa fa-image"></i>{{$pageTitle}}
        </div>
        <div class="actions">
            <a href="/admin/module/sliders/create" class="btn btn-success" title="{{trans('sliders.create')}}">
                <i class="fa fa-plus"></i>
                {{trans('sliders.create')}}
            </a>
        </div>
    </div>
    <div class="portlet-body">
        @if(!empty($sliders) && is_array($sliders))
            <table class="table table-striped table-bordered table-hover" id="sliders">
                <thead>
                <tr>
                    <th>
                        ID
                    </th>
                    <th>
                        {{trans('sliders.title')}}
                    </th>
                    <th>
                        {{trans('sliders.active_for')}}
                    </th>
                    <th>
                        {{trans('sliders.active_from')}}
                    </th>
                    <th>
                        {{trans('sliders.active_to')}}
                    </th>
                    <th>
                        {{trans('sliders.created_at')}}
                    </th>
                    <th>
                        {{trans('sliders.actions')}}
                    </th>
                </tr>
                </thead>
                <tbody>
                @foreach($sliders as $slider)
                    @if(!empty($slider))
                        <tr>
                            <td>
                                {{$slider['id'] or ''}}
                            </td>
                            <td>
                                {{$slider['title'] or ''}}
                            </td>
                            <td>
                                @if(!empty($slider['type']))
                                    @if($slider['type'] == 'homepage')
                                        {{trans('sliders.homepage')}}
                                    @endif
                                    @if($slider['type'] == 'categories')
                                        {{trans('sliders.categories')}}
                                    @endif
                                    @if($slider['type'] == 'pages')
                                        {{trans('sliders.pages')}}
                                    @endif
                                @endif
                            </td>
                            <td>
                                {{$slider['active_from'] or ''}}
                            </td>
                            <td>
                                {{$slider['active_to'] or ''}}
                            </td>
                            <td>
                                {{$slider['created_at'] or ''}}
                            </td>
                            <td class="text-center">
                                <a href="/admin/module/sliders/edit/{{$slider['id']}}"
                                   class="btn btn-icon-only green"
                                   title="{{trans('global.edit')}}"
                                >
                                    <i class="fa fa-pencil"></i>
                                </a>
                                <a href="#"
                                   class="btn btn-icon-only red remove_slider"
                                   title="{{trans('global.remove')}}"
                                   data-id="{{$slider['id']}}"
                                   data-title="{{$slider['title']}}"
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
                var slider_title = $(this).attr('data-title');
                var slider_id = $(this).attr('data-id');
                var parent = $(this).closest('tr');

                if (typeof slider_title !== typeof undefined && slider_title.length > 0) {
                    bootbox.dialog({
                                       message: "<h4>{{trans('sliders.slider_remove')}}</h4><strong> " + slider_title + "</strong><br /><h5>{{trans('sliders.slider_remove_tip')}}</h5>",
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
                                                              url: '/admin/module/sliders/destroy/slider/' + slider_id,
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

            var sliders = $('#sliders');

            if (sliders.length > 0) {
                sliders.DataTable({
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