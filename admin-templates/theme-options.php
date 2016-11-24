<?php 
// Check that the user is allowed to update options
if (!current_user_can('manage_options')) {
    wp_die('You do not have sufficient permissions to access this page.');
}
?>
<div class="wrap">
	<h2><?php  echo wp_get_theme()?> <?php _e('beállítások', 'blackcrystal')?></h2>
	<form method="post" action="options.php">
		<?php @settings_fields('theme-group'); ?>
		<?php @do_settings_fields('theme-group'); ?>
		<table class="webcon_admin_table widefat">
			<tr>
				<th><?php _e('Oldalak', 'blackcrystal')?></th>
			</tr>
			<tr valign="top">
				<td>
					<label for="login"><?php _e('Akciók', 'blackcrystal')?></label>				
					<?php     wp_dropdown_pages(
				        array(
				             'name' => 'page_sale',
				             'echo' => 1,
				             'show_option_none' => __( '&mdash; Select &mdash;' ),
				             'option_none_value' => '0',
				             'selected' => get_option('page_sale')
				        )
				    );?>
				</td>				
				<td>
					<label for="login"><?php _e('Videok', 'blackcrystal')?></label>				
					<?php     wp_dropdown_pages(
				        array(
				             'name' => 'page_video',
				             'echo' => 1,
				             'show_option_none' => __( '&mdash; Select &mdash;' ),
				             'option_none_value' => '0',
				             'selected' => get_option('page_video')
				        )
				    );?>
				</td>		
				<td>
					<label for="register"><?php _e('Kapcsolat', 'blackcrystal')?></label>				
					<?php     wp_dropdown_pages(
				        array(
				             'name' => 'page_kontakt',
				             'echo' => 1,
				             'show_option_none' => __( '&mdash; Select &mdash;' ),
				             'option_none_value' => '0',
				             'selected' => get_option('page_kontakt')
				        )
				    );?>
				</td>	
				<td>
					<label for="register"><?php _e('Ajándék ötletek', 'blackcrystal')?></label>				
					<?php     wp_dropdown_pages(
				        array(
				             'name' => 'page_gift',
				             'echo' => 1,
				             'show_option_none' => __( '&mdash; Select &mdash;' ),
				             'option_none_value' => '0',
				             'selected' => get_option('page_gift')
				        )
				    );?>
				</td>		
				<td>
					<label for="register"><?php _e('Aktualitások', 'blackcrystal')?></label>				
					<?php     wp_dropdown_pages(
				        array(
				             'name' => 'page_actuality',
				             'echo' => 1,
				             'show_option_none' => __( '&mdash; Select &mdash;' ),
				             'option_none_value' => '0',
				             'selected' => get_option('page_actuality')
				        )
				    );?>
				</td>										
			</tr>
			<tr>
				<th><?php _e('Űrlapok', 'blackcrystal')?></th>
			</tr>
			<tr>
				<td>
					<label for="register"><?php _e('Visszahívás kérése', 'blackcrystal')?></label>
					<input type="text" name="callback_form" value="<?php echo get_option('callback_form') ?>" />
				</td>
			</tr>
		</table> 						
		<?php @submit_button(); ?>
	</form>
</div>