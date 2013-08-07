<?php
global $userid; 
$current_userdata = get_userdata($userid);
?>

<!-- LIGHTBOX -->
<script src="<?php echo get_template_directory_uri(); ?>/js/fancybox/jquery.fancybox-1.3.4.pack.js"></script>
<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/js/fancybox/jquery.fancybox-1.3.4.css" type="text/css" media="screen" />

<div id="secondary-nav">
	<section id="main-links">
		
		<div class="profile_pic">
			<?php if($profile_pic_id = get_user_meta($userid, 'profile_pic', 1)) { 
				echo wp_get_attachment_image( $profile_pic_id, 'profile-pic');
			} else {
				echo wp_get_attachment_image(2977, 'profile-pic'); // placeholder pic
			} ?>
			
			<?php if($current_user->ID == $userid) { ?>
			<div class="upload_profile_pic">
				<form id="profile_pic_form" action="#" method="post" enctype="multipart/form-data">
					<input type="file" name="profile_pic_picker" id="profile_pic_picker" />
					<label for="profile_pic_picker">UPLOAD</label>
				</form>
			</div>
			<?php } ?>
		</div>
		
		<h3><?php
		$user_role = $current_userdata->roles; 
		echo ucwords(str_replace("_", " ", $user_role[0])); ?>
		</h3>
		<h2 id="page-title"><?php echo $current_userdata->display_name; ?></h2>
		<hr>
		<ul>
			<li><a href="">Alerts</a></li>
			<li><a href="">Messages</a></li>
			<li><a href="">Active Discussions</a></li>
		</ul>
	</section><!--#main-links-->
	<section id="page-search">
		<hr>
		<ul>
			<li><a href="">Account Settings</a></li>
		</ul>
		
	</section>	<!--#page-search-->
</div><!--#secondary-nav-->