<?php


function getBadgeStatus($badge_id, $dbresults = null) {
	if(!$dbresults) {
		global $current_user, $wpdb; 
		get_currentuserinfo();
		$dbresults = $wpdb->get_results("SELECT * FROM aq_badge_status WHERE user_id = '".$current_user->ID."'"); 
	}
	foreach($dbresults as $badge_status) {
		if($badge_status->badge_id == $badge_id) return $badge_status->status;
	}
	return 0;
}




function breadcrumb($curr_post) {
	echo "<ul class='breadcrumb'>";
	$link = "<li> ‹ <a href='%s'>%s</a>";
    $parent_id  = $curr_post->post_parent;  
    $breadcrumbs = array();  
    $delimiter = " </li> ";
    
    while($parent_id) {  
        $page = get_page($parent_id);  
        $url = get_permalink($page->ID);
        $breadcrumbs[] = sprintf($link, $url, get_the_title($page->ID));  
        $parent_id  = $page->post_parent;  
    }  
    $breadcrumbs = array_reverse($breadcrumbs);  
    for ($i = 0; $i < count($breadcrumbs); $i++) {  
        echo $breadcrumbs[$i];  
        if ($i != count($breadcrumbs)-1) echo $delimiter;  
    }  
    $before = '<li> ‹ <a href="'.get_permalink($curr_post->ID).'" >';
    $after = '</li></a>';
    echo $delimiter . $before . get_the_title($curr_post->ID) . $after; 
    echo "</ul>";
}


function badge_level_name($badge_level_num) {
	if($badge_level_num == 1) echo "Junior Apprentice";
	if($badge_level_num == 2) echo "Senior Apprentice";
	if($badge_level_num == 3) echo "Journeymon";
	if($badge_level_num == 4) echo "Master";
}

	
?>