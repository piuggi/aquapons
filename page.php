<?php get_header(); ?>

	<section class="main">

		<?php if ( have_posts() ) : ?>

			<?php
			/* Start the Loop */
			while ( have_posts() ) : the_post(); ?>

				<section class="main-col text-content">
					<h2><?php echo get_the_title(); ?></h2>
					<?php the_content(); ?>
				</section>
			
			<?php
			endwhile;
			?>

		<?php else : ?>
			
			No content found
			
		<?php endif; ?>

	</section><!-- #main -->

<?php get_footer(); ?>