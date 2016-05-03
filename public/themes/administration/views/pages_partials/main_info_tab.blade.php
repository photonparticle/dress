<!-- MAIN INFO TAB -->
<div class="tab-pane active" id="main_info">
    <form action="#">

        <input type="hidden" name="_token" value="{{ csrf_token() }}">

        <div class="form-group form-md-line-input has-success form-md-floating-label">
            <div class="input-icon right">
                <input name="title" id="title" type="text" class="form-control input-lg"  value="{{isset($page['title']) ? $page['title'] : ''}}"/>

                <label for="title">{{trans('pages.title')}}</label>
                <span class="help-block"></span>
                <i class="fa fa-font"></i>
            </div>
        </div>

        <div class="form-group">
            <label for="content" class="control-label col-xs-12 default no-padding">
                {{trans('pages.content')}}
            </label>
            <div class="col-xs-12 no-padding">
                <div id="content">
                    {!!isset($page['content']) ? $page['content'] : ''!!}
                </div>
            </div>
            <div class="clearfix"></div>
        </div>

        <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 margin-top-20">
            <label for="active" class="control-label col-xs-12 default no-padding">
                {{trans('pages.active')}}
            </label>
            <div class="col-xs-12 no-padding">
                <input id="active" name="active" type="checkbox" class="make-switch" data-on-text="&nbsp;{{trans('pages.activated')}}&nbsp;" data-off-text="&nbsp;{{trans('pages.not_activated')}}&nbsp;" @if(!isset($page['active']) or (isset($page['active']) && $page['active'] == '1')) checked @endif>
            </div>
        </div>

        <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 margin-top-20">
            <label for="show_footer" class="control-label col-xs-12 default no-padding">
                {{trans('pages.show_footer')}}
            </label>
            <div class="col-xs-12 no-padding">
                <input id="show_footer" name="show_footer" type="checkbox" class="make-switch" data-on-text="&nbsp;{{trans('pages.visible')}}&nbsp;" data-off-text="&nbsp;{{trans('pages.hidden')}}&nbsp;" @if(!isset($page['show_footer']) or (isset($page['show_footer']) && $page['show_footer'] == '1')) checked @endif>
            </div>
        </div>

        <div class="clearfix"></div>
    </form>

</div>
<!-- END MAIN INFO TAB -->