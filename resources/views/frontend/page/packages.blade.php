@extends('frontend.layouts.master')

@section('content')
<section class="section-innerPage-content">
			<div class="container">
				<div class="content-pricing">
					<div class="pricing-list">
						<div class="row">
							<form action="{{route('store_package')}}" method="post">
							{{csrf_field()}}	
							@if(!empty($packages))
							@foreach($packages as $item)
								<div class="col-md-4">
									<div class="pricing-box">
										<div class="pricing-head">
											<div class="pri-thumb">
												<img src="{{$item->image}}" alt="" class="img-responsive">
											</div>
											<h2>{{$item->title}}</h2>
											<p><span>{{$item->price}} JD</span> / {{$item->duration}} Month</p>
										</div>
										<div class="col-md-12">
											<div  class="radio">
											  <label><input style="height: 20px;width: 20px;" type="radio" value="{{$item->id}}" name="package_no"></label>
											</div>
										</div>
									</div>
								</div>
							@endforeach
							@else
							@endif
						</div>
					</div>
				</div>
					<button style="margin-left: 43%;" type="submit" class="view-btn">{{__('home.submit')}}</button>
			      </form>
			</div>
		</section><!--section-innerPage-content-->
@endsection