<?php 
/**
 * Recent_Posts widget class
 *
 * @since 2.8.0
 */
class WebcreativesContactWidget extends WP_Widget {

	function __construct() {
		$widget_ops = array('classname' => 'widget_contacts', 'description' => __( "Your company contact info.") );
		parent::__construct('contacts', __('Elérhetőségek'), $widget_ops);
		$this->alt_option_name = 'widget_contacts';

		add_action( 'save_post', array($this, 'flush_widget_cache') );
		add_action( 'deleted_post', array($this, 'flush_widget_cache') );
		add_action( 'switch_theme', array($this, 'flush_widget_cache') );
	}

	function widget($args, $instance) {
		$cache = array();
		if ( ! $this->is_preview() ) {
			$cache = wp_cache_get( 'widget_contacts', 'widget' );
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

		$title = ( ! empty( $instance['title'] ) ) ? $instance['title'] : __( 'Elérhetőségek' );
		$address = ( ! empty( $instance['address'] ) ) ? $instance['address'] : false;
		$phone = ( ! empty( $instance['phone'] ) ) ? $instance['phone'] : false;
		$fax = ( ! empty( $instance['fax'] ) ) ? $instance['fax'] : false;
		$mail = ( ! empty( $instance['mail'] ) ) ? $instance['mail'] : false;

		/** This filter is documented in wp-includes/default-widgets.php */
		$title = apply_filters( 'widget_title', $title, $instance, $this->id_base );
?>
		<?php echo $before_widget; ?>
		<?php if ( $title ) echo $before_title . $title . $after_title; ?>
			<ul class="with_icons default default_size">
				<?php if ($address) : ?><li><span class="icon-home"></span><?=$address?></li><?php endif;?>
				<?php if ($phone) : ?><li><span class="icon-phone"></span><?=$phone?></li><?php endif;?>
				<?php if ($fax) : ?><li><span class="icon-print"></span><?=$fax?></li><?php endif;?>
				<?php if ($mail) : ?><li><span class="icon-lifebuoy"></span><a href="mailto:<?=$mail?>"><?=$mail?></a></li><?php endif;?>
			</ul>
		<?php echo $after_widget; ?>
<?php

		if ( ! $this->is_preview() ) {
			$cache[ $args['widget_id'] ] = ob_get_flush();
			wp_cache_set( 'widget_contacts', $cache, 'widget' );
		} else {
			ob_end_flush();
		}
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['address'] = strip_tags($new_instance['address']);
		$instance['phone'] = strip_tags($new_instance['phone']);
		$instance['fax'] = strip_tags($new_instance['fax']);
		$instance['mail'] = strip_tags($new_instance['mail']);
		$this->flush_widget_cache();

		$alloptions = wp_cache_get( 'alloptions', 'options' );
		if ( isset($alloptions['widget_contacts']) )
			delete_option('widget_contacts');

		return $instance;
	}

	function flush_widget_cache() {
		wp_cache_delete('widget_contacts', 'widget');
	}

	function form( $instance ) {
		$address     = 	isset( $instance['address'] ) ? esc_attr( $instance['address'] ) : '';
		$phone  	 =	isset( $instance['phone'] ) ? esc_attr( $instance['phone'] ) : '';
		$fax   		 = 	isset( $instance['fax'] ) ? esc_attr( $instance['fax'] ) : '';
		$mail  		 = 	isset( $instance['mail'] ) ? esc_attr( $instance['mail'] ) : '';
?>
		<p>
			<label for="<?php echo $this->get_field_id( 'address' ); ?>"><?php _e( 'Cím:' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'address' ); ?>" name="<?php echo $this->get_field_name( 'address' ); ?>" type="text" value="<?php echo $address; ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'phone' ); ?>"><?php _e( 'Telefon:' ); ?></label>
			<input  class="widefat" id="<?php echo $this->get_field_id( 'phone' ); ?>" name="<?php echo $this->get_field_name( 'phone' ); ?>" type="text" value="<?php echo $phone; ?>" size="3" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'fax' ); ?>"><?php _e( 'Fax:' ); ?></label>
			<input  class="widefat" id="<?php echo $this->get_field_id( 'fax' ); ?>" name="<?php echo $this->get_field_name( 'fax' ); ?>" type="text" value="<?php echo $fax; ?>" size="3" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'mail' ); ?>"><?php _e( 'Email:' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'mail' ); ?>" name="<?php echo $this->get_field_name( 'mail' ); ?>" type="text" value="<?php echo $mail; ?>" size="3" />
		</p>
<?php
	}
}