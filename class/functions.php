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
	$sale = (int) get_option( 'pack_sale_percent');
	$adjust_add_price = get_option( 'adjust_add_price' );
	$add_price = get_add_price_net($product);

	$add_price = round($add_price * $adjust_add_price);
	
	$prices['normal'] = $add_price;
	
	if ($sale > 1 && $add_price > 0){
		$prices['sale'] = $add_price * ((100 - $sale) / 100);

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

function import_get_price($price){
	global $wpdb;
	
	$exchange_rate = (int) get_option( 'exchange_rate');
	$adjust_price =  get_option('adjust_price');
	
	$return_price = $price / $exchange_rate;
	
	$return_price = round($return_price * $adjust_price);
	
	return $return_price;	
}

function import_get_sale_price($price, $sale_price){
	global $wpdb;
	
	if ($sale_price > 0){
		$return_price = $sale_price;		
	} else{
		$sale_percent = (int) get_option('sale_percent');
		$return_price = import_get_price($price, $db);	
		$return_price = round($return_price * ((100 - $sale_percent) / 100));	
	}
	
	
	return $return_price;	
}
