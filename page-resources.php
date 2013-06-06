<?php $section = 'resources'; ?>
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
						<h2>Follow A Tutorial</h2>
						
						<?php
						$args = array(
							'post_type' => 'resource',
							'meta_key' => 'resource_type',
							'meta_value' => 'tutorial',
							'orderby' => 'post_date',
							'order' => 'ASC',
							'posts_per_page' => 2
						);
						$query = new WP_Query( $args );
						while($query->have_posts()) {
							$query->the_post();
						?>
	
							<article class="tutorial">
								<a href="<?php echo get_permalink(); ?>">
									<?php 
										
										$thumb= wp_get_attachment_image(get_field('resource_image'), 'tutorial-thumb'); 
										if($thumb) echo $thumb;
										else{
											
											$args = array(
												'post_type' => 'attachment',
												'numberposts' => 1,
												'post_status' => null,
												'post_parent' => $post->ID
											);
											
											$attachments = get_posts( $args );
											if ( $attachments ) echo wp_get_attachment_image( $attachments[0]->ID, 'full' );
										}
											
										
									?>
								</a>
								<div class="info">
									<h4 class="meta-info">Posted <?php echo get_the_date(); ?> by <a><?php echo get_the_author(); ?></a> | <?php comments_number(); ?></h4>
									<h3><a href="<?php echo get_permalink(); ?>"><?php echo get_the_title(); ?></a></h3>
									<?php the_excerpt(); ?>
								</div>
								<footer>
									Level: <span class="level"><?php badge_level_name(get_field('resource_level')); ?></span>
									<span class="approval"><?php $votes = get_post_meta($post->ID, 'votes', true); if($votes) echo $votes; else echo '0'; ?> growers found this useful</span>
								</footer>
							</article>
							
							
						<?php } ?>	
						
						

					</section>

					<section id="find_a_job" class="sidebar">

						<h4>Find a Job</h4>
						<ul>
						<?php
						$args = array(
							'post_type' => 'resource',
							'meta_key' => 'resource_type',
							'meta_value' => 'job',
							'orderby' => 'post_date',
							'order' => 'ASC',
							'post_count' => 6
						);
						$query = new WP_Query( $args );
						while($query->have_posts()) {
							$query->the_post();
						?>
							<li>
								<h5><?php echo get_the_title(); ?></h5>
								<p><a href="<?php echo get_field('job_post_url'); ?>"><?php echo get_field('company_name'); ?></a></p>
							</li>
						<?php } ?>
						</ul>			
					</section>
					
					<section id="browse_the_library">
						<h2>Browse the Library</h2>

						<ul>
							<li id="start">
								<a href="/resources/books/">
								<figure><img src="<?php echo bloginfo('template_url') ?>/imgs/book.png"></figure>
								<h3>Books</h3>
								<hr>
								<p>We have books about a bunch of different topics.</p>
								</a>
							</li>
							<li id="hone">
								<a href="/badges/articles/">
								<figure><img src="<?php echo bloginfo('template_url') ?>/imgs/trim.png"></figure>
								<h3>Articles</h3>
								<hr>
								<p>We have articles about a bunch of different topics.</p>
								</a>
							</li>
							<li id="share">
								<a href="/resources/presentations/">
								<figure><img src="<?php echo bloginfo('template_url') ?>/imgs/comment.png"></figure>
								<h3>Presentations</h3>
								<hr>
								<p>Watch a recent presentation and learn something.</p>
								</a>
							</li>
							<li id="meet">
								<a href="/resources/links">
								<figure><img src="<?php echo bloginfo('template_url') ?>/imgs/leaf.png"></figure>
								<h3>Links</h3>
								<hr>
								<p>Connect to other helpful content on related websites.</p>
								</a>
							</li>		
							<li id="earn">
								<a href="/resources/products/">
								<figure><img src="<?php echo bloginfo('template_url') ?>/imgs/banner.png"></figure>
								<h3>Products</h3>
								<hr>
								<p>Find the tools that help you get growing. asf asdf</p>
								</a>
							</li>
						</ul>
					</section><!-- #browse_the_library -->
			 
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