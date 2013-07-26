<?php $section = 'class'; ?>
<?php get_header(); ?>

	<section id="main" class="class">
			<section id="overview">
					<section id="form" <?php if(!isset($_GET['new']) )echo 'style="display:none;" ';?> >
						<h2>Create a Class</h2>
						<?php if(is_user_logged_in()): ?>
						<form id="new_class" action="<?php echo $_SERVER['REQUEST_URI'] ?>" method="post" accept-charset="utf-8">
							<input id="title" type="text" name="title" placeholder="Enter the name of this class...">
							<?php 
								$classTypes = array('agriculture'=> 'Agriculture',
													'biology'=>'Biology',
													'math'=>'Math', 
													'technology'=> 'Technology', 
													'fabrication'=>'Fabrication', 
													'language-arts'=>'Language Arts');
								//$cats = get_categories($cats_args); 
							?>

							<select id="category" name="category">
								<option value="">Class Content Area</option>
								<?php foreach($classTypes as $typeKey=>$typeVal): ?>
								<option value="<?php echo $typeKey ?>"><?php echo $typeVal ?></option>
								<?php endforeach; ?>
							</select>
							<input id="location" class="half-input" type="text" name="location" placeholder="Where does the class meet?" />
							and
							<input id ="time" class="half-input" type="text" name="time" placeholder="When does it meet?"/>
							<input type="submit" value="Register">
						</form>
						<?php else: ?>
						
						<p><a href='/sign-in?redirect=<?php echo $_SERVER['REQUEST_URI']; ?>'>You Must Log in to post a question</a></p>						
						<?php endif;?>
					</section>
					<header></header>
					<footer><p id="ask">Register</p></footer>
				</section><!--#Overview-->	
	</section><!-- #main -->

<?php get_footer(); ?>