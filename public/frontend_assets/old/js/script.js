$(document).ready(function(){
	var owl = $('#homeSlider');

        owl.on('initialized.owl.carousel change.owl.carousel',function(elem){
            var current = elem.item.index;
            $(elem.target).find(".owl-item").eq(current).find(".to-animate").removeClass('fadeInUp animated');
        });
       
        owl.on('initialized.owl.carousel changed.owl.carousel',function(elem){
            window.setTimeout(function(){
                var current = elem.item.index;
                $(elem.target).find(".owl-item").eq(current).find(".to-animate").addClass('fadeInUp animated');
            }, 400);
        });
	    owl.owlCarousel({
	            items: 1,
	            loop: true,
	            margin: 0,
	            responsiveClass: true,
	            nav: true,
	            dots: true,
	            smartSpeed: 500,
	            autoplay: true,
	            autoplayTimeout: 5000,
	            autoplayHoverPause: true,
	            navText:['<span><img src="http://localhost/coffee_spot/public/images/arrow-right.svg"></span>','<span><img src="http://localhost/coffee_spot/public/images/arrow-left.svg"></span>'],
	    });


	$("#rating-slide").owlCarousel({
 
            // Most important owl features
            loop:true,
            margin:15,
            responsiveClass:true,
            responsive:{
                0:{
                    items:1,
                },
                420:{
                    items:2,
                },
                767:{
                    items:3,
                }

            },
            dots:true,
            nav:true,
            navText:['<span><img src="http://localhost/coffee_spot/public/images/Arrow-r.svg"></span>','<span><img src="http://localhost/coffee_spot/public/images/Arrow-l.svg"></span>'],
            autoplay:false
         

        })

        $(".offers-slide").owlCarousel({
 
            // Most important owl features
            loop:true,
            margin:20,
            responsiveClass:true,
            responsive:{
                0:{
                    items:1,
                },
                767:{
                    items:2,
                }

            },
            dots:true,
            nav:true,
            navText:['<span><img src="http://localhost/coffee_spot/public/images/Arrow-r.svg"></span>','<span><img src="http://localhost/coffee_spot/public/images/Arrow-l.svg"></span>'],
            autoplay:false
         

        }) 
        
        

         /*open menu*/
        $(".hamburger").click(function(){
            var thisclick = $('.hamburger')
            if(thisclick.hasClass('active') != true){
            thisclick.addClass('active');
            $("body,html").addClass('menu-toggle');
            }
            else{
                 thisclick.removeClass('active');
                 $("body,html").removeClass('menu-toggle');
            }

        });


         $('a[href="#search"]').on('click', function(event) {
        event.preventDefault();
            $('#search').addClass('open');
            $('#main-wrapper').addClass('wrapper-blur');
            setTimeout(function(){
                $('#search form > input[type="text"]').focus();
            },100);
        });
    
        $('#search, #search button.close').on('click keyup', function(event) {
            if (event.target == this || event.target.className == 'close' || event.keyCode == 27) {
                $(this).removeClass('open');
                $('#main-wrapper').removeClass('wrapper-blur');
            }
        });

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



         /*upload image*/
        var readURL2 = function(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('.up-img-pic').attr('src', e.target.result);
                }
        
                reader.readAsDataURL(input.files[0]);
            }
        }
        

        $("#up--file").on('change', function(){
            readURL2(this);
        });

         /*upload image*/
        var readURL1 = function(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('.up-img-pic1').attr('src', e.target.result);
                }
        
                reader.readAsDataURL(input.files[0]);
            }
        }
        

        $("#up--file1").on('change', function(){
            readURL1(this);
        });

         /*upload image*/
        var readURL2 = function(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('.up-img-pic2').attr('src', e.target.result);
                }
        
                reader.readAsDataURL(input.files[0]);
            }
        }
        

        $("#up--file2").on('change', function(){
            readURL2(this);
        });

         /*upload image*/
        var readURL3 = function(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('.up-img-pic3').attr('src', e.target.result);
                }
        
                reader.readAsDataURL(input.files[0]);
            }
        }
        

        $("#up--file3").on('change', function(){
            readURL3(this);
        });
         /*upload image*/
        var readURL4 = function(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('.up-img-pic4').attr('src', e.target.result);
                }
        
                reader.readAsDataURL(input.files[0]);
            }
        }
        

        $("#up--file4").on('change', function(){
            readURL4(this);
        });
})



