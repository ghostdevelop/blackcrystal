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
				<th>Megjelenési beállítások</th>
			</tr>
			<tr valign="top">
				<td>
					<label for="header_text_2">Bank logo</label>
					<img src="<?php echo get_option('kh_logo');?>" style="width:100px;" id="logo_img" />
					<div class="uploader">
						<input type="hidden" name="kh_logo" id="logo_url" value="<?php echo get_option('kh_logo');?>"/>
						<button id="logo_button" class="upload_button button" >Feltölt</button>
					</div>
				</td>				
			</tr>
		</table> 	
		<table class="webcon_admin_table widefat">
			<tr>
				<th>Beágyazókódok</th>
			</tr>
			<tr valign="top">
				<td>
					<label for="header_text_2">Google analytics</label>
					<textarea name="google_analytics" ><?php echo get_option('google_analytics') ?></textarea>
				</td>				
			</tr>
		</table> 			
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
				<td>
					<label for="register"><?php _e('Felirat leírás oldala', 'blackcrystal')?></label>				
					<?php     wp_dropdown_pages(
				        array(
				             'name' => 'page_subtitle',
				             'echo' => 1,
				             'show_option_none' => __( '&mdash; Select &mdash;' ),
				             'option_none_value' => '0',
				             'selected' => get_option('page_subtitle')
				        )
				    );?>
				</td>	
				<td>
					<label for="register"><?php _e('Szállítás leírás oldala', 'blackcrystal')?></label>				
					<?php     wp_dropdown_pages(
				        array(
				             'name' => 'page_shipping',
				             'echo' => 1,
				             'show_option_none' => __( '&mdash; Select &mdash;' ),
				             'option_none_value' => '0',
				             'selected' => get_option('page_shipping')
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
					<textarea name="callback_form" ><?php echo get_option('callback_form') ?></textarea>
				</td>
				<td>
					<label for="register"><?php _e('Írjon nekünk', 'blackcrystal')?></label>
					<textarea name="writeus_form" ><?php echo get_option('writeus_form') ?></textarea>
				</td>	
				<td>
					<label for="register"><?php _e('Video kérése', 'blackcrystal')?></label>
					<textarea name="video_form" ><?php echo get_option('video_form') ?></textarea>
				</td>								
			</tr>
		</table> 						
		<?php @submit_button(); ?>
	</form>
</div>
<?php wp_enqueue_media();	?>
<script>
jQuery(document).ready(function($){
                 
	var _custom_media = true,
	_orig_send_attachment = wp.media.editor.send.attachment;
 
	$('.upload_button').click(function(e) {
		var send_attachment_bkp = wp.media.editor.send.attachment;
		var button = $(this);
		var id = button.attr('id').replace('_button', '');
		_custom_media = true;
		wp.media.editor.send.attachment = function(props, attachment){
			if ( _custom_media ) {
				$('#logo_url').val(attachment.url);
				$("#logo_img").attr('src', attachment.url);
			} else {
				return _orig_send_attachment.apply( this, [props, attachment] );
			};
		}
 
		wp.media.editor.open(button);
		return false;
	});
 
	$('.add_media').on('click', function(){
		_custom_media = false;
	});
});
</script>