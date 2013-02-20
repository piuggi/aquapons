<?php the_post(); 
	$post_tags = wp_get_post_tags($post->ID);
	foreach($post_tags as $tag) {
		$tags .= ',"'.$tag->name.'"';
	}
	$tags = substr($tags, 1);
?>
{
  "name": "<?php echo get_the_title(); ?>",
  "description": "<?php echo strip_tags(get_field('badge_description', $badge_id)); ?>",
  "image": "<?php echo get_field('badge_image', $badge_id); ?>",
  "criteria": "<?php echo get_permalink(); ?>",
  "tags": [<?php echo $tags; ?>],
  "issuer": "http://aquapons.info/wp-content/json/organization.json"
}