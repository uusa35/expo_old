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

					<h2>{{__('home.browse_cafés')}}</h2>

					<p></p>

				</div>

				<div class="filter-category clearfix">

					<!-- <div class="filter-rg">

						<select class="form-control">

							@foreach($category as $item)

							<option value="{{$item->id}}">{{$item->title}}</option>

							@endforeach

						</select>

						<img src="{{ asset('frontend_assets/images/Arrow.svg')}}" alt="">

					</div> -->

				<!-- 	<div class="filter-rg">

						<select class="form-control">

							<option>Recent</option>

							<option>Recent</option>

							<option>Recent</option>

						</select>

						<img src="{{ asset('frontend_assets/images/Arrow.svg')}}" alt="">

					</div> -->

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
									{!! substr($item->details,0,50) !!}

								</div>

							</div>

						</div>

						@endforeach

						@else

						@endif

					</div>

					{{ $cafes->links() }}

					<!-- <a  id="load_more" class="view-btn">Load More</a> -->

				</div>

			</div>

		</section><!--section-innerPage-content-->

			@endsection



			<!-- @section('script')

			<script>

			$(document).on("click", "#load_more", function () {

				alert('dd');

			    load_more();   

			});

			function load_more() {

			       $.get('{{route('cafes')}}',{},function(data){

	               console.log(data);

	               });    

			}

			</script>

			@endsection -->