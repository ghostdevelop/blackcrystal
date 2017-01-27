<?php
/**
 * Simple product add to cart
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/add-to-cart/simple.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you (the theme developer).
 * will need to copy the new files to your theme to maintain compatibility. We try to do this.
 * as little as possible, but it does happen. When this occurs the version of the template file will.
 * be bumped and the readme will list any important changes.
 *
 * @see 	    http://docs.woothemes.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $product;

if ( ! $product->is_purchasable() ) {
	return;
}

?>

<?php if ( $product->is_in_stock() ) : ?>

	<?php do_action( 'woocommerce_before_add_to_cart_form' ); ?>
<form class="cart" method="post" enctype='multipart/form-data'>
	<div class="product-add-to-cart-box clearfix">

		<?php
			// Availability
			$availability      = $product->get_availability();
			$availability_html = empty( $availability['availability'] ) ? '' : '<p class="stock ' . esc_attr( $availability['class'] ) . '">' . esc_html( $availability['availability'] ) . '</p>';
		
			echo apply_filters( 'woocommerce_stock_html', $availability_html, $availability['availability'], $product );
		?>	
	 	<?php do_action( 'woocommerce_before_add_to_cart_button' ); ?>
	 	<span class="qty-label"><?php _e('Quantity', 'woocommerce')?></span>
	 	<?php
	 		if ( ! $product->is_sold_individually() ) {
	 			woocommerce_quantity_input( array(
	 				'min_value'   => apply_filters( 'woocommerce_quantity_input_min', 1, $product ),
	 				'max_value'   => apply_filters( 'woocommerce_quantity_input_max', $product->backorders_allowed() ? '' : $product->get_stock_quantity(), $product ),
	 				'input_value' => ( isset( $_POST['quantity'] ) ? wc_stock_amount( $_POST['quantity'] ) : 1 )
	 			) );
	 		}
	 	?>

	 	<input type="hidden" name="add-to-cart" value="<?php echo esc_attr( $product->id ); ?>" />

	 	<button type="submit" class="single_add_to_cart_button button alt"><?php echo esc_html( $product->single_add_to_cart_text() ); ?></button>

	 </div>
		<?php do_action( 'woocommerce_after_add_to_cart_button' ); ?>
		<ul class="additional-products clearfix">
			<li class="clearfix">
				<div class="additional-product clearfix">
					<div class="additional-product-actions">
						<i class="fa fa-info" title="Kattints ide"></i>
					</div>
					<div class="additional-product-image">
						<a href="http://blackcrystal.hu/images/1000.jpg" class="zoom">
							<img src="http://blackcrystal.hu/images/1000.jpg" />
						</a>
					</div>
					<div class="button-box">
						<input id="_package_price" class="input-checkbox addiotional-check" type="checkbox" name="_package_price" value="<?php echo show_add_price_net($product)?>" data-ipp="<?php echo get_post_meta(get_the_ID(), '_item_per_pack_box', true)?>"/>
					</div>
					<div class="price-box">
						<?php show_add_price($product);?>
					</div>
					<h4><?php _e('Díszdoboz', 'blackcrystal')?> <?php echo get_post_meta(get_the_ID(), '_item_per_pack_box', true)?> <?php _e('db termékhez', 'blackcrystal')?></h4>
				</div>
				<div class="additional-product-info">
					<p><?php _e('Kézzel készített bordó díszdoboz, kívül velúr, belül szaténnal bélelve. Kiemeli a kristály szépségét, ajándékozáshoz kiváló. (a kép illusztráció)', 'blackcrystal')?></p>
				</div>				
			</li>
			<!--
			<li class="clearfix">
				<div class="additional-product clearfix">
					<div class="additional-product-actions">
						<i class="fa fa-info"></i>
					</div>			
					<div class="additional-product-image">
						<a href="http://blackcrystal.hu/images/0001.jpg" class="zoom">
							<img src="http://blackcrystal.hu/images/0001.jpg" />
						</a>
					</div>
					<h4>Felirat</h4>

					<div class="button-box">
						<input id="additional-2" class="input-checkbox addiotional-check" type="checkbox" name="additional[]" value="1" />
						<label class="checkbox" for="additional-2" ></label>
					</div>

					<div class="price-box">
						<span>Hamarosan, info itt</span>
					</div>
				</div>
				<div class="additional-product-info">
					<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur ipsum nisi, venenatis non molestie ut, volutpat in justo. Nullam in maximus mi, nec scelerisque ante. Aenean ut mauris auctor enim interdum pharetra.</p>
				</div>
			</li>	
			-->		
		</ul>
</form>

	<?php do_action( 'woocommerce_after_add_to_cart_form' ); ?>

<?php endif; ?>
