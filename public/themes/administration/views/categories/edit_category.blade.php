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
                                    <i class="fa fa-tasks"></i>
                                    <span class="caption-subject font-blue-madison bold uppercase">{{$pageTitle}}</span>
                                </div>
                                <ul class="nav nav-tabs">
                                    <li class="active">
                                        <a href="#main_info" data-toggle="tab">{{trans('categories.main_info')}}</a>
                                    </li>
                                    <li>
                                        <a href="#data" data-toggle="tab">{{trans('categories.data')}}</a>
                                    </li>
                                    <li>
                                        <a href="#seo" data-toggle="tab">SEO</a>
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
{{--                                                    <option value="2" @if(isset($category['level']) && $category['level'] == 2) selected @endif>{{trans('categories.level_2')}}</option>--}}
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

                                            <div class="col-xs-12 margin-top-20">
                                                <label for="size_group" class="control-label col-xs-12 default no-padding">
                                                    {{trans('categories.size_group')}}
                                                </label>
                                                <select id="size_group" name="size_group" class="form-control select2me input-lg no-padding"  multiple>
                                                    <option value="">{{trans('global.none')}}</option>
                                                    @if(isset($size_groups) && is_array($size_groups))
                                                        @foreach($size_groups as $key => $group)
                                                            <option value="{{$group}}" @if(!empty($group) && !empty($category['size_group']) && in_array($group, $category['size_group'])) selected @endif>{{$group}}</option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                            </div>
                                            <div class="clearfix"></div>

                                            <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 margin-top-20">
                                                <label for="input_position" class="control-label col-xs-12 default no-padding">
                                                    {{trans('categories.position')}}
                                                </label>

                                                <div id="position">
                                                    <div class="input-group" style="width:150px;">
                                                        <input type="text" name="position" id="input_position" class="spinner-input form-control" maxlength="2" readonly="" value="{{isset($category['position']) ? $category['position'] : ''}}">
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


                                    <!-- SEO TAB -->
                                    <div class="tab-pane" id="seo">
                                        <form action="#">

                                            <input type="hidden" name="_token" value="{{ csrf_token() }}">

                                            <div class="form-group form-md-line-input has-success form-md-floating-label">
                                                <div class="input-icon right">
                                                    <input name="friendly_url" id="friendly_url" type="text" class="form-control input-lg" value="{{isset($seo['friendly_url']) ? $seo['friendly_url'] : ''}}"/>

                                                    <label for="friendly_url">{{trans('categories.friendly_url')}}</label>
                                                    <span class="help-block"></span>
                                                    <i class="fa fa-font"></i>
                                                </div>
                                            </div>

                                            <div class="form-group form-md-line-input has-success form-md-floating-label">
                                                <div class="input-icon right">
                                                    <input name="page_title" id="page_title" type="text" class="form-control input-lg" value="{{isset($seo['page_title']) ? $seo['page_title'] : ''}}"/>

                                                    <label for="page_title">{{trans('categories.page_title')}}</label>
                                                    <span class="help-block"></span>
                                                    <i class="fa fa-font"></i>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="meta_description" class="control-label col-xs-12 default no-padding">
                                                    {{trans('categories.meta_description')}}
                                                </label>
                                                <div class="col-xs-12 no-padding">
                <textarea id="meta_description"
                          class="form-control"
                          rows="3"
                          placeholder="{{trans('categories.meta_description')}}"
                          style="margin-top: 0px; margin-bottom: 0px; height: 79px;">{!!isset($seo['meta_description']) ? $seo['meta_description'] : ''!!}</textarea>
                                                </div>
                                                <div class="clearfix"></div>
                                            </div>

                                            <div class="form-group">
                                                <label for="meta_keywords" class="control-label col-xs-12 default no-padding">
                                                    {{trans('categories.meta_keywords')}}
                                                </label>
                                                <div class="col-xs-12 no-padding">
                <textarea id="meta_keywords"
                          class="form-control"
                          rows="3"
                          placeholder="{{trans('categories.meta_keywords')}}"
                          style="margin-top: 0px; margin-bottom: 0px; height: 79px;">{!!isset($seo['meta_keywords']) ? $seo['meta_keywords'] : ''!!}</textarea>
                                                </div>
                                                <div class="clearfix"></div>
                                            </div>

                                            <div class="clearfix"></div>

                                            <div class="margin-top-10">
                                                <button class="btn green-haze save_category">
                                                    {{trans('global.save')}} </button>
                                                <a href="/admin/categories" class="btn default">
                                                    {{trans('global.cancel')}} </a>
                                            </div>

                                        </form>

                                    </div>
                                    <!-- END MAIN INFO TAB -->

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

            //SEO URL vars
            var
                    timer,
                    timeout,
                    $slug = $('#friendly_url'),
                    url_from_name = true,
                    current_slug = '{{$seo['friendly_url'] or ''}}',
                    url_invalid = true;

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
                levelLockParents(level);
            });
            levelLockParents('{{$category['level']}}');

            function levelLockParents(level) {
                if (level == '1' || level == '2') {
                    $('.parent-container').removeClass('hidden');

                    $('#parent option').each(function () {
                        var opt_level = $(this).data('level');

                        if (typeof opt_level != typeof undefined && opt_level != null && (opt_level == '0' || opt_level == '1')) {
                            if (opt_level != level - 1) {
                                $(this).attr('disabled', 'disabled');
                            } else {
                                $(this).removeAttr('disabled');
                            }
                        } else if(opt_level == '2') {
                            $(this).attr('disabled', 'disabled');
                        }
                    });
                } else {
                    $('.parent-container').addClass('hidden');
                }
            }

            $('.save_category').click( function(e) {
                e.preventDefault();

                var slug = $slug.val();

                //Check URL
                if (slug.length > 0) {
                    if ((current_slug.length > 0 && current_slug != slug) || (current_slug.length == 0)) {
                        if (url_invalid === true) {
                            showNotification('error', '{{trans('global.warning')}}', '{{trans('categories.url_exists')}}');

                            return;
                        }
                    }
                } else {
                    showNotification('error', '{{trans('global.warning')}}', '{{trans('categories.url_required')}}');

                    return;
                }


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
                               'size_group': $('#size_group').val(),
                               'position': $('#position').spinner('value'),
                               'visible': visible,
                               'active': active,
                               'friendly_url': $slug.val(),
                               'page_title': $('#page_title').val(),
                               'meta_description': $('#meta_description').val(),
                               'meta_keywords': $('#meta_keywords').val(),
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



            //Seo URL

            if ($slug.val().length > 0) {
                url_from_name = false;
            } else {
                url_from_name = true;
            }

            function checkURL(url) {
                clearTimeout(timer);
                $.ajax({
                           type: 'get',
                           url: '/admin/categories/show/check_url/' + url,
                           headers: {
                               'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                           },
                           success: function (response) {
                               if (typeof response == typeof {} && response['status'] && response['message']) {
                                   showNotification(response['status'], response['title'], response['message']);
                                   url_invalid = true;
                               } else {
                                   url_invalid = false;
                               }
                           },
                           error: function () {
                               showNotification('error', translate('request_not_completed'), translate('contact_support'));
                           }

                       });
            }

            function slugify(string) {
                if (string) {
                    var slug = $.slugify(string);
                    if ($slug.length > 0) {
                        $slug.addClass('edited');
                        $slug.val(slug);
                        checkURL(slug);
                    }

                    return slug;
                } else {
                    return '';
                }
            }

            if ($('#title').length > 0) {
                $('#title').on('keyup', function () {
                    if (url_from_name === true) {
                        clearTimeout(timeout);
                        var title = $(this).val();

                        timeout = setTimeout(function () {
                            slugify(title);
                        }, 500);
                    }
                });
            }

            if ($slug.length > 0) {
                $slug.on('keyup', function () {
                    clearTimeout(timer);
                    var url = $(this).val();

                    if (typeof url === typeof undefined || url === null || url.length == 0 || url == '') {
                        url_from_name = true;
                        $slug.removeClass('edited');
                    }

                    if (url) {
                        if ((current_slug.length > 0 && current_slug != url) || current_slug.length == 0) {
                            timer = setTimeout(function () {
                                url = slugify(url);
                                checkURL(url);
                                url_from_name = false;
                            }, 500);
                        }
                    }
                });
            }

        });
    </script>
@endsection