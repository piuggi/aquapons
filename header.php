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
<script type="text/javascript">
var theme_dir = "<?php echo get_theme_root(); ?>";
var theme_url = "<?php echo get_template_directory_uri() ?>";
</script>
<script src="http://beta.openbadges.org/issuer.js"></script>
<!--[if lt IE 9]>
<script src="<?php echo get_template_directory_uri(); ?>/js/html5shiv.js" type="text/javascript"></script>
<![endif]-->
<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div id="container">

	
	
	
	<header>
		<div id="main-nav">
				<h1 id="branding"><a href="/">Aquapons</a></h1>
				<ul id="navigation">
					<li><a class="resources" href="http://aquapons.info/resources/">Resources</a></li>
					<li><a class="badges" href="http://aquapons.info/badges-overview/">Badges</a></li>
					<li><a class="community" href="http://aquapons.info/community/">Community</a></li>
					<li><a class="about" href="http://aquapons.info/about/">About</a></li>
				</ul>
				<ul id="profile">
					<li></li>
					<li><a href="">My Profile</a></li>
					<li><a href="">Log Out</a></li>
					<!-- 		OR 
					<li><a href="">Sign In</a></li> 
					<li>or</li>
					<li><a href="">Sign Up</a></li>
					-->
				</ul>
		</div><!--#main-nav-->
		<?php 
		global $section;
		include(get_template_directory() . "/templates/".$section."-header.php");
		?>
	</header><!--header-->
	