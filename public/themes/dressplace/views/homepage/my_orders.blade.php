@extends('dressplace::layout')

@section('content')

    <div class="container">
        <div class="col-xs-12">
            <div class="section-title text-center no-margin-bottom">
                <h1 class="no-margin">
                    {{trans('client.my-orders')}}
                </h1>
            </div>
        </div>
        <div class="clearfix"></div>
    </div>

    <div class="container">
        <div class="col-xs-12 margin-20">
            @if(!empty($orders) && is_array($orders))
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover text-center" id="orders">
                        <thead>
                        <tr>
                            <th class="text-center">
                                {{trans('client.number')}}
                            </th>
                            <th class="text-center">
                                {{trans('orders.user_names')}}
                            </th>
                            <th class="text-center">
                                {{trans('orders.phone')}}
                            </th>
                            <th class="text-center">
                                {{trans('orders.order_status')}}
                            </th>
                            <th class="text-center">
                                {{trans('orders.created_at')}}
                            </th>
                            <th class="text-center">
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
                                           class="btn"
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
                </div>
            @endif
        </div>

        <div class="clearfix"></div>

    </div>
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