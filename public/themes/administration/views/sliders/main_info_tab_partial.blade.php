<!--Main info tab-->
<div class="tab-pane active" id="main_info_tab">

    {{--Title--}}
    <div class="form-group form-md-line-input has-success form-md-floating-label col-xs-12 col-sm-8 col-md-8 col-lg-10">
        <div class="input-icon right">
            <input name="slider_title" id="slider_title" type="text" class="form-control input-lg" value="{{isset($slider['title']) ? $slider['title'] : ''}}"/>

            <label for="slider_title">{{trans('sliders.title')}}</label>
            <span class="help-block"></span>
            <i class="fa fa-font"></i>
        </div>
    </div>

    {{--Position--}}
    <div class="form-group form-md-line-input has-success form-md-floating-label col-xs-12 col-sm-4 col-md-4 col-lg-2">
        <div class="input-icon right">
            <input name="slider_position" id="slider_position" type="number" class="form-control input-lg" value="{{isset($slider['position']) ? $slider['position'] : ''}}"/>

            <label for="slider_position">{{trans('sliders.position')}}</label>
            <span class="help-block"></span>
            <i class="fa fa-arrows-v"></i>
        </div>
    </div>

    {{--Type--}}
    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
        <label for="type" class="control-label col-xs-12 default no-padding">
            {{trans('sliders.type')}}
        </label>
        <select id="type" name="type" class="form-control input-lg">
            <option value="">{{trans('sliders.choose_module')}}</option>
            <option value="homepage" @if(!empty($slider['type']) && $slider['type'] == 'homepage') selected="selected" @endif>{{trans('sliders.homepage')}}</option>
            <option value="categories" @if(!empty($slider['type']) && $slider['type'] == 'categories') selected="selected" @endif>{{trans('sliders.categories')}}</option>
            <option value="pages" @if(!empty($slider['type']) && $slider['type'] == 'pages') selected="selected" @endif>{{trans('sliders.pages')}}</option>
        </select>
    </div>

    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
        {{--Categories--}}
        <div class="categories_holder hidden">
            <label for="categories" class="control-label col-xs-12 default no-padding">
                {{trans('sliders.choose_category')}}
            </label>
            <select id="categories" name="categories[]" class="form-control select2me input-lg no-padding" data-placeholder="{{trans('sliders.choose_category')}}">
                <option value="">{{trans('sliders.all_categories')}}</option>
                @if(isset($categories) && is_array($categories))
                    @foreach($categories as $key => $category)
                        <option value="{{$category['id']}}" @if(!empty($slider['type']) && $slider['type'] == 'categories' && !empty($slider['target']) && $slider['target'] == $category['id']) selected="selected" @endif>{{$category['title']}}</option>
                    @endforeach
                @endif
            </select>
        </div>

        {{--Pages--}}
        <div class="pages_holder hidden">
            <label for="pages" class="control-label col-xs-12 default no-padding">
                {{trans('sliders.choose_page')}}
            </label>
            <select id="pages" name="pages[]" class="form-control select2me input-lg no-padding" data-placeholder="{{trans('sliders.choose_page')}}">
                <option value="">{{trans('sliders.all_pages')}}</option>
                @if(isset($pages) && is_array($pages))
                    @foreach($pages as $key => $page)
                        <option value="{{$page['id']}}" @if(!empty($slider['type']) && $slider['type'] == 'pages' && !empty($slider['target']) && $slider['target'] == $page['id']) selected="selected" @endif>{{$page['title']}}</option>
                    @endforeach
                @endif
            </select>
        </div>
    </div>

    <div class="clearfix"></div>

    {{--Activation dates--}}

    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 margin-top-20">
        <label for="active_from" class="control-label col-xs-12 default no-padding">
            {{trans('sliders.active_from')}}
        </label>

        <div class="input-group date" id="datetimepicker_active_from">
            <input type="text" id="active_from" size="16" readonly class="form-control" value="{{isset($slider['active_from']) ? $slider['active_from'] : ''}}">
                <span class="input-group-btn">
                    <button class="btn default date-set" type="button"><i class="fa fa-calendar"></i></button>
                </span>
        </div>
    </div>

    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 margin-top-20">
        <label for="active_to" class="control-label col-xs-12 default no-padding">
            {{trans('sliders.active_to')}}
        </label>

        <div class="input-group date" id="datetimepicker_active_to">
            <input type="text" id="active_to" size="16" readonly class="form-control" value="{{isset($slider['active_to']) ? $slider['active_to'] : ''}}">
                <span class="input-group-btn">
                    <button class="btn default date-set" type="button"><i class="fa fa-calendar"></i></button>
                </span>
        </div>
    </div>
</div>