<?php	$full = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full' ); ?>
<?php	$video = get_post_meta(get_the_ID(), '_video_id', true); ?>
<div class="right_holder">
	<h2 class="title"><a href="<?php the_permalink() ?>"><?php the_title()?></a></h2>
	<?php if (has_post_thumbnail()):?>
	    <a class="prod-img" href="<?=$full[0]?>">
			<?php the_post_thumbnail(array(250, 250))?>
	    </a>		
	<?php endif;?>	             
	<div class="entry-content">
	    <?php the_excerpt() ?>
	    <a href="<?php the_permalink()?>" class="read-more"><?php _e("Termék megtekintése", theme_textdomain())?></a>
	</div><!-- .entry-content -->	
	<br clear="all">		
</div>	            	
<iframe class="video-frame" src="http://www.youtube.com/embed/<?=$video?>"></iframe>                	            
