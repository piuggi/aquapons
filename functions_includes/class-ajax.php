<?php 


	function userEmailExists() {
			//echo 'hello!';
			if(email_exists( $_POST['user_email'] )){ echo 'true';}
			else{ echo 'false';}
			
			die();	
	}
	add_action('wp_ajax_userEmailExists', 'userEmailExists');
	add_action('wp_ajax_nopriv_userEmailExists', 'userEmailExists');
?>