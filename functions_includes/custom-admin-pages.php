<?php
//add a new page for comments flagged and such

add_action( 'admin_menu', 'review_forum_discussions' );

function review_forum_discussions(){
	
	add_submenu_page('edit.php?post_type=discussion','Review Forum Answers', 'Review Answers','manage_options', 'review-discussions', 'review_discussions_function');
	
}

function review_discussions_function(){
	
	if ( !current_user_can( 'manage_options' ) ) wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
	
	global $wpdb;
		
	if(isset($_POST['review-discussions'])){
		
		$theID = $_POST['discuss-comment-id'];
		$discussion_id=	$_POST['review-discussions'];
		
		if(isset($_POST['comment_status'])){
		
			$data = array('comment_status'=> $_POST['comment_status']);
			$where = array('id'=> $theID );
			$wpdb->update('aq_discussion_comments', $data, $where );
			
			$answers = get_post_meta($discussion_id, 'answers', true);

			if($_POST['comment_status']=='flagged') $answers--; 
			elseif($_POST['comment_status']=='publish') $answers++; 
			if($answers>=0) update_post_meta($discussion_id, 'answers', $answers);
				
			
		}
	}
	
	if(isset($_POST['delete_posts'])){
		
		//print_r($_POST['post']);
		//comment_id & discussion_id sent as comment_discussion
		foreach($_POST['post'] as $discussion){
			
			$ids = explode('_',$discussion);
			$comment_id=$ids[0];
			$discussion_id=$ids[1];
			$flagged=$ids[2];
			
			if(!$flagged){
				$answers = get_post_meta($discussion_id, 'answers', true);
				$answers--; if($answers>=0) update_post_meta($discussion_id, 'answers', $answers);
			}
			
			$query = "DELETE FROM aq_discussion_comments WHERE ID = ' $comment_id ' ";
			$wpdb->query($query);
					
		}
	}
	
	?>
	<div class="wrap">
		<h2>Review Answers From Discussions</h2>
		<form method="post" action="<?php echo $_SERVER["REQUEST_URI"]; ?>" onsubmit="return confirm('These comments will be deleted perminantely. Are you sure?');">
			<div class="tablenav top">
				<input type="submit" class="button action" name="delete_posts" value="Delete Posts">
			</div>
			<table class="wp-list-table widefat fixed posts" cellspacing="0">
				<thead>
					<tr>
						<th scope="col" id="cb" class="manage-column column-cb check-column">
						<input type="checkbox" id="cb-select-all-1"/>	
						</th>
						<th scope="col" id="cb" class="manage-column column-title sortable desc">Question</th>
						<th scope="col" id="cb" class="manage-column column-title sortable desc">Answer</th>
						<th scope="col" id="cb" class="manage-column column-title sortable desc">Author</th>
						<th scope="col" id="cb" class="manage-column column-title sortable desc">Status</th>
						<th scope="col" id="cb" class="manage-column column-title sortable desc">Rank</th>
						<th scope="col" id="cb" class="manage-column column-title sortable desc">Flags</th>
						<th scope="col" id="cb" class="manage-column column-title sortable desc">Date</th>
					</tr>
				</thead>
				<tfoot>
					<tr>
						<th scope="col" id="cb" class="manage-column column-cb check-column">
						<input type="checkbox" id="cb-select-all-1"/>	
						</th>
						<th scope="col" id="cb" class="manage-column column-title sortable desc">Question</th>
						<th scope="col" id="cb" class="manage-column column-title sortable desc">Answer</th>
						<th scope="col" id="cb" class="manage-column column-title sortable desc">Author</th>
						<th scope="col" id="cb" class="manage-column column-title sortable desc">Status</th>
						<th scope="col" id="cb" class="manage-column column-title sortable desc">Rank</th>
						<th scope="col" id="cb" class="manage-column column-title sortable desc">Flags</th>
						<th scope="col" id="cb" class="manage-column column-title sortable desc">Date</th>
					</tr>
				</tfoot>
				<tbody id="the-list">
				<?php 
					  $query = "SELECT * FROM aq_discussion_comments ORDER BY comment_date ASC";
					  $comments = $wpdb->get_results($query); 
					  foreach($comments as $comment){
					  
						$commentStatus = $comment->comment_status; 
						$flagged=false;
						if($commentStatus == 'flagged') $flagged=true;
		
					  
				?>
					<tr id="discussion-<?php echo $comment->ID; ?>" class="discussion-<?php echo $comment->ID; ?>" <?php if($flagged) echo 'style="background-color:#ff6060;"';?>>
					
						<th scope="row" class="check-column">
							<?php $row_val = $comment->ID."_".$comment->comment_discussion."_".$flagged; ?>
							<input id="cb-select-<?php echo $comment->ID; ?>" type="checkbox" name="post[]" value="<?php echo $row_val; ?>">
						</th>
						<td class="post-title question-title page-title column-title">
							<a target="_blank" href="<?php echo get_permalink($comment->comment_discussion); ?>"><?php echo get_the_title($comment->comment_discussion); ?></a>
						</td>
						<td class="post-title question-anwser page-title column-title">
							<?php echo $comment->comment_content; ?>
						</td>
						<td class="author column-author question-author">
							<?php the_author_meta('display_name', $comment->comment_author); ?>
						</td>

						<td class="status column-status question-status ">
							<form method="post" action="<?php $_SERVER['REQUEST_URI'] ?>" >
								<select onchange="this.form.submit()" name="comment_status">
									<option <?php if(!$flagged) echo 'selected="selected"'; ?> value="publish" >Published</option>
									<option <?php if( $flagged) echo 'selected="selected"'; ?> value="flagged">Flagged</option>
								</select>
								<input type="hidden" name="discuss-comment-id" value="<?php echo $comment->ID; ?>">
								<input type="hidden" name="review-discussions" value="<?php echo $comment->comment_discussion; ?>">
							</form>
						</td>
						<td class="rank column-rank question-rank">
							 <?php echo $comment->comment_rank; ?>
						</td>
						<td class="flags column-flags question-flag">
							<?php echo $comment->comment_flags;?>
						</td>
						<td class="date column-date question-date">
							<?php echo $comment->comment_date; ?>
						</td>
						
					</tr>
				
				<?php //print_r($comment);?>
				
				<?php } ?>
				</tbody>
			</table>
		</form>
	</div>
	<?php 
}
