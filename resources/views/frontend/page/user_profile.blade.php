@extends('frontend.layouts.master')

@section('content')

<section class="top-innerPage-box">

			<div class="container">

				<div class="profile--block">

					<img src="{{ asset('frontend_assets/images/e9a74caa193854d2c175f884862cdf64.png')}}" alt="">

					<h2>{{$info['name']}}</h2>

					<h3>{{$info['email']}}</h3>

					<a href="#" class="view-btn edit-profile">{{__('home.edit_profile')}}</a>

				</div>

			</div>
		 </section>
			@endsection