<?php
namespace Automattic_Unit\Human_Testable\Data_Sources;

require_once( dirname( __DIR__ ) . DIRECTORY_SEPARATOR . 'test_class.base-test.php' );
require_once( TESTED_LIBRARY_PATH . DIRECTORY_SEPARATOR . 'data-sources' . DIRECTORY_SEPARATOR . 'class.pdo-jetpack-data-source.php' );
require_once( TESTED_LIBRARY_PATH . DIRECTORY_SEPARATOR . 'env' . DIRECTORY_SEPARATOR . 'class.environment.php' );
require_once( TESTED_LIBRARY_PATH . DIRECTORY_SEPARATOR . 'env' . DIRECTORY_SEPARATOR . 'class.environment-set.php' );

use Automattic\Human_Testable\Env\Environment;
use Automattic\Human_Testable\Env\Environment_Set;
use Automattic\Human_Testable\Data_Sources\PDO_Jetpack_Data_Source;
use Automattic_Unit\Human_Testable\Base_Test;

class Test_PDO_Jetpack_Data_Source extends Base_Test {
	public function test_get_tests() {
		$data_source = $this->get_pdo_jetpack_data_source();
		$this->assertArrayHasKey( '1', $data_source->get_tests() );
		$this->assertArrayNotHasKey( '2', $data_source->get_tests() );
	}

	public function test_save_completed_test() {
			$data_source = $this->get_pdo_jetpack_data_source();
			$env_array = array();
			$env = $data_source->generate_environment( $env_array );
			$this->assertFalse( $data_source->get_environment_set( 101, $env_array )->match( 1 ) );
			$data_source->save_completed_test( 101, 1, $env );
			$data_source->save_completed_test( 101, 2, $env );
			$this->assertTrue( $data_source->get_environment_set( 101, $env_array )->match( 1 ) );
			$this->assertTrue( $data_source->get_environment_set( 101, $env_array )->match( 2 ) );
			$this->assertFalse( $data_source->get_environment_set( 101, $env_array )->match( 3 ) );
	}

	public function test_get_environment_set() {
		$data_source = $this->get_pdo_jetpack_data_source();
		$env_array = array( 'browser' => 'firefox', 'host' => 'dreamhost', 'wp_version' => '4.6.0', 'php_version' => '7.0.1', 'jp_version' => '4.1.1' );
		$env_set = $data_source->get_environment_set( 100, $env_array );
		$this->assertFalse( $env_set->match( 1 ) );
		$this->assertTrue( $env_set->match( 1, array( 'php_version', 'wp_version', 'jp_major_version' ) ) );

		$env_array = array( 'php_version' => '7.0.1' );
		$env_set = $data_source->get_environment_set( 100, $env_array );
		$this->assertTrue( $env_set->match( 1, array_keys( $env_array ) ) );
		$this->assertTrue( $env_set->match( 2, array_keys( $env_array ) ) );
	}

	public function test_generate_environment() {
		$data_source = $this->get_pdo_jetpack_data_source();
		$env_array = array( 'browser' => 'firefox', 'host' => 'dreamhost', 'wp_version' => '4.6.0', 'php_version' => '7.0.1', 'jp_version' => '4.1.1' );
		$env = $data_source->generate_environment( $env_array );
		$this->assertEquals( $env['browser'], $env_array['browser'] );
		$this->assertEquals( $env['host'], $env_array['host'] );
		$this->assertEquals( $env['wp_version'], $env_array['wp_version'] );
		$this->assertEquals( $env['php_version'], $env_array['php_version'] );
		$this->assertEquals( $env['jp_version'], $env_array['jp_version'] );
		$this->assertEquals( $env['jp_major_version'], 4 );
	}

