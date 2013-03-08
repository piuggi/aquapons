
<?php include(get_template_directory() . "/includes/badges_header.php"); ?>

<?php

if($_SESSION['user_id']) $userid = $_SESSION['user_id'];
else $userid = get_current_user_id();

$actvityid = get_the_ID();
$badgeid = $post->post_parent;
if($_POST) {
//print_r($_POST);

//$wpdb->query("INSERT INTO `aq_badge_submissions` (`id`, `user_id`, `badge_id`, `activity_id`, `current_status`, `data`) VALUES (NULL, '$userid', '$badgeid', '$actvityid', 'reviewing', '".$_POST['activity_submission']."')");

$wpdb->insert( 
	'aq_badge_submissions', 
	array( 
		'id'                   => NULL,
		'user_id'              => $userid,
		'badge_id'             => $badgeid,
		'activity_id'          => $actvityid,
		'current_status'       => 'reviewing',
		'data'                 => $_POST['activity_submission'],
		'submission_timestamp'  => date('Y-m-d H:i:s')
	)
);


}
?>
<section class="main">


	<section id="activity-nav">
		<ul>
			<?php breadcrumb($post); ?>
		</ul>
		<h2><?php the_title(); ?></h2>
		<div class="estimated_time">Estimated Time: 10 weeks</div>
	</section>
		
	<section id="badge-outline">
		<p><?php echo get_post_meta($post->ID, 'badge_description', true); ?></p>
	</section>
	
	<div class="sidebar right">
		<h4>Related Resources</h4>
	</div>
	

	
	<h2>Start Documenting</h2>
	
	
	<p><?php echo get_post_meta($post->ID, 'activity_description', true); ?></p>
		<?php 
	if($activity_info = $wpdb->get_row("SELECT * FROM aq_badge_submissions WHERE user_id = '$userid' AND activity_id = '$actvityid'  ORDER BY submission_timestamp DESC LIMIT 1")) {
	?>
	<div class="submission">
	<?php
	if($activity_info->current_status == 'reviewing') echo "<h4>Your submission is currently being reviewed.</h4>";
	?>
	<h3>Current Submission:</h3>
	<?php echo stripslashes($activity_info->data); ?>
	</div>
	
	<?php } else { // if($activity_info) ?>
	
	<form action="<?php echo $_SERVER['REQUEST_URI'] ?>" method="post" accept-charset="utf-8">
		<?php if(get_field('activity_response_type') == 'text') { //get_post_meta($post->ID, 'activity_response_type', true) == "text") { ?>
			<input type="text" name="activity_submission">
		<?php } else if(get_field('activity_response_type') == 'textarea') { //get_post_meta($post->ID, 'activity_response_type', true) == "text") { ?>
			<textarea name="activity_submission"></textarea>
		<?php } else if(get_field('activity_response_type') == "image") { ?>
			<input type="file" name="activity_submission">
		<?php } ?>
		
		<input type="submit">

	</form>
	
	<?php } // if(!$activity_info) ?>
	
	
	
	
	<h2>Relevant Discussions</h2>

	


</section><!-- #main -->