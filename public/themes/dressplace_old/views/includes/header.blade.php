<!--HEADER START -->
<div class="header">
    <div class="header-top">
        <div class="container">
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6  header-login">
                    <ul>
                        @if(empty($current_user))
                        <li><a href="/login">{{trans('client.login')}}</a></li>
                        <li><a href="/register">{{trans('client.register')}}</a></li>
                        @else
                            <li>
                                {{trans('client.hello')}}, {{$current_user['first_name'] or $current_user['email']}}
                                <a href="/my-profile">{{trans('client.my-account')}}</a>
                            </li>
                            <li><a href="/my-orders">{{trans('client.my-orders')}}</a></li>
                            <li><a href="/logout">{{trans('client.logout')}}</a></li>
                        @endif
                    </ul>
            </div>

            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 header-social">
                <ul>
                    <li>
                        <a href="#">
                            <i class="fa fa-facebook-square" aria-hidden="true"></i>
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <i class="fa fa-google-plus-square" aria-hidden="true"></i>
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <i class="fa fa-twitter-square" aria-hidden="true"></i>
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <i class="fa fa-linkedin-square" aria-hidden="true"></i>
                        </a>
                    </li>
                </ul>

            </div>
            <div class="clearfix"></div>
        </div>
    </div>

    <div class="container">
        <div class="head-top">


            <div class="head-main">
                <div class="col-xs-12 col-sm-12 col-md-4 col-lg-3 text-center no-padding">

                    <a href="/" class="logo"><img src="/images/logo.png" alt="{{$sys['title'] or ''}}" class="img-responsive"></a>
                    <div class="clearfix"></div>
                </div>

                <div class="col-xs-12 col-sm-12 col-md-4 col-lg-7 text-center height-full">

                    <div class="search">
                        <form method="get" action="/search">
                            <input type="text" name="q" placeholder="{{trans('client.search')}}..."/>
                            <button type="submit">
                                <i class="fa fa-search"></i>
                            </button>
                        </form>
                        <div class="clearfix"></div>
                    </div>
                </div>

                <div class="col-xs-12 col-sm-12 col-md-4 col-lg-2 text-center no-padding">
                    <div class="cart box_1 header-cart"
                         title="{{trans('client.preview_cart')}}"
                         data-toggle="tooltip"
                         data-placement="left">
                        <a href="/cart" class="cart-preview">
                            <img src="{{ Theme::asset('dressplace::images/cart.png') }}" alt=""/>
                        </a>
                        <a href="/cart" class="cart-preview">
                            {{trans('client.cart')}} <br/>
                            <div class="total">
                                <span class="cart_total">{{$cart_total or 0}} {{trans('client.currency')}} ({{$cart_items or 0}})</span>
                            </div>
                        </a>
                    </div>
                    <div class="clearfix"></div>
                </div>

                <div class="clearfix"></div>

            </div>
            <div class="clearfix"></div>

            <div class="col-sm-12 no-padding">
                <nav id="menu">
                    <label for="tm" id="toggle-menu">{{trans('client.navigation')}} <span class="drop-icon"><i class="fa fa-caret-down"></i></span></label>
                    <input type="checkbox" id="tm">
                    <ul class="main-menu clearfix">
                        @if(!empty($main_categories) && is_array($main_categories))
                            @foreach($main_categories as $key => $main_category)
                                <li>
                                    <a href="/{{$main_category['slug']}}" class="main-category">
                                        {{$main_category['title'] or ''}}
                                        @if(!empty($second_level_categories[$main_category['id']]) && is_array($second_level_categories[$main_category['id']]))
                                            <span class="drop-icon"><i class="fa fa-caret-down"></i></span>
                                            <label class="drop-icon" for="{{$main_category['id'] or ''}}"><i class="fa fa-caret-down"></i></label>
                                        @endif
                                    </a>
                                    <input type="checkbox" id="{{$main_category['id'] or ''}}"/>

                                    @if(!empty($second_level_categories[$main_category['id']]) && is_array($second_level_categories[$main_category['id']]))
                                        <ul class="sub-menu" class="second-level-category">
                                            @foreach($second_level_categories[$main_category['id']] as $second_level_category)
                                                <li>
                                                    <a href="/{{$second_level_category['slug']}}">
                                                        {{$second_level_category['title'] or ''}}
                                                        @if(!empty($third_level_categories[$second_level_category['id']]) && is_array($third_level_categories[$second_level_category['id']]))
                                                            <span class="drop-icon"><i class="fa fa-caret-right"></i></span>
                                                            <label class="drop-icon" for="{{$second_level_category['id'] or ''}}"><i class="fa fa-caret-down"></i></label>
                                                        @endif
                                                    </a>
                                                    <input type="checkbox" id="{{$second_level_category['id'] or ''}}"/>

                                                    @if(!empty($third_level_categories[$second_level_category['id']]) && is_array($third_level_categories[$second_level_category['id']]))
                                                        <ul class="sub-menu">
                                                            @foreach($third_level_categories[$second_level_category['id']] as $th_key => $third_level_category)
                                                                <li>
                                                                    <a href="/{{$third_level_category['slug']}}" class="third-level-category">
                                                                        {{$third_level_category['title'] or ''}}
                                                                    </a>
                                                                </li>
                                                            @endforeach
                                                        </ul>
                                                    @endif

                                                </li>
                                            @endforeach
                                        </ul>
                                    @endif

                                </li>

                            @endforeach
                        @endif
                    </ul>
                </nav>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
</div>
<!--HEADER END -->