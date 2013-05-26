<?php 
	
	include('/var/www/wp-blog-header.php');
	global $wpdb;
		
	//update a vote
	if(isset($_POST['vote'])){
		
		$vote = $_POST['vote'];
		$theID = $_POST['id'];
		$thePost = $_POST['post'];
		
		$votes = get_post_meta($thePost, 'votes', true);
		$votes++; update_post_meta($thePost, 'votes', $votes);
		
		$query = "UPDATE aq_discussion_comments SET comment_rank= comment_rank + $vote WHERE id='$theID'";

		$wpdb->query($query);
		echo json_encode(array("result"=>"aok"));
		
	}
	
	if(isset($_POST['flag'])){
		
		$flag = $_POST['flag'];
		$theID = $_POST['id'];
		$thePost = $_POST['post'];
		
		//global $wpdb;
		$query = "UPDATE aq_discussion_comments SET comment_flags= comment_flags + $flag WHERE id ='$theID'";
		$wpdb->query($query);
		$result = $wpdb->get_row("SELECT comment_flags FROM aq_discussion_comments WHERE id = $theID", ARRAY_A);
		
		if($result['comment_flags']>=2){
			
			$answers = get_post_meta($thePost, 'answers', true);
			$answers--; if($answers>=0) update_post_meta($thePost, 'answers', $answers);
			
			$data = array('comment_status'=>'flagged');
			$where = array('id'=> $theID );
			
			$wpdb->update('aq_discussion_comments', $data, $where );
			
			//send notification to admins that comment has been flagged for review
			
			echo json_encode(array("result"=>"flagged"));
			
		}else{
			
			echo json_encode(array("result"=>"aok"));
			
		}
		
	}
	
	if(isset($_POST['comment'])){
		
		//global $wpdb;
		
		$userID = $_POST['user'];
		$theID = $_POST['id'];
		$thePost = $_POST['post'];
		$comment = $_POST['comment'];
		
		
		$insert_args = array(
		
			'comment_discussion'=> $thePost,
			'comment_author'=> $userID,
			'comment_date'=> date("Y-m-d H:i:s"),
			'comment_content'=> $comment,
			'comment_status'=> 'publish',
			'comment_rank'=> 0,
			'comment_flags'=> 0,
			'comment_has_children'=> false,
			'comment_is_child'=> true,
			'comment_parent'=> $theID
			
		);
		
		$newID = $wpdb->insert('aq_discussion_comments', $insert_args);
		
		$data = array('comment_has_children'=> true);
		$where = array('id'=> $theID );
		
		$wpdb->update('aq_discussion_comments', $data, $where );
		
		?>
		
			<section class="answer child">			
				<article class="desc">
					<p><?php echo $comment; ?></p>
				</article>
				<figure>
					<?php 
					//$child_id = $child->comment_author;
					  if(userphoto_exists( $userID )) userphoto_thumbnail( $userID ); 
					  else echo get_avatar( get_the_author_meta('user_email', $userID) , 100);//defaults to blank gravatar can substitute if we want 		
					?>
				</figure>
				<section class="user_data">
					<p class="author">Posted <?php echo time_ago_comment( $insert_args['comment_date']); ?> by </p>
					<?php $user_info = get_userdata($userID);?>
					<br/>
					<p> <a class="<?php echo $class; ?>" href=""><?php echo $user_info-> display_name; ?></a>, <strong><?php $user_role = $user_info->roles; echo ucwords(str_replace("_", " ", $user_role[0])); ?></p>
				</section>		
				<ul>
				<li data-id="<?php echo $newID; ?>" data-post="<?php echo $thePost; ?>" data-user="<?php echo $userID; ?>" data-theme="<?php echo $_GET['theme']; ?>" class="flag">
					<img title="Flag this post" src="<?php echo get_bloginfo('stylesheet_directory'); ?>/imgs/discussion_flag.png"/>
				</li>
				</ul>					
			</section>
		
		<?php
		
	}
	
	
?>