@extends('dressplace::layout')

@section('content')
    @if(!isset($ajax))
        <div class="container col-xs-12">
            @endif

            <h1 class="text-center">{{trans('client.my-orders')}}</h1>

            <div class="col-xs-12 margin-20">
                @if(!empty($orders) && is_array($orders))
                    <table class="table table-striped table-bordered table-hover" id="orders">
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
                                        {{trans('orders.' . $order['status'])}}
                                    </td>
                                    <td>
                                        {{$order['created_at']}}
                                    </td>

                                    <td class="text-center">
                                        <a href="/checkout/completed/{{$order['id']}}"
                                           class="btn btn-primary"
                                           title="{{trans('orders.preview_order')}}"
                                           data-toggle="tooltip"
                                           data-position="top"
                                        >{{trans('client.preview')}}
                                        </a>
                                    </td>
                                </tr>
                            @endif
                        @endforeach
                        </tbody>
                    </table>
                @endif
            </div>

            <div class="clearfix"></div>

            @if(!isset($ajax))
        </div>
    @endif
@endsection

@section('customJS')

    <script type="text/javascript">
        jQuery(document).ready(function () {
            var orders = $('#orders');

            if (orders.length > 0) {
                orders.DataTable({
                                     responsive: true,
                                     order: [[0, 'desc']],
                                     stateSave: false,
                                     adaptiveHeight: true,
                                     language: translateData['dataTable']
                                 });
                orders.on('page.dt', function () {
                    stickyFooter();
                });
            }
        });
    </script>
@endsection