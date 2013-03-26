jQuery(document).ready(function($) {

	// add theme name to all URLs in <a> tags
	$('#container a').each(function() {
		var url = $(this).attr('href');
		if(url && theme_branch != "") {
			if(url.indexOf('?') == -1) {
				url = url + "?theme="+theme_branch;
				$(this).attr('href', url);
			}
			else {
				url = url + "&theme="+theme_branch;
				$(this).attr('href', url);
			}
		}
	});
	
	
	
	$('.show_category_descriptions').click(function() {
		$('.category_descriptions_mask').fadeIn(200);
		$('.category_descriptions').animate({left: '0px'}, 200);
        if($(document).scrollTop() > 222) {
	        $('.close_category_descriptions').css('position', 'fixed');
        } else {
	        $('.close_category_descriptions').css('position', 'absolute');
        }
	});
	
	
	$('.close_category_descriptions, .category_descriptions_mask').click(function() {
		$('.category_descriptions_mask').fadeOut(200);
		$('.category_descriptions').animate({left: '-345px'}, 200);
	});
	
	$(document).on("mousewheel", function() {
        if($(document).scrollTop() > 222) {
	        $('.close_category_descriptions').css('position', 'fixed');
        } else {
	        $('.close_category_descriptions').css('position', 'absolute');
        }
    });
	
		
}); // jQuery




