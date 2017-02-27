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
<link href='https://fonts.googleapis.com/css?family=Droid+Sans' rel='stylesheet' type='text/css'>
<link href='//fonts.googleapis.com/css?family=Great+Vibes' rel='stylesheet' type='text/css'/>
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-58896973-1', 'auto');
  ga('send', 'pageview');

</script>
<?php wp_footer(); ?>	
</body>
</html>

