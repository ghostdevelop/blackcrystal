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
			add_action( 'pre_get_posts', array(&$this, 'gallery_posts_per_page' ));	
			add_action( 'after_setup_theme', array(&$this, 'set_languages' ));	
			add_filter( 'logout_url', array(&$this, 'logout_url'), 10, 2 );			

			$this->init();					
		}
		
		public function init(){
			if (class_exists("wCore")){
				wCore::get_dir('class', false, dirname(__FILE__));			
				wCore::get_dir('post-types', false, dirname(__FILE__));
				wCore::get_dir('widgets', false, dirname(__FILE__));							
			}				
			
		}	
		
		function set_languages(){
		    load_theme_textdomain( 'blackcrystal', get_template_directory() . '/languages' );
		}				
		
		public function logout_url($logout_url, $redirect){
			return $logout_url . '&redirect_to=' . home_url();
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
			register_setting('theme-group', 'page_sale'); 		
			register_setting('theme-group', 'page_gift'); 
			register_setting('theme-group', 'page_actuality'); 	
			register_setting('theme-group', 'page_subtitle'); 	
			register_setting('theme-group', 'page_shipping'); 	
			register_setting('theme-group', 'callback_form'); 	
			register_setting('theme-group', 'writeus_form'); 	
			register_setting('theme-group', 'kh_logo'); 	
			register_setting('theme-group', 'video_form'); 	
			register_setting('theme-group', 'google_analytics'); 	
		}	
		
		public function images_setup(){		
			add_theme_support( 'wc-product-gallery-zoom' );
			add_theme_support( 'wc-product-gallery-lightbox' );
			add_theme_support( 'wc-product-gallery-slider' );		
			add_theme_support( 'post-thumbnails' );			
		
			//Add image sizes
			add_image_size( 'home-gallery-thumb', 520, 300, true );					
			add_image_size( 'gallery-thumb', 290, 220, true );					
		}	

		public function nav_menus_setup() {
			register_nav_menu( 'top-menu', __( 'Top menu', 'blackcrystal' ) );
			register_nav_menu( 'header-menu', __( 'Header menu', 'blackcrystal' ) );
			register_nav_menu( 'header-nav-menu', __( 'Header nav menu', 'blackcrystal' ) );
		}
		

		
		function loginout_menu_link( $items, $args ) {
		   if ($args->theme_location == 'header-menu') {
		      if (is_user_logged_in()) {
		         $items .= '<li class=""><a href="'. get_the_permalink(woocommerce_get_page_id('myaccount')) .'">'.__('My Account', 'blackcrystal').'</a></li>';
		         $items .= '<li class=""><a href="'. wp_logout_url(home_url()) .'">'.__('Logout', 'blackcrystal').'</a></li>';
		      } else {
		         $items .= '<li class=""><a href="'. get_the_permalink(woocommerce_get_page_id('myaccount')) .'?action=login">'.__('Log in', 'blackcrystal').'</a></li>';
		         $items .= '<li class=""><a href="'. get_the_permalink(woocommerce_get_page_id('myaccount')) .'">'.__('Register', 'blackcrystal').'</a></li>';
		         $items .= '<li class=""><a href="'. wp_lostpassword_url() .'">'.__('Lost Password', 'blackcrystal').'</a></li>';
		      }
		   }
		   return $items;
		}	
		
		function polylang_search_normalize( $query ) {
		    if ( $query->is_search()) {
		        $query->query_vars['tax_query'] = array();
		    }
		}	
				
		function gallery_posts_per_page( $query ) {
		   if( !is_admin() && $query->is_main_query() && is_post_type_archive( 'gallery' ) ) {
		        $query->set( 'posts_per_page', '-1' );
		    }
		}		
		
	}
}

$ThemeFramework = new ThemeFramework();