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
                                    <a href="/admin/orders" class="btn btn-info" title="{{trans('orders.orders_list')}}">
                                        <i class="fa fa-arrow-left"></i>
                                        {{trans('orders.orders_list')}}
                                    </a>

                                    @if(!empty($method) && $method == 'unlocked')
                                        <a href="javascript:;" class="btn green-haze" id="save_order" title="{{trans('global.save')}}">
                                            <i class="fa fa-save"></i>
                                            {{trans('global.save')}}
                                        </a>
                                    @else
                                        <a href="/admin/orders/edit/{{$order['id'] or ''}}" class="btn btn-success" title="{{trans('global.edit')}}">
                                            <i class="fa fa-edit"></i>
                                            {{trans('global.edit')}}
                                        </a>
                                    @endif
                                </div>
                            </div>
                            <div class="portlet-body">

                                <div class="row">

                                    {{--Details partial--}}
                                    @include('orders.details_partial')

                                    {{--Customer info partial--}}
                                    @include('orders.customer_info_partial')

                                </div>

                                <div class="row">

                                    {{--Details partial--}}
                                    @include('orders.delivery_address_partial')

                                    {{--Customer info partial--}}
                                    @include('orders.comments_partial')

                                </div>

                                {{--Products--}}
                                @if(!empty($order['id']))
                                    <div class="row">

                                        @if(!empty($method) && $method == 'unlocked')
                                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                                <div class="note note-success note-bordered">
                                                    <h4>
                                                        {{trans('orders.products_auto_save_tip')}}
                                                    </h4>
                                                    <h4>
                                                        {{trans('orders.products_auto_save_tip_2')}}
                                                    </h4>
                                                </div>
                                            </div>
                                        @endif
                                        <div id="products_table"></div>
                                    </div>

                                    <div class="row totals_holder">
                                        <div class="col-md-6">
                                        </div>
                                        <div class="col-md-6">
                                            <div class="well">
                                                <div class="row static-info align-reverse subtotal_holder">
                                                    <div class="col-md-8 name">
                                                        {{trans('orders.sub_total')}}:
                                                    </div>
                                                    <div class="col-md-3 value"></div>
                                                </div>
                                                <div class="row static-info align-reverse shipping_holder">
                                                    <div class="col-md-8 name">
                                                        {{trans('orders.shipping')}}:
                                                    </div>
                                                    <div class="col-md-3 value">
                                                        5
                                                    </div>
                                                </div>
                                                <div class="row static-info align-reverse total_holder">
                                                    <div class="col-md-8 name">
                                                        {{trans('orders.grand_total')}}:
                                                    </div>
                                                    <div class="col-md-3 value"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                            </div>
                            @endif


                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END PROFILE CONTENT -->
    </div>

    <div id="ajax-modal" class="modal fade" tabindex="-1" data-width="640">

    </div>
@endsection

