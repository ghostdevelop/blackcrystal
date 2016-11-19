<?php 
	if(!class_exists('ADMIN_COLUMNS')) {

	    class ADMIN_COLUMNS {
	    
		    public function __construct(){	
				add_filter('manage_post_posts_columns', array(&$this, 'posts_columns_thumb'), 5);
				add_action('manage_posts_custom_column', array(&$this, 'posts_custom_columns'), 5, 2);			
				add_filter('manage_page_posts_columns', array(&$this, 'posts_columns_thumb'), 5);	
				add_action('manage_page_posts_custom_column', array(&$this, 'posts_custom_columns'), 5, 2);		    
		    }					
		
			public function posts_columns_thumb($defaults){
				$defaults = array();
				$defaults['cb'] = '<input type="checkbox" />';
				$defaults['thumbnail'] = __('Thumbnail');
				$defaults['title'] = _x( 'Title', 'column name' );
				$defaults['author'] = __( 'Author' );
				$defaults['comments'] = '<span class="vers"><span title="' . esc_attr__( 'Comments' ) . '" class="comment-grey-bubble"></span></span>';
				$defaults['date'] = __( 'Date' );				
				
				return $defaults;
			}
		
			public function posts_custom_columns($column_name, $id){
				if($column_name === 'thumbnail'){
					echo the_post_thumbnail( array(50, 50) );
				}
			}		
		}
	}
	
	if (class_exists('ADMIN_COLUMNS')){
		$ADMIN_COLUMNS = new ADMIN_COLUMNS();
	}
?>