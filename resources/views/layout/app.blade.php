<!DOCTYPE html>

<html lang="en">

<head>

    <meta charset="utf-8"/>

    <title>

        @yield('title')

    </title>

    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <meta content="width=device-width, initial-scale=1" name="viewport"/>

    <meta content="Preview page of Metronic Admin Theme #4 for statistics, charts, recent events and reports"

          name="description"/>

    <meta content="" name="author"/>

    <!-- BEGIN GLOBAL MANDATORY STYLES -->


    <link href="{{admin_assets('/global/plugins/font-awesome/css/font-awesome.min.css')}}" rel="stylesheet"
          type="text/css"/>

    <link href="{{admin_assets('/global/plugins/simple-line-icons/simple-line-icons.min.css')}}" rel="stylesheet"
          type="text/css"/>


    @if(app()->getLocale() == "en")

        <link href="{{admin_assets('/global/plugins/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet"
              type="text/css"/>

        <link href="{{admin_assets('/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css')}}" rel="stylesheet"
              type="text/css"/>

        <link href="{{admin_assets('/layouts/layout4/css/layout.min.css')}}" rel="stylesheet" type="text/css"/>

        <link href="{{admin_assets('/layouts/layout4/css/themes/default.min.css')}}" rel="stylesheet" type="text/css"/>

        <link href="{{admin_assets('/layouts/layout4/css/custom.min.css')}}" rel="stylesheet" type="text/css"/>

        <link href="{{admin_assets('/global/css/components.min.css')}}" rel="stylesheet" type="text/css"/>

        <link href="{{admin_assets('/global/css/plugins.min.css')}}" rel="stylesheet" type="text/css"/>


    @else

        <link href="{{admin_assets('/global/plugins/bootstrap/css/bootstrap-rtl.min.css')}}" rel="stylesheet"
              type="text/css"/>
        <link href="{{admin_assets('/global/plugins/bootstrap-switch/css/bootstrap-switch-rtl.min.css')}}"
              rel="stylesheet" type="text/css"/>
        <link href="{{admin_assets('global/plugins/bootstrap-editable/bootstrap-editable/css/bootstrap-editable-rtl.css')}}"
              rel="stylesheet" type="text/css"/>
        <link href="{{admin_assets('/global/css/components-rtl.min.css')}}" rel="stylesheet" type="text/css"/>
        <link href="{{admin_assets('/global/css/plugins-rtl.min.css')}}" rel="stylesheet" type="text/css"/>
        <link href="{{admin_assets('/layouts/layout4/css/layout-rtl.min.css')}}" rel="stylesheet" type="text/css"/>
        <link href="{{admin_assets('/layouts/layout4/css/themes/default-rtl.min.css')}}" rel="stylesheet"
              type="text/css"/>
        <link href="{{admin_assets('/layouts/layout4/css/custom-rtl.min.css')}}" rel="stylesheet" type="text/css"/>


        <style type="text/css">
            .page-breadcrumb {
                direction: rtl;
            }

            .widget-row {
                margin-top: 45px;
            }

            .btn-group {
                float: right;
            }

            body {
                direction: rtl;
            }

        </style>


    @endif


    <link href="{{admin_assets('/global/plugins/bootstrap-daterangepicker/daterangepicker.min.css')}}" rel="stylesheet"
          type="text/css"/>

    <link href="{{admin_assets('global/plugins/select2/css/select2.min.css')}}" rel="stylesheet" type="text/css"/>

    <link href="{{admin_assets('global/plugins/select2/css/select2-bootstrap.min.css')}}" rel="stylesheet"
          type="text/css"/>

    <link href="{{admin_assets('global/plugins/bootstrap-sweetalert/sweetalert.css')}}" rel="stylesheet"
          type="text/css"/>

    <link href="{{admin_assets('layouts/layout4/css/customize-style.css')}}" rel="stylesheet" type="text/css"/>

    <link href="{{admin_assets('global/plugins/datatables/datatables.min.css')}}" rel="stylesheet" type="text/css"/>


    @yield('css')

    <link rel="shortcut icon" href="{{admin_assets('favicon.png')}}"/>


    <link href="https://fonts.googleapis.com/css?family=Cairo:300,400,600,700" rel="stylesheet">
