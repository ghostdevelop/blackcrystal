<?php 
	if( !is_admin() ):
	        add_filter('pre_get_posts','search_filter',10,1);
	endif;
	 
	function search_filter($query){
	 
	        $general_site_search = filter_input(INPUT_GET, 's', FILTER_SANITIZE_STRING);
	 
	        if(!empty($general_site_search)):
	                add_filter( 'posts_search', '__adapted_search_function', 500, 2 );
	        endif;
	}
	 
	function __adapted_search_function($search, $query) {
	  if(is_admin() || !$query->is_main_query() || !$query->is_search)
	    return; //determine if we are modifying the right query

	  $search_term = $query->get('s');

	  global $wpdb;
	  
	  if (isset($_GET['video-search']) && $_GET['sku']){
		  $search = ' AND ((';
		 	  	 
		  $search .= "($wpdb->postmeta.meta_key = '_sku' AND $wpdb->postmeta.meta_value LIKE '%$search_term%')";
		  //add the filter to join, sql will error out without joining the tables to the query
		  
		  $search .= '))';
		  /*
		  $search .= " AND ";
		  
		  $search .= "(pma.meta_key = '_video' AND pma.meta_value <> '0') AND (pma.meta_key = '_video' AND pma.meta_value <> '') ";	  
	  	  */
	  } elseif (isset($_GET['video-search']) && $_GET['dek']){
		  $search = ' AND ((';
		 	  	 
		  $search .= "($wpdb->postmeta.meta_key = '_design' AND $wpdb->postmeta.meta_value LIKE '%$search_term%')";
		  //add the filter to join, sql will error out without joining the tables to the query
		  
		  $search .= '))';
		  
		  $search .= " AND ";
		  
		  $search .= "(pma.meta_key = '_video_id' AND pma.meta_value <> '0') AND (pma.meta_key = '_video_id' AND pma.meta_value <> '') ";	  
	  	  	  
	  
	  } else {
		  $search = ' AND ((';
		 
		  //point 1
		  $search .= "($wpdb->posts.post_title LIKE '%$search_term%')";
		 
		  //need to add an OR between search conditions
		  $search .= " OR ";
		 
		  //point 2
		  $search .= "($wpdb->posts.post_excerpt LIKE '%$search_term%')";
		  
		  //need to add an OR between search conditions
		  $search .= " OR ";
		  
		  //point 3
		  $search .= "($wpdb->posts.post_content LIKE '%$search_term%')";
		  
	 
		  //need to add an OR between search conditions
		  $search .= " OR ";
		 
		  $search .= "($wpdb->postmeta.meta_key = '_sku' AND $wpdb->postmeta.meta_value LIKE '%$search_term%')";
		 
		  //add the filter to join, sql will error out without joining the tables to the query
	
		  $search .= '))';  
	  }

	  
	  add_filter('posts_join', '__custom_join_tables', 10 ,2);
	  add_filter( 'posts_groupby', 'my_posts_groupby' );
	  
	  return $search;
	}
	
	function my_posts_groupby($groupby) {
	    global $wpdb;
	    $groupby = "{$wpdb->posts}.ID";
	    return $groupby;
	}	
	 
	function __custom_join_tables($joins, $query) {
	  global $wpdb;
	  	if ($query->is_search()){
		  	$joins .= "JOIN $wpdb->postmeta ON ($wpdb->postmeta.post_ID = $wpdb->posts.ID)";	  	
	  	}
	  	
		if (isset($_GET['video-search']) && $_GET['dek']){
			$joins .= "JOIN $wpdb->postmeta AS pma ON (pma.post_ID = $wpdb->posts.ID)";
		}
	  	  
	  return $joins;
	}