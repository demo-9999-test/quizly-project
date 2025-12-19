@extends('front.layouts.master')
@section('title', 'Quizz')
@section('content')

<!-- Breadcrumb start -->
<div id="breadcrumb" class="breadcrumb-main-block"
    @if(isset($setting->breadcrumb_img) && $setting->breadcrumb_img)
        style="background-image: url('{{ asset('images/breadcrumb/'.$setting->breadcrumb_img) }}')"
    @endif
>
    <div class="overlay-bg"></div>
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center ">
                <nav  style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                    <h2 class="breadcrumb-title mb_30">{{__('Profile')}}</h2>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('home.page')}}" title="{{__('Home')}}">{{__('Home')}}</a></li>
                        <li class="breadcrumb-item active">{{__('Profile')}} </li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</div>
<!-- Breadcrumb end -->

<!-- Profile Start -->
<section id="profile" class="profile-main-block">
    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-md-4">
                <div class="profile-sidebar">
                    <div class="user-profile mb_20">
                        @if(auth()->user()['image'] !== NULL && auth()->user()['image'] !== '')
                        <div class="user-img">
                            <img src="{{asset('/images/users/' . Auth::user()->image) }}" class="img-fluid" alt="">
                        </div>
                        @else
                        <div class="user-img">
                            <img src="{{ Avatar::create(auth()->user()->name)->toBase64() }}" class="img-fluid" alt="{{ auth()->user()->name }}">
                        </div>
                        @endif
                        <div class="user-txt">
                            <h4 class="user-name">{{ auth()->user()->name }}</h4>
                            <p  class="user-email">{{ auth()->user()->email }}</p>
                        </div>
                    </div>
                    <ul class="nav nav-tabs flex-column" id="myTab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="about-tab" data-bs-toggle="tab" href="#about" role="tab" aria-controls="about" aria-selected="true"><i class="flaticon-info-button"></i>{{ __('About')}}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="bookmark-tab" data-bs-toggle="tab" href="#bookmark" role="tab" aria-controls="bookmark" aria-selected="false"><i class="flaticon-bookmark"></i>{{ __('Bookmark')}}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="refer-tab" data-bs-toggle="tab" href="#refer" role="tab" aria-controls="refer" aria-selected="false"><i class="flaticon-refer"></i>{{ __('Refer And Earn')}}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="how-to-play-tab" data-bs-toggle="tab" href="#how-to-play" role="tab" aria-controls="how-to-play" aria-selected="false"><i class="flaticon-ask"></i>{{ __('How To Play')}}</a>
                        </li>
                        @if(auth()->user()->role != 'A')
                        <li class="nav-item">
                            <a class="nav-link" id="plans-tab" data-bs-toggle="tab" href="#plans" role="tab" aria-controls="plans" aria-selected="false"><i class="flaticon-tag"></i>{{ __('Purchase Coins')}}</a>
                        </li>
                        @endif
                        <li class="nav-item">
                            <a class="nav-link" id="setting-tab" data-bs-toggle="tab" href="#setting" role="tab" aria-controls="setting" aria-selected="false"><i class="flaticon-settings"></i>{{ __('Settings')}}</a>
                        </li>
                        @if(auth()->user()->role != 'A')
                        <li class="nav-item">
                            <a class="nav-link" id="delete-account-tab" data-bs-toggle="tab" href="#delete-account" role="tab" aria-controls="delete-account" aria-selected="false"><i class="flaticon-delete"></i>{{ __('Delete Account')}}</a>
                        </li>
                        @endif
                    </ul>
                </div>
            </div>
            <div class="col-lg-9 col-md-8">
                <div class="container">
                    <div class="tab-content">
                        <!-- Profile end -->

                        <!-- Start About user -->
                        <div class="tab-pane fade show active" id="about" role="tabpanel" aria-labelledby="about-tab">
                            <h3 class="about-heading mb_10">{{ __('About Me')}}</h3>
                            @if( !auth()->user()->desc)
                                <p>{{__('Add Bio from setting')}}</p>
                            @else
                            <div class="about-me-txt">
                                {!! auth()->user()->desc !!}
                            </div>
                            @endif
                            <hr>
                            <ul class="about-user-lst mb_30">
                                @if( !auth()->user()->state && !auth()->user()->country )
                                <p>{{__('Add Location from setting')}}</p>
                                @else
                                <li><i class="flaticon-location"></i>{{ auth()->user()->state . ', ' . auth()->user()->country}}</li>
                                @endif
                                @if( !auth()->user()->age )
                                <p>{{__('Add age from setting')}}</p>
                                @else
                                <li><i class="flaticon-age"></i>{{ auth()->user()->age.' Years Old' }}</li>
                                @endif
                            </ul>
                            <div class="user-badges mb_30">
                                <div class="row">
                                    <div class="col-lg-6 col-md-6">
                                        <h3 class="user-badge-heading mb_30">{{__('User Badges')}}</h3>
                                    </div>
                                    <div class="col-lg-6 col-md-6 text-end">
                                        <a href="{{ route('badge.page') }}" title="{{ __('Badges') }}" class="btn see-all-btn">{{__('See Badges')}}</a>
                                    </div>
                                </div>
                                <div class="row">
                                    @if(isset($badges) && $badges->isNotEmpty())
                                        @foreach($badges as $data)
                                            <div class="col-lg-2 col-2 text-center">
                                                <div class="badge-block">
                                                    <div class="badge-img">
                                                        <img src="{{asset('images/badge/'.$data->image)}}" class="img-fluid" alt="{{$data->name}}">
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    @else
                                        <div class="col-12 text-center">
                                            <p>{{ __('You have no badges yet.') }}</p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                            @if(auth()->user()->show_mobile == 1 && auth()->user()->show_email == 1 )
                            <div class="user-contact mb_30">
                                <h3 class="about-heading mb_10">{{__('Contact Me')}}</h3>
                                <div class="row">
                                    @if(auth()->user()->show_mobile == 1 )
                                        @if(auth()->user()->mobile)
                                            <div class="col-lg-4 col-6">
                                                <div class="contact-user-block">
                                                    <div class="contact-icon">
                                                        <i class="flaticon-telephone"></i>
                                                    </div>
                                                    <div class="contact-dtls">
                                                        <h5 class="contact-heading">{{__('Phone Number')}}</h5>
                                                        <a href="tel:" title="">{{auth()->user()->mobile}}</a>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    @endif
                                    @if(auth()->user()->show_email == 1 )
                                        <div class="col-lg-4 col-6">
                                            <div class="contact-user-block mb_10">
                                                <div class="contact-icon">
                                                    <i class="flaticon-mail"></i>
                                                </div>
                                                <div class="contact-dtls">
                                                    <h5 class="contact-heading">{{__('Email')}}</h5>
                                                    <a href="mailto:" title="{{ auth()->user()->email }}">{{ auth()->user()->email }}</a>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                            @endif
                            <div class="follow">
                                @if($socialMedia->isNotEmpty())
                                <div class="follow">
                                    <h3 class="about-heading mb_10">{{ __('Follow Me') }}</h3>
                                    <div class="user-social">
                                        <ul>
                                            @foreach($socialMedia as $social)
                                                @switch($social->type)
                                                    @case('facebook')
                                                        @if($social->url)
                                                        <li><a href="{{ $social->url }}" title="Facebook"><i class="flaticon-facebook"></i></a></li>
                                                        @endif
                                                        @break
                                                    @case('instagram')
                                                        @if($social->url)
                                                        <li><a href="{{ $social->url }}" title="Instagram"><i class="flaticon-instagram"></i></a></li>
                                                        @endif
                                                        @break
                                                    @case('twitter')
                                                        @if($social->url)
                                                        <li><a href="{{ $social->url }}" title="Twitter"><i class="flaticon-twitter"></i></a></li>
                                                        @endif
                                                        @break
                                                    @case('linkedIn')
                                                        @if($social->url)
                                                        <li><a href="{{ $social->url }}" title="LinkedIn"><i class="flaticon-linkedin"></i></a></li>
                                                        @endif
                                                        @break
                                                @endswitch
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>
                        <!-- End About user -->

                        <!-- Start Bookmarks -->
                        <div class="tab-pane fade" id="bookmark" role="tabpanel" aria-labelledby="bookmark-tab">
                            <h3 class="bookmark-heading mb_10">{{__('Bookmarks')}}</h3>
                            <p class="bookmark-txt mb_30">{{__('Quiz you bookmarked')}}</p>
                            <div class="bookmark-block">
                                <div class="row">
                                    @if($bookmark->isEmpty())
                                    <div class="nothing-here-block">
                                        <div class="row">
                                            <div class="col-md-12 text-center">
                                                <img src="{{asset('images/nothing-here/nothing-01.jpg')}}" class="img-fluid mb_30" alt="{{__('Nothing here')}}">
                                                <h2>{{__('No quiz is bookmarked yet')}}</h2>
                                            </div>
                                        </div>
                                    </div>
                                    @else
                                    @foreach ($bookmark as $data )
                                        @if ($data->user->id == auth()->user()->id)
                                        <div class="col-lg-5 mb_30">
                                        @if($data->quiz)
                                            <div class="discover-block">
                                                @if($data->quiz['image'] !== NULL && $data->quiz['image'] !== '')
                                                <div class="discover-image mb_20">
                                                    <button class="bookmark-btn active" data-quiz-id="{{ $data->quiz->id }}">
                                                        <i class="flaticon-bookmark"></i>
                                                    </button>
                                                <a href="{{route('home.page')}}" title="{{$data->quiz->name}}"> <img src="{{asset('images/quiz/'.$data->quiz->image)}}" class="img-fluid" alt="{{$data->quiz->name}}"></a>
                                                </div>
                                                @else
                                                <div class="discover-image mb_10">
                                                    <button id="bookmark-btn-{{ $data->quiz->id }}" class="bookmark-btn btn btn-primary" data-quiz-id="{{ $data->quiz->id }}">
                                                        <i class="flaticon-bookmark"></i>
                                                    </button>
                                                    <a href="{{route('home.page')}}" title="{{$data->quiz->name}}"><img src="Avatar::create($data->name)->toBase64()" class="img-fluid" alt="{{$data->quiz->name}}"></a>
                                                </div>
                                                @endif
                                                <div class="discover-dtls">
                                                    <a href="{{route('home.page')}}" title="{{$data->quiz->name}}"><h4 class="discover-title mb_20">{{$data->quiz->name}}</h4></a>
                                                    <ul class="discover-lst mb_30">
                                                        <li>
                                                            <p class="discover-lst-txt"><i class="flaticon-calendar"></i>
                                                                {{__('Ends On')}}</p>
                                                            <h5 class="discover-lst-title">{{$data->quiz->end_date}}</h5>
                                                        </li>
                                                        <li><div class="line"></div></li>
                                                        <li>
                                                            <p class="discover-lst-txt"><i class="flaticon-team-leader"></i>{{__('Players')}}</p>
                                                            <h5 class="discover-lst-title">{{ \App\Models\SubjectiveAnswer::where('quiz_id', $data->id)->distinct('user_id')->count() }}</h5>
                                                        </li>
                                                    </ul>
                                                    <div class="row">
                                                        <div class="col-lg-6 col-6">
                                                            <a href="quiz.html" title="{{$data->quiz->name}}" class="btn btn-primary play-btn">{{__('Play Now')}}</a>
                                                        </div>
                                                        <div class="col-lg-6 col-6 text-end">
                                                            <p class="entry-txt">{{__('Entry fees')}}</p>
                                                            @if($data->quiz->service =='1')
                                                            <p class="coin-txt"><i class="flaticon-coin-1"></i>{{$data->quiz->fees}}</p>
                                                            @else
                                                            <p class="coin-txt"><i class="flaticon-coin-1"></i>{{ __('Free')}}</p>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                        </div>
                                        @endif
                                    @endforeach
                                    @endif
                                </div>
                            </div>
                        </div>
                        <!-- End Bookmarks -->

                        <!-- Start Refer & Earn -->
                        <div class="tab-pane fade" id="refer" role="tabpanel" aria-labelledby="refer-tab">
                            <h3 class="refers-heading mb_10">{{$affiliate->title}}</h3>
                            <p class="refers-txt mb_30">{{strip_tags($affiliate->desc)}} <span><a href="#" title="">{{__('Redeem Now')}}</a></span></p>
                            <div class="refers-block">
                                <h2 class="refers-block-heading mb_30">{{$affiliate->sub_title}} <span>{{$affiliate->point_per_referral}}</span></h2>
                                <div class="row">
                                    <div class="col-lg-8">
                                        <div class="input-group mb-3">
                                            <input type="text" id="myInput" class="form-control form-control-padding_15" value="{{ url('/register') . '/?ref=' . Auth::user()->affiliate_id }}" readonly>
                                            <button class="btn btn-primary" id="refer-link">{{__('Copy Link')}}</button>
                                        </div>
                                        @if(auth()->user()->affiliate_id == NULL)
                                        <form id="mainform" action="{{ route('generate.affiliate') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="affront" value="front" id="">
                                            <button type="submit" class="pull-left btn btn-primary"
                                                title=" {{ __('Generate Affiliate Link') }}">
                                                {{ __('Generate Affiliate Link') }}
                                            </button>
                                        </form>
                                        @endif
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="qr-code-block text-center">
                                            <div class="card-body">
                                                <?php
                                                $path= url('/register') . '/?ref=' . Auth::user()->affiliate_id;
                                            ?>
                                                {!! QrCode::size(200)->generate($path) !!}
                                                <h5 class="qr-code-title mt-3">{{__('Scan QR Code')}}</h5>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- End Refer & Earn -->

                        <!-- Start About how to play -->
                        <div class="tab-pane fade" id="how-to-play" role="tabpanel" aria-labelledby="how-to-play-tab">
                            <h3 class="play-heading mb_30">{{__('How to play?')}}</h3>
                            <div class="accordion accordion-flush" id="accordionFlushExample">
                                @foreach ($faq as $data)
                                    <div class="accordion-item">
                                        <h2 class="accordion-header">
                                            <button class="accordion-button {{ $loop->first ? '' : 'collapsed' }}" type="button" data-bs-toggle="collapse" data-bs-target="#faq-{{ $loop->index }}" aria-expanded="{{ $loop->first ? 'true' : 'false' }}" aria-controls="faq-{{ $loop->index }}">
                                                {{ $data->question }}
                                            </button>
                                        </h2>
                                        <div id="faq-{{ $loop->index }}" class="accordion-collapse collapse {{ $loop->first ? 'show' : '' }}" data-bs-parent="#accordionFlushExample">
                                            <div class="accordion-body">
                                                {{ strip_tags($data->answer) }}
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <!-- End About how to play -->

                        <!-- Start Plans -->
                        <div class="tab-pane fade" id="plans" role="tabpanel" aria-labelledby="plans-tab">
                            <h3 class="plans-heading mb_10">{{__('Select Your Plans')}}</h3>
                            <p class="plan-txt mb_30">{{__('Select plans and buy coins')}}</p>
                            <div class="row">
                                @foreach ($plan as $data )
                                <div class="col-lg-4 col-md-6">
                                    <div class="plan-block basic-plan mb_30 text-center">
                                        <h5 class="plan-block-heading mb_10">{{$data->pname}}</h5>
                                        @php
                                            $currency = DB::table('currencies')->where('default',1)->first();
                                        @endphp
                                        <h4 class="plan-rate mb_10">{{$currency->symbol}} {{ currencyConverter($data->currency, $currency->code,
                                        $data->plan_amount)}}</h4>
                                        <div class="plan-rate-profile-icon mb_10">
                                            <i class="flaticon-coin"></i>
                                        </div>
                                        <h5 class="plan-coins mb_10">{{$data->preward.' Coins'}}</h5>
                                        <a href="{{route('checkout.page',['id' => $data->id])}}" title="{{__('Purchase')}}" class="btn btn-primary plan-btn ">{{__('Purchase')}}</a>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        <!-- End Plans -->

                        <!-- Settings -->
                        <div class="tab-pane fade" id="setting" role="tabpanel" aria-labelledby=setting-tab">
                            <section id="settings" class="settings-main-block">
                                <div class="container">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="setting-block mb_30">
                                                <h3 class="setting-block-heading mb_30">{{__('User Settings')}}</h3>
                                                <form method="POST" action="{{route('front.profile.update',['id' => $user->id])}}" enctype="multipart/form-data">
                                                    @csrf
                                                    <div class="row">
                                                        <div class="col-lg-12 col-md-12 mb_30">
                                                            <div class="row align-items-center">
                                                                <div class="col-lg-3 col-md-12 text-center">
                                                                    @if(auth()->user()->image)
                                                                        <img src="{{ asset('images/users/' . auth()->user()->image) }}" class="img-fluid settings-img" alt="{{ auth()->user()->name }}">
                                                                    @else
                                                                        <img src="{{ Avatar::create(auth()->user()->name)->toBase64() }}" class="img-fluid settings-img" alt="{{ auth()->user()->name }}">
                                                                    @endif
                                                                </div>
                                                                <div class="col-lg-9 col-md-12">
                                                                    <div class="user-img-btns">
                                                                        <button type="button" class="btn btn-primary" id="add-image-button">{{ __('Add Picture') }}</button>
                                                                        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#staticBackdrop">{{ __('Remove Picture') }}</button>
                                                                        <input type="file" id="image" name="image" class="form-control d-none" accept="image/*">
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <!-- Modal for confirming remove picture -->
                                                            <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                                                <div class="modal-dialog">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <h5 class="modal-title">{{__('Confirm Removal')}}</h5>
                                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                        </div>
                                                                    <div class="modal-body">
                                                                        {{__('Are you sure you want to remove the profile picture?')}}
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('Cancel')}}</button>
                                                                        <button type="button" class="btn btn-danger" id="remove-confirm-button">{{__('Yes')}}</button>
                                                                    </div>
                                                                </div>
                                                                </div>
                                                            </div>

                                                            <!-- Flash message placeholder -->
                                                        </div>
                                                        <div class="col-lg-3 col-md-6">
                                                            <div class="form-group">
                                                                <label for="name" class="form-label">{{__('Name')}}</label>
                                                                <input type="text" class="form-control" id="name" placeholder="Enter your name" value="{{ auth()->user()->name ?? '' }}" name="name">
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-3 col-md-6">
                                                            <div class="form-group">
                                                                <label for="Username" class="form-label">{{__('Username')}}</label>
                                                                <input type="text" class="form-control" id="Username" placeholder="Enter your username" value="{{ auth()->user()->slug ?? '' }}" name="Username">
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-4 col-md-6">
                                                            <div class="form-group">
                                                                <label for="email" class="form-label">{{__('Email address')}}</label>
                                                                <input type="email" class="form-control" id="email" placeholder="Enter your email" value="{{ isset(auth()->user()->email) ? auth()->user()->email : '' }}" name="email">
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-3 col-md-6">
                                                            <div class="form-group">
                                                                <label for="contactNumber" class="form-label">{{__('Contact Number')}}</label>
                                                                <input type="tel" class="form-control" id="contactNumber" placeholder="Enter your contact number" value="{{ isset(auth()->user()->mobile) ? auth()->user()->mobile : '' }}" name="mobile">
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-2 col-md-6">
                                                            <div class="form-group">
                                                                <label for="age" class="form-label">{{__('Age')}}</label>
                                                                <input type="number" class="form-control" id="age" placeholder="Enter your age" value="{{ isset(auth()->user()->age) ? auth()->user()->age : '' }}" name="age">
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-3 col-md-6">
                                                            <div class="form-group">
                                                                <label for="slug" class="form-label">{{ __('City') }}</label>
                                                                <input class="form-control city_id" type="text" name="city"
                                                                    placeholder="{{ __('Please Enter Your City Name') }}" aria-label="city"
                                                                    onchange="get_state_country(this.value)" required value="{{ auth()->user()->city }}">
                                                                <input type="hidden" name="city" class="city_id" value="{{ auth()->user()->city }}">
                                                                <div class="form-control-icon"><i class="flaticon-building"></i></div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-3 col-md-6">
                                                            <div class="form-group">
                                                                <label for="slug" class="form-label">{{ __('State') }}</label>
                                                                <input class="form-control state_id" type="text" name="state"
                                                                    placeholder="{{ __('Please Enter Your State Name') }}" aria-label="state"
                                                                    readonly value="{{ auth()->user()->state }}">
                                                                <input type="hidden" name="state" class="state_id" value="{{ auth()->user()->state }}">
                                                                <div class="form-control-icon"><i class="flaticon-government"></i></div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-3 col-md-6">
                                                            <div class="form-group">
                                                                <label for="slug" class="form-label">{{ __('Country') }}</label>
                                                                <input class="form-control country_id" type="text" name="country"
                                                                    placeholder="{{ __('Please Enter Your Country Name') }}" aria-label="country"
                                                                    readonly value="{{ auth()->user()->country }}">
                                                                <input type="hidden" name="country" class="country_id" value="{{ auth()->user()->country }}">
                                                                <div class="form-control-icon"><i class="flaticon-maps"></i></div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-3 col-md-6">
                                                            <div class="form-group">
                                                                <label for="show_mobile" class="form-label">{{ __('Show contact number') }}</label>
                                                                <div class="form-check form-switch">
                                                                    <input class="form-check-input @error('show_mobile') is-invalid @enderror" type="checkbox" role="switch" id="show_mobile" name="show_mobile" value="1" {{ $user->show_mobile ? 'checked' : '' }}>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-3 col-md-6">
                                                            <div class="form-group">
                                                                <label for="show_email" class="form-label">{{ __('Show email') }}</label>
                                                                <div class="form-check form-switch">
                                                                    <input class="form-check-input @error('show_email') is-invalid @enderror" type="checkbox" role="switch" id="show_email" name="show_email" value="1" {{ $user->show_email ? 'checked' : '' }}>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-12 col-md-12">
                                                            <div class="form-group">
                                                                <label for="desc" class="form-label">{{__('Description')}}</label>
                                                                <textarea class="form-control" id="desc" rows="4" placeholder="Description" name="desc">{{ isset(auth()->user()->desc) ? auth()->user()->desc : '' }}</textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <button type="submit" class="btn btn-primary update-btn">{{__('Update')}}</button>
                                                </form>
                                            </div>
                                            <div class="setting-block mb_30">
                                                <h3 class="setting-block-heading mb_30">{{__('Share Social Media')}}</h3>
                                                <form action="{{ route('update.social.media', ['id' => auth()->user()->id]) }}" method="POST">
                                                    @csrf
                                                    <div class="row">
                                                        <div class="col-lg-6">
                                                            <div class="form-group">
                                                                <label for="facebook" class="form-label">{{ __('Facebook URL') }}</label>
                                                                <input type="url" class="form-control" id="facebook" name="facebook" placeholder="Facebook URL" value="{{ $socialMedia->where('type', 'facebook')->first()->url ?? '' }}">
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <div class="form-group">
                                                                <label for="instagram" class="form-label">{{ __('Instagram URL') }}</label>
                                                                <input type="url" id="instagram" class="form-control" name="instagram" placeholder="Instagram URL" value="{{ $socialMedia->where('type', 'instagram')->first()->url ?? '' }}">
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <div class="form-group">
                                                                <label for="linkedIn" class="form-label">{{ __('LinkedIn URL') }}</label>
                                                                <input type="url" id="linkedIn" class="form-control" name="linkedIn" placeholder="LinkedIn URL" value="{{ $socialMedia->where('type', 'linkedIn')->first()->url ?? '' }}">
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <div class="form-group">
                                                                <label for="twitter" class="form-label">{{ __('Twitter URL') }}</label>
                                                                <input type="url" id="twitter" class="form-control" name="twitter" placeholder="Twitter URL" value="{{ $socialMedia->where('type', 'twitter')->first()->url ?? '' }}">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <button type="submit" class="btn btn-primary update-btn">{{ __('Update') }}</button>
                                                </form>
                                            </div>
                                            <div class="setting-block">
                                                <h3 class="setting-block-heading mb_30">{{__('Change Password')}}</h3>
                                                <form method="POST" action="{{ route('password.update',['id'=>auth()->user()->id]) }}">
                                                    @csrf
                                                    <div class="row">
                                                        <div class="col-lg-4">
                                                            <div class="form-group password-group">
                                                                <label for="old_password" class="form-label">{{ __('Old Password') }}</label>
                                                                <input id="old_password" type="password" class="form-control @error('old_password') is-invalid @enderror" name="old_password" required autocomplete="current-password" placeholder="Enter old password">
                                                                <button type="button" class="btn eye-btn"><i class="flaticon-eye-close-up"></i></button>
                                                                @error('old_password')
                                                                    <span class="invalid-feedback" role="alert">
                                                                        <strong>{{ $message }}</strong>
                                                                    </span>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-4">
                                                            <div class="form-group password-group">
                                                                <label for="new_password" class="form-label">{{ __('New Password') }}</label>
                                                                <input id="new_password" type="password" class="form-control @error('new_password') is-invalid @enderror" name="new_password" required autocomplete="new-password" placeholder="Enter new password">
                                                                <button type="button" class="btn eye-btn"><i class="flaticon-eye-close-up"></i></button>
                                                                @error('new_password')
                                                                    <span class="invalid-feedback" role="alert">
                                                                        <strong>{{ $message }}</strong>
                                                                    </span>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-4">
                                                            <div class="form-group password-group">
                                                                <label for="new_password_confirmation" class="form-label">{{ __('Confirm New Password') }}</label>
                                                                <input id="new_password_confirmation" type="password" class="form-control" name="new_password_confirmation" required autocomplete="new-password" placeholder="Enter confirm new password">
                                                                <button type="button" class="btn eye-btn"><i class="flaticon-eye-close-up"></i></button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <button type="submit" class="btn btn-primary update-btn">{{ __('Change Password') }}</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </section>
                        </div>

                        <!-- Settings-->
                        <!-- Start delete account -->
                        <div class="tab-pane fade" id="delete-account" role="tabpanel" aria-labelledby="delete-account-tab">
                            <h3 class="delete-heading mb_20">{{__('Deleteing Account')}}</h3>
                            <p class="deleteing-txt mb_30">{{__('If you want to permanently delete your account, let us know')}}.</p>
                            <div class="delete-account">
                                <h4 class="delete-account-heading mb_10">{{__('Delete Account permanently')}}</h4>
                                <p class="delete-account-txt mb_30">{{__('We are sorry to see you go. Deleting your account will permanently remove all your personal data, preferences, and saved information from our system. This action cannot be undone. Once you delete your account, all your personal information, including any content you’ve created or uploaded, such as posts, comments, and photos, will be permanently erased. Any subscriptions or memberships you have will be canceled, and you will no longer be able to access your account or any associated services. If you encounter any issues or have concerns, please contact our support team before proceeding. If your certain you want to delete your account, please click the button below.')}}</p>
                                <form method="POST" action="{{ route('user.delete') }}">
                                    @csrf
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="password">{{__('Password')}}</label>
                                                <input type="password" class="form-control" id="password" name="password" placeholder="Enter your password">
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="reason">{{__('Reason for deleting account')}}</label>
                                                <select class="form-control" id="reason" name="reason">
                                                    <option value="" disabled selected>{{ __('Select a reason') }}</option>
                                                    @foreach ($reasons as $data)
                                                        <option value="{{ $data->id }}">{{ $data->reason }}</option>
                                                    @endforeach
                                                    <option value="other">{{ __('Other') }}</option>
                                                </select>
                                            </div>
                                            <div class="form-group other-reason-block" id="other-reason-container">
                                                <label for="other-reason">{{__('Please specify your reason')}}</label>
                                                <input type="text" class="form-control" id="other-reason" name="other_reason" placeholder="{{ __('Your reason') }}">
                                            </div>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-primary">{{__('Submit')}}</button>
                                </form>
                            </div>
                        </div>
                        <!-- End delete account -->

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Profile End -->
 
@endsection
