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
					</section>

					<section id="find_a_job" class="sidebar">

						<h4>Find a Job</h4>
						<ul>
							<li>
								<h5>Title of a Job Position</h5>
								<p><a>Some Co.</a></p>
							</li>
							<li>
								<h5>Title of a Job Position</h5>
								<p><a>Some Co.</a></p>
							</li>
							<li>
								<h5>Title of a Job Position</h5>
								<p><a>Some Co.</a></p>
							</li>
							<li>
								<h5>Title of a Job Position</h5>
								<p><a>Some Co.</a></p>
							</li>
							<li>
								<h5>Title of a Job Position</h5>
								<p><a>Some Co.</a></p>
							</li>
						</ul>			
					</section>
					
					<section id="browse_the_library">
						<h2>Browse the Library</h2>

						<ul>
							<li id="start">
								<a href="/resources/tutorials/">
								<figure><img src="<?php echo bloginfo('template_url') ?>/imgs/book.png"></figure>
								<h3>Books</h3>
								<hr>
								<p>We have books about a bunch of different topics.</p>
								</a>
							</li>
							<li id="hone">
								<a href="/badges/skills-badges/">
								<figure><img src="<?php echo bloginfo('template_url') ?>/imgs/trim.png"></figure>
								<h3>Articles</h3>
								<hr>
								<p>We have articles about a bunch of different topics.</p>
								</a>
							</li>
							<li id="share">
								<a href="/resources/forum/">
								<figure><img src="<?php echo bloginfo('template_url') ?>/imgs/comment.png"></figure>
								<h3>Presentations</h3>
								<hr>
								<p>Watch a recent presentation and learn something.</p>
								</a>
							</li>
							<li id="meet">
								<a href="/community/">
								<figure><img src="<?php echo bloginfo('template_url') ?>/imgs/leaf.png"></figure>
								<h3>Links</h3>
								<hr>
								<p>Connect to other helpful content on related websites.</p>
								</a>
							</li>		
							<li id="earn">
								<a href="/badges/badges-overview/">
								<figure><img src="<?php echo bloginfo('template_url') ?>/imgs/banner.png"></figure>
								<h3>Products</h3>
								<hr>
								<p>Find the tools that help you get growing.</p>
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