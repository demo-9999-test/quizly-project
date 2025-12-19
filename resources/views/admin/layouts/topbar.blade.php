<!-- Start Topbar -->
<div class="topbar-two position-fixed topbar-fullscreen">
    <div class="row align-items-center">
        <div class="col-lg-1 col-md-10">
            <div class="container-wide">
                <a id="sidebar-toggle" class="sidebar-toggle nav-link" href="javascript:void(0)">
                    <span class="collapsed-icon-one">
                        <i class="flaticon-angle-square-left"></i>
                    </span>
                    <span class="collapsed-icon">
                        <i class="flaticon-angle-square-right"></i>
                    </span>
                </a>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="togglebar">
                <div class="input-group search-input">
                    <input type="text" class="form-control" id="searchInput1" placeholder="{{ __('Search here...') }}"
                        autocomplete="off">
                    <span class="input-group-text">
                        <a href="javascript:void(0)">
                            <i class="flaticon-loupe"></i>
                        </a>
                    </span>
                </div>
            </div>
            <ul id="resultList1" class="transparent-background "></ul>
        </div>
        <div class="col-lg-8">
            <ul class="topbar-options">
                <li>
                    <div class="visit-site-icon">
                        <a href="{{ route('home.page') }}" class="pink" target="_blank" title="{{ __('Visit Site') }}"><i
                                class="flaticon-internet"></i></a>
                    </div>
                </li>
                <li>
                    <div class="visit-site-icon">
                        <a href="javascript:void(0)" title="{{ __('AI Tool') }}" class="menu-tigger cyan "><i
                                class="flaticon-ai"></i></a>
                        @include('admin.openai.topbar')
                    </div>
                </li>
                <li>
                    @php
                    $language = App\Models\LanguageSetting::all();
                    $defaultlang = App\Models\LanguageSetting::where('status', 1)->first();
                    @endphp
                    <div class="dropdown">
                        <a href="#" id="dropdownToggle" class="btn dropdown-toggle lgt_purple " title="language" type="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            @if(isset($defaultlang))
                            <img id="selectedFlag" src="{{ asset('/images/language/' . $defaultlang->image) }}"
                                class="img-fluid" alt="{{ __('default') }}">
                            @endif
                        </a>
                        <ul class="dropdown-menu">
                            @foreach ($language as $data)
                            <li>
                                <a class="dropdown-item"
                                    href="{{ route('languageSwitch', [$data->local, $data->image]) }}"
                                    onclick="selectLanguage('/{{ $data->image }}')">
                                    <img src="{{ asset('/images/language/' . $data->image) }}" class="img-fluid"
                                        alt="{{ $data->name }}">
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
                        <a class="language dropdown-toggle red" href="#" title="currency"
                            data-bs-toggle="dropdown" aria-expanded="true">
                            @if($defaultcurrency)
                            {{ $defaultcurrency->symbol }}
                            @endif
                        </a>
                        <ul class="dropdown-menu">
                            @foreach ($currencies as $data)
                            <li>
                                <a class="dropdown-item" href="{{ route('currencySwitch', $data->symbol) }}">
                                    {{ $data->code }} ({{ $data->symbol }})
                                </a>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                </li>
                <li>
                    <div class="full-small-screen">
                        <a href="#" title="fullscreen" class="yellow"><i class="flaticon-expand fullscreen-icon"
                                id="fullscreen-icon"></i></a>
                    </div>
                </li>
                <li class="dark-light-mode">
                    <div class="toggle-container">
                        <a href="javascript:void(0)" id="modeSwitch1" class="green_blue">
                            <i class="modeIcon flaticon-sun-1" id="modeIcon1"></i>
                        </a>
                    </div>
                </li>
                <li>
                    <div class="dropdown">
                        <a href="#" class="btn purple dropdown-toggle" title="{{ __('Notification') }}" type="button" data-bs-toggle="dropdown"
                            aria-expanded="false"><i class="flaticon-notification"></i></a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#">{{__('Action')}}</a></li>
                            <li><a class="dropdown-item" href="#">{{__('Another action')}}</a></li>
                            <li><a class="dropdown-item" href="#">{{__('Something else here')}}</a></li>
                        </ul>
                    </div>
                </li>
                <li>
                    <div class="dropdown">
                        <a class="btn dropdown-toggle blue" href="#" role="button" data-bs-toggle="dropdown"
                            aria-expanded="false"><i class="flaticon-user"></i>
                        </a>
                        <ul class="dropdown-menu">
                            <li>
                                <div class="user-dropdown">
                                    <div class="user-img">
                                        @if (!empty(Auth::user()->image))
                                        <img src="{{ asset('/images/users/' . Auth::user()->image) }}" class="img-fluid" alt="{{ Auth::user()->name }}">
                                        @else
                                        <img src="{{ Avatar::create(Auth::user()->name)->toBase64() }}" />
                                        @endif
                                    </div>
                                    <div class="user-detail">
                                        <h6 class="user-info">{{ Auth::user()->name }}</h6>
                                        <p><a href="javascript:void(0)" title="{{ Auth::user()->email }}">{{ Auth::user()->email }}</a>
                                        </p>
                                    </div>
                                </div>
                            </li>
                            <hr>
                            <li><a class="dropdown-item" href="{{ url('admin/profile') }}" title="My Account"><i class="flaticon-user"></i> My Account</a></li>
                            <li><a class="dropdown-item" href="{{ route('logout') }}" title="Logout"><i class="flaticon-turn-off"></i> Logout</a></li>
                        </ul>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</div>
<!-- End Topbar -->
