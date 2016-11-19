<?php 
// Check that the user is allowed to update options
if (!current_user_can('manage_options')) {
    wp_die('You do not have sufficient permissions to access this page.');
}
?>
<div class="wrap">
	<h2><?php  echo wp_get_theme()?> <?php _e('beállítások', theme_textdomain())?></h2>
	<form method="post" action="options.php">
		<?php @settings_fields('theme-group'); ?>
		<?php @do_settings_fields('theme-group'); ?>
		<table class="webcon_admin_table widefat">
			<tr>
				<th><?php _e('Oldalak', theme_textdomain())?></th>
			</tr>
			<tr valign="top">
				<td>
					<label for="login"><?php _e('Videok', theme_textdomain())?></label>				
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
					<label for="register"><?php _e('Kapcsolat', theme_textdomain())?></label>				
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
			</tr>
		</table> 						
		<?php @submit_button(); ?>
	</form>
</div>