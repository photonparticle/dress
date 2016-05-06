<!-- SEO TAB -->
<div class="tab-pane" id="social">
    <form action="#">

        <input type="hidden" name="_token" value="{{ csrf_token() }}">

        <div class="form-group form-md-line-input has-success form-md-floating-label">
            <div class="input-icon right">
                <input name="social_blog" id="social_blog" type="text" class="form-control input-lg" value="{{isset($system_settings['social_blog']) ? $system_settings['social_blog'] : ''}}"/>

                <label for="social_blog">{{trans('system_settings.social_blog')}}</label>
                <span class="help-block"></span>
                <i class="fa fa-rss"></i>
            </div>
        </div>

        <div class="form-group form-md-line-input has-success form-md-floating-label">
            <div class="input-icon right">
                <input name="social_facebook" id="social_facebook" type="text" class="form-control input-lg" value="{{isset($system_settings['social_facebook']) ? $system_settings['social_facebook'] : ''}}"/>

                <label for="social_facebook">{{trans('system_settings.social_facebook')}}</label>
                <span class="help-block"></span>
                <i class="fa fa-facebook"></i>
            </div>
        </div>

        <div class="form-group form-md-line-input has-success form-md-floating-label">
            <div class="input-icon right">
                <input name="social_twitter" id="social_twitter" type="text" class="form-control input-lg" value="{{isset($system_settings['social_twitter']) ? $system_settings['social_twitter'] : ''}}"/>

                <label for="social_twitter">{{trans('system_settings.social_twitter')}}</label>
                <span class="help-block"></span>
                <i class="fa fa-twitter"></i>
            </div>
        </div>

        <div class="form-group form-md-line-input has-success form-md-floating-label">
            <div class="input-icon right">
                <input name="social_google_plus" id="social_google_plus" type="text" class="form-control input-lg" value="{{isset($system_settings['social_google_plus']) ? $system_settings['social_google_plus'] : ''}}"/>

                <label for="social_google_plus">{{trans('system_settings.social_google_plus')}}</label>
                <span class="help-block"></span>
                <i class="fa fa-google-plus"></i>
            </div>
        </div>

        <div class="form-group form-md-line-input has-success form-md-floating-label">
            <div class="input-icon right">
                <input name="social_youtube" id="social_youtube" type="text" class="form-control input-lg" value="{{isset($system_settings['social_youtube']) ? $system_settings['social_youtube'] : ''}}"/>

                <label for="social_youtube">{{trans('system_settings.social_youtube')}}</label>
                <span class="help-block"></span>
                <i class="fa fa-youtube"></i>
            </div>
        </div>

        <div class="form-group form-md-line-input has-success form-md-floating-label">
            <div class="input-icon right">
                <input name="social_pinterest" id="social_pinterest" type="text" class="form-control input-lg" value="{{isset($system_settings['social_pinterest']) ? $system_settings['social_pinterest'] : ''}}"/>

                <label for="social_pinterest">{{trans('system_settings.social_pinterest')}}</label>
                <span class="help-block"></span>
                <i class="fa fa-pinterest"></i>
            </div>
        </div>

        <div class="clearfix"></div>
    </form>

</div>
<!-- END SEO TAB -->