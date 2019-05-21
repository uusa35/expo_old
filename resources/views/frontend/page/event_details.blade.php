@extends('frontend.layouts.master')

@section('content')

<section class="section-innerPage-content">

			<div class="container">

				<div class="event--details">

					<div class="row">

						<div class="col-sm-6">

							<div class="h-s-thumb">

								<img src="{{$item->image}}" alt="" class="img-responsive">

							</div>

						</div>

						<div class="col-sm-6">

							<div class="event--txt">

								<h2></h2>

								<p>{!!$item->details!!}</p>

							</div>

						</div>

					</div>

				</div>

			</div>

		</section>

		@endsection