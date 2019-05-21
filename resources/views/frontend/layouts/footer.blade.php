</div><!--main-wrapper-->
<footer id="footer">
			<div class="container">
				<div class="f-right">
					<ul class="f-social clearfix">
						<li>
							<a href="
							@if (strpos($facebook->value, 'http') !== false)
							{{$facebook->value}}
							@else
							http://{{$facebook->value}}
							@endif
							" target="_blank"><i class="fa fa-facebook" aria-hidden="true"></i></a>
						</li>
						<li>
							<a href="
							@if (strpos($twitter->value, 'http') !== false)
							{{$twitter->value}}
							@else
							http://{{$twitter->value}}
							@endif
							" target="_blank"><i class="fa fa-twitter" aria-hidden="true"></i></a>
						</li>
						<li>
							<a href="
							@if (strpos($instagram->value, 'http') !== false)
							{{$instagram->value}}
							@else
							http://{{$instagram->value}}
							@endif" target="_blank"><i class="fa fa-instagram" aria-hidden="true"></i></a>
						</li>
					</ul>
					<ul class="paylist clearfix">
						<li>
							<a href="#"><img src="{{ asset('frontend_assets//images/Visa-Icon.svg')}}" alt=""></a>
						</li>
						<li>
							<a href="#"><img src="{{ asset('frontend_assets//images/Knet-Icon.svg')}}" alt=""></a>
						</li>
					</ul>
				</div>
				<div class="f-left">
					<ul class="f-menu clearfix">
						<li><a href="{{route('terms')}}">{{__('home.terms_and_condition')}}</a></li>
						<li><a href="{{route('contact')}}">{{__('home.contact_details')}}</a></li>
						<li><a href="{{route('privacy')}}">{{__('home.privacy_policy')}}</a></li>
					</ul>
					<p class="copy-right">
						© 2017 Coffe Spott. All rights reserved.
					</p>
				</div>
			</div>
		</footer><!--footer-->
	 
	<script src="{{ asset('frontend_assets/js/bootstrap.min.js')}}"></script>
	<script src="{{ asset('frontend_assets/js/owl.carousel.min.js')}}" type="text/javascript"></script>
	<script src="{{ asset('frontend_assets/js/script.js')}}"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.2.5/jquery.fancybox.min.js"></script>

</body>
</html>	