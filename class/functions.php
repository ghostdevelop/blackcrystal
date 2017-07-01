<?php
function get_add_price_net($prod_id){
	$add_price = get_post_meta($prod_id->id, '_add_product_price', true);
	$adjust_add_price = get_option( 'adjust_add_price' );
	$sale = (int) get_option( 'pack_sale_percent');
	$exchange_rate = (int) get_option( 'exchange_rate');
	$decimals = get_option('woocommerce_price_num_decimals');
	
	$add_price = round($add_price * $adjust_add_price, $decimals);
	
	$prices['normal'] = $add_price;	
		
	if ($sale > 1 && $add_price > 0){
		$prices['sale'] = $add_price * ((100 - $sale) / 100);

	}	
	
	if (!SIMPLE_SHOP){
		if (get_user_meta(get_current_user_id(), '_show_customer_price', true) == true){
			$pref = get_user_meta(get_current_user_id(), '_preference', true);
			$cp = get_user_meta(get_current_user_id(), '_customer_price', true);
	        //give user 10% of	
	        if ($pref > 0){
				$prices['normal'] = $prices['normal'] * ((100 - $pref) / 100);
				$prices['normal'] = $prices['normal'] * ((100 + $cp) / 100);
				
				if (isset($prices['sale'])){
					$prices['sale'] = $prices['sale'] * ((100 - $pref) / 100);
					$prices['sale'] = $prices['sale'] * ((100 + $cp) / 100);
				} 
	        }	
		} else {
			$pref = get_user_meta(get_current_user_id(), '_preference', true);
	        //give user 10% of
	        if ($pref > 0) $prices['normal'] = $prices['normal'] * ((100 - $pref) / 100);		
		}
	}
	

	if ($exchange_rate > 0) $prices['normal'] = $prices['normal'] / $exchange_rate;
	if ($exchange_rate > 0 && isset($prices['sale'])) $prices['sale'] = $prices['sale'] / $exchange_rate;
	
	if (isset($prices['sale'])) $prices['sale'] = round($prices['sale']);
	if (isset($prices['normal'])) $prices['normal'] = round($prices['normal']);
	
	return $prices;
}

function get_add_price($product){
	$prices = get_add_price_net($product);
		
	if (SIMPLE_SHOP){
		$tax_rates = WC_Tax::get_rates(  );
		if (isset($tax_rates[1])){
			$tax = (100 + $tax_rates[1]['rate']) / 100;	
			$prices['normal'] = $prices['normal'] * $tax;
			if (isset($prices['sale'] )) $prices['sale'] = $prices['sale'] * $tax;		
		}
	}
	
	return $prices;
}

function show_add_price_net($product){
	$prices = get_add_price_net($product);	
	
	if (isset($prices['sale'])) return $prices['sale'];
	
	return $prices['normal'];
}

function show_add_price($product){
	$prices = get_add_price($product);
	
	if (!SIMPLE_SHOP && !is_user_logged_in()){
		echo '<a class="havetologin" href="' . get_permalink(woocommerce_get_page_id('myaccount')) . '">'.__('Jelentkezz be az árak megtekintéséhez', 'blackcrystal').'</a>';
	} else {
		if (!isset($prices['sale'])){
			echo wc_price($prices['normal']);
			if (!SIMPLE_SHOP) echo get_option('woocommerce_price_display_suffix');
		} else {
			echo '<del>';
			echo wc_price($prices['normal']);
			if (!SIMPLE_SHOP) echo get_option('woocommerce_price_display_suffix');
			echo '</del>';
			echo '<ins>';
			echo wc_price($prices['sale']);
			if (!SIMPLE_SHOP) echo get_option('woocommerce_price_display_suffix');
			echo '</ins>';
		}
	}
}

/******** IMPORT Functions **********/
function image_list($tag = '0000', $local = false, $path = ""){
	for ($i = 1; $i <= 2; $i++) {

		if ($local){
			$url = '/images/' . $path;
			if ($i == 1){
				$url = $url.$tag.".jpg";
			} else {
				$url = $url.$tag."_".$i.".jpg";
			}
			if (file_exists(ABSPATH . '/wp-content/uploads/wpallimport/files' . $url)){
				if ($i == 1){
					echo $url;
				} else {
					echo ", ";
					echo $url;
				}
			}			
		} else {
			$url = 'http://blackcrystal.hu/images/' . $path;		
			if ($i == 1){
				$url = $url.$tag.".jpg";
			} else {
				$url = $url.$tag."_".$i.".jpg";
			}
			
			if (@getimagesize($url)){
				if ($i == 1){
					echo $url;
				} else {
					echo ", ";
					echo $url;
				}
			}
		}
	}
}

function import_get_price($price){
	global $wpdb;
	
	$return_price = "";
	
	$exchange_rate = (int) get_option( 'exchange_rate');
	$adjust_price =  get_option('adjust_price');
	$decimals = get_option('woocommerce_price_num_decimals');
	
	$return_price = $price / $exchange_rate;
	
	$return_price = round($return_price * $adjust_price, $decimals);
	
	return $return_price;	
}

function import_get_sale_price($price, $sale_price){
	global $wpdb;
	
	$return_price = "";
	
	$sale_percent = (int) get_option('sale_percent');	
	$decimals = get_option('woocommerce_price_num_decimals');
	
	if ($sale_price > 0 && SIMPLE_SHOP){
		$exchange_rate = (int) get_option( 'exchange_rate');
		
		$return_price = round($sale_price / $exchange_rate);
	
	} elseif ($sale_percent > 0){
		$return_price = import_get_price($price);	
		$return_price = round($return_price * ((100 - $sale_percent) / 100), $decimals);	
	}
	
	
	return $return_price;	
}


function get_product_by_sku( $sku ) {

  global $wpdb;
  
  $product_id = $wpdb->get_results( "SELECT * FROM $wpdb->postmeta WHERE meta_key='_sku' AND meta_value IN ( '$sku') LIMIT 1" );


  if ( $product_id ){
	$prod_id = $product_id[0]->post_id;
	  
  	return $prod_id;
  } 

  return null;

}	