</head>

<!-- END HEAD -->


<body class="page-container-bg-solid page-header-fixed page-sidebar-closed-hide-logo">

<!-- BEGIN HEADER -->

<div class="page-header navbar navbar-fixed-top">

    <!-- BEGIN HEADER INNER -->

    <div class="page-header-inner ">

        <!-- BEGIN LOGO -->

        <div class="page-logo">

            <a href="{{url('/admin/home')}}">

                <img width="60" height="60" src="{{url('admin_assets/Logo.png')}}"
                     style="margin: 7px 10px 0 !important;" alt="logo" class="logo-default"/>
                {{--
                                <img style="width: 65px;position: absolute;" src="{{url('admin_assets/Logo.png')}}"

                                     style="margin: 12px 10px 0 !important;" alt="logo" class="logo-default"/>
                --}}

            </a>

            <div class="menu-toggler sidebar-toggler">

                <!-- DOC: Remove the above "hide" to enable the sidebar toggler button on header -->

            </div>

        </div>

        <!-- END LOGO -->

        <!-- BEGIN RESPONSIVE MENU TOGGLER -->

        <a href="javascript:;" class="menu-toggler responsive-toggler" data-toggle="collapse"

           data-target=".navbar-collapse"> </a>

        <!-- END RESPONSIVE MENU TOGGLER -->

        <!-- BEGIN PAGE TOP -->

        <div class="page-top">

            <div class="top-menu">

                <ul class="nav navbar-nav pull-right">

                    <li class="separator hide"></li>

                    <li class="dropdown dropdown-user dropdown-dark">

                        <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown"

                           data-close-others="true">

                            <span class="username username-hide-on-mobile"> {{auth()->user()->name}} </span>

                            <!-- DOC: Do not remove below empty space(&nbsp;) as its purposely used -->

                            <img alt="" class="img-circle" src="{{admin_assets('/layouts/layout4/img/avatar1.jpg')}}"/>

                        </a>

                        <ul class="dropdown-menu dropdown-menu-default">

                            {{--<li>--}}

                            {{--<a href="#">--}}

                            {{--<i class="icon-user"></i> My Profile </a>--}}

                            {{--</li>--}}

                            {{--<li>--}}

                            {{--<a href="{{url('/admin/home')}}">--}}

                            {{--<i class="icon-home"></i> My Dashboard</a>--}}

                            {{--</li>--}}

                            {{--<li class="divider"></li>--}}

                            <li>


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

                        </ul>

                    </li>


                    <li class="dropdown dropdown-user dropdown-dark">
                        @foreach($locales as $locale)
                            @if($locale->lang == app()->getLocale())
                                <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown"
                                   data-hover="dropdown"
                                   data-close-others="true">
                            <span class="username username-hide-on-mobile">
                                {{$locale->name}} </span>
                                    <img alt="" class="img-circle" src="{{url($locale->flag)}}"/>
                                </a>
                            @endif
                        @endforeach
                        <ul class="dropdown-menu dropdown-menu-default">
                            @foreach($locales as $locale)
                                <li @if($locale->lang == app()->getLocale()) style="background-color: white !important;" @endif>
                                    <a href="{{ LaravelLocalization::getLocalizedURL($locale->lang, null, [], true) }}"> <span
                                                class="username username-hide-on-mobile">
                                {{$locale->name}} </span><i class="zmdi zmdi-globe-alt"></i></a></li>

                            @endforeach

                        </ul>
                    </li>

                </ul>

            </div>

            <!-- END TOP NAVIGATION MENU -->

        </div>

        <!-- END PAGE TOP -->

    </div>

    <!-- END HEADER INNER -->

</div>

<!-- END HEADER -->

<!-- BEGIN HEADER & CONTENT DIVIDER -->

<div class="clearfix"></div>

<!-- END HEADER & CONTENT DIVIDER -->

<!-- BEGIN CONTAINER -->

