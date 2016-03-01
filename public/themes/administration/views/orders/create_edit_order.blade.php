@extends('administration::layout')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <!-- BEGIN PROFILE CONTENT -->
            <div class="profile-content">
                <div class="row">
                    <div class="col-md-12">
                        <div class="portlet light">
                            <div class="portlet-title tabbable-line">
                                <div class="caption caption-md">
                                    <i class="fa fa-shopping-cart"></i>
                                    <span class="caption-subject font-blue-madison bold uppercase">{{$pageTitle}}</span>
                                </div>
                                <div class="actions">
                                    <a href="#" class="btn btn-info add_manufacturer" title="{{trans('orders.orders_list')}}">
                                        <i class="fa fa-arrow-left"></i>
                                        {{trans('orders.orders_list')}}
                                    </a>
                                </div>
                            </div>
                            <div class="portlet-body">

                                
											<div class="row">
												<div class="col-md-6 col-sm-12">
													<div class="portlet yellow-crusta box">
														<div class="portlet-title">
															<div class="caption">
																<i class="fa fa-shopping-cart"></i>{{trans('orders.order_details')}}
															</div>
														</div>
														<div class="portlet-body">
															<div class="row static-info">
																<div class="col-md-5 name">
																	 {{trans('orders.order_n')}}:
																</div>
																<div class="col-md-7 value">
																	 12313232 <span class="label label-info label-sm">
																	Email confirmation was sent </span>
                                                                </div>
															</div>
															<div class="row static-info">
																<div class="col-md-5 name">
																	 {{trans('orders.order_d_t')}}:
																</div>
																<div class="col-md-7 value">
																	 Dec 27, 2013 7:16:25 PM
																</div>
															</div>
															<div class="row static-info">
																<div class="col-md-5 name">
																	 {{trans('orders.order_status')}}:
																</div>
																<div class="col-md-7 value">
																	<span class="label label-success">
																	Closed </span>
																</div>
															</div>
															<div class="row static-info">
																<div class="col-md-5 name">
																	 {{trans('orders.grand_total')}}:
																</div>
																<div class="col-md-7 value">
																	 $175.25
																</div>
															</div>
														</div>
													</div>
												</div>
												<div class="col-md-6 col-sm-12">
													<div class="portlet blue-hoki box">
														<div class="portlet-title">
															<div class="caption">
																<i class="fa fa-shopping-cart"></i>{{trans('orders.customer_info')}}
															</div>
														</div>
														<div class="portlet-body">
															<div class="row static-info">
																<div class="col-md-5 name">
																	 {{trans('orders.name')}}:
																</div>
																<div class="col-md-7 value">
																	 Jhon Doe
																</div>
															</div>
															<div class="row static-info">
																<div class="col-md-5 name">
																	 {{trans('orders.email')}}:
																</div>
																<div class="col-md-7 value">
																	 jhon@doe.com
																</div>
															</div>
															<div class="row static-info">
																<div class="col-md-5 name">
																	 {{trans('orders.phone')}}:
																</div>
																<div class="col-md-7 value">
																	 12234389
																</div>
															</div>
														</div>
													</div>
												</div>
											</div>
											<div class="row">
												<div class="col-md-6 col-sm-12 col-lg-12">
													<div class="portlet red-sunglo box">
														<div class="portlet-title">
															<div class="caption">
																<i class="fa fa-shopping-cart"></i>{{trans('orders.shipping_addr')}}
															</div>
														</div>
														<div class="portlet-body">
															<div class="row static-info">
																<div class="col-md-12 value">
																	 Jhon Done<br>
																	 #24 Park Avenue Str<br>
																	 New York<br>
																	 Connecticut, 23456 New York<br>
																	 United States<br>
																	 T: 123123232<br>
																	 F: 231231232<br>
																</div>
															</div>
														</div>
													</div>
												</div>
											</div>
											<div class="row">
												<div class="col-md-12 col-sm-12">
													<div class="portlet grey-cascade box">
														<div class="portlet-title">
															<div class="caption">
																<i class="fa fa-shopping-cart"></i>{{trans('orders.shopping_cart')}}
															</div>
														</div>
													</div>
												</div>
											</div>
											<div class="row">
												<div class="col-md-6">
												</div>
												<div class="col-md-6">
													<div class="well">
														<div class="row static-info align-reverse">
															<div class="col-md-8 name">
																 {{trans('orders.sub_total')}}:
															</div>
															<div class="col-md-3 value">
																 $1,124.50
															</div>
														</div>
														<div class="row static-info align-reverse">
															<div class="col-md-8 name">
																 {{trans('orders.shipping')}}:
															</div>
															<div class="col-md-3 value">
																 $40.50
															</div>
														</div>
														<div class="row static-info align-reverse">
															<div class="col-md-8 name">
																 {{trans('orders.grand_total')}}:
															</div>
															<div class="col-md-3 value">
																 $1,260.00
															</div>
														</div>
														</div>
													</div>
												</div>
											</div>
										

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- END PROFILE CONTENT -->
        </div>
    </div>
