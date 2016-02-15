<!--Main info tab-->
<div class="tab-pane active" id="main_info_tab">
    <div class="form-group form-md-line-input has-success form-md-floating-label col-xs-12 col-sm-8 col-md-8 col-lg-8">
        <div class="input-icon right">
            <input name="slider_title" id="slider_title" type="text" class="form-control input-lg" value="{{isset($slider['title']) ? $slider['title'] : ''}}"/>

            <label for="slider_title">{{trans('sliders.title')}}</label>
            <span class="help-block"></span>
            <i class="fa fa-font"></i>
        </div>
    </div>

    <div class="form-group form-md-line-input has-success form-md-floating-label col-xs-12 col-sm-4 col-md-4 col-lg-4">
        <div class="input-icon right">
            <input name="slider_position" id="slider_position" type="number" class="form-control input-lg" value="{{isset($slider['position']) ? $slider['position'] : ''}}"/>

            <label for="slider_title">{{trans('sliders.position')}}</label>
            <span class="help-block"></span>
            <i class="fa fa-font"></i>
        </div>
    </div>

    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 margin-top-20">
        <label for="type" class="control-label col-xs-12 default no-padding">
            {{trans('sliders.type')}}
        </label>
        <select id="type" name="type" class="form-control input-lg">
            <option value="">{{trans('sliders.choose_module')}}</option>
            <option value="homepage" @if(!empty($slider['type']) && $slider['tab'] == 'homepage') selected="selected" @endif>{{trans('sliders.homepage')}}</option>
            <option value="categories" @if(!empty($slider['type']) && $slider['tab'] == 'categories') selected="selected" @endif>{{trans('sliders.categories')}}</option>
            <option value="pages" @if(!empty($slider['type']) && $slider['tab'] == 'pages') selected="selected" @endif>{{trans('sliders.pages')}}</option>
        </select>
    </div>

    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 margin-top-20">
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

    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 margin-top-20">
        <label for="pages" class="control-label col-xs-12 default no-padding">
            {{trans('sliders.choose_page')}}
        </label>
        <select id="pages" name="pages[]" class="form-control select2me input-lg no-padding" data-placeholder="{{trans('sliders.choose_page')}}">
            <option value="">{{trans('sliders.choose_page')}}</option>
            @if(isset($pages) && is_array($pages))
                @foreach($pages as $key => $page)
                    <option value="{{$page['id']}}" @if(!empty($slider['type']) && $slider['type'] == 'pages' && !empty($slider['target']) && $slider['target'] == $page['id']) selected="selected" @endif>{{$page['title']}}</option>
                @endforeach
            @endif
        </select>
    </div>
</div>