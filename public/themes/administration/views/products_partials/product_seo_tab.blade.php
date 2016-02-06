<!-- MAIN INFO TAB -->
<div class="tab-pane active" id="seo">
    <form action="#">

        <input type="hidden" name="_token" value="{{ csrf_token() }}">
<!--
        <label for="description" 
               class="control-label col-xs-12 default no-padding">
                Описание
        </label>

        <textarea class="form-control" 
                  rows="3" 
                  placeholder="Enter more text" 
                  style="margin-top: 0px; margin-bottom: 0px; height: 79px;">
        </textarea>

        -->

        <div class="clearfix"></div>

        <div class="margin-top-20">
            <button class="btn green-haze save_category">
                {{trans('global.save')}} </button>
            <a href="/admin/products" class="btn default">
                {{trans('global.cancel')}} </a>
        </div>

    </form>

</div>
<!-- END MAIN INFO TAB -->











<!--

            <div class="input-icon right">
                <input name="meta_description" id="meta_description" type="text" class="form-control input-lg" value="{{isset($product['meta_description']) ? $product['meta_description'] : ''}}"/>

                <label for="meta_description">Заглавие</label>
                <span class="help-block"></span>
                <i class="fa fa-font"></i>
            </div>



-->




























