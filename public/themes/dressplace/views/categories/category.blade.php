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

    <div class="category-holder">
        <div class="category-heading">
            <h1 class="col-xs-12">{{$category['title'] or ''}}</h1>
            <div class="clearfix"></div>

            <div class="line"></div>
            <div class="clearfix"></div>

            <div class="category-description">
                <p class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                    @if(!empty($category['description']))
                        {!! $category['description'] !!}
                    @endif
                </p>

                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 filters">
                    <form method="POST" id="filters" action="/{{$slug}}">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 filter no-padding-left">
                            @if(!empty($sizes) && is_array($sizes))
                                <label for="filter_sizes">{{trans('client.sizes')}}</label>
                                <select id="filter_sizes" name="size" class="form-control">
                                    <option value=""> - {{trans('client.choose_size')}} -</option>
                                    @foreach($sizes as $name)
                                        <option value="{{$name}}" @if(!empty($filter['size']) && $filter['size'] == $name) selected @endif>{{$name}}</option>
                                    @endforeach
                                </select>
                            @endif
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 filter no-padding-right">
                            @if(!empty($sizes) && is_array($sizes))
                                <label for="filter_materials">{{trans('client.material')}}</label>
                                <select id="filter_materials" name="material" class="form-control">
                                    <option value=""> - {{trans('client.choose_material')}} -</option>
                                    @foreach($materials as $key => $name)
                                        <option value="{{$key}}" @if(!empty($filter['material']) && $filter['material'] == $key) selected @endif>{{$name}}</option>
                                    @endforeach
                                </select>
                            @endif
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 filter no-padding-left">
                            @if(!empty($colors) && is_array($colors))
                                <label for="filter_colors">{{trans('client.color')}}</label>
                                <select id="filter_colors" name="color" class="form-control">
                                    <option value=""> - {{trans('client.choose_color')}} -</option>
                                    @foreach($colors as $key => $name)
                                        <option value="{{$key}}" @if(!empty($filter['color']) && $filter['color'] == $key) selected @endif>{{$name}}</option>
                                    @endforeach
                                </select>
                            @endif
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 filter no-padding-right">
                            <label for="order_by">{{trans('client.order_by')}}</label>
                            <select id="order_by" name="order_by" class="form-control">
                                <option value="newest" @if(empty($order_by) || (!empty($order_by) && $order_by == 'newest')) selected @endif>{{trans('client.newest')}}</option>
                                <option value="discounted" @if(!empty($order_by) && $order_by == 'discounted') selected @endif>{{trans('client.discounted')}}</option>
                                <option value="price_asc" @if(!empty($order_by) && $order_by == 'price_asc') selected @endif>{{trans('client.price_asc')}}</option>
                                <option value="price_desc" @if(!empty($order_by) && $order_by == 'price_desc') selected @endif>{{trans('client.price_desc')}}</option>
                            </select>
                        </div>
                    </form>
                </div>
                <div class="clearfix"></div>

                @if(!empty($breadcrumbs) && is_array($breadcrumbs))
                    <ol class="breadcrumb margin-15 no-margin-bottom">
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
                                    <a href="{{$all_categories[$breadcrumb]['slug']}}"
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
            </div>
            <div class="clearfix"></div>
        </div>

        <div class="clearfix"></div>

        <div class="products-holder">
            {{-- PRODUCTS --}}
            @include('dressplace::partials.render_products', $products_to_render)
            {{-- PRODUCTS --}}
            <div class="clearfix"></div>
        </div>
        <div class="clearfix"></div>

        @if(empty($total_pages) || (!empty($total_pages) && $total_pages > 1))
            <div id="pagination" class="text-center"></div>
        @endif
    </div>

    <div class="clearfix"></div>

    {{--SLIDER--}}
    @if(!empty($sliders) && is_array($sliders))
        @foreach($sliders as $key => $slider)
            @if(!empty($slider['slides']) && is_array($slider['slides']) && !empty($slider['slides_positions']) && is_array($slider['slides_positions']))
                @include('dressplace::partials.render_slider', $slider)
            @endif
        @endforeach
    @endif

    {{-- CAROUSELS BOTTOM --}}
    @if(!empty($carousels) && is_array($carousels))
        @foreach($carousels as $carousel)
            @if((!empty($carousel['position']) && intval($carousel['position']) > 1))
{{--                @include('dressplace::partials.render_carousel')--}}
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
                                                     firstLastUse: true,
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