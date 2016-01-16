<!-- BEGIN SIDEBAR -->
<div class="page-sidebar-wrapper">
    <!-- DOC: Set data-auto-scroll="false" to disable the sidebar from auto scrolling/focusing -->
    <!-- DOC: Change data-auto-speed="200" to adjust the sub menu slide up/down speed -->
    <div class="page-sidebar navbar-collapse collapse">
        <!-- BEGIN SIDEBAR MENU -->
        <!-- DOC: Apply "page-sidebar-menu-light" class right after "page-sidebar-menu" to enable light sidebar menu style(without borders) -->
        <!-- DOC: Apply "page-sidebar-menu-hover-submenu" class right after "page-sidebar-menu" to enable hoverable(hover vs accordion) sub menu mode -->
        <!-- DOC: Apply "page-sidebar-menu-closed" class right after "page-sidebar-menu" to collapse("page-sidebar-closed" class must be applied to the body element) the sidebar sub menu mode -->
        <!-- DOC: Set data-auto-scroll="false" to disable the sidebar from auto scrolling/focusing -->
        <!-- DOC: Set data-keep-expand="true" to keep the submenues expanded -->
        <!-- DOC: Set data-auto-speed="200" to adjust the sub menu slide up/down speed -->
        <ul class="page-sidebar-menu page-sidebar-menu-hover-submenu" data-keep-expanded="true" data-auto-scroll="true" data-slide-speed="1000">
            <li class="start active ">
                <a href="/admin/">
                    <i class="icon-home"></i>
                    <span class="title">{{trans('global.dashboard')}}</span>
                    <span class="selected"></span>
                </a>
            </li>

            <li class="last ">
                <a href="javascript:;">
                    <i class="icon-user"></i>
                    <span class="title">{{trans('global.users')}}</span>
                    <span class="arrow "></span>
                </a>
                <ul class="sub-menu">
                    <li>
                        <a href="/admin/users">
                            {{trans('global.users_list')}}
                        </a>
                    </li>
                    <li>
                        <a href="/admin/users/create">
                            {{trans('global.create_user')}}
                        </a>
                    </li>
                </ul>
            </li>
            
            <li class="last ">
                <a href="javascript:;">
                <i class="fa fa-cogs"></i> <!--
                    <i class="icon-pointer"></i> -->
                <span class="title">{{trans('global.categories')}}</span>
                <span class="arrow "></span>
                </a>
                <ul class="sub-menu">
                    <li>
                        <a href="#{{trans('global.categories')}}">
                        {{trans('global.categories')}}
                        </a>
                    </li>
                    <li>
                        <a href="#{{trans('global.list')}}">
                        {{trans('global.list')}}
                        </a>
                    </li>
                </ul>
            </li>
            
        </ul>
        <!-- END SIDEBAR MENU -->
    </div>
</div>