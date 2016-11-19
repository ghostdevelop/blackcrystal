<?php 
	if(!class_exists('METABOXES')) {

	    class METABOXES {
	    
		    public function __construct(){	
			    //add_action( 'admin_head-index.php', array(&$this,'dashboard_columns' ));
			    //add_action('admin_init', array(&$this, 'remove_dashboard_widgets'));	
			    add_action( 'admin_menu', array(&$this, 'remove_meta_boxes'), 999);		    
		    }
		    	
			function dashboard_columns() {
			    add_screen_option('layout_columns',array('max' => 2, 'default' => 2));
		    }	
		    
			function remove_dashboard_widgets() {
				remove_meta_box('dashboard_quick_press', 'dashboard', 'normal');   // right now
				remove_meta_box('dashboard_primary', 'dashboard', 'normal');   // right now
				remove_meta_box('dashboard_right_now', 'dashboard', 'normal');   // right now
				remove_meta_box('dashboard_activity', 'dashboard', 'normal');   // right now
				remove_meta_box('wpsc_dashboard_news', 'dashboard', 'normal');   // right now		
			}
			
			function remove_meta_boxes() {
			    //remove_meta_box('tagsdiv-post_tag', 'post', 'core');
			    //remove_meta_box('categorydiv', 'post', 'core');
			    remove_meta_box('commentstatusdiv', 'post', 'core');
			    remove_meta_box('commentstatusdiv', 'page', 'core');
			    remove_meta_box('commentsdiv', 'post', 'core');
			    remove_meta_box('commentsdiv', 'page', 'core');
			    remove_meta_box('postcustom', 'post', 'core');
			    remove_meta_box('postcustom', 'page', 'core');
			    remove_meta_box('trackbacksdiv', 'post', 'core');
			    remove_meta_box('slugdiv', 'post', 'core');
			    remove_meta_box('slugdiv', 'page', 'core');
			    remove_meta_box('authordiv', 'post', 'core');
			    remove_meta_box('authordiv', 'page', 'core');
			    remove_meta_box('revisionsdiv', 'page', 'core');
			    remove_meta_box('revisionsdiv', 'page', 'core');
			    //remove_meta_box('pageparentdiv', 'page', 'core');
			    remove_action( 'admin_init', 'sharing_add_meta_box' );
			}	
			
			public function add_meta_box( $post_type ) {
			/*
				add_meta_box('gallery_box',__( 'Galéria', 'webconcept_textdomain' ), 'GalleryMetabox::metabox' , 'page','normal'	,'low'	);
				add_meta_box('location_box',__( 'Hely', 'webconcept_textdomain' ), 'LocationMetabox::metabox' , 'page'	,'side'	,'low'	);
				add_meta_box('description_box', __( 'Rövid leírás', 'webconcept_textdomain' ), 'DescriptionMetabox::metabox', 'page' ,'normal'	,'high'	);			
				add_meta_box('youtube_box', __( 'Videók', 'webconcept_textdomain' ), 'YoutubeMetabox::metabox', 'page' ,'normal'	,'high'	);	
			*/		
			}								    	    						
		}
	}
	
	if (class_exists('METABOXES')){
		$METABOXES = new METABOXES();
	}
?>