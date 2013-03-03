<?php $section = 'resources'; ?>
<?php if($_GET['json']) { 
	header('Cache-Control: no-cache, must-revalidate');
	header('Content-type: application/json');
	
	include('php/badges-json.php'); 
} else { ?>


<?php get_header(); ?>


	<section id="main" class="badges">

	<?php if ( have_posts() ) : the_post(); ?>
	
		<h2><?php the_title(); ?></h2>
		<h3><?php the_excerpt(); ?></h3>
		<?php the_content(); ?>
	
	<?php else : ?>

		No content found
		
	<?php endif; ?>

	</div><!-- #main .wrapper -->
	
<?php get_footer(); ?>

<?php } ?>