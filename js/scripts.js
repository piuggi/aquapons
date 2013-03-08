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
		$('.category_descriptions').animate({left: '0px'});
	});
	
	
	$('.close_category_descriptions').click(function() {
		$('.category_descriptions').animate({left: '-220px'});
	});
	
		
}); // jQuery




