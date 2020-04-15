(function($) {
 "use strict";
 
  // $(function() {
   // $('a[href*="#"]:not([href="#"])').click(function() {
   //   if (location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'') && location.hostname == this.hostname) {
    //    var target = $(this.hash);
    //    target = target.length ? target : $('[name=' + this.hash.slice(1) +']');
     //   if (target.length) {
       //   $('html, body').animate({
       //     scrollTop: target.offset().top
       //   }, 450);
      //    return false;
      //  }
    //  }
  //  });
 // });
 
var sidebarBox = document.querySelector('#box');
	var sidebarBtn = document.querySelector('#btn');
	var pageWrapper = document.querySelector('#main-content');
	
	sidebarBtn.addEventListener('click', function(event) {
	
			if (this.classList.contains('active')) {
					this.classList.remove('active');
					sidebarBox.classList.remove('active');
			} else {
					this.classList.add('active');
					sidebarBox.classList.add('active');
			}
	});
	
	//pageWrapper.addEventListener('click', function(event) {
	
			//if (sidebarBox.classList.contains('active')) {
					//sidebarBtn.classList.remove('active');
					//sidebarBox.classList.remove('active');
			//}
	//});
	
	window.addEventListener('keydown', function(event) {
	
			if (sidebarBox.classList.contains('active') && event.keyCode === 27) {
					sidebarBtn.classList.remove('active');
					sidebarBox.classList.remove('active');
			}
	});


  
})(jQuery);