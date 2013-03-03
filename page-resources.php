<?php get_header(); ?>

	<section class="main">

		<?php if ( have_posts() ) : ?>

			<?php
			/* Start the Loop */
			while ( have_posts() ) : the_post();

				// print post results
				the_title();
				the_content();

			endwhile;
			?>

		<?php else : ?>
			
			No content found
			
		<?php endif; ?>

	</section><!-- #main -->

<?php get_footer(); ?>