@extends('frontend.layouts.master')
@section('content')
<style>
.pagination>.active>span{
	background-color: #fac05a;
    border-color: #fac05a;
}
</style>
<section class="top-innerPage-box">
			<div class="container">
				<div class="top-iP-left">
				</div>
			</div>
		</section>
		<section class="section-innerPage-content">
			<div class="container">
				
				<div class="category-items-list">
					<div class="row">
						@if(!$cafes->isEmpty())
						<h2>{{__('home.result_in_cafes')}}</h2>
						<br>
						@foreach($cafes as $item)
						<div class="col-sm-4 col-xs-6">
							<div class="Cafes-item">
								<a href="{{route('cafe',['cafe'=>$item->id])}}" class="Cafes-i-thumb img-hover">
									<img src="{{$item->logo}}" alt="" class="img-responsive">
								</a>
								<div class="Cafes-i-txt">
									<h2><a href="{{route('cafe',['cafe'=>$item->id])}}">{{$item->title}}</a></h2>
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
				<div class="container">
				<div class="category-items-list">
					<div class="row">
						@if(!$products->isEmpty())
						<h2>{{__('home.result_in_products')}}</h2>
						<br>
						@foreach($products as $item)
						<div class="col-sm-4 col-xs-6">
							<div class="Cafes-item">
								<a  class="Cafes-i-thumb img-hover">
									<img src="{{$item->image}}" alt="" class="img-responsive">
								</a>
								<div class="Cafes-i-txt">
									<h2><a >{{$item->title}}</a></h2>
									<p>{!!$item->details!!}</p>
								</div>
							</div>
						</div>
						@endforeach
						@else
						
						@endif
					</div>
				</div>
				@if($cafes->isEmpty() && $products->isEmpty())
				<h2>No result </h2>
				@endif
			</div>
		</section>
			@endsection