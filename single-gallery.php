<?php get_header()?>
	<div class="main-container col2-right-layout">
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
										<div class="entry-content">
											<?php the_content();?>
										</div>
										<?php $gallery = new WCSlider(get_the_ID())?>
										<?php if ($gallery->query->have_posts()):?>
											<div id="lightgallery">
												<?php while ($gallery->query->have_posts()): $gallery->query->the_post()?>
													<?php $thumb = wp_get_attachment_image_src(get_the_ID(), 'large')?>
													<?php $full = wp_get_attachment_image_src(get_the_ID(), 'full')?>
													<a href="<?php echo $full[0]?>">
														<span class="gallery_title"><?php the_title()?></span>
														<img src="<?php echo $thumb[0]?>" />
													</a>
											  	<?php endwhile;?>
											</div>									
										<?php endif;?>
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
    <!-- jQuery version must be >= 1.8.0; -->
    <script src="<?php bloginfo('template_url')?>/js/lightgallery.min.js"></script>

    <!-- A jQuery plugin that adds cross-browser mouse wheel support. (Optional) -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-mousewheel/3.1.13/jquery.mousewheel.min.js"></script>

    <!-- lightgallery plugins -->
    <script src="<?php bloginfo('template_url')?>/js/lg-thumbnail.js"></script>
    <script src="<?php bloginfo('template_url')?>/js/lg-fullscreen.js"></script>	
<script type="text/javascript">
    jQuery(document).ready(function($) {
        $("#lightgallery").lightGallery(); 
    });
</script>    
<?php get_footer()?>