<?php
//add a new page for comments flagged and such

add_action( 'admin_menu', 'review_forum_discussions' );

function review_forum_discussions(){
	
	add_submenu_page('edit.php?post_type=discussion','Review Forum Answers', 'Review Answers','manage_options', 'review-discussions', 'review_discussions_function');
	
}

function review_discussions_function(){
	
		if ( !current_user_can( 'manage_options' ) )  {
		wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
	}
	?>
	<div class="wrap">
		<h2>Review Answers From Discussions</h2>
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
		<?php global $wpdb; 
			  $query = "SELECT * FROM aq_discussion_comments ORDER BY comment_date ASC";
			  $comments = $wpdb->get_results($query); 
			  foreach($comments as $comment){
		?>
			<tr id="discussion-<?php echo $comment->ID; ?>" class="discussion-<?php echo $comment->ID; ?>">
			
				<th scope="row" class="check-column">
					<input id="cb-select-<?php echo $comment->ID; ?>" type="checkbox" name="post[]" value="<?php echo $comment->ID; ?>">
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
				<?php $commentStatus = $comment->comment_status; 
					  $flagged=false;
					  if($commentStatus == 'flagged') $flagged=true;
				?>
				<td class="status column-status question-status " <?php if($flagged) echo 'style="background-color:red;"' ?>>
					
					<select>
						<option <?php if(!$flagged) echo 'selected="selected"' ?> >Published</option>
						<option <?php if($flagged) echo 'selected="selected"' ?>>Flagged</option>
					</select>
					
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
	</div>
	<?php 
}
