<div class="container banner-actions hidden-xs hidden-sm hidden-md">
    <div class="row">
        <div class="col-lg-4">
            <div class="box free-delivery">
                <div class="icon pull-right">
                </div>
                <h3>{{trans('client.banner-free-delivery-title')}}</h3>
                <h5>{{trans('client.banner-free-delivery-subtitle')}} {{$sys['delivery_free_delivery'] or '0'}} {{trans('client.currency')}}</h5>
                <p>
                    {{trans('client.banner-free-delivery-text-1')}}
                    {{$sys['delivery_free_delivery'] or '0'}} {{trans('client.currency')}} <br/>
                    {{trans('client.to_address_long')}} <strong> {{$sys['delivery_to_address'] or '0'}} {{trans('client.currency')}}</strong><br/>
                    {{trans('client.to_office_long')}} <strong> {{$sys['delivery_to_office'] or '0'}} {{trans('client.currency')}}</strong>
                </p>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="box returns">
                <div class="icon pull-right">
                </div>
                <h3>{{trans('client.banner-returns-title')}}</h3>
                <h5>{{trans('client.banner-returns-subtitle')}}</h5>

                <p>
                    <i class="fa fa-check" aria-hidden="true"></i> {{trans('client.banner-returns-text-1')}} <br/>
                    <i class="fa fa-check" aria-hidden="true"></i> {{trans('client.banner-returns-text-2')}} <br/>
                    <i class="fa fa-check" aria-hidden="true"></i> {{trans('client.banner-returns-text-3')}}
                </p>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="box call-us">
                <div class="icon pull-right">
                </div>
                <h3>{{trans('client.banner-call-us-title')}}</h3>
                <h5>{{trans('client.banner-call-us-subtitle')}}</h5>
                <p>
                    <i class="fa fa-phone-square" aria-hidden="true"></i>
                    <a href="tel:{{$sys['phone'] or ''}}"
                       title="{{trans('client.call-us')}}"
                       data-toggle="tooltip" data-placement="top"
                    >{{$sys['phone'] or ''}}</a>
                    <br/>
                    <i class="fa fa-envelope" aria-hidden="true"></i>
                    <a href="mailto:{{$sys['email'] or ''}}"
                       title="{{trans('client.mail-us')}}"
                       data-toggle="tooltip" data-placement="top"
                    >
                        {{$sys['email'] or ''}}
                    </a>
                    <br/>
                    <i class="fa fa-facebook-official" aria-hidden="true"></i>
                    <a href="#"
                    >
                        {{trans('client.banner-call-us-text-fb')}}
                    </a>
                </p>
            </div>
        </div>
    </div>
</div>