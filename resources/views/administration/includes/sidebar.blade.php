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
            <li class="start @if(isset($active_module) && $active_module == 'dashboard') active @endif">
                <a href="/admin/">
                    <i class="icon-home"></i>
                    <span class="title">{{trans('global.dashboard')}}</span>
                    @if(isset($active_module) && $active_module == 'dashboard')
                        <span class="selected"></span>
                    @endif
                </a>
            </li>

            <li class="@if(isset($active_module) && $active_module == 'categories') active @endif">
                <a href="javascript:;">
                    <i class="fa fa-tasks"></i>
                    <span class="title">{{trans('global.categories')}}</span>
                    <span class="arrow "></span>
                    @if(isset($active_module) && $active_module == 'categories')
                        <span class="selected"></span>
                    @endif
                </a>
                <ul class="sub-menu">
                    <li>
                        <a href="/admin/categories">
                            {{trans('global.categories_list')}}
                        </a>
                    </li>
                    <li>
                        <a href="/admin/categories/create">
                            {{trans('global.create_category')}}
                        </a>
                    </li>
                </ul>
            </li>

            <li class="@if(isset($active_module) && $active_module == 'products') active @endif">
                <a href="javascript:;">
                    <i class="fa fa-archive"></i>
                    <span class="title">{{trans('global.products')}}</span>
                    <span class="arrow "></span>
                    @if(isset($active_module) && $active_module == 'products')
                        <span class="selected"></span>
                    @endif
                </a>
                <ul class="sub-menu">
                    <li>
                        <a href="/admin/products">
                            {{trans('global.products_list')}}
                        </a>
                    </li>
                    <li>
                        <a href="/admin/products/create">
                            {{trans('global.create_product')}}
                        </a>
                    </li>
                </ul>
            </li>

            <li class="@if(isset($active_module) && $active_module == 'orders') active @endif">
                <a href="javascript:;">
                    <i class="fa fa-shopping-cart"></i>
                    <span class="title">{{trans('global.orders')}}</span>
                    <span class="arrow "></span>
                </a>
                <ul class="sub-menu">
                    <li>
                        <a href="/admin/orders">
                            {{trans('global.orders_list')}}
                        </a>
                    </li>
                    <li>
                        <a href="/admin/orders/create">
                            {{trans('global.create_order')}}
                        </a>
                    </li>
                </ul>
            </li>

            <li class="@if(isset($active_module) && $active_module == 'pages') active @endif">
                <a href="javascript:;">
                    <i class="fa fa-file-text-o"></i>
                    <span class="title">{{trans('global.pages')}}</span>
                    <span class="arrow "></span>
                </a>
                <ul class="sub-menu">
                    <li>
                        <a href="/admin/pages">
                            {{trans('global.pages_list')}}
                        </a>
                    </li>
                    <li>
                        <a href="/admin/pages/create">
                            {{trans('global.create_pages')}}
                        </a>
                    </li>
                </ul>
            </li>

            <li class="@if(isset($active_module) && $active_module == 'modules') active @endif">
                <a href="/admin/modules">
                    <i class="fa fa-cogs"></i>
                    <span class="title">{{trans('global.modules')}}</span>
                    @if(isset($active_module) && $active_module == 'modules')
                        <span class="selected"></span>
                    @endif
                </a>
            </li>

            <li class="last @if(isset($active_module) && $active_module == 'users') active @endif">
                <a href="javascript:;">
                    <i class="icon-user"></i>
                    <span class="title">{{trans('global.users')}}</span>
                    <span class="arrow "></span>
                    @if(isset($active_module) && $active_module == 'users')
                        <span class="selected"></span>
                    @endif
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
        </ul>
        <!-- END SIDEBAR MENU -->
    </div>
</div>