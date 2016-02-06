<!-- DROPZONE TAB -->
<div class="tab-pane" id="images">




        <form action="#" class="dropzone dz-clickable" id="my-dropzone">
            <div class="dz-default dz-message">
                <!-- BEGIN ERROR MESSAGE -->
                <span>Drop files here to upload</span>
                <!-- END ERROR MESSAGE -->
            </div>
        </form>



        <div class="clearfix"></div>

        <div class="margin-top-20">
            <button class="btn green-haze save_product">
                {{trans('global.save')}} </button>
            <a href="/admin/products" class="btn default">
                {{trans('global.cancel')}} </a>
        </div>



</div>
<!-- END DROPZONE TAB -->