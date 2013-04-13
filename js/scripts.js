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
    
    
    $('.edit_background').click(function() {
	   $('.background').toggleClass('editing');
    });
	
		
}); // jQuery




