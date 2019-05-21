@extends('frontend.layouts.master')
@section('content')
<section class="section-innerPage-content login-page">
            <div class="login-box">
                <h2>{{__('home.sign_up')}}</h2>
             <form class="form-style1 clearfix" method="POST" action="{{ route('register') }}">
                    <div class="row">
                          {{ csrf_field() }}
                        <div class="col-sm-6">
                            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                <label>{{__('home.first_name')}}</label>
                                <input id="name" type="text" class="form-control" name="fname" value="{{ old('name') }}" required autofocus>
                                @if ($errors->has('fname'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('fname') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                <label>{{__('home.last_name')}}</label>
                                <input id="name" type="text" class="form-control" name="lname" value="{{ old('name') }}" required autofocus>
                                     @if ($errors->has('lname'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('lname') }}</strong>
                                        </span>
                                    @endif
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                <label>{{__('home.email')}}</label>
                                <input type="email" class="form-control" name="email"  placeholder="Email Address">
                                 @if ($errors->has('email'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                 @endif </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                             <div class="form-group">
                              <label>{{__('home.register_as')}}</label>
                                    <div class="radio">
                                      <label><input type="radio" name="user_type" value="1">{{__('home.user')}}</label>
                                    </div>
                                    <div class="radio">
                                      <label><input type="radio" name="user_type"  value="2">{{__('home.cafe_owner')}}</label>
                                    </div>
                            </div>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                <label>{{__('home.password')}}</label>
                                <input type="password" name="password"class="form-control" placeholder="Type password">
                                @if ($errors->has('password'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('password') }}</strong>
                                        </span>
                                 @endif </div>
                            </div>
                        </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label>{{__('home.repeat_password')}}</label>
                                <input id="password-confirm" name="password_confirmation"  type="password" class="form-control" name="password_confirmation" required> 
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-st-submit">{{__('home.sign_up')}}</button>
                </form>
            </div>
        </section><!--section-innerPage-content-->
@endsection
