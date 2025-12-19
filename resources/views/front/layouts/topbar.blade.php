<!-- Top-bar Start -->
<div id="top-bar" class="top-bar-main-block">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-1 col-md-3 col-8">
                <div class="logo">
                    <a href="{{ route('home.page') }}" title="{{ $top->logo }}">
                        <img src="{{ asset('images/logo/' . $top->logo) }}" class="img-fluid" alt="{{ $top->logo }}">
                    </a>
                </div>
            </div>
            <div class="col-lg-6 col-md-9 col-4">
                <nav class="navbar navbar-expand-lg navbar-expand-md">
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                        data-bs-target="#navbarContent" aria-controls="navbarContent" aria-expanded="false"
                        aria-label="Toggle navigation">
                        <i class="flaticon-menu"></i>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarContent">
                        <div class="nav-item">
                            <a href="{{ url('/') }}" title="{{ __('home') }}"
                                class="btn btn-primary nav-link {{ request()->is('/') ? 'active' : '' }}">{{ __('Home') }}</a>
                        </div>
                        <div class="nav-item">
                            <a href="{{ url('leaderboard') }}" title="{{ __('Leaderboard') }}"
                                class="btn btn-primary nav-link {{ request()->is('leaderboard') ? 'active' : '' }}">{{ __('Leaderboard') }}</a>
                        </div>
                        <div class="nav-item">
                            <a href="{{ route('discover.page') }}" title="{{ __('Discover') }}"
                                class="btn btn-primary nav-link {{ request()->is('discover') ? 'active' : '' }}">{{ __('Discover') }}</a>
                        </div>
                        <div class="nav-item">
                            <a href="{{ route('blog.page') }}" title="{{ __('Blogs') }}"
                                class="btn btn-primary nav-link {{ request()->routeIs('blog.page') ? 'active' : '' }}">{{ __('Blogs') }}</a>
                        </div>
                        @if (auth()->check())
                            <div class="nav-item">
                                <a href="{{ route('my.friends') }}" title="{{ __('My friends') }}"
                                    class="btn btn-primary nav-link {{ request()->routeIs('my.friends') ? 'active' : '' }}">{{ __('My friends') }}</a>
                            </div>
                            <div class="nav-item">
                                <a href="{{ route('battle.setup') }}" title="{{ __('Battle') }}"
                                    class="btn btn-primary nav-link {{ request()->routeIs('battle.setup') ? 'active' : '' }}">{{ __('Battle') }}</a>
                            </div>
                        @endif
                    </div>
                </nav>
            </div>
            <div class="col-lg-5 col-md-12 col-12">
                <div class="login-btn text-end">
                    <ul>
                        <li>
                            <div class="search-container">
                                <form id="search-form" action="/search" method="get">
                                    <input class="expandright search-input" id="searchright" type="search"
                                        name="query" placeholder="Search">
                                    <label class="button search-icon" for="searchright"><span class="mglass"><i
                                                class="flaticon-search-interface-symbol"></i></span></label>
                                </form>
                                <div id="search-results"></div>
                            </div>
                        </li>
                        <li>
                            @php
                                $language = App\Models\LanguageSetting::all();
                                $defaultlang = App\Models\LanguageSetting::where('status', 1)->first();
                            @endphp
                            <div class="dropdown">
                                <a href="#" id="dropdownToggle" class="btn language" title="language"
                                    type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    @if (isset($defaultlang))
                                        <img id="selectedFlag"
                                            src="{{ asset('/images/language/' . $defaultlang->image) }}"
                                            class="img-fluid language-img" alt="{{ __('default') }}">
                                    @endif
                                </a>
                                <ul class="dropdown-menu">
                                    @foreach ($language as $data)
                                        <li>
                                            <a class="dropdown-item"
                                                href="{{ route('languageSwitch', [$data->local, $data->image]) }}"
                                                onclick="selectLanguage('/{{ $data->image }}')">
                                                <img src="{{ asset('/images/language/' . $data->image) }}"
                                                    class="img-fluid" alt="{{ $data->name }}">
                                                {{ $data->name }} ({{ $data->local }})
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </li>
                        <li>
                            @php
                                $currencies = DB::table('currencies')->get();
                                $defaultcurrency = $currencies->where('default', 1)->first();
                            @endphp
                            <div class="dropdown">
                                <a class="currencies btn" href="#" title="currency" data-bs-toggle="dropdown"
                                    aria-expanded="true">
                                    @if ($defaultcurrency)
                                        {{ $defaultcurrency->symbol }}
                                    @endif
                                </a>
                                <ul class="dropdown-menu">
                                    @foreach ($currencies as $data)
                                        <li>
                                            <a class="dropdown-item"
                                                href="{{ route('currencySwitch', $data->symbol) }}">
                                                {{ $data->code }} ({{ $data->symbol }})
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </li>
                        @if (auth()->check())
                            <li>
                                <a href="{{ route('notifications.index') }}" title="{{ __('flaticon-bell') }}"><i
                                        class="flaticon-bell"></i>
                                    @if (auth()->user()->unreadNotifications->count() > 0)
                                        <span
                                            class=" notification-badge  translate-middle badge rounded-pill bg-danger">
                                            {{ auth()->user()->unreadNotifications->count() }}
                                        </span>
                                    @endif
                                </a>
                            </li>
                            <li>
                                <div class="dropdown">
                                    <button class="btn user-dropdown" type="button" data-bs-toggle="dropdown"
                                        aria-expanded="false">
                                        @if (!is_null(Auth::user()->image) && Auth::user()->image !== '')
                                            <img src="{{ asset('/images/users/' . Auth::user()->image) }}"
                                                class="img-fluid dropdown-img" alt="{{ Auth::user()->name }}">
                                        @else
                                            <img src="{{ Avatar::create(Auth::user()->name)->toBase64() }}"
                                                class="img-fluid dropdown-img" alt="{{ Auth::user()->name }}">
                                        @endif
                                    </button>
                                    <ul class="dropdown-menu">
                                        <div class="user-top-details">
                                            @if (!is_null(Auth::user()->image) && Auth::user()->image !== '')
                                                <img src="{{ asset('/images/users/' . Auth::user()->image) }}"
                                                    class="img-fluid user-top-image" alt="{{ Auth::user()->name }}">
                                            @else
                                                <img src="{{ Avatar::create(Auth::user()->name)->toBase64() }}"
                                                    class="img-fluid user-top-image" alt="{{ Auth::user()->name }}">
                                            @endif
                                            <div class="user-txt">
                                                <h5 class="user-name"> {{ Auth::user()->name }} </h5>
                                                <p class="user-email"> {{ Auth::user()->email }} </p>
                                            </div>
                                        </div>
                                        <div class="scroll-lst">
                                            @if (Auth::user()->role == 'A')
                                                <a href="{{ route('admin.dashboard') }}" target="__blank"
                                                    title="{{ __('dashboard') }}"><i
                                                        class="flaticon-dashboard"></i>{{ __('Admin Dashboard') }}</a>
                                            @endif
                                            <a href="{{ route('profile.page') }}"
                                                title="{{ Auth::user()->name }}"><i
                                                    class="flaticon-user"></i>{{ __('My Profile') }}</a>
                                            @if (auth()->check() && Auth::user()->slug)
                                                <a href="{{ route('front.coins', ['user_slug' => Auth::user()->slug]) }}"
                                                    title="{{ __('coins') }}">
                                                    <i class="flaticon-money"></i>{{ __('Coins') }}
                                                </a>
                                            @endif
                                            {{-- <a href="{{ route('front.coins', ['user_slug' => Auth::user()->slug]) }}" title="{{ __('coins') }}"><i class="flaticon-money"></i>{{ __('Coins') }}</a> --}}
                                            {{-- <a href="{{ route('quiz.reports', ['user_slug' => Auth::user()->slug]) }}"
                                                title="{{ __('my reports') }}"><i
                                                    class="flaticon-report"></i>{{ __('My Reports') }}</a> --}}
                                            @if (auth()->check() && Auth::user()->slug)
                                                <a href="{{ route('quiz.reports', ['user_slug' => Auth::user()->slug]) }}"
                                                    title="{{ __('my reports') }}"><i
                                                        class="flaticon-report"></i>{{ __('My Reports') }}</a>
                                            @endif
                                            <a href="{{ route('find.friends') }}" title="{{ 'Add Friends' }}"><i
                                                    class="flaticon-add-user"></i>{{ __('Add Friends') }}</a>
                                            <a href="{{ route('contact.us') }}" title="{{ 'Contact Us' }}"><i
                                                    class="flaticon-contact-us"></i>{{ __('Contact Us') }}</a>
                                        </div>
                                        <div class="dropdown-logout-btn">
                                            <a class="btn btn-primary" href="{{ route('logout') }}"
                                                title="{{ __('logout') }}"><i
                                                    class="flaticon-power-off"></i>{{ __('Logout') }}</a>
                                        </div>
                                    </ul>
                                </div>
                            </li>
                        @else
                            <li><a href="{{ route('login') }}" title="{{ __('login') }}"
                                    class="btn-primary nav-bar-btn">{{ __('Log in') }}</a></li>
                            <li><a href="{{ url('register') }}" title="{{ __('Sign up') }}"
                                    class="btn-primary nav-bar-btn">{{ __('Sign Up') }}</a></li>
                        @endif
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Top-bar End -->
