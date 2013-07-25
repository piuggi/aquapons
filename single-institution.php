
<?php 
	$userid = get_current_user_id();

	if(isset($_POST['join'])){
		
		$user= $_POST['aq-user'];
		$institution = $_POST['aq-institution'];
		global $wpdb;
	
		$wpdb->insert('aq_members', array('user' => $user, 'institution'=> $institution ));	

	}if(isset($_POST['leave'])){
				$user= $_POST['aq-user'];
		$institution = $_POST['aq-institution'];
		global $wpdb;
	
		$wpdb->delete('aq_members', array('user' => $user, 'institution'=> $institution ));	
	}

?>
<?php $section = 'community'; ?>


<?php get_header(); ?>


	<section class="main">
	<?php if ( have_posts() ) : the_post(); ?>
	

			<section class="background text-content <?php if($institution_admin) echo "editable"; ?>">
				<h2>Background</h2>
				
				<div class="background_display">
					<h4>Location</h4>
					<p class="location"><?php echo get_field('institution_location'); ?></p>
					
					<h4>Established</h4>
					<p class="established"><?php echo date("F d, Y", strtotime(get_field('established_date'))); ?></p>
				</div>
				<div class="background_admin">
				
				</div>
			
			
			</section>
		
			<section class="my_badges text-content">
				<?php echo get_field('institution_description'); ?>
				<div class="members">
					<header>
						<h2>Current Members</h2>						
					</header>
					<section>
							
						<?php $members = $wpdb->get_results("SELECT * FROM `aq_members` WHERE institution = '".get_the_ID()."'"); 
						$bIsMember=false;

						if($members){
							foreach($members as $member){
								$grower=get_userdata($member->user);
								
								if($member->user == $userid) $bIsMember =! $bIsMember;
								
								?>
								
								<figure <?php //if(!$g++) echo 'class="first"'; ?>>
									<?php 
									if(userphoto_exists($grower)) userphoto_thumbnail($grower); 
									else echo get_avatar( $grower->user_email, 160);//defaults to blank gravatar can substitute if we want 		
									?>
									<figcaption>
									<h3><?php echo $grower->display_name; ?></h3>
									</figcaption>
								</figure>
								<?php
								
							}
						
						
						} 
						
						?>
						<?php if(is_user_logged_in()): ?>
						<form action="<?php echo $_SERVER['REQUEST_URI'] ?>" method="post" accept-charset="utf-8">
							<button type="submit"><?php if(!$bIsMember){ echo 'Join Institution'; }else{ echo 'Leave Institution';}?></button>
							<input type="hidden" value="<?php echo the_ID(); ?>" name="aq-institution"/>
							<input type="hidden" value="<?php echo $userid ?>" name="aq-user"/>
							<input type="hidden" value="true" name="<?php if(!$bIsMember){ echo 'join'; }else{ echo 'leave';}?>"/>
						</form>
						<?php else: ?>
						<p>Please login to join</p>
						<?php endif; ?>
					</section>
				</div>
				
			</section>
		</section>
	
	<?php else : ?>

		No content found
		
	<?php endif; ?>

	</div><!-- #main .wrapper -->
	
<?php get_footer(); ?>

