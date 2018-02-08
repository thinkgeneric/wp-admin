<?php
/**
 * todo
 * - move as much of this logic out of the template
 * - if we have the image set, then lets add the .hidden selector to the submit button, and display the image on page load
 */
	$option_array = get_option($args['option'], '');
	$value = isset($option_array[$args['id']]) ? $option_array[$args['id']] : '';
	$id = $args['option'] . '-' . $args['id'];

	$src = $value ? wp_get_attachment_url($value) : '';


?>
<div class="gearhead-file-uploader" data-preview_size="thumbnail" data-library="all" data-mime_types data-uploader="wp">
	<input id="<?php echo esc_attr($id); ?>" name="<?php echo esc_attr($args['slug']); ?>" value="<?php echo esc_attr($value) ?>" type="hidden">
	<div class="hidden image-wrap">
		<img data-name="image" src="<?php echo esc_url($src); ?>" alt="">
		<div class="gearhead-actions hover-actions">
			<a href="#" data-name="edit" title="Edit"></a>
			<a href="#" data-name="remove" title="Remove"><span class="dashicons dashicons-no-alt"></span></a>
		</div>
	</div>

	<div class="gearhead-file-uploader-button">
		<p>No Image Selected <a href="#" data-name="add" class="button" data-key="<?php echo esc_attr($id); ?>">Add Image</a></p>
	</div>
</div>