@endsection

@section('customJS')
    <script type="text/javascript">
        jQuery(document).ready(function () {

            //Global variables
            var group = '{{isset($group) ? $group : ''}}',
                    new_group_name = '';

            $('body').on('change', '#group', function () {
                new_group_name = $(this).val();
            });

            $('body').on('click', '.add_manufacturer', function (e) {
                e.preventDefault();

                $.ajax({
                           type: 'get',
                           url: '/admin/module/manufacturers/show/',
                           async: 'true',
                           headers: {
                               'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                           },
                           success: function (response) {
                               if (response) {
                                   $('#manufacturers_portlet').append(response);
                               }
                           },
                           error: function () {
                               showNotification('error', translate('request_not_completed'), translate('contact_support'));
                           }

                       });
            });

            $('.remove_btn').click(function () {
                var manufacturer_id = $(this).attr('data-id');
                var manufacturer_title = $(this).attr('data-title');
                var parent = $(this).closest('.portlet');

                if (
                        typeof manufacturer_id !== typeof undefined && typeof manufacturer_title !== typeof undefined &&
                        manufacturer_title.length > 0 && manufacturer_title.length > 0
                ) {
                    bootbox.dialog({
                                       message: "<h4>{{trans('manufacturers.remove')}}</h4> <strong>ID:</strong> " + manufacturer_id + " <br /><strong>{{trans('manufacturers.title')}}:</strong> " + manufacturer_title,
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
                                                              url: '/admin/module/manufacturers/destroy/' + manufacturer_id,
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

            $('body').on( 'click', '.save_btn',
                    function (e) {
                        e.preventDefault();

                        var
                                parent = $(this).closest('.portlet'),
                                id = $(this).attr('data-id'),
                                title = parent.find('#title').val(),
                                position = parent.find('#position').val();

                        if(id == 'new') {
                            var url = 'store';
                        } else {
                            var url = 'update/' + id;
                        }

                        console.log(title);

                        $.ajax({
                                   type: 'post',
                                   url: '/admin/module/manufacturers/' + url,
                                   data: {
                                       'id': id,
                                       'title': title,
                                       'position': position
                                   },
                                   headers: {
                                       'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                   },
                                   success: function (response) {
                                       if (typeof response == typeof {} && response['status'] && response['message']) {
                                           showNotification(response['status'], response['message']);
                                       } else {
                                           showNotification('error', translate('request_not_completed'), translate('contact_support'));
                                           
                                           if ( response['status'] == 'success')
                                           {
                                               
                                               parent.find('.caption span').html(title);
                                           }
                                       }
                                   },
                                   error: function () {
                                       showNotification('error', translate('request_not_completed'), translate('contact_support'));
                                   }
                               });
                    }
            );
        });
    </script>
@endsection