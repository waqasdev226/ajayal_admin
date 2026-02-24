<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">
        <a href="/" class="app-brand-link">
              <span class="app-brand-logo demo">
                <img src="{{ asset('assets/img/branding/logo.png') }}" alt="الآجيال" style="height: 32px; max-width: 120px; object-fit: contain;">
              </span>
            <span class="app-brand-text demo menu-text fw-bold">الآجيال</span>
        </a>

        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto">
            <i class="ti menu-toggle-icon d-none d-xl-block ti-sm align-middle"></i>
            <i class="ti ti-x d-block d-xl-none ti-sm align-middle"></i>
        </a>
    </div>

    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1">
        <!-- Dashboards -->

        <li class="menu-item {{ Request::is('/') ? 'active' : '' }}">
            <a href="{{ route('home') }}" class="menu-link">
                <i class="menu-icon tf-icons ti ti-smart-home"></i>
                <div data-i18n="{{ __('all.main') }}">{{__('all.main') }}</div>
            </a>
        </li>

        <!-- Apps & Pages -->
{{--        <li class="menu-header small text-uppercase">--}}
{{--            <span class="menu-header-text">Apps &amp; Pages</span>--}}
{{--        </li>--}}
        <li class="menu-item {{ Request::is( 'investor/*') ? 'active' : '' }}">
            <a href="{{ route('investor.index') }}" class="menu-link">
                <i class="menu-icon tf-icons ti ti-users"></i>
                <div data-i18n="{{ __('all.investors') }}">{{__('all.investors') }}</div>
            </a>
        </li>
        <li class="menu-item  {{ Request::is( 'profit-check/*') ? 'active' : '' }}">
            <a href="{{ route('profit-check.index') }}" class="menu-link">
                <i class="menu-icon tf-icons ti ti-calendar"></i>
                <div data-i18n="{{ __('all.profit') }}">{{ __('all.profit') }}</div>
            </a>
        </li>
        <li class="menu-item  {{ Request::is( 'manual-profit/*') ? 'active' : '' }}">
            <a href="{{ route('manual-profit.index') }}" class="menu-link">
                <i class="menu-icon tf-icons ti ti-currency-dollar"></i>
                <div data-i18n="إضافة ربح يدوي">إضافة ربح يدوي</div>
            </a>
        </li>
        <li class="menu-item  {{ Request::is( 'transaction-check/*') ? 'active' : '' }}">
            <a href="{{ route('transaction-check.index') }}" class="menu-link">
                <i class="menu-icon tf-icons ti ti-file-dollar"></i>
                <div data-i18n="{{ __('all.transaction') }}">{{ __('all.transaction') }}</div>
            </a>
        </li>
        <li class="menu-item  {{ Request::is( 'withdraw-check/*') ? 'active' : '' }}">
            <a href="{{ route('withdraw-check.index') }}" class="menu-link">
                <i class="menu-icon tf-icons ti ti-layout-kanban"></i>
                <div data-i18n="{{ __('all.withdraw') }}">{{ __('all.withdraw') }}</div>
            </a>
        </li>
        @if(Auth::user()->id == 1)
            <li class="menu-item  {{ Request::is( 'system-users/*') ? 'active' : '' }}">
                <a href="{{ route('users.index') }}" class="menu-link">
                    <i class="menu-icon tf-icons ti ti-lock"></i>
                    <div data-i18n="{{ __('all.users') }}">{{ __('all.users') }}</div>
                </a>
            </li>
            <li class="menu-item  {{ Request::is( 'setting') ? 'active' : '' }}">
                <a href="{{ route('getSetting') }}" class="menu-link">
                    <i class="menu-icon tf-icons ti ti-lock"></i>
                    <div data-i18n="{{ __('all.setting') }}">{{ __('all.setting') }}</div>
                </a>
            </li>
            <li class="menu-item  {{ Request::is( 'system-log') ? 'active' : '' }}">
                <a href="{{ route('systemIndex') }}" class="menu-link">
                    <i class="menu-icon tf-icons ti ti-lock"></i>
                    <div data-i18n="{{ __('all.log-system') }}">{{ __('all.log-system') }}</div>
                </a>
            </li>
        @endif

        <!-- Academy menu start -->
{{--        <li class="menu-item">--}}
{{--            <a href="javascript:void(0);" class="menu-link menu-toggle">--}}
{{--                <i class="menu-icon tf-icons ti ti-book"></i>--}}
{{--                <div data-i18n="Academy">Academy</div>--}}
{{--            </a>--}}
{{--            <ul class="menu-sub">--}}
{{--                <li class="menu-item">--}}
{{--                    <a href="app-academy-overview.html" class="menu-link">--}}
{{--                        <div data-i18n="Overview">Overview</div>--}}
{{--                    </a>--}}
{{--                </li>--}}
{{--                <li class="menu-item">--}}
{{--                    <a href="app-academy-course.html" class="menu-link">--}}
{{--                        <div data-i18n="My Course">My Course</div>--}}
{{--                    </a>--}}
{{--                </li>--}}
{{--                <li class="menu-item">--}}
{{--                    <a href="app-academy-course-details.html" class="menu-link">--}}
{{--                        <div data-i18n="Course Details">Course Details</div>--}}
{{--                    </a>--}}
{{--                </li>--}}
{{--            </ul>--}}
{{--        </li>--}}
        <!-- Academy menu end -->

    </ul>
</aside>
