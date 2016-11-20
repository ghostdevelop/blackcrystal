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
							<p class="welcome-msg">Üdvözlünk az oldalon,</p>
							<em><a  href="<?php echo get_permalink( $myaccount_page_id )?>"><i class="fa fa-user"></i><?=$current_user->display_name?></a></em>
						<?php else:?>
							<?php $current_user = wp_get_current_user();?>
							<?php $myaccount_page_id = get_option( 'woocommerce_myaccount_page_id' );?>
							<p class="welcome-msg">Viszonteladók részére</p>
							<em><a  href="mailto:blackcrystal.office@gmail.com"><i class="fa fa-envelope"></i>Érdeklődjön itt</a></em>						
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
