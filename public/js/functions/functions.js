(function ($) {
    "use strict";
    $(document).ready(function () {
        /*scroll to top*/
        $(window).scroll(function () {
            if ($(this).scrollTop() > 100) {
                $('.scrollup').fadeIn();
            } else {
                $('.scrollup').fadeOut();
            }
        });

        $('.scrollup').on("click", function () {
            $("html, body").animate({
                scrollTop: 0
            }, 500);
            return false;

        });
    });
})(jQuery);


//		$('.parallax-1').parallax("50%", 0.1);
//	$('.parallax-2').parallax("50%", 0.1);
//	$('.parallax-3').parallax("50%", 0.4);
//	$('.parallax-4').parallax("50%", 0.3);
//	$('.parallax-5').parallax("50%", 0.1);
//	$('.parallax-6').parallax("50%", 0.1);
//	$('.parallax-7').parallax("50%", 0.4);
//	$('.parallax-8').parallax("50%", 0.3);
//	$('.parallax-9').parallax("50%", 0.1);
//	$('.parallax-10').parallax("50%", 0.1);
//	$('.parallax-11').parallax("50%", 0.4);
//	$('.parallax-12').parallax("50%", 0.3);
//	$('.parallax-13').parallax("50%", 0.1);
//	$('.parallax-14').parallax("50%", 0.1);
//	$('.parallax-15').parallax("50%", 0.4);
//	$('.parallax-16').parallax("50%", 0.3);
//	$('.parallax-17').parallax("50%", 0.1);
//	$('.parallax-18').parallax("50%", 0.1);
//	$('.parallax-19').parallax("50%", 0.4);
//	$('.parallax-20').parallax("50%", 0.3);
//	$('.parallax-21').parallax("50%", 0.1);
//	$('.parallax-22').parallax("50%", 0.1);
//	$('.parallax-23').parallax("50%", 0.4);
//	$('.parallax-24').parallax("50%", 0.3);
//	$('.parallax-25').parallax("50%", 0.1);
//	$('.parallax-26').parallax("50%", 0.1);
//	$('.parallax-27').parallax("50%", 0.4);
//	$('.parallax-28').parallax("50%", 0.3);
//	$('.parallax-29').parallax("50%", 0.1);
//	$('.parallax-30').parallax("50%", 0.1);
//	$('.parallax-31').parallax("50%", 0.4);
//	$('.parallax-32').parallax("50%", 0.3);
//	$('.parallax-33').parallax("50%", 0.1);
//	$('.parallax-34').parallax("50%", 0.1);
//	$('.parallax-35').parallax("50%", 0.4);
//	$('.parallax-36').parallax("50%", 0.3);
//	$('.parallax-37').parallax("50%", 0.1);
//	$('.parallax-38').parallax("50%", 0.1);
//	$('.parallax-39').parallax("50%", 0.4);
//	$('.parallax-40').parallax("50%", 0.3);
//	$('.parallax-41').parallax("50%", 0.1);
//	$('.parallax-42').parallax("50%", 0.1);
//	$('.parallax-43').parallax("50%", 0.4);
//	$('.parallax-44').parallax("50%", 0.3);
//	$('.parallax-45').parallax("50%", 0.1);
//	$('.parallax-46').parallax("50%", 0.1);
//	$('.parallax-47').parallax("50%", 0.4);
//	$('.parallax-48').parallax("50%", 0.3);
//	$('.parallax-49').parallax("50%", 0.1);
//	$('.parallax-50').parallax("50%", 0.1);
//	$('.parallax-51').parallax("50%", 0.3);
//	$('.parallax-52').parallax("50%", 0.1);
//	$('.parallax-53').parallax("50%", 0.1);
//	$('.parallax-54').parallax("50%", 0.4);
//	$('.parallax-55').parallax("50%", 0.3);
//	$('.parallax-56').parallax("50%", 0.1);
//	$('.parallax-57').parallax("50%", 0.1);
//	$('.parallax-58').parallax("50%", 0.4);
//	$('.parallax-59').parallax("50%", 0.3);
//	$('.parallax-60').parallax("50%", 0.1);
//	$('.parallax-61').parallax("50%", 0.1);
//	$('.parallax-62').parallax("50%", 0.3);
//	$('.parallax-63').parallax("50%", 0.1);
//	$('.parallax-64').parallax("50%", 0.1);
//	$('.parallax-65').parallax("50%", 0.4);
//	$('.parallax-66').parallax("50%", 0.3);
//	$('.parallax-67').parallax("50%", 0.1);
//	$('.parallax-68').parallax("50%", 0.1);
//	$('.parallax-69').parallax("50%", 0.4);
//	$('.parallax-70').parallax("50%", 0.3);
//	$('.parallax-71').parallax("50%", 0.1);
//	$('.parallax-72').parallax("50%", 0.1);
