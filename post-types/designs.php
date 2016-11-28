<?php
class DekorPostType {

    /**
    * hooks
    */
    public function __construct() {
        add_action('init', array($this, 'register'));
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
        register_post_type('design', array(
		
			'labels'=> array(
				'name'               => _x( 'Dekorok', 'blackcrystal' ),
				'singular_name'      => _x( 'Dekor', 'blackcrystal' ),
				'menu_name'          => _x( 'Dekorok','blackcrystal' ),
				'name_admin_bar'     => _x( 'Dekor', 'blackcrystal' ),
				'add_new'            => _x( 'Új design', 'blackcrystal' ),
				'add_new_item'       => __( 'Új design hozzáadása', 'blackcrystal' ),
				'new_item'           => __( 'Új design', 'blackcrystal' ),
				'edit_item'          => __( 'Hírdetés szerkesztése', 'blackcrystal' ),
				'view_item'          => __( 'Hírdetés megtekintése', 'blackcrystal' ),
				'all_items'          => __( 'Összes design', 'blackcrystal' ),
				'search_items'       => __( 'Dekor keresése', 'blackcrystal' ),
				'parent_item_colon'  => __( 'Szülő design:', 'blackcrystal' ),
				'not_found'          => __( 'Nincsenek designok.', 'blackcrystal' ),
				'not_found_in_trash' => __( 'Nincsenek designok a kukában.', 'blackcrystal' )
			),
            'description' => __('Dekorok', 'blackcrystal'),
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
            'rewrite' => array('slug' => 'dekorok'),
            'can_export' => false,
            'capabilities' => array (
                'create_posts' => 'edit_posts',
                'edit_post' => 'edit_posts',
                'read_post' => 'edit_posts',
                'delete_post' => 'edit_posts',
                'edit_posts' => 'edit_posts',
                'edit_others_posts' => 'edit_posts',
                'publish_posts' => 'edit_posts',
                'read_private_posts' => 'edit_posts',
            ),             
        ));
    }
    

    
 }
$DekorPostType = new DekorPostType();




?>
