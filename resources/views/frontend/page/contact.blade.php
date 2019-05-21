@extends('frontend.layouts.master')
@section('content')
<section class="top-innerPage-box">
			<div class="container">
				<div class="top-iP-left">
					<h2>{{__('home.contact_us')}}</h2>
					<p></p>
				</div>
			</div>
		</section>
		<section class="section-innerPage-content">
			<div class="container">
				<div class="contact-whiteBox">
					<div class="row">
						<div class="col-sm-6">
							<div class="contact-info-box">
								<h2 class="con-tit">{{__('home.information')}}</h2>
								<!-- <div class="cInfo-row clearfix">
									<div class="cInfo-icon">
										<img src="{{ asset('frontend_assets/images/Icon-com.svg')}}" alt="">
									</div>
									<div class="cInfo-txt">
										<h3>{{__('home.office_address')}}</h3>
										<p>{!!$office_address->value !!}</p>
									</div>
								</div> -->
								<div class="cInfo-row clearfix">
									<div class="cInfo-icon">
										<img src="{{ asset('frontend_assets/images/Icon-em.svg')}}" alt="">
									</div>
									<div class="cInfo-txt">
										<h3>{{__('home.email_address')}}</h3>
										{!!$email_address->value !!}
									</div>
								</div>
								<div class="cInfo-row clearfix">
									<div class="cInfo-icon">
										<img src="{{ asset('frontend_assets/images/Icon-pho.svg')}}" alt="">
									</div>
									<div class="cInfo-txt">
										<h3>{{__('home.contact_information')}}</h3>
										{!! $contact_information->value !!}
									</div>
								</div>
							</div>
						</div>
						<div class="col-sm-6">
							<div class="contact-form-box">
								<h2 class="con-tit">{{__('home.information')}}</h2>
								<form class="form-style1 clearfix" method="POST" id="contact-form" action="{{ route('save_contact') }}">
									{{ csrf_field() }}
									<div id="success_msg"></div>
									<div id="error_msg"></div>
									<div class="form-group">
										<label>{{__('home.name')}}</label>
										<input type="text" class="form-control" name="name" placeholder="Your name">
									    <span id="name_msg"></span>
									</div>
									<div class="form-group">
										<label>{{__('home.email')}}</label>
										<input type="email" class="form-control" name="email" placeholder="Email address">
										<span id="email_msg"></span>
									</div>
									<div class="form-group">
										<label>{{__('home.mobile')}}</label>
										<input type="text" class="form-control" name="mobile" placeholder="0599000000">
										<span id="mobile_msg"></span>
									</div>
									<div class="form-group">
										<label>{{__('home.message')}}</label>
										<textarea class="form-control" name="message" placeholder="Type your Message"></textarea>
									    <span id="message_msg"></span>
									</div>
									<button type="submit" id="send_contact" class="btn btn-st-submit">{{__('home.submit')}}</button>
								</form>
							</div>
						</div>
						
					</div>
				</div>
			</div>
		</section><!--section-innerPage-content-->

		@endsection

	    @section('script')
		 <script>
        $("#contact-form").submit(function (e) {
         var ss;
        e.preventDefault();
        $action = $(this).attr("action");
        $data = $(this).serialize();
        $.ajax({
            url: $action,
            type: "POST",
            data: $data,
            dataType: "json",
            success: function (response) {
            if (response.status == true) {
               document.getElementById("success_msg").innerHTML = '<div style="text-align: center;background-color: #4CAF50;font-size: 20px;color: #fff;">'+response.msg+'</div>';          
              $("#email_msg").html('');
              $("#name_msg").html(''); 
              $("#mobile_msg").html(''); 
              $("#message_msg").html('');
            } else {        
                document.getElementById("error_msg").innerHTML = response.error;
            }
             },error: function(data){
                    var error = data.responseJSON;
                    var errors= error.errors;
                    if(typeof(errors['email']) != "undefined"){
                    	$("#email_msg").html(errors['email'][0]);
                    }
                    if(typeof(errors['name']) != "undefined"){
                    	$("#name_msg").html(errors['name'][0]);
                    }
                    if(typeof(errors['mobile']) != "undefined"){
                    	 $("#mobile_msg").html(errors['mobile'][0]);
                    }
                     if(typeof(errors['message']) != "undefined"){
                    	$("#message_msg").html(errors['message'][0]);
                    }   
                }
        });

    });
    </script>
		@endsection

		    