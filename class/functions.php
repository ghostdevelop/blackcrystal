<?php
function get_add_price_net($prod_id){
	$price = get_post_meta($prod_id->id, '_add_product_price', true);
	
	if (!SIMPLE_SHOP){
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
	}
	
	
	return $price;
}

function get_add_price($product){
	$sale = (int) get_option( 'pack_sale_percent', 1 );
	$add_price = get_add_price_net($product);
	
	$prices['normal'] = $add_price;
	
	if ($sale > 1 && $add_price > 0){
		$prices['sale'] = $add_price * ((100 + $sale) / 100);

	}
	
	if (SIMPLE_SHOP){
		$tax_rates = WC_Tax::get_rates( $tax_class );
		$tax = (100 + $tax_rates[1]['rate']) / 100;	
		$prices['normal'] = $prices['normal'] * $tax;
		if (isset($prices['sale'] )) $prices['sale'] = $prices['sale'] * $tax;
	}
	
	return $prices;
}

function show_add_price($product){
	$price = get_add_price($product);
	
	if (!isset($price['sale'])){
		echo wc_price($price['normal']);	
	} else {
		echo '<del>';
		echo wc_price($price['normal']);
		echo '</del>';
		echo '<ins>';
		echo wc_price($price['sale']);
		echo '</ins>';
	}
	
}








/******** IMPORT Functions **********/
function image_list($tag = '0000'){
	for ($i = 1; $i <= 2; $i++) {
		$formatted_value = sprintf("%02d", $i);
		if ($i == 1){
			$url = "http://blackcrystal.hu/images/".$tag.".jpg";
		} else {
			$url = "http://blackcrystal.hu/images/".$tag."_".$i.".jpg";
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

function import_get_price($price, $db){
	global $wpdb;
	
	$exchange_rate = (int) get_option( 'exchange_rate');
	$adjust_price = (int) 1;
	
	$return_price = $price / $exchange_rate;
	$return_price = round($return_price * $adjust_price);
	$return_price = $return_price;
	
	return $return_price;	
}

function import_get_sale_price($price, $db){
	global $wpdb;
	
	$exchange_rate = (int) get_option( 'exchange_rate');
	$adjust_price = (int) 1;
	$sale_percent = (int) 20;
	
	$return_price = $price / $exchange_rate;
	$return_price = ($return_price * $adjust_price);
	$return_price = round($return_price - ($return_price * ($sale_percent / 100)));
	$return_price = $return_price;	
	
	return $return_price;	
}

function import_set_stock($id, $amount){

	$product = get_product_by_sku($id);
	$items_per_pack = get_post_meta($product[0]->post_id, '_item_per_pack', true);
	$return = $amount;
	
	if ($items_per_pack > 0) $return = $amount / $items_per_pack;
	
	return (int) $return;
}

function get_product_by_sku( $sku ) {

  global $wpdb;
  
  $product_id = $wpdb->get_results( "SELECT * FROM $wpdb->postmeta WHERE meta_key='_sku' AND meta_value IN ( $sku) LIMIT 1" );


  if ( $product_id ) return $product_id;

  return null;

}	