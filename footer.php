		<div class="footer-container">
			<div class="container">
				<div class="row">
					<div class="span12">
						<div class="footer">
							<p id="back-top"><a href="#top"><span></span></a> </p>
							<div class="footer-cols-wrapper">
								<div id="our_products" class="footer-col">
									<h4>Termékeinkről...</h4>
									<div class="footer-col-content">
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
												'orderby' => 'rand',
												'posts_per_page' => 5							
											);
										
											$docs = new WP_Query($args);
										?>
										<?php if ($docs->have_posts()): ?>
											<div id="products-informations" class="box-collateral box-up-sell">
												<ul class="products-information-list">
													<?php while ($docs->have_posts()): $docs->the_post(); ?>
														<li class="products-information-item">
															<a href="<?php the_permalink()?>"><h3><?php the_title()?></h3></a>
															<?php the_post_thumbnail('medium_large'); ?>
														</li>
													<?php endwhile;?>
												</ul>
											</div>
										<?php endif; ?>									
									</div>
								</div>
								<?php dynamic_sidebar('footer_sidebar')?>							
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="footer-container-bottom">
				<div class="container">
					<div class="row">
						<div class="span12">
							<div class="footer">
								<address>&copy; <script type="text/javascript">var mdate = new Date(); document.write(mdate.getFullYear());</script> <?php bloginfo('name')?> <?php _e('Minden jog fentartva.', 'blackcrystal')?></address>
								<div class="clear"></div>
							</div>
						</div>
					</div>
				</div>
				<?php if (SIMPLE_SHOP):?>
					<img class="accept-cards" src="<?php echo get_template_directory_uri()?>/images/accepted-cards.jpg" />
				<?php endif; ?>
				<?php if (SIMPLE_SHOP):?>
					<img src="<?php echo get_option('kh_logo')?>" class="khlogo"/>
				<?php endif;?>
			</div>
		</div>
	</div>
	<div class="modal fade" tabindex="-1" role="dialog" id="myModal">
	  <div class="modal-dialog" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	        <h4 class="modal-title"></h4>
	      </div>
	      <div class="modal-body">

	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-default" data-dismiss="modal"><?php _e('Close', 'blackcrystal')?></button>
	      </div>
	    </div><!-- /.modal-content -->
	  </div><!-- /.modal-dialog -->
	</div><!-- /.modal -->	
<link href='https://fonts.googleapis.com/css?family=Droid+Sans' rel='stylesheet' type='text/css'>
<link href='//fonts.googleapis.com/css?family=Great+Vibes' rel='stylesheet' type='text/css'/>
<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<?/*************** analytics code ****************/?>
<?php echo get_option('google_analytics')?>

<?php wp_footer(); ?>	
</body>
</html>

