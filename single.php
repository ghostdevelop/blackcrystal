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