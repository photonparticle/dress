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
                        <option value="{{$category['id']}}" @if(!empty($related_categories) && in_array($category['id'], $related_categories)) selected="selected" @endif>{{$category['title'] or ''}}</option>
                    @endforeach
                @endif
            </select>
        </div>
        <div class="clearfix"></div>

        <div class="col-xs-12 margin-top-20 categories-container">
            <label for="main_category" class="control-label col-xs-12 default no-padding">
                {{trans('products.main_category')}}
            </label>
            <select id="main_category" name="main_category" class="form-control select2me input-lg no-padding" data-placeholder="{{trans('products.select_main_category')}}">
                <option value="">{{trans('products.select_main_category')}}</option>
                @if(isset($categories) && is_array($categories))
                    @foreach($categories as $key => $category)
                        <option value="{{$category['id']}}" @if(!empty($product['main_category']) && $category['id'] == $product['main_category']) selected="selected" @endif>{{$category['title'] or ''}}</option>
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
                        <option value="{{$manufacturer['id']}}" @if(!empty($product['manufacturer']) && !empty($product['manufacturer']) && $manufacturer['id'] == $product['manufacturer'])) selected="selected" @endif>{{$manufacturer['title'] or ''}}</option>
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
                        <option value="{{$color['id']}}" @if(!empty($related_colors) && in_array($color['id'], $related_colors)) selected="selected" @endif>{{$color['title'] or ''}}</option>
                    @endforeach
                @endif
            </select>
        </div>
        <div class="clearfix"></div>

        <div class="col-xs-12 margin-top-20">
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 no-padding">
                <label for="material" class="control-label col-xs-12 default no-padding">
                    {{trans('products.material')}}
                </label>
                <select id="material" name="material" class="form-control select2me input-lg no-padding" data-placeholder="{{trans('products.select_material')}}">
                    <option value="">{{trans('products.select_material')}}</option>
                    @if(isset($materials) && is_array($materials))
                        @foreach($materials as $key => $material)
                            <option value="{{$material['id']}}" @if(!empty($product['material']) && $material['id'] == $product['material']) selected="selected" @endif>{{$material['title'] or ''}}</option>
                        @endforeach
                    @endif
                </select>
            </div>

            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 margin-top-15 no-padding">
                <div class="col-xs-10 col-sm-11 col-md-11 col-lg-11">
                    <div class="form-group form-md-line-input has-success form-md-floating-label no-margin">
                        <div class="input-icon right">
                            <input name="add_material" id="add_material" type="text" class="form-control input-lg"/>

                            <label for="add_material">{{trans('products.add_material')}}</label>
                            <span class="help-block"></span>
                            <i class="fa fa-font"></i>
                        </div>
                    </div>
                </div>

                <div class="col-xs-2 col-sm-1 col-md-1 col-lg-1 no-padding text-right margin-top-10">
                    <a href="#"
                       class="btn btn-icon-only green save_material margin-top-20"
                       title="{{trans('global.save')}}"
                    >
                        <i class="fa fa-save"></i>
                    </a>
                </div>
            </div>
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
                        <option value="{{$product['id'] or ''}}" @if(!empty($related_products) && !empty($product['id']) && in_array($product['id'], $related_products)) selected="selected" @endif>{{$product['id'] or ''}} - {{$product['title']}}</option>
                    @endforeach
                @endif
            </select>
        </div>
        <div class="clearfix"></div>
    </form>
</div>
<!-- END Relationships TAB -->