<div class="page-container">

    <!-- BEGIN SIDEBAR -->

    <div class="page-sidebar-wrapper">

        <div class="page-sidebar navbar-collapse collapse">

            <ul class="page-sidebar-menu   " data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200">

            <!--  <li class="nav-item active start">

                    <a href="{{url('/admin/home')}}" class="nav-link">

                        <i class="icon-home"></i>

                        <span class="title">Dashboard</span>

                    </a>

                </li> -->

                @if(Auth::user()->user_type==2)

                    <li class="nav-item  {{(explode("/", request()->url())[5] == "myProduct") ? "active open" : ''}}">

                        <a href="{{url(getLocal().'/admin/myProduct')}}" class="nav-link nav-toggle">

                            <i class="fa fa-th-large"></i>

                            <span class="title">{{__('layout.product')}}</span>


                        </a>

                    </li>

                    <li class="nav-item ">

                        <a href="{{url(getLocal().'/admin/myProfile')}}" class="nav-link ">

                            <i class="fa fa-server"></i>

                            <span class="title">{{__('layout.my_profile')}}</span>

                        </a>

                    </li>


                    <li class="nav-item ">

                        <a href="{{url(getLocal().'/admin/myExpo')}}" class="nav-link ">

                            <i class="fa fa-server"></i>

                            <span class="title">{{__('layout.my_expo')}}</span>

                        </a>

                    </li>

                    <li class="nav-item ">

                        <a href="{{url(getLocal().'/admin/myOrders')}}" class="nav-link ">

                            <i class="fa fa-server"></i>

                            <span class="title">{{__('layout.my_orders')}}</span>
                            
                            @php( $expoitem = \App\Models\Expo::query()->where('user_id', auth()->id())->first())
                            
                            @php($count2 = \App\Models\UserOrder::whereHas('orders', function ($q) use ($expoitem) {
                                    $q->where('expo_id', $expoitem->id);
                                })->where('status', 'new')->count())
        
                            @if($count2 > 0) 
                            <span class="badge badge-danger">{{$count2}}</span> @endif
                        </a>

                    </li>

                    <li class="nav-item  {{(explode("/", request()->url())[5] == "deliveryPrices") ? "active open" : ''}}">

                        <a href="{{url(getLocal().'/admin/deliveryPrices')}}" class="nav-link nav-toggle">

                            <i class="fa fa-th-large"></i>

                            <span class="title">{{__('layout.delivery_prices')}}</span>
                        </a>


                    </li>

                    <li class="nav-item  {{(explode("/", request()->url())[5] == "messages") ? "active open" : ''}}">


                        <a href="{{url(getLocal().'/admin/messages')}}" class="nav-link ">

                            <i class="fa fa-plus-square-o"></i>
                            <span class="title">{{__('layout.messages')}}</span>

                            @php($count = \App\Models\MessageContact::query()->where('receiver_id', auth()->id())->where('type', 1)->where('status', 0)->count()) 
                           
                           @if($count > 0) 
                            <span class="badge badge-danger">{{$count}}</span>
                            
                            @endif
                        </a>

                    </li>


                    <li class="nav-item ">

                        <a href="{{url(getLocal().'/admin/password/change')}}" class="nav-link ">

                            <i class="fa fa-server"></i>

                            <span class="title">{{__('layout.change_password')}}</span>

                        </a>

                    </li>



                @endif

                @if(Auth::user()->user_type==3)



                    @if(can('admins'))
                        <li class="nav-item  {{(explode("/", request()->url())[5] == "admins") ? "active open" : ''}}">

                            <a href="{{url(getLocal().'/admin/admins')}}" class="nav-link nav-toggle">

                                <i class="fa fa-th-large"></i>

                                <span class="title">{{__('common.title_admin')}}</span>

                            </a>

                        </li>
                    @endif




                    @if(can('role'))
                        <li class="nav-item {{(explode("/", request()->url())[5] == "role") ? "active open" : ''}}">

                            <a href="{{url(getLocal().'/admin/role')}}" class="nav-link ">

                                <i class="fa fa-server"></i>

                                <span class="title">{{__('layout.role')}}</span>

                            </a>

                        </li>
                    @endif


                    @if(can('expo'))
                        <li class="nav-item  {{(explode("/", request()->url())[5] == "expo") ? "active open" : ''}}">

                            <a href="{{url(getLocal().'/admin/expo')}}" class="nav-link nav-toggle">

                                <i class="fa fa-th-large"></i>

                                <span class="title">{{__('layout.expo')}}</span>

                            </a>

                        </li>
                    @endif


                    @if(can('clothing'))
                        <li class="nav-item  {{(explode("/", request()->url())[5] == "clothing_types") ? "active open" : ''}}">

                            <a href="{{url(getLocal().'/admin/clothing_types')}}" class="nav-link nav-toggle">

                                <i class="fa fa-th-large"></i>

                                <span class="title">{{__('layout.clothing_types')}}</span>

                            </a>

                        </li>
                    @endif


                    @if(can('occasion'))
                        <li class="nav-item  {{(explode("/", request()->url())[5] == "occasion") ? "active open" : ''}}">

                            <a href="{{url(getLocal().'/admin/occasion')}}" class="nav-link nav-toggle">

                                <i class="fa fa-th-large"></i>

                                <span class="title">{{__('layout.occasion')}}</span>


                            </a>

                        </li>
                    @endif

                    @if(can('material'))
                        <li class="nav-item  {{(explode("/", request()->url())[5] == "material") ? "active open" : ''}}">

                            <a href="{{url(getLocal().'/admin/material')}}" class="nav-link nav-toggle">

                                <i class="fa fa-th-large"></i>

                                <span class="title">{{__('layout.material')}}</span>

                            </a>

                        </li>
                    @endif


                    @if(can('colors'))
                        <li class="nav-item  {{(explode("/", request()->url())[5] == "color") ? "active open" : ''}}">

                            <a href="{{url(getLocal().'/admin/colors')}}" class="nav-link nav-toggle">

                                <i class="fa fa-th-large"></i>

                                <span class="title">{{__('layout.color')}}</span>

                            </a>

                        </li>
                    @endif


                    @if(can('size'))
                        <li class="nav-item  {{(explode("/", request()->url())[5] == "size") ? "active open" : ''}}">

                            <a href="{{url(getLocal().'/admin/size')}}" class="nav-link nav-toggle">

                                <i class="fa fa-th-large"></i>

                                <span class="title">{{__('layout.size')}}</span>

                            </a>

                        </li>
                    @endif


                    @if(can('currency'))
                        <li class="nav-item  {{(explode("/", request()->url())[5] == "currency") ? "active open" : ''}}">

                            <a href="{{url(getLocal().'/admin/currency')}}" class="nav-link nav-toggle">

                                <i class="fa fa-th-large"></i>

                                <span class="title">{{__('layout.currency')}}</span>

                            </a>

                        </li>
                    @endif



                    @if(can('calendar'))
                        <li class="nav-item  {{(explode("/", request()->url())[5] == "calendar_event") ? "active open" : ''}}">

                            <a href="{{url(getLocal().'/admin/calendar_event')}}" class="nav-link nav-toggle">

                                <i class="fa fa-th-large"></i>

                                <span class="title">{{__('layout.calendar_event')}}</span>

                            </a>
                        </li>
                    @endif



                    @if(can('products'))
                        <li class="nav-item  {{(explode("/", request()->url())[5] == "product") ? "active open" : ''}}">

                            <a href="{{url(getLocal().'/admin/product')}}" class="nav-link nav-toggle">

                                <i class="fa fa-th-large"></i>

                                <span class="title">{{__('layout.product')}}</span>

                            </a>
                        </li>
                    @endif

                    @if(can('country'))
                        <li class="nav-item  {{(explode("/", request()->url())[5] == "country") ? "active open" : ''}}">

                            <a href="{{url(getLocal().'/admin/country')}}" class="nav-link nav-toggle">

                                <i class="fa fa-th-large"></i>

                                <span class="title">{{__('layout.country')}}</span>

                                </a>

                        </li>
                    @endif


                    @if(can('city'))
                        <li class="nav-item  {{(explode("/", request()->url())[5] == "city") ? "active open" : ''}}">

                            <a href="{{url(getLocal().'/admin/city')}}" class="nav-link nav-toggle">

                                <i class="fa fa-th-large"></i>

                                <span class="title">{{__('layout.city')}}</span>

                            </a>

                        </li>
                    @endif


                    @if(can('sliders'))

                        <li class="nav-item {{(explode("/", request()->url())[5] == "slider") ? "active open" : ''}} ">

                            <a href="{{url(getLocal().'/admin/slider')}}" class="nav-link nav-toggle">

                                <i class="fa fa-picture-o"></i>

                                <span class="title">{{__('layout.slider')}}</span>

                            </a>
                        </li>

                    @endif


                    @if(can('settings'))
                        <li class="nav-item {{(explode("/", request()->url())[5] == "setting") ? "active open" : ''}} ">

                            <a href="{{url(getLocal().'/admin/setting')}}" class="nav-link nav-toggle">

                                <i class="fa fa-cogs"></i>

                                <span class="title">{{__('layout.setting')}}</span>

                            </a>

                        </li>

                    @endif
                    @if(can('contacts'))
                        <li class="nav-item {{(explode("/", request()->url())[5] == "contact") ? "active open" : ''}}">

                            <a href="{{url(getLocal().'/admin/contact')}}" class="nav-link nav-toggle">

                                <i class="fa fa-users"></i>

                                <span class="title">{{__('layout.contact')}}</span>

                            </a>

                        </li>
                    @endif


                    @if(can('users'))
                        <li class="nav-item {{(explode("/", request()->url())[5] == "users") ? "active open" : ''}}">

                            <a href="{{url(getLocal().'/admin/users')}}" class="nav-link nav-toggle">

                                <i class="fa fa-users"></i>

                                <span class="title">{{__('layout.users')}}</span>

                            </a>

                        </li>
                    @endif



                    @if(can('subscriptions'))
                        <li class="nav-item {{(explode("/", request()->url())[5] == "subscription") ? "active open" : ''}}">

                            <a href="{{url(getLocal().'/admin/subscription')}}" class="nav-link nav-toggle">

                                <i class="fa fa-users"></i>

                                <span class="title">{{__('layout.subscription')}}</span>

                            </a>

                        </li>
                    @endif

                    @if(can('categories'))

                        <li class="nav-item  {{(explode("/", request()->url())[5] == "category") ? "active open" : ''}}">

                            <a href="{{url(getLocal().'/admin/category')}}" class="nav-link nav-toggle">

                                <i class="fa fa-th-large"></i>

                                <span class="title">{{__('layout.category')}}</span>

                            </a>

                        </li>
                    @endif


                    @if(can('packages'))
                        <li class="nav-item {{(explode("/", request()->url())[5] == "package") ? "active open" : ''}} ">

                            <a href="{{url(getLocal().'/admin/package')}}" class="nav-link nav-toggle">

                                <i class="fa fa-cc-paypal"></i>

                                <span class="title">{{__('layout.package')}}</span>

                            </a>
                        </li>
                    @endif
                    
                    @if(can('orders'))
                    
                        <li class="nav-item">

                            <a href="{{url(getLocal().'/admin/orders')}}" class="nav-link ">

                                <i class="fa fa-server"></i>

                                <span class="title">{{__('layout.orders')}}</span> @if($orders_count > 0) 
                                <span class="badge badge-danger">{{$orders_count}}</span>
                                @endif

                            </a>

                        </li>

                    @endif





                    @if(can('advertisements'))
                        <li class="nav-item ">

                            <a href="{{url(getLocal().'/admin/ads')}}" class="nav-link ">

                                <i class="fa fa-server"></i>

                                <span class="title">{{__('layout.advertisement')}}</span>

                            </a>

                        </li>
                    @endif

                   
                 @if(can('push-notification'))
                        <li class="nav-item  {{(explode("/", request()->url())[5] == "notifications") ? "active open" : ''}}">

                            <a href="{{url(getLocal().'/admin/notifications')}}" class="nav-link nav-toggle">

                                <i class="fa fa-th-large"></i>

                                <span class="title">{{__('common.manage_notifications')}}</span>
                            </a>
                        </li>
                    @endif
                    
                    
                    
                @endif

            </ul>

        </div>

    </div>

    {{--Begin Content--}}

    <div class="page-content-wrapper">

        <div class="page-content">

            <div class="page-head">

                <div class="page-title">

                    <h1>@yield('title')

                    </h1>

                </div>

                <div class="page-toolbar">

                    <div class="btn-group btn-theme-panel">

                        <!--  <a href="javascript:;" class="btn dropdown-toggle" data-toggle="dropdown">

                             <i class="icon-settings"></i>

                         </a>
  -->
                        <div class="dropdown-menu theme-panel pull-right dropdown-custom hold-on-click">

                            <div class="row">

                                <div class="col-md-4 col-sm-4 col-xs-12">

                                    <h3>HEADER</h3>

                                    <ul class="theme-colors">

                                        <li class="theme-color theme-color-default active" data-theme="default">

                                            <span class="theme-color-view"></span>

                                            <span class="theme-color-name">Dark Header</span>
                                        </li>

                                        <li class="theme-color theme-color-light " data-theme="light">

                                            <span class="theme-color-view"></span>

                                            <span class="theme-color-name">Light Header</span>

                                        </li>

                                    </ul>

                                </div>

                                <div class="col-md-8 col-sm-8 col-xs-12 seperator">

                                    <h3>LAYOUT</h3>

                                    <ul class="theme-settings">

                                        <li> Theme Style

                                            <select class="layout-style-option form-control input-small input-sm">

                                                <option value="square">Square corners</option>

                                                <option value="rounded" selected="selected">Rounded corners</option>

                                            </select>

                                        </li>

                                        <li> Layout

                                            <select class="layout-option form-control input-small input-sm">

                                                <option value="fluid" selected="selected">Fluid</option>

                                                <option value="boxed">Boxed</option>

                                            </select>

                                        </li>

                                        <li> Header

                                            <select class="page-header-option form-control input-small input-sm">

                                                <option value="fixed" selected="selected">Fixed</option>

                                                <option value="default">Default</option>

                                            </select>

                                        </li>

                                        <li> Top Dropdowns

                                            <select class="page-header-top-dropdown-style-option form-control input-small input-sm">

                                                <option value="light">Light</option>

                                                <option value="dark" selected="selected">Dark</option>

                                            </select>

                                        </li>

                                        <li> Sidebar Mode

                                            <select class="sidebar-option form-control input-small input-sm">

                                                <option value="fixed">Fixed</option>

                                                <option value="default" selected="selected">Default</option>

                                            </select>

                                        </li>

                                        <li> Sidebar Menu

                                            <select class="sidebar-menu-option form-control input-small input-sm">

                                                <option value="accordion" selected="selected">Accordion</option>

                                                <option value="hover">Hover</option>

                                            </select>

                                        </li>

                                        <li> Sidebar Position

                                            <select class="sidebar-pos-option form-control input-small input-sm">

                                                <option value="left" selected="selected">Left</option>

                                                <option value="right">Right</option>

                                            </select>

                                        </li>

                                        <li> Footer

                                            <select class="page-footer-option form-control input-small input-sm">

                                                <option value="fixed">Fixed</option>

                                                <option value="default" selected="selected">Default</option>

                                            </select>

                                        </li>

                                    </ul>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

            <ul class="page-breadcrumb breadcrumb">

                <li>

                    <a href="{{url('/')}}">{{__('layout.home')}}</a>

                    <i class="fa fa-circle"></i>

                </li>

                <li>

                    <span class="active">@yield('title')</span>

                </li>

            </ul>

            @if (count($errors) > 0)

                <ul style="border: 1px solid #e02222; background-color: white">

                    @foreach ($errors->all() as $error)

                        <li style="color: #e02222; margin: 15px">{{ $error }}</li>

                    @endforeach

                </ul>

            @endif

            @if (session('status'))

                <ul style="border: 1px solid #01b070; background-color: white">

                    <li style="color: #01b070; margin: 15px">{{  session('status')  }}</li>

                </ul>

            @endif

            @yield('content')

        </div>

    </div>


    <!-- END CONTENT -->

