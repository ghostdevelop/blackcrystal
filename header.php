<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes()?>>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<title><?php wp_title()?></title>
<?php wp_head();?>

<!--[if lt IE 9]>
<div style=' clear: both; text-align:center; position: relative;'>
 <a href="http://windows.microsoft.com/en-US/internet-explorer/products/ie/home?ocid=ie6_countdown_bannercode"><img src="http://storage.ie6countdown.com/assets/100/images/banners/warning_bar_0000_us.jpg" border="0" height="42" width="820" alt="You are using an outdated browser. For a faster, safer browsing experience, upgrade for free today." /></a>
</div>
<![endif]-->
<!--[if lt IE 9]>
	<style>
	body {
		min-width: 960px !important;
	}
	</style>
<![endif]-->
<!--[if lt IE 8]>
<link rel="stylesheet" type="text/css" href="<?php bloginfo('template_url')?>/style-ie.css" media="all" />
<![endif]-->
<!--[if lt IE 7]>
<script type="text/javascript" src="<?php bloginfo('template_url')?>/ds-sleight.js"></script>
<script type="text/javascript" src="<?php bloginfo('template_url')?>/ie6.js"></script>
<![endif]-->
</head>
<div id="callback_wrapper" class="hidden">
	<span id="close_callback">x</span>
	<p><?php _e('Kérjük adja meg nevét és telefonszámát, hogy visszahívhassuk Önt.','blackcrystal')?></p>
	<?php echo do_shortcode(get_option('callback_form'));?>
</div>
<body <?php body_class()?>>
	<div class="wrapper">
		<div class="page">
			<div class="header-container-top">
				<div class="container">
					<div class="row">
						<div class="span12">
							<div class="header">
								<div class="quick-access">
									<div class="header-links">
										<?php wp_nav_menu(array( 
											'menu' => '', 
											'container' => '', 
											'items_wrap' => '<ul id="%1$s" class="%2$s links">%3$s</ul>',
											'theme_location' => 'header-menu' 
										))?>
									</div>
								</div>
								<div class="quick-menu">									
									<div class="header-links">
										<?php wp_nav_menu(array( 
											'menu' => '', 
											'container' => '', 
											'items_wrap' => '<ul id="%1$s" class="%2$s links">%3$s</ul>',
											'theme_location' => 'header-nav-menu' 
										))?>
									</div>
								</div>
								<div class="header-buttons">
									<div class="header-button top-sale">
										<a href="<?php echo get_permalink(get_option('page_sale'))?>"><i class="fa fa-tags" aria-hidden="true"></i></a>
									</div>
									<div class="header-button top-facebook">
										<a href="https://www.facebook.com/Black-Crystal-1457288184496495/" alt="Kövess minket Facebookon" title="Kövess minket Facebookon"><i class="fa fa-facebook" aria-hidden="true"></i></a>
									</div>								
									<div class="header-button menu-list">
										<i class="fa fa-info"></i>
										<?php wp_nav_menu(array( 
											'menu' => '', 
											'container' => '', 
											'items_wrap' => '<ul id="%1$s" class="%2$s links">%3$s</ul>',
											'theme_location' => 'header-nav-menu' 
										))?>
									</div>
									<div class="header-button menu-list">
										<i class="fa fa-user"></i>
										<?php wp_nav_menu(array( 
											'menu' => '', 
											'container' => '', 
											'items_wrap' => '<ul id="%1$s" class="%2$s links">%3$s</ul>',
											'theme_location' => 'header-menu' 
										))?>
									</div>
									<?php /*if ( defined( 'POLYLANG_VERSION' ) ):?>
										<div class="header-button lang-list">
											<?php $languages = pll_the_languages(array('raw' => 1));?>
											<a href="#"></a>
											<ul>
												<?php foreach ($languages as $lang):?>
													<li class="<?php echo ($lang['current_lang'] == 1 ? 'current-lang' : '')?>">
														<a href="<?=$lang['url']?>" title="<?=$lang['locale']?>"><?=$lang['name']?></a>
														<span><img src="<?=$lang['flag']?>" /></span>
													</li>
												<?php endforeach;?>
											</ul>
										</div>
									<?php endif */?>
								</div>
								<h1 class="logo mobile"><a href="<?php echo home_url()?>" title="<?php bloginfo('name')?>" class="logo"><img width="200px" src="<?php bloginfo('template_url')?>/images/logo2.png" alt="<?php bloginfo('name')?>"/></a></h1>
								<div class="block-cart-header">
									<h3><i class="fa fa-shopping-cart"></i> <?php _e('Cart', 'woocommerce')?>:</h3>
									<?php woocommerce_mini_cart()?>
								</div>
								<div class="block-social-media">
									<ul class="social-media">
										<li><a href="https://www.facebook.com/Black-Crystal-1457288184496495/" alt="Kövess minket Facebookon" title="Kövess minket Facebookon"><i class="fa fa-facebook"></i></a></li>
									</ul>
								</div>
								<div class="header-info mobile">
									<em><a id="callback-btn-mobile"><i class="fa fa-phone"></i><?php _e('Kérjen Visszahívást', 'theme-phrases')?></a></em>

								</div> 
							</div>
						</div>
					</div>
				</div>
				<div class="clear"></div>
			</div>
		</div>
		<?php if (SIMPLE_SHOP):?>
			<?php get_template_part('header-simple')?>
		<?php else:?>
			<?php get_template_part('header-wholesale')?>
		<?php endif;?>
		<div class="nav-container">
			<div class="container">
				<div class="row">
					<div class="span12">
						<div id="menu-icon"><div><?php _e('Products', 'woocommerce')?></div></div>
						<?php 
							include_once( WC()->plugin_path() . '/includes/walkers/class-product-cat-list-walker.php' );
						
							$list_args['walker']                     = new WC_Product_Cat_List_Walker;
							$list_args['title_li']                   = '';
							$list_args['depth']                 = 3;
							$list_args['taxonomy']                 = 'product_cat';
							$list_args['current_category_ancestors']                 = '';
							$list_args['show_option_none']           = __('No product categories exist.', 'woocommerce' );
						
							echo '<ul id="nav" class="menu sf-menu">';
								wp_list_categories( $list_args );	
							echo '</ul>';			
						?>
						<ul class="sf-menu-phone">
							<?php wp_list_categories( $list_args );	?>						
						</ul>
					</div>
				</div>
				<div class="clear"></div>
			</div>
		</div>
