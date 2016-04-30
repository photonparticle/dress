<div class="footer">
    <div class="footer-middle">
        <div class="container">
            <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 footer-middle-in">
                <a href="/">
                    <img src="/images/logo.png" alt="" class="img-responsive"/>
                </a>
                @if(!empty($sys['work_time']))
                    <h3 class="margin-top-10">{{trans('client.work_time')}}</h3>
                    <p>
                        {!! $sys['work_time'] or '' !!}
                    </p>
                @endif
            </div>

            <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 footer-middle-in">
                <h6>{{trans('client.information')}}</h6>
                <ul class=" in">
                    <li><a href="/contact">{{trans('client.contact_us')}}</a></li>
                    @if(!empty($footer_pages) && is_array($footer_pages))
                        @foreach($footer_pages as $page)
                            <li><a href="{{$page['slug']}}">{{$page['title']}}</a></li>
                        @endforeach
                    @endif
                </ul>
                <div class="clearfix"></div>
            </div>

            <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 footer-middle-in">
                <h6>{{trans('client.my-account')}}</h6>
                <ul class=" in">
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
                <div class="clearfix"></div>
            </div>
            {{--<div class="col-md-4 footer-middle-in">--}}
            {{--<h6>Tags</h6>--}}
            {{--</div>--}}
            <div class="clearfix"></div>
        </div>
    </div>
    <div class="footer-bottom">
        <div class="container">
            <ul class="footer-bottom-top">
                {{--<li><a href="#"><img src="/images/f1.png" class="img-responsive" alt=""></a></li>--}}
                {{--<li><a href="#"><img src="/images/f2.png" class="img-responsive" alt=""></a></li>--}}
                {{--<li><a href="#"><img src="/images/f3.png" class="img-responsive" alt=""></a></li>--}}
            </ul>
            <p class="footer-class">&copy; {{date('Y')}} <a href="/">{{$sys['title']}}</a></p>
            <div class="clearfix"></div>
        </div>
    </div>
</div>
<!--//footer-->