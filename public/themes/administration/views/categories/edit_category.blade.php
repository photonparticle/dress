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
                                    <i class="fa fa-user"></i>
                                    <span class="caption-subject font-blue-madison bold uppercase">{{$pageTitle}}</span>
                                </div>
                                <ul class="nav nav-tabs">
                                    <li class="active">
                                        <a href="#main_info" data-toggle="tab">{{trans('categories.main_info')}}</a>
                                    </li>
                                    <li>
                                        <a href="#data" data-toggle="tab">{{trans('categories.data')}}</a>
                                    </li>
                                </ul>
                            </div>
                            <div class="portlet-body">
                                <div class="tab-content">
                                    <!-- MAIN INFO TAB -->
                                    <div class="tab-pane active" id="main_info">
                                        <form action="#">

                                            <input type="hidden" name="_token" value="{{ csrf_token() }}">

                                            <div class="form-group form-md-line-input has-success form-md-floating-label">
                                                <div class="input-icon right">
                                                    <input name="title" id="title" type="text" class="form-control input-lg" value="{{isset($category['title']) ? $category['title'] : ''}}" />

                                                    <label for="title">{{trans('categories.title')}}</label>
                                                    <span class="help-block"></span>
                                                    <i class="fa fa-font"></i>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="description" class="control-label col-xs-12 default no-padding">
                                                    {{trans('categories.description')}}
                                                </label>
                                                <div class="col-xs-12 no-padding">
                                                    <div id="description">
                                                        {!!isset($category['description']) ? $category['description'] : ''!!}
                                                    </div>
                                                </div>
                                                <div class="clearfix"></div>
                                            </div>

                                            <div class="margin-top-10">
                                                <button class="btn green-haze save_category">
                                                    {{trans('global.save')}} </button>
                                                <a href="/admin/categories" class="btn default">
                                                    {{trans('global.cancel')}} </a>
                                            </div>

                                        </form>

                                    </div>
                                    <!-- END MAIN INFO TAB -->
                                    <!-- DATA TAB -->
                                    <div class="tab-pane" id="data">
                                        <form action="#">

                                            <div class="col-xs-12 margin-top-20">
                                                <label for="level" class="control-label col-xs-12 default no-padding">
                                                    {{trans('categories.level')}}
                                                </label>
                                                <select id="level" name="level" class="form-control select2me input-lg no-padding">
                                                    <option value="0">{{trans('categories.level_0')}}</option>
                                                    <option value="1" @if(isset($category['level']) && $category['level'] == 1) selected @endif>{{trans('categories.level_1')}}</option>
                                                    <option value="2" @if(isset($category['level']) && $category['level'] == 2) selected @endif>{{trans('categories.level_2')}}</option>
                                                </select>
                                            </div>
                                            <div class="clearfix"></div>

                                            <div class="col-xs-12 margin-top-20 parent-container @if(isset($category['level']) && $category['level'] == '0') hidden @endif">
                                                <label for="parent" class="control-label col-xs-12 default no-padding">
                                                    {{trans('categories.parent_category')}}
                                                </label>
                                                <select id="parent" name="parent" class="form-control select2me input-lg no-padding">
                                                    <option value="" selected>{{trans('global.none')}}</option>
                                                    @if(isset($categories) && is_array($categories))
                                                        @foreach($categories as $key => $cat)
                                                            <option value="{{$cat['id']}}" data-level="{{$cat['level']}}" @if(isset($category['parent_id']) && $category['parent_id'] == $cat['id']) selected @endif>{{$cat['title']}}</option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                            </div>
                                            <div class="clearfix"></div>

                                            <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 margin-top-20">
                                                <label for="position" class="control-label col-xs-12 default no-padding">
                                                    {{trans('categories.position')}}
                                                </label>

                                                <div id="position">
                                                    <div class="input-group" style="width:150px;">
                                                        <input type="text" name="position" class="spinner-input form-control" maxlength="2" readonly="" value="{{isset($category['position']) ? $category['position'] : ''}}">
                                                        <div class="spinner-buttons input-group-btn">
                                                            <button type="button" class="btn spinner-up default">
                                                                <i class="fa fa-angle-up"></i>
                                                            </button>
                                                            <button type="button" class="btn spinner-down default">
                                                                <i class="fa fa-angle-down"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 margin-top-20">
                                                <label for="visible" class="control-label col-xs-12 default no-padding">
                                                    {{trans('categories.visibility')}}
                                                </label>
                                                <div class="col-xs-12 no-padding">
                                                    <input id="visible" name="visible" type="checkbox" class="make-switch" data-on-text="&nbsp;{{trans('categories.visible')}}&nbsp;" data-off-text="&nbsp;{{trans('categories.invisible')}}&nbsp;" @if(isset($category['menu_visibility']) && $category['menu_visibility'] == '1') checked @endif>
                                                </div>
                                            </div>

                                            <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 margin-top-20">
                                                <label for="active" class="control-label col-xs-12 default no-padding">
                                                    {{trans('categories.active')}}
                                                </label>
                                                <div class="col-xs-12 no-padding">
                                                    <input id="active" name="active" type="checkbox" class="make-switch" data-on-text="&nbsp;{{trans('categories.activated')}}&nbsp;" data-off-text="&nbsp;{{trans('categories.not_activated')}}&nbsp;" @if(isset($category['active']) && $category['active'] == '1') checked @endif>
                                                </div>
                                            </div>

                                            <div class="clearfix"></div>

                                            <div class="margin-top-20">
                                                <button class="btn green-haze save_category">
                                                    {{trans('global.save')}} </button>
                                                <a href="/admin/categories" class="btn default">
                                                    {{trans('global.cancel')}} </a>
                                            </div>
                                        </form>
                                    </div>
                                    <!-- END DATA TAB -->

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


            //Init WYSIWYG
            $('#description').summernote({height: 300});

            //Init spinner
            $('#position').spinner({value:0, min: 0, max: 100});

            //Switcher
            $('#active').on('switch-change', function () {
                $('#active').bootstrapSwitch('toggleRadioStateAllowUncheck');
            });
            $('#visible').on('switch-change', function () {
                $('#visible').bootstrapSwitch('toggleRadioStateAllowUncheck');
            });

            //Change category level event
            $('body').on('change', '#level', function () {
                var level = $(this).val();

                if(level == '1' || level == '2') {
                    $('.parent-container').removeClass('hidden');

                    $('#parent').find('option').each( function () {
                        var opt_level = $(this).data('level');

                        if(typeof opt_level != typeof undefined && opt_level != null) {
                            if(opt_level == level - 1) {
                                console.log('Disabled level: ' + opt_level);
                                $(this).removeAttr('disabled');
                            } else {
                                $(this).attr('disabled', 'disabled');
                            }
                        }
                    });
                } else {
                    $('.parent-container').addClass('hidden');
                }
            });

            $('.save_category').click( function(e) {
                e.preventDefault();

                if($('#visible').is(':checked')) {
                    var visible = 1;
                } else {
                    var visible = 0;
                }
                if($('#active').is(':checked')) {
                    var active = 1;
                } else {
                    var active = 0;
                }

                $.ajax({
                           type: 'post',
                           url: '/admin/categories/update/{{$category['id']}}',
                           data: {
                               'title': $('#title').val(),
                               'description': $('#description').code(),
                               'level': $('#level').val(),
                               'parent': $('#parent').val(),
                               'position': $('#position').val(),
                               'visible': visible,
                               'active': active,
                           },
                           headers: {
                               'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                           },
                           success: function (response) {
                               if(typeof response == typeof {} && response['status'] && response['message']) {
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
    </script>
@endsection