<div class="header-container">
	<div class="container">
		<div class="row">
			<div class="span12">
				<div class="header">
					<h1 class="logo"><a href="<?php echo home_url()?>" title="<?php bloginfo('name')?>" class="logo"><img width="200px" src="<?php bloginfo('template_url')?>/images/logo2.png" alt="<?php bloginfo('name')?>"/></a></h1>
					<div class="header-info">
						<p class="welcome-msg"><?php echo sprintf(__("Keressen minket %s elérhetőségeinken %s vagy,", 'blackcrystal'),'<a href="'.get_permalink(get_option('page_kontakt')).'">','</a>');?></p>
						<div class="top-sale-button">
							<a href="<?php echo get_permalink(get_option('page_sale'))?>"><i class="fa fa-tags" aria-hidden="true"></i><?php _e('Akciós termékek', 'blackcrystal')?></a>
						</div>				
						<?php if (get_locale() == 'hu_HU'):?>										
							<em><a id="callback-btn"><i class="fa fa-phone"></i><?php _e('Kérjen Visszahívást','blackcrystal')?></a></em>
						<?php endif;?>
					</div> 
					<?php get_search_form()?>
					<div class="clear"></div>
				</div>
			</div>
		</div>
		<div class="clear"></div>
	</div>
</div>
