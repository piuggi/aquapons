<?php 
header('Cache-Control: no-cache, must-revalidate');
header('Content-type: application/json');
	
the_post(); 
$post_tags = wp_get_post_tags($post->ID);
foreach($post_tags as $tag) {
	$tags .= ',"'.$tag->name.'"';
}
$tags = substr($tags, 1);

// RECIPIENT/ASSERTION JSON 
if($_GET['user_token']) { 

	$user_token = $_GET['user_token'];
	
	$user_meta = $wpdb->get_row("SELECT wp_user_id FROM aq_usermeta WHERE user_token_id = '".$user_token."' LIMIT 1");
	$user_info = get_userdata($user_meta->wp_user_id);
	

	$badge_submission = $wpdb->get_row("SELECT * FROM aq_badge_status WHERE user_id = '".$user_meta->wp_user_id."' AND badge_id = '".get_the_ID()."' AND status = 'complete' LIMIT 1");
	
	if($badge_submission->status != "complete") {
		echo "You have not completed this badge.";
		die();
	}
	
	
	$date_awarded = $badge_submission->updated;
	$date_awarded = date("U", strtotime($date_awarded));

	global $wpdb;

	
    $salt = basename(get_permalink());
    $hashed_email = 'sha256$' . hash('sha256', $user_info->user_email . $salt);//hash('sha256', $user_info->user_email . $salt);



?>
{ 
  "uid": "<?php echo $salt."-".$user_token; ?>",
  "recipient": {
    "type": "email",
    "hashed": true,
    "salt": "<?php echo $salt; ?>",
    "identity": "<?php echo $hashed_email; ?>"
  },
  "image": "<?php echo get_field('badge_image', $badge_id); ?>",
  "evidence": "<?php echo get_permalink(); ?>?user_token=<?php echo $user_token; ?>",
  "issuedOn": "<?php echo $date_awarded; ?>",
  "badge": "<?php echo get_permalink(); ?>?json=true",
  "verify": {
    "type": "hosted",
    "url": "<?php echo get_permalink(); ?>?json=true&user_token=<?php echo $user_token; ?>"
  }
}
<?php 
}



// BADGE JSON 
else {

$title = get_the_title();
$title = preg_replace('/(\s)*&#8212;(\s)*/', ', ', $title);
$title = preg_replace('/\s\s/', ' ', $title);

$description = strip_tags(get_field('badge_objectives', $badge_id));
$description = trim($description);
$description = preg_replace('/\s\s/', ' ', $description);
$description = preg_replace('/\n/', '; ', $description);
$description = html_entity_decode($description);

?>
{
  "name": "<?php echo $title; ?>",
  "description": "<?php echo $description; ?>",
  "image": "<?php echo get_field('badge_image', $badge_id); ?>",
  "criteria": "<?php echo get_permalink(); ?>",
  <?php //"tags": [<?php echo $tags; ? >], ?>
  "issuer": "http://aquapons.info/wp-content/json/organization.json",
  "alignment": [
    { "name": "CCSS.ELA-Literacy.RST.11-12.3",
      "url": "http://www.corestandards.org/ELA-Literacy/RST/11-12/3",
      "description": "Follow precisely a complex multistep procedure when carrying out experiments, taking measurements, or performing technical tasks; analyze the specific results based on explanations in the text."
    },
    { "name": "CCSS.ELA-Literacy.RST.11-12.9",
      "url": "http://www.corestandards.org/ELA-Literacy/RST/11-12/9",
      "description": " Synthesize information from a range of sources (e.g., texts, experiments, simulations) into a coherent understanding of a process, phenomenon, or concept, resolving conflicting information when possible."
    }
  ]
}
<?php } 
	
	
function decode_entities($text) {
    $text= html_entity_decode($text,ENT_QUOTES,"ISO-8859-1"); #NOTE: UTF-8 does not work!
    $text= preg_replace('/&#(\d+);/me',"chr(\\1)",$text); #decimal notation
    $text= preg_replace('/&#x([a-f0-9]+);/mei',"chr(0x\\1)",$text);  #hex notation
    return $text;
}
	
	
	
?>