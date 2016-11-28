<?php /* Template Name: Video kereső */ ?>
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
										<div class="search-box">
											<form role="search" method="get" class="search-form video-search" action="<?php echo home_url( '/' ); ?>">
											    <label>
											        <input type="search" class="search-field"
											            placeholder="<?php echo esc_attr_x( 'Search' ) ?>"
											            value="<?php echo get_search_query() ?>" name="s"
											            title="<?php echo esc_attr_x( 'Search for:', 'label' ) ?>" />
													<input type="hidden" name="video-search" value="1" />
											    </label>
											    <input type="submit" class="search-submit" name="sku" value="<?php echo esc_attr_x( 'Keresés termékkód alapján', 'blackcrystal' ) ?>" />
											    <input type="submit" class="search-submit" name="dek" value="<?php echo esc_attr_x( 'Keresés dekor alapján', 'blackcrystal' ) ?>" />
											</form>	    						
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