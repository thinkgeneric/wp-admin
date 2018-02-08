<?php

namespace Gearhead\WPAdmin;

trait PageSettingsTrait {
	/**
	 * Path to the admin page templates.
	 * // todo this should default to the package's views first but be over written by the extending class
	 * @var string
	 */
	private $template_path;

	/**
	 * Get the capability required to view the admin page
	 * @return string
	 */
	public function get_capability() {
		return "install_plugins";
	}

	/**
	 * Get the title of the admin page in the WordPress admin menu
	 * @return string
	 */
	public function get_menu_title() {
		return "Gearhead";
	}

	/**
	 * Get the title of the admin page
	 * @return string
	 */
	public function get_page_title() {
		return "Gearhead Admin Page";
	}

	/**
	 * Get the parent slug of the admin page
	 * @return string
	 */
	public function get_parent_slug() {
		return "options-general.php";
	}

	/**
	 * Get the slug used by the admin page
	 * @return string
	 */
	public function get_slug() {
		return "gearhead-admin-menu";
	}

	public function get_page_name() {
		return $this->get_slug();
	}

	/**
	 * Get the slug for the dashicon
	 * @return string
	 */
	public function get_dashicon() {
		return 'dashicons-schedule';
	}

	/**
	 * Determine if parent page
	 * @return bool
	 */
	public function is_parent() {
		return true;
	}

	/**
	 * The option namespace
	 */
	public function get_option_name() {
		return 'gearhead';
	}
}