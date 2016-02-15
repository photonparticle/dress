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
                    {!!isset($pages['content']) ? $pages['content'] : ''!!}
                </div>
            </div>
            <div class="clearfix"></div>
        </div>
        
        <div class="clearfix"></div>

        

        <div class="clearfix"></div>
        

         
        
        <div class="clearfix"></div>
    </form>

</div>
<!-- END MAIN INFO TAB -->