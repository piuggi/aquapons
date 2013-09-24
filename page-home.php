<?php get_header(); ?>


		<?php if ( have_posts() ) : ?>

			<?php
			/* Start the Loop */
			while ( have_posts() ) : the_post();  
			
			$page_class = sanitize_title(get_the_title());
			$page_class = strtolower($page_class);
			?>
			

			<section id="main" class="<?php echo $page_class;?>">
			
				<section id="mantle">
				
					<?php 
					
					$args = array('post_type' => 'featured_aquapon', 'posts_per_page'=> 10, 'orderby'=>'date','order'=>'DESC'); 
					$loop = new WP_Query($args);
					
					while( $loop->have_posts()): $loop->the_post();
					
					
					?>
					
					<figure class="showcase" <?php if(!$g++) echo 'id="first"'; ?>>
						<figcaption>
							<h4 class="name"><a href="<?php the_permalink(); ?>"><?php echo get_the_title();?></a></h4>
							<p class="institution"><?php echo  get_post_meta(get_the_ID(), 'instution', true);  ?></p>
							
							<?php $loc = get_post_meta(get_the_ID(), 'location', true); 
								if($loc != ''){
							?>
							<p class="location"><?php echo $loc; ?></p>
							<?php } ?>
							
						</figcaption>
						<?php $imgId = get_post_meta(get_the_ID(), 'image', true);  ?>
						<?php $imgArray = wp_get_attachment_image_src( $imgId, 'full');?>
						
						<img class="aquapon_ledgend" src="<?php echo $imgArray[0];  ?>" alt="One of our featured Aquapons <?php echo get_the_title();?>">
					</figure><!--showcase -->


					<?php endwhile; wp_reset_query(); ?>
				

				</section><!--mantle-->
				<section class="steps">
					<ul >
						<li id="start">
							<a href="/badges/aquapons-badges/">
							<figure><img src="<?php echo bloginfo('template_url') ?>/imgs/book.png"></figure>
							<h3>Start Learning</h3>
							<hr>
							<p>Ready to learn about aquaponics? Get started now!</p>
							</a>
						</li>
						<li id="hone">
							<a href="/badges/skills-badges/">
							<figure><img src="<?php echo bloginfo('template_url') ?>/imgs/trim.png"></figure>
							<h3>Hone your skills</h3>
							<hr>
							<p>Learn new skills or improve existing ones.</p>
							</a>
						</li>
						<li id="share">
							<a href="/resources/forum/">
							<figure><img src="<?php echo bloginfo('template_url') ?>/imgs/comment.png"></figure>
							<h3>Share Knowledge</h3>
							<hr>
							<p>Help others learn aquaponics by sharing your experiences.</p>
							</a>
						</li>
						<li id="meet">
							<a href="/community/">
							<figure><img src="<?php echo bloginfo('template_url') ?>/imgs/leaf.png"></figure>
							<h3>Meet Aquapons</h3>
							<hr>
							<p>Connect with like-minded people. Make friends. Build a community.</p>
							</a>
						</li>		
						<li id="earn">
							<a href="/badges/badges-overview/">
							<figure><img src="<?php echo bloginfo('template_url') ?>/imgs/banner.png"></figure>
							<h3>Earn Badges</h3>
							<hr>
							<p>A look at our badge program. Start earning badges today!</p>
							</a>
						</li>
					</ul>
					<section id="stripes">
					</section><!--stripes -->
				</section><!-- steps -->
				
				<?php 
				global $first_timer;
				if($first_timer) { ?>
					<section class="outline">
						<?php echo get_field('first_time_visitor_message'); ?>
					</section>
				<?php } ?>

				<section id="callout" class="textcontent">
					<section id="featured_grower">
					<h2>Featured Growers </h2>
					<?php 
						//will have to add query to stop from finding COPPA Users
						$grower_args = array( 'orderby'=> 'registered',
										'order'=> 'DESC',
										'number'=> 10
						 				); 
						 				
						 $growers = get_users($grower_args);
						 
						 foreach($growers as $grower){
					?>	 
						  
					<figure <?php if(!$g++) echo 'class="first"'; ?>>
						<?php if(userphoto_exists($grower)) userphoto_thumbnail($grower); 
							  else echo get_avatar( $grower->user_email, 160);//defaults to blank gravatar can substitute if we want 		
						?>
						<!--<img src="<?php echo bloginfo('template_url') ?>/imgs/feat_grower1.png" alt=""/>-->
						<figcaption>
							<h3><?php echo $grower->display_name; ?></h3>
						</figcaption>
					</figure>
						  
					<?php  }/*end for each $growers */ ?>
					</section><!--featured grower -->
				</section><!-- callout -->
				<section id="additional-content" class="text-content">
					<section id="recent-discussions">
						<section id="discussions" class="main-col">
							<h2>Recent Discussions <a href="/resources/forum/">All Discussions ›</a></h2>
							<?php 

							$discussion_args = array('post_type' => 'discussion', 
										  'posts_per_page'=> 5, 
										  'orderby'=>'date',
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
						</section><!--#discussions-->
						<section id="resources" class="sidebar">
							
							<h4>Newly added resources </h4>
							<ul>
								<?php
								$resource_args = array(
									'post_type' => 'resource',
									'orderby' => 'post_date',
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
								
							</section><!--#resources-->	
					</section><!--recent-discussions-->
					<section id="new-institutions" class="side-scroller">
						<h2>New Institutions <a href="/community/institutions/">All institutions ›</a></h2>
						
						<?php  
							$institution_args = array(
														'post_type'=> 'institution',
														'orderby'=> 'date',
														'order'	=> 'DESC',			
													);
							$institutions = new WP_Query($institution_args);
							while($institutions->have_posts()){
								$institutions->the_post();
						?>
						<a href="<?php echo get_permalink(); ?>">
						<article class="institution <?php if(!$g++) echo ' first'; ?>">
							<figure>
							<div class="icon"><img src="<?php echo bloginfo('template_url') ?>/imgs/<?php echo get_post_meta($post->ID, 'institution_icon', true); ?>.png"></div>
							<h4><a href="<?php the_permalink(); ?>"><?php echo get_post_meta($post->ID, 'institution_name', true); ?></a></h4>
							</figure>
							<?php $rawdate = get_post_meta($post->ID, 'established_date', true); 
								$user_count = $wpdb->get_var( "SELECT COUNT(*) FROM `aq_members` WHERE institution = '".get_the_ID()."'" );	
							?>
							<p><?php echo establishedDate($rawdate).' • '.$user_count.' Members'; ?> </p>
						</article><!-- .institution -->
						</a>
						
						
						<?php } wp_reset_query(); ?>

					</section><!--new_institutions -->
				</section><!--additional content -->

			 
			<?php
				// print post results
				//the_title();
			endwhile;
			?>

		<?php else : ?>
			
			Oops. No content found.
			
		<?php endif; ?>


		<?php/* if ( have_posts() ) : ?>

			<?php
			/* Start the Loop * /
			while ( have_posts() ) : the_post();

				// print post results
				//the_title();
			endwhile;
			?>

		<?php else : ?>
			
			Oops. No content found.
			
		<?php endif; */?>

	</section><!-- #main -->

<?php get_footer(); ?>