@extends('frontend.layouts.master')
@section('content')
<section class="section-innerPage-content login-page">
            <div class="login-box">
                <h2>{{__('home.reset')}}</h2>
                 <form class="form-style1 clearfix" method="POST" action="{{ route('password.request') }}">
                   {{ csrf_field() }}
                   <input type="hidden" name="token" value="{{$reset_token}}">
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
                    <div class="form-group">
                        <label>{{__('home.confirm')}}</label>
                       <input id="password_confirmation" type="password" class="form-control" name="password_confirmation" required>
                           @if ($errors->has('password_confirmation'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password_confirmation') }}</strong>
                                    </span>
                            @endif
                    </div>
                    <button type="submit" class="btn btn-st-submit">{{__('home.submit')}}</button>
                </form>
            </div>
        </section>
@endsection