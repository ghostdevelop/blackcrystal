<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
<style>
	span.select2.select2-container.select2-container--default{
		width: 100%;
		display: block;
		margin: 20px 0 0;
	}
	
	#product-select{
		display: block;
		width: 100%;
	}	
</style>
<script type="text/javascript">
	jQuery(document).ready(function($){
		$('#product-select').select2({
		 ajax: {
		    url: "<?php echo admin_url('admin-ajax.php'); ?>",
		    dataType: 'json',
		    delay: 250,
		    data: function (params) {
		      return {
		      	action: "my_ajax",
		        q: params.term, // search term
		      };
		    },
		    processResults: function (data, params) {
		      // parse the results into the format expected by Select2
		      // since we are using custom formatting functions we do not need to
		      // alter the remote JSON data, except to indicate that infinite
		      // scrolling can be used		
		      return {
		        results: data
		      };
		    },
		    cache: true
		  },	
		  minimumInputLength: 4,		  	
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
	<select name="product-select[]" id="product-select" multiple="multiple" >
		<?php if (!empty($products)):?>
			<?php foreach($products as $product): ?>
				<option value="<?php echo $product?>" selected><?php echo get_the_title($product) ?></option>
			<?php endforeach;?>
		<?php endif?>
	</select>
</div>