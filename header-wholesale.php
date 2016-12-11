<div class="header-container">
	<div class="container">
		<div class="row">
			<div class="span12">
				<div class="header">
					<h1 class="logo"><a href="<?php echo home_url()?>" title="<?php bloginfo('name')?>" class="logo"><img width="200px" src="<?php bloginfo('template_url')?>/images/logo2.png" alt="<?php bloginfo('name')?>"/></a></h1>
					<div class="header-info">
						<?php if (is_user_logged_in()):?>
							<?php $current_user = wp_get_current_user();?>
							<?php $myaccount_page_id = get_option( 'woocommerce_myaccount_page_id' );?>
							<p class="welcome-msg"><?php _e('Üdvözlünk az oldalon,', 'blackcrystal')?></p>
							<em><a  href="<?php echo get_permalink( $myaccount_page_id )?>"><i class="fa fa-user"></i><?php echo get_user_meta($current_user->ID, '_shop_name', true)?></a></em>
						<?php else:?>
							<?php $current_user = wp_get_current_user();?>
							<?php $myaccount_page_id = get_option( 'woocommerce_myaccount_page_id' );?>
							<p class="welcome-msg"><?php _e('Viszonteladók részére', 'blackcrystal')?></p>
							<em><a  href="<?php echo get_permalink(get_option('page_kontakt'))?>"><i class="fa fa-envelope"></i><?php _e('Érdeklődjön itt', 'blackcrystal')?></a></em>						
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
