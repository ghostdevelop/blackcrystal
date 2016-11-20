<?php 


if(!class_exists('ThemeFramework')) {
	
	class ThemeFramework{
		
		public function __construct(){
			add_action( 'init', array(&$this, 'images_setup' ));
			add_action( 'init', array(&$this, 'nav_menus_setup' ));
			add_action('admin_menu', array(&$this, 'create_pages'));		
			add_action('admin_init', array(&$this, 'register_settings') );	
			add_filter( 'wp_nav_menu_items', array(&$this, 'loginout_menu_link'), 10, 2 );		
			add_action( 'pre_get_posts', array(&$this, 'polylang_search_normalize' ));	

			$this->init();					
		}
		
		public function init(){
			if (class_exists("wCore")){
				wCore::get_dir('class', false, dirname(__FILE__));			
				wCore::get_dir('post-types', false, dirname(__FILE__));
				wCore::get_dir('widgets', false, dirname(__FILE__));							
			}				
		}		
		
		public function logout_url(){
		  wp_redirect( home_url() );
		  exit();
		}		
		
		public function create_pages(){
			add_menu_page('Téma beállítások', 'Téma beállítások', 'administrator', __FILE__, array(&$this, 'theme_settings_page'),'dashicons-welcome-view-site', 998);			
		}
		
		public function theme_settings_page(){
			include(sprintf("%s/admin-templates/theme-options.php", dirname(__FILE__)));	
		}
		
		public function register_settings(){
			register_setting('theme-group', 'page_video'); 
			register_setting('theme-group', 'page_kontakt'); 	
		}	
		
		public function images_setup(){		
			add_theme_support( 'post-thumbnails' );			
		
			//Add image sizes
			add_image_size( 'home-gallery-thumb', 520, 300, true );					
		}	

		public function nav_menus_setup() {
			register_nav_menu( 'top-menu', __( 'Top menu', 'blackcrystal' ) );
			register_nav_menu( 'header-menu', __( 'Header menu', 'blackcrystal' ) );
			register_nav_menu( 'header-nav-menu', __( 'Header nav menu', 'blackcrystal' ) );
		}
		

		
		function loginout_menu_link( $items, $args ) {
		   if ($args->theme_location == 'header-menu') {
		      if (is_user_logged_in()) {
		         $items .= '<li class=""><a href="'. get_the_permalink(woocommerce_get_page_id('myaccount')) .'">'.__('My Account', 'woocommerce').'</a></li>';
		         $items .= '<li class=""><a href="'. wp_logout_url(home_url()) .'">'.__('Logout', 'woocommerce').'</a></li>';
		      } else {
		         $items .= '<li class=""><a href="'. get_the_permalink(woocommerce_get_page_id('myaccount')) .'">'.__('Log in', 'woocommerce').'</a></li>';
		         $items .= '<li class=""><a href="'. get_the_permalink(woocommerce_get_page_id('myaccount')) .'">'.__('Register', 'woocommerce').'</a></li>';
		         $items .= '<li class=""><a href="'. wp_lostpassword_url() .'">'.__('Lost Password', 'woocommerce').'</a></li>';
		      }
		   }
		   return $items;
		}	
		
		function polylang_search_normalize( $query ) {
		    if ( $query->is_search()) {
		        $query->query_vars['tax_query'] = array();
		    }
		}		
		
	}
}

$ThemeFramework = new ThemeFramework();

if (SIMPLE_SHOP == false){
	
	add_filter('woocommerce_get_price', 'get_custom_price', 10, 2);
	/**
	 * custom_price_WPA111772 
	 *
	 * filter the price based on category and user role
	 * @param  $price   
	 * @param  $product 
	 * @return 
	 */
	function get_custom_price($price, $product) {
	    if (!is_user_logged_in()) return $price;
	
		if (get_user_meta(get_current_user_id(), '_show_customer_price', true) == true){
			$pref = get_user_meta(get_current_user_id(), '_preference', true);
			$cp = get_user_meta(get_current_user_id(), '_customer_price', true);
	        //give user 10% of	
	        if ($pref > 0){
				$price = $price * ((100 - $pref) / 100);
				$price = $price * ((100 + $cp) / 100);
	        }	
		} else {
			$pref = get_user_meta(get_current_user_id(), '_preference', true);
	        //give user 10% of
	        if ($pref > 0) $price = $price * ((100 - $pref) / 100);		
		}
	
	            
	    return $price;
	}
	
	add_action( 'wp_ajax_display_price_action', 'display_price_action_hook' );
	add_action( 'wp_ajax_nopriv_display_price_action', 'display_price_action_hook' );
	
	function display_price_action_hook() {
	    // Handle request then generate response using WP_Ajax_Response
		if ($_POST['data'] == false){
			update_user_meta( get_current_user_id(), '_show_customer_price', true );	
		} else{
			update_user_meta( get_current_user_id(), '_show_customer_price', false );	
		}
	    
	    die();
	}
	
	
	// Hide prices
	add_action('after_setup_theme','activate_filter') ; 
	function activate_filter(){
		add_filter('woocommerce_get_price_html', 'show_price_logged');
	}
	
	function show_price_logged($price){
		if(is_user_logged_in() ){
			return $price;
	    } else {
		    remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart' );
		    remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 10 );
		    remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30 );
		    remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 10 );
		    return '<a class="havetologin" href="' . get_permalink(woocommerce_get_page_id('myaccount')) . '">'.__('Jelentkezz be az árak megtekintéséhez', 'blackcrystal').'</a>';
	    }
	}

}
