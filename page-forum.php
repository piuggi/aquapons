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
						

				 	<section id="discussions" class="main-col">
						<h2>Recent Discussions</h2>
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