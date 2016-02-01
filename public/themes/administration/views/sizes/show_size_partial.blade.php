<div class="portlet box blue">
    <div class="portlet-title">
        <div class="caption">
            <i class="fa fa-arrows-v"></i> {{trans('sizes.size')}}
        </div>
        <div class="tools">
            <a href="javascript:;" class="collapse" data-original-title="" title="">
            </a>
        </div>
    </div>
    <div class="portlet-body size_box" style="display: block;" data-id="{{isset($size['id']) ? $size['id'] : 'new'}}">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <div class="form-group form-md-line-input has-success form-md-floating-label col-xs-12 col-sm-8 col-md-9 col-lg-9">
                <div class="input-icon right">
                    <input id="name" type="text" class="form-control input-md input-name" @if(!empty($size['name'])) value="{{$size['name']}}" @endif />

                    <label for="name">{{trans('sizes.name')}}</label>
                    <span class="help-block"></span>
                    <i class="fa fa-font"></i>
                </div>
            </div>
            <div class="form-group form-md-line-input has-success form-md-floating-label col-xs-10 col-sm-3 col-md-2 col-lg-2">
                <div class="input-icon right col-xs-10 margin-10">
                    <input id="position" type="text" class="form-control input-md input-position edited" value="{{isset($size['position']) ? $size['position'] : '0'}}" />

                    <label for="position">{{trans('sizes.position')}}</label>
                    <span class="help-block"></span>
                    <i class="fa fa-arrows-v"></i>
                </div>
            </div>

            <div class="col-xs-2 col-sm-2 col-md-1 col-lg-1" style="padding-top:20px">
                <a href="#"
                   class="btn btn-icon-only red remove_size"
                   title="{{trans('global.remove')}}"
                   data-id="{{isset($size['id']) ? $size['id'] : 'new'}}"
                   data-name="{{isset($size['name']) ? $size['name'] : ''}}"
                >
                    <i class="fa fa-remove"></i>
                </a>
            </div>
            <div class="clearfix"></div>
        </div>
        <div class="clearfix"></div>
    </div>
</div>
<div class="clearfix"></div>