<?php 
if(!class_exists('CustomWoo')) {

	class CustomWoo{
		
		public function __construct(){
		
			add_action( 'after_setup_theme', array(&$this, 'woocommerce_support' ));
			add_filter( 'woocommerce_enqueue_styles', '__return_false' );
			add_filter( 'woocommerce_cart_shipping_method_full_label', array(&$this, 'hide_shipping_name_on_cart'), 999, 2 );	
			add_filter('loop_shop_columns', array(&$this, 'loop_columns'));
			add_filter( 'woocommerce_product_tabs', array(&$this, 'shipping_tab' ));	
			add_filter( 'woocommerce_checkout_fields' , array(&$this, 'override_checkout_fields' ));				
			add_filter( 'woocommerce_general_settings', array(&$this, 'add_pricing_option_fields' ), 10, 1);	
			add_filter( 'woocommerce_payment_gateways', array(&$this, 'add_card_gateway' ));
			add_action( 'woocommerce_thankyou', array(&$this, 'send_order'));
			add_filter( 'the_title', array($this, 'thankyou_title'), 10, 2 );			
			
			
			
			add_filter( 'woocommerce_get_cart_item_from_session', array(&$this, 'get_cart_items_from_session'), 1, 3 );			
			add_action(	'woocommerce_add_to_cart', array(&$this, 'add_cart_item'), 10, 6);		
			add_filter( 'woocommerce_add_cart_item', array(&$this, 'filter_woocommerce_add_cart_item'), 10, 1 ); 				
			add_action( 'woocommerce_add_order_item_meta', array(&$this, 'save_order_itemmeta'), 10, 3 );	
						
			
			
			/*		
			add_action( 'woocommerce_before_checkout_form', array(&$this, 'apply_matched_coupons' ));
			add_action( 'woocommerce_before_cart', array(&$this, 'apply_matched_coupons' ));		
			
			*/	

		}
		
		function woocommerce_support() {
		    add_theme_support( 'woocommerce' );
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
		
		function shipping_tab( $tabs ) {
			
			// Adds the new tab
			
			$tabs['shipping-tab'] = array(
				'title' 	=> __( 'Shipping', 'woocommerce' ),
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
				
		function filter_woocommerce_add_cart_item( $cart_item) { 
		    // make filter magic happen here... 
		    	if (isset($cart_item['package'])){
				    $cart_item['data']->post->post_title = sprintf(__("Díszdoboz a %d kódszámú termékhez", 'blackcrystal'), $cart_item['prod_id']);	    	
					$cart_item['data']->set_price( $cart_item['package'] );	
		    	}
		    
		    return $cart_item; 
		}
		
		public function add_cart_item($cart_item_key, $product_id, $quantity, $variation_id, $variation, $cart_item_data) {
			if (isset($_POST['_package_price'])){	
				$ap = $_POST['_package_price'];			
				unset($_POST['_package_price']);
								
				WC()->cart->add_to_cart(get_product_by_sku('0000'), 1, "", "", array('package' => $ap, 'prod_id' => get_post_meta($product_id, '_sku', true)));	

			}

		    return $cart_item;
		}
		
		public function get_cart_items_from_session( $item, $values, $key ) {		

			if ($item['data']->id == get_product_by_sku('0000')){	
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
			    $label .= ' (' . __( 'Free', 'woocommerce' ) . ')';
			}
			
			return $label;
		}					
		
		function add_pricing_option_fields( $settings ) {
		
			$updated_settings = array();
		
			foreach ( $settings as $section ) {
				
		   		// at the bottom of the General Options section
		
			   	if ( isset( $section['id'] ) && 'pricing_options' == $section['id'] && isset( $section['type'] ) && 'sectionend' == $section['type'] ) {
					$updated_settings[] = array(		
						'name'     => __( 'Bolt azonosító', 'woocommerce' ),		
						'desc_tip' => __( 'Bolt azonosító', 'woocommerce' ),		
						'id'       => 'shop_id',
						'type'     => 'text',
						'css'      => 'min-width:300px;',		
						'std'      => '',  // WC < 2.0
						'default'  => '',  // WC >= 2.0
						'desc'     => __( 'Bolt azonosízó beállítása a raktárkezelőben történő azonosításhoz', 'woocommerce' ),
					);
					
					$updated_settings[] = array(		
						'name'     => __( 'Árfolyam', 'woocommerce' ),		
						'desc_tip' => __( 'Aktuális árfolyam', 'woocommerce' ),		
						'id'       => 'exchange_rate',
						'type'     => 'text',
						'css'      => 'min-width:300px;',		
						'std'      => '1',  // WC < 2.0
						'default'  => '1',  // WC >= 2.0
						'desc'     => __( 'Aktuális árfolyam beállítása forintról a bolt pénznemére', 'woocommerce' ),
					);
					
					$updated_settings[] = array(
						'name'     => __( 'Árszorzó', 'woocommerce' ),
						'desc_tip' => __( 'A mindenkori nettó árat módosítja a megadott értékkel.', 'woocommerce' ),
						'id'       => 'adjust_price',
						'type'     => 'text',
						'css'      => 'min-width:300px;',
						'std'      => '1',  // WC < 2.0
						'default'  => '1',  // WC >= 2.0
						'desc'     => __( 'A mindenkori nettó árat módosítja a megadott értékkel.', 'woocommerce' ),
					);	
					
					$updated_settings[] = array(
						'name'     => __( 'Kedvezmény', 'woocommerce' ),
						'desc_tip' => __( 'A mindenkori nettó árat módosítja a megadott értékkel.', 'woocommerce' ),
						'id'       => 'sale_percent',
						'type'     => 'text',
						'css'      => 'min-width:300px;',
						'std'      => '0',  // WC < 2.0
						'default'  => '0',  // WC >= 2.0
						'desc'     => __( 'A mindenkori nettó árat módosítja a megadott értékkel.', 'woocommerce' ),
					);
					
					$updated_settings[] = array(
						'name'     => __( 'Díszdoboz azonosító', 'woocommerce' ),
						'desc_tip' => __( 'A díszdoboz termék azonosítója.', 'woocommerce' ),
						'id'       => 'pack_id',
						'type'     => 'text',
						'css'      => 'min-width:300px;',
						'std'      => '',  // WC < 2.0
						'default'  => '',  // WC >= 2.0
						'desc'     => __( 'A díszdoboz termék azonosítója.', 'woocommerce' ),
					);						
					
					$updated_settings[] = array(
						'name'     => __( 'Díszdoboz kedvezmény', 'woocommerce' ),
						'desc_tip' => __( 'A mindenkori nettó díszdoboz árat módosítja a megadott értékkel.', 'woocommerce' ),
						'id'       => 'pack_sale_percent',
						'type'     => 'text',
						'css'      => 'min-width:300px;',
						'std'      => '0',  // WC < 2.0
						'default'  => '0',  // WC >= 2.0
						'desc'     => __( 'A mindenkori nettó árat módosítja a megadott értékkel.', 'woocommerce' ),
					);	
					
					$updated_settings[] = array(
						'name'     => __( 'Díszdoboz árszorzó', 'woocommerce' ),
						'desc_tip' => __( 'A mindenkori nettó díszdoboz árat módosítja a megadott értékkel.', 'woocommerce' ),
						'id'       => 'adjust_add_price',
						'type'     => 'text',
						'css'      => 'min-width:300px;',
						'std'      => '1',  // WC < 2.0
						'default'  => '1',  // WC >= 2.0
						'desc'     => __( 'A mindenkori nettó árat módosítja a megadott értékkel.', 'woocommerce' ),
					);						
					
					$updated_settings[] = array(
						'name'     => __( 'Mennyiségi kedvezmények', 'woocommerce' ),
						'desc_tip' => __( 'Megadja, hogy mekkora mennyiség eléréséhez mekkora kedvezmény tartozik.', 'woocommerce' ),
						'id'       => 'sale_limits',
						'type'     => 'textarea',
						'css'      => 'min-width:300px;',
						'std'      => '',  // WC < 2.0
						'default'  => '',  // WC >= 2.0
						'desc'     => __( 'A mindenkori nettó árat módosítja a megadott értékkel.', 'woocommerce' ),
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
				
				$customer = new WC_Customer($order_id);
				$shop_id = get_option('shop_id');
				$test = false;
				
				if ($order->get_user_id() != 0){
					$user_id = $shop_id . "-" .  $order->get_user_id();
				} else {
					$user_id = $shop_id . '-NOREG-' . $order_id;
				}
				
	
				$user = array(
					'userID' => $user_id,
					'name'	=>	$order->billing_first_name . ' ' . $order->billing_last_name,
					'country' => $customer->get_country(),
					'region' => $customer->get_state(),
					'zip' => $customer->get_postcode(),
					'city' => $customer->get_city(),
					'street' => $customer->get_address() . $customer->get_address_2(),
					'mailcountry' => $customer->get_shipping_country(),
					'mailregion' => $customer->get_shipping_state(),
					'mailzip' => $customer->get_shipping_postcode(),
					'mailcity' => $customer->get_shipping_city(),
					'mailstreet' => $customer->get_shipping_address() . $customer->get_shipping_address_2(),
					'email' => $order->billing_email,
					'phone' => $order->billing_phone,
				);   
				if ($test != true){
					$wpdb->insert( 
						'customers', 
						array( 
							'userID' => $user['userID'],
							'name' => $user['name'],
							'country' => $user['country'],
							'region' => $user['region'],
							'zip' => $user['zip'],
							'city' => $user['city'],
							'street' => $user['street'],
							'mailcountry' => $user['mailcountry'],
							'mailregion' => $user['mailregion'],
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
							'%d', 
							'%s', 
							'%s', 
							'%s', 
							'%s', 
							'%d', 
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
							'orderid' => $order->id,
							'customerid' => $user['userID'],
							'country' => $user['country'],
							'region' => $user['region'],
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
							'%d', 
							'%s', 
							'%s', 
							'%s', 
							'%d', 
							'%s', 
							'%s', 
							'%s', 
							'%d', 
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
					if ($ipp > 0) $price = round($price / $ipp);
						
					$grossvalue = $order_item['line_subtotal'] + $order_item['line_subtotal_tax'];
					$quantity = $order_item['qty'] * $ipp;
					$product_code = get_post_meta($order_item['product_id'], '_sku', true);
					if ($test != true){
						$wpdb->insert( 
							'order_items', 
							array( 
								'orderid' => $order->id,
								'productcode' => $product_code,
								'productname' => $order_item['name'],
								'quantity' => $quantity,
								'unipricenet' => round($price),
								'netvalue' => round($order_item['line_subtotal']),
								'grossvalue' => round($grossvalue),
								),
							array(  
								'%d', 
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
							'orderid' => $order->id,
							'productcode' => '0001',
							'quantity' => 1,
							'unipricenet' =>$order->get_total_shipping(),
							'netvalue' => $order->get_total_shipping(),
							'grossvalue' => $order->get_total_shipping(),
							),
						array(  
							'%d', 
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