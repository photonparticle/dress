<div class="col-md-6 col-sm-12">
    <div class="portlet yellow-crusta box">
        <div class="portlet-title">
            <div class="caption">
                <i class="fa fa-comments"></i>{{trans('orders.comments')}}
            </div>
        </div>
        <div class="portlet-body">

            {{--LOCKED FORM--}}
            @if(empty($method) || !empty($method) && $method == 'locked')
                <div class="locked-form-details">
                    <div class="row static-info">
                        <div class="col-md-12 value">
                            {{$order['comment'] or ''}}
                        </div>

                    </div>
                </div>
            @endif

            {{--UNLOCKED FORM--}}
            @if(!empty($method) && $method == 'unlocked')
                <div class="edit-form-details">
                    <div class="form-group form-md-line-input has-warning form-md-floating-label padding-60 margin-top-10">
                        <textarea id="comment" name="comment" class="form-control" rows="3">{{$order['comment'] or ''}}</textarea>
                        <label for="comment">{{trans('orders.msgtoorder')}}</label>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>