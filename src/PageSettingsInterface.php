<?php

namespace Gearhead\WPAdmin;

interface PageSettingsInterface {

	public function register_setting($option_group, $option_name, $args = []);

	public function add_settings_section($id, $title, $callback, $page);

	public function add_settings_field($id, $title, $callback, $page, $section = null, $args = null);

	public function add_submenu_page($parent_slug, $page_title, $menu_title, $capability, $menu_slug, $function = '');
}