 <!DOCTYPE html>

<html>

<head>

    <meta charset="utf-8">

    <title>{{!empty($title) ? $title:'Coffee Spot'}}</title>

    <!-- Stylesheets -->

    <link href="{{ asset('frontend_assets/css/bootstrap.css')}}" rel="stylesheet">

    <link href="{{ asset('frontend_assets/css/font-awesome.css')}}" rel="stylesheet">

    <link href="https://fonts.googleapis.com/css?family=Work+Sans:300,400,500,600,700" rel="stylesheet">

    <link href="{{ asset('frontend_assets/css/owl.carousel.min.css')}}" rel="stylesheet">

    <link href="{{ asset('frontend_assets/css/owl.theme.default.min.css')}}" rel="stylesheet">

    <link href="{{ asset('frontend_assets/css/animate.css')}}" rel="stylesheet" type="text/css" />

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.2.5/jquery.fancybox.min.css" />

    <link href="{{ asset('frontend_assets/css/style.css')}}" rel="stylesheet">

    <!-- Responsive -->

    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">

    <link href="{{ asset('frontend_assets/css/responsive.css')}}" rel="stylesheet">

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

</style>

</head>

<body>

<div class="mobile-menu">

    <div class="menu-mobile">

        <div class="mmenu">

            <ul class="main-menu-xs">

                   <li class="
                @if(count(Request::segments())<=4)
                 {{(explode("/", request()->url())[4] == "") ? "active" : ''}}
                @else
                 {{(explode("/", request()->url())[5] == "") ? "active" : ''}}
                @endif
                "><a href="{{route('home')}}">Home</a></li>

                <li class="
                @if(count(Request::segments())<=4)
                 {{(explode("/", request()->url())[4] == "cafes") ? "active" : ''}}
                @else
                 {{(explode("/", request()->url())[5] == "cafes") ? "active" : ''}}
                @endif

                "><a href="{{route('cafes')}}">Café</a></li>

                <li class="
                @if(count(Request::segments())<=4)
                 {{(explode("/", request()->url())[4] == "events&offers") ? "active" : ''}}
                @else
                 {{(explode("/", request()->url())[5] == "events&offers") ? "active" : ''}}
                @endif
                 "><a href="{{route('events')}}">Events and Offers</a></li>

                <li class="
                 @if(count(Request::segments())<=4)
                 {{(explode("/", request()->url())[4] == "about") ? "active" : ''}}
                @else
                 {{(explode("/", request()->url())[5] == "about") ? "active" : ''}}
                @endif
                 "><a href="{{route('about')}}">About us</a></li>
                <li class="
                 @if(count(Request::segments())<=4)
                 {{(explode("/", request()->url())[4] == "contact") ? "active" : ''}}
                @else
                 {{(explode("/", request()->url())[5] == "contact") ? "active" : ''}}
                @endif
                 "><a href="{{route('contact')}}">Contact Us</a></li>
                 

              <!--   <li class="{{(explode("/", request()->url())[4] == "") ? "active" : ''}} "><a href="{{route('home')}}">Home</a></li>

                <li class="{{(explode("/", request()->url())[4] == "cafes") ? "active" : ''}} "><a href="{{route('cafes')}}">Café</a></li>

                <li class="{{(explode("/", request()->url())[4] == "events&offers") ? "active" : ''}} "><a href="{{route('events')}}">Events and Offers</a></li>

                <li class="{{(explode("/", request()->url())[4] == "page") ? "active" : ''}} "><a href="{{route('page',['page_key'=>'about'])}}">About us</a></li>

                <li class="{{(explode("/", request()->url())[4] == "contact") ? "active" : ''}} "><a href="{{route('contact')}}">Contact Us</a></li> -->

            </ul>

            <ul class="lang-xs clearfix">

                <li class="active"><a href="{{url('en')}}">EN</a></li>

                <li><a href="{{url('ar')}}">AR</a></li>

            </ul>
            @if(Auth::check())
            @if(Auth::user()->user_type==2)
            <a href="{{route('add_cafe')}}" class="add--cafe-xs">Add your Café</a>
            @else
            <button type="button" class="view-btn" data-toggle="modal" data-target="#myModal">Add your Café</button>
            @endif
            @else
            <button type="button" class="view-btn" data-toggle="modal" data-target="#myModal">Add your Café</button>
            @endif
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

                <input type="text" name="q" class="form-control" placeholder="Search">

            </div>

        </form>

    </div>

