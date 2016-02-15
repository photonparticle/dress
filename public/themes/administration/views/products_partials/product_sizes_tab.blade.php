<!-- Relationships TAB -->
<div class="tab-pane" id="sizes">
    <div class="portlet box blue-madison margin-top-20">
        <div class="portlet-title">
            <div class="caption">
                <i class="fa fa-arrows-v"></i>{{trans('products.sizes')}}
            </div>
            <div class="tools">
                <a href="javascript:;" class="collapse" data-original-title="" title="">
                </a>
            </div>
        </div>
        <div class="portlet-body">
            <form action="#">
                <div class="col-xs-12 margin-top-20 categories-container">
                    <label for="sizes_group" class="control-label col-xs-12 default no-padding">
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
            </form>
        </div>
    </div>

    {{--Dimensions table--}}
    <div class="portlet box blue-madison">
        <div class="portlet-title">
            <div class="caption">
                <i class="fa fa-table"></i>{{trans('products.dimensions_table')}}
            </div>
            <div class="tools">
                <a href="javascript:;" class="collapse" data-original-title="" title="">
                </a>
            </div>
        </div>
        <div class="portlet-body">
            <div class="col-xs-12 categories-container">
                <div class="margin-top-20">
                    <label for="load_table_template" class="control-label col-xs-12 default no-padding">
                        {{trans('products.load_table_template')}}
                    </label>
                    <select id="load_table_template" name="load_table_template" class="form-control select2me input-lg no-padding" data-placeholder="{{trans('global.select_sizes_group')}}">
                        <option value="">{{trans('products.choose_table_template')}}</option>
                        @if(isset($dimensions_tables) && is_array($dimensions_tables))
                            @foreach($dimensions_tables as $key => $table)
                                <option value="{{$table['id']}}">{{$table['title']}}</option>
                            @endforeach
                        @endif
                    </select>
                    <div class="margin-top-20">
                        <label for="dimensions_table" class="control-label col-xs-12 default no-padding">
                            {{trans('products.dimensions_table')}}
                        </label>
                    </div>
                </div>
                <div class="clearfix"></div>
                <div class="margin-top-20">
                    <div id="dimensions_table">
                        {!!isset($product['dimensions_table']) ? $product['dimensions_table'] : ''!!}
                    </div>
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>

    
</div>
<!-- END Relationships TAB -->