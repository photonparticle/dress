@extends('dressplace::layout')

@section('content')

    @if(!isset($ajax))
        <div class="container">
            @endif
            <div class="col-xs-12">
                <div class="section-title text-center">
                    <h1 class="no-margin">
                        {{trans('client.sitemap')}}
                    </h1>
                </div>
            </div>
            <div class="clearfix"></div>
            @if(!isset($ajax))
        </div>
    @endif

    @if(!isset($ajax))
        <div class="container
        sitemap">
            @endif

            @if(!empty($map_cat_lvl_1) && is_array($map_cat_lvl_1))
                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 categories">
                    <h1>{{trans('client.categories')}}</h1>
                    <ul>
                        @foreach($map_cat_lvl_1 as $key => $main_category)
                            <li>
                                <a href="/{{$main_category['slug']}}">
                                    {{$main_category['title'] or ''}}
                                </a>
                                @if(!empty($map_cat_lvl_2[$main_category['id']]) && is_array($map_cat_lvl_2[$main_category['id']]))
                                    <ul>
                                        @foreach($map_cat_lvl_2[$main_category['id']] as $second_level_category)
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
                    </ul>
                </div>
            @endif

            {{-- Information --}}
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                <h1>{{trans('client.pages')}}</h1>
                <ul>
                    <li>
                        <a href="/">
                            {{trans('client.home')}}
                        </a>
                    </li>
                    <li>
                        <a href="/contact">
                            {{trans('client.contact_us')}}
                        </a>
                    </li>
                    @if(!empty($navigation_pages) && is_array($navigation_pages))
                        @foreach($navigation_pages as $page)
                            <li>
                                <a href="{{$page['slug']}}">
                                    {{$page['title']}}
                                </a>
                            </li>
                        @endforeach
                    @endif
                </ul>
            </div>

            {{-- My profile --}}
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                <h1>{{trans('client.my-account')}}</h1>
                <ul>
                    @if(empty($current_user))
                        <li><a href="/login">{{trans('client.login')}}</a></li>
                        <li><a href="/register">{{trans('client.register')}}</a></li>
                    @else
                        <li>
                            <a href="/my-profile">{{trans('client.my-account')}}</a>
                        </li>
                        <li><a href="/my-orders">{{trans('client.my-orders')}}</a></li>
                        <li><a href="/logout">{{trans('client.logout')}}</a></li>
                    @endif
                </ul>
            </div>

            @if(!isset($ajax))
        </div>
    @endif
@endsection