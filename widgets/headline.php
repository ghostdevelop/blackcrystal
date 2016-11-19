<?php 
/**
 * Recent_Posts widget class
 *
 * @since 2.8.0
 */
class WebcreativesHeadlineWidget extends WP_Widget {

	function __construct() {
		$widget_ops = array('classname' => 'widget-heading-1', 'description' => __( "H1 headline text") );
		parent::__construct('contacts', __('Heading 1'), $widget_ops);
		$this->alt_option_name = 'widget-heading-1';

		add_action( 'save_post', array($this, 'flush_widget_cache') );
		add_action( 'deleted_post', array($this, 'flush_widget_cache') );
		add_action( 'switch_theme', array($this, 'flush_widget_cache') );
	}

	function widget($args, $instance) {
		$cache = array();
		if ( ! $this->is_preview() ) {
			$cache = wp_cache_get( 'widget-heading-1', 'widget' );
		}

		if ( ! is_array( $cache ) ) {
			$cache = array();
		}

		if ( ! isset( $args['widget_id'] ) ) {
			$args['widget_id'] = $this->id;
		}

		if ( isset( $cache[ $args['widget_id'] ] ) ) {
			echo $cache[ $args['widget_id'] ];
			return;
		}

		ob_start();
		extract($args);

		$title = ( ! empty( $instance['title'] )  ? $instance['title'] : '' );
?>
		<?php echo $before_widget; ?> 
			 	<section class="text_box" style="text-align: center;">
                    <h1><?=$title?></h1>
                </section>
                <div class="row clearfix" style="margin-bottom: 20px;">
                	<hr class="style-six margin-t0 margin-b0 ">
				</div>                    
		<?php echo $after_widget; ?>
<?php

		if ( ! $this->is_preview() ) {
			$cache[ $args['widget_id'] ] = ob_get_flush();
			wp_cache_set( 'widget-heading-1', $cache, 'widget' );
		} else {
			ob_end_flush();
		}
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['id'] = (int) $new_instance['id'];
		$this->flush_widget_cache();

		$alloptions = wp_cache_get( 'alloptions', 'options' );
		if ( isset($alloptions['widget-heading-1']) )
			delete_option('widget-heading-1');

		return $instance;
	}

	function flush_widget_cache() {
		wp_cache_delete('widget-heading-1', 'widget');
	}

	function form( $instance ) {
		$title     = 	isset( $instance['title'] ) ? sanitize_text_field( $instance['title'] ) : '';
?>
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $title; ?>" />
		</p>
<?php
	}
}
?>