@extends('frontend.layouts.master')
@section('content')
<section class="section-innerPage-content">
			<div class="container" >
				<div class="row">
				@if(session()->has('status'))
			    <div class="alert alert-success">
			        {{'updated successfully'}}
			    </div>
				@endif
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
				<form action="{{route('store_contract')}}" enctype="multipart/form-data" method="Post">
					{{csrf_field()}}
				<div class="col-md-6">
				<div class="upload--images-box">
                    <div class="up--image--file">
                       <input type="file" name="contract" id="up--file2">
                        <div class="drop">
                            <div class="cont">
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
                       		<button type="submit" class="view-btn">{{__('home.submit')}}</button>
						</div>	
				</form>			
					</div>			
				</div>
          </section>
	@endsection
	@section('script')
	<script type="text/javascript">
        var readURL5 = function(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('.up-img-pic2').attr('src', e.target.result);
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
        $("#up--file2").on('change', function(){
            readURL5(this);
        });
	</script>
	@endsection