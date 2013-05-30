<?php	$resource_type = get_post_meta($post->ID, 'resource_type', true);?>

<section class="main-col">
		<h2><?php echo get_post_meta(get_the_ID(), 'answers', true); if(!$resource_type): echo ' Answers'; else: echo ' Comments'; endif; ?> </h2>
		
		
		<?php
		$post_id = get_the_ID();
		$user = wp_get_current_user();
		 //query for added comments 
			global $wpdb;
			$query = "SELECT * FROM aq_discussion_comments WHERE comment_discussion = '$post_id' AND comment_status = 'publish' AND comment_is_child = '0' ORDER BY comment_rank DESC";
			if($comments = $wpdb->get_results($query)){
			
			foreach($comments as $comment){ /*print_r($comment);*/ ?>
				
				
			<section class="answer">
				<ul class="rank">
					<li data-id="<?php echo $comment->ID; ?>" data-user="<?php echo $user->ID; ?>" class="up"></li>
					<li class="current"><?php echo $comment->comment_rank; ?></li>
					<li data-id="<?php echo $comment->ID; ?>" data-user="<?php echo $user->ID; ?>" class="down"></li>
				</ul>
				<article class="desc">
					<p> <?php echo $comment->comment_content; ?></p>
				</article>
				<figure>
				<?php 
					$commenter_id = $comment->comment_author;
					  if(userphoto_exists( $commenter_id )) userphoto_thumbnail( $commenter_id ); 
					  else echo get_avatar( get_the_author_meta('user_email', $commenter_id) , 100);//defaults to blank gravatar can substitute if we want 		
				?>
				</figure>
				<section class="user_data">
					<p class="author">Posted <?php echo time_ago_comment( $comment->comment_date ); ?> by </p>
					<?php $user_info = get_userdata($commenter_id);?>
					<br/>
					<p> <a class="<?php print_aquapon_cat(); ?>" href=""><?php echo $user_info-> display_name; ?></a>, <strong><?php $user_role = $user_info->roles; echo ucwords(str_replace("_", " ", $user_role[0])); ?></strong></p>
				</section>
				<ul>
					<li data-id="<?php echo $comment->ID; ?>" data-user="<?php echo $user->ID; ?>" class="comment">
						<img title="Comment on this post" src="<?php echo get_bloginfo('stylesheet_directory'); ?>/imgs/discussion_comment.png"/>
					</li>
					<li data-id="<?php echo $comment->ID; ?>" data-user="<?php echo $user->ID; ?>" class="flag">
						<img title="Flag this post" src="<?php echo get_bloginfo('stylesheet_directory'); ?>/imgs/discussion_flag.png"/>
					</li>
				</ul>
			</section><!--class="answer"-->
			
			<?php if($comment->comment_has_children){ 
				$comment_id = $comment->ID;
				$query = "SELECT * FROM aq_discussion_comments WHERE comment_parent= '$comment_id' ORDER BY comment_date ASC";
				
				if($children = $wpdb->get_results($query)){
				
					foreach($children as $child){ ?>
						
						<section class="answer child">
						
							<article class="desc">
								<p><?php echo $child->comment_content; ?></p>
							</article>
							<figure>
							<?php 
								$child_id = $child->comment_author;
								  if(userphoto_exists( $child_id )) userphoto_thumbnail( $child_id ); 
								  else echo get_avatar( get_the_author_meta('user_email', $child_id) , 100);//defaults to blank gravatar can substitute if we want 		
							?>
							</figure>
							<section class="user_data">
								<p class="author">Posted <?php echo time_ago_comment( $child->comment_date ); ?> by </p>
								<?php $user_info = get_userdata($child_id);?>
								<br/>
								<p> <a class="<?php print_aquapon_cat(); ?>" href=""><?php echo $user_info-> display_name; ?></a>, <strong><?php $user_role = $user_info->roles; echo ucwords(str_replace("_", " ", $user_role[0])); ?></strong></p>
							</section>		
							<ul>
								<li data-id="<?php echo $comment->ID; ?>" data-user="<?php echo $user->ID; ?>" class="flag">
									<img title="Flag this post" src="<?php echo get_bloginfo('stylesheet_directory'); ?>/imgs/discussion_flag.png"/>
								</li>
							</ul>					
						</section><!--.answer.child-->
						
					<?php } /* foreach children as child */ ?>	
				<?php } /* if query has results */ ?>
				
			<?php } /* if comment has children is true */?>
				
		<?php 	} /* $comments as $comment */ ?>
		
		<?php }else{ ?>
		<?php } //if comments query?>
		<hr>
		<?php if(!is_user_logged_in()){ ?>
		
			<p class="unregistered" ><a href='/sign-in'>You must log in to post a response</a></p>						

		<?php }else{ ?>
			<form action="<?php echo $_SERVER['REQUEST_URI'] ?>" method="post" accept-charset="utf-8">
				
				<textarea name="content" placeholder="Share your expertise..." ></textarea>
				<input type="submit" value="post" >
				
			</form>
		<?php }?>
		
</section><!--section-->
