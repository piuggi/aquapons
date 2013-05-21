<?php
	include('/var/www/wp-blog-header.php');
	global $wpdb;
	 if( isset($_POST['id']) ){ 
		$post_id = $_POST['id'];
		$current_user = $_POST['user'];
		$theme = $_GET['theme'];
		$query = "SELECT * FROM aq_discussion_comments WHERE comment_discussion = '$post_id' AND comment_status = 'publish' AND comment_is_child = '0' ORDER BY comment_rank DESC";
		if($comments = $wpdb->get_results($query)){	?>
			<section class='responses <?php echo $_POST['class']; ?> '>
			<p class='close <?php echo $_POST['class']; ?>'>Close</p>
			<?php foreach($comments as $comment){ ?>
				<section class="answer">
					<ul class="rank">
						<li data-id="<?php echo $comment->ID; ?>" data-post="<?php echo $post_id; ?>" data-user="<?php echo $current_user; ?>" data-theme="<?php echo $theme; ?>" class="up"></li>
						<li class="current"><?php echo $comment->comment_rank; ?></li>
						<li data-id="<?php echo $comment->ID; ?>" data-post="<?php echo $post_id; ?>" data-user="<?php echo $current_user; ?>" data-theme="<?php echo $theme; ?>" class="down"></li>
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
						<p> <a class="<?php echo $class; ?>" href=""><?php echo $user_info-> display_name; ?></a>, <strong><?php $user_role = $user_info->roles; echo ucwords(str_replace("_", " ", $user_role[0])); ?></strong></p>
					</section>
					<ul>
						<li data-id="<?php echo $comment->ID; ?>" data-post="<?php echo $post_id; ?>" data-user="<?php echo $current_user; ?>" data-theme="<?php echo $theme; ?>" class="comment">
							<img title="Comment on this post" src="<?php echo get_bloginfo('stylesheet_directory'); ?>/imgs/discussion_comment.png"/>
						</li>
						<li data-id="<?php echo $comment->ID; ?>" data-post="<?php echo $post_id; ?>" data-user="<?php echo $current_user; ?>" data-theme="<?php echo $theme; ?>" class="flag">
							<img title="Flag this post" src="<?php echo get_bloginfo('stylesheet_directory'); ?>/imgs/discussion_flag.png"/>
						</li>
					</ul>
				</section>
				
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
									<p> <a class="<?php echo $class; ?>" href=""><?php echo $user_info-> display_name; ?></a>, <strong><?php $user_role = $user_info->roles; echo ucwords(str_replace("_", " ", $user_role[0])); ?></strong></p>
								</section>		
								<ul>
									<li data-id="<?php echo $comment->ID; ?>" data-post="<?php echo $post_id; ?>" data-user="<?php echo $current_user; ?>" data-theme="<?php echo $theme; ?>" class="flag">
										<img title="Flag this post" src="<?php echo get_bloginfo('stylesheet_directory'); ?>/imgs/discussion_flag.png"/>
									</li>
								</ul>					
							</section>
						
					<?php } /* foreach children as child */ ?>	
				<?php } /* if query has results */ ?>
				
			<?php } /* if comment has children is true */?>
			

			<?php } /* foreach($comments as $comment) */ ?>
			<p class='close bottom <?php echo $_POST['class']; ?>'>Close</p>
			</section><!-- .responses -->
	
	<?php }else{ ?>
	
				<section class='responses <?php echo $_POST['class']; ?> '>
					<p class='close <?php echo $_POST['class']; ?>'>Close</p>
					<p class='nothing'>No Answers Yet!</p>
				</section><!-- .responses -->

<?php	} /* if $comments */
	
	} /* if $_POST */ ?>