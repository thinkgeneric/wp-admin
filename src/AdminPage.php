<?php

namespace Gearhead\WPAdmin;

abstract class AdminPage {

	/**
	 * Fields to be rendered on the page
	 * @var array
	 */
	protected $fields = [];

	protected $page_settings;

	use PageSettingsTrait;

	/**
	 * AdminPage constructor.
	 *
	 * @param PageSettingsInterface $page_settings
	 * @param string $template_path
	 */
	public function __construct(PageSettingsInterface $page_settings, $template_path = null) {
		if ( ! $template_path) {
			$package_path  = dirname(__FILE__);
			$template_path = "{$package_path}/Views";
		}
		$this->template_path = rtrim($template_path, '/');

		$this->page_settings = $page_settings;
	}

	/**
	 * Configure the admin page using the Settings API
	 * register_setting($option_group, $option_name, $args)
	 */
	public function configure() {
		$this->page_settings->register_setting($this->get_page_name(), $this->get_option_name());

		add_action('admin_enqueue_scripts', [$this, 'enqueue_scripts']);

		$this->page_settings->add_settings_section(
			$this->get_page_name() . '-section',
			'Section Title',
			[$this, 'render_section'],
			$this->get_page_name()
		);

		// todo does this need to be a foreach loop?
		foreach ($this->fields as $field) {
			$type     = $field['type'];
			$callback = "render_option_field";
			// if we have a callback for the method, use that
			if (method_exists($this, "render_option_field_{$type}")) {
				$callback = "render_option_field_{$type}";
			}

			$this->page_settings->add_settings_field(
				$field['slug'],
				$field['title'],
				[$this, $callback],
				$this->get_page_name(),
				"{$this->get_page_name()}-{$field['section']}",
				["option" => $this->get_option_name(), "title" => $field['title'], "slug" => $field['slug'], 'id' => $field['id']]
			);
		}
	}

	public function add_group() {

	}

	/**
	 * Add a new field to the page stack
	 *
	 * @param string $name The name of the field
	 * @param null|string $slug
	 * @param string $section The key of the section the field should be added to
	 * @param string $type The type of field being used
	 *
	 * @internal param null|string $key The key used to find the field
	 */
	public function add_field($title, $id, $option = null, $section = 'section', $type = 'text') {
		// If no name is set, bail
		if (empty($title)) {
			return;
		}

		if (!$option) {
			$option = $this->option_name();
		}

		// Add the field to the stack
		$this->fields[] = [
			'title'    => $title,
			'id' => $id,
			'slug' => "{$option}[{$id}]",
			'option' => $option,
			'section' => $section,
			'type'    => $type,
		];
	}

	/**
	 * Render the option field
	 */
	public function render_option_field($args) {
		$this->render_template('option-field', $args);
	}

	public function render_option_field_file($args) {
		$this->render_template('option-file', $args);
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
	 *
	 * @param string $template
	 */
	private function render_template($template, $args = []) {
		$template_path = "{$this->template_path}/{$template}.php";

		if ( ! is_readable($template_path)) {
			return;
		}

		include $template_path;
	}

	public function register() {
		$this->page_settings->add_submenu_page(
			$this->get_parent_slug(),
			$this->get_page_title(),
			$this->get_menu_title(),
			$this->get_capability(),
			$this->get_slug(),
			[$this, 'render_page']
		);
	}

	public function enqueue_scripts($hook) {
		// Load only on ?page=slug
		if ($hook != "settings_page_{$this->get_slug()}") {
			return;
		}
		$path = dirname(dirname(__FILE__));
		$file = $path . '/Assets/gearhead.css';
		wp_enqueue_style($this->get_slug() . '-css', $file);

		// todo this can be refactored, especially once we move to grunt to compile assets
		wp_enqueue_media(); //todo these assets probably only need to be enqueued when rendering specific fields
		wp_enqueue_script($this->get_slug() . 'js', $path . '/Assets/js/admin.js', ['jquery']);
	}
}