<?php

namespace Gearhead\WPAdmin;

abstract class AdminPage {

	/**
	 * Fields to be rendered on the page
	 * @var array
	 */
	protected $fields = [];

	use PageSettingsTrait;

	/**
	 * AdminPage constructor.
	 *
	 * @param string $template_path
	 */
	public function __construct($template_path = null) {
		if (!$template_path) {
			$package_path = dirname(__FILE__);
			$template_path = "{$package_path}/Views";
		}
		$this->template_path = rtrim($template_path, '/');
	}

	/**
	 * Configure the admin page using the Settings API
	 * register_setting($option_group, $option_name, $args)
	 */
	public function configure() {
		register_setting($this->get_slug(), 'gearhead_option');
		// add_setting_section($id, $title, $callback, $page)
		add_settings_section(
			$this->get_slug() . '-section',
			__('Section Title', 'gearhead'),
			[$this, 'render_section'],
			$this->get_slug()
		);

		// todo does this need to be a foreach loop?
		foreach ($this->fields as $field) {
			$type = $field['type'];
			$callback = "render_option_field";
			// if we have a callback for the method, use that
			if (method_exists($this, "render_option_field_{$type}")) {
				$callback = "render_option_field_{$type}";
			}

			add_settings_field(
				"{$this->get_slug()}-{$field['slug']}",
				__($field['name'], 'gearhead'), // todo we should add the namespace as a property to this class that can be extended
				[$this, $callback],
				$this->get_slug(),
				"{$this->get_slug()}-{$field['section']}"
			);
		}
	}

	/**
	 * Add a new field to the page stack
	 *
	 * @param string $name The name of the field
	 * @param null|string $key The key used to find the field
	 * @param string $section The key of the section the field should be added to
	 * @param string $type The type of field being used
	 */
	protected function add_field($name, $slug = null, $section = 'section', $type = 'text') {
		// If no name is set, bail
		if (empty($name)) {
			return;
		}

		// If no key is set, format the name to be the key.
		if (!$slug) {
			$slug = str_replace('', '-', strtolower($name));
		}

		// Add the field to the stack
		$this->fields[] = [
			'name' => $name,
			'slug' => $slug,
			'section' => $section,
			'type' => $type,
		];
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

	public function register() {
		add_submenu_page(
			$this->get_parent_slug(),
			$this->get_page_title(),
			$this->get_menu_title(),
			$this->get_capability(),
			$this->get_slug(),
			[$this, 'render_page']
		);
	}
}