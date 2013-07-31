

jQuery(document).ready(function($) {


	$('.reject_badge').click(function() {
		var badge_div = $(this).prev();
		var deny_button = $(this);
		badge_div.attr('value', 'Approve');
		deny_button.attr('value', 'Saving...');
		
		
		jQuery.ajax({
			type: 'POST',
			url: 'http://aquapons.info/wp-admin/admin-ajax.php',
			data: {
				action: 'reviewBadgeAjax',
				badge_denied: true,
				user_token: badge_div.attr('user_token'),
				submission_id: badge_div.attr('submission_id'),
				reviewer_id: badge_div.attr('reviewer_id'),
				reviewer_comment: badge_div.parent().find('.approval_comments').val(),
				theme: theme_branch
			},
			success: function(data, textStatus, XMLHttpRequest){
				if(window.console) console.debug(data);
				deny_button.attr('value', 'Reject');
				deny_button.parent().parent().find('.current_status').html('denied').removeClass('approved').addClass('denied');
			},
			error: function(XMLHttpRequest, textStatus, errorThrown){
				console.log(errorThrown);
				alert("There was an error with your request. Please refresh the page and try again.");
			}
		});

		
		
		
		
		
	});
	

	$('.approve_badge').click(function() {
		var badge_div = $(this);
		badge_div.attr('value', 'Saving...');
		badge_div.next().attr('value', 'Reject');
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
				reviewer_comment: badge_div.parent().find('.approval_comments').val(),
				theme: theme_branch
			},
			success: function(data, textStatus, XMLHttpRequest){
				console.debug(data);
				badge_div.attr('value', 'Approve');
				badge_div.parent().parent().find('.current_status').html('approved').addClass('approved').removeClass('denied');
			},
			error: function(XMLHttpRequest, textStatus, errorThrown){
				console.log(errorThrown);
				alert("There was an error with your request. Please refresh the page and try again.");
			}
		});
	}); // $('.approve_badge').click
	
	
	
	$('.send_to_backpack').click(function() {
		backpack_button = $(this);
		var this_badge_id = $(this).data('badge-id');
		// CHECK TO VERIFY BADGE HAS BEEN EARNED BEFORE SUBMITTING AND GET ASSERTION URL
		var assertion_url;
		
		jQuery.ajax({
			type: 'POST',
			url: 'http://aquapons.info/wp-admin/admin-ajax.php',
			data: {
				action: 'reviewBadgeAjax',
				get_assertion_url: true,
				badge_id: this_badge_id,
				/* user_id: $(this).data('user-id'), */
				theme: theme_branch
			},
			success: function(data, textStatus, XMLHttpRequest){				
				assertion_url = data.substring(0, data.length - 1);
				console.log(assertion_url);
				if(data.substring(0, 4) == 'http') sendToBackpack(assertion_url, this_badge_id, backpack_button);
			},
			error: function(XMLHttpRequest, textStatus, errorThrown){
				console.log(errorThrown);
				alert("There was an error with your request. Please refresh the page and try again.");
			}
		});
	
	
	});
	
		
}); // jQuery







function sendToBackpack(assertion_url, current_badge_id, backpack_button) {
	console.log(current_badge_id);


	OpenBadges.issue(['' + assertion_url + ''], function(errors, successes) {

		if (errors.length > 0) {
			console.log(errors);
		}
		if (successes.length > 0) {
			// MARK AS SUBMITTED TO OBI
			jQuery.ajax({
			type: 'POST',
			url: 'http://aquapons.info/wp-admin/admin-ajax.php',
			data: {
				action: 'submittedToOBI',
				badge_id: current_badge_id,
				/* user_id: $(this).data('user-id'), */
				theme: theme_branch
			},
			success: function(data, textStatus, XMLHttpRequest){				
				if(window.console) console.debug(data);
				backpack_button.find('span').html('sent!');
			},
			error: function(XMLHttpRequest, textStatus, errorThrown){
				console.log(errorThrown);
			}
		});
			
			
			
			/*
jQuery.ajax({
				type: 'POST',
				url: 'http://aquapons.info/wp-admin/admin-ajax.php',
				data: {
					action: 'submittedToOBI',
					badge_id: current_badge_id
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