<?php include(get_template_directory() . "/includes/badges_header.php"); ?>

<?php

if($_SESSION['user_id']) $userid = $_SESSION['user_id'];
else $userid = get_current_user_id();



$submissiontype = $_POST['submission_type'];
$activityid = get_the_ID();
$badgeid = $post->post_parent;
if(isset($_POST['ask'])){
	
	//we have a new question for this badge
	
	$post_args = array(

		'post_type'=> 'discussion',
		'post_status'=> 'publish',
		'post_title'=> $_POST['title'],
		'post_category'=>array($_POST['category']),
		'post_content'=> $_POST['question'],
		'post_author'=> get_current_user_id()
		
	
	);
	
	$question_id = wp_insert_post($post_args);
	add_post_meta($question_id, 'views', 0, true );
	add_post_meta($question_id, 'votes', 0, true );
	add_post_meta($question_id, 'answers', 0, true );
	add_post_meta($question_id, 'activity_id', $activityid ,true);
	
	
}else if(isset($_POST['post'])) {



if(is_user_logged_in()){
		
	if($submissiontype === 'video'){
		
		$data=$_POST['activity_video'];

	}elseif($submissiontype ==='image' || $submissiontype ==='file'){
		
			//handle file contents
		if ( ! function_exists( 'wp_handle_upload' ) ) require_once( ABSPATH . 'wp-admin/includes/file.php' );
		$uploadedfile = $_FILES["activity_submission"];
		$upload_overrides = array('test_form'=>false);
		$wpfile = wp_handle_upload( $uploadedfile,$upload_overrides);
		$data='';
		$submissiontype = $_POST['submission_type'];
		//print_r($_POST);
		$data=$wpfile['url'];
		
	}elseif($submissiontype ==='text'){
		
		$data=$_POST['activity_submission'];
	}
	
	
	$info = array( 
	
	'user_id'=> $userid,
	'badge_id'             => $badgeid,
	'activity_id'          => $activityid,
	'current_status'       => 'submission',
	'type'				   => $submissiontype,
	'data'                 => $data,
	'submission_timestamp'  => date('Y-m-d H:i:s')
	
	);
	//does wpdb query with info	
	insertSubmission($info);
	updateBadgeStatus($userid, $badgeid);

}else{
	$error = array("Could not complete request. You must log in to post content.");

}		


}elseif(isset($_POST['complete'])){
	
	//echo 'Submit!';
	if(is_user_logged_in()){
		//will have to query for all submissions by user and update them
		$info = array( 

		'user_id' 			   => $userid,
		'badge_id'             => $badgeid,
		'activity_id'          => $activityid,
		'current_status'       => 'complete',
		'submission_timestamp' => date('Y-m-d H:i:s')
		
		);
		//does wpdb query with info	
		insertSubmission($info);
		updateBadgeStatus($userid, $badgeid);
		
		
/*
		$data = array('current_status'=>'reviewing');
		$where = array('user_id'=> $userid,
					   'activity_id' => $activityid);
		
		$wpdb->update('aq_badge_submissions', $data, $where );
*/
	
	}else{
	
		$error = array("Could not complete request. You must log in to submit content.");
	}
} elseif(isset($_POST['submit'])){
	
	if(is_user_logged_in()){
		//will have to query for all submissions by user and update them
		$info = array( 

		'user_id' 			   => $userid,
		'badge_id'             => $badgeid,
		'activity_id'          => $activityid,
		'current_status'       => 'reviewing',
		'type'				   => $submissiontype,
		'data'                 => $data,
		'submission_timestamp' => date('Y-m-d H:i:s')
		
		);
		
		insertSubmission($info); //does wpdb query with info	
		updateBadgeStatus($userid, $badgeid);
		
		
/*
		$data = array('current_status'=>'reviewing');
		$where = array('user_id'=> $userid,
					   'activity_id' => $activityid);
		
		$wpdb->update('aq_badge_submissions', $data, $where );
*/
	
	}else{
	
		$error = array("Could not complete request. You must log in to submit content.");
	}

}elseif(isset($_POST['delete'])){

	$id = $_POST['submission_id'];
	$query = "DELETE FROM `aq_badge_submissions` WHERE `id`=".$id;
	$wpdb->query($query);

}elseif(isset($_POST['update'])){
	
		$wpdb->update( 
			'aq_badge_submissions', 
			array( 'data'=>$_POST['activity_submission']), 
			array( 'id' => $_POST['submission_id'] )
		);
	//exit;	
	//updateSubmissionText();
	//$id = $_POST['submission_id'];
}


