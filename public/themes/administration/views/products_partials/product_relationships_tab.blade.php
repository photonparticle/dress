<!-- Relationships TAB -->
<div class="tab-pane" id="relationships">
    <form action="#">

        <div class="col-xs-12 margin-top-20 categories-container">
            <label for="categories" class="control-label col-xs-12 default no-padding">
                {{trans('products.parent_category')}}
            </label>
            <select id="categories" name="categories[]" class="form-control select2me input-lg no-padding" multiple="multiple" data-placeholder="{{trans('products.select_catagories')}}">
                @if(isset($categories) && is_array($categories))
                    @foreach($categories as $key => $category)
                        <option value="{{$category['id']}}" @if(!empty($related_categories) && in_array($category['id'], $related_categories)) selected="selected" @endif>{{$category['title']}}</option>
                    @endforeach
                @endif
            </select>
        </div>
        <div class="clearfix"></div>

        <div class="col-xs-12 margin-top-20">
            <label for="manufacturer" class="control-label col-xs-12 default no-padding">
                {{trans('products.manufacturer')}}
            </label>
            <select id="manufacturer"
                    name="manufacturers"
                    class="form-control select2me input-lg no-padding"
                    data-placeholder="{{trans('products.select_manufacturer')}}">
                <option value="">{{trans('products.select_manufacturer')}}</option>
                @if(isset($manufacturers) && is_array($manufacturers))
                    @foreach($manufacturers as $key => $manufacturer)
                        <option value="{{$manufacturer['id']}}" @if(!empty($product['manufacturer']) && !empty($product['manufacturer']) && $manufacturer['id'] == $product['manufacturer'])) selected="selected" @endif>{{$manufacturer['title']}}</option>
                    @endforeach
                @endif
            </select>
        </div>
        <div class="clearfix"></div>

        <div class="col-xs-12 margin-top-20">
            <label for="colors" class="control-label col-xs-12 default no-padding">
                {{trans('products.colors')}}
            </label>
            <select id="colors" name="colors[]" class="form-control select2me input-lg no-padding" multiple="multiple" data-placeholder="{{trans('products.select_colors')}}">
                @if(isset($colors) && is_array($colors))
                    @foreach($colors as $key => $color)
                        <option value="{{$color['id']}}" @if(!empty($related_colors) && in_array($color['id'], $related_colors)) selected="selected" @endif>{{$color['title']}}</option>
                    @endforeach
                @endif
            </select>
        </div>
        <div class="clearfix"></div>

        <div class="col-xs-12 margin-top-20">
            <label for="related_products" class="control-label col-xs-12 default no-padding">
                {{trans('products.related_products')}}
            </label>
            <select id="related_products"
                    name="related_products[]"
                    class="form-control select2me input-lg no-padding"
                    multiple="multiple"
                    data-placeholder="{{trans('products.related_products')}}">
                @if(isset($products) && is_array($products))
                    @foreach($products as $key => $product)
                        <option value="{{$product['id']}}" @if(!empty($related_products) && in_array($product['id'], $related_products)) selected="selected" @endif>{{$product['id']}} - {{$product['title']}}</option>
                    @endforeach
                @endif
            </select>
        </div>
        <div class="clearfix"></div>

        <div class="margin-top-20">
            <button class="btn green-haze save_product">
                {{trans('global.save')}} </button>
            <a href="/admin/products" class="btn default">
                {{trans('global.cancel')}} </a>
        </div>
    </form>
</div>
<!-- END Relationships TAB -->