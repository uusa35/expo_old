<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>{{!empty($title) ? $title:'Coffee Spot'}}</title>
	<!-- Stylesheets -->
	<link href="{{ asset('frontend_assets/css/bootstrap.css')}}" rel="stylesheet">
	<link href="{{ asset('frontend_assets/css/font-awesome.css')}}" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Work+Sans:300,400,700" rel="stylesheet">
	<link href="{{ asset('frontend_assets/css/owl.carousel.min.css')}}" rel="stylesheet">
	<link href="{{ asset('frontend_assets/css/owl.theme.default.min.css')}}" rel="stylesheet">
	<link href="{{ asset('frontend_assets/css/animate.css')}}" rel="stylesheet" type="text/css" />
	<link href="{{ asset('frontend_assets/css/style.css')}}" rel="stylesheet">
	<!-- Responsive -->
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
	<link href="{{ asset('frontend_assets/css/responsive.css')}}" rel="stylesheet">
	<!--[if lt IE 9]><script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
	<!--[if lt IE 9]><script src="js/respond.js"></script><![endif]-->
	<script src="{{ asset('frontend_assets/js/jquery-1.12.2.min.js')}}"></script>
<style>
.logout-btn{
  border-radius: 30px;
  height: 40px;
  line-height: 36px;
  border:2px solid #FAC05A;
  text-align: center;
  color: #FAC05A;
  padding: 0;
  display: block;
  padding: 0 25px;
  width: 140px;
}
.rating-item img {
	max-height: 255px;
	min-height: 255px;
}
</style>
</head>
<body>
	 <!-- Modal -->
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">{{__('home.note')}}</h4>
        </div>
        <div class="modal-body">
          <p>{{__('home.note_body')}}</p>
        </div>
      </div>
      
    </div>
  </div>

	<div class="mobile-menu">
	    <div class="menu-mobile">
	        <div class="mmenu">
		        <ul class="main-menu-xs">
			    <li class="active"><a href="{{route('home')}}">{{__('home.home')}}</a></li>
                <li><a href="{{route('cafes')}}">{{__('home.cafe')}}</a></li>
                <li><a href="{{route('events')}}">{{__('home.events_offers')}}</a></li>
                <li><a href="{{route('about')}}">{{__('home.about_us')}}</a></li>
                <li><a href="{{route('contact')}}">{{__('home.contact_us')}}</a></li>
				</ul>
				<ul class="lang-xs clearfix">
					<li class="active"><a href="{{url('en')}}">EN</a></li>
					<li><a href="{{url('ar')}}">AR</a></li>
				</ul>
				<div>
					<a href="{{route('add_cafe')}}" class="add--cafe-xs">{{__('home.add_your_cafe')}}</a>
				</div>
			</div>
		</div>
		<div class="m-overlay"></div>
	</div><!--mobile-menu-->
	<div id="search">
        <button type="button" class="close">×</button>
        <div class="center-screen">
	        <form action="{{route('search')}}" class="form_search" method="get">
				<div class="form-group">
					<button type="submit" class="search_submit"><img src="{{ asset('frontend_assets/images/icon-s.svg')}}" alt=""></button>
					<input type="text" name="s" class="form-control" placeholder="Search">
				</div>
			</form>
		</div>
    </div>
	<div class="main-wrapper">
		<header id="header">
			<div class="container-fluid">
				<div class="h-top clearfix">
					<a href="{{route('home')}}" class="logo-site">
						<img src="{{ asset('frontend_assets/images/Logo.svg')}}" alt="">
					</a>
					<div class="h-right-group">
						<ul class="action-right clearfix">
							<li>
								<form class="form-search" action="{{route('search')}}">
									<input type="text" name="q" class="form-control" placeholder="Search">
									<button type="submit" class="btn btn-search-submit">
										<img src="{{ asset('frontend_assets/images/icon-s.svg')}}" alt="">
									</button>
								</form>
								<a href="#search" class="search-icon-xs"><img src="{{ asset('frontend_assets/images/Search-Icon-xs.svg')}}" alt=""></a>
							</li>
							<li class="user-profile dropdown">
								<a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="true"><img src="{{ asset('frontend_assets/images/User-Icon.svg')}}" alt=""></a>
								<ul class="dropdown-menu">
									    @if(Auth::check())
                                <li class="logout-btn">
                                <a href="{{ route('logout') }}"
                                   onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                    {{__('common.logout')}}
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                      style="display: none;">
                                    {{ csrf_field() }}
                                </form>
                                </li>
                                 @if(Auth::user()->user_type!=1)
                                 <li><a href="{{route('profile')}}" class="Sign-btn bg-color">Profile</a></li>
                                @else
                                 <li><a href="{{route('user_profile')}}" class="Sign-btn bg-color">Profile</a></li>
                                @endif

                                @else
                                 <li><a href="{{route('customer_login')}}" class="Sign-btn bg-color">Sign in</a></li>
                                 <li><a href="{{route('customer_register')}}" class="Sign-btn">Sign up</a></li>
                                @endif
								</ul>
							</li>
							<li class="lang-site dropdown">
								<a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="true"><img src="{{ asset('frontend_assets/images/Icon-global.svg')}}" alt="">
								<!-- @if(app()->getLocale()=='ar')
                                AR
                                @else
                                EN
                                @endif -->
								<span class="caret-ar"><!-- <i class="fa fa-angle-down" aria-hidden="true"></i> --></span></a>
								<ul class="dropdown-menu ul-drop-lang">
									<li><a href="{{url('en')}}">English</a></li>
									<li><a href="{{url('ar')}}">Arabic</a></li>
								</ul>
							</li>
							<li class="hamburger-li">
								<button type="button" class="hamburger is-closed">
							        <span class="hamb-top"></span>
							        <span class="hamb-middle"></span>
							        <span class="hamb-bottom"></span>
							    </button>
							</li>
							<li class="add-hcafe">
								 @if(Auth::check())
								 @if(Auth::user()->user_type==2)
								<a href="{{route('add_cafe')}}" class="view-btn">{{__('home.add_your_cafe')}}</a>
							      @else
                                  <button type="button" class="view-btn" data-toggle="modal" data-target="#myModal">Add your Café</button>
							     @endif
							     @else
                           		  <button type="button" class="view-btn" data-toggle="modal" data-target="#myModal">Add your Café</button>
							     @endif
							</li>
						</ul>
					</div>
				</div>
				<div class="h-bottom">
					<ul class="main-menu clearfix">
						<li class="active"><a href="{{route('home')}}">{{__('home.home')}}</a></li>
		                <li><a href="{{route('cafes')}}">{{__('home.cafe')}}</a></li>
		                <li><a href="{{route('events')}}">{{__('home.events_offers')}}</a></li>
		                <li><a href="{{route('about')}}">{{__('home.about_us')}}</a></li>
		                <li><a href="{{route('contact')}}">{{__('home.contact_us')}}</a></li>
					</ul>
				</div>
			</div>
		</header><!--header-->
		<section class="section-home-slide" style="background-image: url({{ asset('frontend_assets/images/slide-bg.jpg);')}}">
			<div class="owl-carousel" id="homeSlider">
				@if(!empty($ads))
				@foreach($ads as $item)
				<div class="item">
					<div class="container">
						<div class="row">
							<div class="col-xs-6">
								<div class="h-s-thumb">
									<img src="{{$item->image}}" alt="" class="img-responsive">
								</div>
							</div>
							<div class="col-xs-6">
							<div class="h-s-txt">
							<h2>
							{{$item->title}}</option>
							</h2>
							<p>{!!$item->details!!}</option></p>
							 @if(!empty($item->link))
							 <a href="{{$item->link}}" class="view-btn">{{__('home.view')}}</a>
							 @else
							 @endif
							</div>
							</div>
						</div>
					</div>
				</div>
				@endforeach
				@else
				@endif
			</div>
		</section><!--section-home-slide-->
		<section class="section-content-home">
			<div class="container">
				<div class="rating-box">
					<h2 class="sec-title">{{__('home.most_rating')}}</h2>
					<div class="owl-carousel" id="rating-slide">
						@if(!empty($most_cafe))
						@foreach($most_cafe as $item)
						<div class="item">
							<div class="rating-item">
								<a href="{{route('cafe',['cafe'=>$item->id])}}" class="img-hover">
									<img src="{{$item->logo}}" alt="" class="img-responsive">
								</a>
							</div>
							@for ($i = 0; $i < $item->rating_avg; $i++)
  							 <i style="color: #FFC107;" class="fa fa-star"></i>
							@endfor
						</div>
						@endforeach
						@else
						@endif
					</div>
				</div>
				<div class="offer-box">
					<h2 class="sec-title">{{__('home.events_offers')}}</h2>
					<div class="offers-list">
						<div class="row">
							@if(!empty($offers))
							<div class="col-sm-6">
								<div class="offer-item">
									<div class="offer-thumb">
										<a href="{{route('event_details',['type_id'=>$offers->id])}}" class="img-hover">
											<img src="{{$offers->image}}" alt="" class="img-responsive">
										</a>
										<!-- <span class="off-salary">$14.99</span> -->
									</div>
									<div class="offer-txt">
										<p>{!!$offers->details!!}</p>
									</div>
								</div>
							</div>
							@endif
							@if(!empty($events))
							<div class="col-sm-6">
								<div class="offer-item">
									<div class="offer-thumb">
										<a href="{{route('event_details',['type_id'=>$events->id])}}" class="img-hover">
											<img src="{{$events->image}}" alt="" class="img-responsive">
										</a>
										<!-- <span class="off-salary">$14.99</span> -->
									</div>
									<div class="offer-txt"><!-- {{$events->details}}-->
										<p>{!!$events->details!!}</p>
									</div>
								</div>
							</div>
							@endif
						</div>
						<a href="{{route('events')}}" class="view-btn">{{__('home.view_more')}}</a>
					</div>
				</div>
			</div>	
		</section><!--section-content-home-->
		</div><!--main-wrapper--> 
		<footer id="footer">
			<div class="container">
				<div class="f-right">
					<ul class="f-social clearfix">
						<li>
							<a href="
							@if (strpos($facebook->value, 'http') !== false)
							{{$facebook->value}}
							@else
							http://{{$facebook->value}}
							@endif
							" target="_blank"><i class="fa fa-facebook" aria-hidden="true"></i></a>
						</li>
						<li>
							<a href="
							@if (strpos($twitter->value, 'http') !== false)
							{{$twitter->value}}
							@else
							http://{{$twitter->value}}
							@endif
							" target="_blank"><i class="fa fa-twitter" aria-hidden="true"></i></a>
						</li>
						<li>
							<a href="
							@if (strpos($instagram->value, 'http') !== false)
							{{$instagram->value}}
							@else
							http://{{$instagram->value}}
							@endif" target="_blank"><i class="fa fa-instagram" aria-hidden="true"></i></a>
						</li>
					</ul>
					<ul class="paylist clearfix">
						<li>
							<a href="#"><img src="{{ asset('frontend_assets/images/Visa-Icon.svg')}}" alt=""></a>
						</li>
						<li>
							<a href="#"><img src="{{ asset('frontend_assets/images/Knet-Icon.svg')}}" alt=""></a>
						</li>
					</ul>
				</div>
				<div class="f-left">
					<ul class="f-menu clearfix">
						<li><a href="{{route('terms')}}">{{__('home.terms_and_condition')}}</a></li>
						<li><a href="{{route('contact')}}">{{__('home.contact_details')}}</a></li>
						<li><a href="{{route('privacy')}}">{{__('home.privacy_policy')}}</a></li>
					</ul>
					<p class="copy-right">
						© 2017 Coffe Spott. All rights reserved.
					</p>
				</div>
			</div>
		</footer><!--footer-->
	
	<script src="{{ asset('frontend_assets/js/bootstrap.min.js')}}"></script>
	<script src="{{ asset('frontend_assets/js/owl.carousel.min.js')}}" type="text/javascript"></script>
	<script src="{{ asset('frontend_assets/js/script.js')}}"></script>
</body>
</html>	