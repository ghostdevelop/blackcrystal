<?php
class AdPostType {

    /**
    * hooks
    */
    public function __construct() {
        add_action('init', array($this, 'register'));
        add_action( 'save_post', array( $this, 'save_metabox' ) );
        //add_action('save_post', array(&$this, 'save_metabox'), 1, 2); // save the custom fields

    }

    /**
    * admin_init action
    */
    public function init() {

    }

    /**
    * register Custom Post Type
    */
    public function register() {
        // register the post type
        register_post_type('ad', array(
		
			'labels'=> array(
				'name'               => _x( 'Hírdetések', 'blackcrystal' ),
				'singular_name'      => _x( 'Hírdetés', 'blackcrystal' ),
				'menu_name'          => _x( 'Hírdetések', 'blackcrystal' ),
				'name_admin_bar'     => _x( 'Hírdetés', 'blackcrystal' ),
				'add_new'            => _x( 'Új hírdetés', 'blackcrystal' ),
				'add_new_item'       => __( 'Új hírdetés hozzáadása', 'blackcrystal' ),
				'new_item'           => __( 'Új hírdetés', 'blackcrystal' ),
				'edit_item'          => __( 'Hírdetés szerkesztése', 'blackcrystal' ),
				'view_item'          => __( 'Hírdetés megtekintése', 'blackcrystal' ),
				'all_items'          => __( 'Összes hírdetés', 'blackcrystal' ),
				'search_items'       => __( 'Hírdetés keresése', 'blackcrystal' ),
				'parent_item_colon'  => __( 'Parent hírdetés:', 'blackcrystal' ),
				'not_found'          => __( 'Nincsenek hírdetések.', 'blackcrystal' ),
				'not_found_in_trash' => __( 'Nincsenek hírdetések a kukában.', 'blackcrystal' )
			),
            'description' => __('Hirdetések', 'blackcrystal'),
            'exclude_from_search' => true,
            'publicly_queryable' => true,
            'public' => true,
            'show_ui' => true,
            'auto-draft' => false,
            'show_in_admin_bar' => true,
            'show_in_nav_menus' => true,
            'menu_position' => 4,
            'menu_icon'	=> 'dashicons-tag',
            'revisions' => false,
            'hierarchical' => true,
            'has_archive' => true,
			'supports' => array('title','editor','thumbnail'),
            'rewrite' => false,
            'can_export' => false,
            'capabilities' => array (
                'create_posts' => true,
                'edit_post' => 'manage_options',
                'read_post' => 'manage_options',
                'delete_post' => 'manage_options',
                'edit_posts' => 'manage_options',
                'edit_others_posts' => 'manage_options',
                'publish_posts' => 'manage_options',
                'read_private_posts' => 'manage_options',
            ),
            'register_meta_box_cb' => array(&$this, 'add_metabox')               
        ));
    }
    
    public function add_metabox(){
	    add_meta_box('slider_url', 'Url', array(&$this, 'metabox'), 'ad','side');
    }
    
    public function metabox($post){
	   	// Add an nonce field so we can check for it later.
		wp_nonce_field( 'url_metabox', 'url_metabox_nonce' );

		// Use get_post_meta to retrieve an existing value from the database.
		$value = get_post_meta( $post->ID, 'slider_url', true );
		
		echo '<input type="text" name="slider_url" value="'.$value.'" />';
    }
    
    public function save_metabox($post_id){
		// Check if our nonce is set.
		if ( ! isset( $_POST['url_metabox_nonce'] ) )
			return $post_id;

		$nonce = $_POST['url_metabox_nonce'];

		// Verify that the nonce is valid.
		if ( ! wp_verify_nonce( $nonce, 'url_metabox' ) )
			return $post_id;

		// If this is an autosave, our form has not been submitted,
                //     so we don't want to do anything.
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) 
			return $post_id;

		// Check the user's permissions.
		if ( 'page' == $_POST['post_type'] ) {

			if ( ! current_user_can( 'edit_page', $post_id ) )
				return $post_id;
	
		} else {

			if ( ! current_user_can( 'edit_post', $post_id ) )
				return $post_id;
		}

		/* OK, its safe for us to save the data now. */

		// Sanitize the user input.
		$mydata = sanitize_text_field( $_POST['slider_url'] );

		// Update the meta field.
		update_post_meta( $post_id, 'slider_url', $mydata );
	    
    }
    
 }
$AdPostType = new AdPostType();




?>
