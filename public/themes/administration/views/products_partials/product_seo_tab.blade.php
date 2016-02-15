<!-- SEO TAB -->
<div class="tab-pane" id="seo">
    <form action="#">

        <input type="hidden" name="_token" value="{{ csrf_token() }}">

        <div class="form-group form-md-line-input has-success form-md-floating-label">
            <div class="input-icon right">
                <input name="friendly_url" id="friendly_url" type="text" class="form-control input-lg"  value="{{isset($seo['friendly_url']) ? $seo['friendly_url'] : ''}}"/>

                <label for="friendly_url">{{trans('products.friendly_url')}}</label>
                <span class="help-block"></span>
                <i class="fa fa-font"></i>
            </div>
        </div>

        <div class="form-group">
            <label for="meta_description" class="control-label col-xs-12 default no-padding">
                {{trans('products.meta_description')}}
            </label>
            <div class="col-xs-12 no-padding">
                <textarea id="meta_description"
                          class="form-control"
                          rows="3" 
                          placeholder="{{trans('products.meta_description')}}" 
                          style="margin-top: 0px; margin-bottom: 0px; height: 79px;">{!!isset($seo['meta_description']) ? $seo['meta_description'] : ''!!}</textarea>
            </div>
            <div class="clearfix"></div>
        </div>

        <div class="form-group">
            <label for="meta_keywords" class="control-label col-xs-12 default no-padding">
                {{trans('products.meta_keywords')}}
            </label>
            <div class="col-xs-12 no-padding">
                <textarea id="meta_keywords"
                          class="form-control"
                          rows="3" 
                          placeholder="{{trans('products.meta_keywords')}}" 
                          style="margin-top: 0px; margin-bottom: 0px; height: 79px;">{!!isset($seo['meta_keywords']) ? $seo['meta_keywords'] : ''!!}</textarea>
            </div>
            <div class="clearfix"></div>
        </div>

        <div class="clearfix"></div>
    </form>

</div>
<!-- END SEO TAB -->