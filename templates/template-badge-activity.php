

<?php include(get_template_directory() . "/includes/badges_header.php"); ?>

<?php

if($_SESSION['user_id']) $userid = $_SESSION['user_id'];
else $userid = get_current_user_id();



$submissiontype = $_POST['submission_type'];
$activityid = get_the_ID();
$badgeid = $post->post_parent;


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
		$activity_info = $wpdb->get_row("SELECT * FROM aq_badge_submissions WHERE user_id = '$userid' AND activity_id = '$activity_id' ORDER BY submission_timestamp DESC LIMIT 1");
		if($activity_info->current_status != 'complete' && $activityid != $activity_id) $badge_complete = false;
	}
}
			



if(isset($_POST['post'])) {




//print_r($_POST);

//$wpdb->query("INSERT INTO `aq_badge_submissions` (`id`, `user_id`, `badge_id`, `activity_id`, `current_status`, `data`) VALUES (NULL, '$userid', '$badgeid', '$activityid', 'reviewing', '".$_POST['activity_submission']."')");
//print_r($_POST);
//print_r($_FILES["activity_submission"]);

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
	
	//echo 'Submit!';
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
}
?>
<section class="main <?php if($self_eval[0]) echo 'self_eval'; ?>">


	<section id="activity-nav">
		<?php breadcrumb($post); ?>

		<?php 				
		$activity_info = $wpdb->get_row("SELECT * FROM aq_badge_submissions WHERE user_id = '$userid' AND activity_id = '$activityid' ORDER BY submission_timestamp DESC LIMIT 1");
		if($activity_info->current_status == 'complete') { ?>
			<h3 class="badge_status">COMPLETE</h3>			
		<?php } elseif($activity_info->current_status == 'reviewing') { ?>
			<h3 class="badge_status">REVIEWING</h3>			
		<?php } ?>

		<h2><?php the_title(); ?></h2>
		<div class="estimated_time">Estimated Time: <?php echo get_post_meta($post->ID, 'estimated_timeframe', true); ?></div>
	</section>
	
	

		
	<section class="badge-outline">
		<?php echo get_field('activity_description'); ?>
		<hr>
		<div class="badge-objectives">
			<h3>Instructions</h3>
			<?php echo get_field('activity_instructions'); ?>
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
					
						echo '<img src="'.$activity_info->data.'">';
					
					break;
					case "video":
						//echo $activity_info->data;	
						$embed_code = wp_oembed_get( $activity_info->data, array('width'=> 800) );
						?>
						<div class="h_iframe">
						<?php echo $embed_code; ?> 
						</div>
						<?php
					break;
					case "text":
					?> 
						<article class="text">
						
							<h3>Journal Entry</h3>
							
							<?php $submission_time = explode( " ", $activity_info->submission_timestamp); 
							 $dbDate = explode("-",$submission_time[0]);
							 $date = $dbDate[1]."-".$dbDate[2]."-".$dbDate[0];
							 $time= $submission_time[1];
							 ?>
							<h5><?php  echo $date; ?> </h5>
							<hr>
							<p><?php echo stripslashes($activity_info->data); ?></p>
						
						</article>
						
					<?php
					break;
					case "file":
					?>
						<article class="text">
						<h3>File Upload</h3>
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
				<?php// print_r($activity_info); ?>
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
			
			<?php }else{ //ifuserlogged in  ?>
			
				<h2>Log In to Start Documenting</h2>
				<section class="main-col">	
				
			
			<?php } ?>
			
			<form id="journal_input" action="<?php echo $_SERVER['REQUEST_URI'] ?>" method="post" accept-charset="utf-8" style="display:none;">
					<?php wp_editor('', 'wysiwyg_activity_submission', array(
						'media_buttons' => false,
						'textarea_name' => 'activity_submission',
						'textarea_rows' => 10,
						'teeny' => true
						)
					); ?>
					<input type="hidden" name="submission_type" value="text">
					<input type="submit" name="post" value="Enter Text">
			</form>
			
				
						
			
			
			<section id="discussions">
				<h2>Relevant Discussion <a>All Discussions ›</a></h2>
				<article class="question">
					<section class="qleft">	
						<p>50<em>votes</em></p>
						<hr>
						<p>50<em>answers</em></p>	
					</section><!--.qleft-->
					<section class="qright">
							<div class="plant"></div>
							<h3>Title of Recent Question That Was Posted to the Forum?</h3>
							<p>Posted 5 minutes ago by <a class="plants" href="">Username123</a></p>
					</section><!--.qright-->
				</article><!--.question -->
	
				<article class="question">
					<section class="qleft">	
						<p>50<em>votes</em></p>
						<hr>
						<p>50<em>answers</em></p>	
					</section><!--.qleft-->
					<section class="qright">
							<div class="fish"></div>
							<h3>Title of Recent Question That Was Posted to the Forum?</h3>
							<p>Posted 5 minutes ago by <a class="fish" href="">Username123</a></p>
					</section><!--.qright-->
				</article><!--.question -->
											<article class="question">
					<section class="qleft">	
						<p>50<em>votes</em></p>
						<hr>
						<p>50<em>answers</em></p>	
					</section><!--.qleft-->
					<section class="qright">
							<div class="design-build"></div>
							<h3>Title of Recent Question That Was Posted to the Forum?</h3>
							<p>Posted 5 minutes ago by <a class="plants" href="">Username123</a></p>
					</section><!--.qright-->
				</article><!--.question -->
	
				<article class="question">
					<section class="qleft">	
						<p>50<em>votes</em></p>
						<hr>
						<p>50<em>answers</em></p>	
					</section><!--.qleft-->
					<section class="qright">
							<div class="water"></div>
							<h3>Title of Recent Question That Was Posted to the Forum?</h3>
							<p>Posted 5 minutes ago by <a class="fish" href="">Username123</a></p>
					</section><!--.qright-->
				</article><!--.question -->
			</section><!--#discussions-->
			
			
			
		
		</section> <!--main col -->
		
		<div class="sidebar">
			<?php if($userSubmissions && $current_user->ID == $userid) activityUploadNav(); ?>
			<?php
			$first_resource = 0;
			$resources = get_field('related_resources');
			foreach($resources as $resource) { ?>
				<?php if(!$first_resource) { $first_resource = 1; ?><h4>Related Resources</h4><?php } ?>
				<article>
					<a href="<?php echo get_permalink($resource->ID); ?>"><?php echo $resource->post_title; ?></a>
				</article>
				
			<?php } ?>	
		</div>
	
	
	</section>
	
	

	


</section><!-- #main -->