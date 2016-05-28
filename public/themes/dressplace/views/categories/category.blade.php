@extends('dressplace::layout')

@section('content')

    {{--SLIDER--}}
    @if(!empty($sliders) && is_array($sliders))
        @foreach($sliders as $key => $slider)
            @if(!empty($slider['slides']) && is_array($slider['slides']) && !empty($slider['slides_positions']) && is_array($slider['slides_positions']))
                @include('dressplace::partials.render_slider', $slider)
            @endif
        @endforeach
    @endif

    <div class="clearfix"></div>

    {{-- CAROUSELS TOP --}}
    @if(!empty($carousels) && is_array($carousels))
        @foreach($carousels as $carousel)
            <div class="container">
                <div class="row">
                    @if(empty($carousel['position']) || (!empty($carousel['position']) && intval($carousel['position']) < 2))
                        @include('dressplace::partials.render_carousel')
                    @endif
                </div>
            </div>
        @endforeach
    @endif
    {{-- CAROUSELS TOP --}}

    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <div class="section-title text-center">
                    <h1>{{$category['title'] or ''}}</h1>
                </div>
            </div>

            @if(!empty($category['description']))
                <div class="col-xs-12 hidden-xs hidden-sm">
                    {!! $category['description'] !!}
                </div>
            @endif
        </div>
    </div>

    <!-- shop-area start -->
    <div class="container">
        <div class="row">
            <div class="shop-area">

                @if(!empty($breadcrumbs) && is_array($breadcrumbs))
                    <ol class="breadcrumb">
                        {{--Home page--}}
                        <li>
                            <a href="/"
                               title="{{trans('client.home')}}"
                               data-toggle="tooltip"
                               data-placement="top"
                            >
                                <i class="fa fa-home"></i>
                            </a>
                        </li>
                        @foreach($breadcrumbs as $breadcrumb)
                            @if(!empty($all_categories[$breadcrumb]['slug']) && !empty($all_categories[$breadcrumb]['title']))
                                <li>
                                    <a href="/{{$all_categories[$breadcrumb]['slug']}}"
                                       title="{{$all_categories[$breadcrumb]['title']}}"
                                       data-toggle="tooltip"
                                       data-placement="top"
                                    >
                                        {{$all_categories[$breadcrumb]['title']}}
                                    </a>
                                </li>
                            @endif
                        @endforeach
                    </ol>
                @endif

                <div class="clearfix"></div>

                <!-- left-sidebar start -->
                <div class="col-lg-3 col-md-3 hidden-xs hidden-sm">
                    <!-- widget-categories start -->
                    <aside class="widget widget-categories">
                        <h3 class="sidebar-title">{{trans('client.categories')}}</h3>
                        <ul class="sidebar-menu">
                            @if(!empty($main_categories) && is_array($main_categories))
                                @foreach($main_categories as $key => $main_category)
                                    <li>
                                        <a href="/{{$main_category['slug']}}" class="@if(empty($second_level_categories[$main_category['id']])) empty @endif">
                                            <i class="fa fa-angle-right" aria-hidden="true"></i>

                                            {{$main_category['title'] or ''}}
                                        </a>

                                        @if(!empty($second_level_categories[$main_category['id']]) && is_array($second_level_categories[$main_category['id']]))
                                            <ul class="childs hidden">
                                                @foreach($second_level_categories[$main_category['id']] as $second_level_category)
                                                    <li>
                                                        <a href="/{{$second_level_category['slug']}}">
                                                            {{$second_level_category['title'] or ''}}
                                                        </a>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        @endif
                                    </li>
                                @endforeach
                            @endif
                        </ul>
                    </aside>
                    <!-- widget-categories end -->


                    <form method="POST" id="filters" action="/{{$slug}}">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <!-- shop-filter start -->
                        <aside class="widget shop-filter">
                            <h3 class="sidebar-title">{{trans('client.price')}}</h3>
                            <div class="info_widget">
                                <div class="price_filter">
                                    <div id="slider-range" data-min="1" data-max="100" data-current-min="{{$filter['price_min'] or ''}}" data-current-max="{{$filter['price_max'] or ''}}"></div>
                                    <div class="price_slider_amount">
                                        <div class="ammounts-holder">
                                            <input type="text" class="min-price" name="price_min" readonly/> -
                                            <input type="text" class="max-price" name="price_max" readonly/>
                                        </div>
{{--                                        <input type="submit" value="{{trans('client.filter')}}"/>--}}
                                    </div>
                                </div>
                            </div>
                        </aside>
                        <!-- shop-filter end -->
                    @if(!empty($sizes) && is_array($sizes))
                        <!-- filter-by start -->
                            <aside class="widget filter-by">
                                <h3 class="sidebar-title">
                                    <label for="filter_sizes">
                                        {{trans('client.sizes')}}
                                    </label>
                                </h3>

                                <ul class="sidebar-menu">
                                    <?php $count = 0; ?>
                                    @foreach($sizes as $name)
                                        <?php $count++; ?>
                                        <li>
                                            <a href="javascript:;">
                                                <label for="filter_sizes_{{$count}}">
                                                    <i class="fa fa-angle-right" aria-hidden="true"></i>
                                                    {{$name}}

                                                    <input type="checkbox" name="size[]" id="filter_sizes_{{$count}}" value="{{$name}}" @if(!empty($filter['size']) && is_array($filter['size']) && in_array($name, $filter['size'])) checked @endif />
                                                </label>
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </aside>
                            <!-- filter-by end -->
                    @endif

                    @if(!empty($colors) && is_array($colors))
                        <!-- filter-by start -->
                            <aside class="widget filter-by">
                                <h3 class="sidebar-title">
                                    <label for="filter_colors">
                                        {{trans('client.colors')}}
                                    </label>
                                </h3>

                                <ul class="sidebar-menu">
                                    <?php $count = 0; ?>
                                    @foreach($colors as $key => $name)
                                        <?php $count++; ?>
                                        <li>
                                            <a href="javascript:;">
                                                <label for="filter_colors_{{$count}}">
                                                    <i class="fa fa-angle-right" aria-hidden="true"></i>
                                                    {{$name}}

                                                    <input type="checkbox" name="color[]" id="filter_colors_{{$count}}" value="{{$key}}" @if(!empty($filter['color']) && is_array($filter['color']) && in_array($key, $filter['color'])) checked @endif/>
                                                </label>
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>

                            </aside>
                            <!-- filter-by end -->
                        @endif
                        <input type="submit" class="filter" value="{{trans('client.filter')}}"/>
                        <div class="clearfix"></div>

                        {{--@if(!empty($materials) && is_array($materials))--}}
                        {{--<!-- filter-by start -->--}}
                        {{--<aside class="widget filter-by">--}}
                        {{--<h3 class="sidebar-title">--}}
                        {{--<label for="filter_materials">--}}
                        {{--{{trans('client.material')}}--}}
                        {{--</label>--}}
                        {{--</h3>--}}

                        {{--<select id="filter_materials" name="filter_materials" class="form-control cForm">--}}
                        {{--<option value=""> - {{trans('client.choose_material')}} -</option>--}}
                        {{--@foreach($materials as $key => $name)--}}
                        {{--<option value="{{$key}}" @if(!empty($filter['material']) && $filter['material'] == $key) selected @endif>{{$name}}</option>--}}
                        {{--@endforeach--}}
                        {{--</select>--}}

                        {{--</aside>--}}
                        {{--<!-- filter-by end -->--}}
                        {{--@endif--}}
                    </form>

                @if(!empty($products[$upcoming['product_id']]))
                    <!-- widget-recent start -->
                        <aside class="widget top-product-widget hidden-sm">
                            <h3 class="sidebar-title">{{$upcoming['title'] or ''}}</h3>
                            <div class="banner-curosel">
                                <div class="banner">
                                    <a href="{{$products[$upcoming['product_id']]['slug']}}">
                                        <img
                                                src="{{$thumbs_path . $upcoming['product_id'] . '/' . $icon_size . '/' .  $products[$upcoming['product_id']]['image']}}"
                                                alt="{{$products[$upcoming['product_id']]['title']}}"
                                        />
                                    </a>
                                    <div class="upcoming-pro">
                                        <div data-countdown="{{$upcoming['date'] or ''}}"></div>
                                    </div>
                                </div>
                            </div>
                        </aside>
                @endif

                <!-- widget-recent end -->
                </div>
                <!-- left-sidebar end -->
                <!-- shop-content start -->
                <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12">
                    <div class="shop-content">
                        <!-- Nav tabs -->
                        <ul class="shop-tab" role="tablist">
                            <li role="presentation" class="active"><a href="#grid" aria-controls="grid" role="tab" data-toggle="tab"><i class="fa fa-th"></i></a></li>
                            <li role="presentation"><a href="#list" aria-controls="list" role="tab" data-toggle="tab"><i class="fa fa-list"></i></a></li>
                        </ul>
                        <div class="show-result">
                            {{--<p> Showing 1&ndash;12 of 19 results</p>--}}
                        </div>
                        <div class="toolbar-form">
                            <form method="POST" id="order" action="/{{$slug}}">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <div class="toolbar-select">
                                    <label for="order_by">{{trans('client.order_by')}}</label>
                                    <select name="order_by" id="order_by">
                                        <option value="newest" @if(empty($order_by) || (!empty($order_by) && $order_by == 'newest')) selected @endif>{{trans('client.newest')}}</option>
                                        <option value="discounted" @if(!empty($order_by) && $order_by == 'discounted') selected @endif>{{trans('client.discounted')}}</option>
                                        <option value="price_asc" @if(!empty($order_by) && $order_by == 'price_asc') selected @endif>{{trans('client.price_asc')}}</option>
                                        <option value="price_desc" @if(!empty($order_by) && $order_by == 'price_desc') selected @endif>{{trans('client.price_desc')}}</option>
                                    </select>
                                </div>
                            </form>
                        </div>

                        <!-- Tab panes -->
                        <div class="tab-content">
                            <div role="tabpanel" class="tab-pane active" id="grid">
                                <div class="row">
                                    @include('dressplace::partials.render_products', $products_to_render)
                                </div>
                            </div>
                            <div role="tabpanel" class="tab-pane" id="list">
                                <div class="row shop-list">
                                    @include('dressplace::partials.render_products_list', $products_to_render)
                                </div>
                            </div>
                        </div>
                    </div>
                    @if(!empty($total_pages) && intval($total_pages) > 1)
                        <div class="shop-pagination">
                            <h5>{{trans('client.pages')}} </h5>
                            <div id="pagination" class="pagination text-center"></div>
                        </div>
                    @endif
                </div>
                <!-- shop-content end -->
            </div>
        </div>
    </div>
    <!-- shop-area end -->

    <div class="clearfix"></div>

    {{-- CAROUSELS BOTTOM --}}
    @if(!empty($carousels) && is_array($carousels))
        @foreach($carousels as $carousel)
            @if((!empty($carousel['position']) && intval($carousel['position']) > 1))
                <div class="container">
                    <div class="row">
                        @include('dressplace::partials.render_carousel')
                    </div>
                </div>
            @endif
        @endforeach
    @endif
    {{-- CAROUSELS BOTTOM --}}
@endsection

@section('customJS')
    <script type="text/javascript">
        $(document).ready(function () {
            @if(empty($total_pages) || (!empty($total_pages) && $total_pages > 1))
            $('#pagination').bootpag({
                                                     total: '{{$total_pages or 1}}',
                                                     page: '{{$current_page or 1}}',
                                                     maxVisible: 8,
                                                     leaps: true,
                                                     firstLastUse: false,
                                                     first: '{{trans('client.first_page')}}',
                                                     last: '{{trans('client.last_page')}}',
                                                     href: 'javascript:;'
                                                 }).on("page", function (event, num) {
                window.location.href = "/{{$slug}}/" + num;
            });
            @endif

            //Filters
            var body = $('body');

            body.on('change', '#order_by', function () {
                $(this).closest('form').submit();
            });

            var timer = null;

            $('.price_filter').mouseup(function () {
                if(timer) {
                    clearTimeout(timer);
                    timer = null;
                }

                timer = setTimeout(function () {
                    console.log('submit');
                    $('#filters').submit();
                }, 2000);
            });

            //Breadcrumbs
            initBreadCrumbs();

        });
    </script>
@endsection