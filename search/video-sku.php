<?php	$full = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full' ); ?>
<?php if (has_post_thumbnail()):?>
    <a class="prod-img" href="<?=$full[0]?>">
		<?php the_post_thumbnail(array(250, 250))?>
    </a>		
<?php endif;?>	        
<?php if ($video = get_post_meta(get_the_ID(), '_video_id', true)):?>
	<div class="right_holder">
		<h2 class="title"><a href="<?php the_permalink()?>"><?php the_title()?></a></h2>
	    <div class="entry-content">
	        <?php the_excerpt() ?>
	        <a href="<?php echo get_post_meta(get_the_ID(), "_url", true) ?>" class="read-more"><?php _e("Termék megtekintése", theme_textdomain())?></a>
	    </div><!-- .entry-content -->
	    <br clear="all">				            	
	</div>               	            
	<iframe class="video-frame" src="http://www.youtube.com/embed/<?=$video?>?autoplay=1"></iframe> 
<?php else:?>	
	<div class="search-box">
		<h2 class="title"><a href="<?php the_permalink()?>"><?php the_title()?></a></h2>
		<p><?php _e('A keresett termékhez még nem tartozik video, vagy átmenetileg nem elérhető.', theme_textdomain()) ?></p>	
		<p><?php _e('Kérjük kattintson és próbáljon meg dekor alapján keresni.', theme_textdomain()) ?></p>	
		<form role="search" method="get" class="search-form video-search" action="<?php echo home_url( '/' ); ?>">
		    <label>
		        <input type="search" class="search-field" placeholder="<?php echo esc_attr_x( 'Search' ) ?>" value="<?php echo get_post_meta(get_the_ID(), '_design', true)?>" name="s" title="<?php echo esc_attr_x( 'Search for:', 'label' ) ?>" />
				<input type="hidden" name="video-search" value="1" />
		    </label>
				    <input type="submit" class="search-submit" name="dek" value="<?php echo esc_attr_x( 'Keresés dekor alapján', 'submit button' ) ?>" />
		</form>	  
	</div>	            
<?php endif;?>	