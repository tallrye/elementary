<!-- BEGIN SIDEBAR -->
<div class="page-sidebar-wrapper">
    <div class="page-sidebar navbar-collapse collapse">
        <ul class="page-sidebar-menu  page-header-fixed page-sidebar-menu-light {{ (\Auth::user()->profile->sidebarOpen) ? '' : 'page-sidebar-closed-hide-logo page-sidebar-closed page-sidebar-menu-closed' }}" data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200" style="padding-top: 20px">
            <li class="sidebar-toggler-wrapper hide">
                <div class="sidebar-toggler"> </div>
            </li>
            <li class="sidebar-search-wrapper">
                <form class="sidebar-search" action="page_general_search_3.html" method="POST">
                    <a href="javascript:;" class="remove">
                        <i class="icon-close"></i>
                    </a>
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Search...">
                        <span class="input-group-btn">
                            <a href="javascript:;" class="btn submit">
                                <i class="icon-magnifier"></i>
                            </a>
                        </span>
                    </div>
                </form>
            </li>

            <li class="nav-item {{ (strpos($currentRouteName, 'home') !== false) ? 'active' : '' }}">
                <a href="{{ route('home') }}" class="nav-link nav-toggle">
                    <i class="icon-home"></i>
                    <span class="title">Anasayfa</span>
                    <span class="selected"></span>
                </a>
            </li>
            @can('manage_system')
            <li class="nav-item  
                {{ (strpos($currentRouteName, 'roles') !== false || 
                    strpos($currentRouteName, 'permissions') !== false || 
                    strpos($currentRouteName, 'profiles.admin') !== false) 
                ? 'active' : '' }} ">
                <a href="javascript:;" class="nav-link nav-toggle">
                    <i class="icon-settings"></i>
                    <span class="title">Sistem Yönetimi</span>
                    <span class="selected"></span>
                    <span class="arrow {{ (strpos($currentRouteName, 'roles') !== false || strpos($currentRouteName, 'permissions') !== false) ? 'open' : '' }}"></span>
                </a>
                <ul class="sub-menu">
                    @can('manage_roles')
                    <li class="nav-item {{ (strpos($currentRouteName, 'roles') !== false || strpos($currentRouteName, 'permissions') !== false) ? 'active' : '' }} ">
                        <a href="javascript:;" class="nav-link nav-toggle">
                            <i class="icon-shield"></i>
                            <span class="title">Rol ve Yetki Tanımları</span>
                            <span class="arrow {{ (strpos($currentRouteName, 'roles') !== false || strpos($currentRouteName, 'permissions') !== false) ? 'open' : '' }}"></span>
                            <span class="selected"></span>
                        </a>
                        <ul class="sub-menu">
                            <li class="nav-item {{ (strpos($currentRouteName, 'roles') !== false) ? 'active' : '' }}">
                                <a href="{{ route('roles.index') }}" class="nav-link ">
                                    <span class="title">Roller</span>
                                </a>
                            </li>
                            @can('manage_permissions')
                            <li class="nav-item {{ (strpos($currentRouteName, 'permissions') !== false) ? 'active' : '' }}">
                                <a href="{{ route('permissions.index') }}" class="nav-link ">
                                    <span class="title">Yetkiler</span>
                                </a>
                            </li>
                            @endif
                        </ul>
                    </li>
                    @endif
                    @can('manage_users')
                    <li class="nav-item {{ (strpos($currentRouteName, 'profiles.admin') !== false) ? 'active' : '' }} ">
                        <a href="javascript:;" class="nav-link nav-toggle">
                            <i class="icon-users"></i>
                            <span class="title">Kullanıcılar</span>
                            <span class="arrow {{ (strpos($currentRouteName, 'profiles.admin') !== false) ? 'open' : '' }}"></span>
                            <span class="selected"></span>
                        </a>
                        <ul class="sub-menu">
                            <li class="nav-item {{ (strpos($currentRouteName, 'profiles.admin.create') !== false) ? 'active' : '' }}">
                                <a href="{{ route('profiles.admin.create') }}" class="nav-link ">
                                    <span class="title">Yeni Kullanıcı Ekle</span>
                                </a>
                            </li>
                            <li class="nav-item {{ (strpos($currentRouteName, 'profiles.admin.index') !== false) ? 'active' : '' }}">
                                <a href="{{ route('profiles.admin.index') }}" class="nav-link ">
                                    <span class="title">Mevcut Kullanıcılar</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    @endif
                </ul>
            </li>
            @endif
        </ul>
    </div>
</div>
<!-- END SIDEBAR -->
