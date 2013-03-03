<?php $section = 'badges'; 
	  $page = 'aquapons';
?>
<?php get_header(); ?>
<?php 
	$theme = new ThemeCheck();
	if(!isset($_GET['aquapons'])){
		//::TO-DO
		//check for users level
		
		//if no level present default to jr.
		
		$aquapons_level = 1;
		
		} else{
			
			$aquapons_level = $_GET['aquapons'];
			if($aquapons_level<1)$aquapons_level=1;
			
		}
		?>

	<section id="main" class="badges page aquapons">
		<section id="aquapons-navigation">
		
		<?php 
			$aquaponBadgeNum = 4;
			
			//check our sub navigation needs 
			$bLess = false; $bMore = false;
			if($aquapons_level-1> 0) $bLess = true;
			if($aquapons_level<$aquaponBadgeNum) $bMore = true;
			

			if($bLess ==true){	?>
			
			<a class="page-back" href="<?php $theme->url();?>&aquapons=<?php echo $aquapons_level-1; ?>" >
			</a>
		<?php
			}
			
			for($x = 1; $x <= $aquaponBadgeNum; $x++) { 
				
				// load all badges at this level
				$args = array(
					'post_type' => 'badge',
					'meta_key' => 'badge_level',
					'posts_per_page' => -1,
					'meta_value' => $x,
				);
				$query = new WP_Query( $args );
				while($query->have_posts()){
					$query->the_post();
					if(get_field('badge_type')=='aquapons') { ?>
							<?php /*/(l.<?php echo get_field('badge_level', $query->post->ID); ?>)*/
							
								$current_level=false;
								$hide_div=false;
								$bFirstHide=false;
								if(get_field('badge_level',$query->post->ID)== $aquapons_level) $current_level=true;
								
								//check if its out of our range ie. more than one
	
								if( abs($x-$aquapons_level)>1  ) $hide_div =true;	
								//echo abs($x-$aquapons_level);

								if(($aquapons_level == 1 || $aquapons_level == $aquaponBadgeNum ) && abs($x-$aquapons_level)==2)$hide_div=false;
/*						
								if( abs($x-$aquapons_level)>2 && $aquapons_level !=1 )$hide_div = false;
								if($aquaponBadgeNum == $aquapons_level )$hide_div=false;
*/
							?>
							<div class="aquapons badge <?php if($hide_div==true) echo 'hide';?>">
							<a href="<?php $theme->url();?>&aquapons=<?php echo $x; ?>">
							<img src="<?php bloginfo('template_directory'); if(!$current_level){ echo '/imgs/practioner_secondary.png';}else{ echo '/imgs/practioner_focus.png';}?>"></a>
							<a class="<?php if(!$current_level){ echo ' secondary '; }else{echo ' focus ';} echo sanitize_title(get_the_title()); ?>" href='<?php echo get_permalink($page->ID); $theme->url(); ?>'>
								<?php $t = str_replace(" ", "<br/>", get_the_title() ); echo $t; ?>
							</a>
								
						</div>
					<?php 
					
						if( ($bMore==true && $bFirstHide==false && $hide_div==true && $x!=1) || ($aquaponBadgeNum - $aquapons_level == 1 && $aquaponBadgeNum == $x)){
			
								?>
				
								<a class="page-forward" href="<?php $theme->url();?>&aquapons=<?php echo $aquapons_level+1; ?>" ></a>
			
					<?php 	
						  $bFirstHide=true; 
						  } //if page forward
					
				}//if aquapons
				
			  }//while
			  
			}//for
		?>
		
		</section>
		
		<?php 
		$cats = array('Water', 'Fish', 'Plant', 'Design + Build');


		for($x = 1; $x <= $aquaponBadgeNum; $x++) {
			// load all badges at this level
			$args = array(
				'post_type' => 'badge',
				'meta_key' => 'badge_level',
				'posts_per_page' => -1,
				'meta_value' => $x,
			);
			$query = new WP_Query( $args );
			
			//only show content & skills for the 
			//aquapons badge we are looking at.
			foreach($cats as $cat) { 
				$current_level=false;
				$hide_div=false;
				if(get_field('badge_level',$query->post->ID)== $aquapons_level) $current_level=true;	
				// show content badges
				rewind_posts();
				?>
				<section class="badge-stack <?php echo ' level-'.$x;  echo " ".sanitize_title(strtolower($cat)); if(!$current_level) echo ' hide';?>">
				<?php
				
				while ( $query->have_posts() ) {
					$query->the_post();
					$wp_cats = wp_get_post_categories($query->post->ID);
					if(get_field('badge_type')=='content' && get_cat_name($wp_cats[0]) == $cat) { ?>
						<div class="content badge <?php echo sanitize_title(get_the_title()); echo ' level-'.$x; if(!$current_level) echo ' hide';?>">
							<a href='<?php echo get_permalink($page->ID) ?>'><?php the_title(); ?></a>
							<!--(l.<?php echo get_field('badge_level', $query->post->ID); ?>)-->
						</div>
					<?php }
				}
				?>
				<section class="badge-container <?php echo ' level-'.$x; ?>">
				<?php
				// show skill badges
				rewind_posts(); 
				while ( $query->have_posts() ) {
					$query->the_post();
					$wp_cats = wp_get_post_categories($query->post->ID);
					if(get_field('badge_type')=='skill' && get_cat_name($wp_cats[0]) == $cat) { ?>
						<div class="skill badge <?php echo sanitize_title(get_the_title()); echo ' level-'.$x; if(!$current_level) echo ' hide';?>">
							<a href='<?php echo get_permalink($page->ID) ?>'><?php the_title(); ?></a>
							<hr>
							<!--(l.<?php echo get_field('badge_level', $query->post->ID); ?>)-->
						</div>
					<?php }
				} ?>
				</section><!-- .badge-container -->
			</section><!-- .<?php echo $cat; ?> -->
	<?php } // foreach($cats as $cat)

		}
		?>

	</section><!-- #main -->

<?php get_footer(); ?>