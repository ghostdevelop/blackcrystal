<?php
/**
 * Description tab
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/tabs/description.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you (the theme developer).
 * will need to copy the new files to your theme to maintain compatibility. We try to do this.
 * as little as possible, but it does happen. When this occurs the version of the template file will.
 * be bumped and the readme will list any important changes.
 *
 * @see 	    http://docs.woothemes.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $post;

$heading = esc_html( apply_filters( 'woocommerce_product_description_heading', __( 'Product Description', 'woocommerce' ) ) );

?>
<p>Lehetőség van a termékeken, vagy egy melléjük helyezett táblán feliratokat, logókat elhelyezni.</p>
<p>Terméken:</p>
<ul>
	<li>leghosszabb szállítási idő</li>
	<li>egyedi ár az egyeztetés során</li>
	<li>a termék veszít az értékéből</li>
</ul>
<p>Táblán:</p>
<ul>
	<li>3000 Ft (15 szó, táblával, tartóval)</li>
	<li>termék értéke megmarad</li>
	<li>rövidebb szállítási határidő</li>
</ul>