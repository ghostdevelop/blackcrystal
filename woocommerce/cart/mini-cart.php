<?php
/**
 * Mini-cart
 *
 * Contains the markup for the mini-cart, used by the cart widget.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/mini-cart.php.
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

?>

<?php do_action( 'woocommerce_before_mini_cart' ); ?>

<div class="block-content">

	<?php if ( ! WC()->cart->is_empty() ) : ?>
		<div class="empty">
			<?php echo WC()->cart->get_cart_contents_count()?> <?php _e('product', 'blackcrystal')?> - <span class="price"><?php echo WC()->cart->get_cart_subtotal(); ?></span>
			<div class="cart-content">
			<span id="close_callback">x</span>
			<ul class="mini-cart-products clearfix">
		<?php
			$loop_count = 0;
			foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
				if ($loop_count < 6){
					$_product     = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
					$product_id   = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );
	
					if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_widget_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
	
						$product_name  = apply_filters( 'woocommerce_cart_item_name', $_product->get_title(), $cart_item, $cart_item_key );
						$thumbnail     = apply_filters( 'woocommerce_cart_item_thumbnail', $_product->get_image(array(50,50)), $cart_item, $cart_item_key );
						$product_price = apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price( $_product ), $cart_item, $cart_item_key );
						?>
						<li class="<?php echo esc_attr( apply_filters( 'woocommerce_mini_cart_item_class', 'mini_cart_item', $cart_item, $cart_item_key ) ); ?> clearfix">
							<div class="cart-item-image">
								<?php
								echo apply_filters( 'woocommerce_cart_item_remove_link', sprintf(
									'<a href="%s" class="remove" title="%s" data-product_id="%s" data-product_sku="%s">&times;</a>',
									esc_url( WC()->cart->get_remove_url( $cart_item_key ) ),
									__( 'Remove this item', 'blackcrystal' ),
									esc_attr( $product_id ),
									esc_attr( $_product->get_sku() )
								), $cart_item_key );
								?>
								<?php if ( ! $_product->is_visible() ) : ?>
									<?php echo str_replace( array( 'http:', 'https:' ), '', $thumbnail ) . '&nbsp;'; ?>
								<?php else : ?>
									<a href="<?php echo esc_url( $_product->get_permalink( $cart_item ) ); ?>">
										<?php echo str_replace( array( 'http:', 'https:' ), '', $thumbnail ) . '&nbsp;'; ?>
									</a>
								<?php endif; ?>
							</div>
							<div class="cart-item-data">
								<a href="<?php echo esc_url( $_product->get_permalink( $cart_item ) ); ?>">
									<?=$product_name?>
								</a>
								<?php echo WC()->cart->get_item_data( $cart_item ); ?>
		
								<?php echo apply_filters( 'woocommerce_widget_cart_item_quantity', '<span class="quantity">' . sprintf( '%s &times; %s', $cart_item['quantity'], $product_price ) . '</span>', $cart_item, $cart_item_key ); ?>
							</div>
						</li>
						<?php
					}
				
				} elseif ($loop_count == 6){
					echo '<small>';
					_e('(további termékek ...)', 'blackcrystal');
					echo '</small>';
				}
				
				$loop_count++;
				 
				?>
		<?php }	?>
			</ul>
				<?php if ( ! WC()->cart->is_empty() ) : ?>
				
					<p class="total"><strong><?php _e( 'Subtotal', 'blackcrystal' ); ?>:</strong> <?php echo WC()->cart->get_cart_subtotal(); ?></p>
				
					<?php do_action( 'woocommerce_widget_shopping_cart_before_buttons' ); ?>
				
					<p class="buttons">
						<a href="<?php echo esc_url( wc_get_cart_url() ); ?>" class="button wc-forward"><?php _e( 'View Cart', 'blackcrystal' ); ?></a>
						<a href="<?php echo esc_url( wc_get_checkout_url() ); ?>" class="button checkout wc-forward <?php echo (get_option('minimum_amount') > 0 && WC()->cart->cart_contents_total < get_option('minimum_amount') ? 'disabled' : '') ?> "><?php _e( 'Checkout', 'blackcrystal' ); ?></a>
					</p>
				
				<?php endif; ?>		
						
			</div>
		</div>

	<?php else : ?>

		<div class="empty">
			<?php echo WC()->cart->get_cart_contents_count()?> <?php _e('product', 'blackcrystal')?> - <span class="price"><?php echo WC()->cart->get_cart_subtotal(); ?></span>
			 <div class="cart-content">
				<?php _e( 'No products in the cart.', 'blackcrystal' ); ?>
			 </div>
		</div>

	<?php endif; ?>

</div><!-- end product list -->



<?php do_action( 'woocommerce_after_mini_cart' ); ?>
