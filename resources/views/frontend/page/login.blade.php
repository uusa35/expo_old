@extends('frontend.layouts.master')
@section('content')
<section class="section-innerPage-content login-page">
            <div class="login-box">
                <h2>{{__('home.sign_in')}}</h2>
                 <form class="form-style1 clearfix" method="POST" action="{{ route('login') }}">
                   {{ csrf_field() }}
                    <div class="form-group">
                        <label>{{__('home.email')}}</label>
                     <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autofocus>
                     @if ($errors->has('email'))
                        <span class="help-block">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                    @endif
                    </div>
                    <div class="form-group">
                        <label>{{__('home.password')}}</label>
                       <input id="password" type="password" class="form-control" name="password" required>
                          @if ($errors->has('password'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                            @endif
                    </div>
                    <a href="{{route('reset_password')}}">{{__('home.forget')}}</a>
                    <button type="submit" class="btn btn-st-submit">{{__('home.sign_in')}}</button>
                </form>
            </div>
        </section>
@endsection
