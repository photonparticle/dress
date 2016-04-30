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
                                <div class="caption caption-lg">
                                    <i class="fa fa-list-alt"></i>
                                    <span class="caption-subject font-blue-madison bold uppercase">{{$pageTitle}}</span>
                                </div>
                                <div class="actions">
                                    <a href="javascript:;" class="btn btn-info" id="filter" title="{{trans('reports.filter')}}">
                                        <i class="fa fa-filter"></i>
                                        {{trans('reports.filter')}}
                                    </a>
                                </div>
                            </div>
                            <div class="portlet-body">

                                <div class="col-xs-12">
                                    <div class="form">
                                        <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4" style="padding-left: 0">
                                            <div class="col-xs-12 no-padding margin-top-10">
                                                <label for="input_date_start" class="control-label col-xs-12 default no-padding">
                                                    {{trans('reports.date_start')}}
                                                </label>

                                                <div class="input-group date" id="date_start">
                                                    <input type="text" id="input_date_start" size="16" readonly class="form-control" value="{{$current_time or ''}}">
                                                    <span class="input-group-btn">
                                                        <button class="btn default date-set" type="button"><i class="fa fa-calendar"></i></button>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">

                                            <div class="col-xs-12 no-padding margin-top-10">
                                                <label for="input_date_end" class="control-label col-xs-12 default no-padding">
                                                    {{trans('reports.date_end')}}
                                                </label>

                                                <div class="input-group date" id="date_end">
                                                    <input type="text" id="input_date_end" size="16" readonly class="form-control" value="{{$current_time or ''}}">
                                                    <span class="input-group-btn">
                                                        <button class="btn default date-set" type="button"><i class="fa fa-calendar"></i></button>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4" style="padding-right: 0">
                                            <div class="col-xs-6 margin-top-10">
                                                <label for="type" class="control-label col-xs-12 default no-padding">
                                                    {{trans('reports.report')}}
                                                </label>

                                                <select id="type" name="type" class="form-control input-md">
                                                    <option value="orders">{{trans('reports.orders')}}</option>
                                                    <option value="users">{{trans('reports.users')}}</option>
                                                </select>
                                            </div>
                                            <div class="col-xs-6 margin-top-10">
                                                <label for="group_by" class="control-label col-xs-12 default no-padding">
                                                    {{trans('reports.group_by')}}
                                                </label>

                                                <select id="group_by" name="group_by" class="form-control input-md">
                                                    <option value="">{{trans('reports.choose')}}</option>
                                                    <option value="days">{{trans('reports.days')}}</option>
                                                    <option value="weeks">{{trans('reports.weeks')}}</option>
                                                    <option value="months">{{trans('reports.months')}}</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="clearfix"></div>

                                <div class="col-xs-12 margin-top-20">
                                    <table id="table-holder" class="table table-striped table-bordered table-hover no-footer">

                                    </table>
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

            var results = $('#table-holder');
            var results_table;

            function results_load() {
                if (results.find('tbody').length > 0) {

                    results_table = results.DataTable({
                                                          responsive: true,
                                                          order: [[1, 'desc']],
                                                          stateSave: false,
                                                          adaptiveHeight: true,
                                                          language: translateData['dataTable']
                                                      });
                }
            }

            results_load();

            var date = new Date(),
                    year = date.getFullYear(),
                    month = date.getMonth() + 1,
                    day = date.getDate();

            if (month < 10) {
                month = '0' + month;
            }
            if (day < 10) {
                day = '0' + day;
            }

            // Init DateTime_Picker
            $("#date_start, #date_end").datepicker({
                                                       autoclose: true,
                                                       isRTL: Metronic.isRTL(),
                                                       format: "yyyy-mm-dd",
//                                                       startDate: '2016.03.01',
                                                       endDate: year + '.' + month + '.' + day,
                                                       pickerPosition: (Metronic.isRTL() ? "bottom-right" : "bottom-left"),
                                                   });

            //Settings save
            $('body').on('click', '#filter', function () {
                var
                        url = '/admin/reports/store',
                        date_start = $('#input_date_start').val(),
                        date_end = $('#input_date_end').val(),
                        group_by = $('#group_by').val(),
                        type = $('#type').val();

                if (
                        typeof date_start === typeof undefined &&
                        typeof date_end === typeof undefined
                ) {
                    showNotification('warning', '{{trans('reports.invalid_dates')}}');
                    return;
                }

                if (
                        typeof group_by === typeof undefined ||
                        group_by == ''
                ) {
                    showNotification('warning', '{{trans('reports.select_group_by')}}');
                    return;
                }

                $.ajax({
                           type: 'post',
                           url: url,
                           data: {
                               'date_start': date_start,
                               'date_end': date_end,
                               'group_by': group_by,
                               'type': type
                           },
                           success: function (response) {
                               if (response.length > 0) {
                                   if (response == 'invalid_dates') {
                                       showNotification('warning', '{{trans('reports.invalid_dates')}}');
                                       return;
                                   } else if (response == 'select_group_by') {
                                       showNotification('warning', '{{trans('reports.select_group_by')}}');
                                       return;
                                   } else {

                                       //RENDER TABLE
                                       if (typeof results_table !== typeof undefined) {
                                           results_table.destroy();
                                       }
                                       results.html(response);
                                       results_load();
                                   }
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