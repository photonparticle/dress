<!--HEADER START -->
<div class="header">
    <div class="header-top">
        <div class="container">
            <div class="col-sm-5  header-login">
                <ul>
                    <li><a href="login.html">Login</a></li>
                    <li><a href="register.html">Register</a></li>
                    <li><a href="checkout.html">Checkout</a></li>
                </ul>
            </div>

            <div class="col-sm-5 col-md-offset-2 header-social">
                <ul>
                    <li><a href="#"><i></i></a></li>
                    <li><a href="#"><i class="ic1"></i></a></li>
                    <li><a href="#"><i class="ic2"></i></a></li>
                    <li><a href="#"><i class="ic3"></i></a></li>
                    <li><a href="#"><i class="ic4"></i></a></li>
                </ul>

            </div>
            <div class="clearfix"></div>
        </div>
    </div>

    <div class="container">
        <div class="head-top">


            <div class="head-main">
                <div class="col-xs-12 col-sm-4 col-md-3 col-lg-2">
                    <div class="logo">
                        <a href="/"><img src="/images/logo.png" alt=""></a>
                    </div>
                </div>

                <div class="col-xs-12 col-sm-8 col-md-9 col-lg-10">
                    <div class="cart box_1">
                        <a href="checkout.html">
                            <h3>
                                <div class="total">
                                    <span class="simpleCart_total"></span></div>
                                <img src="{{ Theme::asset('dressplace::images/cart.png') }}" alt=""/></h3>
                        </a>
                        <p><a href="javascript:;" class="simpleCart_empty">Empty Cart</a></p>

                    </div>
                    <ul class="heart">
                        <li>
                            <a href="wishlist.html">
                                <span class="glyphicon glyphicon-heart" aria-hidden="true"></span>
                            </a></li>
                        <li><a class="play-icon popup-with-zoom-anim" href="#small-dialog"><i class="glyphicon glyphicon-search"> </i></a></li>
                    </ul>
                    <div class="clearfix"></div>

                    <!----->

                    <!---//pop-up-box---->
                    <div id="small-dialog" class="mfp-hide">
                        <div class="search-top">
                            <div class="login-search">
                                <input type="submit" value="">
                                <input type="text" value="Search.." onfocus="this.value = '';" onblur="if (this.value == '') {this.value = 'Search..';}">
                            </div>
                            <p>Shopin</p>
                        </div>
                    </div>
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