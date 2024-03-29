<!DOCTYPE html>
<!--[if IE 7]>
<html class="ie ie7" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 8]>
<html class="ie ie8" <?php language_attributes(); ?>>
<![endif]-->
<!--[if !(IE 7) | !(IE 8)  ]><!-->
<html <?php language_attributes(); ?>>
<!--<![endif]-->
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<meta name="viewport" content="width=device-width" />
<title><?php wp_title( '|', true, 'right' ); ?> <?php bloginfo('name'); ?></title>
<link rel="profile" href="http://gmpg.org/xfn/11" />
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
<script type="text/javascript" src="//use.typekit.net/anb1nws.js"></script>
<script type="text/javascript">try{Typekit.load();}catch(e){}</script>
<script type="text/javascript">
var theme_dir = "<?php echo get_theme_root(); ?>";
var theme_url = "<?php echo get_template_directory_uri() ?>";
var theme_branch = "<?php if($_GET['theme']) echo $_GET['theme']; else echo "dev"; ?>";
</script>
<script src="http://beta.openbadges.org/issuer.js"></script>
<!--[if lt IE 9]>
<script src="<?php echo get_template_directory_uri(); ?>/js/html5shiv.js" type="text/javascript"></script>
<![endif]-->
<?php wp_head(); ?>
</head>


<?php
global $pending_reviews;
global $current_user; get_currentuserinfo();
global $section;
global $view;
?>

<?php
if(is_page()) { $page_slug = 'page-'.$post->post_name; }
elseif($_GET['s']) {}
elseif(get_post_meta($post->ID, 'badge_type', true)) $section .= " single-".get_post_meta($post->ID, 'badge_type', true);


?>
<body <?php body_class($page_slug ." ". $section); ?>>
<div id="container">
	<header>
		<div id="main-nav">
				<h1 id="branding"><a href="/">Aquapons</a></h1>
				<ul id="navigation">
					<li class="badges <?php if($section=='badges') echo 'selected'; ?>">
						<a href="http://aquapons.info/badges-overview/">Badges</a>					
						<div class="sub-nav">
							<ul>
								<li><a href="http://aquapons.info/badges/aquapons-badges/">Aquapons</a></li>
								<li><a href="http://aquapons.info/badges/skills-badges/">Skills</a></li>
								<!-- <li><a href="http://aquapons.info/badges/my-badges/">Mine</a></li> -->
							</ul>
						</div>	
					</li>
					
					<li class="community <?php if($section=='community') echo 'selected'; ?>">
						<a href="http://aquapons.info/community/">Community</a>						
<!--
						<div class="sub-nav">
							<ul>
								<li><a href="http://aquapons.info/community/institutions/">Groups/Institutions</a></li>
								
							</ul>
						</div>
-->
					</li>
					<li class="resources <?php if($section=='resources') echo 'selected'; ?>">
						<a href="http://aquapons.info/resources/">Resources</a>						
						<div class="sub-nav">
							<ul>
								<li><a href="/tutorials/">Tutorials</a></li>
								<li><a href="/forum/">Forum</a></li>
								<li><a href="/library/">Library</a></li>
								<li><a href="/jobs/">Jobs</a></li>
							</ul>
						</div>
					</li>
					<li class="about <?php if($section=='about') echo 'selected'; ?>">
						<a href="http://aquapons.info/about/">About</a>
					</li>

				</ul>
				
				<ul id="profile">
					<?php if ( is_user_logged_in() ) { ?>
					
					<?php
					global $user_level, $wpdb;
						if($current_user->roles[0]=='instructor'){
						
						$all_students = $wpdb->get_results("SELECT aq_student_id FROM aq_class_roster WHERE aq_instructor='".$current_user->ID."'");
						//print_r($all_students);
						
						$studentArray = array();
						foreach($all_students as $student)
							if(!in_array($student->aq_student_id, $studentArray)) 
								array_push($studentArray, $student->aq_student_id);
						
						$ids = join(',',$studentArray);
						$pending_reviews = $wpdb->get_var( "SELECT COUNT(*) FROM aq_badge_submissions WHERE current_status = 'reviewing' AND user_id IN ($ids)" );
						//$pending_reviews = $wpdb->query("SELECT id FROM aq_badge_submissions WHERE current_status = 'reviewing' ORDER BY submission_timestamp"); 
						?>
							<li class="submissions <?php if($section=='submissions') echo 'selected'; ?>">
							<a href="http://aquapons.info/review/">
								Submissions
								<?php if($pending_reviews) { ?>
									<span class="submission_count"><?php echo $pending_reviews ?></span>
								<?php } ?>	
							</a>
						</li>	
						<li class="class"><a href="http://aquapons.info/class?new">Your Classes</a></li>
					<?php }elseif($user_level > 8 ) {
						$pending_reviews = $wpdb->query("SELECT id FROM aq_badge_submissions WHERE current_status = 'reviewing' ORDER BY submission_timestamp"); 
					?>
						<li class="submissions <?php if($section=='submissions') echo 'selected'; ?>">
							<a href="http://aquapons.info/review/">
								Submissions
								<?php if($pending_reviews) { ?>
									<span class="submission_count"><?php echo $pending_reviews ?></span>
								<?php } ?>	
							</a>
						</li>
						<li class="class"><a href="http://aquapons.info/class?new">Your Classes</a></li>

					<?php } ?>
					
					<li><a href="/profile/">My Profile</a></li>
					<li>or</li>
					<li><a href="<?php echo wp_logout_url( home_url() ); ?>">Log Out</a></li>
					<?php } else { ?> 
					<li><a href="/sign-in/?theme=<?php if($_GET['theme']) echo $_GET['theme']; else echo 'dev'; ?>">Sign In</a></li> 
					<li>or</li>
					<li><a href="/sign-up/">Sign Up</a></li>
					<?php } ?>
				</ul>
		</div><!--#main-nav-->
		

		<?php
		if($view!=null) $headerPath = "/templates/".$section."-".$view."-header.php"; 
		else if($section) $headerPath = "/templates/".$section."-header.php";
		else $headerPath = "/templates/default-header.php";
		include(get_template_directory() . $headerPath);
		?>
	</header><!--header-->
	