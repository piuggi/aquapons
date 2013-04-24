<?php $section = 'badges'; ?>
<?php get_header(); ?>

	
	<?php include(get_template_directory() . "/includes/badges_header.php"); ?>

	<section id="main" class="badges">
		<section id="page-content">

			<h2>Hierarchy Overview</h2>

			<section class="aquapons-badges"></section>
			<section class="badges-display">
				<section class="water">
					<section class="content-badges"></section><!--.content-badges-->
					<section class="skills-badges">
						<article class="one"></article>
						<article class="two"></article>
						<article class="three"></article>
						<article class="four"></article>
					</section><!--.skills-badges-->
					<section class="activities">
						<h5>activities</h5>
						<div class="bounding"></div>
						<section class="icons">
							<div class="water"></div>
							<div class="water"></div>
							<div class="water"></div>
							<div class="water"></div>
						</section><!--icons-->
					</section><!--.activities-->
				</section><!--.water -->
				<section class="fish">
					<section class="content-badges"></section><!--.content-badges-->
					<section class="skills-badges">
						<article class="one"></article>
						<article class="two"></article>
						<article class="three"></article>
						<article class="four"></article>
					</section><!--.skills-badges-->
					<section class="activities">
						<h5>activities</h5>
						<div class="bounding"></div>
						<section class="icons">
							<div class="fish"></div>
							<div class="fish"></div>
							<div class="fish"></div>
							<div class="fish"></div>
						</section><!--icons-->
					</section><!--.activities-->
				</section><!--.fish -->
				<section class="plant">
					<section class="content-badges"></section><!--.content-badges-->
					<section class="skills-badges">
						<article class="one"></article>
						<article class="two"></article>
						<article class="three"></article>
						<article class="four"></article>
					</section><!--.skills-badges-->
					<section class="activities">
						<h5>activities</h5>
						<div class="bounding"></div>
						<section class="icons">
							<div class="plant"></div>
							<div class="plant"></div>
							<div class="plant"></div>
							<div class="plant"></div>
						</section><!--icons-->
					</section><!--.activities-->
				</section><!--.plant -->
				<section class="design-build">
					<section class="content-badges"></section><!--.content-badges-->
					<section class="skills-badges">
						<article class="one"></article>
						<article class="two"></article>
						<article class="three"></article>
						<article class="four"></article>
					</section><!--.skills-badges-->
					<section class="activities">
						<h5>activities</h5>
						<div class="bounding"></div>
						<section class="icons">
							<div class="design-build"></div>
							<div class="design-build"></div>
							<div class="design-build"></div>
							<div class="design-build"></div>
						</section><!--icons-->
					</section><!--.activities-->
				</section><!--.design-build -->

			</section><!--.badges-display-->
			<section class="badges-desc">
				<section class="badges-desc-content">
						<div class="main-copy">
							<?php echo get_field('intro_paragraph'); ?>
						</div>
						<div class="body-copy">
							<?php echo get_field('overview_text'); ?>
						</div>
				</section>
				<section class="open-badges-callout">
					<div class="mozilla-foundation"></div>
					<p>Do you have a Mozilla Open Badges backpack? If so, you can display your Aquapons badges there as well!</p>
					<p class="link">Log into OBI</p>
				</section>
			</section>

		</section><!--#page-content-->

	</section><!--#main-->


<?php get_footer(); ?>