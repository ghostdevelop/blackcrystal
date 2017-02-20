		<div class="footer-container">
			<div class="container">
				<div class="row">
					<div class="span12">
						<div class="footer">
							<p id="back-top"><a href="#top"><span></span></a> </p>
							<div class="footer-cols-wrapper">
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
<?php wp_footer(); ?>	
</body>
</html>

