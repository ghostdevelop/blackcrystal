<?php if ( have_posts() ) : ?>
	<?php woocommerce_product_loop_start(); ?>

		<?php while ( have_posts() ) : the_post(); ?>

			<?php wc_get_template_part( 'content', 'product' ); ?>

		<?php endwhile; // end of the loop. ?>

	<?php woocommerce_product_loop_end(); ?>
	<div class="pagination clearfix">				
		<?php $args = array(
			'base'               => '%_%',
			'format'             => '?paged=%#%',
			'prev_next'          => true,
			'prev_text'          => __('«'),
			'next_text'          => __('»'),
		); ?>
		<?php echo paginate_links($args)?>
	</div>
<?php else : ?>

	<?php wc_get_template( 'loop/no-products-found.php' ); ?>

<?php endif; ?>