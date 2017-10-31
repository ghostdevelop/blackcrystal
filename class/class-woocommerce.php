<?php 
if(!class_exists('CustomWoo')) {

	class CustomWoo{
		
		public function __construct(){
		
			add_action( 'after_setup_theme', array(&$this, 'woocommerce_support' ));
			add_filter( 'woocommerce_enqueue_styles', '__return_false' );
			add_filter('loop_shop_columns', array(&$this, 'loop_columns'));
			add_filter( 'woocommerce_product_tabs', array(&$this, 'shipping_tab' ));	
			add_filter( 'woocommerce_checkout_fields' , array(&$this, 'override_checkout_fields' ));				
			add_filter( 'woocommerce_general_settings', array(&$this, 'add_pricing_option_fields' ), 10, 1);	
			add_filter( 'woocommerce_payment_gateways', array(&$this, 'add_card_gateway' ));
			add_action( 'woocommerce_thankyou', array(&$this, 'send_order'));
			add_filter( 'the_title', array($this, 'thankyou_title'), 10, 2 );			
			add_filter( 'woocommerce_cart_item_name', array($this, 'add_sku_in_cart'), 20, 3);
			add_filter( 'woocommerce_email_recipient_customer_refunded_order', array(&$this, 'refund_email_to_admin'), 10, 2);
			
			add_filter( 'woocommerce_ship_to_different_address_checked', '__return_false' );
			
			
			add_action( 'woocommerce_remove_cart_item', array(&$this, 'remove_additional_product'), 10, 2 );
			add_filter( 'woocommerce_get_cart_item_from_session', array(&$this, 'get_cart_items_from_session'), 1, 3 );			
			add_action(	'woocommerce_add_to_cart', array(&$this, 'add_cart_item'), 10, 6);		
			add_filter( 'woocommerce_add_cart_item', array(&$this, 'filter_woocommerce_add_cart_item'), 10, 1 ); 				
			add_action( 'woocommerce_add_order_item_meta', array(&$this, 'save_order_itemmeta'), 10, 3 );	
			add_filter( 'woocommerce_product_tabs', array(&$this, 'woo_rename_tabs'), 98 );		
			add_action( 'woocommerce_checkout_process',  array(&$this, 'minimum_order_amount') );
			add_action( 'woocommerce_before_cart' ,  array(&$this, 'minimum_order_amount') );					
			add_filter( 'woocommerce_get_availability_text', array(&$this, 'get_availability_text'), 98, 2 );		
			
									
			if (SIMPLE_SHOP == false){
				add_filter('woocommerce_get_price', array(&$this, 'get_custom_price'), 10, 2);
				add_action('after_setup_theme',array(&$this, 'activate_filter')) ; 
				add_action( 'wp_ajax_display_price_action', array(&$this, 'display_price_action_hook' ));
				add_action( 'wp_ajax_nopriv_display_price_action', array(&$this, 'display_price_action_hook' ));
			}

		
			/*		
			add_filter( 'woocommerce_cart_shipping_method_full_label', array(&$this, 'hide_shipping_name_on_cart'), 999, 2 );	
			add_action( 'woocommerce_before_checkout_form', array(&$this, 'apply_matched_coupons' ));
			add_action( 'woocommerce_before_cart', array(&$this, 'apply_matched_coupons' ));		
			
			*/	

		}
		
		function get_availability_text($availability, $obj){
		   if ( ! $obj->is_in_stock() ) {
		      $availability = __( 'Out of stock', 'blackcrystal' );
		    } elseif ( $obj->managing_stock() && $obj->is_on_backorder( 1 ) ) {
		      $availability = $obj->backorders_require_notification() ? __( 'Available on backorder', 'blackcrystal' ) : __( 'In stock', 'blackcrystal' );
		    } elseif ( $obj->managing_stock() ) {
		      switch ( get_option( 'woocommerce_stock_format' ) ) {
		        case 'no_amount' :
		          $availability = __( 'In stock', 'blackcrystal' );
		        break;
		        case 'low_amount' :
		          if ( $this->get_total_stock() <= get_option( 'woocommerce_notify_low_stock_amount' ) ) {
		            $availability = sprintf( __( 'Only %s left in stock', 'blackcrystal' ), $obj->get_total_stock() );
		
		            if ( $this->backorders_allowed() && $this->backorders_require_notification() ) {
		              $availability .= ' ' . __( '(also available on backorder)', 'blackcrystal' );
		            }
		          } else {
		            $availability = __( 'In stock', 'blackcrystal' );
		          }
		        break;
		        default :
		          $availability = sprintf( __( '%s in stock', 'blackcrystal' ), $obj->get_total_stock() );
		
		          if ( $obj->backorders_allowed() && $obj->backorders_require_notification() ) {
		            $availability .= ' ' . __( '(also available on backorder)', 'blackcrystal' );
		          }
		        break;
		      }
		    } else {
		      $availability = '';
		    }	
		    
		    return $availability;		
		}
		
		function minimum_order_amount() {
		    // Set this variable to specify a minimum order value
		    $minimum = get_option('minimum_amount');
		
		    if ( $minimum > 0 && WC()->cart->cart_contents_total < $minimum ) {
		
		        if( is_cart() ) {
		
		            wc_print_notice( 
		                sprintf( 'You must have an order with a minimum of %s to place your order, your current order total is %s.' , 
		                    wc_price( $minimum ), 
		                    wc_price( WC()->cart->cart_contents_total )
		                ), 'error' 
		            );
		
		        } else {
		
		            wc_add_notice( 
		                sprintf( 'You must have an order with a minimum of %s to place your order, your current order total is %s.' , 
		                    wc_price( $minimum ), 
		                    wc_price( WC()->cart->cart_contents_total )
		                ), 'error' 
		            );
		
		        }
		    }
		
		}			
		
		function woocommerce_support() {
		    add_theme_support( 'blackcrystal' );
		}			
		
		function thankyou_title( $title, $id ) {
			if ( is_order_received_page() && $id ===  woocommerce_get_page_id( 'checkout' ) ) {
				$title = __('Rendelés állapota','blackcrystal');
			}
			return $title;
		}

		function loop_columns() {
			return 3; // 3 products per row
		}	
		
		function refund_email_to_admin($recipient, $object) {
		    $recipient = $recipient . ', edit.blackcrystal.office@gmail.com, blackcrystal.office@gmail.com';
		    return $recipient;
		}	
		
		function woo_rename_tabs( $tabs ) {
		
			$tabs['description']['title'] = __( 'Leírás', 'blackcrystal');		// Rename the description tab
			$tabs['additional_information']['title'] = __( 'Termék adatok', 'blackcrystal' );	// Rename the additional information tab
		
			return $tabs;
		
		}			
		
		function shipping_tab( $tabs ) {
			
			// Adds the new tab
			
			$tabs['shipping-tab'] = array(
				'title' 	=> __( 'Shipping', 'blackcrystal' ),
				'priority' 	=> 50,
				'callback' 	=> array(&$this, 'shipping_tab_content')
			);
		
			$tabs['subtitle-tab'] = array(
				'title' 	=> __( 'Felirat', 'blackcrystal'),
				'priority' 	=> 50,
				'callback' 	=> array(&$this, 'subtitle_tab_content')
			);		
			return $tabs;
		
		}

		function add_card_gateway( $methods ) {
			$methods[] = 'WebcreativesCardPayment';
			return $methods;
		}
		
		function shipping_tab_content() {
			wc_get_template( 'single-product/tabs/shipping.php' );
			
		}	

		function subtitle_tab_content() {
			wc_get_template( 'single-product/tabs/subtitle.php' );
			
		}	
		
		function override_checkout_fields( $fields ) {
		     unset($fields['billing']['billing_state']);
		     unset($fields['shipping']['shipping_state']);
		
		     return $fields;
		}	
		
		function add_sku_in_cart( $title, $values, $cart_item_key ) {
		  $sku = $values['data']->get_sku();
		  
		  return $sku ? $title . " " . sprintf( __('(Termékkód: %s)', 'blackcrystal'), $sku) : $title;
		}			
				
		function filter_woocommerce_add_cart_item( $cart_item) { 
		    // make filter magic happen here... 
		    	if (isset($cart_item['package'])){
				    $cart_item['data']->post->post_title = sprintf(__("Díszdoboz a %d kódszámú termékhez", 'blackcrystal'), $cart_item['prod_id']);	    	
					$cart_item['data']->set_price( $cart_item['package'] );	
		    	}
		    
		    return $cart_item; 
		}
		
		function get_custom_price($price, $product) {
			
		    if (!is_user_logged_in()) return $price;
		    if ($product->get_sku() == "1000") return $price;
			
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
		
		            
		    return round($price);
		}
	
		function display_price_action_hook() {
		    // Handle request then generate response using WP_Ajax_Response
			if ($_POST['data'] == false){
				update_user_meta( get_current_user_id(), '_show_customer_price', true );	
			} else{
				update_user_meta( get_current_user_id(), '_show_customer_price', false );	
			}
		    
		    die();
		}

		function activate_filter(){
			add_filter('woocommerce_get_price_html', array( &$this, 'show_price_logged'));
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
		
		public function add_cart_item($cart_item_key, $product_id, $quantity, $variation_id, $variation, $cart_item_data) {
			if (isset($_POST['_package_price'])){	
				$ap = $_POST['_package_price'];			
				unset($_POST['_package_price']);
				$ipp = get_post_meta($product_id, '_item_per_pack_box', true);
				$qty = 0;
				
				if ($quantity % $ipp == 0){
					$qty = $quantity / $ipp;
					
					WC()->cart->add_to_cart(get_product_by_sku(1000), $qty, "", "", array('package' => $ap, 'prod_id' => get_post_meta($product_id, '_sku', true), 'CartItemKey' => $cart_item_key));	
				} else {
					wc_add_notice(__('Nem megfelelő a darabszám a kiegészítő termék hozzáadásához.'), 'error');
				}
								

			}

		    //return $cart_item;
		}
		
		function remove_additional_product($cart_item_key, $cart ){			
			foreach ($cart->cart_contents as $key => $item){
				if (isset($item['CartItemKey']) && $item['CartItemKey'] == $cart_item_key){		
					$cart->remove_cart_item($key);			
				}
			}
		
		}
		
		public function get_cart_items_from_session( $item, $values, $key ) {		

			if ($item['data']->id == get_product_by_sku(1000)){	
			    $item['data']->post->post_title = sprintf(__("Díszdoboz a %d kódszámú termékhez", 'blackcrystal'), $item['prod_id']);	    	
				$item['data']->set_price( $item['package'] );					
			}
			
		    return $item;
		}
		
		function save_order_itemmeta( $item_id, $values, $cart_item_key ) {		 
			if ( isset( $values['package'] ) ) {
				wc_add_order_item_meta( $item_id, 'package', $values['package'] );
			}
			if ( isset( $values['prod_id'] ) ) {
				wc_add_order_item_meta( $item_id, 'prod_id', $values['prod_id'] );
			}
		 
		}
		
		function hide_shipping_name_on_cart($label, $method){

			$label = "";
			
			if ( $method->cost > 0 ) {
			    if ( WC()->cart->tax_display_cart == 'excl' ) {
			        $label .= wc_price( $method->cost );
			        if ( $method->get_shipping_tax() > 0 && WC()->cart->prices_include_tax ) {
			            $label .= ' <small class="tax_label">' . WC()->countries->ex_tax_or_vat() . '</small>';
			        }
			    } else {
			        $label .= wc_price( $method->cost + $method->get_shipping_tax() );
			        if ( $method->get_shipping_tax() > 0 && ! WC()->cart->prices_include_tax ) {
			            $label .= ' <small class="tax_label">' . WC()->countries->inc_tax_or_vat() . '</small>';
			        }
			    }
			} elseif ( $method->id !== 'free_shipping' ) {
			    $label .= ' (' . __( 'Free', 'blackcrystal' ) . ')';
			}
			
			return $label;
		}					
		
		function add_pricing_option_fields( $settings ) {
		
			$updated_settings = array();
		
			foreach ( $settings as $section ) {
				
		   		// at the bottom of the General Options section
		
			   	if ( isset( $section['id'] ) && 'pricing_options' == $section['id'] && isset( $section['type'] ) && 'sectionend' == $section['type'] ) {
					$updated_settings[] = array(		
						'name'     => __( 'Bolt azonosító', 'blackcrystal' ),		
						'desc_tip' => __( 'Bolt azonosító', 'blackcrystal' ),		
						'id'       => 'shop_id',
						'type'     => 'text',
						'css'      => 'min-width:300px;',		
						'std'      => '',  // WC < 2.0
						'default'  => '',  // WC >= 2.0
						'desc'     => __( 'Bolt azonosízó beállítása a raktárkezelőben történő azonosításhoz', 'blackcrystal' ),
					);
					
					$updated_settings[] = array(		
						'name'     => __( 'Árfolyam', 'blackcrystal' ),		
						'desc_tip' => __( 'Aktuális árfolyam', 'blackcrystal' ),		
						'id'       => 'exchange_rate',
						'type'     => 'text',
						'css'      => 'min-width:300px;',		
						'std'      => '1',  // WC < 2.0
						'default'  => '1',  // WC >= 2.0
						'desc'     => __( 'Aktuális árfolyam beállítása forintról a bolt pénznemére', 'blackcrystal' ),
					);
					
					$updated_settings[] = array(
						'name'     => __( 'Árszorzó', 'blackcrystal' ),
						'desc_tip' => __( 'A mindenkori nettó árat módosítja a megadott értékkel.', 'blackcrystal' ),
						'id'       => 'adjust_price',
						'type'     => 'text',
						'css'      => 'min-width:300px;',
						'std'      => '1',  // WC < 2.0
						'default'  => '1',  // WC >= 2.0
						'desc'     => __( 'A mindenkori nettó árat módosítja a megadott értékkel.', 'blackcrystal' ),
					);	
					
					$updated_settings[] = array(
						'name'     => __( 'Kedvezmény', 'blackcrystal' ),
						'desc_tip' => __( 'A mindenkori nettó árat módosítja a megadott értékkel.', 'blackcrystal' ),
						'id'       => 'sale_percent',
						'type'     => 'text',
						'css'      => 'min-width:300px;',
						'std'      => '0',  // WC < 2.0
						'default'  => '0',  // WC >= 2.0
						'desc'     => __( 'A mindenkori nettó árat módosítja a megadott értékkel.', 'blackcrystal' ),
					);					
					
					$updated_settings[] = array(
						'name'     => __( 'Díszdoboz kedvezmény', 'blackcrystal' ),
						'desc_tip' => __( 'A mindenkori nettó díszdoboz árat módosítja a megadott értékkel.', 'blackcrystal' ),
						'id'       => 'pack_sale_percent',
						'type'     => 'text',
						'css'      => 'min-width:300px;',
						'std'      => '0',  // WC < 2.0
						'default'  => '0',  // WC >= 2.0
						'desc'     => __( 'A mindenkori nettó árat módosítja a megadott értékkel.', 'blackcrystal' ),
					);	
					
					$updated_settings[] = array(
						'name'     => __( 'Díszdoboz árszorzó', 'blackcrystal' ),
						'desc_tip' => __( 'A mindenkori nettó díszdoboz árat módosítja a megadott értékkel.', 'blackcrystal' ),
						'id'       => 'adjust_add_price',
						'type'     => 'text',
						'css'      => 'min-width:300px;',
						'std'      => '1',  // WC < 2.0
						'default'  => '1',  // WC >= 2.0
						'desc'     => __( 'A mindenkori nettó árat módosítja a megadott értékkel.', 'blackcrystal' ),
					);	
					
					$updated_settings[] = array(
						'name'     => __( 'Mennyiségi kedvezmények', 'blackcrystal' ),
						'desc_tip' => __( 'Megadja, hogy mekkora mennyiség eléréséhez mekkora kedvezmény tartozik.', 'blackcrystal' ),
						'id'       => 'sale_limits',
						'type'     => 'textarea',
						'css'      => 'min-width:300px;',
						'std'      => '',  // WC < 2.0
						'default'  => '',  // WC >= 2.0
						'desc'     => __( 'A mindenkori nettó árat módosítja a megadott értékkel.', 'blackcrystal' ),
					);												
					
					$updated_settings[] = array(
						'name'     => __( 'Minimum rendelési összeg', 'blackcrystal' ),
						'desc_tip' => __( 'Megadja, hogy mekkora mennyi a minimum rendelési összeg.', 'blackcrystal' ),
						'id'       => 'minimum_amount',
						'type'     => 'text',
						'css'      => 'min-width:300px;',
						'std'      => '',  // WC < 2.0
						'default'  => '',  // WC >= 2.0
						'desc'     => __( 'Megadja, hogy mekkora mennyi a minimum rendelési összeg.', 'blackcrystal' ),
					);		      	      			      	      
				
				}
		
				$updated_settings[] = $section;
			
			}

			return $updated_settings;
		
		}				
		
		function send_order( $order_id ){	
			global $wpdb;
					
			$order = new WC_Order( $order_id );
			
			if (!$order->has_status( 'failed' ) && !$order->has_status( 'cancelled' )){
				
				$shop_id = get_option('shop_id');
				$test = false;
				$order_data = $order->get_data();
				
				if ($order->get_user_id() != 0){
					$user_id = $shop_id . "-" .  $order->get_user_id();
				} else {
					$user_id = $shop_id . '-NOREG-' . $order_id;
				}
				
				$user = array(
					'userID' => $user_id,
					'name'	=>	$order_data['billing']['first_name'] . ' ' . $order_data['billing']['last_name'],
					'country' => $order_data['billing']['country'],
					'region' => $order_data['billing']['region'],
					'zip' => $order_data['billing']['postcode'],
					'city' => $order_data['billing']['city'],
					'street' => $order_data['billing']['address_1'] . $order_data['billing']['address_2'],
					'mailcountry' => $order_data['shipping']['country'],
					'mailregion' => $order_data['shipping']['region'],
					'mailzip' => $order_data['shipping']['postcode'],
					'mailcity' => $order_data['shipping']['city'],
					'mailstreet' => $order_data['shipping']['address_1'] . $order_data['shipping']['address_2'],
					'email' => $order_data['billing']['email'],
					'phone' => $order_data['billing']['phone'],
				);   
			
				if ($test != true){
				
					$wpdb->insert( 
						'customers', 
						array( 
							'userID' => $user['userID'],
							'name' => $user['name'],
							'country' => $user['country'],
							'zip' => $user['zip'],
							'city' => $user['city'],
							'street' => $user['street'],
							'mailcountry' => $user['mailcountry'],
							'mailzip' => $user['mailzip'],
							'mailcity' => $user['mailcity'],
							'mailstreet' => $user['mailstreet'],
							'email' => $user['email'],
							'phone' => $user['phone'],
						),
						array( 
							'%s', 
							'%s', 
							'%s', 
							'%s', 
							'%s', 
							'%s', 
							'%s', 
							'%s', 
							'%s', 
							'%s', 
							'%s', 
							'%s'
						) 				
						
					);	
					
					$wpdb->insert( 
						'orders', 
						array( 
							'date' => $order->order_date,
							'orderid' => $shop_id . "-" . $order->id,
							'customerid' => $user['userID'],
							'country' => $user['country'],
							'zip' => $user['zip'],
							'city' => $user['city'],
							'street' => $user['street'],				
							'currency' => $order->get_order_currency(),
							'transportmode' => $order->get_shipping_method(),
							'paymentmethod' => $order->payment_method_title,
							'comment' => $order->customer_message,
							),
						array(  
							'%s', 
							'%s', 
							'%s', 
							'%s', 
							'%s', 
							'%s', 
							'%s', 
							'%s', 
							'%s', 
							'%s', 
							'%s'
						) 				
						
					);	
				}
		   
			    $order_items = $order->get_items();		
			    
				foreach ($order_items as $order_item){
					$product = new WC_Product( $order_item['product_id'] );
					$ipp = (int) get_post_meta($order_item['product_id'], '_item_per_pack', true);
					$price = (int) $product->get_price();
					if (get_post_meta($product->id, '_sku', true) == 1000) $price = $order_item['line_subtotal'] / $order_item['qty'];
					if ($ipp > 0) $price = round($price / $ipp);
						
					$grossvalue = $order_item['line_subtotal'] + $order_item['line_subtotal_tax'];
					$quantity = $order_item['qty'] * $ipp;
					$product_code = get_post_meta($order_item['product_id'], '_sku', true);
					if ($test != true){
						$wpdb->insert( 
							'order_items', 
							array( 
								'orderid' => $shop_id . "-" . $order->id,
								'productcode' => $product_code,
								'productname' => $order_item['name'],
								'quantity' => $quantity,
								'unipricenet' => round($price),
								'netvalue' => round($order_item['line_subtotal']),
								'grossvalue' => round($grossvalue),
								),
							array(  
								'%s', 
								'%s', 
								'%s', 
								'%d', 
								'%f',
								'%f',
								'%f',
							) 				
							
						);
					}
					
					
				}	
				
				if ($order->get_total_shipping() > 0 && $test != true){
					$wpdb->insert( 
						'order_items', 
						array( 
							'orderid' => $shop_id . "-" . $order->id,
							'productcode' => '0001',
							'quantity' => 1,
							'unipricenet' =>$order->get_total_shipping(),
							'netvalue' => $order->get_total_shipping(),
							'grossvalue' => $order->get_total_shipping(),
							),
						array(  
							'%s', 
							'%s', 
							'%d', 
							'%f',
							'%f',
							'%f',
						) 				
						
					);		
								
				}
			}		

		}				

		/*
			
	
		

		function apply_matched_coupons() {
		    global $woocommerce;

		    $array = explode(PHP_EOL, get_option('sale_limits'));
		
			foreach ($array as $arr) {
				$limits[] = explode(',', $arr);
			}    
		    $limits = array_reverse($limits);
		
		    if ( $woocommerce->cart->has_discount( $coupon_code ) ) return;
		
	    
		    foreach ($limits as $limit){
			    if ( $woocommerce->cart->cart_contents_total >= $limit[0] ) {
			        $woocommerce->cart->add_discount( $limit[1] );
			        break;
			    }    
		    }	
		      
		}	
				 
	*/
	}

} 

if(class_exists('CustomWoo')) {
	$CustomWoo = new CustomWoo();
}	