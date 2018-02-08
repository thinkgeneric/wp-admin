<?php

namespace Gearhead\WpAdmin\Tests;

use Gearhead\WPAdmin\PageSettingsInterface;
use PHPUnit\Framework\TestCase;
use Symfony\Component\VarDumper\Test\VarDumperTestTrait;


class TestAdminPage extends TestCase {

	use VarDumperTestTrait;

	public function testAddField() {
		// Stub out classes and methods
		$settings = $this->createMock(PageSettingsInterface::class);
		$settings->method('register_setting')
				->willReturn(true);
		$settings->method('add_settings_section')
		         ->willReturn(true);
		$settings->method('add_settings_field')
		         ->willReturn(true);
		$stub = $this->getMockForAbstractClass('Gearhead\\WPAdmin\\AdminPage', [$settings]);

		// Add field
		$stub->add_field('The Option', 'the-slug-1', 'section', 'text');
		$stub->add_field('The Image', 'the-slug-2', 'section', 'image');

		$stub->page_settings->add_settings_field();
		// Verify in some way.
		dump($stub);
	}
}