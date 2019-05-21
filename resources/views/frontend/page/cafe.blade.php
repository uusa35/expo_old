@extends('frontend.layouts.master')


@section('content')

   <!-- Modal -->
  <div class="modal fade" id="myModal2" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
          <p style="font-size: 16px;">{{$cafe->smoking_note}}</p>
        </div>
      </div>
      
    </div>
  </div>

<section class="top-innerPage-box">

			<div class="container">
				<div class="top-iP-left">
					<h2>{{$cafe->title}}</h2>
				</div>
				<div class="filter-category">
					@if(!empty($menu_images{0}->image))
					<a data-fancybox="gallery" href="{{$menu_images{0}->image}}" class="view-btn">show menu</a>
					@else
					<a class="view-btn">show menu</a>
					@endif

				</div>

			</div>

		</section>

		<section class="section-innerPage-content">

			<div class="container">

				<div class="cafe-desc-box">

					<div class="row">
							
						<div class="col-md-5">
							
							<div class="cafe--thumb">

								<img src="{{$cafe->logo}}" alt="" class="img-responsive">

							</div>
							
						</div>

						<div class="col-md-7">

							<div class="cafe--txt">

								<p>{!! $cafe->details!!}</p>

								<ul class="meta-cafe clearfix">

									<li><img src="{{ asset('frontend_assets/images/Icon-map.svg')}}" alt=""><a href="https://www.google.com/maps/place/{{$cafe->latitude}},{{$cafe->longitude}}"> {{(!empty($cafe->location)) ? $cafe->location :"Unnamed address"}}</a></li>

									<li><img src="{{ asset('frontend_assets/images/Time-Icon.svg')}}" alt="">{{$cafe->time_from}} - {{$cafe->time_to}}</li>

								</ul>
								<!-- Go to www.addthis.com/dashboard to customize your tools -->
							<div class="addthis_inline_share_toolbox"></div>
								 <div class="clearfix">
									<div class="rating-content">
										<fieldset class="rating">
											{{csrf_field()}}
										    <input type="radio" class="star"  @if($cafe->rating_avg=='5') checked @endif id="star5" name="rating" value="5" />
						                    <label class="star" for="star5" title="Awesome" aria-hidden="true"></label>
						                    <input type="radio" class="star"  @if($cafe->rating_avg=='4') checked @endif id="star4" name="rating" value="4" />
						                    <label class="star" for="star4" title="Great" aria-hidden="true"></label>
						                    <input type="radio" class="star"  @if($cafe->rating_avg=='3') checked @endif id="star3" name="rating" value="3" />
						                    <label class="star" for="star3" title="Very good" aria-hidden="true"></label>
						                    <input type="radio" class="star"  @if($cafe->rating_avg=='2') checked @endif id="star2" name="rating" value="2" />
						                    <label class="star" for="star2" title="Good" aria-hidden="true"></label>
						                    <input type="radio" class="star"  @if($cafe->rating_avg=='1') checked @endif id="star1" name="rating" value="1" />
						                    <label class="star" for="star1" title="Bad" aria-hidden="true"></label>
										    <input type="hidden" name="cafe_id" value="{{$cafe->id}}">
										</fieldset>
									</div>
								</div>
								<div class="cafe-thumbs-b">

									<div class="row">

										<div class="col-xs-3">

											<div class="cafe-fetBox">

												<img src="{{ asset('frontend_assets/images/Icon-smoke.svg')}}" alt="">

												<h3>{{__('home.smoking')}}</h3>

												@if(in_array(1,explode(",",$cafe->features)))

												<p>Yes</p>

												@else

												<p><a data-toggle="modal" data-target="#myModal2">No</a></p>

												@endif

											</div>

										</div>

										<div class="col-xs-3">

											<div class="cafe-fetBox">

												<img src="{{ asset('frontend_assets/images/boo.svg')}}" alt="">

												<h3>{{__('home.study_places')}}</h3>

												@if(in_array(2,explode(",",$cafe->features)))

												<p>Yes</p>

												@else

												<p>No</p>

												@endif

											</div>

										</div>

										<div class="col-xs-3">

											<div class="cafe-fetBox">

												<img src="{{ asset('frontend_assets/images/sofa.svg')}}" alt="">

												<h3>{{__('home.meeting_rooms')}}</h3>

												@if(in_array(3,explode(",",$cafe->features)))

												<p>Yes</p>

												@else

												<p>No</p>

												@endif

											</div>

										</div>

										<div class="col-xs-3">

											<div class="cafe-fetBox">

												<img src="{{ asset('frontend_assets/images/percentage-38.svg')}}" alt="">

												<h3>Discount</h3>

												<p>{{$cafe->discount_code}}</p>

											</div>

										</div>

									</div>

								</div>

							</div>

						</div>

					</div>

				</div>

				

				<div class="cafe-photo-box">

					<!-- <h2>Menu Photos</h2> -->

					<div class="row">

						@if(!empty($menu_images))
						<?$count=1;?>
						@foreach($menu_images as $item)
							@if($count!=1)
							<div class="col-sm-4" hidden>
							<div class="rating-item">
								<a href="{{$item->image}}" class="img-hover" data-fancybox="gallery">

									<img   src="{{$item->image}}" alt="" class="img-responsive">
								</a>
							</div>
						</div>
						@else
						@endif
						<?$count++;?>
						@endforeach

						@else

						@endif	

					</div>

				</div>

				<div class="clearfix"></div>

				<div class="cafe-photo-box">

					<h2>Products Photo</h2>

					<div class="row products-visible">

						@if(!empty($products))

						@foreach($products as $item)

							<div class="col-sm-4">

							<div class="rating-item">

								<a href="{{$item->image}}" class="img-hover" ><!--data-fancybox="gallery" -->

									<img src="{{$item->image}}" alt="" class="img-responsive">

								</a>

							</div>

						</div>

						@endforeach

						@else

						@endif	

					</div>
					<div class="products-hiddin">
						<div class="owl-carousel" id="rating-slide">
							@if(!empty($products))

							@foreach($products as $item)
							<div class="item">
								<div class="rating-item">

									<a href="{{$item->image}}" class="img-hover" ><!--data-fancybox="gallery" -->

										<img src="{{$item->image}}" alt="" class="img-responsive">

									</a>

								</div>
							</div>
							@endforeach

							@else

							@endif
						</div>
					</div>

				</div>

			

			</div>

		</section><!--section-innerPage-content-->

		@endsection

		@section('script')

		<!-- Go to www.addthis.com/dashboard to customize your tools -->
		<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-5a9cff9ff7a93f4f"></script>


		<script>
		    $('body').on('change','.star',function(){
		        $value = $(this).val();
		        $cafe=$(this).parent().find('input[name="cafe_id"]').val();
		        $token=$(this).parent().find('input[name="_token"]').val();
		        $.post('{{route('rating')}}',{_token:$token,cafe_id:$cafe,rate:$value},function(data){
		        });
		    });
		</script>


		@endsection