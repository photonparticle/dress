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
        
        

        <div class="col-xs-12 margin-top-20 categories-container">
            <label for="manufacturers" class="control-label col-xs-12 default no-padding">
                {{trans('products.manufacturers')}}
            </label>
            <select id="manufacturers" 
                    name="manufacturers[]" 
                    class="form-control select2me input-lg no-padding" 
                    
                    

                    data-placeholder="{{trans('products.select_manufacturers')}}">
                @if(isset($categories) && is_array($categories))
                    @foreach($categories as $key => $category)
                        <option value="{{$category['id']}}" @if(!empty($related_categories) && in_array($category['id'], $related_categories)) selected="selected" @endif>{{$category['title']}}</option>
                    @endforeach
                @endif
            </select>
        </div>
        <div class="clearfix"></div>
        
        
        
        <div class="col-xs-12 margin-top-20 categories-container">
            <label for="related_products" class="control-label col-xs-12 default no-padding">
                {{trans('products.related_products')}}
            </label>
            <select id="related_products" 
                    name="related_products[]" 
                    class="form-control select2me input-lg no-padding" 
                    
                    multiple="multiple"

                    data-placeholder="{{trans('products.related_products')}}">
                @if(isset($categories) && is_array($categories))
                    @foreach($categories as $key => $category)
                        <option value="{{$category['id']}}" @if(!empty($related_categories) && in_array($category['id'], $related_categories)) selected="selected" @endif>{{$category['title']}}</option>
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