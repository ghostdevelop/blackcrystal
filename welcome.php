<?php /* Template Name: Home */ ?>
<?php get_header()?>
	<div class="main-container col1-layout woocommerce">
		<div class="container">
			<div class="row">
				<div class="span12">
					<div class="main">
						<div class="col-main">
							<div class="padding-s">
								<div class="std">
									<?php $actually = new WP_Query(array('p' => get_option('page_actuality'), 'post_type' => 'any'))?>
									<?php if ($actually->have_posts()): $actually->the_post()?>
										<?php if (get_the_content() != ""):?>
											<div class="container">
												<div class="col-md-12 actually">
													<div class="page-title category-title">
														<h1 class="subtitle"><?php the_title()?></h1>
													</div>
													<div class="entry-content">
														<?php the_content() ?>
													</div>
												</div>
											</div>
										<?php endif;?>
									<?php endif;?>
									<?php echo do_shortcode('[rev_slider alias="homeslider"]')?>
									<ul class="banner-block row">
										<li class="span4">
											<a href="<?php echo get_post_type_archive_link('design')?>">
												<img src="<?php bloginfo('template_url')?>/images/banners-1.jpg" alt=""/>
												<div class="banner-block-center">
													<div>
														<h1><?php _e('Dekorok', 'blackcrystal')?></h1>
														<!--<p>Lorem ipsum dolor sit amet conse ctetur adipisicing elit, sed do eiusmo.</p>-->
													</div>
												</div>
											</a>
										</li>
										<li class="span4">
											<a href="<?php echo get_permalink(get_option('page_video'))?>">
												<img src="<?php bloginfo('template_url')?>/images/banners-1.jpg" alt=""/>
												<div class="banner-block-center">
													<div>
														<h1><?php _e('Videók', 'blackcrystal')?></h1>
													</div>
												</div>
											</a>
										</li>
										<li class="span4">
											<a href="<?php echo get_permalink(get_option('page_gift'))?>">
												<img src="<?php bloginfo('template_url')?>/images/banners-1.jpg" alt=""/>
												<div class="banner-block-center">
													<div>
														<h1><?php _e('Ajándék ötletek', 'blackcrystal')?></h1>
													</div>
												</div>
											</a>
										</li>
									</ul>
								</div>
								<div class="page-title category-title">
									<h1 class="subtitle"><?php _e('Featured Products', 'blackcrystal')?></h1>
								</div>
								<?php echo do_shortcode('[featured_products per_page="12" columns="4"]');?>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
<?php get_footer()?>