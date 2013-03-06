jQuery(document).ready(function($) {


	// add theme name to all <a> tags
	$('#container a').each(function() {
		var url = $(this).attr('href');
		if(url && theme_branch) {
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




