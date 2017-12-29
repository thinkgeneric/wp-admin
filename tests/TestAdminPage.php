<?php

namespace Gearhead\WpAdmin\Tests;

use Gearhead\WPAdmin\PageSettingsInterface;
use PHPUnit\Framework\TestCase;
use Symfony\Component\VarDumper\Test\VarDumperTestTrait;


class TestAdminPage extends TestCase {

	use VarDumperTestTrait;

	public function test_add_field() {
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
		$stub->add_field('The Option', 'the-slug', 'section', 'text');
		$stub->configure();
		// Verify in some way.
		dump($stub);
	}
}