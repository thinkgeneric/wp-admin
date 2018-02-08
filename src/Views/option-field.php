<?php

	$option_array = get_option($args['option'], '');
// todo I'd rather not get the value in the template
	$value = isset($option_array[$args['id']]) ? $option_array[$args['id']] : '';
	$id = $arg['option'] . '-' . $args['id'];
?>

<input type="text" id="<?php echo esc_attr($id); ?>" name="<?php echo esc_attr($args['slug']); ?>" value="<?php echo esc_attr($value) ?>" />