<form role="search" method="get" id="search_mini_form" class="search-form" action="<?php echo home_url( '/' ); ?>">
	<div class="form-search">
	    <label for="search"><?php echo _x( 'Search for:', 'label' ) ?></label>
	        <input type="search" class="input-text"
	            placeholder=""
	            value="<?php echo get_search_query() ?>" name="s"
	            title="<?php echo esc_attr_x( 'Search for:', 'label' ) ?>" />
	    <button type="submit" class="button"><span><span><?php echo esc_attr_x( 'Search', 'submit button' ) ?></span></span></button>
	    <div id="search_autocomplete" class="search-autocomplete"></div>
	</div>
</form>