<style>
	#product-select{
		display: block;
		width: 100%;
		height: 300px;
	}	
	
	#product-search{
		margin: 20px 0;
	}
</style>
<script type="text/javascript">
	jQuery(document).ready(function($){
		$('#product-search').on('keyup', function(e){
			if (e.target.value.length > 4){
				var selectedItems = $('#product-select option:selected')
				console.log(selectedItems)
				$.ajax({
				    url: "<?php echo admin_url('admin-ajax.php'); ?>",
				    dataType: 'json',	
				    data: {
				      	action: "products_select_get_products",
				        q: e.target.value, // search term
						offset: 0				        
				    },
				    success: function (response){
						var elements = jQuery.map( response, function( res ) {
						  return ("<option value='" + res.id + "'>" + res.text + "</option>");
						});				    
						
					    $('#product-select').html($.merge( elements, selectedItems))
				    }			    				
				})
			}
			console.log("e", e.target.value.length)
		});
	})
</script>
<?php  wp_nonce_field( 'product-select', 'product-select-nonce' ); ?>


<div class="form-group">
	<?php $args = array('taxonomy'  => 'product_cat', 'hierarchical' => 1, 'name' => 'product-cat-select', 'selected' => get_post_meta(get_the_ID(), 'product-cat-select', true), 'show_option_none'   => 'Válassz'); ?>
	<label><?php _e('Kategória kiválasztása', 'blackcrystal')?></label>
	<?php wp_dropdown_categories( $args );?>
</div>

<?php $products = unserialize(get_post_meta(get_the_ID(), 'product-select', true))?>

<div class="form-group">
	<label><?php _e('Termékek kiválasztása', 'blackcrystal')?></label>
	<input id="product-search" name="product-search" type="text" value="" placeholder="Termékek keresése"/>	
	<select name="product-select[]" id="product-select" multiple="multiple" >
		<?php if (!empty($products)):?>
			<?php foreach($products as $product): ?>
				<option value="<?php echo $product?>" selected><?php echo get_the_title($product) ?></option>
			<?php endforeach;?>
		<?php endif?>
	</select>
</div>