<?php
/**
 * Order details table shown in emails.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/emails/email-order-details.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you (the theme developer).
 * will need to copy the new files to your theme to maintain compatibility. We try to do this.
 * as little as possible, but it does happen. When this occurs the version of the template file will.
 * be bumped and the readme will list any important changes.
 *
 * @see 	    http://docs.woothemes.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates/Emails
 * @version     2.5.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

do_action( 'woocommerce_email_before_order_table', $order, $sent_to_admin, $plain_text, $email ); ?>

<?php if ( ! $sent_to_admin ) : ?>
	<h2 style="color: #aaa;"><?php printf( __( 'Order #%s', 'woocommerce' ), $order->get_order_number() ); ?><span style="font-size: 14px;"><?php _e(' (tranzakicó azonosító)', 'blackcrystal')?></span></h2>
<?php else : ?>
	<h2 style="color: #aaa;"><a class="link" href="<?php echo esc_url( admin_url( 'post.php?post=' . $order->id . '&action=edit' ) ); ?>" style="color: #aaa;"><?php printf( __( 'Order #%s', 'woocommerce'), $order->get_order_number() ); ?></a> (<?php printf( '<time datetime="%s">%s</time>', date_i18n( 'c', strtotime( $order->order_date ) ), date_i18n( wc_date_format(), strtotime( $order->order_date ) ) ); ?>)</h2>
<?php endif; ?>

<table class="td" cellspacing="0" cellpadding="6" style="width: 100%; font-family: 'Helvetica Neue', Helvetica, Roboto, Arial, sans-serif;" border="1">
	<thead>
		<tr>
			<th class="td" scope="col" style="text-align:left; border: 0; border-bottom: 1px solid #b28a60;"><?php _e( 'Product', 'woocommerce' ); ?></th>
			<th class="td" scope="col" style="text-align:left; border: 0; border-bottom: 1px solid #b28a60;"><?php _e( 'Quantity', 'woocommerce' ); ?></th>
			<th class="td" scope="col" style="text-align:left; border: 0; border-bottom: 1px solid #b28a60;"><?php _e( 'Price', 'woocommerce' ); ?></th>
		</tr>
	</thead>
	<tbody>
		<?php echo $order->email_order_items_table( array(
			'show_sku'      => $sent_to_admin,
			'show_image'    => false,
			'image_size'    => array( 32, 32 ),
			'plain_text'    => $plain_text,
			'sent_to_admin' => $sent_to_admin
		) ); ?>
	</tbody>
	<tfoot>
		<?php
			if ( $totals = $order->get_order_item_totals() ) {
				$i = 0;
				$payment_method = $totals['payment_method'];
				unset($totals['payment_method']);
				foreach ( $totals as $total ) {
					$i++;
					?><tr>
						<th class="td" scope="row" colspan="2" style="text-align:left;  padding: 0 8px !important; <?php if ( $i === 1 ) echo 'border-top-width: 4px;'; ?> <?php if ($i == 4) echo 'border-top: 2px solid #b28a60 !important;'?>"><?php echo $total['label']; ?></th>
						<td class="td" style="text-align:left; padding: 2px 8px !important; <?php if ( $i === 1 ) echo 'border-top-width: 4px;'; ?> <?php if ($i == 4) echo 'border-top: 2px solid #b28a60 !important;'?>"><?php echo $total['value']; ?></td>
					</tr><?php
				}
			}
		?>
	</tfoot>
</table>
<?php echo $payment_method['label']?> - 
<?php echo $payment_method['value']?>
<?php do_action( 'woocommerce_email_after_order_table', $order, $sent_to_admin, $plain_text, $email ); ?>
