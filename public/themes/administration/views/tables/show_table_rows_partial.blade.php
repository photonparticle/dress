<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 no-padding holder">
    <div class="form-group form-md-line-input has-success form-md-floating-label no-margin no-padding col-xs-8 col-sm-10 col-md-10 col-lg-10">
        <div class="input-icon right margin-top-20">
            <input name="title" id="title" type="text" class="form-control input-md" value="{{isset($row) ? $row : ''}}" />

            <label for="title">{{trans('tables.title')}}</label>
            <span class="help-block"></span>
            <i class="fa fa-font"></i>
        </div>
    </div>
    <div class="col-xs-4 col-sm-2 col-md-2 col-lg-2 margin-top-20">
        <a href="#" class="btn btn-icon-only btn-danger remove">
            <i class="fa fa-remove"></i>
        </a>
    </div>
</div>
<div class="clearfix"></div>