<?php
/**
 * Display a loop of posts.
 *
 * Class SiteOrigin_Panels_Widgets_CustomPost
 */
class WebcreativesCustomPostWidget extends WP_Widget{
	function __construct() {
		parent::__construct(
			'siteorigin-panels-custompost',
			__( 'Post', 'siteorigin-panels' ),
			array(
				'description' => __( 'Displays a post.', 'siteorigin-panels' ),
			)
		);
	}

	/**
	 * @param array $args
	 * @param array $instance
	 */
	function widget( $args, $instance ) {
		if( empty( $instance['template'] ) ) return;
		if( is_admin() ) return;

		static $depth = 0;
		$depth++;
		if( $depth > 1 ) {
			// Because of infinite loops, don't render this post loop if its inside another
			$depth--;
			echo $args['before_widget'].$args['after_widget'];
			return;
		}

		$query_args = $instance;


		echo $args['before_widget'];


		$variables_to_be_created = array(
				"query_args" => $query_args['featured_post_id'],
				'instance' => $instance
		);					
	
		$template = str_replace('.php', '', $instance['template']);
		
		get_template_part2($template, '', $variables_to_be_created);

		echo $args['after_widget'];

		// Reset everything
		wp_reset_query();
		$depth--;
	}

	/**
	 * Update the widget
	 *
	 * @param array $new
	 * @param array $old
	 * @return array
	 */
	function update($new, $old){
		return $new;
	}

	/**
	 * Get all the existing files
	 *
	 * @return array
	 */
	function get_loop_templates(){
		$templates = array();

		$template_files = array(
			'content*.php',
			'*/content*.php',
		);

		$template_dirs = array(get_template_directory(), get_stylesheet_directory());
		$template_dirs = array_unique($template_dirs);
		foreach($template_dirs  as $dir ){
			foreach($template_files as $template_file) {
				foreach((array) glob($dir.'/'.$template_file) as $file) {
					if( file_exists( $file ) ) $templates[] = str_replace($dir.'/', '', $file);
				}
			}
		}

		$templates = array_unique($templates);
		$templates = apply_filters('siteorigin_panels_postloop_templates', $templates);
		sort($templates);

		return $templates;
	}

	/**
	 * Display the form for the post loop.
	 *
	 * @param array $instance
	 * @return string|void
	 */
	function form( $instance ) {
		$instance = wp_parse_args($instance, array(
			'title' => '',
			'template' => 'content.php',
		));

		$templates = $this->get_loop_templates();
		if( empty($templates) ) {
			?><p><?php _e("Your theme doesn't have any post loops.", 'siteorigin-panels') ?></p><?php
			return;
		}
		?>
	<?php	wp_enqueue_script('jquery-ui-autocomplete'); ?>

		<script>
			jQuery(function($) {	
				$(".autocomplete").each(function( ) {
					$(this).autocomplete({
						source: function(request, response) {
							$.getJSON("/wp-content/plugins/custom-codes-core/addons/sliders/lib/livesearch.php", { term: request.term, action: $(this.element).attr('data-action'), cat: parseInt($( "#<?=$this->get_field_id('cat')?>").val())}, 
						          response);
						},	
						select: function(event,ui){
							$('.hiddenvalue').val(ui.item.id)
					    },								
						minLength: 2,//search after two characters,,
					});   
				}); 	
			});			
		</script>
		 <?php wp_dropdown_pages(array('post_type' => array('services', 'page'))); ?>
		<div class="field_holder">
			<label for="<?php echo $this->get_field_id( 'title' ) ?>"><?php _e( 'Cím', 'siteorigin-panels' ) ?></label>
			<input type="text"name="<?php echo $this->get_field_name( 'title' ) ?>" id="<?php echo $this->get_field_id( 'title' ) ?>" value="<?php echo esc_attr( $instance['title'] ) ?>">
		</div>
		<br clear="all">
		<?php

			if ( ! empty( $instance['posts'] ) ) {
				$instance = wp_parse_args( $instance['posts'] , $instance );
				unset( $instance['posts'] );
				//unset post__in and taxonomies?
			}
			// Get all the loop template files
			$post_types = get_post_types(array('public' => true));
			$post_types = array_values($post_types);
			$post_types = array_diff($post_types, array('attachment', 'revision', 'nav_menu_item'));
			?>
				<div class="field_holder">
					<label for="<?php echo $this->get_field_id('template') ?>"><?php _e('Template', 'siteorigin-panels') ?></label>
					<select id="<?php echo $this->get_field_id( 'template' ) ?>" name="<?php echo $this->get_field_name( 'template' ) ?>">
						<?php foreach($templates as $template) : ?>
							<option value="<?php echo esc_attr($template) ?>" <?php selected($instance['template'], $template) ?>>
								<?php
								$headers = get_file_data( locate_template($template), array(
									'loop_name' => 'Loop Name',
								) );
								echo esc_html(!empty($headers['loop_name']) ? $headers['loop_name'] : $template);
								?>
							</option>
						<?php endforeach; ?>
					</select>
				</div>	

			<div class="featured_posts holder">
				<div class="field_holder">
					<label for="<?php echo $this->get_field_id('featured_post') ?>"><?php _e('Oldal kiválasztása', 'siteorigin-panels') ?></label>
					<input type="text" class="autocomplete" name="<?php echo $this->get_field_name( 'featured_post' ) ?>" id="<?php echo $this->get_field_id( 'featured_post' ) ?>" data-action="custom_post_autocomplete" placeholder="<?php echo get_the_title($instance['featured_post_id']) ?>" />
					<input type="hidden"  class="hiddenvalue"  name="<?php echo $this->get_field_name( 'featured_post_id' ) ?>" id="<?php echo $this->get_field_id( 'featured_post_id' ) ?>" value="<?php echo (int) $instance['featured_post_id'] ?>" />
				</div>			
			</div>
			<?php
	}
}