// SELF-EVAL CHECK			
// check to see if activity is self-eval
$self_eval = get_field('self_evaluation');
// if so, are all other activities complete?
$badge_complete = true;
if($self_eval[0]) {
	$args = array(
		'post_type' => 'badge',
		'post_status' => 'publish',
		'orderby' => 'menu_order',
		'order' => 'ASC',
		'posts_per_page' => -1,
		'post_parent' => $badgeid
	);
	$children = new WP_Query( $args );
	while($children->have_posts()) { $children->the_post();
		$activity_id = get_the_ID();
		// LOAD CURRENT STATUS
		$activity_status = $wpdb->get_row("SELECT * FROM aq_badge_submissions WHERE user_id = '$userid' AND activity_id = '$activity_id' ORDER BY submission_timestamp DESC LIMIT 1");
		if($activity_status->current_status != 'complete' && $activityid != $activity_id) $badge_complete = false;
	}
}

?>



<section class="main <?php if($self_eval[0]) echo ' self_eval'; if(isset($_SESSION['reviewing'])) echo ' reviewing'; ?>">


	<section id="activity-nav">
		<?php breadcrumb($post); ?>

		<?php
		
		$ancestors = get_ancestors($activityid, 'badge');
		$badge_info = $wpdb->get_row("SELECT * FROM aq_badge_status WHERE user_id = '$userid' AND badge_id = '".$ancestors[0]."'");
		$current_userdata = get_userdata($userid);
		$activity_status = $wpdb->get_row("SELECT * FROM aq_badge_submissions WHERE user_id = '$userid' AND activity_id = '$activityid' ORDER BY submission_timestamp DESC LIMIT 1");
		
		if(isset($_SESSION['reviewing'])) { ?>
			<div class="badge_status_container">
				<h3 class="this_badge_status">CURRENTLY REVIEWING <?php echo $current_userdata->user_nicename; ?>'S WORK </h3>			
			</div>
		<?php } elseif($badge_info->status == 'complete' || $activity_status->current_status == 'complete') { ?>
			<div class="badge_status_container">
				<h3 class="this_badge_status">COMPLETE</h3>			
			</div>
		<?php } elseif($activity_status->current_status == 'reviewing') { ?>
			<div class="badge_status_container">
				<h3 class="this_badge_status">REVIEWING</h3>			
			</div>
		<?php } ?>

		<h2><?php the_title(); ?></h2>
		<div class="estimated_time">Estimated Time: <?php echo get_post_meta($post->ID, 'estimated_timeframe', true); ?></div>
	</section>
	
	
	<section id="activity-pagination">
	
		<?php
		$args = array(
				'posts_per_page'  => -1,
				'post_type' => 'badge',
				'orderby' => 'menu_order',
				'order' => 'ASC',
				'post_parent' => $post->post_parent
			);
		$siblings = get_posts($args);
	
		foreach ($siblings as $key=>$sibling){
	        if ($post->ID == $sibling->ID){
	            $ID = $key;
	        }
	    }
		?>
	
		<div class="previous_activity">
			<?php if($siblings[$ID-1]) { ?>
				<a href="<?php echo get_permalink($siblings[$ID-1]->ID) ?>">‹ <?php echo $siblings[$ID-1]->post_title; ?></a>
			<?php } ?>
		</div>
		<div class="next_activity">
			<?php if($siblings[$ID+1]) { ?>
				<a href="<?php echo get_permalink($siblings[$ID+1]->ID) ?>"><?php echo $siblings[$ID+1]->post_title; ?> ›</a>
			<?php } ?>
		</div>
		<div class="activity_siblings">
			<?php 
			foreach ($siblings as $key=>$sibling){ ?>
		        <?php if($ID != $key) { ?>
		       		<a href="<?php echo get_permalink($siblings[$key]->ID) ?>"><?php echo $key+1; ?></a>
		        <?php } 
		        else echo $key+1;
		    } ?>
		</div>
	</section>
	

		
	<section class="badge-outline">
		<?php echo get_field('activity_description'); ?>
		<hr>
		<div class="badge-objectives">
			<?php if(get_field('activity_instructions')!= '' ){ ?>
				<h3>Instructions</h3>
				<?php echo get_field('activity_instructions'); ?>
			<?php } ?>
			<div class="info">
				<?php if(get_field('activity_learn')!= '' ){ ?>
					<div class="half learn"> <h3>Learn</h3> <?php echo get_field('activity_learn');?></div>
				<?php } ?>
				<?php if(get_field('activity_do')!= '' ){ ?>
					<div class="half do"><h3>Do</h3><?php echo get_field('activity_do');?></div>
				<?php } ?>
			</div>
		</div>
	</section>
	
	<section class="text-content">
	
		<?php 
			if(isset($error)){				
				foreach($error as $e){ ?>
					
					<h4 class="error"><?php echo $e; ?></h4>
					
			<?php }
				
			}
			if(is_user_logged_in()){
		
			if($activity_retrieve = $wpdb->get_results("SELECT * FROM aq_badge_submissions WHERE user_id = '$userid' AND activity_id = '$activityid'  AND (`type`='text' OR `type`='image' OR `type`='video' OR `type`='file')  ORDER BY submission_timestamp DESC")) { $userSubmissions = true; ?>
		
		<h2>Recent Documentation</h2>
		<section class="main-col">
			<?php //<h3>Current Submission:</h3>?>
			<?php
			foreach($activity_retrieve as $activity_info){
				//print_r($activity_info);
				$type=$activity_info->type;
				?>
				<div class="submission <?php echo $type; ?>">
				<?php
				switch($type){
					
					case "image":
					?>
						<figure>
							<img src="<?php echo $activity_info->data; ?>">
							<form action="<?php echo $_SERVER['REQUEST_URI'] ?>" method="post" accept-charset="utf-8">
								<button type="submit" name="delete">Delete</button>
							<input type="hidden" name="submission_id" value="<?php echo $activity_info->id ?>">
							</form>
						</figure>
					<?php
					break;
					case "video":
						//echo $activity_info->data;	
						$embed_code = wp_oembed_get( $activity_info->data, array('width'=> 800) );
						?>
						<div class="h_iframe">
						<form action="<?php echo $_SERVER['REQUEST_URI'] ?>" method="post" accept-charset="utf-8">
							<button type="submit" name="delete">Delete</button>
							<input type="hidden" name="submission_id" value="<?php echo $activity_info->id ?>">
						</form>
						<?php echo $embed_code; ?> 
						</div>
						<?php
					break;
					case "text":
					?> 
						<article class="text">
						
							<h3>Journal Entry</h3>
							<button type="button" class="edit">Edit</button>
							<form action="<?php echo $_SERVER['REQUEST_URI'] ?>" method="post" accept-charset="utf-8">
								<button type="submit" name="delete">Delete</button>
								<input type="hidden" name="submission_id" value="<?php echo $activity_info->id ?>">
							</form>
							<?php $submission_time = explode( " ", $activity_info->submission_timestamp); 
							 $dbDate = explode("-",$submission_time[0]);
							 $date = $dbDate[1]."-".$dbDate[2]."-".$dbDate[0];
							 $time= $submission_time[1];
							 ?>
							<h5><?php  echo $date; ?> </h5>
							<hr>
							<form class="edit" id="journal_edit-<?php echo $activity_info->id ?>" action="<?php echo $_SERVER['REQUEST_URI'] ?>" method="post" accept-charset="utf-8" style="display:none;">
								<?php wp_editor($activity_info->data, 'wysiwyg_activity_submission', array(
									'media_buttons' => false,
									'textarea_name' => 'activity_submission',
									//'textarea_rows' => 25,
									'teeny' => true, 
									'quicktags' => false
									)
								); ?>
								<input type="hidden" name="submission_id" value="<?php echo $activity_info->id ?>">
							</form>
							<p><?php echo stripslashes($activity_info->data); ?></p>
							
							
						
						</article>
						
					<?php
					break;
					case "file":
					?>
						<article class="text">
						<h3>File Upload</h3>
						<form action="<?php echo $_SERVER['REQUEST_URI'] ?>" method="post" accept-charset="utf-8">
							<button type="submit" name="delete">Delete</button>
							<input type="hidden" name="submission_id" value="<?php echo $activity_info->id ?>">
						</form>
						<?php $submission_time = explode( " ", $activity_info->submission_timestamp); 
							 $dbDate = explode("-",$submission_time[0]);
							 $date = $dbDate[1]."-".$dbDate[2]."-".$dbDate[0];
							 $time= $submission_time[1];
							 ?>
						<h5><?php  echo $date; ?> </h5>
						<hr>
						<p><a href="<?php echo $activity_info->data; ?>"><?php echo $activity_info->data; ?></a></p>
						</article>
					<?
					break;
					
				}
				?>
				<?php// echo stripslashes($activity_info->data); ?>
				</div>
			
			<?php }/*end foreach($activity_retrieve as $activity_info)*/ ?>
			
			
			<?php } elseif($self_eval[0] && !$badge_complete) { ?>
			
				<h2>Start Documenting</h2>
				<h3>You must complete all other activities before you fill out a self-evaluation.</h3>
			
			<?php } else { $userSubmissions=false; // if($activity_info) ?>
				
				<h2>Start Documenting</h2>
				<section class="main-col no_submission">

				<?php if(!$userSubmissions && $current_user->ID == $userid) activityUploadNav(); ?>
					
			<?php	} ?>
			
			<?php } else{ //ifuserlogged in  ?>
			
				<h2>Log In to Start Documenting</h2>
				<section class="main-col">	
				
			
			<?php } ?>
			
			<form id="journal_input" action="<?php echo $_SERVER['REQUEST_URI'] ?>" method="post" accept-charset="utf-8" style="display:none;">
					<?php wp_editor('', 'wysiwyg_activity_submission', array(
						'media_buttons' => false,
						'textarea_name' => 'activity_submission',
						'textarea_rows' => 15,
						'teeny' => true, 
						'quicktags' => false
						)
					); ?>
					<input type="hidden" name="submission_type" value="text">
					<input type="submit" name="post" value="Enter Text">
					<a class="cancel_link cancel_journal_input">Cancel</a>
			</form>
			
				
			<?php// if(!$userSubmissions) activityUploadNav(); ?>
		
		</section> <!--main col -->
		
		<div class="sidebar">
			<?php 
			if($activity_status->current_status === 'reviewing') echo "<h2>Your badge has been submitted for review.</h2>";
			elseif($userSubmissions && $current_user->ID == $userid && $activity_status->current_status !== 'complete') activityUploadNav();
			
			$first_resource = 0;
			$resources = get_field('related_resources');
			foreach($resources as $resource) { ?>
				<?php if(!$first_resource) { $first_resource = 1; ?><h4>Related Resources</h4><?php } ?>
				<article>
					<a href="<?php echo get_permalink($resource->ID); ?>"><?php echo $resource->post_title; ?></a>
				</article>
			<?php } echo "&nbsp;" ?>	
		</div>
	
	
	</section>
	
	<section id="discussions">
	<h2>Relevant Discussions <a href="/forum">All Discussions ›</a></h2>
	<?php $totalDiscussions = 0; ?>
	<?php if(is_user_logged_in()){
	
			$discussion_args = array(	'post_type' => 'discussion', 
				 						'orderby'=>'date',
				 						'order'=>'DESC',
				 						'author'=> get_current_user_id(),
				 						'meta_query'=>array(
				 										array(
				 											'key'=> 'activity_id',
				 											'value'=> $activityid
				 										)
				 									)
				 					); 
		} else {
			
			$discussion_args = array(	'post_type' => 'discussion', 
				 						'orderby'=>'date',
				 						'order'=>'DESC',
				 						'meta_query'=>array(
				 										array(
				 											'key'=> 'activity_id',
				 											'value'=> $activityid
				 										)
				 									)
				 					);
		}
		
		$discussions = new WP_Query($discussion_args);
		
		if(is_user_logged_in() && $discussions->found_posts==0){
				//if the user is signed in but hasn't asked any questions 
				//default to any questions asked by the community.
				
				$discussion_args = array(	'post_type' => 'discussion', 
		 									'orderby'=>'date',
		 									'order'=>'DESC',
					 						'meta_query'=>array(
					 										array(
					 											'key'=> 'activity_id',
					 											'value'=> $activityid
					 										)
					 									)
					 					);
		 		$discussions = new WP_Query($discussion_args);

			
		}
		while( $discussions->have_posts()): $discussions->the_post(); 
					$cats = get_the_category();
					
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
						<h3><a data-id="<?php the_ID(); ?>" data-user="<?php echo get_current_user_id(); ?>" data-theme="<?php echo $_GET['theme']; ?>" class="<?php echo $class; ?>" href="<?php the_permalink(); ?>"><?php echo get_the_title(); ?></a></h3>
						<p>Posted <?php echo time_ago(); ?> by <a class="<?php echo $class; ?>" href=""><?php echo get_the_author(); ?></a></p>
				</section><!--.qright-->
			</article><!--.question <?php echo get_the_title(); ?>  -->
	<?php endwhile; ?>

</section><!--#discussions-->
	
	<section id="ask-question">
		<section id="form">
			<h2>Ask A Question</h2>
			<?php if(is_user_logged_in()): ?>
			<form id="new_discussion" action="<?php echo $_SERVER['REQUEST_URI'] ?>" method="post" accept-charset="utf-8">
				<input id="title" type="text" name="title" placeholder="Give this question a descriptive title...">
				<?php 
					$cats_args = array('type'=>'discussions', 'exclude'=>1);
					$cats = get_categories($cats_args); 
				?>

				<select id="category" name="category">
					<option value="">Relevant Content Area</option>
					<?php foreach($cats as $cat): ?>
					<option value="<?php echo $cat->cat_ID; ?>"><?php echo $cat->cat_name; ?></option>
					<?php endforeach; ?>
				</select>
				<textarea id="question" name="question" placeholder="What's the problem?"></textarea>
				<input type="submit" name="ask" value="Post Question">
			</form>
			<?php else: ?>
			<p><a href='/sign-in'>You Must Log in to post a question</a></p>						
			<?php endif;?>
		</section>
	</section><!--#ask-->

</section><!-- #main -->