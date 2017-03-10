<?php
/**
 * The template for displaying product content within loops
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you (the theme developer).
 * will need to copy the new files to your theme to maintain compatibility. We try to do this.
 * as little as possible, but it does happen. When this occurs the version of the template file will.
 * be bumped and the readme will list any important changes.
 *
 * @see     http://docs.woothemes.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 2.5.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $product, $woocommerce_loop;

// Store loop count we're currently on
if ( empty( $woocommerce_loop['loop'] ) ) {
	$woocommerce_loop['loop'] = 0;
}

// Store column count for displaying the grid
if ( empty( $woocommerce_loop['columns'] ) ) {
	$woocommerce_loop['columns'] = apply_filters( 'loop_shop_columns', 4 );
}

// Ensure visibility
if ( ! $product || ! $product->is_visible() ) {
	return;
}

// Increase loop count
$woocommerce_loop['loop']++;

// Extra post classes
$classes = array();
if ( 0 === ( $woocommerce_loop['loop'] - 1 ) % $woocommerce_loop['columns'] || 1 === $woocommerce_loop['columns'] ) {
	$classes[] = 'first';
}
if ( 0 === $woocommerce_loop['loop'] % $woocommerce_loop['columns'] ) {
	$classes[] = 'last';
}
$classes[] = 'item span3';
?>
<li <?php post_class( $classes ); ?>>
	<?php woocommerce_show_product_loop_sale_flash()?>
	<?php if (has_post_thumbnail()):?>
		<a href="<?php the_permalink()?>" class="product-image">
			<?php the_post_thumbnail('shop_catalog')?>
			<span class="sku_wrapper"><span class="sku" itemprop="sku"><?php echo ( $sku = $product->get_sku() ) ? $sku : __( 'N/A', 'woocommerce' ); ?></span></span>
		</a>
	<?php else: ?>
		<a href="<?php the_permalink()?>" class="product-image">
			<img src="<?php bloginfo('template_url')?>/images/default-no-image.png" />
			<span class="sku_wrapper"><span class="sku" itemprop="sku"><?php echo ( $sku = $product->get_sku() ) ? $sku : __( 'N/A', 'woocommerce' ); ?></span></span>			
		</a>
	<?php endif; ?>
	<h3 class="product-name">
		<a href="<?php the_permalink()?>" class="product-title">
			<?php the_title() ?>
		</a>
	</h3>
	<div class="price-box">
		<?php woocommerce_template_loop_price()?>	
	</div>
	<a href="<?php the_permalink()?>" class="more-info"><?php _e('Részletek', 'blackcrystal')?></a>
	<?php $shp = get_user_meta(get_current_user_id(), '_show_customer_price', true );?>
	<?php if (is_user_logged_in() and !$shp):?>
		<?php woocommerce_template_loop_add_to_cart()	?>
	<?php endif?>

</li>
