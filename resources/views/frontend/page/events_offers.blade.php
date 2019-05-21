@extends('frontend.layouts.master')
@section('content')
<section class="top-innerPage-box">
			<div class="container">
				<div class="top-iP-left">
					<h2>{{__('home.events_offers')}}</h2>
					<p></p>
				</div>
			</div>
		</section>
		<section class="section-innerPage-content">
			<div class="container">
				<div class="offer-box">
					<h2 class="sec-title">{{__('home.events')}}</h2>
					<div class="owl-carousel offers-slide">
						@if(!empty($events))
							@foreach($events as $item)
							<div class="item">
										<div class="offer-item">
											<div class="offer-thumb">
												<a href="{{route('event_details',['type_id'=>$item->id])}}" class="img-hover">
													<img src="{{$item->image}}" alt="" class="img-responsive">
												</a>
											</div>
											<div class="offer-txt">
												<h2><a href="#"></a></h2>
												<p>{!!$item->details!!}</p>
											</div>
										</div>
									</div>
							@endforeach
						@else
						@endif
					</div>
				</div>
				<div class="offer-box">
					<h2 class="sec-title">{{__('home.offers')}}</h2>
					<div class="owl-carousel offers-slide">
							@if(!empty($offers))
							@foreach($offers as $item)
							<div class="item">
									<div class="offer-item">
										<div class="offer-thumb">
											<a href="{{route('event_details',['type_id'=>$item->id])}}" class="img-hover">
												<img src="{{$item->image}}" alt="" class="img-responsive">
											</a>
<!-- 											<span class="off-salary">$14.99</span>
 -->										</div>
										<div class="offer-txt">
											<h2><a href="#"></a></h2>
											<p>{!!$item->details!!}</p>
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