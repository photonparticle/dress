<!DOCTYPE html>
<html lang="bg">
<head>
    <meta charset="utf-8"/>
    <title>{{trans('client.register_mail')}} - {{$sys['title']}}</title>

    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0"/>

    <!-- google fonts -->
    <link href='https://fonts.googleapis.com/css?family=Roboto:400,300,300italic,100italic,100,400italic,500,500italic,700,700italic,900,900italic&subset=latin,cyrillic' rel='stylesheet' type='text/css'>

    <!-- font-awesome css -->
    <link rel="stylesheet" href="{{ Theme::asset('dressplace::css/font-awesome.min.css') }}">

    <style>
        footer h1,
        footer h2,
        footer h3,
        footer h4,
        footer h5,
        footer h6 {
            margin: 5px 0 2px 0;
            font-size: 1.2em;
        }
    </style>

</head>
<body style="padding: 0 !important; margin: 0 !important; font-family: Roboto; font-size: 14px;">
<header style="max-width: 940px; margin: 0 auto;">
    <div style="width: 100%; padding: 20px 0; margin-bottom: 10px; text-align: center">
        <a href="{{url('/')}}" title="{{trans('client.home')}}" style="display: inline-block">
            <img src="{{url('/images/logo.png')}}" alt="{{$sys['title']}}" style="display: inline-block"/>
        </a>
    </div>
</header>

<main style="text-align: center">
    <div style="max-width: 940px; width: 100%; display: inline-block;">

        <div style="width: 80%; max-width: 80%; display: inline-block; background-color: #418dda;padding: 35px 20px;">

            <div style="width: 100%; display: inline-block; vertical-align: middle; margin-right: 20px">
                <img src="{{url('images/emails/register.png')}}" alt="{{trans('client.register_mail')}}"/>
            </div>
            <div style="width: 100%; display: inline-block; vertical-align: middle; margin-right: 20px">
                <h1 style="color: #fff; text-align: center; text-transform: uppercase; margin-top: 0;">
                    {{trans('client.register_mail')}}
                </h1>

                <hr style="border: 1px solid #fff" />

                <div style="padding: 0 20px 20px 20px;">
                    <h2 style="color: #fff; text-align: center; margin-top: 0;">{{trans('client.register_mail_tip')}} {{$sys['title']}}</h2>
                    <h2 style="color: #fff; text-align: center; margin-top: 0;">{{trans('client.register_mail_tip_2')}}</h2>

                    <hr style="border: 1px solid #fff" />

                    <h2 style="color: #fff; text-align: center; margin: 0;">{{trans('client.register_mail_tip_3')}}</h2>
                    <a href="{{url('/login')}}" style="color: #fff; font-size: 1.5em">
                        {{url('/login')}}
                    </a>
                </div>
            </div>
        </div>
    </div>

    </div>
</main>

<footer style="max-width: 940px; margin: 0 auto;">
    <div style="width: 100%; background: #2d2d2d none repeat scroll 0 0; padding: 50px 0; margin-top: 25px;">

        <div style="max-width: 940px; margin: 0 auto; text-align: center">
            <img src="/images/logo.png" alt=""/>

            <div class="widget-icon">
                @if(!empty($sys['social_facebook']))
                    <a href="{{$sys['social_facebook'] or '#'}}" style="border: 1px solid #d5d5d5; color: #d5d5d5; display: inline-block; line-height: 32px; text-align: center; width: 32px; margin: 5px;" target="_blank"><i style="font-size:18px; line-height: 32px;" class="fa fa-facebook" aria-hidden="true"></i></a>
                @endif
                @if(!empty($sys['social_twitter']))
                    <a href="{{$sys['social_twitter'] or '#'}}" style="border: 1px solid #d5d5d5; color: #d5d5d5; display: inline-block; line-height: 32px; text-align: center; width: 32px; margin: 5px;" target="_blank"><i style="font-size:18px; line-height: 32px;" class="fa fa-twitter" aria-hidden="true"></i></a>
                @endif
                @if(!empty($sys['social_google_plus']))
                    <a href="{{$sys['social_google_plus'] or '#'}}" style="border: 1px solid #d5d5d5; color: #d5d5d5; display: inline-block; line-height: 32px; text-align: center; width: 32px; margin: 5px;" target="_blank"><i style="font-size:18px; line-height: 32px;" class="fa fa-google-plus" aria-hidden="true"></i></a>
                @endif
                @if(!empty($sys['social_pinterest']))
                    <a href="{{$sys['social_pinterest'] or '#'}}" style="border: 1px solid #d5d5d5; color: #d5d5d5; display: inline-block; line-height: 32px; text-align: center; width: 32px; margin: 5px;" target="_blank"><i style="font-size:18px; line-height: 32px;" class="fa fa-pinterest" aria-hidden="true"></i></a>
                @endif
                @if(!empty($sys['social_youtube']))
                    <a href="{{$sys['social_youtube'] or '#'}}" style="border: 1px solid #d5d5d5; color: #d5d5d5; display: inline-block; line-height: 32px; text-align: center; width: 32px; margin: 5px;" target="_blank"><i style="font-size:18px; line-height: 32px;" class="fa fa-youtube" aria-hidden="true"></i></a>
                @endif
                @if(!empty($sys['social_blog']))
                    <a href="{{$sys['social_blog'] or '#'}}" style="border: 1px solid #d5d5d5; color: #d5d5d5; display: inline-block; line-height: 32px; text-align: center; width: 32px; margin: 5px;" target="_blank"><i style="font-size:18px; line-height: 32px;" class="fa fa-rss-square" aria-hidden="true"></i></a>
                @endif
                <a href="/rss" style="border: 1px solid #d5d5d5; color: #d5d5d5; display: inline-block; line-height: 32px; text-align: center; width: 32px; margin: 5px;" target="_blank"><i style="font-size:18px; line-height: 32px;" class="fa fa-rss" aria-hidden="true"></i></a>
            </div>

            <h3 style="color: #fff; font-size: 24px;">{{trans('client.contact_us')}}</h3>
            <ul style="list-style: none; color: #fff;  margin: 0; padding: 0;">
                @if(!empty($sys['email']))
                    <li>
                        <h3>
                            <i class="fa fa-envelope"> </i> &nbsp;
                            {{$sys['email']}}
                        </h3>
                    </li>
                @endif
                @if(!empty($sys['phone']))
                    <li>
                        <h3>
                            <i class="fa fa-phone"> </i> &nbsp;
                            {{$sys['phone']}}
                        </h3>
                    </li>
                @endif
                @if(!empty($sys['work_time']))
                    <li class="work_time">
                        <div style="display: inline-block; vertical-align: top">
                            <h3><i class="fa fa-clock-o"> </i> &nbsp; {{trans('client.work_time')}}</h3>
                            {!! preg_replace('/(<[^>]+) style=".*?"/i', '$1', $sys['work_time']) !!}
                        </div>
                    </li>
                @endif
            </ul>
        </div>
    </div>
</footer>
</body>
</html>