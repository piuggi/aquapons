<?php if ( is_user_logged_in() ){ wp_redirect( home_url() ); exit; } ?>
<?php get_header(); ?>

	<section class="main">
		
		<?php the_post(); ?>
		<?php the_content(); ?>
		<?php wp_login_form(); ?>
			
	</section><!-- #main -->

<?php get_footer(); ?>