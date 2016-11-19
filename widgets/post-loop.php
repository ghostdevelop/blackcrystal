<?php
/**
 * Display a loop of posts.
 *
 * Class SiteOrigin_Panels_Widgets_CustomPostLoop
 */
class WebcreativesPostLoopWidget extends WP_Widget{
	function __construct() {
		parent::__construct(
			'webcreatives-panel-custompostloop',
			__( 'Post Loop', 'webcreatives-panel' ),
			array(
				'description' => __( 'Displays a post loop.', 'webcreatives-panel' ),
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
		//If Widgets Bundle post selector is available and a posts query has been saved using it.
		if ( function_exists( 'siteorigin_widget_post_selector_process_query' ) && ! empty( $instance['posts'] ) ) {
			$query_args = siteorigin_widget_post_selector_process_query($instance['posts']);
			$instance['additional'] = $query_args['additional'];
		}
		else {
			if ( ! empty( $instance['posts'] ) ) {
				$query_args = wp_parse_args( $instance['posts'], $query_args );
			}

			switch($query_args['sticky']){
				case 'ignore' :
					$query_args['ignore_sticky_posts'] = 1;
					break;
				case 'only' :
					$query_args['post__in'] = get_option( 'sticky_posts' );
					break;
				case 'exclude' :
					$query_args['post__not_in'] = get_option( 'sticky_posts' );
					break;
			}
			unset($query_args['template']);
			unset($query_args['title']);
			unset($query_args['sticky']);
		}
		$query_args = wp_parse_args($query_args['additional'], $query_args);
		unset($query_args['additional']);

		global $wp_rewrite;

		if( $wp_rewrite->using_permalinks() ) {

			if( get_query_var('paged') ) {
				// When the widget appears on a sub page.
				$query_args['paged'] = get_query_var('paged');
			}
			elseif( strpos( $_SERVER['REQUEST_URI'], '/page/' ) !== false ) {
				// When the widget appears on the home page.
				preg_match('/\/page\/([0-9]+)\//', $_SERVER['REQUEST_URI'], $matches);
				if(!empty($matches[1])) $query_args['paged'] = intval($matches[1]);
				else $query_args['paged'] = 1;
			}
			else $query_args['paged'] = 1;
		}
		else {
			// Get current page number when we're not using permalinks
			$paged = filter_input( INPUT_GET, 'paged', FILTER_SANITIZE_NUMBER_INT );
			$query_args['paged'] = $paged !== false ? $paged : 1;
		}

		// Exclude the current post to prevent possible infinite loop

		global $siteorigin_panels_current_post;

		if( !empty($siteorigin_panels_current_post) ){
			if(!empty($query_args['post__not_in'])){
				$query_args['post__not_in'][] = $siteorigin_panels_current_post;
			}
			else {
				$query_args['post__not_in'] = array( $siteorigin_panels_current_post );
			}
		}

		if( !empty($query_args['post__in']) && !is_array($query_args['post__in']) ) {
			$query_args['post__in'] = explode(',', $query_args['post__in']);
			$query_args['post__in'] = array_map('intval', $query_args['post__in']);
		}

		echo $args['before_widget'];
		
		$query = new WP_Query($query_args);	

		$variables_to_be_created = array(
				"query" => $query,
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
		$new['more'] = !empty( $new['more'] );
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
			'slider*.php',
			'carousel*.php',
			'loop*.php',
			'*/loop*.php',
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
			'template' => 'loop.php',

			// Query args
			'post_type' => 'post',
			'posts_per_page' => '',
			'cat'	=> '',

			'order' => 'DESC',
			'orderby' => 'date',

			'sticky' => '',

			'additional' => '',
			'more' => false,
			'show_num' => ""
		));

		$templates = $this->get_loop_templates();
		if( empty($templates) ) {
			?><p><?php _e("Your theme doesn't have any post loops.", 'webcreatives-panel') ?></p><?php
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
		<div class="field_holder">
			<label for="<?php echo $this->get_field_id( 'title' ) ?>"><?php _e( 'Title', 'webcreatives-panel' ) ?></label>
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
			<div class="query_settings_holder">
				<h3>Query Settings</h3>
				<div class="field_holder">
					<label for="<?php echo $this->get_field_id('template') ?>"><?php _e('Template', 'webcreatives-panel') ?></label>
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
						<label for="<?php echo $this->get_field_id('post_type') ?>"><?php _e('Post Type', 'webcreatives-panel') ?></label>
						<?php dropdown_post_types($this->get_field_name( 'post_type' ), $instance['post_type']) ?>
				
				</div>
				
				<div class="field_holder">
					<label for="<?php echo $this->get_field_id('cat') ?>"><?php _e('Category', 'webcreatives-panel') ?></label>
					<?php wp_dropdown_categories( array('taxonomy' => 'category', 'name' => $this->get_field_name('cat'), 'id' => $this->get_field_id('cat'), 'selected' => $instance['cat'], 'show_option_none'   => 'Válassz', 'option_none_value'  => 0,) ); ?>
				</div>					
	
				<div class="field_holder">
					<label for="<?php echo $this->get_field_id('posts_per_page') ?>"><?php _e('Elemek száma', 'webcreatives-panel') ?></label>
					<input type="text" class="small-text" id="<?php echo $this->get_field_id( 'posts_per_page' ) ?>" name="<?php echo $this->get_field_name( 'posts_per_page' ) ?>" value="<?php echo esc_attr($instance['posts_per_page']) ?>" />
				</div>
				
				<div class="field_holder">
					<label for="<?php echo $this->get_field_id('show_num') ?>"><?php _e('Ennyit jelenítsen meg', 'webcreatives-panel') ?></label>
					<input type="text" class="small-text" id="<?php echo $this->get_field_id( 'show_num' ) ?>" name="<?php echo $this->get_field_name( 'show_num' ) ?>" value="<?php echo $instance['show_num'] ?>" />
				</div>				
	
				<div class="field_holder">
					<label <?php echo $this->get_field_id('orderby') ?>><?php _e('Order By', 'webcreatives-panel') ?></label>
					<select id="<?php echo $this->get_field_id( 'orderby' ) ?>" name="<?php echo $this->get_field_name( 'orderby' ) ?>" value="<?php echo esc_attr($instance['orderby']) ?>">
						<option value="none" <?php selected($instance['orderby'], 'none') ?>><?php esc_html_e('None', 'webcreatives-panel') ?></option>
						<option value="ID" <?php selected($instance['orderby'], 'ID') ?>><?php esc_html_e('Post ID', 'webcreatives-panel') ?></option>
						<option value="author" <?php selected($instance['orderby'], 'author') ?>><?php esc_html_e('Author', 'webcreatives-panel') ?></option>
						<option value="name" <?php selected($instance['orderby'], 'name') ?>><?php esc_html_e('Name', 'webcreatives-panel') ?></option>
						<option value="date" <?php selected($instance['orderby'], 'date') ?>><?php esc_html_e('Date', 'webcreatives-panel') ?></option>
						<option value="modified" <?php selected($instance['orderby'], 'modified') ?>><?php esc_html_e('Modified', 'webcreatives-panel') ?></option>
						<option value="parent" <?php selected($instance['orderby'], 'parent') ?>><?php esc_html_e('Parent', 'webcreatives-panel') ?></option>
						<option value="rand" <?php selected($instance['orderby'], 'rand') ?>><?php esc_html_e('Random', 'webcreatives-panel') ?></option>
						<option value="comment_count" <?php selected($instance['orderby'], 'comment_count') ?>><?php esc_html_e('Comment Count', 'webcreatives-panel') ?></option>
						<option value="menu_order" <?php selected($instance['orderby'], 'menu_order') ?>><?php esc_html_e('Menu Order', 'webcreatives-panel') ?></option>
						<option value="post__in" <?php selected($instance['orderby'], 'post__in') ?>><?php esc_html_e('Post In Order', 'webcreatives-panel') ?></option>
					</select>
				</div>
	
				<div class="field_holder">
					<label for="<?php echo $this->get_field_id('order') ?>"><?php _e('Order', 'webcreatives-panel') ?></label>
					<select id="<?php echo $this->get_field_id( 'order' ) ?>" name="<?php echo $this->get_field_name( 'order' ) ?>" value="<?php echo esc_attr($instance['order']) ?>">
						<option value="DESC" <?php selected($instance['order'], 'DESC') ?>><?php esc_html_e('Descending', 'webcreatives-panel') ?></option>
						<option value="ASC" <?php selected($instance['order'], 'ASC') ?>><?php esc_html_e('Ascending', 'webcreatives-panel') ?></option>
					</select>
				</div>
				<div class="field_holder">
					<label for="<?php echo $this->get_field_id('sticky') ?>"><?php _e('Sticky Posts', 'webcreatives-panel') ?></label>
					<select id="<?php echo $this->get_field_id( 'sticky' ) ?>" name="<?php echo $this->get_field_name( 'sticky' ) ?>" value="<?php echo esc_attr($instance['sticky']) ?>">
						<option value="" <?php selected($instance['sticky'], '') ?>><?php esc_html_e('Default', 'webcreatives-panel') ?></option>
						<option value="ignore" <?php selected($instance['sticky'], 'ignore') ?>><?php esc_html_e('Ignore Sticky', 'webcreatives-panel') ?></option>
						<option value="exclude" <?php selected($instance['sticky'], 'exclude') ?>><?php esc_html_e('Exclude Sticky', 'webcreatives-panel') ?></option>
						<option value="only" <?php selected($instance['sticky'], 'only') ?>><?php esc_html_e('Only Sticky', 'webcreatives-panel') ?></option>
					</select>
				</div>
<!--	
				<div class="field_holder">
					<label for="<?php echo $this->get_field_id('additional') ?>"><?php _e('Additional ', 'webcreatives-panel') ?></label>
					<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'additional' ) ?>" name="<?php echo $this->get_field_name( 'additional' ) ?>" value="<?php echo esc_attr($instance['additional']) ?>" />
					<small>
						<?php
						echo preg_replace(
							'/1\{ *(.*?) *\}/',
							'<a href="http://codex.wordpress.org/Function_Reference/query_posts">$1</a>',
							__('Additional query arguments. See 1{query_posts}.', 'webcreatives-panel')
						)
						?>
					</small>
				</div>
-->	
			</div>
			<br clear="all">
			<div class="featured_posts holder">
				<h3>Featured Post Settings</h3>
				<div class="field_holder">
					<label for="<?php echo $this->get_field_id('featured_post') ?>"><?php _e('Featured Post', 'webcreatives-panel') ?></label>
					<input type="text" class="autocomplete" name="<?php echo $this->get_field_name( 'featured_post' ) ?>" id="<?php echo $this->get_field_id( 'featured_post' ) ?>" data-action="custom_post_loop_autocomplete" placeholder="<?php echo get_the_title($instance['featured_post_id']) ?>" />
					<input type="hidden"  class="hiddenvalue"  name="<?php echo $this->get_field_name( 'featured_post_id' ) ?>" id="<?php echo $this->get_field_id( 'featured_post_id' ) ?>" value="<?php echo (int) $instance['featured_post_id'] ?>" />
				</div>			
			</div>
			<?php
	}
}
