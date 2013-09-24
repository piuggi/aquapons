<?php $section = 'class'; ?>

<?php
	//print_r($_POST); 
	$classTypes = array('agriculture'=> 'Agriculture',
						'biology'=>'Biology',
						'math'=>'Math', 
						'technology'=> 'Technology', 
						'fabrication'=>'Fabrication', 
						'language-arts'=>'Language Arts');
	//$cats = get_categories($cats_args); 
?>

<?php  if(isset($_POST['aq-title'])){
		$classTitle =$_POST['aq-title'];
		$classLocation = $_POST['aq-location'];
		$classTime = $_POST['aq-time'];
		$classContentArea= $_POST['aq-contentarea'];
		$classInstitution=$_POST['aq-institution'];
	
	
	
		$wpdb->insert('aq_class', array(
			'instructor'=> get_current_user_id(),
			'title'=> $classTitle,
			'location'=> $classLocation,
			'time'=>$classTime,
			'content_area'=> $classContentArea,
			'institution'=>$classInstitution
		));
	
	
	
	//print_r($_POST);
	
}elseif(isset($_POST['delete-class'])){
	
		//print_r($_POST);
		
		$wpdb->delete('aq_class',array('id'=>$_POST['class-id']) ); //delete class from db
		$wpdb->delete('aq_class_roster',array('aq_class_id' => $_POST['class-id'])); //delete roster from db
	
}elseif(isset($_POST['student-name'])){
	
		//print_r($_POST);
		$user = get_user_by( 'email', $_POST['student-name'] );
		$class_id = $_POST['class-id'];

		//print_r($user);
		
		$user_count = $wpdb->get_var( "SELECT COUNT(*) FROM aq_class_roster WHERE aq_student_id = '".$user->ID."' AND aq_class_id='".$class_id."'" );
		if($user_count == 0){
			$wpdb->insert('aq_class_roster', array(
				'aq_instructor'=> get_current_user_id(),
				'aq_class_id'=> $class_id,
				'aq_student_id'=> $user->ID
			));
		}

	
}elseif(isset($_POST["remove-student"])){
		$wpdb->delete( 'aq_class_roster' , array('aq_student_id' => $_POST['student-id'], 'aq_class_id'=> $_POST['class-id']) ); //delete roster from db

		
}?>
<?php get_header(); ?>

	<section id="main" class="class">
			<section id="overview">
					<section id="form" <?php if(!isset($_GET['new']) )echo 'style="display:none;" ';?> >
						<h2>Create a Class</h2>
						<?php if(is_user_logged_in()): ?>
						<form id="new_class" action="<?php echo $_SERVER['REQUEST_URI'] ?>" method="post" accept-charset="utf-8">
						<section id="text-holder">
						<article>
							<input id="title" type="text" name="aq-title" placeholder="Enter the name of this class...">
						</article>
						<article>
							<input id="location" class="half-input" type="text" name="aq-location" placeholder="Where does the class meet?" />
							<input id ="time" class="half-input" type="text" name="aq-time" placeholder="When does it meet?"/>
						</article>	
						</section>
							<aside>
								<select id="category" name="aq-contentarea">
									<option value="">Class Content Area</option>
									<?php foreach($classTypes as $typeKey=>$typeVal): ?>
										<option value="<?php echo $typeVal ?>"><?php echo $typeVal ?></option>
									<?php endforeach; ?>
								</select>
								<select id="institution" name="aq-institution">
									<option value="">Affiliated Institution</option>
									<?php 
										  
										$institution_args = array(
												'post_type'=> 'institution',
												'orderby'=> 'date',
												'order'	=> 'DESC',			
											);
										$institutions = new WP_Query($institution_args);
										while($institutions->have_posts()){
											$institutions->the_post();
										?>
										<option value="<?php the_ID(); ?>"><?php echo get_post_meta($post->ID, 'institution_name', true); ?></option>
									<?php 	} wp_reset_query(); ?>
								</select>
							</aside>
							<input type="submit" value="Register">
						</form>
						<?php else: ?>
						
						<p><a href='/sign-in?redirect=<?php echo $_SERVER['REQUEST_URI']; ?>'>You Must Log in to post a question</a></p>						
						<?php endif;?>
					</section>
					<header></header>
					<footer><p id="register"><?php if(isset($_GET['new'])){ echo 'Close';}else{echo 'Register';}?></p></footer>
				</section><!--#Overview-->	
				
				<section class="text-content">
					<h2>Your Classes</h2>
					<section id="class-list">
					<?php
					  $query="SELECT * FROM aq_class WHERE instructor = '".get_current_user_id()."'";
					  //echo $query;
					  $classes = $wpdb->get_results( $query );
					  //print_r($classes);
					  ?>
					  
					<?php if($classes){ 
							foreach($classes as $class){ ?>
						
								<article class="single-class">
								
									<ul>
										<li>
											<h2><?php echo $class->title;?> </h2>
											<ul>
												<li><?php echo $class->location;?></li>
												<li>||</li>
												<li><?php echo $class->time;?></li>
												<li>||</li>
												<li><?php echo $class->content_area;?></li>
											</ul>
										</li>
										<li class="right">
											<ul>
												<li>
													<form class="delete-class" action="<?php echo $_SERVER['REQUEST_URI'] ?>" method="post" accept-charset="utf-8">
														<button type="submit" name="delete-class">Delete Class</button>
														<input type="hidden" name="class-id" value="<?php echo $class->id;?> ">
													</form>
												</li>
												<li>
													<form class="submit-student" action="<?php echo $_SERVER['REQUEST_URI'] ?>" method="post" accept-charset="utf-8" >
														<button class="add-student" type="button" >Add Student</button>
														<input style="display:none;" class="student-email" type="input" name="student-name" placeholder="Enter your students email address">
														<button class="submit-student" style="display:none;"  type="button" name="add-student" value="add">Submit</button>
														<button class="cancel-student" style="display:none;" type="button" name="cancel" value="add">Cancel</button>
														<input type="hidden" name="class-id" value="<?php echo $class->id;?> ">

													</form>
												</li>
											</ul>
										</li>
									</ul>
									
									<section>
										<h3>Current Students</h3>
										<?php $roster =  $wpdb->get_results("SELECT * FROM aq_class_roster WHERE aq_class_id = '".$class->id."'"); 
											  foreach($roster as $student):
											  		//print_r($s);
											  		//echo $student;
												  $studentUser = get_user_by('id', $student->aq_student_id);
												  	//print_r($studentUser);
										?>
										<div class="student-info">
											<ul>
												<li>Username: <?php echo $studentUser->display_name ?></li>
												<!--<li>Email: <?php echo $studentUser->user_email ?></li>-->
												<li>Level: <?php echo $studentUser->roles[0] ?></li>
												
												<?php 	$user_meta = $wpdb->get_row("SELECT * FROM aq_usermeta WHERE wp_user_id = '".$student->aq_student_id."' LIMIT 1"); 
														//print_r($user_meta);
														$user_token = $user_meta->user_token_id;
												?>
												
												<li><a href="/profile/?user=<?php echo $user_token; ?>">View work</a></li>
												<li>
													<form action="<?php echo $_SERVER['REQUEST_URI'] ?>" class="remove-student" method="post" accept-charset="utf-8">
														<button type="submit"  name="remove-student">Remove Student</button>
														<input type="hidden" name="class-id" value="<?php echo $student->aq_class_id;?> ">
														<input type="hidden" name="student-id" value="<?php echo $student->aq_student_id;?> ">

													</form>
												</li>
											</ul>
										</div>

										<?php endforeach; ?>
									</section>
									
								</article>
					<?php	}
						}?>
					</section>
				</section>
	</section><!-- #main -->

<?php get_footer(); ?>