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
var theme_branch = "<?php echo $_GET['theme']; ?>";
</script>
<!-- <script src="http://beta.openbadges.org/issuer.js"></script> -->
<!--[if lt IE 9]>
<script src="<?php echo get_template_directory_uri(); ?>/js/html5shiv.js" type="text/javascript"></script>
<![endif]-->
<?php wp_head(); ?>
</head>


<?php
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
								<li><a href="http://aquapons.info/badges/my-badges/">Mine</a></li>
							</ul>
						</div>	
					</li>
					
					<li class="community <?php if($section=='community') echo 'selected'; ?>">
						<a href="http://aquapons.info/community/">Community</a>						
						<div class="sub-nav">
							<ul>
								<li><a href="http://aquapons.info/community/institutions/">Groups/Institutions</a></li>
								<li><a href="http://aquapons.info/review/">Peer Evaluations</a></li>
							</ul>
						</div>
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
					<li><a href="/profile/">My Profile</a></li>
					<li>or</li>
					<li><a href="<?php echo wp_logout_url( home_url() ); ?>">Log Out</a></li>
					<?php } else { ?> 
					<li><a href="/sign-in/">Sign In</a></li> 
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
	