	public function test_get_version_modules() {
		$data_source = $this->get_pdo_jetpack_data_source();
		$modules = $data_source->get_version_modules();
		$this->assertArrayHasKey( '4.6.0', $modules );
		$this->assertArrayHasKey( '4.5.9', $modules );
		$this->assertContains( 'carousel', $modules['4.6.0'] );
		$this->assertContains( 'comments', $modules['4.6.0'] );
		$this->assertContains( 'publicize', $modules['4.6.0'] );
		$this->assertNotContains( 'sso', $modules['4.6.0'] );
	}

	protected function get_pdo_jetpack_data_source() {
		$data_source = new PDO_Jetpack_Data_Source( 'sqlite::memory:', null, null );
		$reflection = new \ReflectionProperty( PDO_Jetpack_Data_Source::class, 'pdo' );
		$reflection->setAccessible( true );
		$pdo = $reflection->getValue( $data_source );
		$pdo->exec( "CREATE TABLE `jetpack_test_items` (
		  `jetpack_test_item_id` int(11) NOT NULL,
		  `active` tinyint(2) DEFAULT '0',
		  `date_added` timestamp DEFAULT NULL,
		  `importance` tinyint(3) DEFAULT '0',
		  `title` varchar(255) DEFAULT NULL,
		  `instructions` text,
		  `min_jp_ver` varchar(15) DEFAULT NULL,
		  `max_jp_ver` varchar(15) DEFAULT NULL,
		  `min_wp_ver` varchar(15) DEFAULT NULL,
		  `max_wp_ver` varchar(15) DEFAULT NULL,
		  `min_php_ver` varchar(15) DEFAULT NULL,
		  `max_php_ver` varchar(128) DEFAULT NULL,
		  `module` varchar(128) DEFAULT NULL,
		  `host` varchar(128) DEFAULT NULL,
		  `browser` varchar(128) DEFAULT NULL,
		  `initial_path` varchar(128) DEFAULT NULL,
		  `added_by` varchar(128) DEFAULT NULL
		);" );
		$pdo->exec( 'CREATE TABLE `jetpack_test_items_completed` (
                      `jetpack_test_item_id` int(11) NOT NULL,
                      `site_id` int(11) NOT NULL,

                      `browser` varchar(15) DEFAULT NULL,
                      `host` varchar(40) DEFAULT NULL,

                      `jp_version` varchar(15) DEFAULT NULL,
                      `wp_version` varchar(15) DEFAULT NULL,
                      `php_version` varchar(15) DEFAULT NULL,
                      
                      `date_added` datetime DEFAULT NULL
                    );'
		);
		$pdo->exec( 'CREATE TABLE `jetpack_versions` (
              `jetpack_version_id` int(11) NOT NULL,
              `version` varchar(15) NOT NULL,
              `touched_modules` text NOT NULL
            );'
		);
		$pdo->exec( "INSERT INTO `jetpack_versions` (`jetpack_version_id`, `version`, `touched_modules`) VALUES
		(1, '4.6.0', '[\"carousel\", \"comments\", \"publicize\"]'),
		(2, '4.5.9', '[\"shortcodes\", \"sso\"]');" );
		$pdo->exec( 'INSERT INTO `jetpack_test_items` (`jetpack_test_item_id`, `title`, `active`) VALUES (1, "Dogs are the best", 1)' );
		$pdo->exec( 'INSERT INTO `jetpack_test_items` (`jetpack_test_item_id`, `title`, `active`) VALUES (2, "Woops", 0)' );
		$pdo->exec( 'INSERT INTO `jetpack_test_items_completed` (`jetpack_test_item_id`, `site_id`, `browser`, `host`, `jp_version`, `wp_version`, `php_version`) VALUES (1, 100, "firefox", "bluehost", "4.1.1", "4.6.0", "7.0.1")' );
		$pdo->exec( 'INSERT INTO `jetpack_test_items_completed` (`jetpack_test_item_id`, `site_id`, `browser`, `host`, `jp_version`, `wp_version`, `php_version`) VALUES (2, 100, "firefox", "bluehost", "4.2.0", "4.6.1", "7.0.1")' );
		return $data_source;
	}
}