</div>

<div class="main-wrapper">

    <header id="header" class="header-innerPage">

        <div class="container-fluid">

            <div class="h-top clearfix">

                <a href="{{route('home')}}" class="logo-site">

                    <img src="{{ asset('frontend_assets/images/Logo.svg')}}" alt="">

                </a>

                <div class="h-bottom">

                    <ul class="main-menu clearfix">

                <li class="
                @if(count(Request::segments())<=4)
                 {{(explode("/", request()->url())[4] == "") ? "active" : ''}}
                @else
                 {{(explode("/", request()->url())[5] == "") ? "active" : ''}}
                @endif
                "><a href="{{route('home')}}">Home</a></li>

                <li class="
                @if(count(Request::segments())<=4)
                 {{(explode("/", request()->url())[4] == "cafes") ? "active" : ''}}
                @else
                 {{(explode("/", request()->url())[5] == "cafes") ? "active" : ''}}
                @endif

                "><a href="{{route('cafes')}}">Café</a></li>

                <li class="
                @if(count(Request::segments())<=4)
                 {{(explode("/", request()->url())[4] == "events&offers") ? "active" : ''}}
                @else
                 {{(explode("/", request()->url())[5] == "events&offers") ? "active" : ''}}
                @endif
                 "><a href="{{route('events')}}">Events and Offers</a></li>

                <li class="
                 @if(count(Request::segments())<=4)
                 {{(explode("/", request()->url())[4] == "about") ? "active" : ''}}
                @else
                 {{(explode("/", request()->url())[5] == "about") ? "active" : ''}}
                @endif
                 "><a href="{{route('about')}}">About us</a></li>
                <li class="
                 @if(count(Request::segments())<=4)
                 {{(explode("/", request()->url())[4] == "contact") ? "active" : ''}}
                @else
                 {{(explode("/", request()->url())[5] == "contact") ? "active" : ''}}
                @endif
                 "><a href="{{route('contact')}}">Contact Us</a></li>

                    </ul>

                </div>

                <div class="h-right-group">

                    <ul class="action-right clearfix">

                        <li>

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
                               <!--  @if(app()->getLocale()=='ar')
                                AR
                                @else
                                EN
                                @endif -->
                                <span class="caret-ar"><!-- <i class="fa fa-angle-down" aria-hidden="true"></i> --></span></a>

                            <ul class="dropdown-menu ul-drop-lang">
                               <?php $prv_url = explode("/", request()->url());?>
                                <li><a href="
                                  <?php 
                              if ($prv_url[3] == 'ar') {
                                $prv_url[3] = 'en';
                                $url = implode('/', $prv_url);
                                echo $url;
                                      }
                                  ?>

                                  ">English</a></li>

                                <li><a href="
                                 <?php 
                                 if ($prv_url[3] == 'en') {
                                 $prv_url[3] = 'ar';
                                 $url = implode('/', $prv_url);
                                 echo $url;
                                      }
                                  ?>">Arabic</a></li>

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
                            <a href="{{route('add_cafe')}}" class="view-btn">Add your Café</a>
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

        </div>

    </header><!--header--> 

    <!-- Modal -->
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Information</h4>
        </div>
        <div class="modal-body">
          <p>You should login with a cafe account to add cafe</p>
        </div>
      </div>
      
    </div>
  </div>
  