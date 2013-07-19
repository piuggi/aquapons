

jQuery(document).ready(function($) {


	
	//get all our data for the user
	$('.single-activity article.question section.qright h3 a').click(function(e){
		e.preventDefault();
		
		var $question = $(this).parent().parent().parent();
		
		var currentClass = $(this).attr('class');
		
		console.log($question);
		
		if(!$question.hasClass('more')){
			$question.addClass('more');		
			
			//make getJSON or ajax call to populate data
			
			var postID = $(this).attr('data-id');
			var theme = $(this).attr('data-theme');
			var user = $(this).attr('data-user');
			
			$.ajax({url:"/wp-content/themes/"+theme+"/php/get-discussion.php?theme="+theme, 
						type: "POST", 
						dataType: "html", 
						data: "id="+postID+"&class="+currentClass+"&user="+user+"&theme="+theme
						}).done(function(data){ 
				
				//console.log("ajax got: "+data);
	
				$question.append(data);
				
			});
		
		}else{
			
			alert('Already Showing Results for question: '+$(this).html());
			
		}
		
	});
	
	//clean up when the user closes
	$('p.close').live("click",function(){
		var $responses = $(this).parent();
		
		var $question = $(this).parent().parent();
		$question.removeClass('more');
		$responses.children().remove();
		$responses.remove();
		
		
	});
	
	
	function vote(vote, theme, postID, ID, $this){

		$.ajax({url:"/wp-content/themes/"+theme+"/php/update-discussion.php?theme="+theme, 
				type: "POST",
				data: "id="+ID+"&vote="+vote+"&post="+postID
		}).done(function(data){
				var current = $this.siblings('.current').html();
				var currInt = parseInt(current,10);
				currInt+=vote; 
				$this.siblings('.current').html(currInt);
		});
	
	}
	
	
	$('.up').live('click', function(){
		var ID = $(this).attr('data-id');
		var userID = $(this).attr('data-user');
		var postID = $(this).attr('data-post');
		var theme = $(this).attr('data-theme');
		
		var $this = $(this);
		
		if(userID != 0){
			
			vote(1, theme, postID, ID, $this);
			
		}else{
			alert('You must log in to vote');
			
		}
		
	});
	
	$('.down').live('click', function(){
		var ID = $(this).attr('data-id');
		var userID = $(this).attr('data-user');
		var postID = $(this).attr('data-post');
		var theme = $(this).attr('data-theme');
		
		var $this = $(this);
		
		if(userID != 0){
			
			vote(-1, theme, postID, ID, $this);
			
		}else{
			alert('You must log in to vote');
			
		}
		
	});
	
	
	$('.flag').live('click',function(){
		var ID = $(this).attr('data-id');
		var userID = $(this).attr('data-user');
		var postID = $(this).attr('data-post');
		var theme = $(this).attr('data-theme');
		
		var $this = $(this);
		var $answer = $this.parent().parent();
		
		//console.log($answer);
				
		if(userID != 0){

		$.ajax({url:"/wp-content/themes/"+theme+"/php/update-discussion.php?theme="+theme, 
				type: "POST",
				dataType: "json", 
				data: "id="+ID+"&flag=1&post="+postID
		}).done(function(data){
				console.log(data);
				console.log(data.result);
				console.log(data["result"]);
				
				if(data.result == 'flagged')
					$this.parent().parent().remove();
				
				alert("Thanks for reporting");
			
				
		});
				
		
		}else{
		
			alert('You must log in to flag content!');	
			
		}
		
	});
	
	$('.comment').live('click',function(){
		var ID = $(this).attr('data-id');
		var userID = $(this).attr('data-user');
		var postID = $(this).attr('data-post');
		var theme = $(this).attr('data-theme');
		
		var $answer = $(this).parent().parent();
		
		if(userID != 0){
		
		
			var form = "<hr><form  method='post' accept-charset='utf-8' class='comment'>";
			form+= "<textarea name='comment' placeholder='Share your expertise...' ></textarea>";
			form+= "<input type='hidden' name='comment-id' value='"+ID+"'>";
			form+= "<input type='hidden' name='user-id' value='"+userID+"'>";
			form+= "<input type='hidden' name='post-id' value='"+postID+"'>";
			form+= "<input type='hidden' name='theme' value='"+theme+"'>"
			form+= "<input type='submit' value='post'>";
			form+= "</form>";
			$answer.append(form);
			
		}else{
		
			alert('You must log in to comment!');	
			
		}
		
		
	});
	
	$('form.comment').live('submit',function(e){
		
		e.preventDefault();
		
		var $this = $(this);
		var $answer = $(this).parent();
		
		var ID = $this.find("[name='comment-id']").val();
		var userID = $this.find("[name='user-id']").val();
		var postID = $this.find("[name='post-id']").val();
		var theme = $this.find("[name='theme']").val();
		var comment = $this.find("[name='comment']").val();

		$.ajax({url:"/wp-content/themes/"+theme+"/php/update-discussion.php?theme="+theme, 
				type: "POST",
				dataType: "html", 
				data: "comment="+comment+"&id="+ID+"&user="+userID+"&post="+postID
		}).done(function(data){
				console.log(data);
				//console.log(data.result);
				//console.log(data["result"]);
				$this.remove();
				$answer.find('hr').remove();
				$answer.append(data);
				
		});

		
	});
	
	$('button.edit').click( function(){
		//$(this).html('Submit');
		$(this).parent().find('p').hide();
		$(this).parent().find('form.edit').show().append('<button type="submit" name="update">Submit</button>');;
		$(this).hide();
		
	});
	
	$('.reviewing form, .reviewing button').remove();
	
	
});