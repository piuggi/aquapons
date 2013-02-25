<?php

function breadcrumb($curr_post) {
	$link = "<a href='%s'>%s</a>";
    $parent_id  = $curr_post->post_parent;  
    $breadcrumbs = array();  
    $delimiter = " > ";
    
    while($parent_id) {  
        $page = get_page($parent_id);  
        $breadcrumbs[] = sprintf($link, get_permalink($page->ID), get_the_title($page->ID));  
        $parent_id  = $page->post_parent;  
    }  
    $breadcrumbs = array_reverse($breadcrumbs);  
    for ($i = 0; $i < count($breadcrumbs); $i++) {  
        echo $breadcrumbs[$i];  
        if ($i != count($breadcrumbs)-1) echo $delimiter;  
    }  
    echo $delimiter . $before . get_the_title($curr_post->ID) . $after; 
}

/*
**
*/

class themeCheck {
	
	public $theme = false;
	public $themeUrl;
	
	function __construct(){
		if(isset($_GET["theme"])){
			
			$this->theme=true;
			$this->themeUrl = "?theme={$_GET['theme']}";
			
		}
		
	}
	
	function url(){
		 if($this->theme) echo $this->themeUrl;
	}
	
}
	
?>