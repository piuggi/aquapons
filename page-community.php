<?php $section = 'community'; ?>
<?php get_header(); ?>


		<?php if ( have_posts() ) : ?>

			<?php
			/* Start the Loop */
			while ( have_posts() ) : the_post();  
			
			$page_class = sanitize_title(get_the_title());
			$page_class = strtolower($page_class);
			?>
			<section id="main" class="<?php echo $page_class;?>">
				

				<section class="text-content">
						
					<section class="main-col">
						<h2>Featured Aquapons</h2>
						<section class="feat_aquapon">
							<?php 
					
							$args = array('post_type' => 'featured_aquapon', 'posts_per_page'=> 10, 'orderby'=>'date','order'=>'DESC'); 
							$loop = new WP_Query($args);
							
							while( $loop->have_posts()): $loop->the_post();
							
							?>
							<figure class="showcase" <?php if(!$g++) echo 'id="first"'; ?>>
								<?php $imgId = get_post_meta(get_the_ID(), 'image', true);  ?>
								<?php $imgArray = wp_get_attachment_image_src( $imgId);?>
								<a href="<?php the_permalink(); ?>">
									<img class="aquapon_ledgend" src="<?php echo $imgArray[0];  ?>" alt="One of our featured Aquapons <?php echo get_the_title();?>">
								</a>
								<figcaption>
									<h4 class="name"><a href="<?php the_permalink(); ?>"><?php echo get_the_title();?></a></h4>
									<p class="institution meta"><?php echo  get_post_meta(get_the_ID(), 'instution', true);  ?></p>
									
									<?php $loc = get_post_meta(get_the_ID(), 'location', true); 
										if($loc != ''){
									?>
									<p class="location meta"><?php echo $loc; ?></p>
									<?php } ?>
									
								</figcaption>
							</figure><!--showcase -->
		
		
							<?php endwhile; wp_reset_query(); ?>
						</section><!-- feat_aquapon -->
						<section id="new-institutions" >

						<h2>Featured Institutions <a>All institutions ›</a></h2>
							
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
									<article class="institution <?php if(!$g++) echo ' first'; ?>">
										<figure>
										<div class="icon">
											<img src="<?php echo bloginfo('template_url') ?>/imgs/<?php echo get_post_meta($post->ID, 'institution_icon', true); ?>.png">
										</div>
										<h4><?php echo get_post_meta($post->ID, 'institution_name', true); ?></h4>
										</figure>
										<?php $rawdate = get_post_meta($post->ID, 'established_date', true); 
											
										?>
										<p><?php echo establishedDate($rawdate); ?> • 54 Members</p>
									</article><!-- .institution -->
						
						
						
						<?php } wp_reset_query(); ?>
						</section><!-- #new-institutions -->
						
					</section>

					<section id="new_aquapons" class="sidebar">

						<h4>Newest Aquapons</h4>
						<ul>
						<?php						
		 			    $user_search = new WP_User_Query( 
							array(
							    'orderby'       => 'registered', 
							    'order'         => 'DESC', 
							    'number'        => 15,
							    'meta_key' 		=> 'private',
							    'meta_value' 	=> 0
							));
							
						$users = $user_search->get_results();
						foreach($users as $user){
							$user_info = get_userdata($user->ID); ?>
		
							<li><a href="http://aquapons.info/profile/?user=<?php echo getUserToken($user->ID); ?>"><?php echo $user_info->display_name; ?></a></li>
						<?php } ?>
						</ul>			
					</section>
				
				
				

				
				</section><!-- .text-content -->
			 
			<?php
				// print post results
				//the_title();
			endwhile;
			?>

		<?php else : ?>
			
			Oops. No content found.
			
		<?php endif; ?>

	</section><!-- #main -->

<?php get_footer(); ?>