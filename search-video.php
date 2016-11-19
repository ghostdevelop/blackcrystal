<?php if (have_posts() && $_GET['sku']):?>

	<?php while ( have_posts() ) : the_post(); ?>

		<?php wc_get_template( 'search/video-sku.php' ); ?>

	<?php endwhile; // end of the loop. ?>
		
<?php elseif (have_posts() && $_GET['dek']): ?>	

	<?php while ( have_posts() ) : the_post(); ?>

		<?php wc_get_template( 'search/video-dekor.php' ); ?>

	<?php endwhile; // end of the loop. ?>

<?php else : ?>

		<?php wc_get_template( 'search/no-video.php' ); ?>

<?php endif; ?>
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