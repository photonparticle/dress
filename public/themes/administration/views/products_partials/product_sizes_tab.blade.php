<!-- Relationships TAB -->
<div class="tab-pane" id="sizes">
    <form action="#">

        <div class="col-xs-12 margin-top-20 categories-container">
            <label for="categories" class="control-label col-xs-12 default no-padding">
                {{trans('sizes.group')}}
            </label>
            <select id="sizes_group" name="sizes_group" class="form-control select2me input-lg no-padding" data-placeholder="{{trans('global.select_sizes_group')}}">
                <option value="">{{trans('products.select_sizes_group')}}</option>
                @if(isset($groups) && is_array($groups))
                    @foreach($groups as $key => $group)
                        <option value="{{$group}}" @if(!empty($active_group) && $group = $active_group) selected="selected" @endif>{{$group}}</option>
                    @endforeach
                @endif
            </select>
        </div>
        <div class="clearfix"></div>

        <div id="sizes_holder" class="margin-top-20">
            @include('products_partials.product_sizes_form')
        </div>

        <div class="margin-top-20">
            <button class="btn green-haze save_product">
                {{trans('global.save')}} </button>
            <a href="/admin/products" class="btn default">
                {{trans('global.cancel')}} </a>
        </div>
    </form>
</div>
<!-- END Relationships TAB -->