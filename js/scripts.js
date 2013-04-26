jQuery(document).ready(function($) {

	// add theme name to all URLs in <a> tags
	$('#container a').each(function() {
		var url = $(this).attr('href');
		if(url && theme_branch != "") {
			if(url.indexOf('?') == -1) {
				url = url + "?theme="+theme_branch;
				$(this).attr('href', url);
			}
			else if(url.indexOf('&theme=') == -1) {
				url = url + "&theme="+theme_branch;
				$(this).attr('href', url);
			}
		}
	});
	
	
	// HANDLE DAILY TIPS
	$('.tip').first().addClass('selected');
	$('.next_tip').click(function() {
		var current_tip = $('.tip.selected');
		var next_tip = $('.tip.selected').next();
		if(!next_tip.hasClass('tip')) next_tip = $('.tip').first();
		current_tip.fadeOut(300);
		next_tip.delay(310).fadeIn(300);
		current_tip.removeClass('selected');
		next_tip.addClass('selected');
	});
	
	
	
		$('select#submission_type').change(function(){
		
		var selection = $('select#submission_type').val();
		var change = $('input#activity_submission');
		if(selection == 'video'){
			
			$('form #activity_video').show();
			$('form #activity_submission').hide();
		}
		else if(selection == 'file' || selection == 'image'){
		
			$('form #activity_video').hide();
			$('form #activity_submission').show();
			
		}
		
	});
	
	$('section.submission_nav').hover(function(){
						
				$(this).find('p').hide();
				$(this).find('form').show();
				if($(this).find('form').find('select').val() == 'video' ){

					$('.form-help').show();					
					
				}

			  },
			  function(){ //out
				$(this).find('p').show();
				$(this).find('form').hide();
			  }
	);
	
	$('form#journal_entry').submit(function(e){
		
		e.preventDefault();
		$('.submission').hide();
		$('form#journal_input').show();
		
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
	
	
	
	
	
    $('.edit_background, .cancel_background_info').click(function() {
    	$('.background').toggleClass('editing');
    	$('.background_admin input[type!="submit"]').each(function() {
	    	$(this).val($(this).attr('original_value'));
    	});
    });
    
    
    $('.delete_school').click(function() {
	    if(confirm('Are you sure you want to remove this school from your profile?')) {
	    	var this_button = $(this);
	    	this_button.slideUp();
		    this_button.next().slideUp().find('.remove_school').val('true');
	    }
    });
    
    
    $('.delete_company').click(function() {
	    if(confirm('Are you sure you want to remove this job from your profile?')) {
	    	var this_button = $(this);
	    	this_button.slideUp();
		    this_button.next().slideUp().find('.remove_company').val('true');
	    }
    });
	
	$(".edit_resume").change(function(){
        $(this).parent().submit();
    });
	
	
	//resources forum stuff
	$('#new_discussion').submit(function(e){
				
		var q=$('#question').val();
		var t=$('#title').val();
		var c=$('#category').val();

		if(t==''|| q=='' || c=='' ){
			alert("You must have a title, category and description!");
			e.preventDefault();
		}
		
		
	});
	
	$('#ask').click(function(){
		
		$('#form').slideToggle('slow');
		if($('#ask').html() == 'Ask a Question') $('#ask').html('Close');	
		else $('#ask').html('Ask a Question');	
			
		
		
	});
		
}); // jQuery




