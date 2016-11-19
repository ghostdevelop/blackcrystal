<?php
/**
 * Display a loop of posts.
 *
 * Class SiteOrigin_Panels_Widgets_Slider
 */
class WebcreatviesChainsWidget extends WP_Widget{
	function __construct() {
		parent::__construct(
			'webcreatives-core-slider',
			__( 'Chains', 'webcreatives-core' ),
			array(
				'description' => __( 'Displays a post loop.', 'webcreatives-core' ),
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

		echo $args['before_widget'];

		// Filter the title
		$instance['title'] = apply_filters('widget_title', $instance['title'], $instance, $this->id_base);
		if ( !empty( $instance['title'] ) ) {
			echo $args['before_title'] . $instance['title'] . $args['after_title'];
		}
		
		$gallery = new CCSlider($instance['sliderID']);
		
		$variables_to_be_created = array(
				"sliderID" => $instance['sliderID'],
				"query" => $gallery->query,
				"instance" => $instance,
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
		$new['sliderID'] = (int) $new['sliderID'];
		$new['items_number'] = (int) $new['items_number'];
		$new['show_num'] = $new['show_num'];
		
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
			'carousel*.php',
			'slider*.php',
		//	'*/carousel*.php',
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
			'template' => 'slider.php',
			'items_number' => 1,
			'show_num' => 1,

			// Query args
			'sliderID' => false
		));

		$templates = $this->get_loop_templates();
		if( empty($templates) ) {
			?><p><?php _e("Your theme doesn't have any post loops.", 'webcreatives-core') ?></p><?php
			return;
		}
		?>

		<div class="field_holder">
			<label for="<?php echo $this->get_field_id( 'title' ) ?>"><?php _e( 'Title', 'webcreatives-core' ) ?></label>
			<input type="text" class="widefat" name="<?php echo $this->get_field_name( 'title' ) ?>" id="<?php echo $this->get_field_id( 'title' ) ?>" value="<?php echo esc_attr( $instance['title'] ) ?>">
		</div>
		<div class="field_holder">
			<label for="<?php echo $this->get_field_id('template') ?>"><?php _e('Template', 'webcreatives-core') ?></label>
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
		<div class="field_holder">
			<label for="<?php echo $this->get_field_id( 'items_number' ) ?>"><?php _e( 'Elemek száma', 'webcreatives-core' ) ?></label>
			<input type="text" class="widefat" name="<?php echo $this->get_field_name( 'items_number' ) ?>" id="<?php echo $this->get_field_id( 'items_number' ) ?>" value="<?php echo esc_attr( $instance['items_number'] ) ?>">
		</div>
		<div class="field_holder">
			<label for="<?php echo $this->get_field_id('show_num') ?>"><?php _e('Ennyit jelenítsen meg', 'webcreatives-panel') ?></label>
			<input type="text" class="small-text" id="<?php echo $this->get_field_id( 'show_num' ) ?>" name="<?php echo $this->get_field_name( 'show_num' ) ?>" value="<?php echo $instance['show_num'] ?>" />
		</div>				
		<div class="field_holder">
			<?php wp_dropdown_pages(array('post_type' => 'chains', 'name' => $this->get_field_name( 'sliderID' ), 'id' => $this->get_field_id( 'sliderID' ), 'selected' => $instance['sliderID']));?>
			<label for="<?php echo $this->get_field_id('sliderID') ?>"><?php _e('Chain', 'webcreatives-core') ?></label>

		</div>
		<?php

	}
}
