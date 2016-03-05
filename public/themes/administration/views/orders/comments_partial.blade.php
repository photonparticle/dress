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
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis dignissim odio non vulputate malesuada. Nulla sed orci pulvinar, pretium nunc at, feugiat massa. In nec erat sem. Vivamus dignissim, metus ut laoreet venenatis, purus odio luctus ante, et pellentesque libero risus a augue. Aliquam quis urna pulvinar, luctus nulla eu, sagittis enim. Donec pellentesque sit amet nunc et auctor. In mattis, mi sed laoreet malesuada, mi lorem luctus tellus, interdum luctus est dui scelerisque neque. Donec nec imperdiet sem. Praesent sapien nisl, dictum nec tortor at, iaculis efficitur nisl.
                        </div>

                    </div>
                </div>
            @endif

            {{--UNLOCKED FORM--}}
            @if(!empty($method) && $method == 'unlocked')
                <div class="edit-form-details">
                    <div class="form-group form-md-line-input has-warning form-md-floating-label padding-60 margin-top-10">
                        <textarea id="comment" name="comment" class="form-control" rows="3"></textarea>
                        <label for="comment">{{trans('orders.msgtoorder')}}</label>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>