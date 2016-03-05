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

                                <div class="row">

                                    {{--Products--}}
                                    @include('orders.products_list_partial')
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

    <div id="ajax-modal" class="modal fade" tabindex="-1" data-width="640">

    </div>
@endsection

@section('customJS')
    <script type="text/javascript">
        jQuery(document).ready(function () {
            var $modal = $('#ajax-modal');

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

            $('body').on('click', '#add_product', function (e) {
                e.preventDefault();
                e.stopPropagation();

                // create the backdrop and wait for next modal to be triggered
                $('body').modalmanager('loading');
                var target = $(this).attr('href');

                setTimeout(function(){
                    $modal.load(target, '', function(){
                        $modal.modal();
                        $("#products").select2();
                    });
                }, 1000);
            });

            $('body').on('click', '#select_product', function (e) {
                e.preventDefault();
                e.stopPropagation();

                var product = $('#products').val();

                if(!product || product.length == 0) {
                    return;
                }

                var
                    quantity = $('#products').find('option[value=' + product + ']').attr('data-quantity'),
                    price = $('#products').find('option[value="' + product + '"]').attr('data-price'),
                    original_price = $('#products').find('option[value="' + product + '"]').attr('data-original-price'),
                    discount = $('#products').find('option[value="' + product + '"]').attr('data-discount');

                $modal.modal('hide');

                // create the backdrop and wait for next modal to be triggered
                $('body').modalmanager('loading');
                var target = '/admin/orders/show/' + product + '/add_product_info';

                setTimeout(function(){
                    $modal.load(target, '', function(){
                        $modal.modal();
                    });
                }, 1000);
            });

            $('body').on('change', '#size', function () {
                var size = $(this).val(),
                    quantity = $(this).find('option:selected').attr('data-quantity');
                    $('#quantity').attr('max', quantity);

                console.log(quantity);
            });

        });
    </script>
@endsection