<?php $section = 'resources'; ?>
<?php $view = 'single'; ?>
<?php get_header(); ?>


<section id="main" class="<?php echo $page_class;?>">
	<?php if ( have_posts() ) : the_post(); 
		
		$post_id = get_the_ID();
		$user = wp_get_current_user();

	?>
	
	<?php /* Check for various for types */?>
	<?php if(isset($_POST["content"]) && is_user_logged_in() ){
	
		//we've gotten an anwser
		$answers = get_post_meta(get_the_ID(), 'answers', true);
		$answers++; update_post_meta(get_the_ID(), 'answers', $answers);
		
		global $wpdb;
		
		
		$insert_args = array(
		
			'comment_discussion'=> $post_id,
			'comment_author'=> $user->ID,
			'comment_date'=> date("Y-m-d H:i:s"),
			'comment_content'=> $_POST['content'],
			'comment_status'=> 'publish',
			'comment_rank'=> 0,
			'comment_flags'=> 0,
			'comment_has_children'=> false,
			'comment_is_child'=> false
		);
		
		$wpdb->insert('aq_discussion_comments', $insert_args);
		
	}elseif(isset($_POST["comment"])){
		
		global $wpdb;
		
		$insert_args = array(
		
			'comment_discussion'=> $post_id,
			'comment_author'=> $user->ID,
			'comment_date'=> date("Y-m-d H:i:s"),
			'comment_content'=> $_POST['comment'],
			'comment_status'=> 'publish',
			'comment_rank'=> 0,
			'comment_flags'=> 0,
			'comment_has_children'=> false,
			'comment_is_child'=> true,
			'comment_parent'=> $_POST['comment-id']
			
		);
		
		$wpdb->insert('aq_discussion_comments', $insert_args);
		
		$data = array('comment_has_children'=> true);
		$where = array('id'=> $_POST['comment-id'] );
		
		$wpdb->update('aq_discussion_comments', $data, $where );

		
	}elseif(isset($_POST["vote"])){
		
		$votes = get_post_meta(get_the_ID(), 'votes', true);
		$votes++; update_post_meta(get_the_ID(), 'votes', $votes);
		
		$vote = $_POST['vote'];
		$theID = $_POST['comment-id'];
		global $wpdb;
		
		
		$query = "UPDATE aq_discussion_comments SET comment_rank= comment_rank + $vote WHERE id='$theID'";

		$wpdb->query($query);
		
	}elseif(isset($_POST["flag"])){
		
		$flag = $_POST['flag'];
		$theID = $_POST['comment-id'];
		global $wpdb;
		$query = "UPDATE aq_discussion_comments SET comment_flags= comment_flags + $flag WHERE id ='$theID'";
		$wpdb->query($query);
		$result = $wpdb->get_row("SELECT comment_flags FROM aq_discussion_comments WHERE id = $theID", ARRAY_A);
		
		if($result['comment_flags']>=2){
			
			$answers = get_post_meta(get_the_ID(), 'answers', true);
			$answers--; if($answers>=0) update_post_meta(get_the_ID(), 'answers', $answers);
			
			$data = array('comment_status'=>'flagged');
			$where = array('id'=> $theID );
			
			$wpdb->update('aq_discussion_comments', $data, $where );
			
			//send notification to admins that comment has been flagged for review
			
		}
		
	} 
	
	?>
	
	
	<ul class="breadcrumb">
		<li>‹ <a href="/resources"> Resources </a></li>
		<li>‹ <a href="/resources/forum"> Forum </a></li>
		<li>‹ <a class="strong" href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
	</ul>
	<?php //keep a count of the views for each discussion item
		  $views =  get_post_meta($post_id, 'views', true); 
		  $views++; update_post_meta($post_id, 'views', $views);
		  $cats = get_the_category();	  
		  if($cats) $class = $cats[0]->slug;
		  else $class = 'plant';
		
	?>
	<header id="original" class="<?php echo $class; ?>">
		<figure class="user_photo">
			<?php if(userphoto_exists( get_the_author_meta('ID') )) userphoto_thumbnail( get_the_author_meta('ID') ); 
				  else echo get_avatar( get_the_author_meta('user_email') , 100);//defaults to blank gravatar can substitute if we want 		
			?>
		</figure>
		<section class="original_post">
			<p class="author">Posted <?php echo time_ago(); ?> by <a class="<?php echo $class; ?>" href=""><?php echo get_the_author(); ?></a></p>
			<h2 class="title"> <?php the_title(); ?> </h2>
			<p class="desc"> <?php echo get_the_content();?> </p>
		</section>
	</header><!--header#original-->
	
	<section id="responses" class="<?php echo $class; ?>">
		<section class="main-col">
		<h2><?php echo get_post_meta(get_the_ID(), 'answers', true) ?> Answers</h2>
		<?php //query for added comments 
			
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
					<p> <a class="<?php echo $class; ?>" href=""><?php echo $user_info-> display_name; ?></a>, <strong><?php $user_role = $user_info->roles; echo ucwords(str_replace("_", " ", $user_role[0])); ?></strong></p>
				</section>
				<ul>
					<li data-id="<?php echo $comment->ID; ?>" data-user="<?php echo $user->ID; ?>" class="comment">
						<img title="Comment on this post" src="<?php echo get_bloginfo('stylesheet_directory'); ?>/imgs/discussion_comment.png"/>
					</li>
					<li data-id="<?php echo $comment->ID; ?>" data-user="<?php echo $user->ID; ?>" class="flag">
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
								<li data-id="<?php echo $comment->ID; ?>" data-user="<?php echo $user->ID; ?>" class="flag">
									<img title="Flag this post" src="<?php echo get_bloginfo('stylesheet_directory'); ?>/imgs/discussion_flag.png"/>
								</li>
							</ul>					
						</section>
						
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
		<aside class="sidebar">							
			<h4>Related resources </h4>
			<ul>
				<?php
				$resource_args = array(
					'post_type' => 'resource',
					'orderby' => 'post_date',
					'category_name'=> $class,
					'order' => 'ASC',
				);
				$resource_query = new WP_Query( $resource_args );
				while($resource_query->have_posts()) {
					$resource_query->the_post();
				?>

					<li class="recent_resource">
						<a href="<?php echo the_permalink(); ?>">
							<h5><?php echo get_the_title(); ?></h5>
						</a>
					</li>
					
				<?php } wp_reset_query(); ?>	
			</ul>	
				
		</aside>
	</section><!--section#responses-->
	
	<section id="similar">
		<h2>Similar Discussions</h2>
		<?php 
	
		$discussion_args = array('post_type' => 'discussion', 
					  'posts_per_page'=> 5, 
					  'orderby'=>'date',
					  'category_name'=> $class,
					  'order'=>'DESC'); 
		$discussions = new WP_Query($discussion_args);
		while( $discussions->have_posts()): $discussions->the_post();
			$cats = get_the_category();
			//print_r($cats);
			
			if($cats) $class = $cats[0]->slug;
			else $class = 'plant';
		?>
		
		<article class="question">
			<section class="qleft">	
				<p><?php echo get_post_meta(get_the_ID(), 'votes', true) ?><em>votes</em></p>
				<hr>
				<p><?php echo get_post_meta(get_the_ID(), 'answers', true) ?><em>answers</em></p>	
			</section><!--.qleft-->
			<section class="qright">
					<div class="<?php echo $class; ?>"></div>
					<h3><a class="<?php echo $class; ?>" href="<?php the_permalink(); ?>"><?php echo get_the_title(); ?></a></h3>
					<p>Posted <?php echo time_ago(); ?> by <a class="<?php echo $class; ?>" href=""><?php echo get_the_author(); ?></a></p>
			</section><!--.qright-->
		</article><!--.question <?php echo get_the_title(); ?>  -->
		
		<?php endwhile; wp_reset_query(); ?>
	
	</section><!--#similar-->
	
	<?php endif;?>
</section><!--#main-->
<?php get_footer(); ?>
<?php /* Secret Form for page actions */ ?>
<form id="page_actions" action="<?php echo $_SERVER['REQUEST_URI'] ?>" method="post" accept-charset="utf-8" style="display: none;"></form>