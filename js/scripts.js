jQuery(document).ready(function($) {


	// add theme name to all URLs
	$('#container a').each(function() {
		var url = $(this).attr('href');
		if(window.console) console.debug(url);
		if(url) {
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
	
	
		
}); // jQuery




