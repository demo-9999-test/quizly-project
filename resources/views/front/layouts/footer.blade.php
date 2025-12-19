<!-- Footer Start-->
<footer id="footer" class="footer-main-block">
    <div class="container">
      <div class="row">
        <div class="col-lg-4 col-12">
          <div class="footer-logo mb_30">
            <a href="{{route('home.page')}}" title="{{$footer->title}}"><img src="{{asset('images/footer_logo/'.$footer->footer_logo)}}" class="img-fluid footer-image mb_20" alt=""></a>
            <p class="mb_30">{{strip_tags($footer->desc)}}</p>
            <h5 class="contact-sub-heading mb_10">{{__('Follow Us')}}</h5>
            <div class="footer-icons mb_30">
                <ul class="social-footer-lst">
                    @if($footer->fb_url)
                    <li><a href="{{$footer->fb_url}}" title="{{__('Facebook')}}"><i class="flaticon-facebook"></i></a></li>
                    @endif
                    @if($footer->twitter_url)
                    <li><a href="{{$footer->twitter_url}}" title="{{__('Twitter')}}"><i class="flaticon-twitter"></i></a></li>
                    @endif
                    @if($footer->insta_url)
                    <li><a href="{{$footer->insta_url}}" title="{{__('Instagram')}}"><i class="flaticon-instagram"></i></a></li>
                    @endif
                    @if($footer->linkedin_url)
                    <li><a href="{{$footer->linkedin_url}}" title="{{__('Linkedin')}}"><i class="flaticon-linkedin"></i></a></li>
                    @endif
                </ul>
            </div>
          </div>
        </div>
        <div class="col-lg-8 col-12">
          <div class="row">
            <div class="col-lg-3 col-md-3 col-6">
              <div class="footer-widget mb_30">
                <h4 class="footer-widget-title mb_30">{{__('Company')}}</h4>
                <ul>
                  <li><a href="{{route('discover.page')}}" title="{{__('Discover Quiz')}}">{{__('Discover Quiz')}}</a></li>
                  <li><a href="{{route('blog.page')}}" title="{{__('Blogs')}}">{{__('Blogs')}}</a></li>
                  <li><a href="{{route('leaderboard.page')}}" title="{{__('LeaderBoard')}}">{{__('LeaderBoard')}}</a></li>
                  <li><a href="{{route('contact.us')}}" title="{{__('Contact Us')}}">{{__('Contact Us')}}</a></li>
                  @if(auth()->check())
                  <li><a href="{{route('support.form')}}" title="{{__('Help and Support')}}">{{__('Help and Support')}}</a></li>
                  @endif
                </ul>
              </div>
            </div>
            <div class="col-lg-3 col-md-3 col-6">
              <div class="footer-widget">
                <h4 class="footer-widget-title mb_30">{{__('Policy')}}</h4>
                <ul>
                    @foreach ($pages as $data)
                        <li><a href="{{ route('pagesdetails', ['slug' => $data->slug]) }}" title="{{ $data->title }}">{{ $data->title }}</a></li>
                    @endforeach
                </ul>
              </div>
            </div>
            <div class="col-lg-6 col-md-6 col-12">
                <div class="footer-widget">
                    <h4 class="footer-widget-title mb_30">{{__('Contact Us')}}</h4>
                    <div class="contact-information-block">
                        <ul class="footer-lst">
                            <li>
                                <h5 class="contact-sub-heading mb_10">{{__('Address:')}}</h5>
                                <p class="contact-information-txt">{{strip_tags($about->address)}}</p>
                            </li>
                            <li>
                                <h5 class="contact-sub-heading mb_10">{{__('Phone:')}}</h5>
                                <a href="tel:{{($about->contact)}}" class="contact-information-txt" title="{{($about->contact)}}">{{($about->contact)}}</a>
                            </li>
                            <li>
                                <h5 class="contact-sub-heading mb_10">{{__('Email:')}}</h5>
                                <a href="mailto:{{$about->email}}" class="contact-information-txt" title="{{($about->email)}}">{{($about->email)}}</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    </footer>
    <div class="tiny-footer">
        <div class="container">
            <div class="row">
                <div class="col-md-12 text-center text-sm-center">
                    <p>{{$footer->copyright_text}}</p>
                </div>
            </div>
        </div>
    </div>
<!-- Footer End-->
