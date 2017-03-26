<?php
/**
 * The template for displaying product content in the single-product.php template
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-single-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you (the theme developer).
 * will need to copy the new files to your theme to maintain compatibility. We try to do this.
 * as little as possible, but it does happen. When this occurs the version of the template file will.
 * be bumped and the readme will list any important changes.
 *
 * @see 	    http://docs.woothemes.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

?>

<?php
	/**
	 * woocommerce_before_single_product hook.
	 *
	 * @hooked wc_print_notices - 10
	 */
	 do_action( 'woocommerce_before_single_product' );

	 if ( post_password_required() ) {
	 	echo get_the_password_form();
	 	return;
	 }
	 
	 global $product;
?>

<div itemscope itemtype="<?php echo woocommerce_get_product_schema(); ?>" id="product-<?php the_ID(); ?>" <?php post_class('product-view'); ?>>

	<?php
		/**
		 * woocommerce_before_single_product_summary hook.
		 *
		 * @hooked woocommerce_show_product_sale_flash - 10
		 * @hooked woocommerce_show_product_images - 20
		 */
		do_action( 'woocommerce_before_single_product_summary' );
	?>

	<div class="summary entry-summary ">
		<div class="product-title-line clearfix">
			<?php woocommerce_template_single_title() ?>
		</div>
		<?php woocommerce_template_single_price() ?>
		<?php //woocommerce_template_single_meta() ?>
		<?php woocommerce_template_single_add_to_cart() ?>
		<?php woocommerce_output_product_data_tabs()?>

	</div><!-- .summary -->
	<?php woocommerce_upsell_display()?>
	<?php if (get_post_meta(get_the_ID(), '_video_id', true) != ""):?>
		<div class="video-box box-collateral">
			<h2><?php _e('Video', 'woocommerce')?></h2>
			<div class="box-collateral-content">
				<div class="video">
					<iframe src="http://www.youtube.com/embed/<?php echo get_post_meta(get_the_ID(), '_video_id', true)?>" frameborder="0" allowfullscreen=""></iframe>
				</div>
			</div>
		</div>	
	<?php endif;?>
	
	<?php woocommerce_output_related_products()?>


	<meta itemprop="url" content="<?php the_permalink(); ?>" />

</div><!-- #product-<?php the_ID(); ?> -->

<?php do_action( 'woocommerce_after_single_product' ); ?>
