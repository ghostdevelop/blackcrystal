<?php /* Template Name: Landing Page */ ?>
<?php get_header()?>
	<div class="main-container col2-right-layout woocommerce">
		<div class="container">
			<div class="row">
				<div class="span12">
					<div class="main">
						<div class="breadcrumbs">
							<?php if ( function_exists('yoast_breadcrumb') ) 
{yoast_breadcrumb('<p id="breadcrumbs">','</p>');} ?>
						</div>
						<div class="row">
							<div class="col-main span9">
								<div class="padding-s">
									<?php if (have_posts()): the_post();?>
										<h2 class="page-title"><strong><?php the_title()?></strong></h2>	
						                <?php if (has_post_thumbnail()):?>
						                	<div class="landing-thumbnail-holder">
												<?php the_post_thumbnail('large')?>
						                	</div>
						                <?php endif;?>																				
										<div class="entry-content">
											<?php the_content();?>
										</div>
									<?php endif;?>
									
									<?php 
										$args = array(
											'post_type' => array('page'),										
											'meta_query' => array(
												array(
													'key'     => '_yoast_wpseo_focuskw',
													'value'   => "",
													'compare' => '!=',
												),
											),			
											'posts_per_page' => -1							
										);
									
										$docs = new WP_Query($args);
									?>
									
									<?php $products = unserialize(get_post_meta(get_the_ID(), 'product-select', true))?>
									<?php $product_cats = get_post_meta(get_the_ID(), 'product-cat-select', true)?>
									
									<?php if (!empty($products)): ?>
										<?php $args = array('post__in' => $products, 'post_type' => 'product') ?>
									<?php else: ?>
										<?php $args = array(
											'post__in' => $products, 
											'post_type' => 'product',
										   'tax_query'             => array(
										        array(
										            'taxonomy'      => 'product_cat',
										            'field' => 'term_id', //This is optional, as it defaults to 'term_id'
										            'terms'         => $product_cats,
										            'operator'      => 'IN' // Possible values are 'IN', 'NOT IN', 'AND'.
										        )
										    )											
										)?>
										
									<?php endif; ?>
									
									<?php $loop = new WP_Query($args)?>

										<?php if ( $loop->have_posts() ) :?>
											<?php woocommerce_product_loop_start(); ?>										
											
											<?php while ( $loop->have_posts() ) : $loop->the_post(); ?>
												<?php wc_get_template_part( 'content', 'product' );?>
											<?php endwhile; ?>
											
											<?php woocommerce_product_loop_end(); ?>	
										<?php else: ?>
											<?php echo __( 'No products found' ); ?>
											<?php wp_reset_postdata(); ?>	
										<?php endif;?>		

								</div>
							</div>
							<?php get_sidebar()?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
<?php get_footer()?>