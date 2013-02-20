<?php get_header(); ?>

	<section class="main">

		<?php if ( have_posts() ) : ?>

			<?php
			/* Start the Loop */
			while ( have_posts() ) : the_post();

				// print post results

			endwhile;
			?>

		<?php else : ?>
			
			No content found
			
		<?php endif; ?>

	</section><!-- #main -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>