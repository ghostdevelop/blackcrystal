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
				'name'               => _x( 'Dekorok', 'theme-phrases' ),
				'singular_name'      => _x( 'Dekor', 'theme-phrases' ),
				'menu_name'          => _x( 'Dekorok','theme-phrases' ),
				'name_admin_bar'     => _x( 'Dekor', 'theme-phrases' ),
				'add_new'            => _x( 'Új design', 'theme-phrases' ),
				'add_new_item'       => __( 'Új design hozzáadása', 'theme-phrases' ),
				'new_item'           => __( 'Új design', 'theme-phrases' ),
				'edit_item'          => __( 'Hírdetés szerkesztése', 'theme-phrases' ),
				'view_item'          => __( 'Hírdetés megtekintése', 'theme-phrases' ),
				'all_items'          => __( 'Összes design', 'theme-phrases' ),
				'search_items'       => __( 'Dekor keresése', 'theme-phrases' ),
				'parent_item_colon'  => __( 'Szülő design:', 'theme-phrases' ),
				'not_found'          => __( 'Nincsenek designok.', 'theme-phrases' ),
				'not_found_in_trash' => __( 'Nincsenek designok a kukában.', 'theme-phrases' )
			),
            'description' => __('Dekorok', 'theme-phrases'),
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
