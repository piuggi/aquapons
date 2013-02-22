

jQuery(document).ready(function($) {


	$('.reject_badge').click(function() {
		var badge_div = $(this).prev();
		
		
		jQuery.ajax({
			type: 'POST',
			url: 'http://aquapons.info/wp-admin/admin-ajax.php',
			data: {
				action: 'reviewBadgeAjax',
				badge_denied: true,
				submission_id: badge_div.attr('submission_id'),
				reviewer_id: badge_div.attr('reviewer_id'),
				reviewer_comment: $('.approval_comments').val(),
				theme: theme_branch
			},
			success: function(data, textStatus, XMLHttpRequest){
				if(window.console) console.debug(data);
			},
			error: function(XMLHttpRequest, textStatus, errorThrown){
				console.log(errorThrown);
			}
		});

		
		
		
		
		
	});
	

	$('.approve_badge').click(function() {
		var badge_div = $(this);
		var assertion_url;
		if(window.console) console.debug('.approve_badge');
		jQuery.ajax({
			type: 'POST',
			url: 'http://aquapons.info/wp-admin/admin-ajax.php',
			data: {
				action: 'reviewBadgeAjax',
				badge_approved: true,
				submission_id: badge_div.attr('submission_id'),
				json_dir: theme_dir + "/../json/",
				badge_id: badge_div.attr('badge_id'),
				activity_id: badge_div.attr('activity_id'),
				recipient: badge_div.attr('user_id'),
				salt: badge_div.attr(''),
				user_token: badge_div.attr('user_token'),
				evidence: badge_div.attr('evidence'),
				version: badge_div.attr('version'),
				name: badge_div.attr('badgename'),
				image: badge_div.attr('badgeimage'),
				description: badge_div.attr('description'),
				criteria: badge_div.attr('criteria'),
				expires: badge_div.attr('expires'),
				reviewer_id: badge_div.attr('reviewer_id'),
				reviewer_comment: $('.approval_comments').val(),
				theme: theme_branch
			},
			success: function(data, textStatus, XMLHttpRequest){
				console.debug(data);
			},
			error: function(XMLHttpRequest, textStatus, errorThrown){
				console.log(errorThrown);
			}
		});
	}); // $('.approve_badge').click
	
	
	
	$('.send_to_backpack').click(function() {
		
		// CHECK TO VERIFY BADGE HAS BEEN EARNED BEFORE SUBMITTING AND GET ASSERTION URL
		var assertion_url;
		
		jQuery.ajax({
			type: 'POST',
			url: 'http://aquapons.info/wp-admin/admin-ajax.php',
			data: {
				action: 'reviewBadgeAjax',
				get_assertion_url: true,
				badge_id: $(this).attr('badge_id'),
				user_id: $(this).attr('user_id')
			},
			success: function(data, textStatus, XMLHttpRequest){
				if(window.console) console.debug(data);
				
				assertion_url = data.substring(0, data.length - 1);
				console.log(assertion_url);
				if(data.substring(0, 4) == 'http') sendToBackpack(assertion_url);
			},
			error: function(XMLHttpRequest, textStatus, errorThrown){
				console.log(errorThrown);
			}
		});
	
	
	})
	
		
}); // jQuery







function sendToBackpack(assertion_url) {


	OpenBadges.issue(['' + assertion_url + ''], function(errors, successes) {

	if (errors.length > 0) {
		console.log(errors);
	}
	if (successes.length > 0) {
		// set submitted_to_obi in badge_submissions to 1
		console.log('obi success');
/*
		jQuery.ajax({
			type: 'POST',
			url: 'http://aquapons.info/wp-admin/admin-ajax.php',
			data: {
				action: 'submittedToOBI',
				submission_id: badge_div.attr('submission_id')
			},
			success: function(data, textStatus, XMLHttpRequest){
				if(window.console) console.debug(data);
			},
			error: function(XMLHttpRequest, textStatus, errorThrown){
				console.log(errorThrown);
			}
		});	
*/
	}
}); //OpenBadges.issue
	
}