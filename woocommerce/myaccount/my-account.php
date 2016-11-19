<?php
/**
 * My Account page
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/my-account.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you (the theme developer).
 * will need to copy the new files to your theme to maintain compatibility. We try to do this.
 * as little as possible, but it does happen. When this occurs the version of the template file will.
 * be bumped and the readme will list any important changes.
 *
 * @see 	    http://docs.woothemes.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

wc_print_notices(); ?>

<p class="myaccount_user">
	<?php
	printf(
		__( 'Hello <strong>%1$s</strong> (not %1$s? <a href="%2$s">Sign out</a>).', 'woocommerce' ) . ' ',
		$current_user->display_name,
		wc_get_endpoint_url( 'customer-logout', '', wc_get_page_permalink( 'myaccount' ) )
	);

	printf( __( 'From your account dashboard you can view your recent orders, manage your shipping and billing addresses and <a href="%s">edit your password and account details</a>.', 'woocommerce' ),
		wc_customer_edit_account_url()
	);
	?>
</p>
<script type="text/javascript" src="http://xn--kristlynagyker-zgb.hu/wp-content/themes/blackcrystal/js/on-off-switch.js?ver=1.0.0"></script>
<script type="text/javascript" src="http://xn--kristlynagyker-zgb.hu/wp-content/themes/blackcrystal/js/on-off-switch-onload.js?ver=1.0.0"></script>

<style>
</style>
<div class="show_price_switch_checkbox_container">

    <span class="show_price_switch_label">Eladási árak megjelenítése? </span><input type="hidden" id="on-off-switch-custom" value="1">

    <script type="text/javascript">
        new DG.OnOffSwitch({
            el: '#on-off-switch-custom',
            height: 30,
            trackColorOn:'#F57C00',
            trackColorOff:'#666',
            trackBorderColor:'#555',
            textColorOff:'#fff',
            textOn:'Igen',
            textOff:'Nem'
        });
        
        jQuery('#on-off-switch-custom + .on-off-switch').on('click', function(){
			var ajaxurl = '<?php echo admin_url( 'admin-ajax.php' )?>';
			jQuery.post(
			    ajaxurl, 
			    {
			        'action': 'display_price_action',
			        'data':   jQuery('#on-off-switch-custom').val()
			    }, 
			    function(response){
					location.reload();
			    }
			);
        })
        <?php if (get_user_meta( get_current_user_id(), '_show_customer_price', true ) == false):?>
       		DG.switches["#on-off-switch-custom"].uncheck();
        <?php endif;?>
    </script>
</div>


<?php do_action( 'woocommerce_before_my_account' ); ?>

<?php wc_get_template( 'myaccount/my-downloads.php' ); ?>

<?php wc_get_template( 'myaccount/my-orders.php', array( 'order_count' => $order_count ) ); ?>

<?php wc_get_template( 'myaccount/my-address.php' ); ?>

<?php do_action( 'woocommerce_after_my_account' ); ?>
