<?php get_header()?>
<script type="text/javascript">

jQuery(window).load(function(){
    var $container = jQuery('.portfolioContainer');
    $container.isotope({
        filter: '*',
      
        animationOptions: {
            duration: 750,
            easing: 'linear',
            queue: false
        }
    });
 
    jQuery('.portfolioFilter a').click(function(){
        jQuery('.portfolioFilter .current').removeClass('current');
        jQuery(this).addClass('current');
 
        var selector = jQuery(this).attr('data-filter');
        $container.isotope({
            filter: selector,
            animationOptions: {
                duration: 750,
                easing: 'linear',
                queue: false
            }
         });
         return false;
    }); 
});

</script>	
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
									<h2 class="page-title"><strong><?php echo post_type_archive_title()?></strong></h2>							
									<?php if (have_posts()):?>
										<?php $terms = get_terms( 'gallery', array('hide_empty' => true));?>
										<?php if (!empty($terms)):?>
											<div class="portfolioFilter">
												<a href="#" data-filter="*" class="current"><?php _e('Minden kategória', 'blackcrystal')?></a>
												<?php foreach ($terms as $term):?>
													<a href="#" data-filter=".<?php echo $term->slug?>"><?php echo $term->name?></a>
												<?php endforeach;?>				
											</div>		
										<?php endif;?>			
										<div class="portfolioContainer">									
											<?php while (have_posts()): the_post()?>
												<?php $category = get_the_terms(get_the_ID(), 'gallery')?>
									            <div class="grid-item <?php echo $category[0]->slug?>">
									                <?php if (has_post_thumbnail()):?>
										                <a href="<?php echo get_the_post_thumbnail_url(get_the_ID(), 'full')?>" class="grow swipebox" title="<?php echo  get_the_title()?>">
															<?php the_post_thumbnail(array(300), array('title' => get_the_title()))?>
															<span><?php the_title()?></span>
										                </a>	
									                <?php endif;?>	
									            </div><!-- end .entry -->
								            <?php endwhile;?>		
										</div>          
									<?php endif; ?>
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