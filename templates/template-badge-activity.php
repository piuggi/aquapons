
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
		<?php breadcrumb($post); ?>
		<h2><?php the_title(); ?></h2>
		<div class="estimated_time">Estimated Time: 10 weeks</div>
	</section>
		
	<section id="badge-outline">
		<p><?php echo get_post_meta($post->ID, 'badge_description', true); ?></p>
	</section>
	
	<section class="text-content">
	
		
		<h2>Start Documenting</h2>
		<section class="main-col">
			
			
			<label for="activity_submission"><?php echo get_post_meta($post->ID, 'activity_description', true); ?></label>
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
					
					<?php wp_editor('', 'wysiwyg_activity_submission', array(
						'media_buttons' => false,
						'textarea_name' => 'activity_submission',
						'textarea_rows' => 10,
						'teeny' => true
						)
					); ?>
					
				<?php } else if(get_field('activity_response_type') == "image") { ?>
					<input type="file" name="activity_submission">
				<?php } else if(get_field('activity_response_type') == "video") { ?>
					<input type="text" name="activity_submission">
					<p class="submission_info">Enter in the URL for your video from either Vimeo or YouTube (eg. http://vimeo.com/32100234)</p>
				<?php } else if(get_field('activity_response_type') == "file") { ?>
					<input type="file" name="activity_submission">
				<?php } ?>
				
				<input type="submit" value="Post it!">
		
			</form>
			
			<?php } // if(!$activity_info) ?>
			
			
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
			
			
			
		
		</section>
		
		<div class="sidebar">
			<h4>Related Resources</h4>
						<?php 
			$resources = get_field('related_resources');
			foreach($resources as $resource) { ?>
				<article>
					<a href="<?php echo get_permalink($resource->ID); ?>"><?php echo $resource->post_title; ?></a>
				</article>
				
			<?php } ?>	
		</div>
	
	
	</section>
	
	

	


</section><!-- #main -->