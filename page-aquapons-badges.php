<?php $section = 'badges'; ?>
<?php get_header(); ?>
<?php
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
			
			<a class="page-back" href="?aquapons=<?php echo $aquapons_level-1; ?>" >
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
					'orderby' => 'menu_order',
					'order' => 'ASC'
				);
				$query = new WP_Query( $args );
				while($query->have_posts()){
					$query->the_post();
					if(get_field('badge_type')=='aquapons') { ?>
							<?php /*/(l.<?php echo get_field('badge_level', $query->post->ID); ?>)*/
							
								$current_level=false;
								$hide_div=false;
								$bFirstHide=false;
								if(get_field('badge_level',$query->post->ID)== $aquapons_level) {
									$current_level=true;
									$aquapons_badge_desc = get_field('badge_description',$query->post->ID);
								}
								
								//check if its out of our range ie. more than one
	
								if( abs($x-$aquapons_level)>1  ) $hide_div =true;	
								//echo abs($x-$aquapons_level);

								if(($aquapons_level == 1 || $aquapons_level == $aquaponBadgeNum ) && abs($x-$aquapons_level)==2)$hide_div=false;
/*						
								if( abs($x-$aquapons_level)>2 && $aquapons_level !=1 )$hide_div = false;
								if($aquaponBadgeNum == $aquapons_level )$hide_div=false;
*/
							?>
							<div class="aquapons badge <?php if($current_level)echo 'current'; if($hide_div==true) echo 'hide';?>">
								<a href="?aquapons=<?php echo $x; ?>">
									<span class="vertical_align">
										<?php $t = str_replace(" ", "<br/>", get_the_title() ); echo $t; ?>
									</span>
								</a>
							</div>
					<?php 
					
						if( ($bMore==true && $bFirstHide==false && $hide_div==true && $x!=1) || ($aquaponBadgeNum - $aquapons_level == 1 && $aquaponBadgeNum == $x)){
			
								?>
				
								<a class="page-forward" href="?aquapons=<?php echo $aquapons_level+1; ?>" ></a>
			
					<?php 	
						  $bFirstHide=true; 
						  } //if page forward
					
				}//if aquapons
				
			  }//while
			  
			}//for
		?>
		
		</section>
		
		
							
		<section id="badge-outline" class="outline">
			<p><?php echo $aquapons_badge_desc; ?></p>
		</section>
		
		
		<?php 
		$cats = array('Water', 'Fish', 'Plant', 'Design + Build', 'Impact');


		for($x = 1; $x <= $aquaponBadgeNum; $x++) {
			// load all badges at this level
			$args = array(
				'post_type' => 'badge',
				'meta_key' => 'badge_level',
				'posts_per_page' => -1,
				'meta_value' => $x,
				'orderby' => 'menu_order',
				'order' => 'ASC'
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
				if($current_level) {
				?>
				<section class="badge-stack <?php echo ' level-'.$x; ?>">
				<?php
				
				while ( $query->have_posts() ) {
					$query->the_post();
					$wp_cats = wp_get_post_categories($query->post->ID);
					if(get_field('badge_type')=='content' && get_cat_name($wp_cats[0]) == $cat) { ?>
						<div class="content badge <?php echo ' level-'.$x; ?>" style="background: url(<?php echo get_field('badge_image', $badge_id->post_id); ?>) center center no-repeat;">
							<a href='<?php echo get_permalink($page->ID); ?>'>
								<div class="content_badge_title"><?php the_title(); ?></div>
							</a>
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
						<?php showBadge($query->post->ID); ?>
					<?php }
				} ?>
				</section><!-- .badge-container -->
			</section><!-- .badge-stack ?> -->
	<?php	} // if($current_level)
		 } // foreach($cats as $cat)

		}
		?>

	</section><!-- #main -->

<?php get_footer(); ?>