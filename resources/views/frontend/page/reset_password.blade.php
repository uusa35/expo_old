@extends('frontend.layouts.master')
@section('content')
      <section class="section-innerPage-content login-page">
            <div class="login-box">
                <h2>{{__('home.reset')}}</h2>
                 <form class="form-style1 clearfix" method="POST" action="{{ route('password.email') }}">
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
                    <button type="submit" class="btn btn-st-submit">{{__('home.send_reset_link')}}</button>
                </form>
            </div>
        </section>
@endsection
