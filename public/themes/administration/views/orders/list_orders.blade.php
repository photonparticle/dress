@extends('administration::layout')

@section('content')
        <!-- BEGIN EXAMPLE TABLE PORTLET-->
<div class="portlet box blue-madison">
    <div class="portlet-title">
        <div class="caption">
            <i class="fa fa-orders"></i>{{$pageTitle}}
        </div>
        <div class="actions">
            <a href="/admin/orders/create" class="btn btn-success" title="{{trans('orders.create')}}">
                <i class="fa fa-plus"></i>
                {{trans('orders.create')}}
            </a>
        </div>
    </div>
    <div class="portlet-body">
        @if(!empty($orders) && is_array($orders))
            <table class="table orders-striped orders-bordered table-hover" id="orders">
                <thead>
                <tr>
                    <th>
                        ID
                    </th>
                    <th>
                        {{trans('orders.user_names')}}
                    </th>
                    <th>
                        {{trans('orders.phone')}}
                    </th>
                    <th>
                        {{trans('orders.order_status')}}
                    </th>
                    <th>
                        {{trans('orders.created_at')}}
                    </th>
                    <th>
                        {{trans('orders.actions')}}
                    </th>
                </tr>
                </thead>
                <tbody>
                @foreach($orders as $order)
                    @if(!empty($order))
                        <tr>
                            <td>
                                {{$order['id']}}
                            </td>
                            <td>
                                {{$order['name']}} {{$order['last_name']}}
                            </td>
                            <td>
                                {{$order['phone']}}
                            </td>
                            <td>
                                <span class="label label-sm text-center {{$order['status_color'] or ''}}">
                                {{trans('orders.' . $order['status'])}} </span>
                            </td>
                            <td>
                                {{$order['created_at']}}
                            </td>

                            <td class="text-center">
                                <a href="/admin/orders/show/{{$order['id']}}"
                                   class="btn btn-icon-only blue"
                                   title="{{trans('orders.preview_order')}}"
                                >
                                    <i class="fa fa-eye"></i>
                                </a>
                                <a href="/admin/orders/edit/{{$order['id']}}"
                                   class="btn btn-icon-only green"
                                   title="{{trans('global.edit')}}"
                                >
                                    <i class="fa fa-pencil"></i>
                                </a>
                                <a href="#"
                                   class="btn btn-icon-only red remove_order"
                                   title="{{trans('global.remove')}}"
                                   data-id="{{$order['id']}}"
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

            $('.remove_order').click(function (e) {
                console.log('remove product');
                e.preventDefault();
                var order_id = $(this).attr('data-id');
                var parent = $(this).closest('tr');

                if (typeof order_id !== typeof undefined && order_id.length > 0) {
                    bootbox.dialog({
                                       message: "<h4>{{trans('orders.order_remove')}}</h4><strong>ID: " + order_id + "</strong>",
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
                                                              url: '/admin/orders/destroy',
                                                              data: {
                                                                  method: 'order',
                                                                  order_id: order_id
                                                              },
                                                              headers: {
                                                                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                                              }
                                                              ,
                                                              success: function (response) {
                                                                  if (typeof response == typeof {} && response['status'] && response['message']) {
                                                                      showNotification(response['status'], response['title'], response['message']);
                                                                      if (response['status'] == 'success') {
                                                                          parent.remove();
                                                                      }
                                                                  } else {
                                                                      showNotification('error', translate('request_not_completed'), translate('contact_support'));
                                                                  }
                                                              }
                                                              ,
                                                              error: function () {
                                                                  showNotification('error', translate('request_not_completed'), translate('contact_support'));
                                                              }

                                                          })
                                                   ;
                                               }
                                           }
                                       }
                                   });
                }
            });

            var orders = $('#orders');

            if (orders.length > 0) {
                orders.DataTable({
                                     responsive: true,
                                     order: [[0, 'desc']],
                                     stateSave: false,
                                     adaptiveHeight: true,
                                     language: translateData['dataTable']
                                 });
            }

        });
    </script>
@endsection