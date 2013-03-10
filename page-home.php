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
					<figure id="showcase">
						<figcaption>
							<h4 class="name">Linda Jackson</h4>
							<p class="institution">institution name</p>
							<p class="location">san diego, california</p>
						</figcaption>
						<img id="aquapon_ledgend" src="<?php echo bloginfo('template_url') ?>/imgs/featured_dev_test.png" alt="One of our featured Aquapons">
					</figure>
					<ul >
						<li id="start" class="steps">
							<figure><img src="<?php echo bloginfo('template_url') ?>/imgs/book.png"></figure>
							<h3>Start Learning</h3>
						</li>
						<li id="hone" class="steps">
							<figure><img src="<?php echo bloginfo('template_url') ?>/imgs/trim.png"></figure>
							<h3>Hone your skills</h3>
						</li>
						<li id="share" class="steps">
							<figure><img src="<?php echo bloginfo('template_url') ?>/imgs/comment.png"></figure>
							<h3>Share Knowledge</h3>
						</li>
						<li id="meet" class="steps">
							<figure><img src="<?php echo bloginfo('template_url') ?>/imgs/leaf.png"></figure>
							<h3>Meet Aquapons</h3>
						</li>		
						<li id="earn" class="steps">
							<figure><img src="<?php echo bloginfo('template_url') ?>/imgs/banner.png"></figure>
							<h3>Earn Badges</h3>
						</li>
					</ul>
					<section id="stripes">
					</section><!--stripes -->
				</section><!--mantle-->
				<section id="callout">
					<section id="featured_grower">
					<h2>Featured Growers </h2>
					<figure class="first">
						<img src="<?php echo bloginfo('template_url') ?>/imgs/feat_grower1.png" alt=""/>
						<figcaption>
							<h3>CoolUsername12324</h3>
						</figcaption>
					</figure>
					<figure>
						<img src="<?php echo bloginfo('template_url') ?>/imgs/feat_grower2.png" alt=""/>
						<figcaption>
							<h3>CoolUsername12324</h3>
						</figcaption>
					</figure>
					<figure>
						<img src="<?php echo bloginfo('template_url') ?>/imgs/feat_grower3.png" alt=""/>
						<figcaption>
							<h3>CoolUsername12324</h3>
						</figcaption>
					</figure>
					<figure>
						<img src="<?php echo bloginfo('template_url') ?>/imgs/feat_grower4.png" alt=""/>
						<figcaption>
							<h3>CoolUsername12324</h3>
						</figcaption>
					</figure>
					<figure>
						<img src="<?php echo bloginfo('template_url') ?>/imgs/feat_grower5.png" alt=""/>
						<figcaption>
							<h3>CoolUsername12324</h3>
						</figcaption>
					</figure>
					<figure>
						<img src="<?php echo bloginfo('template_url') ?>/imgs/feat_grower1.png" alt=""/>
						<figcaption>
							<h3>CoolUsername12324</h3>
						</figcaption>
					</figure>
					</section><!--featured grower -->
				</section>
				<section id="additional-content">
					<section id="recent-discussions">
						
						<section id="discussions">
							<h2>Recent Discussion <a>All Discussions ›</a></h2>
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
						<section id="resources">
							<article class="recent_resource">
							<h4>Newly added resources </h4>
							<hr/>
							</article>
							<article class="recent_resource">
								<p>Power point presentation <a>Download ›</a></p>
								<hr/>
							</article>
							<article class="recent_resource">
								<p><a>Just a resource link ›</a></p>
								<hr/>
							</article>
							<article class="recent_resource">
								<p><a>Title of a resource </a>by author name</p>
								<hr/>
							</article>	
							<article class="recent_resource">
								<p>PDF Document to <a>Download ›</a></p>
								<hr/>
							</article>
							<article class="recent_resource">
								<p>Power point presentation <a>Download ›</a></p>
								<hr/>
							</article>
							<article class="recent_resource">
								<p><a>Just a resource link ›</a></p>
								<hr/>
							</article>
							<article class="recent_resource">
								<p><a>Title of a resource </a>by author name</p>
								<hr/>
							</article>	
							<article class="recent_resource">
								<p>PDF Document to <a>Download ›</a></p>
								<hr/>
							</article>						
						</section>
					</section><!--recent-->
					<section id="new-institutions">
						<h2>New Institutions <a>All institutions ›</a></h2>
						<article class="institution first">
							<figure>
							<img src="<?php echo bloginfo('template_url') ?>/imgs/largerleaf.png">
							<h4>Brooklyn Growers Society</h4>
							</figure>
							<p>Est. April,2005 • 54 Members</p>
						</article>
						<article class="institution">
							<figure>
							<img src="<?php echo bloginfo('template_url') ?>/imgs/squiggle.png">
							<h4>Washington University Aquaponics</h4>
							</figure>
							<p>Est. Sept,2008 • 65 Members</p>
						</article>
						<article class="institution">
							<figure>
							<img src="<?php echo bloginfo('template_url') ?>/imgs/fish.png">
							<h4>Jefferson High School Urban Farming Club</h4>
							</figure>
							<p>Est. August,2013 • 34 Members</p>
						</article>
						<article class="institution">
							<figure>
							<img src="<?php echo bloginfo('template_url') ?>/imgs/largerleaf.png">
							<h4>Brooklyn Growers Society</h4>
							</figure>
							<p>Est. January, 2013 • 23 Members</p>
						</article>
						<article class="institution">
							<figure>
							<img src="<?php echo bloginfo('template_url') ?>/imgs/squiggle.png">
							<h4>Washington University Aquaponics</h4>
							</figure>
							<p>Est. Sept,2008 • 65 Members</p>
						</article>
					</section><!--new_institutions -->
			 </section><!--additional_content -->
			 
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