<!-- Start Sidebar -->

<div id="sidebar_menu" class="sidebar-menu scrollable">
    <div class="input-group search-input">
        <input type="text" class="form-control" id="searchInput12" placeholder="{{ __('Search here...') }}"
            autocomplete="off">
        <span class="input-group-text">
            <a href="javascript:void(0)">
                <i class="flaticon-loupe"></i>
            </a>
        </span>
    </div>
    <ul id="resultList12"></ul>
    <ul class="vertical-menu" id="sidebarMenu">
        <li
            class="{{ request()->routeIs('admin.dashboard') || request()->routeIs('user.dashboard') ? 'active menu-open' : '' }}">
            <a href="{{ route('admin.dashboard') }}" title="{{ __('Dashboard') }}" class="nav-link menu">
                <span class="sidebar-icon">
                    <i class="flaticon-dashboard"></i>
                </span>
                <span class="sidebar-title">{{ __('Dashboard') }}</span>
            </a>
        </li>
        <li
            class="{{ request()->routeIs('admin.marketing') || request()->routeIs('user.dashboard') ? 'active menu-open' : '' }}">
            <a href="{{ route('admin.marketing') }}" title="{{ __('Marketing Dashboard') }}" class="nav-link menu">
                <span class="sidebar-icon">
                    <i class="flaticon-report"></i>
                </span>
                <span class="sidebar-title">{{ __('Marketing Dashboard') }}</span>
            </a>
        </li>
        @canany(['users.view', 'roles.view', 'accountdelete.manage'])
            @can('users.view')
                <li class="menu-title mb-0">
                    <span>{{ __('Users') }}</span>
                </li>
                <li class="{{ Request::is('admin/users*') ? 'active menu-open' : '' }}">
                    <a href="{{ url('admin/users') }}" title="{{ __('Users') }}" class="menu">
                        <span class="sidebar-icon">
                            <i class="flaticon-user"></i>
                        </span>
                        <span class="sidebar-title">{{ __('Users') }}</span>
                    </a>
                </li>
            @endcan
            @can('accountdelete.manage')
                <li class="{{ Request::is('admin/user_delete*') ? 'active menu-open' : '' }}">
                    <a href="{{ route('user_delete.index') }}" title="{{ __('Users Account Delete Request') }}"
                        class="menu">
                        <span class="sidebar-icon">
                            <i class="flaticon-delete-1"></i>
                        </span>
                        <span class="sidebar-title">{{ __('Users Delete Request') }}</span>
                    </a>
                </li>
            @endcan
            @can('reason.view')
            <li class="{{ Request::is('/admin/reasons*') ? 'active menu-open' : '' }}">
                <a href="{{ route('reason.show') }}" title="{{ __('Users delete reasons') }}"
                    class="menu">
                    <span class="sidebar-icon">
                        <i class="flaticon-delete-1"></i>
                    </span>
                    <span class="sidebar-title">{{ __('Users Delete Reasons') }}</span>
                </a>
            </li>
            @endcan
            @can('roles.view')
                <li class="{{ Request::is('admin/roles*') ? 'active menu-open' : '' }}">
                    <a href="{{ route('roles.show') }}" title="{{ __('Roles and Permissions') }}" class="menu">
                        <span class="sidebar-icon">
                            <i class="flaticon-management"></i>
                        </span>
                        <span class="sidebar-title">{{ __('Roles and Permissions') }}</span>
                    </a>
                </li>
            @endcan
        @endcanany
        @can('category.view')
            <li class="menu-title mb-0">
                <span>{{ __('Categories') }}</span>
            </li>
            <li class="{{ Request::is('admin/category*') ? 'active menu-open' : '' }}">
                <a href="{{ route('category.index') }}" title="{{ __('Categories') }}" class="menu">
                    <span class="sidebar-icon">
                        <i class="flaticon-data-classification"></i>
                    </span>
                    <span class="sidebar-title">{{ __('Categories') }}</span>
                </a>
            </li>
        @endcan
        <li class="menu-title mb-0">
            <span>{{ __('Quiz') }}</span>
        </li>
        @can('quiz.view')
        <li class="treeview {{ Request::is('admin/quiz/*') ? 'active menu-open' : '' }}">
            <a href="{{ route('quiz.index') }}" title="{{ __('quiz') }}" class="menu">
                <span class="sidebar-icon">
                    <i class="flaticon-speech-bubble-1"></i>
                </span>
                <span class="sidebar-title">{{ __('Quiz') }}</span>
            </a>
        </li>
        @endcan
        @can('badge.view')
        <li class="treeview {{ Request::is('admin/badges/*') ? 'active menu-open' : '' }}">
            <a href="{{ route('badge.index') }}" title="{{ __('badges') }}" class="menu">
                <span class="sidebar-icon">
                    <i class="flaticon-achieve"></i>
                </span>
                <span class="sidebar-title">{{ __('Badges') }}</span>
            </a>
        </li>
        @endcan
        @can('battle.view')
        <li class="treeview {{ Request::is('admin/battle/*') ? 'active menu-open' : '' }}">
            <a href="{{ route('battle.index') }}" title="{{ __('battle') }}" class="menu">
                <span class="sidebar-icon">
                    <i class="flaticon-swords"></i>
                </span>
                <span class="sidebar-title">{{ __('Battle') }}</span>
            </a>
        </li>
        @endcan
        @can('contest.view')
        <li class="treeview {{ Request::is('admin/contest/*') ? 'active menu-open' : '' }}">
            <a href="{{ route('contest.index') }}" title="{{ __('contest') }}" class="menu">
                <span class="sidebar-icon">
                    <i class="flaticon-data-classification"></i>
                </span>
                <span class="sidebar-title">{{ __('Contest') }}</span>
            </a>
        </li>
        @endcan
        @can('coupon.view')
            <li class="menu-title mb-0">
                <span>{{ __('Marketing and Plans') }}</span>
            </li>
            <li class="{{ Request::is('admin/coupon*') ? 'active menu-open' : '' }}">
                <a href="{{ route('coupon.show') }}" title="{{ __('Coupons') }}" class="menu">
                    <span class="sidebar-icon">
                        <i class="flaticon-promo-code"></i>
                    </span>
                    <span class="sidebar-title">{{ __('Coupons') }}</span>
                </a>
            </li>
        @endcan
        @canany(['affiliate.manage'])
            <li class="{{ Request::is('admin/affiliate*') ? 'active menu-open' : '' }}">
                <a href="#" title="{{ __('Affiliate') }}" class="menu">
                    <span class="sidebar-icon">
                        <i class="flaticon-dashboard-1"></i>
                    </span>
                    <span class="sidebar-title">{{ __('Affiliate') }}</span>
                    <span class="right-arrow">
                        <i class="flaticon-down-arrow"></i>
                    </span>
                </a>
                <ul class="vertical-submenu">
                    <li>
                        <a href="{{ route('admin.affiliate.link') }}" title="{{ __('Affiliate Link') }}">
                            <span class="sidebar-icon">
                                <i class="flaticon-record-button"></i>
                            </span>
                            <span class="submenu-title">{{ __('Affiliate Link') }}</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.report.affiliate.reports') }}" title="{{ __('Affiliate History') }}">
                            <span class="sidebar-icon">
                                <i class="flaticon-record-button"></i>
                            </span>
                            <span class="submenu-title">{{ __('Affiliate History') }}</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.affiliate') }}" title="{{ __('Affiliate Settings') }}">
                            <span class="sidebar-icon">
                                <i class="flaticon-record-button"></i>
                            </span>
                            <span class="submenu-title">{{ __('Affiliate Settings') }}</span>
                        </a>
                    </li>
                </ul>
            </li>
        @endcanany
        @canany(['packages.view', 'packages_features.view'])
            <li class="{{ Request::is('admin/packages*', 'admin/packages-features*') ? 'active menu-open' : '' }}">
                <a href="#" title="{{ __('Packages') }}" class="menu">
                    <span class="sidebar-icon">
                        <i class="flaticon-box"></i>
                    </span>
                    <span class="sidebar-title">{{ __('Packages') }}</span>
                    <span class="right-arrow">
                        <i class="flaticon-down-arrow"></i>
                    </span>
                </a>
                <ul class="vertical-submenu">
                    @can('packages.view')
                        <li>
                            <a href="{{ route('packages.show') }}" title="{{ __('Packages') }}">
                                <span class="sidebar-icon">
                                    <i class="flaticon-record-button"></i>
                                </span>
                                <span class="submenu-title">{{ __('Packages') }}</span>
                            </a>
                        </li>
                    @endcan
                    @can('packages_features.view')
                        <li>
                            <a href="{{ route('packages_features.show') }}" title="{{ __('Packages Features') }}">
                                <span class="sidebar-icon">
                                    <i class="flaticon-record-button"></i>
                                </span>
                                <span class="submenu-title">{{ __('Packages Features') }}</span>
                            </a>
                        </li>
                    @endcan
                </ul>
            </li>
        @endcanany
        @can('advertisement.view')
            <li class="menu-title mb-0">
                <span>{{ __('Advertisements') }}</span>
            </li>
            <li class="{{ Request::is('admin/advertisement*') ? 'active menu-open' : '' }}">
                <a href="{{ route('advertisement.show') }}" title="{{ __('Advertisements') }}" class="menu">
                    <span class="sidebar-icon">
                        <i class="flaticon-digital-marketing"></i>
                    </span>
                    <span class="sidebar-title">{{ __('Advertisements') }}</span>
                </a>
            </li>
        @endcan
        @canany(['affiliate.manage'])
            <li class="menu-title mb-0">
                <span>{{ __('Financial') }}</span>
            </li>
            <li>
                <a href="{{route('orders.admin')}}" title="{{ __('Order') }}" class="menu">
                    <span class="sidebar-icon">
                        <i class="flaticon-checkout"></i>
                    </span>
                    <span class="sidebar-title">{{ __('Orders') }}</span>
                </a>
            </li>
            <li class="">
                <a href="#" title="{{ __('Reports') }}" class="menu">
                    <span class="sidebar-icon">
                        <i class="flaticon-dashboard-1"></i>
                    </span>
                    <span class="sidebar-title">{{ __('Reports') }}</span>
                    <span class="right-arrow">
                        <i class="flaticon-down-arrow"></i>
                    </span>
                </a>
                <ul class="vertical-submenu">
                    <li>
                        <a href="{{ route('admin.affiliate.reports') }}" title="{{ __('Affiliate History') }}">
                            <span class="sidebar-icon">
                                <i class="flaticon-record-button"></i>
                            </span>
                            <span class="submenu-title">{{ __('Affiliate History') }}</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.quiz.reports') }}" title="{{ __('Quiz Reports') }}">
                            <span class="sidebar-icon">
                                <i class="flaticon-record-button"></i>
                            </span>
                            <span class="submenu-title">{{ __('Quiz Reports') }}</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.badge.reports') }}" title="{{ __('Quiz Reports') }}">
                            <span class="sidebar-icon">
                                <i class="flaticon-record-button"></i>
                            </span>
                            <span class="submenu-title">{{ __('Badges Reports') }}</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{route('newsletter.reports')}}" title="{{ __('Newsletter Reports') }}">
                            <span class="sidebar-icon">
                                <i class="flaticon-record-button"></i>
                            </span>
                            <span class="submenu-title">{{ __('Newsletter Reports') }}</span>
                        </a>
                    </li>
                </ul>
            </li>
        @endcanany
        @canany(['mail.manage', 'general.manage', 'custom.manage', 'chat.manage', 'language.view', 'currency.view',
        'cockpit.manage', 'apisetting.manage', 'sms.manage', 'service.view', '2fa.manage'])
            <li class="menu-title mb-0">
                <span>{{ __('Settings') }}</span>
            </li>
            <li
                class="{{ Request::is('admin/mail-setting*', 'admin/general-setting*', 'admin/cockpit*', 'admin/custom-setting*', 'admin/chat-setting*', 'admin/language*', 'admin/currency*', 'admin/api-setting*', 'admin/sms-setting*', 'admin/country*', 'admin/state*', 'admin/cities*', 'admin/two-factor/auth*') ? 'active menu-open' : '' }}">
                <a href="#" title="{{ __('Project Settings') }}" class="menu">
                    <span class="sidebar-icon">
                        <i class="flaticon-folder-management"></i>
                    </span>
                    <span class="sidebar-title">{{ __('Project Settings') }}</span>
                    <span class="right-arrow">
                        <i class="flaticon-down-arrow"></i>
                    </span>
                </a>
                <ul class="vertical-submenu">
                    @can('general.manage')
                        <li>
                            <a href="{{ url('/admin/general-setting') }}" title="{{ __('General Settings') }}">
                                <span class="sidebar-icon">
                                    <i class="flaticon-record-button"></i>
                                </span>
                                <span class="submenu-title">{{ __('General Settings') }}</span>
                            </a>
                        </li>
                    @endcan
                    @can('mail.manage')
                        <li>
                            <a href="{{ url('/admin/mail-setting') }}" title="{{ __('Mail Settings') }}">
                                <span class="sidebar-icon">
                                    <i class="flaticon-record-button"></i>
                                </span>
                                <span class="submenu-title">{{ __('Mail Settings') }}</span>
                            </a>
                        </li>
                    @endcan
                    @can('cockpit.manage')
                        <li>
                            <a href="{{ url('admin/cockpit') }}" title="{{ __('Cockpit') }}">
                                <span class="sidebar-icon">
                                    <i class="flaticon-record-button"></i>
                                </span>
                                <span class="submenu-title">{{ __('Cockpit') }}</span>
                            </a>
                        </li>
                    @endcan
                    @can('custom.manage')
                        <li>
                            <a href="{{ url('admin/custom-setting') }}" title="{{ __('Custom Css & Js') }}">
                                <span class="sidebar-icon">
                                    <i class="flaticon-record-button"></i>
                                </span>
                                <span class="submenu-title">{{ __('Custom Css & Js') }}</span>
                            </a>
                        </li>
                    @endcan
                    @can('chat.manage')
                        <li>
                            <a href="{{ url('/admin/chat-setting') }}" title="{{ __('Chat Settings') }}">
                                <span class="sidebar-icon">
                                    <i class="flaticon-record-button"></i>
                                </span>
                                <span class="submenu-title">{{ __('Chat Settings') }}</span>
                            </a>
                        </li>
                    @endcan
                    @can('language.view')
                        <li class="{{ Request::is('admin/language*') ? 'active menu-open' : '' }}">
                            <a href="{{ url('admin/language') }}" title="{{ __('Languages') }}">
                                <span class="sidebar-icon">
                                    <i class="flaticon-record-button"></i>
                                </span>
                                <span class="submenu-title">{{ __('Languages') }}</span>
                            </a>
                        </li>
                    @endcan
                    @can('currency.view')
                        <li>
                            <a href="{{ url('admin/currency') }}" title="{{ __('Currencies') }}">
                                <span class="sidebar-icon">
                                    <i class="flaticon-record-button"></i>
                                </span>
                                <span class="submenu-title">{{ __('Currencies') }}</span>
                            </a>
                        </li>
                    @endcan
                    @canany(['apisetting.manage'])
                        <li>
                            <a href="{{ url('admin/api-setting') }}" title="{{ __('API Settings') }}">
                                <span class="sidebar-icon">
                                    <i class="flaticon-record-button"></i>
                                </span>
                                <span class="submenu-title">{{ __('API Settings') }}</span>
                            </a>
                        </li>
                    @endcanany
                    @can('sms.manage')
                        <li>
                            <a href="{{ url('admin/sms-setting') }}" title="{{ __('SMS Settings') }}">
                                <span class="sidebar-icon">
                                    <i class="flaticon-record-button"></i>
                                </span>
                                <span class="submenu-title">{{ __('SMS Settings') }}</span>
                            </a>
                        </li>
                    @endcan
                    <li class="location">
                        <a href="#" title="{{ __('Locations') }}" title="{{ __('Locations') }}">
                            <span class="sidebar-icon">
                                <i class="flaticon-record-button"></i>
                            </span>
                            <span class="submenu-title">{{ __('Locations') }}</span>
                            <span class="right-arrow">
                                <i class="flaticon-down-arrow"></i>
                            </span>
                        </a>
                        <ul class="vertical-submenu">
                            <li class="{{ Request::is('admin/country*') ? 'active menu-open' : '' }}">
                                <a href="{{ url('admin/country') }}" title="{{ __('Country') }}" class="menu">
                                    <span class="sidebar-icon">
                                        <i class="flaticon-record-button"></i>
                                    </span>
                                    <span class="submenu-title">{{ __('Country') }}</span>
                                </a>
                            </li>
                            <li class="{{ Request::is('admin/state*') ? 'active menu-open' : '' }}" class="menu">
                                <a href="{{ url('admin/state') }}" title="{{ __('State') }}">
                                    <span class="sidebar-icon">
                                        <i class="flaticon-record-button"></i>
                                    </span>
                                    <span class="submenu-title">{{ __('State') }}</span>
                                </a>
                            </li>
                            <li class="{{ Request::is('admin/cities*') ? 'active menu-open' : '' }}" class="menu">
                                <a href="{{ url('admin/cities') }}" title="{{ __('City') }}">
                                    <span class="sidebar-icon">
                                        <i class="flaticon-record-button"></i>
                                    </span>
                                    <span class="submenu-title">{{ __('City') }}</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    @can('service.view')
                        <li>
                            <a href="{{ url('admin/services') }}" title="{{ __('Open Ai Services') }}">
                                <span class="sidebar-icon">
                                    <i class="flaticon-record-button"></i>
                                </span>
                                <span class="submenu-title">{{ __('Open Ai Services') }}</span>
                            </a>
                        </li>
                    @endcan
                    @can('2fa.manage')
                    <li>
                        <a href="{{ url('/admin/two-factor/auth') }}" title="{{ __('Two Factor Auth') }}">
                            <span class="sidebar-icon">
                                <i class="flaticon-record-button"></i>
                            </span>
                            <span class="submenu-title">{{ __('Two Factor Auth') }}</span>
                        </a>
                    </li>
                    @endcan
                </ul>
            </li>
        @endcanany
        @canany(['blog.view', 'faq.view', 'pages.view', 'testimonial.view', 'slider.view', 'trustedslider.view',
        'gallery.view', 'team.view', 'sitemap.view', 'footersetting.manage', 'pwa.manage', 'seo.manage',
        'login_signup.manage'])
            <li
                class="{{ Request::is('admin/post*', 'admin/post-category*', 'admin/faq*', 'admin/pages*', 'admin/testimonial*', 'admin/sitemap*', 'admin/slider*', 'admin/footer-setting*', 'admin/pwa-setting*', 'admin/seo_setting*', 'admin/login_signup*', 'admin/gallery*', 'admin/team-members*', 'admin/trusted/slider*') ? 'active menu-open' : '' }}">
                <a href="#" title="{{ __('Front Panel') }}" class="menu">
                    <span class="sidebar-icon">
                        <i class="flaticon-settings"></i>
                    </span>
                    <span class="sidebar-title">{{ __('Front Settings') }}</span>
                    <span class="right-arrow">
                        <i class="flaticon-down-arrow"></i>
                    </span>
                </a>
                <ul class="vertical-submenu">
                    @can('slider.view')
                        <li class="{{ request()->is('admin/slider*') ? ' active' : '' }}">
                            <a href="{{ route('slider.show') }}" title="{{ __('Sliders') }}">
                                <span class="sidebar-icon">
                                    <i class="flaticon-record-button"></i>
                                </span>
                                <span class="submenu-title">{{ __('Sliders') }}</span>
                            </a>
                        </li>
                    @endcan

                    @can('trustedslider.view')
                        <li class="{{ request()->is('admin/trusted/slider*') ? ' active' : '' }}">
                            <a href="{{ route('trusted.slider.index') }}" title="{{ __('Trusted Sliders') }}">
                                <span class="sidebar-icon">
                                    <i class="flaticon-record-button"></i>
                                </span>
                                <span class="submenu-title">{{ __('Trusted Sliders') }}</span>
                            </a>
                        </li>
                    @endcan

                    @can('zone.view')
                    <li class="{{ request()->is('admin/zone*')}}">
                        <a href="{{ url('admin/zone') }}" title="{{ __('Zone') }}">
                            <span class="sidebar-icon">
                                <i class="flaticon-record-button"></i>
                            </span>
                            <span class="submenu-title">{{ __('Zone') }}</span>
                        </a>
                    </li>
                    @endcan

                    @can('blog.view')
                        <li
                            class="{{ request()->is('admin/post*') && !request()->is('admin/post-category*') ? 'active' : '' }}">
                            <a href="{{ url('admin/post') }}" title="{{ __('Post') }}">
                                <span class="sidebar-icon">
                                    <i class="flaticon-record-button"></i>
                                </span>
                                <span class="submenu-title">{{ __('Post') }}</span>
                            </a>
                        </li>
                    @endcan

                    @can('blog.comments')
                    <li
                        class="{{ request()->is('admin/comments/*') && !request()->is('admin/post-category*') ? 'active' : '' }}">
                        <a href="{{ url('admin/comments') }}" title="{{ __('comments') }}">
                            <span class="sidebar-icon">
                                <i class="flaticon-record-button"></i>
                            </span>
                            <span class="submenu-title">{{ __('Blog comments') }}</span>
                        </a>
                    </li>
                    @endcan

                    @can('blog.view')
                        <li class="{{ request()->is('admin/post-category*') ? 'active' : '' }}">
                            <a href="{{ url('admin/post-category') }}" title="{{ __('Post Categories') }}">
                                <span class="sidebar-icon">
                                    <i class="flaticon-record-button"></i>
                                </span>
                                <span class="submenu-title">{{ __('Post Categories') }}</span>
                            </a>
                        </li>
                    @endcan

                    @can('team.view')
                        <li class="{{ request()->is('admin/team-members*') ? 'active' : '' }}">
                            <a href="{{ url('admin/team-members') }}" title="{{ __('Team') }}">
                                <span class="sidebar-icon">
                                    <i class="flaticon-record-button"></i>
                                </span>
                                <span class="submenu-title">{{ __('Team') }}</span>
                            </a>
                        </li>
                    @endcan

                    @can('comingsoon.manage')
                        <li class="{{ request()->is('admin/coming-soon*') ? 'active' : '' }}">
                            <a href="{{route('admin.coming_soon')}}" title="{{ __('Coming Soon') }}">
                                <span class="sidebar-icon">
                                    <i class="flaticon-record-button"></i>
                                </span>
                                <span class="submenu-title">{{ __('Coming Soon') }}</span>
                            </a>
                        </li>
                    @endcan

                    @can('faq.view')
                        <li class="{{ request()->is('admin/faq*') ? ' active' : '' }}">
                            <a href="{{ url('admin/faq') }}" title="{{ __('FAQ') }}'{{ __('s') }}">
                                <span class="sidebar-icon">
                                    <i class="flaticon-record-button"></i>
                                </span>
                                <span class="submenu-title">{{ __('FAQ') }}'{{ __('s') }}</span>
                            </a>
                        </li>
                    @endcan

                    @can('testimonial.view')
                        <li class="{{ request()->is('admin/testimonial*') ? ' active' : '' }}">
                            <a href="{{ route('testimonial.show') }}" title="{{ __('Testimonials') }}">
                                <span class="sidebar-icon">
                                    <i class="flaticon-record-button"></i>
                                </span>
                                <span class="submenu-title">{{ __('Testimonials') }}</span>
                            </a>
                        </li>
                    @endcan

                    @can('home.view')
                        <li class="{{ request()->is('admin/homepage-setting*') ? ' active' : '' }}">
                            <a href="{{ route('admin.home.setting') }}" title="{{ __('Homepage Setting') }}">
                                <span class="sidebar-icon">
                                    <i class="flaticon-record-button"></i>
                                </span>
                                <span class="submenu-title">{{ __('Homepage Setting') }}</span>
                            </a>
                        </li>
                    @endcan

                    @can('newsletter.view')
                        <li class="{{ request()->is('admin/newsletter*') ? ' active' : '' }}">
                            <a href="{{ route('newsletter.index') }}" title="{{ __('newsletter') }}">
                                <span class="sidebar-icon">
                                    <i class="flaticon-record-button"></i>
                                </span>
                                <span class="submenu-title">{{ __('Newsletter') }}</span>
                            </a>
                        </li>
                    @endcan

                    @can('pages.view')
                        <li class="{{ request()->is('admin/pages*') ? ' active' : '' }}">
                            <a href="{{ url('admin/pages') }}" title="Pages">
                                <span class="sidebar-icon">
                                    <i class="flaticon-record-button"></i>
                                </span>
                                <span class="submenu-title">{{ __('Pages') }}</span>
                            </a>
                        </li>
                    @endcan
                    
                    @can('invoice.manage')
                        <li class="">
                            <a href="{{route('admin.invoice_settings')}}" title="{{ __('Invoice Settings') }}">
                                <span class="sidebar-icon">
                                    <i class="flaticon-record-button"></i>
                                </span>
                                <span class="submenu-title">{{ __('Invoice Settings') }}</span>
                            </a>
                        </li>
                    @endcan

                    @can('theme_setting.manage')
                        <li class="">
                            <a href="#" title="{{ __('Theme Setting') }}">
                                <span class="sidebar-icon">
                                    <i class="flaticon-record-button"></i>
                                </span>
                                <span class="submenu-title">{{ __('Theme Setting') }}</span>
                            </a>
                        </li>
                    @endcan
                    
                    @can('sitemap.view')
                        <li class="">
                            <a href="{{ route('sitemap.index') }}" title="{{ __('Sitemap') }}">
                                <span class="sidebar-icon">
                                    <i class="flaticon-record-button"></i>
                                </span>
                                <span class="submenu-title">{{ __('Sitemap') }}</span>
                            </a>
                        </li>
                    @endcan 

                    @can('footersetting.manage')
                        <li class="{{ request()->is('admin/footer-setting*') ? ' active' : '' }}">
                            <a href="{{ route('footer.show') }}" title="{{ __('Footer Settings') }}">
                                <span class="sidebar-icon">
                                    <i class="flaticon-record-button"></i>
                                </span>
                                <span class="submenu-title">{{ __('Footer Settings') }}</span>
                            </a>
                        </li>
                    @endcan

                    @can('pwa.manage')
                        <li>
                            <a href="{{ url('admin/pwa-setting') }}" title="{{ __('PWA Settings') }}">
                                <span class="sidebar-icon">
                                    <i class="flaticon-record-button"></i>
                                </span>
                                <span class="submenu-title">{{ __('PWA Settings') }}</span>
                            </a>
                        </li>
                    @endcan

                    @can('seo.manage')
                        <li>
                            <a href="{{ url('admin/seo_setting') }}" title="{{ __('SEO Settings') }}">
                                <span class="sidebar-icon">
                                    <i class="flaticon-record-button"></i>
                                </span>
                                <span class="submenu-title">{{ __('SEO Settings') }}</span>
                            </a>
                        </li>
                    @endcan

                    @can('login_signup.manage')
                        <li>
                            <a href="{{ route('login_signup.index') }}" title="{{ __('Login & Signup') }}">
                                <span class="sidebar-icon">
                                    <i class="flaticon-record-button"></i>
                                </span>
                                <span class="submenu-title">{{ __('Login & Signup') }}</span>
                            </a>
                        </li>
                    @endcan

                    @can('openai.manage')
                        <li>
                            <a href="{{ route('openai') }}" title="{{ __('Open Ai') }}">
                                <span class="sidebar-icon">
                                    <i class="flaticon-record-button"></i>
                                </span>
                                <span class="submenu-title">{{ __('Open Ai') }}</span>
                            </a>
                        </li>
                    @endcan
                </ul>
            </li>
        @endcanany

        @canany(['admin.manage'])
            <li class="">
                <a href="#" title="{{ __('Admin Setting') }}" class="menu">
                    <span class="sidebar-icon">
                        <i class="flaticon-admin"></i>
                    </span>
                    <span class="sidebar-title">{{ __('Admin Setting') }}</span>
                    <span class="right-arrow">
                        <i class="flaticon-down-arrow"></i>
                    </span>
                </a>
                <ul class="vertical-submenu">
                    @can('admin.manage')
                        <li>
                            <a href="{{ route('admincolor.index') }}" title="{{ __('Color Settings') }}">
                                <span class="sidebar-icon">
                                    <i class="flaticon-record-button"></i>
                                </span>
                                <span class="submenu-title">{{ __('Color Settings') }}</span>
                            </a>
                        </li>
                    @endcan

                    @can('admin.manage')
                        <li>
                            <a href="{{ route('adminsetting.index') }}" title="{{ __('Admin Settings') }}">
                                <span class="sidebar-icon">
                                    <i class="flaticon-record-button"></i>
                                </span>
                                <span class="submenu-title">{{ __('Admin Settings') }}</span>
                            </a>
                        </li>
                    @endcan
                </ul>
            </li>
        @endcanany

        @canany(['payment-setting.manage'])
            <li class="{{ request()->is('payment-gateway*') ? ' active' : '' }}">
                <a href="{{ url('admin/payment-gateway') }}" title="{{ __('Payment Gateways') }}" class="menu">
                    <span class="sidebar-icon">
                        <i class="flaticon-gear"></i>
                    </span>
                    <span class="sidebar-title">{{ __('Payment Gateways') }}</span>
                </a>
            </li>
        @endcan

        @can('manual-payment.manage')
            <li class="{{ request()->is('manual_payment*') ? ' active' : '' }}">
                <a href="{{ url('admin/manual_payment') }}" title="{{ __('Manual Payment') }}" class="menu">
                    <span class="sidebar-icon">
                        <i class="flaticon-gear"></i>
                    </span>
                    <span class="sidebar-title">{{ __('Manual Payment') }}</span>
                </a>
            </li>
        @endcan

        @canany(['contact.view', 'support_type.view', 'support.manage', 'database.manage'])
            <li class="menu-title mb-0">
                <span>{{ __('Support') }}</span>
            </li>
            <li
                class="{{ Request::is('admin/contact*') || Request::is('admin/support_type*') || Request::is('admin/support_admin*') || Request::is('admin/support*') || Request::is('admin/import-demo*') || Request::is('admin/database-backup*') || Request::is('admin/remove-public*') || Request::is('admin/clear*') ? 'active' : '' }}">
                <a href="#" title="{{ __('Help & Support') }}" class="menu">
                    <span class="sidebar-icon">
                        <i class="flaticon-help"></i>
                    </span>
                    <span class="sidebar-title">{{ __('Help & Support') }}</span>
                    <span class="right-arrow">
                        <i class="flaticon-down-arrow"></i>
                    </span>
                </a>
                <ul class="vertical-submenu">

                    @can('contact.view')
                        <li class="{{ Request::is('admin/contact*') ? 'active' : '' }}">
                            <a href="{{ url('admin/contact') }}" title="{{ __('Contact') }}">
                                <span class="sidebar-icon">
                                    <i class="flaticon-record-button"></i>
                                </span>
                                <span class="submenu-title">{{ __('Contact') }}</span>
                            </a>
                        </li>
                    @endcan

                    @can('support_type.view')
                        <li class="{{ request()->is('admin/support_type*') ? 'active' : '' }}">
                            <a href="{{ url('admin/support_type') }}" title="{{ __('Support Type') }}">
                                <span class="sidebar-icon">
                                    <i class="flaticon-record-button"></i>
                                </span>
                                <span class="submenu-title">{{ __('Support Type') }}</span>
                            </a>
                        </li>
                    @endcan


                    @can('support.manage')
                        <li
                            class="{{ request()->is('admin/support_admin*') && !request()->is('admin/support*') ? 'active' : '' }}">
                            <a href="{{ url('admin/support_admin') }}" title="{{ __('Support Admin') }}">
                                <span class="sidebar-icon">
                                    <i class="flaticon-record-button"></i>
                                </span>
                                <span class="submenu-title">{{ __('Support Admin') }}</span>
                            </a>
                        </li>
                    @endcan


                    @can('support.view')
                        <li
                            class="{{ request()->is('admin/support*') && !request()->is('admin/support_type*') && !request()->is('admin/support_admin*') ? 'active' : '' }}">
                            <a href="{{ url('admin/support') }}" title="{{ __('Support') }}">
                                <span class="sidebar-icon">
                                    <i class="flaticon-record-button"></i>
                                </span>
                                <span class="submenu-title">{{ __('Support') }}</span>
                            </a>
                        </li>
                    @endcan

                    @can('database.manage')
                        <li class="{{ Request::is('admin/import-demo*') ? 'active' : '' }}">
                            <a href="{{ url('admin/import-demo') }}" title="{{ __('Import Demo') }}">
                                <span class="sidebar-icon">
                                    <i class="flaticon-record-button"></i>
                                </span>
                                <span class="submenu-title">{{ __('Import Demo') }}</span>
                            </a>
                        </li>
                        <li class="{{ Request::is('admin/database-backup*') ? 'active' : '' }}">
                            <a href="{{ url('admin/database-backup') }}" title="{{ __('Database Backup') }}">
                                <span class="sidebar-icon">
                                    <i class="flaticon-record-button"></i>
                                </span>
                                <span class="submenu-title">{{ __('Database Backup') }}</span>
                            </a>
                        </li>
                        <li class="{{ Request::is('admin/remove-public*') ? 'active' : '' }}">
                            <a href="{{ url('admin/remove-public') }}" title="{{ __('Remove Public') }}">
                                <span class="sidebar-icon">
                                    <i class="flaticon-record-button"></i>
                                </span>
                                <span class="submenu-title">{{ __('Remove Public') }}</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ url('/clear') }}" title="{{ __('Clear Cache') }}">
                                <span class="sidebar-icon">
                                    <i class="flaticon-record-button"></i>
                                </span>
                                <span class="submenu-title">{{ __('Clear Cache') }}</span>
                            </a>
                        </li>
                    @endcan
                </ul>
            </li>
        @endcanany
    </ul>
</div>

<!-- End Sidebar -->
