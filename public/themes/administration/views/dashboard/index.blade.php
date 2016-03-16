@extends('administration::layout')

@section('content')

        <!-- BEGIN PAGE HEADER-->
<h3 class="page-title">
    {{trans('dashboard.dashboard')}} &amp; {{trans('dashboard.statistics')}}
    <small>

    </small>
</h3>
<!-- END PAGE HEADER-->

<!-- BEGIN PAGE CONTENT-->
<div class="row">
    @if(!empty($total_sales))
        <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 margin-bottom-10">
            <div class="dashboard-stat blue-madison">
                <div class="visual">
                    <i class="fa fa-briefcase fa-icon-medium"></i>
                </div>
                <div class="details">
                    <div class="number">
                        {{$total_sales}} {{trans('dashboard.currency')}}
                    </div>
                    <div class="desc">
                        {{trans('dashboard.total_sales')}}
                    </div>
                </div>
                <a class="more" href="/admin/orders">
                    {{trans('dashboard.orders')}} <i class="m-icon-swapright m-icon-white"></i>
                </a>
            </div>
        </div>
    @endif
    @if(!empty($count_sales))
        <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
            <div class="dashboard-stat red-intense">
                <div class="visual">
                    <i class="fa fa-shopping-cart"></i>
                </div>
                <div class="details">
                    <div class="number">
                        {{$count_sales}}
                    </div>
                    <div class="desc">
                        {{trans('dashboard.count_orders')}}
                    </div>
                </div>
                <a class="more" href="/admin/orders">
                    {{trans('dashboard.orders')}} <i class="m-icon-swapright m-icon-white"></i>
                </a>
            </div>
        </div>
    @endif
    @if(!empty($avg_sales))
        <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
            <div class="dashboard-stat green-haze">
                <div class="visual">
                    <i class="fa fa-group fa-icon-medium"></i>
                </div>
                <div class="details">
                    <div class="number">
                        {{$avg_sales}} {{trans('dashboard.currency')}}
                    </div>
                    <div class="desc">
                        {{trans('dashboard.avg')}}
                    </div>
                </div>
                <a class="more" href="/admin/orders">
                    {{trans('dashboard.orders')}} <i class="m-icon-swapright m-icon-white"></i>
                </a>
            </div>
        </div>
    @endif
</div>
<div class="row">
    <div class="col-md-12">
        <!-- Begin: life time stats -->
        <div class="portlet light">
            <div class="portlet-title tabbable-line">
                <div class="caption">
                    <i class="icon-share font-red-sunglo"></i>
                    <span class="caption-subject font-red-sunglo bold uppercase">{{trans('dashboard.orders')}}</span>
                    <span class="caption-helper">{{trans('dashboard.weekly_status')}}</span>
                </div>
                <ul class="nav nav-tabs">
                    <li>
                        <a href="#numbers" data-toggle="tab" id="number_tab">
                            {{trans('dashboard.number')}} </a>
                    </li>
                    <li class="active">
                        <a href="#amounts" data-toggle="tab" id="amount_tab">
                            {{trans('dashboard.amounts')}} </a>
                    </li>
                </ul>
            </div>
            <div class="portlet-body">
                <div class="tab-content">
                    <div class="tab-pane active" id="amounts">
                        <div id="statistics_1" class="chart" style="padding: 0px; position: relative;">

                        </div>
                    </div>
                    <div class="tab-pane" id="numbers">
                        <div id="statistics_2" class="chart">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End: life time stats -->
    </div>
    <div class="col-md-12">
        <!-- Begin: life time stats -->
        <div class="portlet light">
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-bar-chart font-green-sharp"></i>
                    <span class="caption-subject font-green-sharp bold uppercase">{{trans('dashboard.overview')}}</span>
                </div>
            </div>
            <div class="portlet-body">
                <div class="tabbable-line">
                    <ul class="nav nav-tabs">
                        <li class="active">
                            <a href="#last_orders" data-toggle="tab">
                                {{trans('dashboard.last_20_orders')}} ({{$last_orders_count or 0}}) </a>
                        </li>
                        <li>
                            <a href="#last_users" data-toggle="tab">
                                {{trans('dashboard.last_20_users')}} ({{$last_users_count or 0}}) </a>
                        </li>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="last_orders">
                            <div class="table-responsive">
                                <table class="table table-striped table-hover table-bordered">
                                    <thead>
                                    <tr>
                                        <th>
                                            {{trans('dashboard.names')}}
                                        </th>
                                        <th>
                                            {{trans('dashboard.created_at')}}
                                        </th>
                                        <th class="text-center">
                                            {{trans('dashboard.status')}}
                                        </th>
                                        <th>
                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if(!empty($last_orders))
                                        @foreach($last_orders as $order)
                                            <tr>
                                                <td>
                                                    {{$order['first_name'] or ''}} {{$order['last_name'] or ''}}
                                                </td>
                                                <td>
                                                    {{$order['created_at'] or ''}}
                                                </td>
                                                <td class="text-center">
														<span class="label label-sm text-center {{$order['status_color'] or ''}}">
														{{$order['status'] or ''}} </span>
                                                </td>
                                                <td class="text-center">
                                                    <a href="/admin/orders/show/{{$order['id'] or ''}}" class="btn default btn-xs green-stripe">
                                                        {{trans('dashboard.preview')}} </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="tab-pane" id="last_users">
                            <div class="table-responsive">
                                <table class="table table-striped table-hover table-bordered">
                                    <thead>
                                    <tr>
                                        <th>
                                            {{trans('dashboard.names')}}
                                        </th>
                                        <th>
                                            {{trans('dashboard.email')}}
                                        </th>
                                        <th>
                                            {{trans('dashboard.user_created_at')}}
                                        </th>
                                        <th>
                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if(!empty($last_users))
                                        @foreach($last_users as $user)
                                            <tr>
                                                <td>
                                                    {{$user['first_name'] or ''}} {{$user['last_name'] or ''}}
                                                </td>
                                                <td>
                                                    {{$user['email'] or ''}}
                                                </td>
                                                <td>
                                                    {{$user['created_at'] or ''}}
                                                </td>
                                                <td class="text-center">
                                                    <a href="/admin/users/edit/{{$user['id'] or ''}}" class="btn default btn-xs green-stripe">
                                                        {{trans('dashboard.preview')}} </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <!-- End: life time stats -->
    </div>
