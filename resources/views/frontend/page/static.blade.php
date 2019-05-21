@extends('frontend.layouts.master')
@section('content')
<section class="section-innerPage-content padd-0">
			<div class="about-page clearfix">
				<div class="about--img" style="background-image: url({{ asset('frontend_assets/images/stock-photo-94764209.jpg);')}}">
					<img src="{{ asset('frontend_assets/images/stock-photo-94764209.jpg')}}" alt="">
				</div>
			</div>
			<div class="container">
				<div class="row">
					<div class="col-md-6 col-md-offset-6 col-sm-6 col-sm-offset-6">
						<div class="about--txt">
							<div class="about-txt-box">
								<p>{!!$page_info->value!!}</p>
						</div>
					</div>
				</div>
			</div>
		</section><!--section-innerPage-content-->
		@endsection