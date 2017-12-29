<?php
namespace Gearhead\WPAdmin;

class PageSettings implements PageSettingsInterface {

	public function register_setting($option_group, $option_name, $args = []) {
		register_setting($option_group, $option_name, $args);
	}

	public function add_settings_section($id, $title, $callback, $page) {
		add_settings_section($id, $title, $callback, $page);
	}

	public function add_settings_field($id, $title, $callback, $page, $section = null, $args = null) {
		add_settings_field($id, $title, $callback, $page, $section, $args);
	}

	public function add_submenu_page($parent_slug, $page_title, $menu_title, $capability, $menu_slug, $function = '') {
		add_submenu_page($parent_slug, $page_title, $menu_title, $capability, $menu_slug, $function);
	}
}