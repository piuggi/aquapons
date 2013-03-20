<?php $section = 'resources'; ?>
<?php get_header(); ?>


		<?php if ( have_posts() ) : ?>

			<?php
			/* Start the Loop */
			while ( have_posts() ) : the_post();  
			
			$page_class = sanitize_title(get_the_title());
			$page_class = strtolower($page_class);
			?>
			<section id="main" class="<?php echo $page_class;?> text-content">
				
			 	<section id="tutorials" class="main-col">
			 	
			 	
					<h2>Recent Tutorials</h2>
					
					<?php
					$args = array(
						'post_type' => 'resource',
						'meta_key' => 'resource_type',
						'meta_value' => 'tutorial',
						'orderby' => 'post_date',
						'order' => 'ASC'
					);
					$query = new WP_Query( $args );
					while($query->have_posts()) {
						$query->the_post();
					?>

						<article class="tutorial">
							<?php echo wp_get_attachment_image(get_field('resource_image'), 'tutorial-thumb'); ?>
							<h4 class="meta-info">Posted 3 days ago by <a>Username123</a> | 3 comments</h4>
							<h3><?php echo get_the_title(); ?></h3>
							<?php the_excerpt(); ?>
							<footer>
								Level: <span class="level">Senior Apprentice</span>
								<span class="approval">12 growers found this useful</span>
							</footer>
						</article>
						
						
					<?php } ?>	
						
						<article class="tutorial">
							<img src="" alt="Tutorial Name">
							<h4 class="meta-info">Posted 3 days ago by <a>Username123</a> | 3 comments</h4>
							<h3>Name of Tutorial</h3>
							<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
							<footer>
								Level: <span class="level">Senior Apprentice</span>
								<span class="approval">12 growers found this useful</span>
							</footer>
						</article>
						<article class="tutorial">
							<img src="" alt="Tutorial Name">
							<h4 class="meta-info">Posted 3 days ago by <a>Username123</a> | 3 comments</h4>
							<h3>Name of Tutorial</h3>
							<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
							<footer>
								Level: <span class="level">Senior Apprentice</span>
								<span class="approval">12 growers found this useful</span>
							</footer>
						</article>
						<article class="tutorial">
							<img src="" alt="Tutorial Name">
							<h4 class="meta-info">Posted 3 days ago by <a>Username123</a> | 3 comments</h4>
							<h3>Name of Tutorial</h3>
							<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
							<footer>
								Level: <span class="level">Senior Apprentice</span>
								<span class="approval">12 growers found this useful</span>
							</footer>
						</article>
						
						
					</section><!--#discussions-->
			
			 
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