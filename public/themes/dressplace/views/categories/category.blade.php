@extends('dressplace::layout')

@section('content')

    {{-- CAROUSELS TOP --}}
    @if(!empty($carousels) && is_array($carousels))
        @foreach($carousels as $carousel)
            @if(empty($carousel['position']) || (!empty($carousel['position']) && intval($carousel['position']) < 2))
                @include('dressplace::partials.render_carousel')
            @endif
        @endforeach
    @endif
    {{-- CAROUSELS TOP --}}

    <div class="container">
        <div class="col-xs-12">
            <div class="section-title text-center">
                <h1>{{$category['title'] or ''}}</h1>
            </div>
        </div>

        @if(!empty($category['description']))

            <div class="col-xs-12">
                {!! $category['description'] !!}
            </div>
        @endif
    </div>

    <!-- shop-area start -->
    <div class="shop-area">
        <div class="container">
            <div class="row">

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
                <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
                    <form method="POST" id="filters" action="/{{$slug}}">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <!-- widget-categories start -->
                        <aside class="widget widget-categories">
                            <h3 class="sidebar-title">{{trans('client.categories')}}</h3>
                            <ul class="sidebar-menu">
                                @if(!empty($main_categories) && is_array($main_categories))
                                    @foreach($main_categories as $key => $main_category)
                                        <li>
                                            <a href="/{{$main_category['slug']}}">
                                                {{$main_category['title'] or ''}}
                                            </a>
                                        </li>
                                    @endforeach
                                @endif
                            </ul>
                        </aside>
                        <!-- widget-categories end -->
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
                                        <input type="submit" value="{{trans('client.filter')}}"/>
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
                            <select id="filter_sizes" name="size" class="form-control cForm">
                                <option value=""> - {{trans('client.choose_size')}} -</option>
                                @foreach($sizes as $name)
                                    <option value="{{$name}}" @if(!empty($filter['size']) && $filter['size'] == $name) selected @endif>{{$name}}</option>
                                @endforeach
                            </select>
                        </aside>
                        <!-- filter-by end -->
                        @endif

                        @if(!empty($materials) && is_array($materials))
                                <!-- filter-by start -->
                        <aside class="widget filter-by">
                            <h3 class="sidebar-title">
                                <label for="filter_materials">
                                    {{trans('client.material')}}
                                </label>
                            </h3>

                            <select id="filter_materials" name="filter_materials" class="form-control cForm">
                                <option value=""> - {{trans('client.choose_material')}} -</option>
                                @foreach($materials as $key => $name)
                                    <option value="{{$key}}" @if(!empty($filter['material']) && $filter['material'] == $key) selected @endif>{{$name}}</option>
                                @endforeach
                            </select>

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

                            <select id="filter_colors" name="filter_colors" class="form-control cForm">
                                <option value=""> - {{trans('client.choose_color')}} -</option>
                                @foreach($colors as $key => $name)
                                    <option value="{{$key}}" @if(!empty($filter['color']) && $filter['color'] == $key) selected @endif>{{$name}}</option>
                                @endforeach
                            </select>

                        </aside>
                        <!-- filter-by end -->
                        @endif
                        <input type="submit" class="filter" value="{{trans('client.filter')}}"/>
                        <div class="clearfix"></div>
                    </form>

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
                                <div class="tolbar-select">
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

    {{--SLIDER--}}
    @if(!empty($sliders) && is_array($sliders))
        @foreach($sliders as $key => $slider)
            @if(!empty($slider['slides']) && is_array($slider['slides']) && !empty($slider['slides_positions']) && is_array($slider['slides_positions']))
                @include('dressplace::partials.render_slider', $slider)
            @endif
        @endforeach
    @endif

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

    {{--INIT MODULES--}}
    {{--@include('dressplace::partials.init_slider')--}}
    {{--@include('dressplace::partials.init_carousel')--}}
    {{--@include('dressplace::partials.init_products')--}}
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
            body.on('change', '#filter_sizes', function () {
                $(this).closest('form').submit();
            });

            body.on('change', '#filter_materials', function () {
                $(this).closest('form').submit();
            });

            body.on('change', '#filter_colors', function () {
                $(this).closest('form').submit();
            });

            body.on('change', '#order_by', function () {
                $(this).closest('form').submit();
            });

            //Breadcrumbs
            initBreadCrumbs();

        });
    </script>
@endsection