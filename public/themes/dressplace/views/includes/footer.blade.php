<!-- footer start -->
<footer>
    <!-- footer-top-area start -->
    <div class="footer-top-area">
        <div class="container">
            <div class="row">
                <!-- footer-widget start -->
                <div class="col-lg-3 col-md-3 col-sm-4">
                    <div class="footer-widget">
                        <img src="/images/logo.png" alt=""/>
                        <p>

                        </p>
                        <div class="widget-icon">
                            <a href="#"><i class="fa fa-facebook"></i></a>
                            <a href="#"><i class="fa fa-twitter"></i></a>
                            <a href="#"><i class="fa fa-linkedin"></i></a>
                            <a href="#"><i class="fa fa-google-plus"></i></a>
                        </div>

                    </div>
                </div>
                <!-- footer-widget end -->
                <!-- footer-widget start -->
                <div class="col-lg-3 col-md-3 col-sm-4">
                    <div class="footer-widget">
                        <h3>{{trans('client.information')}}</h3>
                        <ul class="footer-menu">
                            <li><a href="/contact">{{trans('client.contact_us')}}</a></li>
                            @if(!empty($footer_pages) && is_array($footer_pages))
                                @foreach($footer_pages as $page)
                                    <li><a href="{{$page['slug']}}">{{$page['title']}}</a></li>
                                @endforeach
                            @endif
                        </ul>
                    </div>
                </div>
                <!-- footer-widget end -->
                <!-- footer-widget start -->
                <div class="col-lg-3 col-md-3 col-sm-4 hidden-sm">
                    <div class="footer-widget">
                        <h3>{{trans('client.my-account')}}</h3>
                        <ul class="footer-menu">
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
                </div>
                <!-- footer-widget end -->
                <!-- footer-widget start -->
                <div class="col-lg-3 col-md-3 col-sm-4">
                    <div class="footer-widget">
                        <h3>{{trans('client.contact_us')}}</h3>
                        <ul class="footer-contact">
                            @if(!empty($sys['email']))
                                <li>
                                    <i class="fa fa-envelope"> </i>
                                    {{$sys['email']}}
                                </li>
                            @endif
                            @if(!empty($sys['phone']))
                                <li>
                                    <i class="fa fa-phone"> </i>
                                    {{$sys['phone']}}
                                </li>
                            @endif
                            @if(!empty($sys['work_time']))
                                <li class="work_time">
                                    <div>
                                        <i class="fa fa-clock-o"> </i>
                                    </div>
                                    <div>
                                        {!! $sys['work_time'] or '' !!}
                                    </div>
                                </li>
                            @endif
                        </ul>
                    </div>
                </div>
                <!-- footer-widget end -->
            </div>
        </div>
    </div>
    <!-- footer-top-area end -->
    <!-- footer-bottom-area start -->
    @if(!empty($sys['title']))
        <div class="footer-bottom-area">
            <div class="container">
                <div class="row">
                    <div class="col-xs-12 text-center">
                        <div class="copyright">
                            <p>&copy; {{date('Y')}} <a href="/">{{$sys['title'] or ''}}</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif
                <!-- footer-bottom-area end -->
</footer>
<!-- footer end -->