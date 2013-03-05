<?php $section = 'badges'; ?>
<?php $view = 'single'; ?>
<?php if($_GET['json']) { 
	header('Cache-Control: no-cache, must-revalidate');
	header('Content-type: application/json');
	
	include('php/badges-json.php'); 
} else { ?>

<?php if ( have_posts() ) : the_post(); ?>


<?php get_header(); ?>


	<section id="main" class="badges">

	<?php 
		$badge_type = get_post_meta($post->ID, 'badge_type', true);
		include(get_template_directory() . "/templates/template-badge-".$badge_type.".php");
	
	else : ?>

	
<?php get_header(); ?>

	<section id="main" class="badges">

		No content found
		
	<?php endif; ?>

	</div><!-- #main .wrapper -->
	
<?php get_footer(); ?>

<?php } ?>