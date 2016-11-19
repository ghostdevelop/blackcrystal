<?php 
	if(!class_exists('ADMIN_MENU')) {

	    class ADMIN_MENU {
	    
		    public function __construct(){	
			    add_action( 'admin_menu', array(&$this, 'remove_menus' ));	
			    add_action( 'admin_menu', array(&$this, 'menu_labels' ));	
			    add_action( 'init', array(&$this, 'change_post_object_label' ));
		    }	
		    				
			function remove_menus(){
				if(get_current_user_id() != 1){	  
					  //remove_menu_page( 'index.php' );                  	//Dashboard
					  //remove_menu_page( 'edit.php' );                   	//Posts
					  remove_menu_page( 'upload.php' );                	 	//Media
					  //remove_menu_page( 'edit.php?post_type=page' );    	//Pages
					  remove_menu_page( 'edit-comments.php' );          	//Comments
					  //remove_menu_page( 'themes.php' );                 	//Appearance
					  //remove_menu_page( 'plugins.php' );                	//Plugins
					  //remove_menu_page( 'users.php' );                  	//Users
					  remove_menu_page( 'tools.php' );                  	//Tools
					  remove_menu_page( 'profile.php' );                  	//Tools
					  remove_menu_page( 'options-general.php' );        	//Settings
					  remove_submenu_page( 'themes.php', 'themes.php' );
				}
			}	
			
			function menu_labels() {
			    global $menu;
			    global $submenu;
			    $menu[5][0] = 'Hírek';
			    $submenu['edit.php'][5][0] = 'Hírek';
			    $submenu['edit.php'][10][0] = 'Új hír';
			    echo '';
			    
			    //Woocommerce 
			    $menu[55.5][0] = 'Webshop';
			    //Loco Translate 
			    $menu[101][0] = 'Fordítások';
			    $menu[112][0] = 'Import';
			}	
			
			function change_post_object_label() {
			        global $wp_post_types;
			        $labels = &$wp_post_types['post']->labels;
			        $labels->name = 'Hírek';
			        $labels->singular_name = 'Hír';
			        $labels->add_new = 'Új hír';
			        $labels->add_new_item = 'Új hír';
			        $labels->edit_item = 'Hír szerkesztése';
			        $labels->new_item = 'Hír';
			        $labels->view_item = 'Hír megtekintése';
			        $labels->search_items = 'Hír keresése';
			        $labels->not_found = 'Nem található hír';
			        $labels->not_found_in_trash = 'Nem található hír a kukában';
			}	
								
		}
	}
	
	if (class_exists('ADMIN_MENU')){
		$ADMIN_MENU = new ADMIN_MENU();
	}
?>