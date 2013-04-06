//Uber hack for jQuery Cycle to get it to respond to the height of each image. 
//Must run through window.load in order to make sure that it fixes the divs when all content is loaded 


jQuery(window).load(function($){

	var h = jQuery('#first').children('img').height(); //get height of first element to apply
	//console.log("Height: "+ h);	
	
	jQuery('#mantle').cycle({
	
	  after: function(el, next_el) {
	        jQuery(next_el).addClass('active'); //add active class
	        
	        var $ht = jQuery(this).children('img').height(); //get height
	        jQuery(this).parent().height($ht);
	        jQuery(this).height($ht);
	        //console.log('After: '+$ht);
	  },
	  before: function(el) {
	        jQuery(el).removeClass('active'); //remove active class
	  },
	  timeout: 4000,
	  speed: 500,
	  height: h,
	  containerResize: 0,
	  slideResize: false
	});


	
});

jQuery(document).ready(function($){
	// a little buggy still needs some work
	$(window).resize(function() {
	  //console.log('Handler for .resize() called.');
	  var h = $('#first').children('img').height();
	  $('#mantle').height(h);
	  $('.showcase').height(h);
	  
	});

	
	
});