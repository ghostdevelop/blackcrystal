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
										<h1 class="page-title"><strong><?php the_title()?></strong></h1>	
						                <?php if (has_post_thumbnail()):?>
											<?php the_post_thumbnail(array(848))?>
						                <?php endif;?>		
						                <!--																	
										<div class="entry-content">
											<?php the_content();?>
										</div>
										-->
										<br clear="all">
										<div class="box-collateral box-up-sell related-carousel">
											<h2 class="page-title"><strong><?php _e('Termékek ezzel a dekorral', 'blackcrystal')?></strong></h2>											
											<?php $products = new WP_Query(array('post_type' => 'product', 'meta_key' => '_design', 'meta_value'=> get_post_meta(get_the_ID(), '_slug', true), 'posts_per_page' => -1))?>
											<?php if ( $products->have_posts() ) : ?>
												<?php woocommerce_product_loop_start(); ?>
											
													<?php while ( $products->have_posts() ) : $products->the_post(); ?>
											
														<?php wc_get_template_part( 'content', 'product' ); ?>
											
													<?php endwhile; // end of the loop. ?>
											
												<?php woocommerce_product_loop_end(); ?>									
											<?php endif; ?>		
										</div>								
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