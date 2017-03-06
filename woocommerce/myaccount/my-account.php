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
		__( 'Hello <strong>%1$s</strong> (not %1$s? <a href="%2$s">Sign out</a>).', 'blackcrystal' ),
		$current_user->display_name,
		wc_get_endpoint_url( 'customer-logout', '', wc_get_page_permalink( 'myaccount' ) )
	);

	printf( __( 'From your account dashboard you can view your recent orders, manage your shipping and billing addresses and <a href="%s">edit your password and account details</a>.', 'blackcrystal' ),
		wc_customer_edit_account_url()
	);
	?>
</p>
<?php if (SIMPLE_SHOP == false):?>
		<span class="show_price_switch_label">Eladási árak megjelenítése? </span>
		<div class="onoffswitch">
		    <input type="checkbox" name="onoffswitch" class="onoffswitch-checkbox" value="<?php echo get_user_meta( get_current_user_id(), '_show_customer_price', true ) ?>" id="myonoffswitch" <?php echo (get_user_meta( get_current_user_id(), '_show_customer_price', true ) == false ? "" : "checked")?>>
		    <label class="onoffswitch-label" for="myonoffswitch">
		        <span class="onoffswitch-inner"></span>
		        <span class="onoffswitch-switch"></span>
		    </label>
		</div>	    
    <script type="text/javascript">
       
        jQuery('.onoffswitch-checkbox').on('change', function(){
			var ajaxurl = '<?php echo admin_url( 'admin-ajax.php' )?>';
			var val = jQuery(this).val()
			jQuery.post(
			    ajaxurl, 
			    {
			        'action': 'display_price_action',
			        'data':   val
			    }, 
			    function(response){
					location.reload();
			    }
			);
        })
       
    </script>
</div>
<?php endif?>

<?php do_action( 'woocommerce_before_my_account' ); ?>

<?php wc_get_template( 'myaccount/my-orders.php', array( 'order_count' => $order_count ) ); ?>

<?php wc_get_template( 'myaccount/my-address.php' ); ?>

<?php do_action( 'woocommerce_after_my_account' ); ?>
