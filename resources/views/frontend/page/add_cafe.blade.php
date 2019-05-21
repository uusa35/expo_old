@extends('frontend.layouts.master')

@section('page_css')
<link href="{{ asset('frontend_assets/js/select2/select2.css')}}" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="{{ asset('frontend_assets/css/bootstrap-datetimepicker.min.css')}}">

 <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCjOp2BjQx-ruFkTnb4mB_2m3eFtcCyPbU&sensor=false&libraries=places"></script>

@endsection
@section('content')
<section class="top-innerPage-box">
			<div class="container">
				<div class="top-iP-left">
					<h2>{{__('home.add_your_cafe')}}</h2>
					<p></p>
				</div>
			</div>
		</section>
		<section class="section-innerPage-content">
			    <div>
			    <div class="clearfix"></div>
				@if(session()->has('status'))
			    <div class="alert alert-success">
			        {{ session()->get('status') }}
			    </div>
				@endif
			   </div>
			   <div>
				@if ($errors->any())
				    <div class="alert alert-danger">
				        <ul>
				            @foreach ($errors->all() as $error)
				                <li>{{ $error }}</li>
				            @endforeach
				        </ul>
				    </div>
				@endif
			   </div>
			<div class="container">
				<div class="addCafe-whiteBox">
					<form class="form-style1 clearfix" action="{{route('store_cafe')}}"  enctype="multipart/form-data" method="Post">
						{{csrf_field()}}
						<div class="row">
							<div class="col-md-6">
								<h2 class="ac-trg">{{__('home.information')}}</h2>
								<div class="form-group">
									<label>{{__('home.cafe_name')}}</label>
									<input type="text" name="title" class="form-control" placeholder="Your café name" value="{{ old('title') }}">
								</div>
								<div class="form-group" hidden>
									<label>{{__('home.cafe_category')}}</label>
									<select class="form-control chosen-select" name="category_id">
										@if(!empty($categories))
										@foreach($categories as $item)
										<option value="{{$item->id}}">{{$item->title}}</option>
										@endforeach
										@else
										@endif
										
									</select>
								</div>
								<div class="form-group input-col">
									<label>{{__('home.worktime')}}</label>
									<div class="row">
										<div class="col-xs-6">
											<div class="worktime-input">
												<div class="worktime-label">
													<img src="{{ asset('frontend_assets/images/Time-Icon.svg')}}" alt="">
													<span></span>
												</div>
												<input type="text" name="time_from" class="form-control" id="datetimepicker1" name="fromdate" placeholder="From">
											</div>
										</div>
										<div class="col-xs-6">
											<div class="worktime-input">
												<div class="worktime-label">
													<img src="{{ asset('frontend_assets/images/Time-Icon.svg')}}" alt="">
													<span></span>
												</div>
												<input type="text" name="time_to" class="form-control" id="datetimepicker2" name="todate" placeholder="To">
											</div>
										</div>
									</div>
								</div>
								<div class="form-group location-map">
									
								<fieldset>

                                <legend>{{__('home.location')}}</legend>

                                <input id="searchInput" class="input-controls" type="text"

                                       placeholder="Enter a location">

                                <div class="map" id="map" style="width: 100%; height: 300px;"></div>

                                <div class="form_area">

                                    <input type="hidden" name="location" id="location" value="">

                                    <input type="hidden" name="latitude" id="lat" value="34.339102">

                                    <input type="hidden" name="longitude" id="lng" value="31.386909">

                                </div>

                                <script>

                                    /* script */

                                    function initialize() {

                                        var latlng = new google.maps.LatLng('31.386909', '34.339102');

                                        var map = new google.maps.Map(document.getElementById('map'), {

                                            center: latlng,

                                            zoom: 10

                                        });

                                        var marker = new google.maps.Marker({

                                            map: map,

                                            position: latlng,

                                            draggable: true,

                                            anchorPoint: new google.maps.Point(0, -29)

                                        });

                                        var input = document.getElementById('searchInput');

                                        map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);

                                        var geocoder = new google.maps.Geocoder();

                                        var autocomplete = new google.maps.places.Autocomplete(input);

                                        autocomplete.bindTo('bounds', map);

                                        var infowindow = new google.maps.InfoWindow();

                                        autocomplete.addListener('place_changed', function () {

                                            infowindow.close();

                                            marker.setVisible(false);

                                            var place = autocomplete.getPlace();

                                            if (!place.geometry) {

                                                window.alert("Autocomplete's returned place contains no geometry");

                                                return;

                                            }



                                            // If the place has a geometry, then present it on a map.

                                            if (place.geometry.viewport) {

                                                map.fitBounds(place.geometry.viewport);

                                            } else {

                                                map.setCenter(place.geometry.location);

                                                map.setZoom(17);

                                            }



                                            marker.setPosition(place.geometry.location);

                                            marker.setVisible(true);



                                            bindDataToForm(place.formatted_address, place.geometry.location.lat(), place.geometry.location.lng());

                                            infowindow.setContent(place.formatted_address);

                                            infowindow.open(map, marker);



                                        });

                                        // this function will work on marker move event into map

                                        google.maps.event.addListener(marker, 'dragend', function () {

                                            geocoder.geocode({'latLng': marker.getPosition()}, function (results, status) {

                                                if (status == google.maps.GeocoderStatus.OK) {

                                                    if (results[0]) {

                                                        bindDataToForm(results[0].formatted_address, marker.getPosition().lat(), marker.getPosition().lng());

                                                        infowindow.setContent(results[0].formatted_address);

                                                        infowindow.open(map, marker);

                                                    }

                                                }

                                            });

                                        });

                                    }



                                    function bindDataToForm(address, lat, lng) {

                                        document.getElementById('location').value = address;

                                        document.getElementById('lat').value = lat;

                                        document.getElementById('lng').value = lng;

//                                                console.log('location = ' + address);

//                                                console.log('lat = ' + lat);

//                                                console.log('lng = ' + lng);

                                    }



                                    google.maps.event.addDomListener(window, 'load', initialize);

                                </script>

                            </fieldset>


								</div>
								<div class="form-group input-col">
									<div class="row">
										<div class="col-xs-6">
											<label>{{__('home.cafe_logo')}}</label>
											<div class="upload--images-box">
	                                            <div class="up--image--file">
	                                                <input type="file" name="logo" id="up--file">
	                                                <div class="drop">
		                                                <div class="cont">
													      <img src="{{ asset('frontend_assets/images/Upload Icon.svg')}}" alt="">
													      <div class="tit">
													      	{{__('home.drag')}}
													      </div>
													      <div class="desc">
													        or 
													      </div>
													      <div class="browse">
													        {{__('home.choose')}}
													      </div>
													    </div>
												    </div>
	                                            </div>
	                                            <div class="up--image--result">
	                                                <img src="" alt="" class="up-img-pic">
	                                            </div>
	                                        </div>
										</div>
										<div class="col-xs-6">
											<label> {{__('home.menu_photo')}}</label>
											<div class="upload--images-box">
	                                            <div class="up--image--file">
	                                                <input type="file" name="menu_images[]" multiple id="up--file1">
	                                                <div class="drop">
		                                                <div class="cont">
													      <img src="{{ asset('frontend_assets/images/Upload Icon.svg')}}" alt="">
													      <div class="tit">
													       {{__('home.drag')}}
													      </div>
													      <div class="desc">
													        or 
													      </div>
													      <div class="browse">
													        {{__('home.choose')}}
													      </div>
													    </div>
												    </div>
	                                            </div>
	                                            <div class="up--image--result">
	                                                <img src="" alt="" class="up-img-pic1">
	                                            </div>
	                                        </div>
										</div>
									</div>
								</div>
								<div class="form-group">
									<label>{{__('home.description')}}</label>
									<textarea class="form-control" name="details" placeholder="Type additional information">{{ old('details') }}</textarea>
								</div>
							</div>
							<div class="col-md-6">
								<h2 class="ac-trg">{{__('home.cafe_photos')}}</h2>
								<div class="cafe-photo-group">
									<ul class="cafe-tab-menu clearfix">
										<li class="active">
											<a href="#cafe-tab1" data-toggle="tab" aria-expanded="true">{{__('home.first')}}</a>
										</li>
										<li>
											<a href="#cafe-tab2" data-toggle="tab" aria-expanded="false">{{__('home.second')}}</a>
										</li>
										<li>
											<a href="#cafe-tab3" data-toggle="tab" aria-expanded="false">{{__('home.third')}}</a>
										</li>
									</ul>
									<div class="tab-content">
										<div class="tab-pane active" id="cafe-tab1">
											<div class="form-group">
												<label>{{__('home.cafe_logo')}}</label>
												<div class="upload--images-box">
		                                            <div class="up--image--file">
		                                                <input type="file" name="products_logo1" id="up--file2">
		                                                <div class="drop">
			                                                <div class="cont">
														      <img src="{{ asset('frontend_assets/images/Upload Icon.svg')}}" alt="">
														      <div class="tit">
														       	{{__('home.drag')}}
														      </div>
														      <div class="desc">
														        or 
														      </div>
														      <div class="browse">
														        {{__('home.choose')}}
														      </div>
														    </div>
													    </div>
		                                            </div>
		                                            <div class="up--image--result">
		                                                <img src="" alt="" class="up-img-pic2">
		                                            </div>
		                                        </div>
		                                    </div>
		                                    <div class="form-group">
												<label> {{__('home.title')}}</label>
												<input type="text" name="products_title1" value="{{ old('products_title1') }}" class="form-control" placeholder="Title to your photo">
											</div>
		                                    <div class="form-group">
												<label>{{__('home.description')}}</label>
												<textarea class="form-control" name="products_details1"  placeholder="Type description">{{ old('products_details1') }}</textarea>
											</div>
										</div>
										<div class="tab-pane fade" id="cafe-tab2">
											<div class="form-group">
												<label>{{__('home.cafe_logo')}}</label>
												<div class="upload--images-box">
		                                            <div class="up--image--file">
		                                                <input type="file" name="products_logo2" id="up--file3">
		                                                <div class="drop">
			                                                <div class="cont">
														      <img src="{{ asset('frontend_assets/images/Upload Icon.svg')}}" alt="">
														      <div class="tit">
														       	{{__('home.drag')}}
														      </div>
														      <div class="desc">
														        or 
														      </div>
														      <div class="browse">
														        {{__('home.choose')}}
														      </div>
														    </div>
													    </div>
		                                            </div>
		                                            <div class="up--image--result">
		                                                <img src="" alt="" class="up-img-pic3">
		                                            </div>
		                                        </div>
		                                    </div>
		                                    <div class="form-group">
												<label>{{__('home.title')}}</label>
												<input type="text" name="products_title2" value="{{ old('products_title2') }}" class="form-control" placeholder="Title to your photo">
											</div>
		                                    <div class="form-group">
												<label>{{__('home.description')}}</label>
												<textarea class="form-control" name="products_details2" placeholder="Type description">{{ old('products_details2') }}</textarea>
											</div>
										</div>
										<div class="tab-pane fade" id="cafe-tab3">
											<div class="form-group">
												<label>{{__('home.cafe_logo')}}</label>
												<div class="upload--images-box">
		                                            <div class="up--image--file">
		                                                <input type="file" name="products_logo3" id="up--file4">
		                                                <div class="drop">
			                                                <div class="cont">
														      <img src="{{ asset('frontend_assets/images/Upload Icon.svg')}}" alt="">
														      <div class="tit">
														       	{{__('home.drag')}}
														      </div>
														      <div class="desc">
														        or 
														      </div>
														      <div class="browse">
														        {{__('home.choose')}}
														      </div>
														    </div>
													    </div>
		                                            </div>
		                                            <div class="up--image--result">
		                                                <img src="" alt="" class="up-img-pic4">
		                                            </div>
		                                        </div>
		                                    </div>
		                                    <div class="form-group">
												<label>{{__('home.title')}}</label>
												<input type="text" name="products_title3" value="{{ old('products_title3') }}" class="form-control" placeholder="Title to your photo">
											</div>
		                                    <div class="form-group">
												<label>{{__('home.description')}}</label>
												<textarea class="form-control" name="products_details3" placeholder="Type description">{{ old('products_details3') }}</textarea>
											</div>
										</div>
									</div>
								</div>
								<h2 class="ac-trg">{{__('home.features')}}</h2>
								<div class="features-group">
									<div class="feat-row clearfix">
										<p>{{__('home.smoking')}}</p>
										<div class="switch-checkbox">
	                                       <label class="switch">
	                                          <input type="checkbox" id="smoking" name="features[]" value="1" >
	                                          <div class="slider round clearfix">
	                                          	<span class="s-yes">{{__('home.yes')}}</span>
	                                          	<span class="s-no">{{__('home.no')}}</span>
	                                          </div>
	                                        </label>
	                                    </div>
									</div>
									<div class="form-group" id="smoking_note">
									<label>{{__('home.smoking_note')}}</label>
									<input type="text" name="smoking_note" class="form-control" placeholder="smoking note" value="{{ old('smoking_note') }}">
								   </div>

									<div class="feat-row clearfix">
										<p>{{__('home.study_places')}}</p>
										<div class="switch-checkbox">
	                                       <label class="switch">
	                                          <input type="checkbox" name="features[]" value="2">
	                                          <div class="slider round clearfix">
	                                          	<span class="s-yes">{{__('home.yes')}}</span>
	                                          	<span class="s-no">{{__('home.no')}}</span>
	                                          </div>
	                                        </label>
	                                    </div>
									</div>
									<div class="feat-row clearfix">
										<p>{{__('home.meeting_rooms')}}</p>
										<div class="switch-checkbox">
	                                       <label class="switch">
	                                          <input type="checkbox"  name="features[]" value="3">
	                                          <div class="slider round clearfix">
	                                          	<span class="s-yes">{{__('home.yes')}}</span>
	                                          	<span class="s-no">{{__('home.no')}}</span>
	                                          </div>
	                                        </label>
	                                    </div>
									</div>
									<div class="feat-row clearfix">
										<p>{{__('home.discount_code')}}</p>
										<input type="text" name="discount_code" value="{{ old('discount_code') }}" class="form-control" placeholder="">
										<!-- <br><h3>or</h3> <br> -->
										<!-- <p>{{__('home.discount_code_qr')}}</p>
										<input type="text" name="discount_code_qr" value="{{ old('discount_code_qr') }}" class="form-control" placeholder=""> -->
										<!-- <br>
										<div class="col-xs-6">
											<label>{{__('home.cafe_logo')}}</label>
											<div class="upload--images-box">
	                                            <div class="up--image--file">
	                                                <input type="file" name="discount_code_image" id="up--file7">
	                                                <div class="drop">
		                                                <div class="cont">
													      <img src="{{ asset('frontend_assets/images/Upload Icon.svg')}}" alt="">
													      <div class="tit">
													      	{{__('home.drag')}}
													      </div>
													      <div class="desc">
													        or 
													      </div>
													      <div class="browse">
													        {{__('home.choose')}}
													      </div>
													    </div>
												    </div>
	                                            </div>
	                                            <div class="up--image--result">
	                                                <img src="" alt="" class="up-img-pic7">
	                                            </div>
	                                        </div>
										</div> -->
										<!-- <div class="discount-select">
											<select class="form-control chosen-select" name="discount_code">
												<option value="10%">10%</option>
												<option value="20%" >20%</option>
												<option value="30%" >30%</option>
												<option value="40%" >40%</option>
											</select>
										</div> -->
									</div>
									
								</div>
								<button type="submit" class="btn btn-st-submit">{{__('home.submit_your_cafe')}}</button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</section><!--section-innerPage-content-->
		@endsection

		@section('script')
		<script src="{{ asset('frontend_assets/js/moment.js')}}"></script>
	    <script src="{{ asset('frontend_assets/js/bootstrap-datetimepicker.min.js')}}"></script>
	    <script src="{{ asset('frontend_assets/js/select2/select2.min.js')}}" type="text/javascript"></script>
		<script type="text/javascript">
	    $(document).ready(function(){
	        $('.chosen-select').select2({
	        minimumResultsForSearch: Infinity
	    });
	    });
	    </script>
	    <script>
		$("#datetimepicker1").datetimepicker({
            format: "LT",
            icons: {
              up: "fa fa-chevron-up",
              down: "fa fa-chevron-down"
            }
        });
        $("#datetimepicker2").datetimepicker({
            format: "LT",
            icons: {
              up: "fa fa-chevron-up",
              down: "fa fa-chevron-down"
            }
        });
	    </script>

	    <script>
	     $(document).ready(function(){
        $("#smoking_note").show();
     });
	   $( "#smoking" ).click(function() {
 if(this.checked == true){
    $("#smoking_note").hide();
 }else{
    $("#smoking_note").show();
 }
})
   </script>

		@endsection
