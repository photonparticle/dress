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
					<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 margin-bottom-10">
						<div class="dashboard-stat blue-madison">
							<div class="visual">
								<i class="fa fa-briefcase fa-icon-medium"></i>
							</div>
							<div class="details">
								<div class="number">
									 $168,492.54
								</div>
								<div class="desc">
									 Lifetime Sales
								</div>
							</div>
							<a class="more" href="javascript:;">
							View more <i class="m-icon-swapright m-icon-white"></i>
							</a>
						</div>
					</div>
					<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
						<div class="dashboard-stat red-intense">
							<div class="visual">
								<i class="fa fa-shopping-cart"></i>
							</div>
							<div class="details">
								<div class="number">
									 1,127,390
								</div>
								<div class="desc">
									 Total Orders
								</div>
							</div>
							<a class="more" href="javascript:;">
							View more <i class="m-icon-swapright m-icon-white"></i>
							</a>
						</div>
					</div>
					<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
						<div class="dashboard-stat green-haze">
							<div class="visual">
								<i class="fa fa-group fa-icon-medium"></i>
							</div>
							<div class="details">
								<div class="number">
									 $670.54
								</div>
								<div class="desc">
									 Average Orders
								</div>
							</div>
							<a class="more" href="javascript:;">
							View more <i class="m-icon-swapright m-icon-white"></i>
							</a>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-6">
						<!-- Begin: life time stats -->
						<div class="portlet light">
							<div class="portlet-title">
								<div class="caption">
									<i class="icon-bar-chart font-green-sharp"></i>
									<span class="caption-subject font-green-sharp bold uppercase">Overview</span>
									<span class="caption-helper">weekly stats...</span>
								</div>
								<div class="tools">
									<a href="javascript:;" class="collapse" data-original-title="" title="">
									</a>
									<a href="#portlet-config" data-toggle="modal" class="config" data-original-title="" title="">
									</a>
									<a href="javascript:;" class="reload" data-original-title="" title="">
									</a>
									<a href="javascript:;" class="fullscreen" data-original-title="" title="">
									</a>
									<a href="javascript:;" class="remove" data-original-title="" title="">
									</a>
								</div>
							</div>
							<div class="portlet-body">
								<div class="tabbable-line">
									<ul class="nav nav-tabs">
										<li class="active">
											<a href="#overview_1" data-toggle="tab">
											Top Selling </a>
										</li>
										<li>
											<a href="#overview_2" data-toggle="tab">
											Most Viewed </a>
										</li>
										<li>
											<a href="#overview_3" data-toggle="tab">
											Customers </a>
										</li>
										<li class="dropdown">
											<a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown">
											Orders <i class="fa fa-angle-down"></i>
											</a>
											<ul class="dropdown-menu" role="menu">
												<li>
													<a href="#overview_4" tabindex="-1" data-toggle="tab">
													Latest 10 Orders </a>
												</li>
												<li>
													<a href="#overview_4" tabindex="-1" data-toggle="tab">
													Pending Orders </a>
												</li>
												<li>
													<a href="#overview_4" tabindex="-1" data-toggle="tab">
													Completed Orders </a>
												</li>
												<li>
													<a href="#overview_4" tabindex="-1" data-toggle="tab">
													Rejected Orders </a>
												</li>
											</ul>
										</li>
									</ul>
									<div class="tab-content">
										<div class="tab-pane active" id="overview_1">
											<div class="table-responsive">
												<table class="table table-striped table-hover table-bordered">
												<thead>
												<tr>
													<th>
														 Product Name
													</th>
													<th>
														 Price
													</th>
													<th>
														 Sold
													</th>
													<th>
													</th>
												</tr>
												</thead>
												<tbody>
												<tr>
													<td>
														<a href="javascript:;">
														Apple iPhone 4s - 16GB - Black </a>
													</td>
													<td>
														 $625.50
													</td>
													<td>
														 809
													</td>
													<td>
														<a href="javascript:;" class="btn default btn-xs green-stripe">
														View </a>
													</td>
												</tr>
												<tr>
													<td>
														<a href="javascript:;">
														Samsung Galaxy S III SGH-I747 - 16GB </a>
													</td>
													<td>
														 $915.50
													</td>
													<td>
														 6709
													</td>
													<td>
														<a href="javascript:;" class="btn default btn-xs green-stripe">
														View </a>
													</td>
												</tr>
												<tr>
													<td>
														<a href="javascript:;">
														Motorola Droid 4 XT894 - 16GB - Black </a>
													</td>
													<td>
														 $878.50
													</td>
													<td>
														 784
													</td>
													<td>
														<a href="javascript:;" class="btn default btn-xs green-stripe">
														View </a>
													</td>
												</tr>
												<tr>
													<td>
														<a href="javascript:;">
														Regatta Luca 3 in 1 Jacket </a>
													</td>
													<td>
														 $25.50
													</td>
													<td>
														 1245
													</td>
													<td>
														<a href="javascript:;" class="btn default btn-xs green-stripe">
														View </a>
													</td>
												</tr>
												<tr>
													<td>
														<a href="javascript:;">
														Samsung Galaxy Note 3 </a>
													</td>
													<td>
														 $925.50
													</td>
													<td>
														 21245
													</td>
													<td>
														<a href="javascript:;" class="btn default btn-xs green-stripe">
														View </a>
													</td>
												</tr>
												<tr>
													<td>
														<a href="javascript:;">
														Inoval Digital Pen </a>
													</td>
													<td>
														 $125.50
													</td>
													<td>
														 1245
													</td>
													<td>
														<a href="javascript:;" class="btn default btn-xs green-stripe">
														View </a>
													</td>
												</tr>
												<tr>
													<td>
														<a href="javascript:;">
														Metronic - Responsive Admin + Frontend Theme </a>
													</td>
													<td>
														 $20.00
													</td>
													<td>
														 11190
													</td>
													<td>
														<a href="javascript:;" class="btn default btn-xs green-stripe">
														View </a>
													</td>
												</tr>
												</tbody>
												</table>
											</div>
										</div>
										<div class="tab-pane" id="overview_2">
											<div class="table-responsive">
												<table class="table table-striped table-hover table-bordered">
												<thead>
												<tr>
													<th>
														 Product Name
													</th>
													<th>
														 Price
													</th>
													<th>
														 Views
													</th>
													<th>
													</th>
												</tr>
												</thead>
												<tbody>
												<tr>
													<td>
														<a href="javascript:;">
														Metronic - Responsive Admin + Frontend Theme </a>
													</td>
													<td>
														 $20.00
													</td>
													<td>
														 11190
													</td>
													<td>
														<a href="javascript:;" class="btn default btn-xs green-stripe">
														View </a>
													</td>
												</tr>
												<tr>
													<td>
														<a href="javascript:;">
														Regatta Luca 3 in 1 Jacket </a>
													</td>
													<td>
														 $25.50
													</td>
													<td>
														 1245
													</td>
													<td>
														<a href="javascript:;" class="btn default btn-xs green-stripe">
														View </a>
													</td>
												</tr>
												<tr>
													<td>
														<a href="javascript:;">
														Apple iPhone 4s - 16GB - Black </a>
													</td>
													<td>
														 $625.50
													</td>
													<td>
														 809
													</td>
													<td>
														<a href="javascript:;" class="btn default btn-xs green-stripe">
														View </a>
													</td>
												</tr>
												<tr>
													<td>
														<a href="javascript:;">
														Samsung Galaxy S III SGH-I747 - 16GB </a>
													</td>
													<td>
														 $915.50
													</td>
													<td>
														 6709
													</td>
													<td>
														<a href="javascript:;" class="btn default btn-xs green-stripe">
														View </a>
													</td>
												</tr>
												<tr>
													<td>
														<a href="javascript:;">
														Motorola Droid 4 XT894 - 16GB - Black </a>
													</td>
													<td>
														 $878.50
													</td>
													<td>
														 784
													</td>
													<td>
														<a href="javascript:;" class="btn default btn-xs green-stripe">
														View </a>
													</td>
												</tr>
												<tr>
													<td>
														<a href="javascript:;">
														Samsung Galaxy Note 3 </a>
													</td>
													<td>
														 $925.50
													</td>
													<td>
														 21245
													</td>
													<td>
														<a href="javascript:;" class="btn default btn-xs green-stripe">
														View </a>
													</td>
												</tr>
												<tr>
													<td>
														<a href="javascript:;">
														Inoval Digital Pen </a>
													</td>
													<td>
														 $125.50
													</td>
													<td>
														 1245
													</td>
													<td>
														<a href="javascript:;" class="btn default btn-xs green-stripe">
														View </a>
													</td>
												</tr>
												</tbody>
												</table>
											</div>
										</div>
										<div class="tab-pane" id="overview_3">
											<div class="table-responsive">
												<table class="table table-striped table-hover table-bordered">
												<thead>
												<tr>
													<th>
														 Customer Name
													</th>
													<th>
														 Total Orders
													</th>
													<th>
														 Total Amount
													</th>
													<th>
													</th>
												</tr>
												</thead>
												<tbody>
												<tr>
													<td>
														<a href="javascript:;">
														David Wilson </a>
													</td>
													<td>
														 3
													</td>
													<td>
														 $625.50
													</td>
													<td>
														<a href="javascript:;" class="btn default btn-xs green-stripe">
														View </a>
													</td>
												</tr>
												<tr>
													<td>
														<a href="javascript:;">
														Amanda Nilson </a>
													</td>
													<td>
														 4
													</td>
													<td>
														 $12625.50
													</td>
													<td>
														<a href="javascript:;" class="btn default btn-xs green-stripe">
														View </a>
													</td>
												</tr>
												<tr>
													<td>
														<a href="javascript:;">
														Jhon Doe </a>
													</td>
													<td>
														 2
													</td>
													<td>
														 $125.00
													</td>
													<td>
														<a href="javascript:;" class="btn default btn-xs green-stripe">
														View </a>
													</td>
												</tr>
												<tr>
													<td>
														<a href="javascript:;">
														Bill Chang </a>
													</td>
													<td>
														 45
													</td>
													<td>
														 $12,125.70
													</td>
													<td>
														<a href="javascript:;" class="btn default btn-xs green-stripe">
														View </a>
													</td>
												</tr>
												<tr>
													<td>
														<a href="javascript:;">
														Paul Strong </a>
													</td>
													<td>
														 1
													</td>
													<td>
														 $890.85
													</td>
													<td>
														<a href="javascript:;" class="btn default btn-xs green-stripe">
														View </a>
													</td>
												</tr>
												<tr>
													<td>
														<a href="javascript:;">
														Jane Hilson </a>
													</td>
													<td>
														 5
													</td>
													<td>
														 $239.85
													</td>
													<td>
														<a href="javascript:;" class="btn default btn-xs green-stripe">
														View </a>
													</td>
												</tr>
												<tr>
													<td>
														<a href="javascript:;">
														Patrick Walker </a>
													</td>
													<td>
														 2
													</td>
													<td>
														 $1239.85
													</td>
													<td>
														<a href="javascript:;" class="btn default btn-xs green-stripe">
														View </a>
													</td>
												</tr>
												</tbody>
												</table>
											</div>
										</div>
										<div class="tab-pane" id="overview_4">
											<div class="table-responsive">
												<table class="table table-striped table-hover table-bordered">
												<thead>
												<tr>
													<th>
														 Customer Name
													</th>
													<th>
														 Date
													</th>
													<th>
														 Amount
													</th>
													<th>
														 Status
													</th>
													<th>
													</th>
												</tr>
												</thead>
												<tbody>
												<tr>
													<td>
														<a href="javascript:;">
														David Wilson </a>
													</td>
													<td>
														 3 Jan, 2013
													</td>
													<td>
														 $625.50
													</td>
													<td>
														<span class="label label-sm label-warning">
														Pending </span>
													</td>
													<td>
														<a href="javascript:;" class="btn default btn-xs green-stripe">
														View </a>
													</td>
												</tr>
												<tr>
													<td>
														<a href="javascript:;">
														Amanda Nilson </a>
													</td>
													<td>
														 13 Feb, 2013
													</td>
													<td>
														 $12625.50
													</td>
													<td>
														<span class="label label-sm label-warning">
														Pending </span>
													</td>
													<td>
														<a href="javascript:;" class="btn default btn-xs green-stripe">
														View </a>
													</td>
												</tr>
												<tr>
													<td>
														<a href="javascript:;">
														Jhon Doe </a>
													</td>
													<td>
														 20 Mar, 2013
													</td>
													<td>
														 $125.00
													</td>
													<td>
														<span class="label label-sm label-success">
														Success </span>
													</td>
													<td>
														<a href="javascript:;" class="btn default btn-xs green-stripe">
														View </a>
													</td>
												</tr>
												<tr>
													<td>
														<a href="javascript:;">
														Bill Chang </a>
													</td>
													<td>
														 29 May, 2013
													</td>
													<td>
														 $12,125.70
													</td>
													<td>
														<span class="label label-sm label-info">
														In Process </span>
													</td>
													<td>
														<a href="javascript:;" class="btn default btn-xs green-stripe">
														View </a>
													</td>
												</tr>
												<tr>
													<td>
														<a href="javascript:;">
														Paul Strong </a>
													</td>
													<td>
														 1 Jun, 2013
													</td>
													<td>
														 $890.85
													</td>
													<td>
														<span class="label label-sm label-success">
														Success </span>
													</td>
													<td>
														<a href="javascript:;" class="btn default btn-xs green-stripe">
														View </a>
													</td>
												</tr>
												<tr>
													<td>
														<a href="javascript:;">
														Jane Hilson </a>
													</td>
													<td>
														 5 Aug, 2013
													</td>
													<td>
														 $239.85
													</td>
													<td>
														<span class="label label-sm label-danger">
														Canceled </span>
													</td>
													<td>
														<a href="javascript:;" class="btn default btn-xs green-stripe">
														View </a>
													</td>
												</tr>
												<tr>
													<td>
														<a href="javascript:;">
														Patrick Walker </a>
													</td>
													<td>
														 6 Aug, 2013
													</td>
													<td>
														 $1239.85
													</td>
													<td>
														<span class="label label-sm label-success">
														Success </span>
													</td>
													<td>
														<a href="javascript:;" class="btn default btn-xs green-stripe">
														View </a>
													</td>
												</tr>
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
					<div class="col-md-6">
						<!-- Begin: life time stats -->
						<div class="portlet light">
							<div class="portlet-title tabbable-line">
								<div class="caption">
									<i class="icon-share font-red-sunglo"></i>
									<span class="caption-subject font-red-sunglo bold uppercase">Revenue</span>
									<span class="caption-helper">weekly stats...</span>
								</div>
								<ul class="nav nav-tabs">
									<li>
										<a href="#portlet_tab2" data-toggle="tab" id="statistics_amounts_tab">
										Amounts </a>
									</li>
									<li class="active">
										<a href="#portlet_tab1" data-toggle="tab">
										Orders </a>
									</li>
								</ul>
							</div>
							<div class="portlet-body">
								<div class="tab-content">
									<div class="tab-pane active" id="portlet_tab1">
										<div id="statistics_1" class="chart" style="padding: 0px; position: relative;">
										<canvas class="flot-base" width="448" height="300" style="direction: ltr; position: absolute; left: 0px; top: 0px; width: 448px; height: 300px;"></canvas>
                                            <div class="flot-text" style="position: absolute; top: 0px; left: 0px; bottom: 0px; right: 0px; font-size: smaller; color: rgb(84, 84, 84);">
                                                <div class="flot-x-axis flot-x1-axis xAxis x1Axis" style="position: absolute; top: 0px; left: 0px; bottom: 0px; right: 0px; display: block;">
                                                    <div style="position: absolute; max-width: 49px; top: 284px; font-style: normal; font-variant: small-caps; font-weight: 400; font-stretch: normal; font-size: 11px; line-height: 15px; font-family: 'Open Sans', sans-serif; color: rgb(111, 123, 138); left: 25px; text-align: center;">03/2013</div>
                                                    <div style="position: absolute; max-width: 49px; top: 284px; font-style: normal; font-variant: small-caps; font-weight: 400; font-stretch: normal; font-size: 11px; line-height: 15px; font-family: 'Open Sans', sans-serif; color: rgb(111, 123, 138); left: 73px; text-align: center;">04/2013</div>
                                                    <div style="position: absolute; max-width: 49px; top: 284px; font-style: normal; font-variant: small-caps; font-weight: 400; font-stretch: normal; font-size: 11px; line-height: 15px; font-family: 'Open Sans', sans-serif; color: rgb(111, 123, 138); left: 120px; text-align: center;">05/2013</div>
                                                    <div style="position: absolute; max-width: 49px; top: 284px; font-style: normal; font-variant: small-caps; font-weight: 400; font-stretch: normal; font-size: 11px; line-height: 15px; font-family: 'Open Sans', sans-serif; color: rgb(111, 123, 138); left: 168px; text-align: center;">06/2013</div>
                                                    <div style="position: absolute; max-width: 49px; top: 284px; font-style: normal; font-variant: small-caps; font-weight: 400; font-stretch: normal; font-size: 11px; line-height: 15px; font-family: 'Open Sans', sans-serif; color: rgb(111, 123, 138); left: 216px; text-align: center;">07/2013</div>
                                                    <div style="position: absolute; max-width: 49px; top: 284px; font-style: normal; font-variant: small-caps; font-weight: 400; font-stretch: normal; font-size: 11px; line-height: 15px; font-family: 'Open Sans', sans-serif; color: rgb(111, 123, 138); left: 263px; text-align: center;">08/2013</div>
                                                    <div style="position: absolute; max-width: 49px; top: 284px; font-style: normal; font-variant: small-caps; font-weight: 400; font-stretch: normal; font-size: 11px; line-height: 15px; font-family: 'Open Sans', sans-serif; color: rgb(111, 123, 138); left: 311px; text-align: center;">09/2013</div>
                                                    <div style="position: absolute; max-width: 49px; top: 284px; font-style: normal; font-variant: small-caps; font-weight: 400; font-stretch: normal; font-size: 11px; line-height: 15px; font-family: 'Open Sans', sans-serif; color: rgb(111, 123, 138); left: 358px; text-align: center;">10/2013</div>
                                                    <div style="position: absolute; max-width: 49px; top: 284px; font-style: normal; font-variant: small-caps; font-weight: 400; font-stretch: normal; font-size: 11px; line-height: 15px; font-family: 'Open Sans', sans-serif; color: rgb(111, 123, 138); left: 406px; text-align: center;">11/2013</div></div>
                                                <div class="flot-y-axis flot-y1-axis yAxis y1Axis" style="position: absolute; top: 0px; left: 0px; bottom: 0px; right: 0px; display: block;">
                                                    <div style="position: absolute; top: 257px; font-style: normal; font-variant: small-caps; font-weight: 400; font-stretch: normal; font-size: 11px; line-height: 15px; font-family: 'Open Sans', sans-serif; color: rgb(111, 123, 138); left: 20px; text-align: right;">0</div>
                                                    <div style="position: absolute; top: 205px; font-style: normal; font-variant: small-caps; font-weight: 400; font-stretch: normal; font-size: 11px; line-height: 15px; font-family: 'Open Sans', sans-serif; color: rgb(111, 123, 138); left: 7px; text-align: right;">500</div>
                                                    <div style="position: absolute; top: 154px; font-style: normal; font-variant: small-caps; font-weight: 400; font-stretch: normal; font-size: 11px; line-height: 15px; font-family: 'Open Sans', sans-serif; color: rgb(111, 123, 138); left: 1px; text-align: right;">1000</div>
                                                    <div style="position: absolute; top: 103px; font-style: normal; font-variant: small-caps; font-weight: 400; font-stretch: normal; font-size: 11px; line-height: 15px; font-family: 'Open Sans', sans-serif; color: rgb(111, 123, 138); left: 1px; text-align: right;">1500</div>
                                                    <div style="position: absolute; top: 52px; font-style: normal; font-variant: small-caps; font-weight: 400; font-stretch: normal; font-size: 11px; line-height: 15px; font-family: 'Open Sans', sans-serif; color: rgb(111, 123, 138); left: 1px; text-align: right;">2000</div>
                                                    <div style="position: absolute; top: 1px; font-style: normal; font-variant: small-caps; font-weight: 400; font-stretch: normal; font-size: 11px; line-height: 15px; font-family: 'Open Sans', sans-serif; color: rgb(111, 123, 138); left: 1px; text-align: right;">2500</div></div></div>
                                            <canvas class="flot-overlay" width="448" height="300" style="direction: ltr; position: absolute; left: 0px; top: 0px; width: 448px; height: 300px;"></canvas></div>
									</div>
									<div class="tab-pane" id="portlet_tab2">
										<div id="statistics_2" class="chart">
										</div>
									</div>
								</div>
								<div class="well margin-top-10 no-margin no-border">
									<div class="row">
										<div class="col-md-3 col-sm-3 col-xs-6 text-stat">
											<span class="label label-success">
											Revenue: </span>
											<h3>$111K</h3>
										</div>
										<div class="col-md-3 col-sm-3 col-xs-6 text-stat">
											<span class="label label-info">
											Tax: </span>
											<h3>$14K</h3>
										</div>
										<div class="col-md-3 col-sm-3 col-xs-6 text-stat">
											<span class="label label-danger">
											Shipment: </span>
											<h3>$10K</h3>
										</div>
										<div class="col-md-3 col-sm-3 col-xs-6 text-stat">
											<span class="label label-warning">
											Orders: </span>
											<h3>2350</h3>
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
        jQuery(document).ready(function() {
            EcommerceIndex.init();
        });
    </script>
@endsection