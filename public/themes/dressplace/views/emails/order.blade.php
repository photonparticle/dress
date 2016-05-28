<!DOCTYPE html>
<html lang="bg">
<head>
    <meta charset="utf-8"/>
    <title>{{trans('client.order_completed')}} - {{$sys['title']}}</title>

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
<header>
    <div style="width: 100%; padding: 20px 0; margin-bottom: 10px; text-align: center">
        <a href="{{url('/')}}" title="{{trans('client.home')}}" style="display: inline-block">
            <img src="{{url('/images/logo.png')}}" alt="{{$sys['title']}}" style="display: inline-block"/>
        </a>
    </div>
</header>

<main>
    <div style="max-width: 940px; width: 100%; margin: 0 auto">

        <div style="width: 80%; max-width: 80%; margin: 0 auto;background-color: #418dda;padding: 35px 20px; text-align: center">

            <div>
                <div style="display: inline-block; vertical-align: middle; margin-right: 20px">
                    <img src="{{url('images/emails/order.png')}}" alt="{{trans('client.order_completed')}}"/>
                </div>
                <div style="display: inline-block; vertical-align: middle">
                    <h1 style="color: #fff; text-align: center; text-transform: uppercase; margin-top: 0;">{{trans('client.order_completed')}}</h1>
                    <h2 style="color: #fff; text-align: center; text-transform: uppercase; margin-top: 0;">{{trans('client.order_completed_tip')}}</h2>
                </div>
            </div>
            <hr style="border: 1px solid #fff; width: 90%;"/>

            <h3 style="font-size: 18px; color: #fff;">{{trans('client.order_completed_text_1')}}</h3>
            <h3 style="font-size: 18px; color: #fff;">{{trans('client.order_completed_text_2')}}</h3>

            <h4 style="font-size: 16px; margin-bottom: 5px; color: #fff;">{{trans('client.order_completed_text_3')}}</h4>
            <a href="{{url('/checkout/completed/' . $order['id'])}}" style="color: #fff;">{{url('/checkout/completed/' . $order['id'])}}</a>
        </div>

        <div style="width: 80%; max-width: 80%; margin: 0 auto;padding: 35px 20px">
            <table style="width: 100%;">
                <tr>
                    <td style="width: 50%; vertical-align: top">
                        <h4 style="color: #418dda; margin: 15px 0 5px 0; font-weight: 400; font-size: 18px; font-family: inherit; line-height: 1.1;">
                            {{trans('client.order_number')}}
                        </h4>
                        #{{$order_id or ''}}

                        @if(!empty($order['status']))
                            <h4 style="color: #418dda; margin: 15px 0 5px 0; font-weight: 400; font-size: 18px; font-family: inherit; line-height: 1.1;">
                                {{trans('client.order_status')}}
                            </h4>
                        @endif

                        <h4 style="color: #418dda; margin: 15px 0 5px 0; font-weight: 400; font-size: 18px; font-family: inherit; line-height: 1.1;">
                            {{trans('client.date_create')}}
                        </h4>
                        {{$date_created or ''}}

                        <h4 style="color: #418dda; margin: 15px 0 5px 0; font-weight: 400; font-size: 18px; font-family: inherit; line-height: 1.1;">
                            {{trans('client.total_payable')}}
                        </h4>
                        {{$order_total or 0}} {{trans('client.currency')}}

                        <h4 style="color: #418dda; margin: 15px 0 5px 0; font-weight: 400; font-size: 18px; font-family: inherit; line-height: 1.1;">
                            {{trans('client.delivery_type')}}
                        </h4>
                        {{trans('client.' . $delivery_type . '_long')}}
                    </td>

                    <td style="width: 50%; vertical-align: top; text-align: right">
                        <h4 style="color: #418dda; margin: 15px 0 5px 0; font-weight: 400; font-size: 18px; font-family: inherit; line-height: 1.1;">
                            {{trans('client.info_order')}}
                        </h4>
                        @if(!empty($order['email']))
                            {{$order['email'] or ''}}
                        @endif

                        @if(!empty($order['name']))
                            <br/>{{$order['name'] or ''}}
                        @endif

                        @if(!empty($order['last_name']))
                            {{$order['last_name'] or ''}}
                        @endif

                        @if(!empty($order['phone']))
                            <br/>{{$order['phone'] or ''}}
                        @endif

                        @if(!empty($order['address']))
                            <br/>{{$order['address'] or ''}}
                        @endif

                        @if(!empty($order['city']))
                            <br/>{{$order['city'] or ''}}
                        @endif

                        @if(!empty($order['state']))
                            , {{trans('orders.'.$order['state'] . '')}}
                        @endif

                        @if(!empty($order['post_code']))
                            <br/>{{$order['post_code'] or ''}}
                        @endif

                        @if(!empty($order['comment']))
                            <h4 style="color: #418dda; margin: 15px 0 5px 0; font-weight: 400; font-size: 18px; font-family: inherit; line-height: 1.1;">
                                {{trans('client.comment')}}
                            </h4>
                            {{$order['comment'] or ''}}
                        @endif
                    </td>
                </tr>
            </table>
        </div>

        <div style="overflow: auto; width: 80%; max-width: 80%; margin: 20px auto;">
            <table style="margin: 25px auto; background-color: transparent; border-collapse: collapse;
   				 border-spacing: 0; outline: none; box-sizing: border-box; display: table; border-color: grey;  font-size: 14px; line-height: 1.42857143; box-sizing: border-box;">
                <tbody style="display: table-row-group; vertical-align: middle; border-color: inherit; ">


                <tr style="display: table-row; vertical-align: inherit; padding: 8px; vertical-align: top; border-top: 1px solid #ddd;">
                    <th style=" text-align: left; font-weight: bold; display: table-cell;"></th>
                    <th style="padding-left: 15px !important;">{{trans('client.product')}}</th>
                    <th style="text-align: center; font-weight: bold; display: table-cell;">{{trans('client.price')}}</th>
                    <th style="text-align: center; font-weight: bold; display: table-cell;">{{trans('client.subtotal')}}</th>
                </tr>

                @foreach($cart as $key => $item)
                    <tr style="display: table-row; vertical-align: inherit; border-color: inherit; border-top: 1px solid #ddd;">

                        {{--IMAGE--}}
                        <td style="max-width: 100px; display: table-cell; text-align: center">
                            <a href="{{url('/' . $products[$item['product_id']]['slug'])}}" style="text-decoration: none; color: #222;">
                                <img src="{{url($thumbs_path . $item['product_id'] . '/' . $icon_size . '/' .  $products[$item['product_id']]['image'])}}"
                                     alt=""
                                     style="vertical-align: middle; border: 0; max-width: 100px; margin-top: 10px"
                                />
                            </a>
                        </td>

                        {{--PRODUCT--}}
                        <td style="padding: 0 0 0 15px !important; text-align: left; display: table-cell;">
                            <h3 style="margin: 0 !important; color: #232323; font-weight: 400; font-size: 24px; display: block; text-align: left;">
                                <a href="{{url('/' . $products[$item['product_id']]['slug'])}}" style="text-decoration: none; color: #222; background-color: transparent; font-weight: 400; font-size: 24px; font-family: inherit; line-height: 1.1;">
                                    {{$products[$item['product_id']]['title'] or ''}}
                                </a>
                            </h3>

                            <h4 style="margin-top: 10px; margin: 0 0 10px; color: #232323; font-weight: 400; font-size: 18px; line-height: 1.1; font-family: inherit;">
                                {{trans('client.size')}}
                            </h4>
                            <p style="margin: 0 !important; display: block; text-align: left;">
                                {{$item['size'] or ''}}
                            </p>

                            <div style="clear: both; width: 100%; display: block; padding: 0 !important; margin: 0 !important; text-align: left; font-size: 14px; box-sizing: border-box; display: table; border-collapse: collapse;"></div>

                            <h4 style="margin-top: 10px; margin: 0 0 10px; color: #232323; font-weight: 400; font-size: 18px; font-family: inherit; line-height: 1.1; text-align: left;">
                                {{trans('client.quantity')}}
                            </h4>
                            <p style="float: none; margin: 0 !important; text-align: left; border-collapse: collapse;">
                                {{$item['quantity'] or 1}}
                            </p>
                            <div style="clear: both; width: 100%; display: block; padding: 0 !important; margin: 0 !important; text-align: left;"></div>
                        </td>

                        <td style="font-size: 1.2em !important; padding: 8px; line-height: 1.42857143; text-align: center; display: table-cell;">
                            <p style="margin: 0 0 15px; font-size: 1.2em !important;">
                                @if(
                                                                    !empty($item['discount']) &&
                                                                    !empty($item['discount_price']) &&
                                                                    !empty($item['active_discount']))
                                    <em style="color: #418dda; font-size: 1.2em !important">{{$item['discount_price'] or ''}} {{trans('client.currency')}}</em>
                                    <em style="color: #666; font-size: 0.9em; font-weight: 400; margin-left: 6px; text-decoration: line-through;">{{$item['price'] or ''}} {{trans('client.currency')}}</em>
                                @else
                                    <em style="color: #418dda; font-size: 1.1em !important">{{$item['price'] or ''}} {{trans('client.currency')}}</em>
                                @endif

                                @if(
                                !empty($item['discount']) &&
                                !empty($item['discount_price']) &&
                                !empty($item['active_discount']))
                                    <em style="color: #666; font-size: 1.1em; margin-right: 6px; line-height: 20px;"><span>-<span>{{$item['discount'] or ''}}</span>%</span></em>
                                @endif
                            </p>
                        </td>

                        <td style="font-size: 1.2em !important; padding: 8px; line-height: 1.42857143; text-align: center;">
                            <p style="margin: 0 0 15px; font-size: 1.2em !important; text-align: center; ">
                                {{$item['subtotal'] or 0}} {{trans('client.currency')}}
                            </p>
                        </td>
                    </tr>
                @endforeach

                </tbody>
            </table>

            <table style="width: 100%; max-width: 100%; margin-bottom: 20px;">
                <tbody style="display: table-row-group; vertical-align: middle;">

                <tr>
                    <td style="text-align: right; padding: 8px; line-height: 1.42857143; vertical-align: top;">
                        <h4 style="margin-top: 10px; margin: 0 0 10px; color: #232323; font-weight: 400; font-size: 18px; font-family: inherit; line-height: 1.1;">
                            {{trans('client.subtotal')}}
                        </h4>
                    </td>
                    <td style="width: 70px; padding: 8px; line-height: 1.42857143; vertical-align: top;">
                        <h4 style="margin-top: 10px; margin: 0 0 10px; color: #232323; font-weight: 400; font-size: 18px; font-family: inherit; line-height: 1.1; box-sizing: border-box; border-collapse: collapse;">
                            <span style="outline: none; color: #232323; font-weight: 400; font-size: 18px; font-family: inherit; line-height: 1.1;">
                                {{$total}}
                            </span>
                            <span style="outline: none; color: #232323; font-weight: 400; font-size: 18px; font-family: inherit; line-height: 1.1;">
                                {{trans('client.currency')}}
                            </span>
                        </h4>
                    </td>
                </tr>

                <tr style="outline: none;">
                    <td style="text-align: right; padding: 8px; line-height: 1.42857143; vertical-align: top;">
                        <h4 style="margin-top: 10px; margin: 0 0 10px; color: #232323; font-weight: 400; font-size: 18px; font-family: inherit; line-height: 1.1;">
                            {{trans('client.delivery_price')}}
                        </h4>
                    </td>
                    <td style="width: 70px; padding: 8px; line-height: 1.42857143; vertical-align: top;">
                        @if(!empty($delivery_cost) && $delivery_cost > 0)
                            <div class="delivery_price">
                                <h4 style="margin-top: 10px; margin: 0 0 10px; color: #232323; font-weight: 400; font-size: 18px;   font-family: inherit; line-height: 1.1;">
                                    <span class="delivery_price">{{$delivery_cost}}</span> <span>{{trans('client.currency')}}</span>
                                </h4>
                            </div>
                        @else
                            <span class="delivery_price_free" style="color: #418dda">{{trans('client.free')}}<br/>{{trans('client.delivery')}}</span>
                        @endif
                    </td>
                </tr>

                <tr style="outline: none;">
                    <td style="text-align: right; padding: 8px; line-height: 1.42857143; vertical-align: top">
                        <h4 style="margin-top: 10px; margin: 0 0 10px; color: #232323; font-weight: 400; font-size: 18px;   font-family: inherit; line-height: 1.1;">
                            {{trans('client.total')}}
                        </h4>
                    </td>
                    <td style="width: 70px; padding: 8px; line-height: 1.42857143; vertical-align: top">
                        <h4 style="margin-top: 10px; margin: 0 0 10px; color: #232323; font-weight: 400; font-size: 18px;   font-family: inherit; line-height: 1.1;">
                            <span>{{$order_total}}</span> <span>{{trans('client.currency')}}</span>
                        </h4>
                    </td>
                </tr>

                </tbody>
            </table>

            <div style="clear: both; width: 100%; display: block; padding: 0 !important; margin: 0 !important; outline: none; clear: both;"></div>
        </div>
    </div>
</main>


<footer>
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