<header>
    <!-- header-top-area start -->
    <div class="header-top-area bg-color">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-4">
                    <div class="welcome">
                        @if(!empty($sys['phone']))
                            <span class="phone">{{$sys['phone'] or ''}}</span> <span>/</span>
                        @endif
                        @if(!empty($sys['email']))
                            <span class="email">{{$sys['email'] or ''}}</span>
                        @endif
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-8">
                    <div class="top-menu">
                        <ul>
                            @if(empty($current_user))
                                <li><a href="/login">{{trans('client.login')}}</a></li>
                                <li><a href="/register">{{trans('client.register')}}</a></li>
                            @else
                                <li><a href="/my-profile">{{trans('client.my-account')}}</a></li>
                                <li><a href="/my-orders">{{trans('client.my-orders')}}</a></li>
                                <li><a href="/logout">{{trans('client.logout')}}</a></li>
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- header-top-area end -->
    <!-- header-bottom-area start -->
    <div class="header-bottom-area">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                    <div class="logo margin-top-10">
                        <a href="/"><img src="/images/logo.png" alt="{{$sys['title'] or ''}}"/></a>
                    </div>
                </div>
                <div class="col-lg-6 col-md-5 col-sm-5 col-xs-12">
                    <div class="header-search margin-top-10">
                        <input type="text" placeholder="{{trans('client.search')}}"/>
                        <button><i class="fa fa-search"></i></button>
                    </div>
                </div>
                <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12 pad-left">
                    <div class="total-cart">
                        <div class="cart-toggler">
                            <a href="/cart">
                                <div class="icon">
                                    <div class="count"><span>{{$cart_items}}</span></div>
                                </div>
                                <div class="texts">
                                    <span class="cart_title">{{trans('client.cart')}}</span>
                                    <span class="cart_data">{{trans('client.products')}} - <span>{{$cart_total}}</span> {{trans('client.currency')}}</span>
                                </div>
                            </a>
                        </div>
                        <ul class="cart-items-drop">
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- header-bottom-area end -->
    <!-- main-menu-area start -->
    <div class="main-menu-area bg-color hidden-xs">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <div class="main-menu">
                        <nav>
                            <ul>
                                @if(!empty($main_categories) && is_array($main_categories))
                                    @foreach($main_categories as $key => $main_category)
                                        <li>
                                            <a href="/{{$main_category['slug']}}">
                                                {{$main_category['title'] or ''}}
                                            </a>
                                            @if(!empty($second_level_categories[$main_category['id']]) && is_array($second_level_categories[$main_category['id']]))
                                                <ul>
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
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- main-menu-area end -->
    <!-- mobile-menu-area start -->
    <div class="mobile-menu-area visible-xs">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="mobile-menu">
                        <nav id="dropdown">
                            <ul>
                                @if(!empty($main_categories) && is_array($main_categories))
                                    @foreach($main_categories as $key => $main_category)
                                        <li>
                                            <a href="/{{$main_category['slug']}}">
                                                {{$main_category['title'] or ''}}
                                            </a>
                                            @if(!empty($second_level_categories[$main_category['id']]) && is_array($second_level_categories[$main_category['id']]))
                                                <ul>
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
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- mobile-menu-area end -->
</header>