<div class="main-menu menu-fixed menu-light menu-accordion menu-shadow" data-scroll-to-active="true">
    <div class="navbar-header">
        <ul class="nav navbar-nav flex-row">
            <li class="nav-item me-auto"><a class="navbar-brand" href="#">
                    <h2 class="brand-text">{{config('app.name')}}</h2></a>
            </li>
            <li class="nav-item nav-toggle">
                <a class="nav-link modern-nav-toggle pe-0" data-bs-toggle="collapse">
                    <i class="d-block d-xl-none text-primary toggle-icon font-medium-4" data-feather="x"></i>
                    <i class="d-none d-xl-block collapse-toggle-icon font-medium-4  text-primary" data-feather="disc"
                       data-ticon="disc"></i>
                </a>
            </li>
        </ul>
    </div>
    <div class="shadow-bottom"></div>
    <div class="main-menu-content">
        <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
            <li class="nav-item {{ $selected == "welcome" ? 'active' : '' }}" >
                <a class="d-flex align-items-center" href="{{ route('welcome') }}">
                    <i data-feather="home"></i>
                    <span class="menu-title text-truncate" data-i18n="Chat">
                       {{__('includes/menu.sidebar.welcome')}}
                    </span>
                </a>
            </li>
            @role('administrator')
            <li class="nav-item ">
                <a class="d-flex align-items-center">
                    <i data-feather="settings"></i>
                    <span class="menu-title text-truncate" data-i18n="Chat">
                       {{__('includes/menu.sidebar.management.title')}}
                    </span>
                </a>
                <ul class="menu-content">
                    <li class="{{ $selected == "permissions" ? 'active' : '' }}">
                        <a class="d-flex align-items-center" href="{{ route('management.permission.index') }}">
                            <i data-feather="circle"></i>
                            <span class="menu-item text-truncate" data-i18n="List">
                                {{ __('includes/menu.sidebar.management.permissions') }}
                            </span>
                        </a>
                    </li>
                    <li class="{{ $selected == "roles" ? 'active' : '' }}">
                        <a class="d-flex align-items-center" href="{{ route('management.role.index') }}">
                            <i data-feather="circle"></i>
                            <span class="menu-item text-truncate" data-i18n="List">
                                {{ __('includes/menu.sidebar.management.roles') }}
                            </span>
                        </a>
                    </li>
                    <li class="{{ $selected == "users" ? 'active' : '' }}">
                        <a class="d-flex align-items-center" href="{{ route('management.user.index') }}">
                            <i data-feather="circle"></i>
                            <span class="menu-item text-truncate" data-i18n="List">
                                {{ __('includes/menu.sidebar.management.users') }}
                            </span>
                        </a>
                    </li>
                    @endrole
                </ul>
            </li>
        </ul>
    </div>
</div>