@section('customJS')
    <script type="text/javascript">
        jQuery(document).ready(function () {

                    @if($method == 'unlocked')
            var $modal = $('#ajax-modal');

            // general settings
            $.fn.modal.defaults.spinner = $.fn.modalmanager.defaults.spinner =
                    '<div class="loading-spinner" style="width: 200px; margin-left: -100px;">' +
                    '<div class="progress progress-striped active">' +
                    '<div class="progress-bar" style="width: 100%;"></div>' +
                    '</div>' +
                    '</div>';

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

            $('body').on('click', '#save_order', function (e) {
                e.preventDefault();
                e.stopPropagation();

                        @if(empty($order['id']))
                var url = '/admin/orders/store';
                        @else
                var url = '/admin/orders/store/{{$order['id']}}';
                @endif

                $.ajax({
                                           type: 'post',
                                           url: url,
                                           data: {
                                               'created_at': $('#created_at').val(),
                                               'status': $('#status').val(),
                                               'delivery_type': $('#delivery_type').val(),
                                               'name': $('#name').val(),
                                               'last_name': $('#last_name').val(),
                                               'email': $('#email').val(),
                                               'phone': $('#phone').val(),
                                               'address': $('#address').val(),
                                               'city': $('#city').val(),
                                               'state': $('#state').val(),
                                               'post_code': $('#post_code').val(),
                                               'comment': $('#comment').val()
                                           },
                                           success: function (response) {
                                               if (typeof response == typeof {} && response['status'] && response['message']) {
                                                   showNotification(response['status'], response['message']);

                                                   if (response['status'] == 'success' && response['id']) {
                                                       setTimeout(function () {
                                                           window.location.href = "/admin/orders/edit/" + response['id'];
                                                       }, 2000);
                                                   }
                                               } else {
                                                   showNotification('error', translate('request_not_completed'), translate('contact_support'));
                                               }
                                           },
                                           error: function () {
                                               showNotification('error', translate('request_not_completed'), translate('contact_support'));
                                           }
                                       });
            });
            @endif

            @if(!empty($order['id']))

            $('body').on('click', '.remove_product', function () {
                var product_id = $(this).attr('data-id');
                var record_id = $(this).attr('data-record');
                var product_title = $(this).attr('data-title');
                var parent = $(this).closest('tr');

                if (
                        typeof product_id !== typeof undefined && typeof product_title !== typeof undefined &&
                        product_id.length > 0 && product_title.length > 0
                ) {
                    bootbox.dialog({
                                       message: "<h4>{{trans('orders.product_remove')}}</h4> <strong>ID:</strong> " + product_id + " <br /><strong>{{trans('orders.product_title')}}:</strong> " + product_title,
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
                                                                  'method': 'product',
                                                                  'record_id': record_id

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

                    $('.bootbox.modal').addClass('bootbox-remove-bs');
                }
            });

            $('body').on('click', '#add_product', function (e) {
                e.preventDefault();
                e.stopPropagation();

                // create the backdrop and wait for next modal to be triggered
                $('body').modalmanager('loading');
                var target = $(this).attr('href');

                setTimeout(function () {
                    $modal.load(target, '', function () {
                        $modal.modal();
                        $("#products").select2();
                    });
                }, 1000);
            });

            $('body').on('click', '#select_product', function (e) {
                e.preventDefault();
                e.stopPropagation();

                var product = $('#products').val();

                if (!product || product.length == 0) {
                    return;
                }

                $modal.modal('hide');

                // create the backdrop and wait for next modal to be triggered
                $('body').modalmanager('loading');
                var target = '/admin/orders/show/' + product + '/add_product_info';

                setTimeout(function () {
                    $modal.load(target, '', function () {
                        $modal.modal();
                    });
                }, 1000);
            });

            $('body').on('change', '#size', function () {
                var size = $(this).val(),
                        quantity = $(this).find('option:selected').attr('data-quantity');

                $('#quantity').attr('max', quantity).val(1);
            });

            $('body').on('click', '#save_product', function (e) {
                e.preventDefault();
                e.stopPropagation();

                var
                        product_id = $(this).attr('data-id'),
                        order_id = '{{$order['id'] or ''}}',
                        selected_size = $('#size').find('option:selected'),
                        size = selected_size.attr('data-size'),
                        quantity = $('#quantity').val(),
                        price = selected_size.attr('data-price'),
                        original_price = selected_size.attr('data-original_price'),
                        discount = selected_size.attr('data-discount');

                $.ajax({
                           type: 'post',
                           url: '/admin/orders/store/' + order_id + '/product',
                           data: {
                               'product_id': product_id,
                               'order_id': order_id,
                               'size': size,
                               'quantity': quantity,
                               'price': price,
                               'original_price': original_price,
                               'discount': discount
                           },
                           success: function (response) {
                               if (typeof response == typeof {} && response['status'] && response['message']) {
                                   showNotification(response['status'], response['message']);

                                   if (response['status'] == 'success') {
                                       $modal.modal('hide');
                                       productsTable();
                                   }
                               } else {
                                   showNotification('error', translate('request_not_completed'), translate('contact_support'));
                               }
                           },
                           error: function () {
                               showNotification('error', translate('request_not_completed'), translate('contact_support'));
                           }
                       });
            });
            @endif

            @if(!empty($order))
            function productsTable() {
                $.ajax({
                           type: 'get',
                           url: '/admin/orders/show/{{$order['id']}}/products_table/{{$method or ''}}',
                           success: function (response) {
                               if (response) {
                                   $('#products_table').html(response);

                                   var sub_total = 0;

                                   if ($('.total_val').length > 0) {
                                       //Show sub_totals
                                       $('.sub_totals_holder').removeClass('hidden');

                                       $('.total_val').each(function () {
                                           sub_total = sub_total + parseFloat($(this).html());
                                       });

                                       $('.subtotal_holder .value').html(sub_total + ' {{trans('orders.currency')}}');

                                       var total = parseFloat($('.shipping_holder .value').html()) + sub_total;

                                       $('.total_holder .value').html(total + ' {{trans('orders.currency')}}');

                                       if ($('.summary-total .value').length > 0) {
                                           $('.summary-total .value').html(total + ' {{trans('orders.currency')}}');
                                       }
                                   } else {
                                       //Hide totals
                                       $('.totals_holder').addClass('hidden');
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

            productsTable();
            @endif

        });

        $.ajaxPrefilter(function (options) {
            if (!options.beforeSend) {
                options.beforeSend = function (xhr) {
                    xhr.setRequestHeader('X-CSRF-Token', $('meta[name="csrf-token"]').attr('content'));
                }
            }
        });
    </script>
@endsection