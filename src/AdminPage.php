<?php

namespace Gearhead\WPAdmin\AdminPage;

class AdminPage {

	/**
	 * Path to the admin page templates.
	 * @var string
	 */
	private $template_path;

	/**
	 * AdminPage constructor.
	 *
	 * @param string $template_path
	 */
	public function __construct($template_path) {
		$this->template_path = rtrim($template_path, '/');
	}

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

	/**
	 * Configure the admin page using the Settings API
	 * register_setting($option_group, $option_name, $args)
	 */
	public function configure() {
		register_setting($this->get_slug(), 'gearhead_option');

		add_settings_section(
			$this->get_slug() . '-section',
			__('Section Title', 'gearhead'),
			[$this, 'render_section'],
			$this->get_slug()
		);

		add_settings_field(
			$this->get_slug() . '-option',
			__('The Option', 'gearhead'),
			[$this, 'render_option_field'],
			$this->get_slug(),
			$this->get_slug() . '-section'
		);
	}

	/**
	 * Render the option field
	 */
	public function render_option_field() {
		$this->render_template('option-field');
	}

	/**
	 * Render the admin page
	 */
	public function render_page() {
		$this->render_template('page');
	}

	/**
	 * Render the top section of the admin page
	 */
	public function render_section() {
		$this->render_template('section');
	}

	/**
	 * Renders the given template if it is readable.
	 * @param string $template
	 */
	private function render_template($template) {
		$template_path = "{$this->template_path}/{$template}.php";

		if (!is_readable($template_path)) {
			return;
		}

		include $template_path;
	}
}