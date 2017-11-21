<div class="wrap" id="gearhead-admin">
	<div id="icon-tools" class="icon32"><br></div>
	<h2><?php echo esc_html($this->get_page_title()); ?></h2>
	<?php if (!empty($_GET['updated'])) : ?>
		<div id="setting-error-settings_updated" class="updated settings-error notice is-dismissible">
			<p><strong><?php _e('Settings saved.') ?></strong></p>
			<button type="button" class="notice-dismiss"><span class="screen-reader-text">Dismiss this notice.</span></button>
		</div>
		<?php do_action( 'gearhead_setting_messages' ); // todo we will need to build the settings messanger as a package?>
	<?php endif; ?>
	<form action="options.php" method="POST">
		<?php settings_fields($this->get_slug()); ?>
		<?php do_settings_sections($this->get_slug()); ?>
		<?php submit_button(__('Save')); ?>
	</form>
</div>