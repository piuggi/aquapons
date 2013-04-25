jQuery(document).ready(function($){
	
	
	$('.up').click(function(){
		
		var ID = $(this).attr('data-id');
		var userID = $(this).attr('data-user');
		
		if(userID != 0){
			
		$('<input>').attr({
		    type: 'hidden',
		    name: 'vote',
		    value: '1',
		}).appendTo('form#page_actions');
		
		$('<input>').attr({
		    type: 'hidden',
		    name: 'comment-id',
		    value: ID,
		}).appendTo('form#page_actions');
		
		$('form#page_actions').submit();
				
		
		}else{
		
			alert('You must log in to vote!');	
			
		}
				
	});
	
	$('.down').click(function(){
		
		var ID = $(this).attr('data-id');
		var userID = $(this).attr('data-user');
		
		if(userID != 0){
			
		$('<input>').attr({
		    type: 'hidden',
		    name: 'vote',
		    value: '-1',
		}).appendTo('form#page_actions');
		
		$('<input>').attr({
		    type: 'hidden',
		    name: 'comment-id',
		    value: ID,
		}).appendTo('form#page_actions');
		
		$('form#page_actions').submit();
				
		
		}else{
		
			alert('You must log in to vote!');	
			
		}
				
	});

	$('.flag').click(function(){
		
		var ID = $(this).attr('data-id');
		var userID = $(this).attr('data-user');
		
		if(userID != 0){
			
		$('<input>').attr({
		    type: 'hidden',
		    name: 'flag',
		    value: '1',
		}).appendTo('form#page_actions');
		
		$('<input>').attr({
		    type: 'hidden',
		    name: 'comment-id',
		    value: ID,
		}).appendTo('form#page_actions');
		
		$('form#page_actions').submit();
				
		
		}else{
		
			alert('You must log in to vote!');	
			
		}
		
	});
	
	$('.comment').click(function(){
		
		var ID = $(this).attr('data-id');
		var userID = $(this).attr('data-user');		
		
		var $answer = $(this).parent().parent();
		if(userID != 0){
			
			var action = $('form#page_actions').attr('action');
			
			var form = "<hr><form action='"+action+"' method='post' accept-charset='utf-8' class='comment'>";
				form+= "<textarea name='comment' placeholder='Share your expertise...' ></textarea>";
				form+= "<input type='hidden' name='comment-id' value='"+ID+"'>";
				form+= "<input type='submit' value='post'>";
				form+= "</form>";
			
			$answer.append(form);
			
		}else{
			
			alert('You must log in to comment!');
			
		}
		
		
		
		
	});
	
	
});