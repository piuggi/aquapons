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
								<?php echo wp_get_attachment_image(get_field('resource_image'), 'tutorial-thumb'); ?>
								<div class="info">
									<h4 class="meta-info">Posted <?php echo get_the_date(); ?> by <a><?php echo get_the_author(); ?></a> | <?php comments_number(); ?></h4>
									<h3><?php echo get_the_title(); ?></h3>
									<?php the_excerpt(); ?>
								</div>
								<footer>
									Level: <span class="level"><?php badge_level_name(get_field('resource_level')); ?></span>
									<span class="approval">12 growers found this useful</span>
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
			 
				 	<section id="discussions" class="main-col">
						<h2>Recent Discussions <a>All Discussions ›</a></h2>
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