</div>

<div class="page-footer">

    <div class="page-footer-inner"> {{'2018 &copy;'}}

    </div>

    <div class="scroll-to-top">

        <i class="icon-arrow-up"></i>

    </div>

</div>

<script src="{{admin_assets('/global/plugins/jquery.min.js')}}" type="text/javascript"></script>

<script src="{{admin_assets('/global/plugins/bootstrap/js/bootstrap.min.js')}}" type="text/javascript"></script>

<script src="{{admin_assets('/global/plugins/moment.min.js')}}" type="text/javascript"></script>
<script src="{{admin_assets('global/plugins/bootstrap-daterangepicker/daterangepicker.min.js')}}"
        type="text/javascript"></script>

<script src="{{admin_assets('/global/plugins/counterup/jquery.waypoints.min.js')}}" type="text/javascript"></script>

<script src="{{admin_assets('/global/plugins/counterup/jquery.counterup.min.js')}}" type="text/javascript"></script>
<script src="{{admin_assets('/global/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.js')}}"
        type="text/javascript"></script>
<script src="{{admin_assets('/global/plugins/jquery-minicolors/jquery.minicolors.min.js')}}"
        type="text/javascript"></script>

<script src="{{admin_assets('/global/scripts/app.min.js')}}" type="text/javascript"></script>
<script src="{{admin_assets('pages/scripts/components-color-pickers.min.js')}}" type="text/javascript"></script>

