@extends('frontend.layouts.master')
@section('content')
<section class="top-innerPage-box">
			<div class="container">
				<div class="profile--block">
					<img src="{{ !empty(Auth::user()->image)? Auth::user()->image :'' }}" alt="">

					<h2>{{$info['name']}}</h2>

					<h3>{{$info['email']}}</h3>

					<a href="{{route('edit_profile')}}" class="view-btn edit-profile">{{__('home.edit_profile')}}</a>
				</div>
			</div>
		</section>
		<section class="section-innerPage-content">
			<div class="container">
				<div class="category-items-list">
					<div class="row">
						@if(!empty($cafes))
							@foreach($cafes as $item)
							<div class="col-sm-4 col-xs-6">
								<div class="Cafes-item">
									<a href="{{route('cafe',['cafe'=>$item->id])}}" class="Cafes-i-thumb img-hover">
										<img src="{{$item->logo}}" alt="" class="img-responsive">
									</a>
									<div class="Cafes-i-txt">
										<h2><a href="{{route('cafe',['cafe'=>$item->id])}}">{{$item->title}}</a></h2>
										<p>{!! $item->details !!}</p>
									</div>
								</div>
						   </div>
							@endforeach
						  @else
						@endif
					</div>
				</div>
			</div>
		</section><!--section-innerPage-content-->

			@endsection
