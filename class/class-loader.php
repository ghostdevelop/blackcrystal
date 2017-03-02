<?php 
	if(!class_exists('THEME_LOADER')) {
	
	    class THEME_LOADER {
	    
		    public function __construct(){
		    	add_action( 'wp_enqueue_scripts', array(&$this, 'front_scripts' ));
		    	add_action( 'wp_enqueue_scripts', array(&$this, 'register_scripts' ));
		    	add_action( 'admin_enqueue_scripts', array(&$this, 'admin_scripts' ));
		    	add_action( 'wp_enqueue_scripts', array(&$this, 'woocommerce_scripts_cleaner'), 99 );		
		    }
		    
		    function register_scripts(){

	    
		    }
		    
		    function register_styles(){
		    	//wp_register_style( $handle, $src, $deps, $ver, $media ); 			    
		    }
		    
		    function load_core_scripts(){

		    }
		    	
		    function admin_scripts(){
			    wp_enqueue_media();
		    }
		    
		    function front_scripts(){
		    	
		    	//Styles	    			    
				wp_enqueue_style( 'bootstrap.modal', get_template_directory_uri() . '/css/bootstrap.css', array(), false, '');	
				wp_enqueue_style( 'font-awesome');
				wp_enqueue_style( 'wyswyg');
				wp_enqueue_style( 'woocommerce', get_template_directory_uri() . '/css/woocommerce.css', array(), false, '');	
				wp_enqueue_style( 'woocommerce-layout', get_template_directory_uri() . '/css/woocommerce-layout.css', array(), false, '');	
				wp_enqueue_style( 'woocommerce-smallscreen', get_template_directory_uri() . '/css/woocommerce-smallscreen.css', array(), false, 'only screen and (max-width: 768px)');					
				wp_enqueue_style( 'animate', get_template_directory_uri() . '/css/animate.css', array(), false, '');			    
				wp_enqueue_style( 'swipebox.min', get_template_directory_uri() . '/css/swipebox.min.css', array(), false, '');			    
				wp_enqueue_style( 'extra_style', get_template_directory_uri() . '/css/extra_style.css', array(), false, '');			    
				wp_enqueue_style( 'grid_1170', get_template_directory_uri() . '/css/grid_1170.css', array(), false, '');			    
				wp_enqueue_style( 'styles', get_template_directory_uri() . '/css/styles.css', array(), false, '');			    
				wp_enqueue_style( 'superfish', get_template_directory_uri() . '/css/superfish.css', array(), false, '');			    
				wp_enqueue_style( 'camera', get_template_directory_uri() . '/css/camera.css', array(), false, '');			    
				wp_enqueue_style( 'style-name', get_stylesheet_uri() );
				wp_enqueue_style( 'responsive', get_template_directory_uri() . '/css/responsive.css', array(), false, '');			    
			   
				//wp_enqueue_style( 'sample', get_template_directory_uri() . '/css/sample.css', array(), false, '');			    
			   			   
 
			   
			   //Scripts
			   wp_enqueue_script( 'jquery');			    
			   wp_enqueue_script( 'jquery-ui-tooltip');			    
   
			   wp_enqueue_script( 'jquery-cookie');			    

			   wp_enqueue_script( 'jquery.isotope', get_template_directory_uri() . '/js/jquery.isotope.js', array('jquery'), '1.0.0', true );			    

			   wp_enqueue_script( 'jquery.swipebox.min', get_template_directory_uri() . '/js/jquery.swipebox.min.js', array('jquery'), '1.0.0', true );			    
			   wp_enqueue_script( 'j-carousel', get_template_directory_uri() . '/js/j-carousel.js', array('jquery'), '1.0.0', true );
			   wp_enqueue_script( 'jquery.easing.1.3', get_template_directory_uri() . '/js/jquery.easing.1.3.js', array('jquery'), '1.0.0', true );			    
			   wp_enqueue_script( 'superfish', get_template_directory_uri() . '/js/superfish.js', array('jquery'), '1.0.0', true );			    
			   wp_enqueue_script( 'scripts', get_template_directory_uri() . '/js/scripts.js', array('jquery'), '1.0.0', true );
				wp_localize_script( 
					'scripts', 'texts', 
					array(
						'not_enough' => __('Díszdoboz csak teljes készlethez érhető el', 'blackcrystal'),
						'low_order_amount_title' => __("Checkout error", 'blackcrystal'),
						'low_order_amount' => sprintf( __('You must have an order with a minimum of %s to place your order, your current order total is %s.', 'blackcrystal') , 
		                    	wc_price( get_option('minimum_amount') ), 
								wc_price( WC()->cart->cart_contents_total 
							)
						),
					) 
				);			   			    		    
			   wp_enqueue_script( 'camera', get_template_directory_uri() . '/js/camera.js', array('jquery'), '1.0.0', true );			    		    
			    
			   //wp_enqueue_script( 'init', get_template_directory_uri() . '/js/init.js', array('jquery'), '1.0.0', true );			    
		    }
		    
			function woocommerce_scripts_cleaner() {
				
				// Remove the generator tag
				remove_action( 'wp_head', array( $GLOBALS['woocommerce'], 'generator' ) );
				// Unless we're in the store, remove all the cruft!
			    
				if ( ! is_woocommerce() && ! is_cart() && ! is_checkout() ) {
					wp_dequeue_style( 'woocommerce_frontend_styles' );
					wp_dequeue_style( 'woocommerce-general');
					wp_dequeue_style( 'woocommerce-layout' );
					wp_dequeue_style( 'woocommerce-smallscreen' );
					wp_dequeue_style( 'woocommerce_fancybox_styles' );
					wp_dequeue_style( 'woocommerce_chosen_styles' );
					wp_dequeue_style( 'woocommerce_prettyPhoto_css' );
					wp_dequeue_style( 'select2' );
					wp_dequeue_script( 'wc-add-payment-method' );
					wp_dequeue_script( 'wc-lost-password' );
					wp_dequeue_script( 'wc_price_slider' );
					wp_dequeue_script( 'wc-single-product' );
					wp_dequeue_script( 'wc-add-to-cart' );
					wp_dequeue_script( 'wc-cart-fragments' );
					wp_dequeue_script( 'wc-credit-card-form' );
					wp_dequeue_script( 'wc-add-to-cart-variation' );
					wp_dequeue_script( 'wc-single-product' );
					wp_dequeue_script( 'wc-cart' );
					wp_dequeue_script( 'wc-chosen' );
					wp_dequeue_script( 'woocommerce' );
					wp_dequeue_script( 'prettyPhoto' );
					wp_dequeue_script( 'prettyPhoto-init' );
					wp_dequeue_script( 'jquery-blockui' );
					wp_dequeue_script( 'jquery-placeholder' );
					wp_dequeue_script( 'jquery-payment' );
					wp_dequeue_script( 'fancybox' );
					wp_dequeue_script( 'jqueryui' );
					
				}
				wp_deregister_script( 'wc-checkout' ); 
				wp_register_script( 'wc-checkout',get_template_directory_uri() . '/js/wc-checkout.js', array('jquery'), '1.0.0', true );				
			}
					    
	    }
	}
	
	if (class_exists('THEME_LOADER')){
		$THEME_LOADER = new THEME_LOADER();
	}
?>