<script src="{{admin_assets('/layouts/layout4/scripts/layout.min.js')}}" type="text/javascript"></script>

<script src="{{admin_assets('/global/plugins/bootstrap-sweetalert/sweetalert.min.js')}}"

        type="text/javascript"></script>

<script src="{{admin_assets('/global/plugins/select2/js/select2.full.min.js')}}"

        type="text/javascript"></script>

<script src="{{admin_assets('/pages/scripts/components-select2.min.js')}}"

        type="text/javascript"></script>

<script src="{{admin_assets('/pages/scripts/ui-sweetalert.min.js')}}"

        type="text/javascript"></script>


<script src="{{admin_assets('global/plugins/datatables/datatables.min.js')}}"

        type="text/javascript"></script>


<script src="{{admin_assets('global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js')}}"

        type="text/javascript"></script>

<script src="{{admin_assets('pages/scripts/table-datatables-managed.min.js')}}"

        type="text/javascript"></script>

<script src="{{admin_assets('global/plugins/ckeditor/ckeditor.js')}}"

        type="text/javascript"></script>


<script src="{{admin_assets('calendar/custom.js')}}" type="text/javascript"></script>

{{--<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>--}}

<script src="{{admin_assets('sweet_alert/sweetalert.min.js')}}" type="text/javascript"></script>

