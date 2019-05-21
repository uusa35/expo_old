@extends('frontend.layouts.master')

@section('page_css')
    <link href="{{ asset('frontend_assets/css/jquery.fancybox.css')}}" rel="stylesheet" type="text/css" />

@endsection

@section('content')

<section class="top-innerPage-box">

			<div class="container">

				<div class="top-iP-left">

					<h2>{{__('home.contract')}}</h2>

					<p></p>

				</div>

			</div>

		</section>

		<section class="section-innerPage-content">

			<div class="container">

				<div class="contract-whiteBox">

					<div class="row">

						<div class="col-md-6 col-sm-7">

							<div class="contract-block">

								{!!$contract->value!!}

							</div>

							

						</div>

						<div class="col-md-offset-2 col-md-4 col-sm-offset-1 col-sm-4">

							<a href="{{route('contract_template')}}" class="contract-btn fancybox fancybox.iframe">Contract</a>

							<a href="{{route('resubmit')}}" class="contract-btn">Resubmit Contract</a>

						</div>

					</div>

				</div>

			</div>

		</section><!--section-innerPage-content-->

		@endsection

		@section('script')
		<script>
       $(".fancybox").fancybox({
          openEffect  : 'none',
          closeEffect : 'none',
      });
      
      $(".various").fancybox({
        maxWidth    : 800,
        maxHeight   : 600,
        fitToView   : false,
        width       : '70%',
        height      : '70%',
        autoSize    : false,
        closeClick  : false,
        openEffect  : 'none',
        closeEffect : 'none'
      });
	   </script>
	   <script src="{{ asset('frontend_assets/js/jquery.fancybox.pack.js')}}"></script>

		@endsection