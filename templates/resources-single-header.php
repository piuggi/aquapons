<?php	$resource_type = get_post_meta($post->ID, 'resource_type', true);?>
<?php check_postComments();	?>


<ul class="breadcrumb">
	<li>‹ <a href="/resources"> Resources </a></li>
	<li>‹ <a href="/resources/<?php if($resource_type) {echo $resource_type; if(substr($resource_type, -1) != 's' )echo 's';}else echo 'Forum'; ?>"> <?php if($resource_type) { echo ucfirst($resource_type); if(substr($resource_type, -1) != 's' )echo 's';}else echo 'Forum'; ?> </a></li>
	<li>‹ <a class="strong" href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
</ul>
<?php //keep a count of the views for each discussion item
  $views =  get_post_meta($post_id, 'views', true); 
  $views++; update_post_meta($post_id, 'views', $views);
  
?>
