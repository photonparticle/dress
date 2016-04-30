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
                                <div class="caption caption-lg col-xs-12 col-sm-12 col-md-4 col-lg-8">
                                    <i class="fa fa-file-text-o"></i>
                                    <span class="caption-subject font-blue-madison bold uppercase">{{$pageTitle}}</span>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-8 col-lg-4 text-right margin-top-5 no-padding">
                                    <button class="btn green-haze save_page">
                                        {{trans('global.save')}} </button>
                                    <a href="/admin/pages" class="btn default">
                                        {{trans('global.cancel')}} </a>

                                </div>
                                <div class="clearfix"></div>
                                <ul class="nav nav-tabs pull-left">
                                    <li class="active pull-left">
                                        <a href="#main_info" data-toggle="tab">{{trans('pages.main_info')}}</a>
                                    </li>
                                    <li>
                                        <a href="#seo_tab" data-toggle="tab">SEO</a>
                                    </li>
                                </ul>
                            </div>
                            <div class="portlet-body">
                                <div class="tab-content">

                                    {{--Main info tab--}}
                                    @include('pages_partials.main_info_tab')

                                    {{--SEO tab--}}
                                    @include('pages_partials.seo_tab')

                                </div>

                                <div class="clearfix"></div>

                                <div class="col-xs-12 text-right">
                                    <button class="btn green-haze save_page">
                                        {{trans('global.save')}} </button>
                                    <a href="/admin/pages" class="btn default">
                                        {{trans('global.cancel')}} </a>

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
            //SEO URL vars
            var
                    timer,
                    timeout,
                    $slug = $('#friendly_url'),
                    url_from_name = true,
                    current_slug = '{{$seo['friendly_url'] or ''}}',
                    url_invalid = true;

            //Init WYSIWYG
            $('#content').summernote({height: 300});

            $('body').on('click', '.save_page', function () {
                var
                        title = $('#title').val(),
                        content = $('#content').code(),
                        page_title = $('#page_title').val(),
                        meta_description = $('#meta_description').val(),
                        meta_keywords = $('#meta_keywords').val();

                var slug = $slug.val();

                //Check URL
                if (slug.length > 0) {
                    if ((current_slug.length > 0 && current_slug != slug) || (current_slug.length == 0)) {
                        if (url_invalid === true) {
                            showNotification('error', '{{trans('global.warning')}}', '{{trans('pages.url_exists')}}');

                            return;
                        }
                    }
                } else {
                    showNotification('error', '{{trans('global.warning')}}', '{{trans('pages.url_required')}}');

                    return;
                }

                if ($('#active').is(':checked')) {
                    var active = 1;
                } else {
                    var active = 0;
                }
                if ($('#show_footer').is(':checked')) {
                    var show_footer = 1;
                } else {
                    var show_footer = 0;
                }

                $.ajax({
                           type: 'post',
                           url: '/admin/pages/store',
                           data: {
                               'title': title,
                               'content': content,
                               'active': active,
                               'show_footer': show_footer,
                               'friendly_url': $slug.val(),
                               'page_title': page_title,
                               'meta_description': meta_description,
                               'meta_keywords': meta_keywords,
                               'id': '{{$page['id'] or ''}}'
                           },
                           success: function (response) {
                               if (typeof response == typeof {} && response['status'] && response['message']) {
                                   showNotification(response['status'], response['message']);

                                   if (response['status'] == 'success' && response['redirect']) {
                                       setTimeout(function () {
                                           window.location.href = "/admin/pages/edit/" + response['id'];
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
                           url: '/admin/pages/show/check_url/' + url,
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

        $.ajaxPrefilter(function (options) {
            if (!options.beforeSend) {
                options.beforeSend = function (xhr) {
                    xhr.setRequestHeader('X-CSRF-Token', $('meta[name="csrf-token"]').attr('content'));
                }
            }
        });
    </script>
@endsection