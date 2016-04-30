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
                                    <i class="fa fa-clock-o"></i>
                                    <span class="caption-subject font-blue-madison bold uppercase">{{$pageTitle}}</span>
                                </div>
                                <div class="actions">
                                    <button id="save" type="submit" class="btn btn-success"><i class="fa fa-save"></i> {{trans('upcoming_product.save')}}</button>
                                </div>
                            </div>
                            <div class="portlet-body">

                                <div class="form-group form-md-line-input has-success form-md-floating-label">
                                    <div class="input-icon right">
                                        <input name="title" id="title" type="text" class="form-control input-lg" value="{{isset($title) ? $title : ''}}"/>

                                        <label for="title">{{trans('products.title')}}</label>
                                        <span class="help-block"></span>
                                        <i class="fa fa-font"></i>
                                    </div>
                                </div>

                                <div class="col-xs-12 no-padding">
                                    <label for="product_id" class="control-label col-xs-12 default no-padding">
                                        {{trans('upcoming_product.product')}}
                                    </label>
                                    <select id="product_id"
                                            name="product_id"
                                            class="form-control select2me input-lg no-padding"
                                            data-placeholder="{{trans('upcoming_product.select_product')}}">
                                        <option value="">{{trans('upcoming_product.select_product')}}</option>
                                        @if(isset($products) && is_array($products))
                                            @foreach($products as $key => $product)
                                                <option value="{{$product['id'] or ''}}" @if(isset($product_id) && $product_id == $product['id']) selected="selected" @endif>{{$product['id'] or ''}} - {{$product['title']}}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                                <div class="clearfix"></div>

                                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 margin-top-20 no-padding">
                                    <label for="date" class="control-label col-xs-12 default no-padding">
                                        {{trans('upcoming_product.date')}}
                                    </label>

                                    <div class="input-group date">
                                        <input type="text" id="date" size="16" readonly class="form-control" value="{{isset($date) ? $date : ''}}">

                                        <span class="input-group-btn">
                                            <button class="btn default date-set" type="button"><i class="fa fa-calendar"></i></button>
                                        </span>
                                    </div>
                                </div>

                                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 margin-top-20">
                                    <label for="active" class="control-label col-xs-12 default no-padding">
                                        {{trans('upcoming_product.active')}}
                                    </label>
                                    <div class="col-xs-12 no-padding">
                                        <input id="active" name="active" type="checkbox" class="make-switch" data-on-text="&nbsp;{{trans('upcoming_product.activated')}}&nbsp;" data-off-text="&nbsp;{{trans('upcoming_product.not_activated')}}&nbsp;" @if(isset($active) && $active == '1') checked @endif>
                                    </div>
                                </div>

                                <div class="clearfix"></div>

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
            $(".date").datetimepicker({
                                          autoclose: true,
                                          isRTL: Metronic.isRTL(),
                                          format: "yyyy.mm.dd hh:ii",
                                          pickerPosition: (Metronic.isRTL() ? "bottom-right" : "bottom-left")
                                      });

            $('#save').on('click', function (e) {
                e.preventDefault();
                e.stopPropagation();

                if ($('#active').is(':checked')) {
                    var active = 1;
                } else {
                    var active = 0;
                }

                $.ajax({
                           type: 'post',
                           url: '/admin/module/upcoming-product/store',
                           data: {
                               'title': $('#title').val(),
                               'product_id': $('#product_id').val(),
                               'date': $('#date').val(),
                               'active': active
                           },
                           success: function (response) {
                               if (typeof response == typeof {} && response['status'] && response['message']) {
                                   showNotification(response['status'], response['message']);
                               } else {
                                   showNotification('error', translate('request_not_completed'), translate('contact_support'));
                               }
                           },
                           error: function () {
                               showNotification('error', translate('request_not_completed'), translate('contact_support'));
                           }

                       });
            });
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