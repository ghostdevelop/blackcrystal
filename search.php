<?php
/**
 * The Template for displaying product archives, including the main shop page which is a post type archive
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/archive-product.php.
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

get_header( ); ?>

	<?php woocommerce_output_content_wrapper()?>

		<?php if ( apply_filters( 'woocommerce_show_page_title', true ) ) : ?>
		
			<div class="page-title category-title">
				<h1><?php woocommerce_page_title(); ?></h1>
			</div>
			
		<?php endif; ?>
		
    	<?php if ($_GET['video-search']):?>  
    	  
    		<?php get_template_part('search', 'video')?>
    		
		<?php else :?>
		
    		<?php get_template_part('search', 'default')?>
    		
		<?php endif; ?>
		
	<?php woocommerce_output_content_wrapper_end()?>

<?php get_footer( ); ?>

