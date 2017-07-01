<?php 
	if(!class_exists('METABOXES')) {

	    class METABOXES {
	    
		    public function __construct(){	
			    //add_action( 'admin_head-index.php', array(&$this,'dashboard_columns' ));
			    //add_action('admin_init', array(&$this, 'remove_dashboard_widgets'));	
			    add_action( 'admin_menu', array(&$this, 'remove_meta_boxes'), 999);		
				add_action( 'add_meta_boxes_page', array(&$this, 'select_product_metabox' ));	
				add_action( 'save_post', array(&$this, 'product_select_save' ));					
				add_action( 'wp_ajax_products_select_get_products', array(&$this, 'products_select_get_products' ));						        
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
//			    remove_meta_box('slugdiv', 'post', 'core');
//			    remove_meta_box('slugdiv', 'page', 'core');
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
			
			function select_product_metabox() {
			    global $post;
			    if ( 'landing.php' == get_post_meta( $post->ID, '_wp_page_template', true ) ) {
					add_meta_box(
	                 'product_meta', // $id
	                 __('Kapcsolódó termékek', 'blackcrystal'), // $title
	                 array(&$this, 'display_product_information'), // $callback
	                 'page', // $page
	                 'normal', // $context
	                 'high'); // $priority
				    }
			}
			
			function display_product_information(){
				require_once(dirname(dirname(__FILE__)) . '/metaboxes/select-product.php');
			}
			
			function product_select_save( $post_id ) {
			
			    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) 
			    return;
			
			    if ( !wp_verify_nonce( $_POST['product-select-nonce'], 'product-select') )
			    return;
			
			    if ( 'page' == $_POST['post_type'] ) {
			        if ( !current_user_can( 'edit_page', $post_id ) )
			        return;
			    } else {
			        if ( !current_user_can( 'edit_post', $post_id ) )
			        return;
			    }
			    
			    $cat = (int) $_POST['product-cat-select'];
			    $prod =  serialize($_POST['product-select']);
			    
			    update_post_meta( $post_id, 'product-cat-select', $cat );
			    update_post_meta( $post_id, 'product-select', $prod );
			}		
			
			function products_select_get_products() {
				$args = array(
				    'post_type' => 'product',
				    's' => $_GET['q'],
				    'posts_per_page' => 20,
				    'offset' => $_GET['offset'],
				    'post_status' => 'publish',
				    'orderby'     => 'title', 
				    'order'       => 'ASC'        
				);
				
				$wp_query = new WP_Query($args);
				
				if ($wp_query->have_posts()):
					while ($wp_query->have_posts()): $wp_query->the_post();
						$data[] = array('id' => get_the_ID(), 'text' => get_the_title());
					endwhile;
				else:
					$data[] = array('id' => '0', 'text' => 'No Products Found');
				endif;
			
				// return the result in json
				echo json_encode($data);
				
				die();
			
			}				
								    	    						
		}
	}
	
	if (class_exists('METABOXES')){
		$METABOXES = new METABOXES();
	}
