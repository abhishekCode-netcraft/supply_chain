<div class="sticky">
    <div class="app-sidebar__overlay" data-bs-toggle="sidebar"></div>
    <div class="app-sidebar" style="overflow: scroll;">
        <div class="side-header">
            <a class="header-brand1" href="/admin/dashboard">
                <img src="/storage/{{ $userInfo->logo??'logo-3.png' }}" class="header-brand-img desktop-logo" alt="logo">
                <img src="/storage/{{ $userInfo->logo??'logo-3.png' }}" class="header-brand-img toggle-logo" alt="logo">
                <img src="/storage/{{ $userInfo->logo??'logo-3.png' }}" class="header-brand-img light-logo" alt="logo">
                <img src="/storage/{{ $userInfo->logo??'logo-3.png' }}" class="header-brand-img light-logo1" alt="logo" width="50" height="50">
            </a>
            <!-- LOGO -->
        </div>
        <div class="main-sidemenu">
            <div class="slide-left disabled" id="slide-left">
                <svg xmlns="http://www.w3.org/2000/svg" fill="#7b8191" width="24" height="24" viewBox="0 0 24 24">
                    <path d="M13.293 6.293 7.586 12l5.707 5.707 1.414-1.414L10.414 12l4.293-4.293z" />
                </svg>
            </div>
            <ul class="side-menu">

                <li class="sub-category">
                    <h3>{{ __('Main') }}</h3>
                </li>
                <li class="slide">
                    <a class="side-menu__item" data-bs-toggle="slide" href="{{ route('dashboard') }}"><i class="side-menu__icon fe fe-home"></i><span class="side-menu__label">{{ __('Dashboard') }}</span></a>
                </li>
                    <li class="slide">
                    <a class="side-menu__item" data-bs-toggle="slide" href="{{ route('users.index') }}"><i class="side-menu__icon fe fe-home"></i><span class="side-menu__label">{{ __('Manage Users') }}</span></a>
                </li>
            </ul>
        </div>
    </div>
</div>
