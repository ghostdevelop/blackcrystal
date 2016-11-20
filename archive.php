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
									<h2 class="page-title"><strong><?php echo post_type_archive_title()?></strong></h2>							
									<?php if (have_posts()):?>
										<?php while (have_posts()): the_post()?>
								            <article id="post-<?php the_ID(); ?>" <?php post_class("clearfix dekor-list-item"); ?> >
								                <h2 class="title"><a href="<?php the_permalink()?>"><?php the_title()?></a></h2>
								                <?php if (has_post_thumbnail()):?>
									                <a class="cover-img" href="<?php the_permalink()?>">
														<?php the_post_thumbnail('large')?>
									                </a>	
								                <?php endif;?>	
								                <div class="entry-content">
								                   <?php //the_excerpt()?>
								                </div><!-- .entry-content -->
								                <br clear="all">
								                <a href="<?php the_permalink()?>" class="read-more"><?php _e("Megnézem", 'blackcrystal')?></a>
								            </article><!-- end .entry -->
							            <?php endwhile;?>
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