<script src="{{admin_assets('global/plugins/bootstrap-switch/js/bootstrap-switch.min.js')}}"

        type="text/javascript"></script>


@yield('js')


<script>

    $(document).ready(function () {

        $('#clickmewow').click(function () {

            $('#radio1003').attr('checked', 'checked');

        });

    });


</script>

<script>

    $('#toolsTable').DataTable({

        dom: 'Bfrtip',

        searching: false,

        bInfo: false, //Dont display info e.g. "Showing 1 to 4 of 4 entries"

        paging: false,//Dont want paging

        bPaginate: false,//Dont want paging

        buttons: [

            'copy', 'excel', 'pdf', 'print'

        ]

    });

    $('.btn--filter').click(function () {

        $('.box-filter-collapse').slideToggle(500);

    });

    var IDArray = [];

    $("input:checkbox[name=chkBox]:checked").each(function () {

        IDArray.push($(this).val());

    });

    if (IDArray.length == 0) {

        $('.event').attr('disabled', 'disabled');
        $('.event2').attr('disabled', 'disabled');

    }

    $('.chkBox').on('change', function () {

        var IDArray = [];

        $("input:checkbox[name=chkBox]:checked").each(function () {

            IDArray.push($(this).val());

        });

        if (IDArray.length == 0) {

            $('.event').attr('disabled', 'disabled');
            $('.event2').attr('disabled', 'disabled');

        } else {

            $('.event').removeAttr('disabled');
            $('.event2').removeAttr('disabled');

        }

    });

    $('.event').on('click', function () {


        var event = $(this).attr('id');

        var url = $('#url').val();

        var csrf_token = '{{csrf_token()}}';

        var IDsArray = [];

        $("input:checkbox[name=chkBox]:checked").each(function () {

            IDsArray.push($(this).val());

        });


        if (IDsArray.length > 0) {

            $.ajax({

                type: 'POST',

                headers: {'X-CSRF-TOKEN': csrf_token},

                url: url,

                data: {event: event, IDsArray: IDsArray, _token: csrf_token},

                success: function (response) {

                    if (response === 'active') {

                        $.each(IDsArray, function (index, value) {

                            $('#label-' + value).removeClass('label-danger');

                            $('#label-' + value).addClass('label-info');

                            $('#label-' + value).text('active');

                        });

                    } else if (response === 'not_active') {

                        $.each(IDsArray, function (index, value) {

                            $('#label-' + value).removeClass('label-info');

                            $('#label-' + value).addClass('label-danger');

                            $('#label-' + value).text('Not Active');

                        });

                    } else if (response === 'canceled') {

                        $.each(IDsArray, function (index, value) {

                            $('#label-' + value).removeClass('label-info');

                            $('#label-' + value).addClass('label-danger');

                            $('#label-' + value).text('Canceled');

                        });

                    } else if (response === 'new') {

                        $.each(IDsArray, function (index, value) {

                            $('#label-' + value).removeClass('label-danger');

                            $('#label-' + value).addClass('label-info');

                            $('#label-' + value).text('new');

                        });

                    } else if (response === 'delete') {

                        $.each(IDsArray, function (index, value) {

                            $('#tr-' + value).hide(2000);

                        });

                    }


                },

                fail: function (e) {

                    alert(e);

                }

            });

        } else {

            alert('{{__('common.not_selected')}}');

        }

    });


    $('.event2').on('click', function () {

        swal({

            title: "{{__('common.confirm')}}",

            text: "{{__('cafe.delete_msg')}}",

            icon: "warning",

            buttons: true,

            dangerMode: true

        }).then((willDelete) => {
            if (willDelete) {

                var event = $(this).attr('id');

                var url = $('#url').val();

                var csrf_token = '{{csrf_token()}}';

                var IDsArray = [];

                $("input:checkbox[name=chkBox]:checked").each(function () {

                    IDsArray.push($(this).val());

                });
                if (IDsArray.length > 0) {

                    $.ajax({

                        type: 'POST',

                        headers: {'X-CSRF-TOKEN': csrf_token},

                        url: url,

                        data: {event: event, IDsArray: IDsArray, _token: csrf_token},

                        success: function (response) {

                            if (response === 'active') {

                                $.each(IDsArray, function (index, value) {

                                    $('#label-' + value).removeClass('label-danger');

                                    $('#label-' + value).addClass('label-info');

                                    $('#label-' + value).text('active');

                                });

                            } else if (response === 'not_active') {

                                $.each(IDsArray, function (index, value) {

                                    $('#label-' + value).removeClass('label-info');

                                    $('#label-' + value).addClass('label-danger');

                                    $('#label-' + value).text('Not Active');

                                });

                            } else if (response === 'delete') {

                                $.each(IDsArray, function (index, value) {

                                    $('#tr-' + value).hide(2000);

                                });

                            }


                        },

                        fail: function (e) {

                            alert(e);

                        }

                    });

                } else {

                    alert('{{__('common.not_selected')}}');

                }
            } else {

                swal("{{__('cafe.delete_cancel')}}");

            }

        });
    });


    function readURL(input, target) {

        if (input.files && input.files[0]) {

            var reader = new FileReader();

            reader.onload = function (e) {

                target.attr('src', e.target.result);

            };

            reader.readAsDataURL(input.files[0]);

        }

    }


</script>


@yield('script')

</body>


</html>