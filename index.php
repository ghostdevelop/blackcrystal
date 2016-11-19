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
									<?php $actually = new WP_Query(array('p' => 4124, 'post_type' => 'any'))?>
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
									<?php $slider = new WP_Query(array('post_type' => 'ad', 'post_status' => 'publish')) ?>
									<?php if ($slider->have_posts()):?>
									<script>
									        jQuery(function(){
									            jQuery('#camera_wrap').camera({
									                alignmen: 'topCenter',
									                height: '34.99%',
									                minHeight: '100px',
									                loader : false,
									                navigation: false,
									                fx: 'simpleFade',
									                navigationHover:false,       
									                thumbnails: false,
									                playPause: false
									            });
									        });
									</script>
									<div class="fluid_container_wrap">
										<div class="fluid_container">
											<div class="camera_wrap camera_orange_skin" id="camera_wrap">
												<?php while ($slider->have_posts()): $slider->the_post()?>
													<?php $img = wp_get_attachment_image_src(get_post_thumbnail_ID(), 'full')?>
													<div data-link="" data-src="<?=$img[0]?>">
														<div class="camera_caption fadeFromLeft">
															<div class="lof_camera_title"><?php the_title()?></div>
															<?php echo get_the_content()?>
														</div>
													</div>
												<?php endwhile; ?>
											</div>
										</div>
									</div>
									<?php endif;?>
									<ul class="banner-block row">
										<li class="span4">
											<a href="<?php echo get_post_type_archive_link('design')?>">
												<img src="<?php bloginfo('template_url')?>/images/banners-1.jpg" alt=""/>
												<div class="banner-block-center">
													<div>
														<h1><?php _e('Dekorok', theme_textdomain())?></h1>
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
														<h1><?php _e('Videók', theme_textdomain())?></h1>
													</div>
												</div>
											</a>
										</li>
										<li class="span4">
											<a href="<?php echo get_permalink(get_option('page_kontakt'))?>">
												<img src="<?php bloginfo('template_url')?>/images/banners-1.jpg" alt=""/><?php echo get_option('page_contact')?>
												<div class="banner-block-center">
													<div>
														<h1><?php _e('Kapcsolat', theme_textdomain())?></h1>
													</div>
												</div>
											</a>
										</li>
									</ul>
								</div>
								<div class="page-title category-title">
									<h1 class="subtitle"><?php _e('Featured Products', 'woocommerce')?></h1>
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