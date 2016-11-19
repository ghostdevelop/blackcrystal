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
									<h2><?php _e( 'A keresett oldal nem található.' ); ?></h2>
									<p><?php _e( 'Probálj meg keresni!' ); ?></p>
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