</div>
<!-- END PAGE CONTENT-->


@endsection

@section('customJS')
    <script type="text/javascript">
        jQuery(document).ready(function () {
            @if(!empty($graph))
            $('#amount_tab').on('shown.bs.tab', function (e) {
                initChart();
            });
            if(window.location.hash && window.location.hash == '#amounts') {
                initChart();
            } else {
                initChart();
            }
            initChart();
            function initChart() {

                var data = [
                    @foreach($graph as $date => $amount)
                    ['{{$date}}', {{$amount}}],
                    @endforeach
                ];

                var plot_statistics = $.plot(
                        $("#statistics_1"),
                        [
                            {
                                data:data,
                                lines: {
                                    fill: 0.6,
                                    lineWidth: 0
                                },
                                color: ['#f89f9f']
                            },
                            {
                                data: data,
                                points: {
                                    show: true,
                                    fill: true,
                                    radius: 5,
                                    fillColor: "#f89f9f",
                                    lineWidth: 3
                                },
                                color: '#fff',
                                shadowSize: 0
                            }
                        ],
                        {

                            xaxis: {
                                tickLength: 0,
                                tickDecimals: 0,
                                mode: "categories",
                                min: 0,
                                font: {
                                    lineHeight: 15,
                                    style: "normal",
                                    variant: "small-caps",
                                    color: "#6F7B8A"
                                }
                            },
                            yaxis: {
                                ticks: 3,
                                tickDecimals: 0,
                                tickColor: "#f0f0f0",
                                font: {
                                    lineHeight: 15,
                                    style: "normal",
                                    variant: "small-caps",
                                    color: "#6F7B8A"
                                }
                            },
                            grid: {
                                backgroundColor: {
                                    colors: ["#fff", "#fff"]
                                },
                                borderWidth: 1,
                                borderColor: "#f0f0f0",
                                margin: 0,
                                minBorderMargin: 0,
                                labelMargin: 20,
                                hoverable: true,
                                clickable: true,
                                mouseActiveRadius: 6
                            },
                            legend: {
                                show: false
                            }
                        }
                );

                var previousPoint = null;

                $("#statistics_1").bind("plothover", function (event, pos, item) {
                    $("#x").text(pos.x.toFixed(2));
                    $("#y").text(pos.y.toFixed(2));
                    if (item) {
                        if (previousPoint != item.dataIndex) {
                            previousPoint = item.dataIndex;

                            $("#tooltip").remove();
                            var x = item.datapoint[0].toFixed(2),
                                    y = item.datapoint[1].toFixed(2);

                            showTooltip(item.pageX, item.pageY, item.datapoint[0], item.datapoint[1]);
                        }
                    } else {
                        $("#tooltip").remove();
                        previousPoint = null;
                    }
                });

            }
            @endif

            @if(!empty($graph2))
            $('#number_tab').on('shown.bs.tab', function (e) {
                initChart2();
            });

            if(window.location.hash && window.location.hash == '#numbers') {
                initChart2();
            }

            function initChart2() {

                var data = [
                        @foreach($graph2 as $date => $count)
                    ['{{$date}}', {{$count}}],
                    @endforeach
                ];

                var plot_statistics = $.plot(
                        $("#statistics_2"),
                        [
                            {
                                data:data,
                                lines: {
                                    fill: 0.6,
                                    lineWidth: 0
                                },
                                color: ['#BAD9F5']
                            },
                            {
                                data: data,
                                points: {
                                    show: true,
                                    fill: true,
                                    radius: 5,
                                    fillColor: "#BAD9F5",
                                    lineWidth: 3
                                },
                                color: '#fff',
                                shadowSize: 0
                            }
                        ],
                        {

                            xaxis: {
                                tickLength: 0,
                                tickDecimals: 0,
                                mode: "categories",
                                min: 0,
                                font: {
                                    lineHeight: 14,
                                    style: "normal",
                                    variant: "small-caps",
                                    color: "#6F7B8A"
                                }
                            },
                            yaxis: {
                                ticks: 3,
                                tickDecimals: 0,
                                tickColor: "#f0f0f0",
                                font: {
                                    lineHeight: 14,
                                    style: "normal",
                                    variant: "small-caps",
                                    color: "#6F7B8A"
                                }
                            },
                            grid: {
                                backgroundColor: {
                                    colors: ["#fff", "#fff"]
                                },
                                borderWidth: 1,
                                borderColor: "#f0f0f0",
                                margin: 0,
                                minBorderMargin: 0,
                                labelMargin: 20,
                                hoverable: true,
                                clickable: true,
                                mouseActiveRadius: 6
                            },
                            legend: {
                                show: false
                            }
                        }
                );

                var previousPoint = null;

                $("#statistics_2").bind("plothover", function (event, pos, item) {
                    $("#x").text(pos.x.toFixed(2));
                    $("#y").text(pos.y.toFixed(2));
                    if (item) {
                        if (previousPoint != item.dataIndex) {
                            previousPoint = item.dataIndex;

                            $("#tooltip").remove();
                            var x = item.datapoint[0].toFixed(2),
                                    y = item.datapoint[1].toFixed(2);

                            showTooltip2(item.pageX, item.pageY, item.datapoint[0], item.datapoint[1]);
                        }
                    } else {
                        $("#tooltip").remove();
                        previousPoint = null;
                    }
                });

            }
            @endif

            function showTooltip(x, y, labelX, labelY) {
                $('<div id="tooltip" class="chart-tooltip">' + (labelY.toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, '$1,')) + ' {{trans('dashboard.currency')}}<\/div>').css({
                                                                                                                                                 position: 'absolute',
                                                                                                                                                 display: 'none',
                                                                                                                                                 top: y - 40,
                                                                                                                                                 left: x - 60,
                                                                                                                                                 border: '0px solid #ccc',
                                                                                                                                                 padding: '2px 6px',
                                                                                                                                                 'background-color': '#fff'
                                                                                                                                             }).appendTo("body").fadeIn(200);
            }

            function showTooltip2(x, y, labelX, labelY) {
                $('<div id="tooltip" class="chart-tooltip">' + (labelY.toFixed(0).replace(/(\d)(?=(\d{3})+\.)/g, '$1,')) + ' <\/div>').css({
                                                                                                                                                 position: 'absolute',
                                                                                                                                                 display: 'none',
                                                                                                                                                 top: y - 40,
                                                                                                                                                 left: x - 60,
                                                                                                                                                 border: '0px solid #ccc',
                                                                                                                                                 padding: '2px 6px',
                                                                                                                                                 'background-color': '#fff'
                                                                                                                                             }).appendTo("body").fadeIn(200);
            }

        });
    </script>
@endsection