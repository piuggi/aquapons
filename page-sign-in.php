<?php if ( is_user_logged_in() ){ wp_redirect( home_url() ); exit; } ?>
<?php get_header(); ?>

	<section class="main">
		
		<?php the_post(); ?>
		<?php the_content(); ?>
		
		<?php 
		
			if(isset($_GET['redirect'])){
				
				$args = array(	
								'redirect'=>site_url($_GET['redirect']) 
								
							  );
							  
				wp_login_form($args);
				
			}else{
				
				wp_login_form();	
				
			}
		 
		?>
			
	</section><!-- #main -->

<?php get_footer(); ?>