@extends('administration::layout')

@section('content')
        <!-- BEGIN PROFILE CONTENT -->
<div class="profile-content">
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <div class="portlet light">
                <div class="portlet-title tabbable-line">
                    <div class="caption caption-lg margin-top-10">
                        <i class="fa fa-arrows"></i>
                        <span class="caption-subject font-blue-madison bold uppercase">{{$pageTitle}}</span>
                    </div>
                    <div class="actions">
                        <a href="/admin/module/sliders" class="btn btn-info margin-top-10" title="{{trans('sliders.sliders_list')}}">
                            <i class="fa fa-arrow-left"></i>
                            {{trans('sliders.sliders_list')}}
                        </a>
                        <a href="#" id="add_slide" class="btn btn-success margin-top-10" title="{{trans('sliders.add')}}">
                            <i class="fa fa-plus"></i>
                            {{trans('sliders.add')}}
                        </a>
                        <a href="#" id="save" class="btn btn-success margin-top-10" title="{{trans('sliders.save')}}">
                            <i class="fa fa-save"></i>
                            {{trans('sliders.save')}}
                        </a>
                    </div>
                    <div class="clearfix"></div>

                    <ul class="nav nav-tabs pull-left">
                        <li class="active">
                            <a href="#main_info_tab" data-toggle="tab">{{trans('sliders.main_info')}}</a>
                        </li>
                        <li>
                            <a href="#images_tab" data-toggle="tab">{{trans('sliders.images')}}</a>
                        </li>
                    </ul>
                </div>
                <div class="portlet-body">

                    <div class="tab-content">

                        {{--Main info tab--}}
                        @include('sliders.main_info_tab_partial')

                        {{--Images tab--}}
                        @include('sliders.images_tab_partial')

                    </div>

                    <div class="clearfix"></div>


                </div>
            </div>
        </div>
    </div>
</div>
<!-- END PROFILE CONTENT -->
@endsection

@section('customJS')
    <script type="text/javascript">
        jQuery(document).ready(function () {

            // Init DateTime_Picker
            var time_pickers = $("#datetimepicker_active_from, #datetimepicker_active_to");
            time_pickers.datetimepicker({
                                            autoclose: true,
                                            isRTL: Metronic.isRTL(),
                                            format: "yyyy.mm.dd hh:ii",
                                            pickerPosition: (Metronic.isRTL() ? "bottom-right" : "bottom-left")
                                        });

            $('body').on('change', '#type', function () {
                showHideTarget();
            });

            //Show/hide activate targets
            function showHideTarget() {
                var type = $('#type').val();

                if (type == 'categories') {
                    $('.categories_holder').removeClass('hidden');
                } else {
                    $('.categories_holder').addClass('hidden');
                }
                if (type == 'pages') {
                    $('.pages_holder').removeClass('hidden');
                } else {
                    $('.pages_holder').addClass('hidden');
                }
            }

            showHideTarget();

            //Sync images button
            $('body').on('click', '#sync_images', function () {
                var scan_target = $(this).attr('data-scan-target'),
                        holder = $('#slider-images');

                if (scan_target) {
                    $.ajax({
                               type: 'get',
                               url: '/admin/module/sliders/show/sync_images/' + scan_target,
                               success: function (response) {
                                   if (response) {
                                       if (holder.length > 0) {
                                           holder.html(response);
                                       }
                                   }
                               },
                               error: function () {
                                   showNotification('error', translate('request_not_completed'), translate('contact_support'));
                               }

                           });
                }
            });

            @if(!empty($slider['id']))
            //Sync images on load
            $('#sync_images').trigger('click');
            @endif

            //Remove slide button
            $('body').on('click', '.remove_slide', function () {
                var image = $(this).attr('data-image'),
                        parent = $(this).closest('.slider-image-holder');

                //If images found remove
                if (image) {
                    $.ajax({
                               type: 'post',
                               url: '/admin/module/sliders/destroy/image',
                               data: {
                                   'image': image,
                                   'dir': '{{$slider_dir or ''}}'
                               },
                               success: function (response) {
                                   if (typeof response == typeof {} && response['status'] && response['message']) {
                                       showNotification(response['status'], response['message']);
                                       if (response['status'] == 'success') {
                                           parent.remove();

                                           @if(!empty($slider['id']))
                                               saveSlides('{{$slider['id']}}');
                                           @endif
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
            });

            //Save slider
            function saveSlider() {
                var
                        slider_holder = $('.slider-image-holder'),
                        title = $('#slider_title').val(),
                        position = $('#slider_position').val(),
                        type = $('#type').val(),
                        categories = $('#categories').val(),
                        pages = $('#pages').val(),
                        active_from = $('#active_from').val(),
                        active_to = $('#active_to').val(),
                        target = '';

                        if(type == 'categories') {
                            target = categories;
                        }
                        if(type == 'pages') {
                            target = pages;
                        }

                $.ajax({
                           type: 'post',
                           url: '/admin/module/sliders/store',
                           data: {
                               'title': title,
                               'position': position,
                               'type': type,
                               'target': target,
                               'active_from': active_from,
                               'active_to': active_to,
                               'dir': '{{$slider_dir or $slider['dir']}}',
                               'id': '{{$slider['id'] or ''}}'
                           },
                           success: function (response) {
                               if (typeof response == typeof {} && response['status'] && response['message']) {
                                   showNotification(response['status'], response['message']);

                                   if(response['status'] == 'success' && response['id']) {
                                       saveSlides(response['id']);
                                   }
                                   if(response['status'] == 'success' && response['redirect']) {
                                       setTimeout(function () {
                                           window.location.href = "/admin/module/sliders/edit/" + response['id'];
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
            }

            //Get array with slides and their positions
            function getSlides() {
                var
                        slider_holder = $('.slider-image-holder'),
                        slides = {},
                        order = {};

                if (slider_holder.length > 0) {
                    //Loop trough sliders, get position, populate array
                    slider_holder.each(function () {
                        var
                                slide = $(this).attr('data-image'),
                                title = $(this).find('.input-title').val(),
                                text = $(this).find('.input-text').val(),
                                buttonText = $(this).find('.input-buttonText').val(),
                                buttonURL = $(this).find('.input-buttonURL').val(),
                                position = $(this).find('.input-position').val();

                        //Remember positioning
                        if (!position) {
                            position = 0;
                        }
                        order[slide] = position;

                        //Remember slides
                        if (slide) {
                            slides[slide] = {
                                'title': title,
                                'text': text,
                                'buttonText': buttonText,
                                'buttonURL': buttonURL
                            };
                        }

                    });

                    if (slides && order) {
                        var response = {'slides': slides, 'slides_positions': order};
                    } else {
                        var response = false;
                    }

                    return response;
                }
            }

            function saveSlides(slider_id) {
                var slides = getSlides();

                if (slides) {
                    $.ajax({
                               type: 'post',
                               url: '/admin/module/sliders/store/slides',
                               data: {
                                   'slides': slides['slides'],
                                   'slides_positions': slides['slides_positions'],
                                   'slider_id': slider_id
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
                }
            }

            $('#save').click(function (e) {
                e.preventDefault();

                //Save the slider
                saveSlider();
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