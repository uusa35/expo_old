@extends('frontend.layouts.master')
@section('content')
	<section class="top-innerPage-box">
		<div class="container">
		<div class="row">
		<div class="top-iP-left">
			<h2>{{__('home.expired')}}</h2>
			<br><br>
			<br><br>
			<h3>{{__('home.subscription')}} <a href="{{route('packages')}}">{{__('home.here')}}</a><h3>
			<br><br><br><br>
			<br><br><br><br>
    		</div>
		  </div>
		</div>	
	</section>
@endsection
