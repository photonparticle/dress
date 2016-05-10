<div class="portlet box blue">
    <div class="portlet-title">
        <div class="caption">
            <i class="fa fa-info-circle"></i> {{trans('materials.material')}} @if(!empty($material['title']))<span>{{$material['title']}}</span> @else <span></span>@endif
        </div>
        <div class="tools">
            <a href="javascript:;" class="collapse" data-original-title="" title="">
            </a>
        </div>
    </div>
    <div class="portlet-body material_box" style="display: block;" data-id="{{isset($material['id']) ? $material['id'] : 'new'}}">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <div class="form-group form-md-line-input has-success form-md-floating-label col-xs-12 col-sm-12 col-md-6 col-lg-8">
                <div class="input-icon right">
                    <input id="title" type="text" class="form-control input-md input-title" @if(!empty($material['title'])) value="{{$material['title']}}" @endif />

                    <label for="title">{{trans('materials.title')}}</label>
                    <span class="help-block"></span>
                    <i class="fa fa-font"></i>
                </div>
            </div>
            <div class="form-group form-md-line-input has-success form-md-floating-label col-xs-10 col-sm-6 col-md-3 col-lg-2">
                <div class="input-icon right col-xs-10 margin-10">
                    <input id="position" type="text" class="form-control input-md input-position edited" value="{{isset($material['position']) ? $material['position'] : '0'}}" />

                    <label for="position">{{trans('materials.position')}}</label>
                    <span class="help-block"></span>
                    <i class="fa fa-arrows-v"></i>
                </div>
            </div>

            <div class="col-xs-6 col-sm-6 col-md-3 col-lg-2" style="padding-top:20px">
                <a href="#"
                   class="btn btn-icon-only green-haze save_btn"
                   title="{{trans('global.save')}}"
                   data-id="{{isset($material['id']) ? $material['id'] : 'new'}}"
                   data-title="{{isset($material['title']) ? $material['title'] : ''}}"
                >
                    <i class="fa fa-save"></i>
                </a>
                <a href="#"
                   class="btn btn-icon-only red remove_btn"
                   title="{{trans('global.remove')}}"
                   data-id="{{isset($material['id']) ? $material['id'] : 'new'}}"
                   data-title="{{isset($material['title']) ? $material['title'] : ''}}"
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