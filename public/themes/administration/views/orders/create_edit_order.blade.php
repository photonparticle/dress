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
													<div class="portlet red-sunglo box">
														<div class="portlet-title">
															<div class="caption">
																<i class="fa fa-shopping-cart"></i>{{trans('orders.order_details')}}
															</div>
														</div>
														<div class="portlet-body">
                                                            <div class="locked-form-details" >
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
                                                            
                                                            <div class="edit-form-details ">
                                                                
                                                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 margin-top-20 no-padding">
                                                                    <label for="created_at" class="control-label col-xs-12 default no-padding">
                                                                        {{trans('orders.created_at')}}
                                                                    </label>

                                                                    <div class="input-group date created_at">
                                                                        <input type="text" id="created_at" size="16" readonly class="form-control" value="{{isset($product['created_at']) ? $product['created_at'] : ''}}">
                                                                        <span class="input-group-btn">
                                                                            <button class="btn default date-set" type="button"><i class="fa fa-calendar"></i></button>
                                                                        </span>
                                                                    </div>
                                                                </div>
                                                                
                                                                <div class="clearfix"></div>
                                                                
                                                                    <!-- START -->
                                                                
                                                                    {{--STATUS--}}
                                                                
                                                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 no-padding">
                                                                    <label for="type" class="control-label col-xs-12 default no-padding">
                                                                        {{trans('orders.order_status')}}
                                                                    </label>
                                                                    <select id="type" name="type" class="form-control input-lg">
                                                                        <option value="">{{trans('orders.ch_status')}}</option>
                                                                        <option value="requested" @if(!empty($orders['status']) && $order['status'] == 'requested') selected="selected" @endif>{{trans('orders.requested')}}</option>
                                                                        <option value="sended" @if(!empty($order['status']) && $order['status'] == 'sended') selected="selected" @endif>{{trans('orders.sended')}}</option>
                                                                        <option value="completed" @if(!empty($order['status']) && $order['status'] == 'completed') selected="selected" @endif>{{trans('orders.completed')}}</option>
                                                                        <option value="canceled" @if(!empty($order['status']) && $order['status'] == 'canceled') selected="selected" @endif>{{trans('orders.canceled')}}</option>
                                                                    </select>
                                                                </div>
                                                                                                                                
                                                                <div class="clearfix"></div>
                                                                
                                                                    <!-- END -->
                                                                
                                                                    <!-- START -->
                                                                
                                                                    {{--DELIVERY_TYPE--}}
                                                                
                                                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 no-padding">
                                                                    <label for="type" class="control-label col-xs-12 default no-padding">
                                                                        {{trans('orders.delivery_type')}}
                                                                    </label>
                                                                    <select id="type" name="type" class="form-control input-lg">
                                                                        <option value="">{{trans('orders.ch_delivery')}}</option>
                                                                        <option value="to_office" @if(!empty($orders['status']) && $order['status'] == 'requested') selected="selected" @endif>{{trans('orders.to_office')}}</option>
                                                                        <option value="to_address" @if(!empty($order['status']) && $order['status'] == 'sended') selected="selected" @endif>{{trans('orders.to_address')}}</option>
                                                                    </select>
                                                                </div>
                                                                                                                                
                                                                <div class="clearfix"></div>
                                                                
                                                                    <!-- END -->
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
                                                            <div class="locked-form-details">
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
                                                            <div class="edit-form-details ">
                                                                
                                                                

                                                                <div class="form-group form-md-line-input has-info form-md-floating-label no-margin margin-top-10">
                                                                    
                                                                    <div class="input-icon right">
                                                                        <input name="title" id="title" type="text" class="form-control input-lg"  value="{{isset($product['title']) ? $product['title'] : ''}}"/>

                                                                        <label for="title">{{trans('orders.name')}}</label>
                                                                        <span class="help-block"></span>
                                                                        <i class="fa fa-user"></i>
                                                                    </div>
                                                                </div>
                                                                

                                                                <div class="form-group form-md-line-input has-info form-md-floating-label no-margin margin-top-10">
                                                                    <div class="input-icon right">
                                                                        <input name="title" id="title" type="text" class="form-control input-lg"  value="{{isset($product['title']) ? $product['title'] : ''}}"/>

                                                                        <label for="title">{{trans('orders.lastname')}}</label>
                                                                        <span class="help-block"></span>
                                                                        <i class="fa fa-user-plus"></i>
                                                                    </div>
                                                                </div>
                                                                

                                                                <div class="form-group form-md-line-input has-info form-md-floating-label no-margin margin-top-10">
                                                                    <div class="input-icon right">
                                                                        <input name="title" id="title" type="text" class="form-control input-lg"  value="{{isset($product['title']) ? $product['title'] : ''}}"/>

                                                                        <label for="title">{{trans('orders.email')}}</label>
                                                                        <span class="help-block"></span>
                                                                        <i class="fa fa-at"></i>
                                                                    </div>
                                                                </div>
                                                                

                                                                <div class="form-group form-md-line-input has-info form-md-floating-label no-margin margin-top-10">
                                                                    <div class="input-icon right">
                                                                        <input name="title" id="title" type="text" class="form-control input-lg"  value="{{isset($product['title']) ? $product['title'] : ''}}"/>

                                                                        <label for="title">{{trans('orders.phone')}}</label>
                                                                        <span class="help-block"></span>
                                                                        <i class="fa fa-phone"></i>
                                                                    </div>
                                                                </div>
                                                            </div>
														</div>
													</div>
												</div>
											</div>
											<div class="row">
												<div class="col-md-6 col-sm-12">
													<div class="portlet box green">
														<div class="portlet-title">
															<div class="caption">
																<i class="fa fa-shopping-cart"></i>{{trans('orders.shipping_addr')}}
															</div>
														</div>
														<div class="portlet-body">
                                                            <div class="locked-form-details">
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
                                                            
                                                            <div class="edit-form-details ">
                                                                    
                                                                <div class="form-group form-md-line-input has-warnig form-md-floating-label">
                                                                    <div class="input-icon right ">
                                                                        <input name="title" id="title" type="text" class="form-control input-lg"  value="{{isset($product['title']) ? $product['title'] : ''}}"/>

                                                                        <label for="title">{{trans('orders.address')}}</label>
                                                                        <span class="help-block"></span>
                                                                        <i class="fa fa-building"></i>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group form-md-line-input has-warnig form-md-floating-label">
                                                                    <div class="input-icon right">
                                                                        <input name="title" id="title" type="text" class="form-control input-lg"  value="{{isset($product['title']) ? $product['title'] : ''}}"/>

                                                                        <label for="title">{{trans('orders.city')}}</label>
                                                                        <span class="help-block"></span>
                                                                        <i class="fa fa-building-o"></i>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group form-md-line-input has-warnig form-md-floating-label">
                                                                    <div class="input-icon right">
                                                                        <input name="title" id="title" type="text" class="form-control input-lg"  value="{{isset($product['title']) ? $product['title'] : ''}}"/>

                                                                        <label for="title">{{trans('orders.post_code')}}</label>
                                                                        <span class="help-block"></span>
                                                                        <i class="fa fa-envelope-o"></i>
                                                                    </div>
                                                                </div>
                                                            </div>
														</div>
													</div>
												</div>
                                                
												<div class="col-md-6 col-sm-12">
													<div class="portlet yellow-crusta box">
														<div class="portlet-title">
															<div class="caption">
																<i class="fa fa-shopping-cart"></i>{{trans('orders.comments')}}
															</div>
														</div>
														<div class="portlet-body">
                                                            <div class="locked-form-details">
                                                                <div class="row static-info">
                                                                    <div class="col-md-12 value">
                                                                        <!--
                                                                        #################<br>
                                                                        
                                                                        COMMENT TO ORDER<br>
                                                                        
                                                                        #################<br>
                                                                        -->
                                                                        <div class="form-group form-md-line-input has-warning form-md-floating-label padding-60">
                                                                            <textarea class="form-control" rows="3"></textarea>
                                                                            <label for="form_control_1">{{trans('orders.msgtoorder')}}</label>
                                                                            
                                                                        </div>

                                                                        
                                                                    </div>

                                                                </div>
                                                            </div>
                                                            
                                                            <div class="edit-form-details ">
                                                                  
                                                                <div class="clearfix"></div>
                                                                
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
        
        
            // Init DateTime_Picker
            $(".discount_start, .discount_end, .created_at").datetimepicker({
                                                                                autoclose: true,
                                                                                isRTL: Metronic.isRTL(),
                                                                                format: "yyyy.mm.dd hh:ii",
                                                                                pickerPosition: (Metronic.isRTL() ? "bottom-right" : "bottom-left")
                                                                            });
            //Init WYSIWYG
            $('#description').summernote({height: 300});
            $('#dimensions_table').summernote({height: 300});
        
        
        });
    </script>
@endsection